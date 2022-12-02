<template>
<div class="profile w-100 h-100">
  <v-lazy :options="{
            threshold: .4
          }" transition="scale-transition">
    <v-row justify="center" class="ml-0 mr-0">
      <v-col class="pl-3 pr-3">
        <v-card class="rounded" elevation="0">
          <v-card-text>
            <v-flex class="mb-4">
              <v-container fluid>
                <v-row justify="center">
                  <v-avatar color="primary" size="48" class="mr-3" v-if="!avatarImageUrl">
                    <span style="color:white" class="text-uppercase font-weight-bold">{{ usernameInitial }}</span>
                  </v-avatar>
                  <v-avatar color="primary" size="48" class="mr-3" v-else>
                    <img :src="avatarImageUrl">
                  </v-avatar>
                  <div class="ml-3">
                    <v-btn disabled>
                      <span>Člen od: <span class="font-weight-bold">{{ memberFrom }}</span></span>
                    </v-btn>
                  </div>
                </v-row>
              </v-container>
            </v-flex>

            <v-flex class="mb-4">
              <v-container fluid>
                <v-row justify="center">
                  <div class="ml-3">
                    <v-btn disabled>
                      <span>Meno: {{name}}</span>
                    </v-btn>
                  </div>

                  <div class="ml-3">
                    <v-btn disabled>
                      <span>Email: {{email}}</span>
                    </v-btn>
                  </div>
                </v-row>
              </v-container>
            </v-flex>

          </v-card-text>
          <v-card-actions>
            <v-btn class="mr-3" color="primary" :loading="loading">
              <v-icon left dark>mdi-message-text-lock</v-icon>
              Poslať súkromnú správu
            </v-btn>

            <v-btn class="mr-3" color="info" @click="sendFriendshipRequest()" v-if="this.friendship_status == '0'">
              <v-icon>mdi-account-plus</v-icon>
              <span class="ml-1">Poslať žiadosť o priateľstvo</span>
            </v-btn>
            <div v-else-if="this.friendship_status == '1'">
              <v-btn class="mr-3" color="success">
                <v-icon>mdi-account-check</v-icon>
                <span class="ml-1">Priatelia</span>
              </v-btn>
              <v-btn class="mr-3" color="error" @click="removeFromFriendshipList()">
                <v-icon>mdi-close-circle</v-icon>
                <span class="ml-1">Zrušiť priateľstvo</span>
              </v-btn>
            </div>
            <v-btn class="mr-3" color="warning" @click="acceptFriendshipRequest()" v-else-if="this.friendship_status == '2' && this.user_requested == actualUser">
              <v-icon>mdi-arrow-right-bold</v-icon>
              <span class="ml-1">Prijať žiadosť</span>
            </v-btn>
            <div v-else>
              <v-btn class="mr-3" color="warning">
                <v-icon>mdi-account-clock</v-icon>
                <span class="ml-1">Žiadosť odoslaná</span>
              </v-btn>
              <v-btn class="mr-3" color="error" @click="removeFromFriendshipList()">
                <v-icon>mdi-close-circle</v-icon>
                <span class="ml-1">Zrušiť žiadosť</span>
              </v-btn>
            </div>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-lazy>
</div>
</template>

<script>
import axios from 'axios'
import moment from 'moment';
export default {
  pageTitle: 'ShowProfile',
  // props: ['userInfo'],
  data() {
    return {
      loading: false,
      avatarImageUrl: "",
      usernameInitial: '',
      name: '',
      email: '',
      memberFrom: '',
      friendship_status: 0,
      requester: '',
      user_requested: '',
      actualUser: localStorage.getItem("user_id"),
      rules: [v => v.length <= 25 || 'Max 25 characters'],
      show1: false,
      userInfo: JSON.parse(localStorage.getItem('userInformations')),
    }
  },

  mounted() {
    // this.avatarImageUrl = "http://127.0.0.1:8000/storage/user-avatar/" + this.userInfo.avatar;
    // this.name = this.userInfo.name;
    // this.email = this.userInfo.email;
    // this.memberFrom = moment(this.userInfo.created_at).format('YYYY-MM-DD');
    // this.usernameInitial = this.userInfo.name.charAt(0);
  },

  created() {
    console.log(this.userInfo)
    if (this.userInfo.avatar) {
      this.avatarImageUrl = "http://127.0.0.1:8000/storage/user-avatar/" + this.userInfo.avatar;
    }
    this.name = this.userInfo.name;
    this.email = this.userInfo.email;
    if (this.userInfo.friendship_status != null) {
      this.friendship_status = this.userInfo.friendship_status;
    } else {
      this.friendship_status = 0;
    }

    this.requester = this.userInfo.requester;
    this.user_requested = this.userInfo.user_requested;
    this.memberFrom = moment(this.userInfo.created_at)
      .format('YYYY-MM-DD');
    this.usernameInitial = this.userInfo.name.charAt(0);
  },

  methods: {
    sendFriendshipRequest() {
      this.friendship_status = 2;
      const api = 'http://127.0.0.1:8000/api/friendships/sendFriendshipRequest';
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };

      axios.post(api, {
            user_requested: this.userInfo.id,
            friendship_status: '2'
          },
          config
        )
        .then((res) => {
          console.log(res);
        })
    },

    // acceptFriendshipRequest() {
    //   const api = 'http://127.0.0.1:8000/api/friendships/acceptFriendshipRequest';
    //   const config = {
    //     headers: {
    //       Accept: "application/json",
    //       Authorization: "Bearer " + localStorage.getItem("authToken"),
    //     },
    //   };
    //
    //   axios.post(api, {
    //         requester: this.requester,
    //         user_requested: this.user_requested,
    //         friendship_status: '1'
    //       },
    //       config
    //     )
    //     .then((res) => {
    //       console.log(res);
    //     })
    // },

    removeFromFriendshipList() {
      this.friendship_status = 0;
      const api = 'http://127.0.0.1:8000/api/friendships/removeFromFriendshipList';
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };

      axios.post(api, {
            requester: this.actualUser,
            user_requested: this.userInfo.id,
          },
          config
        )
        .then((res) => {
          console.log(res);
        })
    },
  }
}
</script>

<style media="screen">
input[type="file"] {
  opacity: 0;
  filter: aplha(opacity=0);
}

.file-input-icon-profile {
  position: absolute;
  margin-bottom: 0px;
}

.v-icon.avatar-img {
  font-size: 16px !important;
}

.image-upload>input {
  display: none;
}
</style>
