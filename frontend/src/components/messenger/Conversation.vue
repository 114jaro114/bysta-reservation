<template lang="html">
  <div class="conversation">
    <v-row justify="center" class="ml-0 mr-0">
      <v-col class="pl-0 pr-0">
        <v-card elevation="0" v-if="contact.id != null" :typingStatusNew="typingStatusNew" class="pb-5">
          <!-- v-show="showChat" -->
          <div class="top-bar">
            <!-- <div class="avatar"><p>CB</p></div> -->
            <div class="row m-0">
              <div class="name" v-if="contact.status == 'online'">
                <v-icon color="success mr-1">mdi-account</v-icon>
                <span class="accent--text"> {{ contact.name }}</span>
              </div>
              <div class="name" v-else>
                <v-icon color="error mr-1">mdi-account</v-icon>
                <span class="accent--text"> {{ contact.name }}</span>
              </div>
              <div class="icons">
                <v-btn icon>
                  <v-icon>mdi-phone</v-icon>
                </v-btn>

                <v-btn icon>
                  <v-icon>mdi-video</v-icon>
                </v-btn>

                <v-btn icon>
                  <v-icon>mdi-dots-vertical</v-icon>
                </v-btn>

                <v-btn icon @click="removeSelectedContact">
                  <v-icon>mdi-close</v-icon>
                </v-btn>
                <!-- <i class="fas fa-phone"></i>
                <i class="fas fa-video"></i>
                <i class="fas fa-ellipsis-v"></i>
                <i class="fas fa-times" style="font-size: 15px" @click="removeSelectedContact"></i> -->
              </div>
            </div>
          </div>

          <v-divider class="mt-0"/>

          <div class="card-body pt-3 pb-3 pl-0 pr-0">
            <!-- <span>{{ contact ? contact.name: 'Select a Contact' }}</span> -->
            <MessagesFeed :typingStatus="typingStatus" :contact="contact" :messages="messages" />
          </div>

          <v-divider />

          <div class="bottom-bar">
            <MessageComposer @send="sendMessage" />
          </div>
        </v-card>

        <v-card elevation="0" v-else>
          <v-card-title class="justify-center">
            <span class="primary--text">
              <v-icon style="font-size: 50px" class="mr-1" color="primary">mdi-account-cancel</v-icon>
              <span>Nie je vybratý priateľ</span>
            </span>
          </v-card-title>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import MessagesFeed from './MessagesFeed.vue';
import MessageComposer from './MessageComposer.vue';
import axios from 'axios';
export default {
  components: {
    MessagesFeed,
    MessageComposer
  },

  props: {
    contact: {
      type: Object,
      default: null
    },
    messages: {
      type: Array,
      default: () => []
    },
    typingStatusNew: Boolean,
  },

  data() {
    return {
      typingStatus: false,
      contactIdExist: null,
    }
  },

  updated() {
    this.typingStatus = this.typingStatusNew;
  },

  created() {
    //do something after creating vue instance
  },

  methods: {
    sendMessage(text) {
      if (!this.contact) {
        return;
      }

      const api = 'http://127.0.0.1:8000/api/conversation/send';
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };

      axios.post(api, {
            contact_id: this.contact.id,
            text: text
          },
          config
        )
        .then((res) => {
          console.log("res")
          this.$emit('new', res.data);
        })
      console.log(text);
    },

    removeSelectedContact() {
      // console.log("hmm");
      // this.$emit('selected', this.contact);
      this.$store.dispatch('selectedUser', {
        id: null,
        name: null,
        email: null,
        status: null,
        avatar: null,
        created_at: null,
        unread: null,
      });
    }
  }
}
</script>

<style lang="scss" scoped>
// .status {
//     width: 8px;
//     height: 8px;
//     border-radius: 50%;
//     // display: inline-block;
//     margin-right: 7px;
// }
//
// .online {
//     background-color: #58b666;
// }
//
// .offline {
//     background-color: #ff725d;
// }
.v-window__container {
    padding-bottom: 480px !important;
}
</style>
