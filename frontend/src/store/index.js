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
    }
    // userInformations: [],
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