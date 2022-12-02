<template>
<div class="contact w-100 h-100">
  <v-container class="mt-16 mb-4">
    <v-card class="pt-3 pt-lg-5 pt-md-5">
      <v-overlay :value="$root.me.overlayAvatar">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
      <v-lazy :options="{
                      threshold: .4
                    }" transition="scale-transition">
        <v-row justify="center" class="ml-0 mr-0">
          <v-col class="pl-3 pr-3">
            <v-card class="rounded" elevation="0">
              <v-toolbar class="rounded-top" color="primary" flat dark>
                <v-row align="center">
                  <v-divider />
                  <!-- <v-icon class="pr-1">mdi-alert-circle</v-icon> -->
                  V prípade akýchkoľvek otázok nás neváhajte kontaktovať.
                  <v-divider />
                </v-row>
              </v-toolbar>
              <v-row justify="center" class="ml-0 mr-0 mt-3 pb-3">
                <v-col class="pl-3 pr-3 m-auto">
                  <v-btn class="mt-3" x-large color="primary" outlined dark to="/messenger">
                    <v-icon class="pr-1">mdi-facebook-messenger</v-icon>
                    Messenger
                  </v-btn>
                </v-col>
                <v-divider inset vertical></v-divider>
                <v-col class="pl-3 pr-3">
                  <v-form ref="form" v-model="valid" lazy-validation>
                    <v-card-text class="p-3">
                      <v-text-field v-model="$root.me.email" :rules="emailRules" label="Email" tabindex="1" filled clearable required></v-text-field>
                      <v-textarea v-model="message" :rules="messageRules" :counter="1000" label="Správa" tabindex="1" filled clearable no-resize style="overflow:hidden"></v-textarea>
                    </v-card-text>
                    <hr class="mt-0 ml-4 mr-4">
                    <v-card-actions class="p-3">
                      <v-btn color="primary" @click="sendMessage()" block>
                        Odoslať správu
                      </v-btn>
                    </v-card-actions>
                  </v-form>
                </v-col>
              </v-row>
            </v-card>
          </v-col>
        </v-row>
      </v-lazy>
    </v-card>
  </v-container>
</div>
</template>

<script>
// import axios from 'axios';
export default {
  name: "Contact",
  components: {},
  data() {
    return {
      valid: false,
      message: '',
      messageRules: [
        v => !!v || 'Správa je povinná',
        v => (v && v.length <= 1000) || 'Správa môže obsahovať maximálne 1000 znakov',
      ],
      // email: '',
      emailRules: [
        v => !!v || 'E-mail je povinný',
        v => /.+@.+\..+/.test(v) || 'E-mail musí mať platný tvar',
      ],
    }
  },

  mounted() {},

  updated() {},
  methods: {
    validate() {
      return this.$refs.form.validate();
    },

    sendMessage() {
      if (this.validate()) {
        console.log("nice, all good");
      }
    }
  }
}
</script>

<style>

</style>
