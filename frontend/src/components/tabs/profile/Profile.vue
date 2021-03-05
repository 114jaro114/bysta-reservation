<template>
<div class="profile w-100 h-100 text-uppercase mt-1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <v-row justify="center" class="ml-0 mr-0">
    <v-col>
      <v-card elevation="2" :loading="myloadingvariable">
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
                Kontaktné informácie {{show1}}
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

              <div class="image-upload">
                <v-btn @change="updateAvatar($event)" color="primary" block>
                  <v-icon>mdi-file-find</v-icon>
                  <label class="file-input-icon-profile" for="file-input">
                    Zmeniť profilovú fotku
                  </label>
                  <input type="file" id="file-input" name="avatar" ref="photo" accept="image/*" @change="updateAvatar($event)">
                </v-btn>
              </div>

              <div class="user-from" block>
                <v-btn disabled>
                  <span>Člen od: <span class="font-weight-bold">{{ memberFrom }}</span></span>
                </v-btn>
              </div>
            </v-row>

            <v-row justify="center">
              <v-col cols="12" sm="12" md="12" lg="12" class="pb-0">
                <v-text-field v-model="name" label="Meno" prepend-icon="mdi-account" earable :rules="rules" counter="15" clearable></v-text-field>
              </v-col>

              <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                <v-text-field v-model="email" label="Email" prepend-icon="mdi-email" :rules="rules" counter="25" clearable></v-text-field>
              </v-col>

              <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                <v-text-field v-model="password" label="Heslo" prepend-icon="mdi-lock" :rules="rules" counter="25" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" hint="Minimálne 4 znaky" @click:append="show1 = !show1"
                  :type="show1 ? 'text' : 'password'" clearable>
                </v-text-field>
              </v-col>
            </v-row>
          </div>
          <div v-else>
            <v-row justify="center">
              <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                <v-text-field ref="surname" v-model="surname" label="Meno" counter clearable required></v-text-field>
              </v-col>

              <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                <v-text-field ref="lastname" v-model="lastname" label="Priezvisko" counter clearable required></v-text-field>
              </v-col>

              <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                <v-text-field ref="address" v-model="address" label="Adresa" counter clearable required></v-text-field>
              </v-col>

              <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                <v-text-field ref="city" v-model="city" label="Mesto" counter clearable required></v-text-field>
              </v-col>

              <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                <v-text-field ref="postcode" v-model="postcode" label="PSČ" counter clearable required></v-text-field>
              </v-col>

              <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                <v-autocomplete :menu-props="autocompleteMenuProps()" ref="country" v-model="country" :items="countries" label="Krajina" counter clearable required>
                </v-autocomplete>
              </v-col>

              <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                <VueTelInputVuetify v-model="myPhone" :preferred-countries="['svk']" :valid-characters-only="true" @input="onInput" label="Mobilné číslo" placeholder="" counter clearable></VueTelInputVuetify>
              </v-col>
            </v-row>
          </div>
        </v-card-text>

        <v-divider />

        <v-card-actions class="pt-0">
          <div v-if="user_acc_info == true">
            <v-btn color="primary" :loading="loading" @click.native="update">
              <v-icon left dark>mdi-check</v-icon>
              Uložiť zmeny
            </v-btn>
          </div>
          <div v-else>
            <v-btn color="primary" :loading="loading" @click="updateContactInfo">
              <v-icon left dark>mdi-update</v-icon>
              Aktualizovať kontaktné údaje
            </v-btn>
          </div>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</div>
</template>

<script>
import axios from 'axios'
import moment from 'moment';
import VueTelInputVuetify from "vue-tel-input-vuetify/lib/vue-tel-input-vuetify.vue"

const config = {
  headers: {
    Accept: "application/json",
    // 'Content-Type': 'multipart/form-data',
    Authorization: "Bearer " + localStorage.getItem("authToken"),
  },
};

export default {
  pageTitle: 'Profile',
  components: {
    VueTelInputVuetify
  },
  data() {
    return {
      loading: false,
      showAvatarPicker: false,
      uploadPercent: 0,
      avatarImageUrl: "",
      showUploadProgress: false,
      processingUpload: false,
      usernameInitial: localStorage.getItem('username')
        .charAt(0),
      name: localStorage.getItem("username"),
      email: '',
      password: '',
      memberFrom: '',
      rules: [v => v.length <= 25 || 'Max 25 characters'],
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
    }
  },

  mounted() {
    this.myloadingvariable = true;
    this.avatarImageUrl = this.avatarUrl;
    const api = 'http://127.0.0.1:8000/api/user';

    axios.get(api, config)
      .then((response) => {
        if (response.data.avatar) {
          this.avatarImageUrl = "http://127.0.0.1:8000/storage/user-avatar/" + response.data.avatar;
          this.myloadingvariable = false;
        }
      })
      .catch((error) => {
        console.log(error)
      })

    const api2 = 'http://127.0.0.1:8000/api/getContactForm';

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
  },
  async created() {
    this.myloadingvariable = true;
    const api = 'http://127.0.0.1:8000/api/auth/user';
    try {
      let res = await axios.get(api, config)
      this.email = res.data.email;
      this.memberFrom = moment(res.data.created_at)
        .format('YYYY-MM-DD');
      this.myloadingvariable = false;
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
    console.log(this.surname);
    console.log(this.lastname);
    console.log(this.address);
    console.log(this.city);
    console.log(this.postcode);
    console.log(this.country);
    console.log(this.phone);
  },

  methods: {
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
        const api = 'http://127.0.0.1:8000/api/upload_avatar';
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
            console.log(response);
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

    updateContactInfo() {
      const api = 'http://127.0.0.1:8000/api/contactForm';
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
        .then(resp => {
          console.log(resp);
          const api = 'http://127.0.0.1:8000/api/getContactForm';
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

.image-upload {
  margin-right: 1rem;
}

.user-from {
  margin-left: 1rem;
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
