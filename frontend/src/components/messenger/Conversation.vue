<template lang="html">
  <div class="conversation col-8 pr-0 pl-1 pt-0 pb-0">
    <v-card v-if="contact" class="h-100" :typingStatusNew="typingStatusNew">
      <!-- v-show="showChat" -->
      <div class="top-bar">
        <!-- <div class="avatar"><p>CB</p></div> -->
        <div class="row m-0">
          <div class="name" v-if="contact.status == 'online'">
            <i class="fas fa-user" style="color: #58b666"></i>
            <span> {{ contact.name }}</span>
          </div>
          <div class="name" v-else>
            <i class="fas fa-user" style="color: #ff725d"></i>
            <span> {{ contact.name }}</span>
          </div>
          <div class="icons">
            <i class="fas fa-phone"></i>
            <i class="fas fa-video"></i>
            <i class="fas fa-ellipsis-v"></i>
            <i class="fas fa-times" style="font-size: 15px" @click="removeSelectedContact"></i>
          </div>
        </div>
      </div>

      <hr class="mb-0 mt-0">

      <div class="card-body">
        <!-- <span>{{ contact ? contact.name: 'Select a Contact' }}</span> -->
        <MessagesFeed :typingStatus="typingStatus" :contact="contact" :messages="messages" />
      </div>
      <!-- <hr class="mb-0 mt-0"> -->
      <div class="bottom-bar">
        <MessageComposer @send="sendMessage" />
      </div>
    </v-card>
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
    }
  },

  updated() {
    this.typingStatus = this.typingStatusNew;
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
          this.$emit('new', res.data);
        })
      console.log(text);
    },

    removeSelectedContact() {
      this.contact = null;
    }
  }
}
</script>

<style lang="scss" scoped>
.status {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    // display: inline-block;
    margin-right: 7px;
}

.online {
    background-color: #58b666;
}

.offline {
    background-color: #ff725d;
}
</style>
