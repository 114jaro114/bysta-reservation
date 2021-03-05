<template lang="html">
  <div class="feed">
    <div v-bar class="list-unstyled" style="height:300px; overflow-y:scroll" v-chat-scroll="{smooth: true, notSmoothOnInit: true}" ref="card_body" v-if="contact">
      <div class="row m-0 pt-4 pl-2 pr-2 w-100" v-for="message in messages" :class="`message${message.to = contact.id ? ' sent' : ' received'}`" :key="message.id">
        <div v-if="message.from != user_id" class="float-left" style="border-radius: 5px;">
          <div class="float-left p-2 pr-3 pl-3 mr-1 bubble_friend" :style="{background: $vuetify.theme.themes[isDark].accent}">
            <span class="background--text">{{ message.text }}</span><br>
          </div>
          <div class="float-left pr-3 bubble_friend2 accent--text">
            <span>{{ message.created_at.substr(11, 5) }}</span>
          </div>
        </div>
        <div v-else class="col p-0">
          <div class="float-right p-2 pr-3 pl-3 ml-1 bubble_me" :style="{background: $vuetify.theme.themes[isDark].primary}">
            <span class="secondary--text">{{ message.text }}</span><br>
          </div>
          <div class="float-right bubble_me2 primary--text">
            <span>{{ message.created_at.substr(11, 5) }}</span>
          </div>
        </div>
      </div>
      <span class="accent--text text-muted p-2 float-left" v-if="typingStatusFunction">
        {{ writingUser }}
        <div class="bubble primary--text">
          <div class="ellipsis one" :style="{background: $vuetify.theme.themes[isDark].accent}"></div>
          <div class="ellipsis two" :style="{background: $vuetify.theme.themes[isDark].accent}"></div>
          <div class="ellipsis three" :style="{background: $vuetify.theme.themes[isDark].accent}"></div>
        </div>
      </span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    contact: {
      type: Object,
    },
    messages: {
      type: Array,
      required: true
    },
    typingStatus: Boolean,
  },

  data() {
    return {
      user_id: localStorage.getItem("user_id"),
      writingUser: null,
      typingTimer: false,
      typingStatusNew: false
    }
  },

  computed: {
    typingStatusFunction() {
      return this.typingStatus;
    },

    isDark() {
      return (this.$vuetify.theme.dark) ? 'dark' : 'light'
    },
  },

  created() {
    window.Echo.join('pchat')
      .here(user => {
        console.log('here', user);
      })
      .joining(user => {
        console.log('joining', user);
      })
      .leaving(user => {
        console.log('leaving', user);
      })
      .listenForWhisper('typing', (user) => {
        this.writingUser = user;
        this.typingStatus = true;
        if (this.typingTimer) {
          clearTimeout(this.typingTimer);
        }
        this.typingTimer = setTimeout(() => {
          this.typingStatus = false;
        }, 2000);
      })
  },

  methods: {
    scrollToBottom() {
      setTimeout(() => {
        this.$refs.card_body.scrollTop = this.$refs.card_body.scrollHeight;
      }, 50);
    }
  },
  updated() {
    // This will be called when the component updates
    this.scrollToBottom();
  },
}
</script>

<style lang="scss" scoped>
.bubble_friend {
    border-radius: 10px;
    max-width: 230px;
}
.bubble_friend2 {
    font-size: 10px;
    color: lightgrey;
    position: relative;
    left: -30px;
    top: -17px;
}

.bubble_me {
    border-radius: 10px;
    max-width: 230px;
}

.bubble_me2 {
    font-size: 10px;
    color: lightblue;
    position: relative;
    right: -30px;
    top: -17px;
}
.v-window__container {
    padding-bottom: 480px !important;
}
</style>
