
<template>
    <div class="login-box">

        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>Admin</b>Login</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form @submit.prevent="loginOrRegister">
                    <div class="input-group mb-3">
                        <input type="email" v-model="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" v-model="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>

                    </div>
                </form>

                <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>
            </div>

        </div>
    </div>
</template>
<script>
import axios from 'axios';

// Import the Vuex store
// import store from '@/store';

const config = {
    headers: {
        'Content-Type': 'application/json',
    },
};

export default {
   
  data() {
    return {
      email: '',
      password: '',
      action: 'Login', // Will be 'Register' for the registration form
    };
  },
  methods: {
    async loginOrRegister() {
      // Make an HTTP request to the Laravel API for login or registration
      const requestData = {
        email: this.email,
        password: this.password,
      };

      if (this.action === 'Login') {
        // Make a login request
        await axios.post('/api/login',requestData,config)
        .then((response) => {
            
            const token = response.data.access_token;
            console.log(this);
            // Store the token in the Vuex store
            this.$store.dispatch('loginOrRegister', token);
            
            //window.location.href = "/admin/files"
                })
                .catch((error) => {
                    console.error('API Error:', error);
                });
      } else {
        // Make a registration request
      }
    },
  },
};
</script>