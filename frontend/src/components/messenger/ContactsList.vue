<template lang="html">
  <div class="contacts-list">
    <v-row justify="center" class="ml-0 mr-0">
      <v-col>
        <v-card elevation="0" :loading="myloadingvariable">
          <v-card-title class="justify-center">
            <v-icon class="mr-1 primary--text" large>mdi-account-group</v-icon>
            <span class="primary--text">Zoznam priateľov</span>
          </v-card-title>
          <v-divider class="mt-0" />
        <v-card-text class="p-3">
          <v-row justify="center" class="ml-0 mr-0 position-relative" v-for="contact in sortedContacts" :key="contact.id" @click="selectContact(contact)" :class="{ 'selected': contact == selected }">
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

            <div v-if="contact.status == 'online'">
              <v-badge bordered bottom dot inline left color="success">
                <v-badge :content="contact.unread" :value="contact.unread" color="primary">
                  {{ contact.name }}
                </v-badge>
              </v-badge>
            </div>
            <div v-else>
              <v-badge bordered bottom dot inline left color="error">
                <v-badge :content="contact.unread" :value="contact.unread" color="primary">
                  {{ contact.name }}
                </v-badge>
              </v-badge>
            </div>


              <!-- <div class="contact">
                <span>{{ contact.name }}</span>
              </div>
              <div class="unread" v-if="contact.unread">
                <span>{{ contact.unread }}</span>
              </div> -->
            </v-row>
            <!-- </div> -->
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>
<script>
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
      // selected: 0
      selected: this.contacts.length ? this.contacts[0] : null,
      myloadingvariable: true,
    }
  },
  methods: {
    selectContact(contact) {
      this.selected = contact;
      this.$emit('selected', contact);
    }
  },
  created() {
    // window.Echo.private('statusUpdate')
    //   .listen('statusUpdate', (e) => {
    //     console.log("test " + e.message);
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
    }
  }
}
</script>
<style lang="scss" scoped>
// .unread {
//     background: #82e0a8;
//     color: #fff;
//     width: 20px;
//     // right: 9px;
//     // position: absolute;
//     border-radius: 3px;
// }
.v-badge--dot .v-badge__badge {
    width: 12px !important;
    height: 12px !important;
    border-radius: 10px !important;
}
</style>
