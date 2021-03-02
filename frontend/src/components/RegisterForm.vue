<template>
<div class="RegisterForm padding-top-height">
  <div class="p-3 position-ref body-height">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <v-card :loading="myloadingvariable" tile>
          <v-card-title>
            <v-row justify="center" class="p-3">
              <span class="font-weight-bold text-center primary--text">Registrácia</span>
              <router-link :to="{ name: 'Welcome' }">
                <button type="button" class="primary--text close">&times;</button>
              </router-link>
            </v-row>
          </v-card-title>
          <hr class="mt-0 mb-0 custom-hr">
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-card-text class="p-3">

              <v-text-field prepend-icon="mdi-account" v-model="name" :rules="nameRules" :error-messages="errorUsername" label="Meno" clearable @click:clear="callItBackUsername()" clear-icon="mdi-close" counter></v-text-field>

              <v-text-field ref="email" prepend-icon="mdi-email" v-model="email" :rules="emailRules" :error-messages="errorEmail" label="Email" clearable @click:clear="callItBackEMail()" clear-icon="mdi-close" counter></v-text-field>

              <v-text-field prepend-icon="mdi-lock" v-model="password" :append-icon="togglePassword ? 'mdi-eye' : 'mdi-eye-off'" :rules="passwordRules" :type="togglePassword ? 'text' : 'password'" label="Heslo" hint="Minimálne 4 znaky" counter
                @click:append="togglePassword = !togglePassword" clearable clear-icon="mdi-close"></v-text-field>
              <v-text-field prepend-icon="mdi-lock" v-model="confirmPassword" :append-icon="togglePasswordConfirm ? 'mdi-eye' : 'mdi-eye-off'" :rules="confirmPasswordRules" :type="togglePasswordConfirm ? 'text' : 'password'" label="Heslo znova"
                hint="Minimálne 4 znaky" counter @click:append="togglePasswordConfirm = !togglePasswordConfirm" clearable clear-icon="mdi-close"></v-text-field>

              <div class="row">
                <div class="col text-center">
                  <router-link :to="{ name: 'Login' }">
                    <span class="forgot-pass accent--text">Už máš účet? <span class="primary--text font-weight-bold">Prihlás sa</span></span>
                  </router-link>
                </div>
              </div>
            </v-card-text>
            <hr class="mt-0 mb-0 custom-hr">
            <v-card-actions>
              <v-btn color="primary" @click="register" block>
                Zaregistrovať sa
              </v-btn>
            </v-card-actions>
          </v-form>
        </v-card>
      </div>
    </div>
  </div>
</div>
</template>
<script>
import axios from 'axios';

export default {
  name: "RegisterForm",
  props: {},
  data() {
    return {
      // form: {
      //   email: '',
      //   name: '',
      //   password: '',
      //   confirm_password: '',
      // },
      // sending: false,
      // takenNameError: false,
      // takenEmailError: false,
      // overlay: false,
      myloadingvariable: false,
      togglePassword: false,
      togglePasswordConfirm: false,
      alertSuccessRegister: false,
      alertFail: false,
      valid: true,
      name: '',
      nameRules: [
        v => !!v || 'Meno je povinné',
        v => (v && v.length <= 10) || 'Meno musí obsahovať max 10 znakov',
      ],
      email: '',
      emailRules: [
        v => !!v || 'E-mail je povinný',
        v => /.+@.+\..+/.test(v) || 'E-mail musí mať valídny tvar',
      ],
      password: '',
      passwordRules: [
        v => !!v || 'Heslo je povinné',
        v => v.length >= 4 || 'Heslo musí obsahovať minimálne 4 znaky',
      ],
      confirmPassword: '',
      confirmPasswordRules: [
        v => !!v || 'Potvrdenie hesla je povinné',
        v => v.length >= 4 || 'Potvrdenie hesla musí obsahovať minimálne 4 znaky',
        v => v === this.password || 'Zadané hesla sa nezhodujú',
      ],
      remember: true,
      alertFailText: '',

      errorUsername: [],
      errorEmail: [],
    }
  },
  computed: {},
  watch: {
    name() {
      if (this.name.length >= 4) {
        axios.get(`http://127.0.0.1:8000/api/checkIfUsernameExist/${this.name}`)
          .then(valid => {
            this.errorUsername = valid.data;
            // this.errorUsername = valid ? [] : ['async error']
          });
      } else {
        this.errorUsername = [];
      }
    },

    email() {
      if (/.+@.+\..+/.test(this.email)) {
        axios.post('http://127.0.0.1:8000/api/checkIfEMailExist', {
          email: this.email
        }).then(valid => {
          this.errorEmail = valid.data;
          // this.errorEmail = valid ? [] : ['async error']
        });
      } else {
        this.errorEmail = '';
      }
    }
  },
  methods: {
    validate() {
      return this.$refs.form.validate();
    },
    reset() {
      this.$refs.form.reset()
    },

    callItBackUsername() {
      this.errorUsername = [];
    },

    callItBackEmail() {
      this.errorEmail = [];
    },

    register() {
      //call API
      console.log(this.$refs.form);
      if (this.validate()) {
        this.myloadingvariable = true;
        axios.post('http://127.0.0.1:8000/api/auth/register', {
          email: this.email,
          name: this.name,
          password: this.password
        }).then(resp => {
          this.myloadingvariable = false;
          this.alertSuccess = true;
          this.$store.dispatch('successRegister', {
            success: true
          });
          // setTimeout(function() {
          this.$router.push("/Login");
          // }, 3000);
          console.log(resp);
        }).catch(e => {
          this.alertFail = true;
          this.myloadingvariable = false;
          console.log(e);
          if (e.response.data.errors.name != null && e.response.data.errors.email != null) {
            this.alertFailText = 'Zadaný email a meno sú už použíté!';
          } else if (e.response.data.errors.email != null) {
            this.alertFailText = 'Zadaný email je už použítý!';
          } else if (e.response.data.errors.name != null) {
            this.alertFailText = 'Zadané meno je už použíté!';
          }
          console.log(e);
        })
      }
    },
  },
};
</script>
<style lang="css" scoped>
  .padding-top-height {
    padding-top: 10vh;
  }

  .md-error-pl {
    padding-left: 36px;
  }

  .md-invalid .md-icon {
    color: #ff1744 !important;
  }

</style>
