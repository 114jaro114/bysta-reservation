import Vue from 'vue'
import VueRouter from 'vue-router'

import goTo from 'vuetify/es5/services/goto'
// import {
//   isLoggedIn
// } from '../utils/auth'

//auth
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import ForgotPassword from '../views/ForgotPassword.vue'
import ResetPassword from '../views/ResetPassword.vue'
import VerificationAccount from '../views/VerificationAccount.vue'
import AvatarImage from '../views/AvatarImage.vue'

//views
import Welcome from '../views/Welcome.vue'
import Home from '../views/Home.vue'
import Profile from '../views/Profile.vue'
import Notifications from '../views/Notifications.vue'
import Inbox from '../views/Inbox.vue'
import Settings from '../views/Settings.vue'
import Reservation from '../views/Reservation.vue'
import Administration from '../views/Administration.vue'
import Messenger from '../views/Messenger.vue'
import PriceList from '../views/PriceList.vue'
import SavedReservations from '../views/SavedReservations.vue'
import Contact from '../views/Contact.vue'

Vue.use(VueRouter)

const routes = [{
    path: '/',
    name: 'Welcome',
    component: Welcome,
    // meta: {
    //   allowAnonymous: true
    // },
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    // meta: {
    //   allowAnonymous: true
    // },
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
    // meta: {
    //   allowAnonymous: true
    // },
  },
  {
    path: '/forgot-password',
    name: 'ForgotPassword',
    component: ForgotPassword,
    // meta: {
    //   allowAnonymous: true
    // },
  },
  {
    path: '/reset-password/:token',
    name: 'ResetPassword',
    component: ResetPassword,
    // meta: {
    //   allowAnonymous: true
    // },
  },
  {
    path: '/activation-account/:token',
    name: 'VerificationAccount',
    component: VerificationAccount,
    // meta: {
    //   allowAnonymous: true
    // },
  },
  {
    path: '/home',
    name: 'Home',
    component: Home,
    children: [{
        path: '/home',
        name: 'Domov',
        component: require('../components/tabs/home/Domov.vue')
          .default
      },
      {
        path: '/home/lokalita',
        name: 'Mapa',
        component: require('../components/tabs/home/Mapa.vue')
          .default
      },
      {
        path: '/home/recenzie',
        name: 'Hodnotenie',
        component: require('../components/tabs/home/Hodnotenie.vue')
          .default
      },
      {
        path: '/home/vybavenie',
        name: 'Vybavenie',
        component: require('../components/tabs/home/Vybavenie.vue')
          .default
      },
    ],
  },
  {
    path: '/profile',
    name: 'Profile',
    component: Profile,
    children: [{
        path: '/profile',
        name: 'Profile',
        component: require('../components/tabs/profile/Profile.vue')
          .default
      },
      // {
      //   path: '/profile/my_profile',
      //   name: 'MyProfile',
      //   component: require('../components/tabs/profile/MyProfile.vue')
      //     .default
      // },
      {
        path: '/profile/add_friends',
        name: 'AddFriends',
        component: require('../components/tabs/profile/AddFriends.vue')
          .default
      }, {
        path: '/profile/user_profile',
        name: 'ShowProfile',
        component: require('../components/tabs/profile/ShowProfile.vue')
          .default,
        props: true
      },
      {
        path: '/profile/friend_list',
        name: 'FriendList',
        component: require('../components/tabs/profile/FriendList.vue')
          .default
      }
    ],
  },
  {
    path: '/notifications',
    name: 'Notifications',
    component: Notifications,
    children: [{
        path: '/notifications',
        name: 'All',
        component: require('../components/tabs/notifications/All.vue')
          .default
      },
      {
        path: '/notifications/new',
        name: 'New',
        component: require('../components/tabs/notifications/New.vue')
          .default
      },
      {
        path: '/notifications/relevant',
        name: 'Relevant',
        component: require('../components/tabs/notifications/Relevant.vue')
          .default
      }
    ],
  },
  {
    path: '/inbox',
    name: 'Inbox',
    component: Inbox,
    children: [{
        path: '/inbox',
        name: 'Sent',
        component: require('../components/tabs/inbox/Sent.vue')
          .default
      },
      {
        path: '/inbox/delivered',
        name: 'Delivered',
        component: require('../components/tabs/inbox/Delivered.vue')
          .default
      },
      {
        path: '/inbox/relevant',
        name: 'Relevant',
        component: require('../components/tabs/inbox/Relevant.vue')
          .default
      }
    ],
  },
  {
    path: '/settings',
    name: 'Settings',
    component: Settings,
    children: [{
        path: '/settings',
        name: 'AppSettings',
        component: require('../components/tabs/settings/AppSettings.vue')
          .default
      },
      {
        path: '/settings/info',
        name: 'Informations',
        component: require('../components/tabs/settings/Informations.vue')
          .default
      },
    ],
  }, {
    path: '/administration',
    name: 'Administration',
    component: Administration,
    children: [{
        path: '/administration',
        name: 'MojeRezervacie',
        component: require('../components/tabs/administration/MojeRezervacie.vue')
          .default
      },
      {
        path: '/administration/details',
        name: 'Details',
        component: require('../components/tabs/administration/Details.vue')
          .default
      },
      {
        path: '/administration/prices',
        name: 'Ceny',
        component: require('../components/tabs/administration/Ceny.vue')
          .default
      },
    ],
  }, {
    path: '/reservation',
    name: 'Reservation',
    component: Reservation,
    children: [{
      path: '/reservation',
      name: 'VytvoritRezervaciu',
      component: require('../components/tabs/reservation/VytvoritRezervaciu.vue')
        .default
    }, ],
  }, {
    path: '/messenger',
    name: 'Messenger',
    component: Messenger
  },
  // {
  //   path: '/profile/user_profile',
  //   name: 'ShowProfile',
  //   component: require('../components/tabs/profile/ShowProfile.vue')
  //     .default,
  //   props: true
  // },
  {
    path: '/saved_reservations',
    name: 'SavedReservations',
    component: SavedReservations
  }, {
    path: '/price_list',
    name: 'PriceList',
    component: PriceList
  }, {
    path: '/contact',
    name: 'Contact',
    component: Contact
  }, {
    path: '/avatar',
    name: 'AvatarImage',
    component: AvatarImage
  },
  //socialite
  {
    path: '/auth/:provide/callback',
    component: {
      template: '<div class="auth-component"></div>'
    }
  },
]

const router = new VueRouter({
  scrollBehavior: (to, from, savedPosition) => {
    let scrollTo = 0

    if (to.hash) {
      scrollTo = to.hash
    } else if (savedPosition) {
      scrollTo = savedPosition.y
    }

    return goTo(scrollTo)
  },

  mode: 'history', //eliminates # thing from the URL.
  // base: process.env.BASE_URL,
  routes
})

// router.beforeResolve((to, from, next) => {
//
//   if (to.matched.some(record => record.meta.middlewareAuth)) {
//         if (!AuthData.check()) {
//             next('/login');
//
//             return;
//         }
//     }
//  }
// })


// router.beforeEach((to, from, next) => {
//   if (((to.name == 'Login') || (to.name == 'Register') || (to.name == 'Welcome')) && isLoggedIn()) {
//     next({
//       path: '/home'
//     })
//   } else if (!to.meta.allowAnonymous && !isLoggedIn()) {
//     next({
//       path: '/login',
//     })
//   } else {
//     next()
//   }
// })
export default router