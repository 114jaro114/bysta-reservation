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
            :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
            :append-outer-icon="message ? 'mdi-send' : 'mdi-thumb-up'"
            :prepend-icon="'mdi-emoticon'"
            :type="show2 ? 'text' : 'password'"
            filled
            clearable
            counter
            clear-icon="mdi-close"
            label="Správa"
            v-model="message"
            @click:append="show2 = !show2"
            @click:append-outer="test"
            @click:prepend="changeIcon"
            @click:clear="clearMessage"
            @keydown.enter="sendMessage"
            @keydown="sendTypingEvent()"
          ></v-text-field>
          <div v-if="autoselectMenu">
            <picker :showSearch="false" :showPreview="false" :set="'messenger'" :showSkinTones="true" :emojiTooltip="true" :infiniteScroll="false" @select="selectEmoji" :i18n="i18n" />
          </div>
        </v-col>
      </v-row>
    </div>
  </div>
</template>

<script>
// import {
//   VEmojiPicker
// } from 'v-emoji-picker';
import {
  Picker
} from 'emoji-mart-vue'
export default {
  components: {
    // VEmojiPicker,
    Picker,
  },
  data() {
    return {
      message: '',
      // chatInput
      show: false,
      show2: true,
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
      }
    }
  },

  computed: {
    // icon() {
    //   return this.icons[this.iconIndex]
    // },
  },

  methods: {
    test(a) {
      if (a.toElement.className == 'v-icon notranslate v-icon--link mdi mdi-send theme--light' || a.toElement.className == 'v-icon notranslate v-icon--link mdi mdi-send theme--dark') {
        // console.log(a.toElement.className);
        this.$emit('send', this.message);
        this.resetIcon();
        this.clearMessage();
      } else {
        this.$emit('send', '👍');
      }
    },
    // emoji input char
    selectEmoji(emoji) {
      if (this.message != null) {
        this.message += emoji.native;
      } else {
        this.message = emoji.native;
        // console.log(emoji.native);
      }
    },

    // send(e) {
    //   e.preventDefault();
    //   if (this.message == '') {
    //     return;
    //   }
    //   this.$emit('send', this.message);
    //   this.message = '';
    // },

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
      // this.iconIndex === this.icons.length - 1 ?
      //   this.iconIndex = 0 :
      //   this.iconIndex++
    },
  }
}
</script>

<style lang="scss" scoped>
.v-window__container {
    padding-bottom: 480px !important;
}
</style>
