<template>
<div class="LoginForm padding-top-height text-uppercase">
  <div class="text-center">
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
  </div>
  <div class="p-3 position-ref body-height">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <form novalidate method="POST" @submit.prevent='validateLogin'>
          <md-card>
            <md-card-header>
              <div class="md-title font-weight-bold text-center">Sign in</div>
              <router-link :to="{ name: 'Welcome' }">
                <button type="button" class="close">&times;</button>
              </router-link>
            </md-card-header>
            <hr class="mt-0 mb-0 custom-hr">
            <md-card-content>
              <div class="row pl-3 pr-3" v-show="hasErrorMessage">
                <span class="alert w-100 mb-1 m-auto font-weight-bold" role="alert" style="color: #ff1744; border-color: #ff1744">
                  <i class="fa fa-info-circle"></i> Bad email or password </span>
              </div>
              <md-field :class="[getValidationClass('email'), errorMessageClass]" md-clearable>
                <md-icon class="fa fa-envelope"></md-icon>
                <label for="email">Email</label>
                <md-input type="email" name="email" id="email" autocomplete="email" v-model="form.email" />
                <span class="md-error md-error-pl" v-if="!$v.form.email.required">The email is required</span>
                <span class="md-error md-error-pl" v-else-if="!$v.form.email.email">The email is invalid</span>
              </md-field>
              <md-field :class="[getValidationClass('password'), errorMessageClass]">
                <md-icon class="fa fa-lock"></md-icon>
                <label>Password</label>
                <md-input v-model="form.password" type="password" name="password" required />
                <span class="md-error md-error-pl" v-if="!$v.form.password.required">Password is required</span>
                <span class="md-error md-error-pl" v-else-if="!$v.form.password.minLength">Password must contains min 3 characters</span>
              </md-field>
              <div class="row">
                <div class="col-6 text-center">
                  <md-checkbox v-model="form.remember" name="remember" id="remember" class="md-primary">Remember</md-checkbox>
                </div>
                <div class="col-6 text-center">
                  <router-link :to="{ name: 'Reset' }">
                    <span class="forgot-pass">Forgot <span class="primary-color">password?</span></span>
                  </router-link>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col text-center">
                  <router-link :to="{ name: 'Register' }">
                    <span class="forgot-pass">New user? <span class="primary-color">Sign up</span> to create your account</span>
                  </router-link>
                </div>
              </div>
            </md-card-content>
            <hr class="mt-0 mb-0 custom-hr">
            <md-card-actions>
              <md-button type="submit" class="md-raised md-primary" id="md-primary" @click="overlay = !overlay">Sign in</md-button>
            </md-card-actions>
          </md-card>
        </form>
      </div>
    </div>
  </div>
</div>
</template>
<script>
import axios from 'axios';
import {
  required,
  email,
  minLength,
} from 'vuelidate/lib/validators'
export default {
  names: ['LoginForm', 'CheckboxHueColors', 'FormValidation'],
  props: {},
  data() {
    return {
      form: {
        email: null,
        password: null,
        remember: true,
      },
      hasErrorMessage: false,
      sending: false,
      overlay: false,
    }
  },
  validations: {
    form: {
      email: {
        required,
        email
      },
      password: {
        required,
        minLength: minLength(3)
      },
    }
  },
  computed: {
    errorMessageClass() {
      return {
        'md-invalid': this.hasErrorMessage
      }
    },
  },
  methods: {
    getValidationClass(fieldName) {
      const field = this.$v.form[fieldName]
      if (field) {
        return {
          'md-invalid': field.$invalid && field.$dirty
        }
      }
    },
    validateLogin() {
      this.$v.$touch()
      if (!this.$v.$invalid) {
        this.saveUser()
      } else {
        this.overlay = false;
      }
    },
    clearForm() {
      this.$v.$reset()
      this.form.email = null
      this.form.password = null
    },
    saveUser() {
      this.sending = true
      // call API
      axios.post('http://127.0.0.1:8000/api/auth/login', {
        email: this.form.email,
        password: this.form.password,
        remember: this.form.remember,
        status: "online"
      }).then(resp => {
        this.hasErrorMessage = false;
        localStorage.setItem('username', resp.data.user.name);
        localStorage.setItem('user_id', resp.data.user.id);
        localStorage.setItem('authToken', resp.data.token);
        this.sending = false;
        this.clearForm();
        this.$router.push("/home");
        this.overlay = false;
      }).catch(e => {
        this.overlay = false;
        this.hasErrorMessage = true,
          this.errors.push(e)
      })
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
  .md-title {
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
    background-color: rgb(255, 255, 255) !important;
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
