<template>
<div class="row justify-content-center mr-0 ml-0">
  <div class="col">
    <v-card elevation="0">
      <v-card-title>
        <v-row v-if="pu == true">
          <v-col class="pl-0 pr-0">
            <v-btn class="w-100" color="info" disabled>
              Používateľský účet
            </v-btn>
          </v-col>
          <v-col class="pl-0 pr-0">
            <v-btn class="w-100" outlined color="blue" @click="contact_inf()">
              Kontaktné informácie<v-icon>mdi-arrow-right-thick</v-icon>
            </v-btn>
          </v-col>
        </v-row>
        <v-row v-else>
          <v-col class="pl-0 pr-0">
            <v-btn class="w-100" color="info" @click="user_acc()">
              <v-icon>mdi-arrow-left-thick</v-icon>Používateľšký účet
            </v-btn>
          </v-col>
          <v-col class="pl-0 pr-0">
            <v-btn class="w-100" outlined color="blue" disabled>
              Kontaktné informácie
            </v-btn>
          </v-col>
        </v-row>
      </v-card-title>

      <v-divider class="mb-0" />

      <v-card-text>
        <div class="" v-if="pu == true">
          <v-row justify="center" class="mt-3 mb-3">
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
              <v-btn @change="updateAvatar($event)" block>
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
            <v-text-field v-model="name" label="Meno" prepend-icon="mdi-account" earable :rules="rules" counter="15" clearable clear-icon="mdi-close-circle"></v-text-field>
            <v-text-field v-model="email" label="Email" prepend-icon="mdi-email" :rules="rules" counter="25" clearable clear-icon="mdi-close-circle"></v-text-field>
            <v-text-field v-model="password" label="Heslo" prepend-icon="mdi-lock" :rules="rules" counter="25" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" hint="Minimálne 4 znaky" @click:append="show1 = !show1"
              :type="show1 ? 'text' : 'password'" clearable clear-icon="mdi-close-circle">
            </v-text-field>
          </v-row>
        </div>
        <div v-else>
          <v-row justify="center">
            <v-col cols="12" sm="12" md="6" lg="6">
              <v-text-field ref="surname" v-model="surname" :rules="[() => !!surname || 'This field is required']" :error-messages="errorMessages" label="Meno" clearable clear-icon="mdi-close-circle" required></v-text-field>
            </v-col>

            <v-col cols="12" sm="12" md="6" lg="6">
              <v-text-field ref="lastname" v-model="lastname" :rules="[() => !!lastname || 'This field is required']" :error-messages="errorMessages" label="Priezvisko" clearable clear-icon="mdi-close-circle" required></v-text-field>
            </v-col>
          </v-row>


          <v-text-field ref="address" v-model="address" :rules="[() => !!address || 'This field is required',
                    () => !!address && address.length <= 25 || 'Address must be less than 25 characters',
                    addressCheck]" label="Adresa" counter="25" clearable clear-icon="mdi-close-circle" required></v-text-field>
          <v-row justify="center">
            <v-col cols="12" sm="12" md="6" lg="6">
              <v-text-field ref="city" v-model="city" :rules="[() => !!city || 'This field is required', addressCheck]" label="Mesto" clearable clear-icon="mdi-close-circle" required></v-text-field>
            </v-col>

            <v-col cols="12" sm="12" md="6" lg="6">
              <v-text-field ref="zip" v-model="zip" :rules="[() => !!zip || 'This field is required']" label="PSČ" clearable clear-icon="mdi-close-circle" required></v-text-field>
            </v-col>
          </v-row>
          <v-autocomplete :menu-props="autocompleteMenuProps()" ref="country" v-model="country" :rules="[() => !!country || 'This field is required']" :items="countries" label="Krajina" clearable clear-icon="mdi-close-circle" required>
          </v-autocomplete>

          <VueTelInputVuetify v-model="myPhone" :preferred-countries="['svk']" :valid-characters-only="true" @input="onInput" label="Mobilné číslo" placeholder="" clearable clear-icon="mdi-close-circle"></VueTelInputVuetify>
          <div v-if="phone.number" style="color: #e83e8c">
            <span>
              Number:
              <strong>{{ phone.number }}</strong>,&nbsp;
            </span>
            <span>
              Is valid:
              <strong>{{ phone.valid }}</strong>,&nbsp;
            </span>
            <span>
              Country:
              <strong>{{ phone.country }}</strong>
            </span>
          </div>
          <v-textarea v-model="comment" :rules="[() => !!comment && comment.length <= 25 || 'Address must be less than 50 characters']" label=" Poznámka" rows="1" counter="50" clearable clear-icon="mdi-close-circle">
          </v-textarea>
        </div>
      </v-card-text>

      <v-divider />

      <v-card-actions>
        <div v-if="pu == true">
          <v-btn color="info" :loading="loading" @click.native="update">
            <v-icon left dark>mdi-check</v-icon>
            Uložiť zmeny
          </v-btn>
        </div>
        <div v-else>
          <v-btn color="info" :loading="loading" @click="updateContactInfo">
            <v-icon left dark>mdi-update</v-icon>
            Aktualizovať kontaktné informácie
          </v-btn>
        </div>

      </v-card-actions>
    </v-card>
  </div>
</div>
</template>

<script>
import axios from 'axios'
import moment from 'moment';
// import {
//   VueTelInputVuetify
// } from 'vue-tel-input-vuetify';

import VueTelInputVuetify from "vue-tel-input-vuetify/lib/vue-tel-input-vuetify.vue"
export default {
  pageTitle: 'Profile',
  components: {
    VueTelInputVuetify
  },
  data() {
    return {
      loading: false,
      form: {
        firstName: 'John',
        lastName: 'Doe',
        contactEmail: 'john@doe.com',
        avatar: 'MALE_CAUCASIAN_BLOND_BEARD'
      },
      showAvatarPicker: false,

      uploadPercent: 0,
      avatarImageUrl: "",
      showUploadProgress: false,
      processingUpload: false,
      usernameInitial: localStorage.getItem('username').charAt(0),
      name: localStorage.getItem("username"),
      email: '',
      password: '',
      memberFrom: '',
      rules: [v => v.length <= 25 || 'Max 25 characters'],
      //Password
      show1: false,
      pu: true,

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
      zip: null,
      country: null,
      myPhone: '',
      phone: {
        number: '',
        valid: false,
        country: undefined,
      },
      comment: null,
      formHasErrors: false,
    }
  },

  mounted() {
    this.avatarImageUrl = this.avatarUrl
    const api = 'http://127.0.0.1:8000/api/user';
    const config = {
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("authToken"),
      },
    };
    axios.get(api, config).then((response) => {
      if (response.data.avatar) {
        this.avatarImageUrl = "http://127.0.0.1:8000/storage/user-avatar/" + response.data.avatar;
      }
    }).catch((error) => {
      console.log(error)
    })
  },
  async created() {
    const api = 'http://127.0.0.1:8000/api/auth/user';
    const config = {
      headers: {
        Accept: 'application/json',
        Authorization: "Bearer " + localStorage.getItem("authToken")
      }
    }
    try {
      let res = await axios.get(api, config)
      this.email = res.data.email;
      this.memberFrom = moment(res.data.created_at).format('YYYY-MM-DD');
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
    // surname: null,
    // lastname: null,
    // address: null,
    // city: null,
    // zip: null,
    // country: null,
    // comment: null,
    console.log(this.surname);
    console.log(this.lastname);
    console.log(this.address);
    console.log(this.city);
    console.log(this.zip);
    console.log(this.country);
    console.log(this.phone);
    console.log(this.comment);
  },

  methods: {
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
        maxHeight: 304
      };

      if (this.$vuetify.breakpoint.smAndDown) {
        defaultProps.maxHeight = 130;
        defaultProps.top = true;
      }
      return defaultProps;
    },

    addressCheck() {
      this.errorMessages = this.address && !this.name ?
        `Hey! I'm required` :
        ''

      return true
    },
    //
    contact_inf() {
      this.pu = false;
    },

    user_acc() {
      this.pu = true;
    },

    openAvatarPicker() {
      this.showAvatarPicker = true
    },
    selectAvatar(avatar) {
      this.form.avatar = avatar
    },

    updateAvatar(event) {
      if (this.$refs.photo) {
        this.showUploadProgress = true
        this.processingUpload = true
        this.uploadPercent = 0
        let formData = new FormData();
        formData.append('avatar', event.target.files[0]);
        const api = 'http://127.0.0.1:8000/api/upload_avatar';
        const config = {
          headers: {
            Accept: "application/json",
            'Content-Type': 'multipart/form-data',
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
            console.log(response);
            this.avatarImageUrl = response.data.avatar_url
            this.showUploadProgress = false
            this.processingUpload = false
            this.$emit('imageUrl', response.data.secure_url)
          }).catch((error) => {
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
      // const api = 'http://127.0.0.1:8000/api/contactForm';
      // const config = {
      //   headers: {
      //     Accept: "application/json",
      //     'Content-Type': 'multipart/form-data',
      //     Authorization: "Bearer " + localStorage.getItem("authToken"),
      //   },
      // };

      // const bodyParameters = {
      //   surname: this.surname,
      //   lastname: this.lastname,
      //   address: this.address,
      //   city: this.city,
      //   postcode: this.zip,
      //   country: this.country,
      //   phone: this.phone.number,
      //   note: this.comment
      // };
      axios.post('http://127.0.0.1:8000/api/contactForm', {
        surname: this.surname,
        lastname: this.lastname,
        address: this.address,
        city: this.city,
        postcode: this.zip,
        country: this.country,
        phone: this.phone.number,
        note: this.comment
      }).then(resp => {
        console.log(resp);
      }).catch(e => {
        console.log(e)
      })
      // axios.post(api, {
      //     bodyParameters
      //   })
      //   .then((response) => {
      //     console.log(response);
      //   }).catch((error) => {
      //     console.log(error)
      //   })
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
