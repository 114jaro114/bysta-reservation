<template>
<div class="add_friends w-100 h-100">
  <!-- <v-lazy :options="{
            threshold: .4
          }" transition="scale-transition"> -->
  <v-overlay :value="overlay">
    <v-progress-circular indeterminate size="64"></v-progress-circular>
  </v-overlay>
  <v-row justify="center" class="ml-0 mr-0">
    <v-col class="pl-3 pr-3">
      <v-card class="rounded" elevation="0">
        <v-toolbar extended extension-height="4" class="rounded-top" color="primary" flat dark>
          <v-spacer />
          <v-text-field v-model="search" append-icon="mdi-magnify" label="Vyhľadať" hide-details filled clearable dense></v-text-field>
          <v-spacer />
          <!-- <v-progress-linear v-if="myloadingvariable" color="white" style="height:4px" slot="extension" :indeterminate="true"></v-progress-linear> -->
        </v-toolbar>

        <v-data-table :mobile-breakpoint="0" no-data-text="Nenašli sa žiadny používatelia" :header-props="headerProps" :footer-props="footerProps" :headers="headers" :items="users" :search="search" item-key="name"
          loading-text="Načítavanie... Prosím počkajte">
          <template v-slot:item.name="{ item }">
            <!-- <v-btn text class="mr-3" color="primary" @click="showProfile(item)" outlined>
                <v-icon>mdi-account</v-icon>
                <span>{{item.name}}</span>
              </v-btn> -->
            <v-dialog v-model="dialogShowProfile" fullscreen hide-overlay transition="dialog-bottom-transition">
              <template v-slot:activator="{ on, attrs }">
                <v-btn text class="mr-3" color="primary" @click="showProfile(item)" v-bind="attrs" v-on="on">
                  <v-icon>mdi-account</v-icon>
                  <span>{{item.name}}</span>
                </v-btn>
              </template>
              <v-card elevation="0">
                <v-toolbar tile dark color="primary">
                  <v-btn icon dark @click="dialogShowProfile = false">
                    <v-icon>mdi-close</v-icon>
                  </v-btn>
                  <v-toolbar-title class="justify-center">Informácie o používateľovi</v-toolbar-title>
                </v-toolbar>

                <v-card elevation="0" class="mt-5">
                  <v-card-text>
                    <!-- <v-flex class="mb-4">
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
                      </v-flex> -->
                    <v-row justify="center">
                      <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                        <v-avatar color="primary" size="48" class="mr-3" v-if="!avatarImageUrl">
                          <span style="color:white" class="text-uppercase font-weight-bold">{{ usernameInitial }}</span>
                        </v-avatar>
                        <v-avatar color="primary" size="48" class="mr-3" v-else>
                          <img :src="avatarImageUrl">
                        </v-avatar>
                      </v-col>

                      <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                        <v-text-field ref="address" v-model="memberFrom" label="Člen od:" filled readonly></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                        <v-text-field ref="surname" v-model="name" label="Prezívka" filled readonly></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                        <v-text-field ref="lastname" v-model="email" label="Email" filled readonly></v-text-field>
                      </v-col>

                      <!-- <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                          <div v-if="country == null">
                            <v-text-field value="-" ref="country" label="Krajina" readonly></v-text-field>
                          </div>
                          <div v-else>
                            <v-text-field ref="country" v-model="country" :items="countries" label="Krajina" readonly></v-text-field>
                          </div>
                        </v-col> -->
                    </v-row>
                  </v-card-text>

                  <v-divider class="mt-0" />

                  <v-card-actions>
                    <v-btn class="mr-3" color="primary">
                      <v-icon left dark>mdi-message-text-lock</v-icon>
                      Poslať súkromnú správu
                    </v-btn>

                    <v-btn class="mr-3" color="info" @click="sendFriendshipRequest(item)" v-if="friendship_status == '0'">
                      <v-icon>mdi-account-plus</v-icon>
                      <span class="ml-1">Poslať žiadosť o priateľstvo</span>
                    </v-btn>
                    <div v-else-if="friendship_status == '1'">
                      <v-btn class="mr-3" color="success">
                        <v-icon>mdi-account-check</v-icon>
                        <span class="ml-1">Priatelia</span>
                      </v-btn>
                      <v-btn class="mr-3" color="error" @click="removeFromFriendshipList(item)">
                        <v-icon>mdi-close-circle</v-icon>
                        <span class="ml-1">Zrušiť priateľstvo</span>
                      </v-btn>
                    </div>
                    <v-btn class="mr-3" color="warning" @click="acceptFriendshipRequest(item)" v-else-if="friendship_status == '2' && user_requested == actualUser">
                      <v-icon>mdi-arrow-right-bold</v-icon>
                      <span class="ml-1">Prijať žiadosť</span>
                    </v-btn>
                    <div v-else>
                      <v-btn class="mr-3" color="warning">
                        <v-icon>mdi-account-clock</v-icon>
                        <span class="ml-1">Žiadosť odoslaná</span>
                      </v-btn>
                      <v-btn class="mr-3" color="error" @click="removeFromFriendshipList(item)">
                        <v-icon>mdi-close-circle</v-icon>
                        <span class="ml-1">Zrušiť žiadosť</span>
                      </v-btn>
                    </div>
                  </v-card-actions>
                </v-card>
              </v-card>
            </v-dialog>
          </template>

          <template v-slot:item.id="{ item }">
            <v-btn class="mr-3" color="primary" @click="sendFriendshipRequest(item)" v-if="item.id">
              <v-icon>mdi-account-plus</v-icon>
              <span class="ml-1">Pridať priateľa</span>
            </v-btn>
          </template>
        </v-data-table>
      </v-card>
    </v-col>
  </v-row>
  <!-- </v-lazy> -->
</div>
</template>

<script>
import axios from 'axios'
import moment from 'moment'
export default {
  name: "AddFriends",
  components: {},
  data() {
    return {
      search: '',
      footerProps: {
        itemsPerPageText: 'Počet riadkov',
        itemsPerPageOptions: [5, 10, 15, 'Všetko'],
      },
      headerProps: {
        sortByText: "Zoradiť podľa"
      },
      headers: [{
          text: 'Meno',
          align: 'center',
          filterable: true,
          value: 'name',
        },
        {
          align: 'center',
          text: 'Status',
          value: 'id',
          filterable: false,
        },
      ],
      users: [],
      addFriend: false,
      myloadingvariable: true,
      dialogShowProfile: false,

      //user info
      avatarImageUrl: "",
      usernameInitial: '',
      name: '',
      email: '',
      memberFrom: '',
      friendship_status: '0',
      actualUser: localStorage.getItem("user_id"),

      overlay: true,
    }
  },

  mounted() {
    const api = `${process.env.VUE_APP_API_URL}/getAllPossibleFriends`;
    const config = {
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("authToken"),
      },
    };
    axios.get(api, config)
      .then(res => {
        console.log(res.data);
        this.myloadingvariable = false;
        this.overlay = false;
        this.users = res.data;
      });
  },

  methods: {
    sendFriendshipRequest(item) {
      this.myloadingvariable = true;
      const api = `${process.env.VUE_APP_API_URL}/friendships/sendFriendshipRequest`;
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };

      axios.post(api, {
            user_requested: item.id,
            friendship_status: '2'
          },
          config
        )
        .then((res) => {
          console.log(res);
          const api = `${process.env.VUE_APP_API_URL}/getAllPossibleFriends`;
          const config = {
            headers: {
              Accept: "application/json",
              Authorization: "Bearer " + localStorage.getItem("authToken"),
            },
          };
          axios.get(api, config)
            .then(res => {
              console.log(res.data);
              this.myloadingvariable = false;
              this.users = res.data;
            });
        })
    },

    removeFromFriendshipList(item) {
      console.log(item);
      this.friendship_status = 0;
      const api = `${process.env.VUE_APP_API_URL}/friendships/removeFromFriendshipList`;
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };

      axios.post(api, {
            requester: this.actualUser,
            user_requested: item.id,
          },
          config
        )
        .then((res) => {
          console.log(res);
        })
    },

    showProfile(item) {
      console.log(item);
      // this.$store.dispatch('showProfile', {
      //   avatar: item.avatar,
      //   created_at: item.created_at,
      //   email: item.email,
      //   id: item.id,
      //   name: item.name,
      //   status: item.status,
      //   // friendship_status: item.friendship_status,
      //   // requester: item.requester,
      //   // user_requested: item.user_requested,
      // })

      if (item.avatar) {
        this.avatarImageUrl = "http://127.0.0.1:8000/storage/user-avatar/" + item.avatar;
      }
      this.name = item.name;
      this.email = item.email;
      if (item.friendship_status != null) {
        this.friendship_status = item.friendship_status;
      } else {
        this.friendship_status = 0;
      }

      // this.requester = this.actualUser;
      // this.user_requested = item.id;
      this.memberFrom = moment(item.created_at)
        .format('YYYY-MM-DD');
      this.usernameInitial = item.name.charAt(0);

      //odoslanie hodnoty cez router
      // this.$router.push({
      //   name: 'ShowProfile',
      //   params: {
      //     userInfo: Object.assign({}, item)
      //   }
      // });
      // console.log(item);
      // this.$store.commit('userInfo', Object.assign({}, item));
      // this.$router.push("/profile/user_profile");
      //this.userInfo = Object.assign({}, item)

    },
  },

  created() {

  },

  computed: {

  }
}
</script>

<style type="scss">
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
