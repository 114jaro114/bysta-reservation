<template>
<div class="profile w-100 h-100">
  <!-- <v-lazy :options="{
            threshold: .4
          }" transition="scale-transition"> -->
  <v-overlay :value="overlay">
    <v-progress-circular indeterminate size="64"></v-progress-circular>
  </v-overlay>
  <v-row justify="center" class="ml-0 mr-0">
    <v-snackbar v-model="snackbar" :multi-line="multiLine" color="success" bottom right class="m-3">
      <v-icon>mdi-check-circle</v-icon>
      <span>{{text}}</span>
      <template v-slot:action="{ attrs }">
        <v-btn color="white" fab text small v-bind="attrs" @click="snackbar = false">
          <v-icon>mdi-close-circle</v-icon>
        </v-btn>
      </template>
    </v-snackbar>
    <v-col class="pl-3 pr-3">
      <!-- :loading="myloadingvariable" -->
      <v-card class="rounded" elevation="0">
        <v-card-title>
          <v-row v-if="user_acc_info == true">
            <v-col>
              <v-btn class="w-100" color="primary" disabled>
                Používateľský účet
              </v-btn>
            </v-col>
            <v-col>
              <v-btn class="w-100" outlined color="primary" @click="contact_inf()">
                Kontaktné informácie<v-icon>mdi-arrow-right-thick</v-icon>
              </v-btn>
            </v-col>
          </v-row>
          <v-row v-else>
            <!-- {{user_acc_info}} -->
            <v-col>
              <v-btn class="w-100" color="primary" @click="user_acc()">
                <v-icon>mdi-arrow-left-thick</v-icon>Používateľšký účet
              </v-btn>
            </v-col>
            <v-col>
              <v-btn class="w-100" outlined color="primary" disabled>
                Kontaktné informácie
              </v-btn>
            </v-col>
          </v-row>
        </v-card-title>

        <v-divider />

        <v-card-text>
          <div v-if="user_acc_info == true">
            <v-row justify="center" class="mb-3">
              <!-- <v-avatar color="blue" size="48" class="mr-3" v-if="!avatarImageUrl">
                  <span style="color:white">{{ usernameInitial }}</span>
                </v-avatar>
                <v-avatar color="blue" size="48" class="mr-3" v-else>
                  <img :src="avatarImageUrl">
                </v-avatar> -->

              <!-- <div v-if="showUploadProgress">
                  Uploading: {{ uploadPercent }} %
                </div> -->
              <v-col>
                <div class="image-upload">
                  <v-btn @change="updateAvatar($event)" color="primary" block class="p-0">
                    <v-icon>mdi-file-find</v-icon>
                    <label class="file-input-icon-profile" for="file-input">
                      Zmeniť profilovú fotku
                    </label>
                    <input type="file" id="file-input" name="avatar" ref="photo" accept="image/*" @change="updateAvatar($event)">
                  </v-btn>
                </div>
              </v-col>
              <v-col>
                <div class="user-from" block>
                  <v-btn disabled>
                    <span>Člen od: <span class="font-weight-bold">{{ memberFrom }}</span></span>
                  </v-btn>
                </div>
              </v-col>
            </v-row>

            <v-row justify="center">
              <v-form ref="form" v-model="valid" lazy-validation class="w-100">
                <v-col cols="12" sm="12" md="12" lg="12" class="pb-0">
                  <v-text-field ref="name" prepend-icon="mdi-account" v-model="name" :rules="nameRules" :error-messages="errorUsername" label="Meno" filled clearable @click:clear="callItBackUsername()" clear-icon="mdi-close" counter></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="12" lg="12" class="pb-0">
                  <v-text-field ref="email" prepend-icon="mdi-email" v-model="email" :rules="emailRules" :error-messages="errorEmail" label="Email" filled clearable @click:clear="callItBackEMail()" clear-icon="mdi-close" counter></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="12" lg="12" class="pb-0">
                  <v-text-field prepend-icon="mdi-lock" v-model="password" :append-icon="togglePassword ? 'mdi-eye' : 'mdi-eye-off'" :rules="passwordRules" :type="togglePassword ? 'text' : 'password'" label="Heslo" hint="Minimálne 4 znaky" counter
                    @click:append="togglePassword = !togglePassword" filled clearable clear-icon="mdi-close"></v-text-field>
                </v-col>
                <!-- <v-col cols="12" sm="12" md="12" lg="12" class="pb-0">
                    <v-text-field prepend-icon="mdi-lock" v-model="confirmPassword" :append-icon="togglePasswordConfirm ? 'mdi-eye' : 'mdi-eye-off'" :rules="confirmPasswordRules.concat(passwordConfirmationRule)"
                      :type="togglePasswordConfirm ? 'text' : 'password'" label="Heslo znova" hint="Minimálne 4 znaky" counter @click:append="togglePasswordConfirm = !togglePasswordConfirm" filled clearable clear-icon="mdi-close"></v-text-field>
                  </v-col> -->
              </v-form>
              <!-- <v-col cols="12" sm="12" md="12" lg="12" class="pb-0">
                  <v-text-field v-model="name" label="Meno" prepend-icon="mdi-account" earable :rules="rules" counter="15" filled clearable></v-text-field>
                </v-col>

                <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                  <v-text-field v-model="email" label="Email" prepend-icon="mdi-email" :rules="rules" counter="25" filled clearable></v-text-field>
                </v-col>

                <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                  <v-text-field v-model="password" label="Heslo" prepend-icon="mdi-lock" :rules="rules" counter="25" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" hint="Minimálne 4 znaky" @click:append="show1 = !show1"
                    :type="show1 ? 'text' : 'password'" filled clearable>
                  </v-text-field>
                </v-col> -->
            </v-row>
          </div>
          <div v-else>
            <v-row justify="center">
              <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                <v-text-field ref="surname" v-model="surname" label="Meno" counter clearable filled required></v-text-field>
              </v-col>

              <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                <v-text-field ref="lastname" v-model="lastname" label="Priezvisko" counter clearable filled required></v-text-field>
              </v-col>

              <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                <v-text-field ref="address" v-model="address" label="Adresa" counter clearable filled required></v-text-field>
              </v-col>

              <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                <v-text-field ref="city" v-model="city" label="Mesto" counter clearable filled required></v-text-field>
              </v-col>

              <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                <v-text-field ref="postcode" v-model="postcode" label="PSČ" counter clearable filled required></v-text-field>
              </v-col>

              <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                <v-autocomplete :menu-props="autocompleteMenuProps()" ref="country" v-model="country" :items="countries" label="Krajina" counter clearable filled required>
                </v-autocomplete>
              </v-col>

              <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                <VueTelInputVuetify v-model="myPhone" :preferred-countries="['svk']" :valid-characters-only="true" @input="onInput" label="Mobilné číslo" placeholder="" counter filled clearable>
                </VueTelInputVuetify>
              </v-col>
            </v-row>
          </div>
        </v-card-text>

        <v-divider />

        <v-card-actions class="pt-0 pb-4 pl-4">
          <div v-if="user_acc_info == true">
            <v-btn color="primary" :loading="loadingBtn" @click="updateAccount" :disabled="disabledBtn">
              <v-icon left dark>mdi-check</v-icon>
              Uložiť zmeny
            </v-btn>
          </div>
          <div v-else>
            <v-btn color="primary" :loading="loadingBtn" @click="updateContactInfo">
              <v-icon left dark>mdi-update</v-icon>
              Aktualizovať kontaktné údaje
            </v-btn>
          </div>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
  <!-- </v-lazy> -->
</div>
</template>

<script>
import axios from 'axios'
import moment from 'moment';
import VueTelInputVuetify from "vue-tel-input-vuetify/lib/vue-tel-input-vuetify.vue"

export default {
  pageTitle: 'Profile',
  components: {
    VueTelInputVuetify
  },
  data() {
    return {
      snackbar: false,
      text: '',
      multiLine: true,
      disabledBtn: true,
      loadingBtn: false,
      loading: false,
      showAvatarPicker: false,
      uploadPercent: 0,
      avatarImageUrl: "",
      showUploadProgress: false,
      processingUpload: false,
      usernameInitial: localStorage.getItem('username')
        .charAt(0),
      memberFrom: '',
      name: '',
      nameRules: [
        v => !!v || 'Meno je povinné',
        v => (v && v.length <= 10) || 'Meno musí obsahovať max 10 znakov',
      ],
      email: '',
      emailRules: [
        v => !!v || 'E-mail je povinný',
        v => /.+@.+\..+/.test(v) || 'E-mail musí mať valídny tvar',
      ],
      password: '',
      passwordRules: [
        // v => !!v || 'Heslo je povinné',
        v => ((v && v.length >= 4) || v.length == 0) || 'Heslo musí obsahovať minimálne 4 znaky',
      ],
      // confirmPassword: '',
      // confirmPasswordRules: [
      //   v => !!v || 'Potvrdenie hesla je povinné',
      //   v => v.length >= 4 || 'Potvrdenie hesla musí obsahovať minimálne 4 znaky',
      //   v => v === this.password || 'Zadané hesla sa nezhodujú',
      // ],

      email2: '',
      name2: '',
      valid: true,
      togglePassword: false,
      // togglePasswordConfirm: false,
      errorUsername: [],
      errorEmail: [],
      checkName: '',
      checkEmail: '',
      //Password
      show1: false,

      // contact formular
      // contact form
      countries: ['Afghanistan', 'Albania', 'Algeria', 'Andorra', 'Angola', 'Anguilla', 'Antigua &amp; Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus',
        'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia &amp; Herzegovina', 'Botswana', 'Brazil', 'British Virgin Islands', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia', 'Cameroon', 'Cape Verde',
        'Cayman Islands', 'Chad', 'Chile', 'China', 'Colombia', 'Congo', 'Cook Islands', 'Costa Rica', 'Cote D Ivoire', 'Croatia', 'Cruise Ship', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic',
        'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Estonia', 'Ethiopia', 'Falkland Islands', 'Faroe Islands', 'Fiji', 'Finland', 'France', 'French Polynesia', 'French West Indies', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana',
        'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guam', 'Guatemala', 'Guernsey', 'Guinea', 'Guinea Bissau', 'Guyana', 'Haiti', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Isle of Man',
        'Israel', 'Italy', 'Jamaica', 'Japan', 'Jersey', 'Jordan', 'Kazakhstan', 'Kenya', 'Kuwait', 'Kyrgyz Republic', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia',
        'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Mauritania', 'Mauritius', 'Mexico', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Montserrat', 'Morocco', 'Mozambique', 'Namibia', 'Nepal', 'Netherlands',
        'Netherlands Antilles', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Norway', 'Oman', 'Pakistan', 'Palestine', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Poland', 'Portugal', 'Puerto Rico',
        'Qatar', 'Reunion', 'Romania', 'Russia', 'Rwanda', 'Saint Pierre &amp; Miquelon', 'Samoa', 'San Marino', 'Satellite', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'South Africa',
        'South Korea', 'Spain', 'Sri Lanka', 'St Kitts &amp; Nevis', 'St Lucia', 'St Vincent', 'St. Lucia', 'Sudan', 'Suriname', 'Swaziland', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', `Timor L'Este`, 'Togo',
        'Tonga', 'Trinidad &amp; Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks &amp; Caicos', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan', 'Venezuela', 'Vietnam',
        'Virgin Islands (US)', 'Yemen', 'Zambia', 'Zimbabwe'
      ],
      errorMessages: '',
      surname: null,
      lastname: null,
      address: null,
      city: null,
      postcode: null,
      country: null,
      myPhone: null,
      phone: {
        number: '',
        valid: false,
        country: undefined,
      },
      // comment: null,
      formHasErrors: false,
      myloadingvariable: true,
      user_acc_info: true,

      overlay: true,
    }
  },

  // computed: {
  //   passwordConfirmationRule() {
  //     return this.password === this.confirmPassword || "Zadané hesla sa nezhodujú";
  //   }
  // },

  watch: {
    name() {
      if (this.name != this.name2) {
        if (this.name) {
          axios.post(`${process.env.VUE_APP_API_URL}/checkIfUsernameExist`, {
              name: this.name
            })
            .then(valid => {
              this.errorUsername = valid.data;
              // this.errorUsername = valid ? [] : ['async error']
            });
        } else {
          this.errorUsername = '';
        }
      }
    },

    email() {
      if (this.email != this.email2) {
        if (/.+@.+\..+/.test(this.email)) {
          axios.post(`${process.env.VUE_APP_API_URL}/checkIfEMailExist`, {
              email: this.email
            })
            .then(valid => {
              this.errorEmail = valid.data;
              // this.errorEmail = valid ? [] : ['async error']
            });
        } else {
          this.errorEmail = '';
        }
      }
    }
  },

  mounted() {
    this.myloadingvariable = true;
    this.avatarImageUrl = this.avatarUrl;
    this.getAccData();
  },
  async created() {
    this.myloadingvariable = true;
    const api = `${process.env.VUE_APP_API_URL}/auth/user`;
    const config = {
      headers: {
        Accept: "application/json",
        // 'Content-Type': 'multipart/form-data',
        Authorization: "Bearer " + localStorage.getItem("authToken"),
      },
    };
    try {
      let res = await axios.get(api, config)
      this.email = res.data.email;
      this.email2 = res.data.email;
      this.name = localStorage.getItem("username");
      this.name2 = localStorage.getItem("username");
      this.errorEmail = '';
      this.errorUsername = '';
      this.memberFrom = moment(res.data.created_at)
        .format('YYYY-MM-DD');
      this.myloadingvariable = false;
      this.overlay = false;
    } catch (err) {
      console.log(err)
    }
    // axios.get(api, config)
    //   .then(res => {
    //     this.email = res.data.email;
    //     this.memberFrom = moment(res.data.created_at).format('YYYY-MM-DD');
    //   })
    //   .catch((error) => {
    //     console.log('error', Object.assign({}, error));
    //   });
  },

  updated() {
    //do something after updating vue instance
    // console.log(this.surname);
    // console.log(this.lastname);
    // console.log(this.address);
    // console.log(this.city);
    // console.log(this.postcode);
    // console.log(this.country);
    // console.log(this.phone);
  },

  methods: {
    //account settings
    validate() {
      return this.$refs.form.validate();
    },
    reset() {
      this.$refs.form.reset()
    },

    callItBackUsername() {
      this.errorUsername = [];
    },

    callItBackEmail() {
      this.errorEmail = [];
    },

    contact_inf() {
      this.user_acc_info = false;
    },

    user_acc() {
      this.user_acc_info = true;
    },
    onInput(formattedNumber, {
      number,
      valid,
      country
    }) {
      this.phone.number = number.international;
      this.phone.valid = valid;
      this.phone.country = country && country.name;
    },
    // contact formular
    autocompleteMenuProps() {
      // default properties copied from the vuetify-autocomplete docs
      let defaultProps = {
        closeOnClick: false,
        closeOnContentClick: false,
        disableKeys: true,
        openOnClick: false,
        maxHeight: 304,
      };

      if (this.$vuetify.breakpoint.smAndDown) {
        defaultProps.maxHeight = 112;
        defaultProps.top = true;
      }
      return defaultProps;
    },

    addressCheck() {
      //   this.errorMessages = this.address && !this.name ?
      //     `Hey! I'm required` :
      //     ''
      //
      return false
    },

    openAvatarPicker() {
      this.showAvatarPicker = true
    },
    selectAvatar(avatar) {
      this.form.avatar = avatar
    },

    updateAvatar(event) {
      if (this.$refs.photo) {
        this.myloadingvariable = true;
        this.showUploadProgress = true
        this.processingUpload = true
        this.uploadPercent = 0
        let formData = new FormData();
        formData.append('avatar', event.target.files[0]);
        const api = `${process.env.VUE_APP_API_URL}/upload_avatar`;
        const config = {
          headers: {
            Accept: "application/json",
            // 'Content-Type': 'multipart/form-data',
            Authorization: "Bearer " + localStorage.getItem("authToken"),
          },
        };
        // axios.post(api, formData, {
        //     onUploadProgress: (progressEvent) => {
        //       this.uploadPercent = progressEvent.lengthComputable ? Math.round((progressEvent.loaded * 100) / progressEvent.total) : 0;
        //     },
        //   }, config)
        axios.post(api, formData, config, {
            onUploadProgress: (progressEvent) => {
              this.uploadPercent = progressEvent.lengthComputable ? Math.round((progressEvent.loaded * 100) / progressEvent.total) : 0;
            }
          })
          .then((response) => {
            this.avatarImageUrl = response.data.avatar_url;
            this.showUploadProgress = false;
            this.processingUpload = false;
            this.myloadingvariable = false;
            this.$emit('imageUrl', response.data.secure_url);
          })
          .catch((error) => {
            if (error.response) {
              console.log(error.message)
            } else {
              console.log(error)
            }
            this.showUploadProgress = false
            this.processingUpload = false
          })
      }
    },

    updateAccount() {
      this.getAccData();
      const config = {
        headers: {
          Accept: "application/json",
          // 'Content-Type': 'multipart/form-data',
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };
      if (this.validate() && this.errorUsername.length == 0 && this.errorEmail.length == 0) {
        if (this.checkName != this.name || this.checkEmail != this.email) {
          this.loadingBtn = true;
          this.myloadingvariable = true;
          axios.post(`${process.env.VUE_APP_API_URL}/updateAccountSettings`, {
              email: this.email,
              name: this.name,
              password: this.password
            }, config)
            .then((resp) => {
              console.log(resp);
              this.snackbar = true;
              this.text = "Údaje boli úspešne zmenené.";
              this.loadingBtn = false;
              localStorage.setItem('username', this.name);
              // const api = `${process.env.VUE_APP_API_URL}/sendNotification`;
              // const config = {
              //   headers: {
              //     Accept: "application/json",
              //     Authorization: "Bearer " + localStorage.getItem("authToken"),
              //   },
              // };
              // axios.post(api, {
              //     recipient: res.data.user.id,
              //     title: "Chata Byšta",
              //     subtitle: "Vítame Vás na stránke chaty Byšta",
              //     text: "Pre akékoľvek informácie nás neváhajte kontaktovať cez messenger alebo email.",
              //     date: moment(new Date())
              //       .format('YYYY-MM-DD HH:mm'),
              //     status: "new",
              //   }, config)
              //   .then(() => {})

              this.myloadingvariable = false;
            })
            .catch(() => {
              // this.alertFail = true;
              this.myloadingvariable = false;
              // if (e.response.data.errors.name != null && e.response.data.errors.email != null) {
              //   this.alertFailText = 'Zadaný email a meno sú už použíté!';
              // } else if (e.response.data.errors.email != null) {
              //   this.alertFailText = 'Zadaný email je už použítý!';
              // } else if (e.response.data.errors.name != null) {
              //   this.alertFailText = 'Zadané meno je už použíté!';
              // }
            })
        }
      }
    },

    updateContactInfo() {
      const api = `${process.env.VUE_APP_API_URL}/contactForm`;
      const config = {
        headers: {
          Accept: "application/json",
          // 'Content-Type': 'multipart/form-data',
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };
      this.loadingBtn = true;
      this.myloadingvariable = true;
      axios.post(api, {
            surname: this.surname,
            lastname: this.lastname,
            address: this.address,
            city: this.city,
            postcode: this.postcode,
            country: this.country,
            phone: this.phone.number,
            // note: this.comment
          },
          config
        )
        .then(() => {
          this.snackbar = true;
          this.loadingBtn = false;
          this.text = "Kontaktné údaje boli úspešne aktualizované.";
          const api = `${process.env.VUE_APP_API_URL}/getContactForm`;
          const config = {
            headers: {
              Accept: "application/json",
              // 'Content-Type': 'multipart/form-data',
              Authorization: "Bearer " + localStorage.getItem("authToken"),
            },
          };
          axios.get(api, config)
            .then(res => {
              this.myloadingvariable = false;
              this.surname = res.data[0].surname;
              this.lastname = res.data[0].lastname;
              this.address = res.data[0].address;
              this.city = res.data[0].city;
              this.postcode = res.data[0].postcode;
              this.country = res.data[0].country;
              this.myPhone = res.data[0].phone;
            });
        })
        .catch(e => {
          console.log(e)
        })
    },

    getAccData() {
      const api = `${process.env.VUE_APP_API_URL}/auth/user`;
      const api2 = `${process.env.VUE_APP_API_URL}/getContactForm`;
      const config = {
        headers: {
          Accept: "application/json",
          // 'Content-Type': 'multipart/form-data',
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };

      axios.get(api, config)
        .then((response) => {
          if (response.data.avatar) {
            this.avatarImageUrl = "http://127.0.0.1:8000/storage/user-avatar/" + response.data.avatar;
            this.myloadingvariable = false;
            this.checkName = response.data.name;
            this.checkEmail = response.data.email;
            this.disabledBtn = false;
          }
        })
        .catch((error) => {
          console.log(error)
        })


      axios.get(api2, config)
        .then(res => {
          if (res.data.length != 0) {
            this.surname = res.data[0].surname;
            this.lastname = res.data[0].lastname;
            this.address = res.data[0].address;
            this.city = res.data[0].city;
            this.postcode = res.data[0].postcode;
            this.country = res.data[0].country;
            this.myPhone = res.data[0].phone;
          }
        });
    }
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

/* .image-upload {
  margin-right: 1rem;
} */

.user-from {
  margin-left: 1rem;
}

.vue-tel-input-vuetify .country-code {
  width: 85px !important;
}

.vue-tel-input-vuetify .country-code .v-text-field.v-text-field--enclosed {
  border-top-left-radius: 4px !important;
  border-top-right-radius: 0px !important;
}

.vue-tel-input-vuetify .v-text-field.v-text-field--enclosed {
  border-top-left-radius: 0px !important;
}

/* .menuable__content__active {
  top: 305px !important;
} */

/* @media screen and (max-width:767px) {
  .image-upload {
    margin-right: 0 !important;
  }

  .user-from {
    margin-left: 0 !important;
    margin-top: 10px;
  }
}

@media screen and (max-width:525px) {
  .image-upload {
    margin-right: 0 !important;
  }

  .user-from {
    margin-left: 0 !important;
    margin-top: 10px;
  }
} */
</style>
