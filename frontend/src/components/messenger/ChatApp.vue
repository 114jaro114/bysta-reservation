<template lang="html">
  <div class="chat-app pt-3">
    <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage"/>
    <ContactsList :contacts="contacts" @selected="startConversationWith"/>
  </div>
</template>

<script>
import Conversation from './Conversation.vue';
import ContactsList from './ContactsList.vue';
import axios from 'axios';

export default {
  components: {
    Conversation,
    ContactsList
  },

  data() {
    return {
      selectedContact: null,
      messages: [],
      contacts: [],
      users: [],
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
      });
  },

  created() {
    //presence channel
    window.Echo.join('messages.' + localStorage.getItem("user_id"))
      .listen('NewMessage', (e) => {
        console.log(e);
        this.handleIncoming(e.message);
      })

    //private channel
    // window.Echo.private(`messages.${localStorage.getItem("user_id")}`)
    //   .listen('NewMessage', (e) => {
    //     this.handleIncoming(e.message);
    //   })
  },

  methods: {
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
        });
    },
    saveNewMessage(message) {
      this.messages.push(message);
      // console.log(this.messages)
    },

    handleIncoming(message) {
      // console.log(this.selectedContact.id);
      if (this.selectedContact && message.from == this.selectedContact.id) {
        // console.log(message);
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

  },
}
</script>

<style lang="scss" scoped>
.chat-app {
    display: flex;
    width: 100%;
}
</style>
