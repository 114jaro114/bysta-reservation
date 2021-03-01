<!-- <template>
<div class="comment w-100 h-100 text-uppercase secondary-color" v-bind:class="{fixed: menuVisible}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <md-toolbar class="md-large md-dense md-accent position-fixed">
    <div class="md-toolbar-row">
      <div class="md-toolbar-section-start">
        <span class="md-title font-weight-bold">
          <img class="logo2 align-middle" src="/img/logo2.png">
        </span>
      </div>
      <div class="md-toolbar-section-end">
        <md-button class="md-icon-button" @click="menuVisible = !menuVisible">
          <i class="fas fa-bars secondary-color"></i>
        </md-button>
      </div>
    </div>
    <div class="md-toolbar-row">
      <md-tabs class="m-auto w-100" md-alignment="fixed">
        <md-tab id="tab-about_us" md-label="About us" md-disabled></md-tab>
      </md-tabs>
    </div>
  </md-toolbar>

  <md-content class="justify-content-center">
    <md-drawer class="menu" :md-active.sync="menuVisible">
      <md-list>
        <md-list-item>
          <div class="md-list-section-start">
            <i class="fas fa-user-circle fa-3x pl-4 secondary-color"></i>
          </div>

          <div class="md-list-section-end">
            <md-button class="md-icon-button" v-on:click="logout">
              <i class="fas fa-sign-out-alt fa-lg secondary-color"></i>
            </md-button>

          </div>
        </md-list-item>

        <div class="row mr-0 ml-0 border-bottom">
          <md-list-item>
            <md-button class="m-0" v-on:click="isHidden = !isHidden">
              <span class="font-weight-bold">{{ username }}</span>
            </md-button>
          </md-list-item>
          <md-list-item class="show-profile" v-if="!isHidden">
            <md-button to="/profile" class="md-icon-button">
              <i class="fas fa-pen"></i>
            </md-button>
          </md-list-item>
        </div>
        <div class="menu-list">
          <md-list-item>
            <md-button to="/home">
              <div class="row ml-0 mr-0">
                <div class="menu-list-position">
                  <i class="fas fa-home fa-lg primary-color"></i>
                </div>
                <span> Domov</span>
              </div>
            </md-button>
          </md-list-item>

          <md-list-item>
            <md-button to="/notifications">
              <div class="row ml-0 mr-0">
                <div class="menu-list-position">
                  <i class="fas fa-bell fa-lg primary-color"></i>
                </div>
                <span> Notifikácie</span>
              </div>
            </md-button>
          </md-list-item>

          <md-list-item>
            <md-button to="/administration">
              <div class="row ml-0 mr-0">
                <div class="menu-list-position">
                  <i class="fas fa-clipboard-list fa-lg primary-color"></i>
                </div>
                <span> Administrácia</span>
              </div>
            </md-button>
          </md-list-item>

          <md-list-item>
            <md-button to="/reservation">
              <div class="row ml-0 mr-0">
                <div class="menu-list-position">
                  <i class="fas fa-calendar-alt fa-lg primary-color"></i>
                </div>
                <span> Rezervácia</span>
              </div>
            </md-button>
          </md-list-item>

          <md-list-item>
            <md-button to="/messenger">
              <div class="row ml-0 mr-0">
                <div class="menu-list-position">
                  <i class="fab fa-facebook-messenger fa-lg primary-color"></i>
                </div>
                <span> Messenger</span>
              </div>
            </md-button>
          </md-list-item>

          <md-list-item>
            <md-button to="/settings">
              <div class="row ml-0 mr-0">
                <div class="menu-list-position">
                  <i class="fas fa-cog fa-lg primary-color"></i>
                </div>
                <span> Nastavenia</span>
              </div>
            </md-button>
          </md-list-item>

          <md-list-item>
            <md-button to="/about_us" disabled>
              <div class="row ml-0 mr-0">
                <div class="menu-list-position">
                  <i class="fas fa-info-circle fa-lg"></i>
                </div>
                <span> O nás</span>
              </div>
            </md-button>
          </md-list-item>
        </div>
      </md-list>
    </md-drawer>
    <div class="row w-100 justify-content-center mr-0 ml-0">
      <div class="col-6 pl-0 pr-0">
        <md-card md-with-hover class="mt-3">
          <div class="container">
            <div class="question-wrapper">
                <img width="200" src="{{ asset('images/adonuxt.png') }}" alt="">
                <h5 class="is-size-2" style="color: #220052;">
                    What do you think about <span style="color: #47b784;">Laravel</span>?</h5>
                <br>
                <a href="#commentForm" class="button is-medium has-shadow has-text-white" style="background-col
                or: #47b784">Comment</a>
            </div>

            <br><br>
            <comments></comments>
            <new-comment></new-comment>
        </div>
        </md-card>
      </div>
    </div>
  </md-content>

  <div class="md-speed-dial">
    <md-speed-dial class="md-bottom-right" md-direction="top">
      <md-speed-dial-target class="md-primary">
        <i class="fas fa-pen md-morph-initial white-color"></i>
        <i class="fas fa-times md-morph-final white-color"></i>
      </md-speed-dial-target>

      <md-speed-dial-content>
        <md-button class="md-icon-button">
          <i class="fas fa-comment primary-color"></i>
        </md-button>

        <md-button class="md-icon-button">
          <i class="fas fa-envelope primary-color"></i>
        </md-button>
      </md-speed-dial-content>
    </md-speed-dial>
  </div>
  <div class="phone-viewport w-100 m-auto">
    <md-bottom-bar md-sync-route class="md-primary" md-type="shift">
      <md-bottom-bar-item id="bottom-bar-item-home" md-label="Domov" md-icon="home" to="/home" exact></md-bottom-bar-item>
      <md-bottom-bar-item id="bottom-bar-item-pages" md-label="Rezervácia" md-icon="date_range" to="/reservation"></md-bottom-bar-item>
      <md-bottom-bar-item id="bottom-bar-item-posts" md-label="Administrácia" md-icon="assignment" to="/administration"></md-bottom-bar-item>
      <md-bottom-bar-item id="bottom-bar-item-favorites" md-label="Settings" md-icon="settings" to="/settings"></md-bottom-bar-item>
    </md-bottom-bar>
  </div>
  <Footer />
</div>
</template>

<script>
import axios from 'axios';
import Footer from "../components/Footer.vue";
import Comment from "../components/Comment.vue";
import Comments from "../components/Comments.vue";
import NewComment from "../components/NewComment.vue";
export default {
  name: "Comment",
  components: {
    Footer,
    Comment,
    Comments,
    NewComment
  },
}
</script>

<style type="scss">
</style> -->
