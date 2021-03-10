<template>
<div class="LoginForm padding-top-height">
  <div class="p-3 position-ref body-height">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="row justify-content-center">
      <div class="text-center">
        <v-snackbar v-model="snackbar" :multi-line="multiLine" color="success" :left="true">
          <v-icon>mdi-check-circle</v-icon>
          {{ text }}
          <template v-slot:action="{ attrs }">
            <v-btn color="white" text v-bind="attrs" @click="snackbar = false">
              Close
            </v-btn>
          </template>
        </v-snackbar>
      </div>
      <div class="col-md-6">
        <v-card :loading="myloadingvariable" tile>
          <v-card-title>
            <v-row justify="center" class="p-3">
              <span class="font-weight-bold text-center primary--text">Prihlásenie</span>
              <router-link :to="{ name: 'Welcome' }">
                <button type="button" class="primary--text close">&times;</button>
              </router-link>
            </v-row>

          </v-card-title>
          <hr class="mt-0 mb-0 custom-hr">
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-card-text class="p-3">
              <v-alert v-if="alert" dismissible color="error" border="left" elevation="2" colored-border icon="mdi-alert-circle">
                <span>Nesprávny email alebo heslo!</span>
              </v-alert>

              <v-alert v-if="alertSuccessRegister" dismissible color="success" border="left" elevation="2" colored-border icon="mdi-check-circle">
                <span>Používateľský účet bol úspešne vytvorený!</span>
              </v-alert>

              <v-text-field prepend-icon="mdi-email" v-model="email" :error-messages="error" :rules="emailRules" label="Email" clearable clear-icon="mdi-close" counter></v-text-field>

              <v-text-field prepend-icon="mdi-lock" v-model="password" :append-icon="togglePassword ? 'mdi-eye' : 'mdi-eye-off'" :error-messages="error" :rules="passwordRules" :type="togglePassword ? 'text' : 'password'" label="Heslo"
                hint="Minimálne 4 znaky" counter @click:append="togglePassword = !togglePassword" clearable clear-icon="mdi-close"></v-text-field>
              <v-row justify="center">
                <v-col class="text-center pb-0 pt-5">
                  <v-checkbox v-model="remember" name="remember" id="remember" label="Zapamätať"></v-checkbox>
                </v-col>
                <v-col class="pb-0 pt-5 float-right text-right">
                  <router-link :to="{ name: 'Reset' }">
                    <span class="forgot-pass primary--text font-weight-bold">Zabudnuté <span class="primary-color font-weight-bold">heslo?</span></span>
                  </router-link>
                </v-col>
              </v-row>
              <v-divider class="mx-0"></v-divider>
              <div class="row">
                <div class="col text-center">
                  <router-link :to="{ name: 'Register' }">
                    <span class="forgot-pass accent--text">Ešte nemáš účet? <span class="primary--text font-weight-bold">Zaregistruj sa</span></span>
                  </router-link>
                </div>
              </div>
            </v-card-text>
            <v-divider class="mt-0" />
            <!-- <hr class="mt-0 mb-0 custom-hr"> -->
            <v-card-actions>
              <v-btn color="primary" @click="login" block>
                Prihlásiť sa
              </v-btn>
            </v-card-actions>
          </v-form>
          <v-container align="center" class="p-4 pt-3">
            <v-row align="center">
              <v-divider />
              Alebo
              <v-divider />
            </v-row>
            <v-row class="pt-1" style="justify-content: center">
              <v-btn fab medium color="blue">
                <v-icon>
                  mdi-facebook
                </v-icon>
              </v-btn>

              <v-btn class="ml-5" fab medium color="red">
                <v-icon>
                  mdi-google
                </v-icon>
              </v-btn>

              <v-btn class="ml-5" fab medium color="light-blue">
                <v-icon>
                  mdi-twitter
                </v-icon>
              </v-btn>

              <v-btn class="ml-5" fab medium color="brown">
                <v-icon>
                  mdi-github
                </v-icon>
              </v-btn>
            </v-row>
          </v-container>
        </v-card>
      </div>
    </div>
  </div>
</div>
</template>
<script>
import axios from 'axios';
export default {
  names: ['LoginForm', 'CheckboxHueColors', 'FormValidation'],
  props: {},
  data() {
    return {
      alertSuccessRegister: false,
      myloadingvariable: false,
      togglePassword: false,
      alert: false,
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
      remember: true,
      error: '',

      multiLine: true,
      snackbar: false,
      text: '',
    }
  },

  computed: {
    // user() {
    //
    //   return this.$store.getters['security/localUser']
    // },
    // this.alertSuccessRegister =
  },
  methods: {


    validate() {
      return this.$refs.form.validate();
    },
    reset() {
      this.$refs.form.reset()
    },
    // resetValidation() {
    //   this.$refs.form.resetValidation()
    // },
    login() {
      if (this.validate()) {
        this.myloadingvariable = true;
        this.error = '';
        this.alert = false;
        // call API
        axios.post('http://127.0.0.1:8000/api/auth/login', {
            email: this.email,
            password: this.password,
            remember: this.remember,
            status: "online"
          })
          .then(resp => {
            this.myloadingvariable = false;
            localStorage.setItem('username', resp.data.user.name);
            localStorage.setItem('user_id', resp.data.user.id);
            localStorage.setItem('authToken', resp.data.token);
            this.reset();
            this.$router.push("/home");
            if (localStorage.getItem('speed_dial') == undefined) {
              localStorage.setItem('speed_dial', true);
              this.$store.dispatch('actionSpeedDialState', {
                status: true
              });
            }
            if (localStorage.getItem('bottom_navigation') == undefined) {
              localStorage.setItem('bottom_navigation', true);
              this.$store.dispatch('actionBottomNavigationState', {
                status: true
              });
            }
          })
          .catch(e => {
            this.myloadingvariable = false,
              this.alert = true,
              this.error = ' ',
              this.errors.push(e)
          })
      }
    },
  },
  updated() {

  },
  mounted() {
    if (this.$store.getters['isLoggedOut'].logout != false) {
      this.snackbar = true;
    } else {
      this.snackbar = false;
    }
    console.log('Component login mounted.')
  },
  created() {
    //add text that user was sucessfully registered
    this.alertSuccessRegister = this.$store.getters['successRegisterAlert'].success;
    this.text = `${this.$store.getters['isLoggedOut'].username}, bol si úspešne odhlásený`;
    console.log(this.$store.getters['isLoggedOut'].logout);
    console.log('Component login created')
  }
};
</script>
<style lang="css">
.v-input--selection-controls {
  margin-top: 0 !important;
  padding-top: 0 !important;
}
label {
  margin-bottom: 0 !important;
}
</style>
