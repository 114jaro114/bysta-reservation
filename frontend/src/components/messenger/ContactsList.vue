<template lang="html">
  <div class="contacts-list">
    <v-row justify="center" class="ml-0 mr-0">
      <v-col>
        <v-card elevation="0">
          <!-- <v-card-title class="justify-center">
            <v-icon class="mr-1 primary--text" large>mdi-account-group</v-icon>
            <span class="primary--text">Zoznam priateľov</span>
          </v-card-title>
          <v-divider class="mt-0" /> -->
        <v-card-text class="p-0">
          <!-- <v-row justify="center" class="ml-0 mr-0 position-relative" v-for="contact in sortedContacts" :key="contact.id" @click="selectContact(contact)" :class="{ 'selected': contact == selected }"> -->
            <!-- <div class="row mr-0 ml-0 pl-1 w-100 position-relative" style="color: #6c757d" v-for="contact in sortedContacts" :key="contact.id" @click="selectContact(contact)" :class="{ 'selected': contact == selected }"> -->
              <!-- <div style="width:20px;text-align:left" v-if="contact.status == 'online'">
                <span class="status online"></span>
              </div>
              <div style="width:20px;text-align:left" v-else>
                <span class="status offline"></span>
              </div> -->
              <!-- <div class="avatar">
                <img :src="contact.profile_image" :alt="contact.name">
            </div> -->
            <v-data-table no-data-text="Nenašli sa žiadny priatelia" item-key="name" sort-by="name" :header-props="headerProps" :footer-props="footerProps" :headers="headers" :items="contacts" :search="search"  :loading="myloadingvariable" loading-text="Načítavanie... Prosím počkajte" elevation="0">
              <template v-slot:top>
                <v-toolbar flat>
                  <!-- <v-toolbar-title>Rezervácie</v-toolbar-title> -->
                  <!-- <v-spacer></v-spacer> -->
                  <v-text-field v-model="search" append-icon="mdi-magnify" label="Vyhľadať" single-line hide-details></v-text-field>
                  <!-- <v-divider class="mx-4" inset vertical></v-divider> -->
                  <v-spacer class="mr-1 ml-1"></v-spacer>
                  <v-btn color="primary" class="mb-2" to="/profile/add_friends" fab small ><v-icon>mdi-account-plus</v-icon></v-btn>
                </v-toolbar>
              </template>
              <template v-slot:item="{ item }" >
                <div class="p-3" :key="item.id" @click="selectContact(item)" :class="{ 'selected': item == selected }">
                  <v-badge bottom dot bordered :color="getColor(item.status)" offset-x="10" offset-y="10" class="mr-2">
                    <v-avatar color="primary" size="48" v-if="item.avatar == null">
                      <span class="text-uppercase secondary--text">{{ item.name.charAt(0) }}</span>
                    </v-avatar>
                    <v-avatar color="primary" size="48" v-else>
                      <img :src="`http://127.0.0.1:8000/storage/user-avatar/${item.avatar}`">
                    </v-avatar>
                  </v-badge>

                  <v-badge :content="item.unread" :value="item.unread" color="orange">
                    {{ item.name }}
                  </v-badge>
                </div>
                <!-- <v-chip :color="getColor(item.status)">
                  {{ item.status }}
                </v-chip> -->
              </template>
            </v-data-table>
            <!-- <div v-if="contact.status == 'online'">
              <v-badge bordered bottom dot inline left color="success">
              </v-badge>
              <v-badge :content="contact.unread" :value="contact.unread" color="primary">
                {{ contact.name }}
              </v-badge>
            </div>
            <div v-else>
              <v-badge bordered bottom dot inline left color="error">
              </v-badge>
              <v-badge :content="contact.unread" :value="contact.unread" color="primary" overlap>
                {{ contact.name }}
              </v-badge>
            </div> -->
              <!-- <div class="contact">
                <span>{{ contact.name }}</span>
              </div>
              <div class="unread" v-if="contact.unread">
                <span>{{ contact.unread }}</span>
              </div> -->
            <!-- </v-row> -->
            <!-- </div> -->
            <!-- {{message}} -->
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <!-- <v-text-field
      ref="ta"
      :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
      :append-outer-icon="message ? 'mdi-send' : 'mdi-microphone'"
      :prepend-icon="icon"
      :type="show2 ? 'text' : 'password'"
      filled
      clearable
      auto-grow
      counter
      rows="1"
      clear-icon="mdi-close"
      label="Správa"
      v-model="message"
      @click:append="show2 = !show2"
      @click:prepend="changeIcon"
      @click:clear="clearMessage"
    ></v-text-field>
    <div v-if="autoselectMenu"> -->
      <!-- <VEmojiPicker @click="selectEmoji" /> -->
      <!-- <picker :color="`${$vuetify.theme.themes[isDark].primary}`" :showSearch="false" :showPreview="false" :set="'messenger'" :showSkinTones="true" :emojiTooltip="true" :infiniteScroll="false" @select="selectEmoji" :i18n="i18n" />
    </div> -->
  </div>
</template>
<script>
// import {
//   Picker
// } from 'emoji-mart-vue'
// import axios from 'axios';
import _ from 'lodash';
export default {
  props: {
    contacts: {
      type: Array,
      default: () => []
    }
  },

  data() {
    return {
      show2: false,
      // selected: 0
      selected: this.contacts.length ? this.contacts[0] : null,
      myloadingvariable: true,
      // chatInput
      show: false,
      marker: true,
      iconIndex: 0,
      icons: [
        'mdi-emoticon',
        'mdi-emoticon-neutral',
      ],
      autoselectMenu: false,
      i18n: {
        search: 'Vyhľadať',
        notfound: 'Neboli nájdené žiadne emoji',
        categories: {
          search: 'Výsledok vyhľadávania',
          recent: '',
          people: '',
          nature: '',
          foods: '',
          activity: '',
          places: '',
          objects: '',
          symbols: '',
          flags: '',
          custom: '',
        }
      },

      message: '',

      // table friends
      footerProps: {
        itemsPerPageText: 'Počet riadkov',
        itemsPerPageOptions: [5, 10, 15, -1],
      },
      headerProps: {
        sortByText: "Zoradiť podľa"
      },
      headers: [{
          // text: 'Priateľ',
          align: 'center',
          value: 'name',
          sortable: false,
        },
        // {
        //   text: 'Email',
        //   align: 'center',
        //   value: 'email',
        //   sortable: false,
        // },
      ],
      search: '',
    }
  },

  methods: {
    getColor(e) {
      if (e == 'offline') return 'red'
      else return 'green'
    },
    selectContact(item) {
      this.selected = item;
      this.$emit('selected', item);
      this.$store.dispatch('selectedUser', {
        id: item.id,
        name: item.name,
        email: item.email,
        status: item.status,
        avatar: item.avatar,
        created_at: item.created_at,
        unread: item.unread,
      });
    },

    // newEvent
    selectEmoji(emoji) {
      if (this.message != null) {
        this.message += emoji.native;
      } else {
        this.message = emoji.native;
        // console.log(emoji.native);
      }
    },
    // chatInput
    toggleMarker() {
      this.marker = !this.marker
    },

    sendMessage(message) {
      message.preventDefault();
      if (this.message == '') {
        return;
      }
      this.$emit('send', this.message);
      this.resetIcon()
      this.clearMessage()
    },
    clearMessage() {
      this.message = ''
    },
    resetIcon() {
      this.iconIndex = 0
    },
    changeIcon() {
      this.autoselectMenu = !this.autoselectMenu;
      this.iconIndex === this.icons.length - 1 ?
        this.iconIndex = 0 :
        this.iconIndex++
    },
  },
  updated() {
    //do something after updating vue instance
    this.myloadingvariable = this.$store.getters['contactListLoader'];
    this.selected = this.$store.getters['selectedUser'];
  },

  mounted() {
    //do something after mounting vue instance
  },

  created() {
    this.myloadingvariable = this.$store.getters['contactListLoader'];
    this.selected = this.$store.getters['selectedUser'];
    // window.Echo.private('statusUpdate')
    //   .listen('statusUpdate', (e) => {
    //     console.log("test " + e.message);
    //   })
    // window.Echo.join('allUnreadMessages.' + localStorage.getItem("user_id"))
    //   .listen('UnreadMessages', (e) => {
    //     console.log(e);
    //   })
  },

  computed: {
    sortedContacts() {
      return _.sortBy(this.contacts, [(contact) => {
          if (contact == this.selected) {
            return Infinity;
          }
          return contact.unread;
        }])
        .reverse();
    },

    // newEvent
    icon() {
      return this.icons[this.iconIndex]
    },
    isDark() {
      return (this.$vuetify.theme.dark) ? 'dark' : 'light'
    },
  }
}
</script>
<style lang="scss" scoped>
.unread {
    background: #82e0a8;
    color: #fff;
    width: 20px;
    // right: 9px;
    // position: absolute;
    border-radius: 3px;
}
// .v-badge--dot .v-badge__badge {
//     width: 12px !important;
//     height: 12px !important;
//     border-radius: 10px !important;
// }

.theme--light .emoji-mart[data-v-7bc71df8] {
    width: 100% !important;
    border: 1px solid #0D47A1;
}

.theme--dark .emoji-mart[data-v-7bc71df8] {
    width: 100% !important;
    border: 1px solid #21CFF3;
}

.theme--light .emoji-mart-bar[data-v-7bc71df8] {
    border: 0 solid #0D47A1 !important;
}

.theme--dark .emoji-mart-bar[data-v-7bc71df8] {
    border: 0 solid #21CFF3 !important;
}

.theme--light .emoji-mart-anchor-bar[data-v-51188104] {
    background-color: #0D47A1 !important;
}

.theme--dark .emoji-mart-anchor-bar[data-v-51188104] {
    background-color: #21CFF3 !important;
}
.emoji-mart-anchors[data-v-51188104] {
    padding: 0 !important;
}
</style>
