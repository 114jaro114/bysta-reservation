<template>
<div class="LoginForm padding-top-height">
  <div id="blur-effect">
    <div class="p-3 position-ref body-height">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <div class="row justify-content-center">
        <div class="col-md-6">

          <v-card :loading="myloadingvariable" tile>
            <v-card-title>
              <span class="font-weight-bold text-center">Obnova hesla</span>
              <router-link :to="{ name: 'Welcome' }">
                <button type="button" class="close">&times;</button>
              </router-link>
            </v-card-title>
            <hr class="mt-0 mb-0 custom-hr">
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-card-text class="p-3">
                <v-alert v-if="alert" dismissible color="green" border="left" elevation="2" colored-border icon="mdi-check-circle">
                  <span>Na zadaný email bol odoslaný link na vytvorenie nového hesla!</span>
                </v-alert>

                <v-text-field prepend-icon="mdi-email" v-model="email" :rules="emailRules" label="Email" clearable clear-icon="mdi-close-circle"></v-text-field>

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
                <v-btn color="info" @click="sendNewPassword" block>
                  Resetovať heslo
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
  names: ['LoginForm', 'CheckboxHueColors', 'FormValidation'],
  props: {},
  data() {
    return {
      valid: true,
      myloadingvariable: false,
      alert: false,
      email: '',
      emailRules: [
        v => !!v || 'E-mail je povinný',
        v => /.+@.+\..+/.test(v) || 'E-mail musí mať valídny tvar',
      ],
    }
  },

  methods: {
    validate() {
      return this.$refs.form.validate();
    },
    reset() {
      this.$refs.form.reset()
    },

    sendNewPassword() {
      if (this.validate()) {
        this.myloadingvariable = true;
        // call API
        axios.post('http://127.0.0.1:8000/api/auth/login', {
          email: this.email,
          password: this.password,
          remember: this.remember,
          status: "online"
        }).then(resp => {
          this.myloadingvariable = false;
          this.alert = true;
          localStorage.setItem('username', resp.data.user.name);
          localStorage.setItem('user_id', resp.data.user.id);
          localStorage.setItem('authToken', resp.data.token);
          this.reset();
          this.$router.push("/home");
        }).catch(e => {
          this.myloadingvariable = false;
          this.errors.push(e)
        })
      }
    },
  },
  mounted() {
    console.log('Component login mounted.')
  },

  created() {
    console.log('Component login created')
  }
};
</script>

<style lang="css">
  .md-title{
    color: #007bff;
  }
  .padding-top-height {
    padding-top: 10vh;
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
