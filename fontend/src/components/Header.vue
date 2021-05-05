<template>
  <div>
    <b-navbar type="dark" variant="dark">
      <b-navbar-nav>
        <b-nav-item>
          <router-link to="/" custom v-slot="{ navigate }" v-if="ifLogedIn === false">
          <span @click="navigate" @keypress.enter="navigate" role="link">Home</span>
        </router-link>
        </b-nav-item>
        <b-nav-item>
          <router-link to="/register" custom v-slot="{ navigate }"  v-if="ifLogedIn === false">
          <span @click="navigate" @keypress.enter="navigate" role="link">Register</span>
        </router-link>
        </b-nav-item>
        <b-nav-item>
          <router-link to="/login" custom v-slot="{ navigate }" v-if="ifLogedIn === false">
          <span @click="navigate" @keypress.enter="navigate" role="link">Login</span>
        </router-link>
        </b-nav-item>
      </b-navbar-nav>
      <b-button variant="danger" style="float:right" size="sm" @click.prevent="onSubmitLogout" v-if="ifLogedIn === true">Logout</b-button>
    </b-navbar>
  </div>
</template>

<script>

export default {

    name: 'Header',


    methods: {
      onSubmitLogout()
      {
        const headers = {
          "Content-Type": "application/json;charset=UTF-8",
          "Access-Control-Allow-Origin": "*",
          "Accept": "application/json",
          "Authorization": 'Bearer ' + localStorage.getItem('user_token'),
        };

        this.$axios.get(`${this.$base_path}/api/user/logout`, {headers:headers})
        .then((response) => {
          if(response.data.success)
          {
            localStorage.removeItem('user_token');
            this.$router.push('/login');
          }
        })
        .catch((error) => {
            console.log(error);
          });
      }
    },


    computed: {
      ifLogedIn () {
        let decision;
        if (localStorage.getItem('user_token'))
        {
          decision = true;
        }else{
          decision = false;
        }

        return decision;
      }
    }
}

</script>

<style scoped>
a{
  text-decoration: none;
  color: white;
}
a:hover{
  color: red;
  text-decoration: none;
}
</style>
