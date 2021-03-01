<template lang="html">
  <div class="contacts-list col-4 pr-1 pl-3 pt-0 pb-0">
    <v-card tile class="h-100">
      <div class="top-bar">
        <!-- <div class="avatar"><p>CB</p></div> -->
        <div class="name text-center"><i class="fas fa-users"></i> Zoznam priateľov</div>
      </div>
      <hr class="mb-0 mt-0">
      <div class="card-body h-100">
        <div class="row mr-0 ml-0 pl-1 w-100 position-relative" style="color: #6c757d" v-for="contact in sortedContacts" :key="contact.id" @click="selectContact(contact)" :class="{ 'selected': contact == selected }">
          <div style="width:20px;text-align:left" v-if="contact.status == 'online'">
            <span class="status online"></span>
          </div>
          <div style="width:20px;text-align:left" v-else>
            <span class="status offline"></span>
          </div>
          <!-- <div class="avatar">
            <img :src="contact.profile_image" :alt="contact.name">
        </div> -->
          <div class="contact">
            <span>{{ contact.name }}</span>
          </div>
          <div class="unread" v-if="contact.unread">
            <span>{{ contact.unread }}</span>
          </div>
        </div>
      </div>
    </v-card>
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
      selected: this.contacts.length ? this.contacts[0] : null
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
      }]).reverse();
    }
  }
}
</script>
<style lang="scss" scoped>
.unread {
    background: #82e0a8;
    color: #fff;
    width: 20px;
    right: 9px;
    position: absolute;
    border-radius: 3px;
}

.status {
    width: 10px;
    height: 10px;
    border-radius: 100%;
    position: absolute;
    top: 4px;
}

.online {
    background-color: #58b666;
}

.offline {
    background-color: #ff725d;
}
</style>
