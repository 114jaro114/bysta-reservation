<template>
<div class="add_friends w-100 h-100 text-uppercase secondary-color mt-3">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <div class="row justify-content-center mr-0 ml-0">
    <div class="col">
      <v-card elevation="0">
        <v-card-title>
          <v-text-field v-model="search" append-icon="mdi-magnify" label="Vyhľadať" single-line hide-details></v-text-field>
        </v-card-title>
        <v-data-table no-data-text="Nenašli sa žiadny používateľia" :header-props="headerProps" :footer-props="footerProps" :headers="headers" :items="users" :search="search" item-key="name" :loading="myloadingvariable"
          loading-text="Načítavanie... Prosím počkajte">
          <template v-slot:item.name="{ item }">
            <v-btn class="mr-3" @click="showProfile(item)">
              <v-icon>mdi-account</v-icon>
              <span>{{item.name}}</span>
            </v-btn>
          </template>

          <template v-slot:item.id="{ item }">
            <v-btn class="mr-3" color="primary" @click="sendFriendshipRequest(item)" v-if="item.id">
              <v-icon>mdi-account-plus</v-icon>
              <span class="ml-1">Pridať priateľa</span>
            </v-btn>
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
          align: 'start',
          filterable: true,
          value: 'name',
        },
        {
          text: 'Status',
          value: 'id',
          filterable: false,
        },
      ],
      users: [],
      addFriend: false,
      myloadingvariable: true,
    }
  },

  mounted() {
    const api = 'http://127.0.0.1:8000/api/getAllPossibleFriends';
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
    sendFriendshipRequest(item) {
      this.myloadingvariable = true;
      const api = 'http://127.0.0.1:8000/api/friendships/sendFriendshipRequest';
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
          const api = 'http://127.0.0.1:8000/api/getAllPossibleFriends';
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
    showProfile(item) {
      console.log(item);
      this.$store.dispatch('showProfile', {
        avatar: item.avatar,
        created_at: item.created_at,
        email: item.email,
        id: item.id,
        name: item.name,
        status: item.status,
        // friendship_status: item.friendship_status,
        // requester: item.requester,
        // user_requested: item.user_requested,
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

  computed: {

  }
}
</script>

<style type="scss">
</style>
