<template lang="html">
  <div class="composer">
    <div class="chat">
      <v-row class="m-0">
        <v-col cols="12" class="p-0">
          <!-- <v-text-field
            class="chatInput"
            solo
            label="Napiš správu..."
            clearable
            v-model="message"
            @keydown.enter="send"
            @keydown="sendTypingEvent()"
            name="message"
            append-icon="mdi-send"
          ></v-text-field> -->
          <v-text-field
            v-model="message"
            :append-icon="marker ? 'mdi-eye' : 'mdi-eye-off'"
            :append-outer-icon="message ? 'mdi-send' : 'mdi-microphone'"
            :prepend-icon="icon"
            filled
            clear-icon="mdi-close"
            clearable
            label="Správa"
            type="text"
            @click:append="toggleMarker"
            @click:append-outer="sendMessage"
            @click:prepend="changeIcon"
            @click:clear="clearMessage"
            @keydown.enter="sendMessage" 
            @keydown="sendTypingEvent()"
          ></v-text-field>
          <v-menu offset-y>
            <template id="">
              <span>dement</span>
            </template>

    </v-menu>

          <div v-if="autoselectMenu">
            <VEmojiPicker @click="selectEmoji" />
          </div>
          <!-- <input class="chatInput" type="text" placeholder="Napiš správu..." v-model="message" @keydown.enter="send" @keydown="sendTypingEvent()" name="message" /> -->
        </v-col>
        <!-- <v-col cols="2" class="pt-2 pb-0 pr-0 pl-0">
          <v-btn icon color="primary" @click="send">
            <v-icon>mdi-send</v-icon>
          </v-btn>
        </v-col> -->
      </v-row>
    </div>
  </div>
</template>

<script>
import {
  VEmojiPicker
} from 'v-emoji-picker';
export default {
  components: {
    VEmojiPicker,
  },
  data() {
    return {
      message: '',
      // chatInput
      show: false,
      marker: true,
      iconIndex: 0,
      icons: [
        'mdi-emoticon',
        'mdi-emoticon-cool',
        'mdi-emoticon-dead',
        'mdi-emoticon-excited',
        'mdi-emoticon-happy',
        'mdi-emoticon-neutral',
        'mdi-emoticon-sad',
        'mdi-emoticon-tongue',
      ],
      items: [{
          title: 'Click Me'
        },
        {
          title: 'Click Me'
        },
        {
          title: 'Click Me'
        },
        {
          title: 'Click Me 2'
        },
      ],
      autoselectMenu: false,
    }
  },

  computed: {
    icon() {
      return this.icons[this.iconIndex]
    },
  },

  methods: {
    // emoji input char
    selectEmoji(emoji) {
      console.log(emoji)
    },

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
  }
}
</script>

<style lang="scss" scoped>

</style>
