<template>
<div class="LoginForm padding-top-height">
  <div class="p-3 position-ref body-height">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <v-card :loading="myloadingvariable" tile>
          <v-card-title>
            <span class="font-weight-bold text-center">Prihlásenie</span>
            <router-link :to="{ name: 'Welcome' }">
              <button type="button" class="close">&times;</button>
            </router-link>
          </v-card-title>
          <hr class="mt-0 mb-0 custom-hr">
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-card-text class="p-3">
              <v-alert v-if="alert" dismissible color="red" border="left" elevation="2" colored-border icon="mdi-alert-circle">
                <span>Nesprávny email alebo heslo!</span>
              </v-alert>

              <v-alert v-if="alertSuccessRegister" dismissible color="green" border="left" elevation="2" colored-border icon="mdi-check-circle">
                <span>Používateľský účet bol úspešne vytvorený!</span>
              </v-alert>

              <v-text-field prepend-icon="mdi-email" v-model="email" :error-messages="error" :rules="emailRules" label="Email" clearable clear-icon="mdi-close-circle" counter></v-text-field>

              <v-text-field prepend-icon="mdi-lock" v-model="password" :append-icon="togglePassword ? 'mdi-eye' : 'mdi-eye-off'" :error-messages="error" :rules="passwordRules" :type="togglePassword ? 'text' : 'password'" label="Heslo"
                hint="Minimálne 4 znaky" counter @click:append="togglePassword = !togglePassword" clearable clear-icon="mdi-close-circle"></v-text-field>
              <v-row>
                <v-col class="text-center pb-0 pt-5">
                  <v-checkbox v-model="remember" name="remember" id="remember" label="Zapamätať"></v-checkbox>
                </v-col>
                <v-col class="text-center pb-0 pt-5">
                  <router-link :to="{ name: 'Reset' }">
                    <span class="forgot-pass">Zabudnuté <span class="primary-color">heslo?</span></span>
                  </router-link>
                </v-col>
              </v-row>
              <v-divider class="mx-0"></v-divider>
              <div class="row">
                <div class="col text-center">
                  <router-link :to="{ name: 'Register' }">
                    <span class="forgot-pass">Ešte nemáš účet? <span class="primary-color">Zaregistruj sa</span></span>
                  </router-link>
                </div>
              </div>
            </v-card-text>
            <hr class="mt-0 mb-0 custom-hr">
            <v-card-actions>
              <v-btn color="info" @click="login" block>
                Prihlásiť sa
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
        v => !!v || 'Heslo je Povinné.',
        v => v.length >= 4 || 'Heslo musí obsahovať minimálne 4 znaky',
      ],
      remember: true,
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
        }).then(resp => {
          this.myloadingvariable = false;
          localStorage.setItem('username', resp.data.user.name);
          localStorage.setItem('user_id', resp.data.user.id);
          localStorage.setItem('authToken', resp.data.token);
          this.reset();
          this.$router.push("/home");
        }).catch(e => {
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
    console.log('Component login mounted.')
  },
  created() {
    //add text that user was sucessfully registered
    this.alertSuccessRegister = this.$store.getters['successRegisterAlert'].success
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
