<template>
<div class="new w-100 h-100 text-uppercase mt-1">
  <v-lazy :options="{
            threshold: .8
          }" transition="fade-transition">
    <v-row justify="center" class="ml-0 mr-0">
      <v-col>
        <!-- <v-lazy v-model="isActive" :options="{
          threshold: .5
        }" min-height="200" transition="fade-transition"> -->
        <v-btn color="primary" icon width="170px" height="170px">
          <v-icon style="font-size: 150px">mdi-bell-cancel</v-icon>
        </v-btn>
        <!-- </v-lazy> -->
        <v-text-field v-model="form.recipient" label="meno">meno</v-text-field>
        <v-text-field v-model="form.text" label="text">text</v-text-field>
        <v-text-field v-model="form.status" label="status">status</v-text-field>
        <v-btn @click="methodName">odoslat</v-btn>
      </v-col>
    </v-row>
  </v-lazy>
</div>
</template>

<script>
import axios from 'axios';
export default {
  name: "New",
  components: {},
  data() {
    return {
      isActive: true,
      form: {
        recipient: null,
        text: null,
        status: null,
      },
      notif: [],
      notifCount: null
    }
  },

  mounted() {
    //do something after mounting vue instance
    const api = `http://127.0.0.1:8000/api/getNotification/${localStorage.getItem('user_id')}`;
    const config = {
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("authToken"),
      },
    };
    axios.get(api, config)
      .then(res => {
        this.notif = res.data;
        this.notifCount = res.data.length;
        this.$store.dispatch('notificationCounter', {
          notifCounter: this.notifCount
        });
      });
  },

  methods: {
    methodName() {
      console.log(this.form);
      const api = 'http://127.0.0.1:8000/api/sendNotification';
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };
      axios.post(api, {
          recipient: this.form.recipient,
          text: this.form.text,
          status: this.form.status
        }, config)
        .then(res => {
          console.log("res");
          console.log(res);
        })
    }
  },

  created() {
    //do something after creating vue instance
    //presence channel
    window.Echo.join('notif-channel')
      .listen('Notifi', (e) => {
        this.notif = e.notifications;
        console.log(e);
        this.notifCount += 1;
        this.$store.dispatch('notificationCounter', {
          notifCounter: this.notifCount
        });
        // this.notifCount = e.notifications.length;
      })
  },

  updated() {
    //do something after updating vue instance

  }
}
</script>

<style type="scss">
/* .md-empty-state {
    margin-top: 5rem !important;
  } */
@media only screen and (max-width: 550px) {
  .md-empty-state {
    width: 250px !important;
    height: 250px !important;
    padding: 0 !important;
  }
}
</style>
