<template>
<div class="ResetPasswordForm padding-top-height">
  <div id="blur-effect">
    <div class="p-3 position-ref body-height">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <v-card class="rounded" :loading="myloadingvariable" elevation="0">
            <v-card-title>
              <v-row justify="center" class="p-3">
                <span class="font-weight-bold text-center primary--text">Nové heslo</span>
                <router-link :to="{ name: 'Login' }">
                  <button type="button" class="primary--text close">&times;</button>
                </router-link>
              </v-row>
            </v-card-title>
            <hr class="mt-0 mb-0 custom-hr">
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-card-text class="p-3">
                <v-snackbar v-model="alertFailResetPassword" :multi-line="multiLine" color="success" :bottom="true">
                  <v-icon>mdi-check-circle</v-icon>
                  {{ text }}
                  <template v-slot:action="{ attrs }">
                    <v-btn color="white" fab text small v-bind="attrs" @click="alertFailResetPassword = false">
                      <v-icon>mdi-close-circle</v-icon>
                    </v-btn>
                  </template>
                </v-snackbar>

                <v-text-field prepend-icon="mdi-email" v-model="email" :rules="emailRules" label="Email" filled clearable clear-icon="mdi-close"></v-text-field>
                <v-text-field prepend-icon="mdi-lock" v-model="password" :append-icon="togglePassword ? 'mdi-eye' : 'mdi-eye-off'" :rules="passwordRules" :type="togglePassword ? 'text' : 'password'" label="Heslo" hint="Minimálne 4 znaky" counter
                  @click:append="togglePassword = !togglePassword" filled clearable clear-icon="mdi-close"></v-text-field>
                <v-text-field prepend-icon="mdi-lock" v-model="confirmPassword" :append-icon="togglePasswordConfirm ? 'mdi-eye' : 'mdi-eye-off'" :rules="confirmPasswordRules" :type="togglePasswordConfirm ? 'text' : 'password'" label="Heslo znova"
                  hint="Minimálne 4 znaky" counter @click:append="togglePasswordConfirm = !togglePasswordConfirm" filled clearable clear-icon="mdi-close"></v-text-field>
              </v-card-text>
              <hr class="mt-0 mb-0 custom-hr">
              <v-card-actions>
                <v-btn color="primary" @click="resetPassword" block>
                  Uložiť nové heslo
                </v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
          <!-- <form novalidate method="POST" @submit.prevent='validateLogin'>
            <md-card>
              <md-card-header>
                <div class="md-title font-weight-bold text-center">Obnovenie hesla</div>
                <router-link :to="{ name: 'Welcome' }">
                  <button type="button" class="close">&times;</button>
                </router-link>
              </md-card-header>

              <hr class="mt-0 mb-0 custom-hr">

              <md-card-content>
                <div class="row pl-3 pr-3" v-show="hasErrorMessage">
                  <span class="alert w-100 mb-1 m-auto font-weight-bold" role="alert" style="color: #ff1744; border-color: #ff1744">
                    <i class="fa fa-info-circle"></i> Bad email or password
                  </span>
                </div>

                <md-field :class="[getValidationClass('email'), errorMessageClass]" md-clearable>
                  <md-icon class="fa fa-envelope"></md-icon>
                  <label for="email">Email</label>
                  <md-input type="email" name="email" id="email" autocomplete="email" v-model="form.email" />
                  <span class="md-error md-error-pl" v-if="!$v.form.email.required">The email is required</span>
                  <span class="md-error md-error-pl" v-else-if="!$v.form.email.email">The email is invalid</span>
                </md-field>
                <div class="row">
                  <div class="col text-center">
                    <router-link :to="{ name: 'Register' }">
                      <span class="forgot-pass">Ešte nemáš účet?</span><span class="primary-color"> Zaregistruj sa</span>
                    </router-link>
                  </div>
                </div>

              </md-card-content>

              <hr class="mt-0 mb-0 custom-hr">

              <md-card-actions>
                <md-button type="submit" class="md-raised md-primary" id="md-primary">Odoslať odkaz na obnovenie hesla</md-button>
              </md-card-actions>
            </md-card>
          </form> -->
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import axios from 'axios';
export default {
  names: ['ResetPasswordForm', 'CheckboxHueColors', 'FormValidation'],
  props: {},
  data() {
    return {
      valid: true,
      myloadingvariable: false,
      togglePassword: false,
      togglePasswordConfirm: false,

      alertFailResetPassword: false,
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
      token: null,
      multiLine: true,
      text: '',
    }
  },

  methods: {
    validate() {
      return this.$refs.form.validate();
    },
    reset() {
      this.$refs.form.reset()
    },

    resetPassword() {
      if (this.validate()) {
        this.myloadingvariable = true;
        // call API
        axios.post('http://127.0.0.1:8000/api/auth/reset/password/', {
            token: this.$route.params.token,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation
          })
          .then(resp => {
            console.log(resp);
            this.myloadingvariable = false;
            this.reset();
            this.$store.dispatch('successfullyUpdatedPassword', {
              state: true
            });
            this.$router.push("/login");
          })
          .catch(e => {
            this.myloadingvariable = false;
            this.alertFailResetPassword = true;
            this.text = "Vyskytol sa nejaký problém. Prosím skúste to znova";
            this.errors.push(e)
          })
      }
    },
  },
  mounted() {
    // console.log('Component Reset mounted.');
    this.$store.dispatch('isLoggedOut', {
      username: '',
      logout: false
    });
  },

  created() {
    // console.log('Component Reset created')
  }
};
</script>

<style lang="css">
  .md-title{
    color: #007bff;
  }
  .padding-top-height {
    padding-top: 5vh;
  }
  .md-checkbox {
    display: flex;
    margin: 0 !important;
  }
  .md-field:last-child {
    margin-bottom: 40px;
  }
  .md-field.md-theme-default>.md-icon:after {
    background-color: rgb(255,255,255) !important;
  }
  .md-button.md-theme-default.md-primary {
    background-color: #007bff;
  }
  .forgot-pass {
    color: black;
    /* margin: 16px 0px 16px 16px; */
  }
  .md-button {
    width: 100%;
  }
  .md-icon.fa-envelope {
    font-size: 18px !important;
  }
  .custom-hr {
    border-width: 3px;
  }
  .close {
    margin-right: 5px;
    position: absolute;
    top: 10px;
    right: 10px;
  }

  .md-theme-default a:not(.md-button):hover {
    text-decoration: unset !important;
  }

  .md-error-pl {
    padding-left: 36px;
  }

  .md-invalid .md-icon {
    color: #ff1744 !important;
  }
</style>
