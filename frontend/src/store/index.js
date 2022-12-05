import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    successRegisterAlert: {
      success: false
    },

    isLoggedOut: {
      username: '',
      logout: false
    },

    speedDialState: {
      state: false,
    },

    bottomNavigationState: {
      state: false,
    },

    autoDarkLightModeState: {
      state: false,
    },

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

    notificationCounter: 0,
    reservationCounter: 0,

    updatedPassword: false,

    msgUnreadCounter: 0,

    activatedAccount: false,

    contactListLoader: true,

    successMakeReservation: {
      success: false
    },

    successReservationData: {
      event_name: '',
      start_date: '',
      end_date: '',
      start_time: '',
      end_time: '',
      username: '',
    },

    selectedUser: {
      id: null,
      name: null,
      email: null,
      status: null,
      avatar: null,
      created_at: null,
      unread: null,
    },

    me: {
      id: null,
      name: null,
      email: null,
      status: null,
      avatar: null,
      created_at: null,
    },

    friendshipRequestAction: {
      status: null,
      text: null
    },

    ratingState: true,

    pendingReservation: 0,
  },
  getters: {
    successRegisterAlert: state => {
      return state.successRegisterAlert;
    },

    isLoggedOut: state => {
      return state.isLoggedOut
    },

    speedDialState: state => {
      return state.speedDialState
    },

    bottomNavigationState: state => {
      return state.bottomNavigationState
    },

    autoDarkLightModeState: state => {
      return state.autoDarkLightModeState
    },

    Data: state => {
      return state.userInformations;
    },

    notificationCounter: state => {
      return state.notificationCounter
    },

    reservationCounter: state => {
      return state.reservationCounter
    },

    updatedPassword: state => {
      return state.updatedPassword
    },

    msgUnreadCounter: state => {
      return state.msgUnreadCounter
    },

    activatedAccount: state => {
      return state.activatedAccount
    },

    contactListLoader: state => {
      return state.contactListLoader
    },

    successMakeReservation: state => {
      return state.successMakeReservation;
    },

    successReservationData: state => {
      return state.successReservationData;
    },

    selectedUser: state => {
      return state.selectedUser
    },

    me: state => {
      return state.me
    },

    friendshipRequestAction: state => {
      return state.friendshipRequestAction
    },

    ratingState: state => {
      return state.ratingState
    },

    pendingReservation: state => {
      return state.pendingReservation
    },


  },
  mutations: {
    mutationSuccessRegister: (state, payload) => {
      Vue.set(state.successRegisterAlert, 'success', payload.success);
    },

    mutationLogout: (state, payload) => {
      Vue.set(state.isLoggedOut, 'username', payload.username);
      Vue.set(state.isLoggedOut, 'logout', payload.logout);
    },

    mutationSpeedDialState: (state, payload) => {
      Vue.set(state.speedDialState, 'state', payload.status);
    },

    mutationBottomNavigationState: (state, payload) => {
      Vue.set(state.bottomNavigationState, 'state', payload.status);
    },

    mutationAutoDarkLightModeState: (state, payload) => {
      Vue.set(state.autoDarkLightModeState, 'state', payload.status);
    },

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

    mutationNotificationCounter: (state, payload) => {
      state.notificationCounter = payload.notifCounter
    },

    mutationReservationCounter: (state, payload) => {
      state.reservationCounter = payload.reservCounter
    },



    mutationUpdatedPassword: (state, payload) => {
      state.updatedPassword = payload.state;
    },

    mutationMsgUnreadCounter: (state, payload) => {
      state.msgUnreadCounter = payload.unreadCounter
    },

    mutationActivatedAccount: (state, payload) => {
      state.activatedAccount = payload.state
    },

    mutationContactListLoader: (state, payload) => {
      state.contactListLoader = payload.cancelLoader;
    },

    mutationSuccessReservation: (state, payload) => {
      Vue.set(state.successMakeReservation, 'success', payload.success);
    },

    mutationReservationData: (state, payload) => {
      Vue.set(state.successReservationData, 'event_name', payload.event_name);
      Vue.set(state.successReservationData, 'start_date', payload.start_date);
      Vue.set(state.successReservationData, 'end_date', payload.end_date);
      Vue.set(state.successReservationData, 'start_time', payload.start_time);
      Vue.set(state.successReservationData, 'end_time', payload.end_time);
      Vue.set(state.successReservationData, 'username', payload.username);
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

    mutationMe: (state, payload) => {
      Vue.set(state.me, 'id', payload.id);
      Vue.set(state.me, 'name', payload.name);
      Vue.set(state.me, 'email', payload.email);
      Vue.set(state.me, 'status', payload.status);
      Vue.set(state.me, 'avatar', payload.avatar);
      Vue.set(state.me, 'created_at', payload.created_at);
    },

    mutationFriendshipRequestAction: (state, payload) => {
      Vue.set(state.friendshipRequestAction, 'status', payload.status);
      Vue.set(state.friendshipRequestAction, 'text', payload.text);
    },

    mutationRatingState: (state, payload) => {
      state.ratingState = payload.state
    },

    mutationPendingReservation: (state, payload) => {
      state.pendingReservation = payload.count
    },
  },

  actions: {
    successRegister: (context, payload) => {
      context.commit('mutationSuccessRegister', payload)
    },

    isLoggedOut: (context, payload) => {
      context.commit('mutationLogout', payload)
    },

    speedDialState: (context, payload) => {
      context.commit('mutationSpeedDialState', payload)
    },

    bottomNavigationState: (context, payload) => {
      context.commit('mutationBottomNavigationState', payload)
    },

    autoDarkLightModeState: (context, payload) => {
      context.commit('mutationAutoDarkLightModeState', payload)
    },

    showProfile: (context, payload) => {
      context.commit('mutationShowProfile', payload)
    },

    notificationCounter: (context, payload) => {
      context.commit('mutationNotificationCounter', payload)
    },

    reservationCounter: (context, payload) => {
      context.commit('mutationReservationCounter', payload)
    },

    updatedPassword: (context, payload) => {
      context.commit('mutationUpdatedPassword', payload)
    },

    msgUnreadCounter: (context, payload) => {
      context.commit('mutationMsgUnreadCounter', payload)
    },

    activatedAccount: (context, payload) => {
      context.commit('mutationActivatedAccount', payload)
    },

    contactListLoader: (context, payload) => {
      context.commit('mutationContactListLoader', payload)
    },

    successReservation: (context, payload) => {
      context.commit('mutationSuccessReservation', payload)
    },

    reservationData: (context, payload) => {
      context.commit('mutationReservationData', payload)
    },

    selectedUser: (context, payload) => {
      context.commit('mutationSelectedUser', payload)
    },

    me: (context, payload) => {
      context.commit('mutationMe', payload)
    },

    friendshipRequestAction: (context, payload) => {
      context.commit('mutationFriendshipRequestAction', payload)
    },

    ratingState: (context, payload) => {
      context.commit('mutationRatingState', payload)
    },

    pendingReservation: (context, payload) => {
      context.commit('mutationPendingReservation', payload)
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