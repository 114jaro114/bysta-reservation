<template lang="html">
  <div class="chat-app w-100 h-100 mt-1">
    <v-row justify="center" class="ml-0 mr-0">
      <v-col>
        <v-lazy :options="{
                  threshold: .4
                }" transition="scale-transition">
          <v-card elevation="2">
            <v-card-title>
              <v-row v-if="this.$store.getters['selectedUser'].id != null">
                <v-col>
                  <v-btn class="w-100" color="primary" disabled>
                    <v-icon class="mr-1">mdi-facebook-messenger</v-icon>Chat
                  </v-btn>
                </v-col>
                <v-col>
                  <v-btn class="w-100" outlined color="primary" @click="friend_list()">
                    <v-icon class="mr-1">mdi-account-group</v-icon>
                    Zoznam priateľov
                    <!-- <v-icon class="ml-1">mdi-arrow-right-thick</v-icon> -->
                  </v-btn>
                </v-col>
              </v-row>
              <v-row v-else>
                <v-col>
                  <v-btn class="w-100" color="primary" @click="chat()">
                    <!-- <v-icon class="mr-1">mdi-arrow-left-thick</v-icon> -->
                    <v-icon class="mr-1">mdi-facebook-messenger</v-icon>
                    Chat
                  </v-btn>
                </v-col>
                <v-col>
                  <v-btn class="w-100" outlined color="primary" disabled>
                    <v-icon class="mr-1">mdi-account-group</v-icon>Zoznam priateľov
                  </v-btn>
                </v-col>
              </v-row>
            </v-card-title>

            <v-divider class="mb-0" />

            <v-card-text>
              <div v-if="this.$store.getters['selectedUser'].id != null">
                <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage"/>
                <!--  -->
              </div>
              <div v-else>
                <ContactsList :contacts="contacts" @selected="startConversationWith"/>
              </div>
              <div v-if="autoselectMenu">
                <picker :showSearch="false" :showPreview="false" :set="'messenger'" :showSkinTones="true" :emojiTooltip="true" :infiniteScroll="false" @select="selectEmoji" :i18n="i18n" />
              </div>
            </v-card-text>

            <!-- <v-divider /> -->

            <!-- <v-card-actions class="pt-0">
              <div v-if="userChoosed == true">
                <v-btn color="primary" :loading="loading">
                  <v-icon left dark>mdi-check</v-icon>
                  Uložiť zmeny
                </v-btn>
              </div>
              <div v-else>
                <v-btn color="primary" :loading="loading">
                  <v-icon left dark>mdi-update</v-icon>
                  Aktualizovať kontaktné údaje
                </v-btn>
              </div>

            </v-card-actions> -->
          </v-card>
        </v-lazy>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import Conversation from './Conversation.vue';
import ContactsList from './ContactsList.vue';
import axios from 'axios';
import {
  Picker
} from 'emoji-mart-vue'

export default {
  components: {
    Conversation,
    ContactsList,
    Picker
  },

  data() {
    return {
      selectedContact: null,
      messages: [],
      contacts: [],
      users: [],
      // userChoosed: false,
      autoselectMenu: false,
    }
  },

  mounted() {
    const api = 'http://127.0.0.1:8000/api/contacts';
    const config = {
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("authToken"),
      },
    };
    axios.get(api, config)
      .then(res => {
        this.contacts = res.data;
        this.users = res.data
        this.$store.dispatch('contactListLoader', {
          cancelLoader: false
        });
      });
    //reset choodes user while come back to the messenger page
    this.$store.dispatch('selectedUser', {
      id: null,
      name: null,
      email: null,
      status: null,
      avatar: null,
      created_at: null,
      unread: null,
    });
  },

  created() {
    //presence channel
    window.Echo.join('messages.' + localStorage.getItem("user_id"))
      .listen('NewMessage', (e) => {
        console.log(e);
        console.log(e.message.to);
        console.log(localStorage.getItem("user_id"));
        console.log("hm");
        this.handleIncoming(e.message);
        if (e.message.to == localStorage.getItem("user_id")) {
          console.log("fasa");
          this.$store.dispatch('msgUnreadCounter', {
            unreadCounter: e.message.totalUnreadMsgTo
          });
        }
      })

    this.selectedContact = this.$store.getters['selectedUser'];
    console.log(this.$store.getters['selectedUser']);
    //private channel
    // window.Echo.private(`messages.${localStorage.getItem("user_id")}`)
    //   .listen('NewMessage', (e) => {
    //     this.handleIncoming(e.message);
    //   })
  },

  methods: {
    // friend_list() {
    //   this.userChoosed = false;
    // },
    //
    // chat() {
    //   this.userChoosed = true;
    // },

    startConversationWith(contact) {
      this.updateUnreadCount(contact, true);

      const api = `http://127.0.0.1:8000/api/conversation/${contact.id}`;
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };
      axios.get(api, config)
        .then(res => {
          this.messages = res.data;
          this.selectedContact = contact;
          //unread messages
          const api = 'http://127.0.0.1:8000/api/getAllUnreadMessages';
          axios.get(api, config)
            .then((res) => {
              this.$store.dispatch('msgUnreadCounter', {
                unreadCounter: res.data
              });
            });
        });
    },
    saveNewMessage(message) {
      this.messages.push(message);
    },

    handleIncoming(message) {
      if (this.selectedContact && message.from == this.selectedContact.id) {
        this.saveNewMessage(message);
        return;
      }

      this.updateUnreadCount(message.from_contact, false);
    },

    fetchMessages() {
      if (this.selectedContact != null) {
        const api = `http://127.0.0.1:8000/api/conversation/${this.selectedContact.id}`;
        const config = {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.getItem("authToken"),
          },
        };
        axios.get(api, config)
          .then(res => {
            this.messages = res.data;
          });
      }
    },

    updateUnreadCount(contact, reset) {
      this.contacts = this.contacts.map((single) => {
        if (single.id !== contact.id) {
          return single;
        }

        if (reset)
          single.unread = 0;
        else
          single.unread += 1;
        return single;
      })
    },

    // sendTypingEvent() {
    //   window.Echo.join('pchat')
    //     .whisper('typing', this.user);
    // },
  },

  updated() {
    //do something after updating vue instance
    // console.log(this.$store.getters['selectedUser']);
    this.selectedContact = this.$store.getters['selectedUser'];
  }
}
</script>

<style lang="scss" scoped>
.chat-app {
    display: flex;
    width: 100%;
    height: 100%;
}
.v-window .v-item-group .v-window__container {
    padding-bottom: 380px !important;
}
</style>
