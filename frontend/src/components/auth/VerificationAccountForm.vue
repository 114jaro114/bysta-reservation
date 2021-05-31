<template>
<div class="VerificationAccountForm padding-top-height">
  <div id="blur-effect">
    <div class="p-3 position-ref body-height">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <v-card class="rounded" :loading="myloadingvariable" elevation="0">
            <v-card-title>
              <v-row justify="center" class="p-3">
                <span class="font-weight-bold text-center primary--text">Aktivácia účtu</span>
              </v-row>
            </v-card-title>
            <v-card-text>
              <v-icon>mdi-check-circle</v-icon>
              <span>Používateľský účet bol úspešne aktivovaný. O malu chvíľu budete presmernovaný na stránku s príhlásením</span>
            </v-card-text>
          </v-card>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import axios from 'axios';
export default {
  names: 'VerificationAccountForm',
  props: {},
  data() {
    return {
      myloadingvariable: false,
      token: null,
    }
  },

  methods: {
    verif_account() {
      this.myloadingvariable = true;
      // call API
      axios.post('http://127.0.0.1:8000/api/auth/reset/password/', {
          token: this.$route.params.token,
        })
        .then(resp => {
          console.log(resp);
          this.myloadingvariable = false;
          // this.$store.dispatch('successfullyUpdatedPassword', {
          //   state: true
          // });
          // this.$router.push("/login");
        })
        .catch(e => {
          this.myloadingvariable = false;
          this.text = "Vyskytol sa nejaký problém. Prosím skúste to znova";
          this.errors.push(e)
        })
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
