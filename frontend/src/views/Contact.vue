<template>
<div class="contact w-100 h-100 mt-16">
  <v-overlay :value="$root.me.overlayAvatar">
    <v-progress-circular indeterminate size="64"></v-progress-circular>
  </v-overlay>

  <v-container>
    <v-lazy :options="{
        threshold: .4
      }" transition="scale-transition">
      <v-card flat>
        <v-toolbar class="rounded-top d-flex justify-center" color="primary" flat dark>
          <span>
            <v-icon class="pr-1">mdi-information</v-icon>
            V prípade akýchkoľvek otázok nás neváhajte kontaktovať.
          </span>
        </v-toolbar>

        <v-row justify="center" class="m-0">
          <v-col class="pl-3 pr-3 m-auto" cols="12" sm="5" md="5" lg="5" xl="5">
            <v-btn class="mt-3" x-large color="primary" outlined dark to="/messenger">
              <v-icon class="pr-1">mdi-facebook-messenger</v-icon>
              Messenger
            </v-btn>
          </v-col>

          <!-- <v-col class="pt-4 pb-4 pr-0 pl-0 d-flex justify-end" cols="12" sm="1" md="1" lg="1" xl="1"> -->
          <v-divider class="mt-4 mb-4 ml-4 mr-4 mr-sm-0 mr-md-0 mr-lg-0 ml-sm-0 ml-md-0 ml-lg-0" :vertical="dividerType"></v-divider>
          <!-- </v-col> -->

          <v-col class="p-0" cols="12" sm="6" md="6" lg="6" xl="6">
            <v-form ref="form" v-model="valid" lazy-validation>

              <v-card-text class="">
                <v-text-field v-model="$root.me.email" :rules="emailRules" label="Email" tabindex="1" clearable filled rounded required></v-text-field>
                <v-textarea v-model="message" :rules="messageRules" :counter="1000" label="Správa" tabindex="1" filled rounded clearable no-resize style="overflow:hidden"></v-textarea>
              </v-card-text>

              <v-divider class="mt-0 mb-0 ml-4 mr-4"></v-divider>

              <v-card-actions class="p-3">
                <v-btn color="primary" @click="sendMessage()" block>
                  Odoslať správu
                </v-btn>
              </v-card-actions>
            </v-form>
          </v-col>
        </v-row>
      </v-card>
    </v-lazy>
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

  computed: {
    dividerType() {
      let size = false;
      switch (this.$vuetify.breakpoint.name) {
        case 'xs':
          size = false;
          break;
        case 'sm':
          size = false;
          break;
        case 'md':
          size = true;
          break;
        case 'lg':
          size = true;
          break;
        case 'xl':
          size = true;
      }
      console.log(this.$vuetify.breakpoint.name);
      console.log(size);
      return size;
    },
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
