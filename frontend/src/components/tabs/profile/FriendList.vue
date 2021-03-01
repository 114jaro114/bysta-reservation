<template>
<div class="friend_list w-100 h-100 text-uppercase secondary-color mt-3">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <div class="row justify-content-center mr-0 ml-0">
    <div class="col">
      <v-card elevation="0">
        <v-card-title>
          <v-text-field v-model="search" append-icon="mdi-magnify" label="Vyhľadať" single-line hide-details></v-text-field>
        </v-card-title>
        <v-data-table no-data-text="Nenašli sa žiadny priatelia" :header-props="headerProps" :footer-props="footerProps" :headers="headers" :items="users" :search="search" item-key="name" :loading="myloadingvariable"
          loading-text="Načítavanie... Prosím počkajte">
          <template v-slot:item.name="{ item }">
            <v-btn class="mr-3" @click="showProfile(item)">
              <v-icon>mdi-account</v-icon>
              <span>{{item.name}}</span>
            </v-btn>
          </template>

          <template v-slot:item.status="{ item }">
            <v-icon style="color:red" v-if="item.status == 'offline'">mdi-checkbox-blank-circle</v-icon>
            <v-icon style="color:green" v-else>mdi-checkbox-blank-circle</v-icon>
            <span>{{item.status}}</span>
          </template>

          <template v-slot:item.friendship_status="{ item }">
            <v-btn class="mr-3" color="info" @click="sendFriendshipRequest(item)" v-if="item.friendship_status == '0'">
              <v-icon>mdi-account-plus</v-icon>
              <span class="ml-1">Pridať priateľa</span>
            </v-btn>
            <div v-else-if="item.friendship_status == '1'">
              <v-btn class="mr-3" color="success">
                <v-icon>mdi-account-check</v-icon>
                <span class="ml-1">Priatelia</span>
              </v-btn>
              <v-btn class="mr-3" color="error" @click="removeFromFriendshipList(item)">
                <v-icon>mdi-close-circle</v-icon>
                <span class="ml-1">Zrušiť priateľstvo</span>
              </v-btn>
            </div>
            <v-btn class="mr-3" color="warning" @click="acceptFriendshipRequest(item)" v-else-if="item.friendship_status == '2' && item.user_requested == actualUser">
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
                <span class="ml-1">Zrušiť žiadosť o priateľstvo</span>
              </v-btn>
            </div>
          </template>
        </v-data-table>
      </v-card>
    </div>
  </div>
</div>
</template>

<script>
import axios from 'axios'
export default {
  name: "FriendList",
  components: {},
  data() {
    return {
      search: '',
      footerProps: {
        itemsPerPageText: 'Počet riadkov',
        itemsPerPageOptions: [5, 10, 15, -1],
      },
      headerProps: {
        sortByText: "Zoradiť podľa"
      },
      headers: [{
          text: 'Status',
          align: 'start',
          filterable: false,
          sortable: false,
          value: 'status',
        },
        {
          text: 'Meno',
          value: 'name',
        },
        {
          text: 'Stav',
          value: 'friendship_status',
          sortable: false,
        }
      ],
      actualUser: localStorage.getItem("user_id"),
      users: [],
      myloadingvariable: true,
    }
  },

  mounted() {
    const api = 'http://127.0.0.1:8000/api/friendships';
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
  },

  methods: {
    acceptFriendshipRequest(item) {
      console.log(item);
      const api = 'http://127.0.0.1:8000/api/friendships/acceptFriendshipRequest';
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };

      axios.post(api, {
            requester: item.id,
            user_requested: item.user_requested,
            friendship_status: '1'
          },
          config
        )
        .then((res) => {
          console.log(res);
        })
    },

    removeFromFriendshipList(item) {
      this.myloadingvariable = true;
      const api = 'http://127.0.0.1:8000/api/friendships/removeFromFriendshipList';
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };

      axios.post(api, {
            requester: item.requester,
            user_requested: item.user_requested,
          },
          config
        )
        .then((res) => {
          console.log(res);
          const api = 'http://127.0.0.1:8000/api/friendships';
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
    // triggerFunction: function(title,description,price,calories){
    //   this.$store.dispatch('triggerFunction', {
    //       title: title,
    //       description: description,
    //       price: price,
    //       calories: calories
    //   }),
    showProfile(item) {
      console.log(item);
      this.$store.dispatch('showProfile', {
        avatar: item.avatar,
        created_at: item.created_at,
        email: item.email,
        id: item.id,
        name: item.name,
        status: item.status,
        friendship_status: item.friendship_status,
        requester: item.requester,
        user_requested: item.user_requested,
      })

      //odoslanie hodnoty cez router
      // this.$router.push({
      //   name: 'ShowProfile',
      //   params: {
      //     userInfo: Object.assign({}, item)
      //   }
      // });
      // console.log(item);
      // this.$store.commit('userInfo', Object.assign({}, item));
      this.$router.push("/profile/user_profile");
      //this.userInfo = Object.assign({}, item)

    },
  },

  created() {

  },

  computed: {}
}
</script>

<style type="scss">
.md-conente {
  padding: unset !important;
}

.md-table-fixed-header {
  padding-right: 0 !important;
  margin: auto;
}

.md-table .md-table-content {
  padding: 0 !important;
}

.md-table-head {
  text-align: center !important;
}

.md-table-empty-state {
  width: 0 !important;
  height: 0 !important;
  margin-top: 0 !important
}

.friend_list .md-empty-state {
  padding: 0 !important;
}

.friend_list .md-content {
  min-height: auto !important;
}
</style>
