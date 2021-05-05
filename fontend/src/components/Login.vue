<template>
  <div>
    <Header/>
    <Message v-if="message !== null" :message="message" />
    <div class="form-area">
      <h1>Login form</h1>
      <b-form @submit.prevent="onFormSubmit">
        <b-form-group
          id="input-group-1"
          label="Email address:"
          label-for="input-1"
        >
          <b-form-input
            id="input-1"
            type="email"
            placeholder="Enter your email"
            required
            v-model="email"
          ></b-form-input>
        </b-form-group>

        <b-form-group id="input-group-2" label="Password:" label-for="input-2">
          <b-form-input
            id="input-2"
            placeholder="Enter your password"
            required
            type="password"
            v-model="password"
          ></b-form-input>
        </b-form-group>
        <b-button type="submit" variant="primary">Login now</b-button>
        <p style="color: red">{{ logn_error }}</p>
      </b-form>
    </div>
  </div>
</template>

<script>
import Header from '../components/Header'
import Message from "../components/Message";

export default {


  name: "Login",

  
  components: {
    Message,
    Header
  },


  data() {
    return {
      email: null,
      password: null,
      logn_error: null,
      message: null,
    };
  },


  methods: {
    onFormSubmit() {
      const data = {
        email: this.email,
        password: this.password,
      };

      const headers = {
        "Content-Type": "application/json;charset=UTF-8",
        "Access-Control-Allow-Origin": "*",
        Accept: "application/json",
      };

      this.$axios
        .post(`${this.$base_path}/api/login`, data, {
          headers: headers,
        })
        .then((response) => {
          if (response.data.error) {
            this.logn_error = response.data.error;
          }
          if (response.data.token) {
            localStorage.setItem("user_token", response.data.token);
            this.$router.push("/profile");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  mounted() {

    if (this.$route.query.message) {
      this.message = this.$route.query.message;
    }

    if (this.$route.query.verify_token && this.$route.query.target) {
      const headers = {
        "Content-Type": "application/json;charset=UTF-8",
        "Access-Control-Allow-Origin": "*",
        Accept: "application/json",
      };
      this.$axios
        .get(
          `${this.$base_path}/api/verify-user/${this.$route.query.verify_token}/${this.$route.query.target}`,
          { headers: headers }
        )
        .then((response) => {
          this.$toast.success(`${response.data.success}`, {
            position: "top",
          });
        })
        .catch((error) => {
          console.log(error);
        });
    }
  },
};
</script>

<style scoped>
.form-area {
  width: 400px;
  border: 1px solid black;
  margin: 100px auto;
  padding: 20px;
}
.message {
  widows: 100%;
  height: 30px;
  background-color: green;
  text-align: center;
  color: white;
}
</style>