<template>
<div class="profile w-100 h-100 text-uppercase secondary-color mt-3">
  <!-- for md-icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <div class="row justify-content-center mr-0 ml-0">
    <div class="col pl-0 pr-0">
      <md-card>

        <md-card-content v-if="!editProfile">
          <div class="noclick">

          </div>
          <v-row>
            <v-btn class="ma-2" color="info">
              Outlined Button
            </v-btn>
            <v-btn class="ma-2" outlined color="blue">
              Outlined Button
            </v-btn>
          </v-row>
          <md-card class="p-2">
            <span>Člen od: <span class="font-weight-bold">{{ memberFrom }}</span></span>
          </md-card>

          <md-field>
            <md-icon class="fa fa-user"></md-icon>
            <md-input v-model="name"></md-input>
          </md-field>

          <md-field>
            <md-icon class="fa fa-envelope"></md-icon>
            <md-input v-model="email" id="text" name="email"></md-input>
          </md-field>
        </md-card-content>

        <md-card-content v-else>
          <form method="POST" @submit.prevent='submit()'>
            <md-field md-clearable>
              <md-icon class="fa fa-user"></md-icon>
              <label>Username</label>
              <md-input v-model="name" id="name" name="name" required autocomplete="name"></md-input>
              <span class="md-error"></span>
            </md-field>

            <md-field md-clearable>
              <md-icon class="fa fa-envelope"></md-icon>
              <label>Email</label>
              <md-input v-model="email" id="email" name="email" required autocomplete="email"></md-input>
              <span class="md-error"></span>
            </md-field>

            <md-field>
              <md-icon class="fa fa-lock"></md-icon>
              <label>Password</label>
              <md-input v-model="password" type="password" id="password" name="password" required autocomplete="new-password"></md-input>
              <span class="md-error"></span>
            </md-field>
            <!-- <v-file-input accept="image/png, image/jpeg, image/bmp" prepend-icon="mdi-camera" label="Avatar"></v-file-input> -->
          </form>
        </md-card-content>

        <md-card-actions v-if="!editProfile">
          <md-button class="md-primary md-raised" v-on:click="editProfile = !editProfile">
            <span>Editovať profil</span>
          </md-button>
        </md-card-actions>

        <md-card-actions v-else>
          <md-button class="md-primary md-raised" @click="changeLoginData()">
            <span>Uložiť zmeny</span>
          </md-button>
          <md-button class="md-primary md-raised" v-on:click="editProfile = !editProfile" style="background: grey">
            <span>Zrušiť editovanie</span>
          </md-button>
        </md-card-actions>
      </md-card>
    </div>
  </div>
</div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
export default {
  name: "Profile",
  components: {},
  data() {
    return {
      name: localStorage.getItem("username"),
      email: null,
      password: null,
      memberFrom: null,
      editProfile: false,
    }
  },
  async created() {
    const api = 'http://127.0.0.1:8000/api/auth/user';
    const config = {
      headers: {
        Accept: 'application/json',
        Authorization: "Bearer " + localStorage.getItem("authToken")
      }
    }
    try {
      let res = await axios.get(api, config)
      this.email = res.data.email;
      this.memberFrom = moment(res.data.created_at).format('YYYY-MM-DD');
    } catch (err) {
      console.log(err)
    }
    // axios.get(api, config)
    //   .then(res => {
    //     this.email = res.data.email;
    //     this.memberFrom = moment(res.data.created_at).format('YYYY-MM-DD');
    //   })
    //   .catch((error) => {
    //     console.log('error', Object.assign({}, error));
    //   });
  },

  methods: {}
}
</script>

<style type="scss">
/* .md-empty-state {
    margin-top: 5rem !important;
  } */
.noclick {
  position: absolute;
  left: 0;
  top: 0;
  background-color: transparent;
  z-index: 555;
  width: 100%;
  height: 80%;
}

.profile .md-card-content {
  padding-bottom: 0 !important;
}

.profile .md-field:last-child {
  margin-bottom: 20px !important;
}
</style>
