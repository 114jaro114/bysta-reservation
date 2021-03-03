<template lang="html">
  <div class="composer">
    <div class="chat">
      <v-row class="m-0">
        <v-col cols="10" class="p-0">
          <input class="chatInput" type="text" placeholder="Napiš správu..." v-model="message" @keydown.enter="send" @keydown="sendTypingEvent()" name="message" />
        </v-col>
        <v-col cols="2" class="pt-2 pb-0 pr-0 pl-0">
          <v-btn icon color="primary" @click="send">
            <v-icon>mdi-send</v-icon>
          </v-btn>
        </v-col>
      </v-row>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      message: '',
    }
  },
  methods: {
    send(e) {
      e.preventDefault();
      if (this.message == '') {
        return;
      }
      this.$emit('send', this.message);
      this.message = '';
    },

    sendTypingEvent() {
      window.Echo.join('pchat')
        .whisper('typing', localStorage.getItem('username'));
    },
  }
}
</script>

<style lang="scss" scoped>

</style>
