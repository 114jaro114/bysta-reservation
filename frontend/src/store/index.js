import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    userInfo: {
      avatar: '',
      created_at: '',
      email: '',
      id: '',
      name: '',
      status: '',
      friendship_status: '',
      user_requested: '',
      requester: '',
    },
    successRegisterAlert: {
      success: false
    },
    successMakeReservation: {
      success: false
    },

    successReservationData: {
      event_name: '',
      start_date: '',
      end_date: '',
      color: '',
      username: '',
    },

    speedDialState: {
      test: false,
    },

    isLoggedOut: {
      username: '',
      logout: false
    }
  },
  getters: {
    Data: state => {
      return state.userInformations;
    },

    successRegisterAlert: state => {
      return state.successRegisterAlert;
    },

    successMakeReservation: state => {
      return state.successMakeReservation;
    },

    successReservationData: state => {
      return state.successReservationData;
    },

    speedDialState: state => {
      return state.speedDialState
    },

    gettersIsLoggedOut: state => {
      return state.isLoggedOut
    }
  },
  mutations: {
    showProfile: (state, payload) => {
      if (payload.id) {
        Vue.set(state.userInfo, 'avatar', payload.avatar);
        Vue.set(state.userInfo, 'created_at', payload.created_at);
        Vue.set(state.userInfo, 'email', payload.email);
        Vue.set(state.userInfo, 'id', payload.id);
        Vue.set(state.userInfo, 'name', payload.name);
        Vue.set(state.userInfo, 'status', payload.status);
        Vue.set(state.userInfo, 'friendship_status', payload.friendship_status);
        Vue.set(state.userInfo, 'requester', payload.requester);
        Vue.set(state.userInfo, 'user_requested', payload.user_requested);
        // state.userInformations.push(state.userInfo);
        localStorage.setItem("userInformations", JSON.stringify(state.userInfo));
      }
    },

    successRegister: (state, payload) => {
      Vue.set(state.successRegisterAlert, 'success', payload.success);
    },

    successReservation: (state, payload) => {
      Vue.set(state.successMakeReservation, 'success', payload.success);
    },

    reservationData: (state, payload) => {
      Vue.set(state.successReservationData, 'event_name', payload.event_name);
      Vue.set(state.successReservationData, 'start_date', payload.start_date);
      Vue.set(state.successReservationData, 'end_date', payload.end_date);
      Vue.set(state.successReservationData, 'color', payload.color);
      Vue.set(state.successReservationData, 'username', payload.username);
    },

    speedDialState2: (state, payload) => {
      Vue.set(state.speedDialState, 'test', payload.status);
    },


    mutationLogout: (state, payload) => {
      Vue.set(state.isLoggedOut, 'username', payload.username);
      Vue.set(state.isLoggedOut, 'logout', payload.logout);
    },

    // mutationLogout: (state, payload) => {
    //   state.username = payload.username;
    // }
  },
  actions: {
    showProfile: (context, payload) => {
      context.commit('showProfile', payload)
    },

    successRegister: (context, payload) => {
      context.commit('successRegister', payload)
    },

    successReservation: (context, payload) => {
      context.commit('successReservation', payload)
    },

    reservationData: (context, payload) => {
      context.commit('reservationData', payload)
    },

    speedDialState2: (context, payload) => {
      context.commit('speedDialState2', payload)
    },

    mutationLogout: (context, payload) => {
      context.commit('mutationLogout', payload)
    }
  }
});


///state ->pristup k udajom
// mounted () {
//    console.log(this.$store.state.user.username);
// },

// getter
// mounted () {
//    console.log(this.$store.getters.firstName);
// }