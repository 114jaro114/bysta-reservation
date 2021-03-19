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
      state: false,
    },

    bottomNavigationState: {
      state: false,
    },

    isLoggedOut: {
      username: '',
      logout: false
    },

    contactListLoader: true,

    selectedUser: {
      id: null,
      name: null,
      email: null,
      status: null,
      avatar: null,
      created_at: null,
      unread: null,
    },

    notificationCounter: null,
    msgUnreadCounter: 0,
    ratingState: true,
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

    bottomNavigationState: state => {
      return state.bottomNavigationState
    },

    isLoggedOut: state => {
      return state.isLoggedOut
    },

    contactListLoader: state => {
      return state.contactListLoader
    },

    selectedUser: state => {
      return state.selectedUser
    },

    notificationCounter: state => {
      return state.notificationCounter
    },

    msgUnreadCounter: state => {
      return state.msgUnreadCounter
    },

    ratingState: state => {
      return state.ratingState
    },
  },
  mutations: {
    mutationShowProfile: (state, payload) => {
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

    mutationSuccessRegister: (state, payload) => {
      Vue.set(state.successRegisterAlert, 'success', payload.success);
    },

    mutationSuccessReservation: (state, payload) => {
      Vue.set(state.successMakeReservation, 'success', payload.success);
    },

    mutationReservationData: (state, payload) => {
      Vue.set(state.successReservationData, 'event_name', payload.event_name);
      Vue.set(state.successReservationData, 'start_date', payload.start_date);
      Vue.set(state.successReservationData, 'end_date', payload.end_date);
      Vue.set(state.successReservationData, 'color', payload.color);
      Vue.set(state.successReservationData, 'username', payload.username);
    },

    mutationSpeedDialState: (state, payload) => {
      Vue.set(state.speedDialState, 'state', payload.status);
    },

    mutationBottomNavigationState: (state, payload) => {
      Vue.set(state.bottomNavigationState, 'state', payload.status);
    },

    mutationLogout: (state, payload) => {
      Vue.set(state.isLoggedOut, 'username', payload.username);
      Vue.set(state.isLoggedOut, 'logout', payload.logout);
    },

    mutationContactListLoader: (state, payload) => {
      state.contactListLoader = payload.cancelLoader;
    },

    mutationSelectedUser: (state, payload) => {
      Vue.set(state.selectedUser, 'id', payload.id);
      Vue.set(state.selectedUser, 'name', payload.name);
      Vue.set(state.selectedUser, 'email', payload.email);
      Vue.set(state.selectedUser, 'status', payload.status);
      Vue.set(state.selectedUser, 'avatar', payload.avatar);
      Vue.set(state.selectedUser, 'created_at', payload.created_at);
      Vue.set(state.selectedUser, 'unread', payload.unread);
    },

    mutationNotificationCounter: (state, payload) => {
      state.notificationCounter = payload.notifCounter
    },

    mutationMsgUnreadCounter: (state, payload) => {
      state.msgUnreadCounter = payload.unreadCounter
    },

    mutationRatingState: (state, payload) => {
      state.ratingState = payload.state
    },
  },
  actions: {
    showProfile: (context, payload) => {
      context.commit('mutationShowProfile', payload)
    },

    successRegister: (context, payload) => {
      context.commit('mutationSuccessRegister', payload)
    },

    successReservation: (context, payload) => {
      context.commit('mutationSuccessReservation', payload)
    },

    reservationData: (context, payload) => {
      context.commit('mutationReservationData', payload)
    },

    speedDialState: (context, payload) => {
      context.commit('mutationSpeedDialState', payload)
    },

    bottomNavigationState: (context, payload) => {
      context.commit('mutationBottomNavigationState', payload)
    },

    isLoggedOut: (context, payload) => {
      context.commit('mutationLogout', payload)
    },
    contactListLoader: (context, payload) => {
      context.commit('mutationContactListLoader', payload)
    },

    selectedUser: (context, payload) => {
      context.commit('mutationSelectedUser', payload)
    },

    notificationCounter: (context, payload) => {
      context.commit('mutationNotificationCounter', payload)
    },

    msgUnreadCounter: (context, payload) => {
      context.commit('mutationMsgUnreadCounter', payload)
    },

    ratingState: (context, payload) => {
      context.commit('mutationRatingState', payload)
    },
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