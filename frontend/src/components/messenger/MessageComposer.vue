<template lang="html">
  <div class="composer">
    <div class="chat">
      <div class="row m-0">
        <div class="col-10 p-0">
          <input class="chatInput" type="text" placeholder="Napiš správu..." v-model="message" @keydown.enter="send" @keydown="sendTypingEvent()" name="message" />
        </div>
        <div class="col-2 pt-2 pb-0 pr-0 pl-0">
          <v-btn icon color="blue" @click="send">
            <i class="fas fa-paper-plane"></i>
          </v-btn>
        </div>
      </div>
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
