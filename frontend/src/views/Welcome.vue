<template>
<div class="welcome vh-100 p-3">
  <!-- SIGN CONTROLS -->
  <div class="sign-controls float-right p-3">
    <!-- SIGN IN -->
    <div class="login-content">
      <router-link :to="{ name: 'Login' }">
        <button type="button" name="button" class="login-content-btn text-uppercase font-weight-bold cursor-pointer text-decoration-none">
          <i class="fas fa-sign-in-alt"></i> Log in
        </button>
      </router-link>
    </div>
    <div class="text pb-3"></div>
    <!-- GET STARTED -->
    <div class="register-content">
      <router-link :to="{ name: 'Register' }">
        <button type="button" name="button" class="register-content-btn text-uppercase font-weight-bold text-decoration-none">
          <i class="fas fa-user-plus"></i> Sign up
        </button>
      </router-link>
    </div>
  </div>

  <!-- content -->
  <div class="content verticalhorizontal">
    <img src="/img/logo.png" align="middle" class="m-auto align-middle">
  </div>
</div>
</template>

<script>
export default {
  name: "Welcome",
  components: {},
};
</script>

<style lang="css">
  .sign-controls {
    position: fixed;
    right: 15px;
    display: flex;
    flex-wrap: wrap;
  }
  .flex-center {
    align-items: center;
    display: flex;
    justify-content: center;
  }
  .position-ref {
    position: relative;
  }
  .top-right {
    position: absolute;
    right: 10px;
    top: 18px;
  }
  .content {
    text-align: center;
    width: 70vw;
    margin: auto;
    display:flex;
    top: 30vh;
    position: relative;
  }
  .login-content-btn {
    width: 300px;
    height: 50px;
    border: 1px solid #007bff;
    background-color: #fff;
    color: #007bff;
    border-radius: 50px;
    text-align: center;
  }
  .login-content-btn:hover {
    border: 1px solid #007bff;
    background-color: #007bff;
    color: #fff;
  }
  .register-content-btn {
    width: 300px;
    height: 50px;
    border: 1px solid #007bff;
    background-color: #007bff;
    color: #fff;
    border-radius: 50px;
    text-align: center;
  }
  .register-content-btn:hover {
    border: 1px solid #007bff;
    background-color: #fff;
    color: #007bff;
  }
  .login-content {
    padding: 0px 15px 0px 15px;
  }
  .register-content {
    padding: 0px 15px 0px 15px;
  }
  .text,
  .text2,
  .text3 {
    display: none;
  }
</style>
