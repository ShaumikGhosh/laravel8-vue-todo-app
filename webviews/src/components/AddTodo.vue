<template>
  <div>
    <Header/>
    <div class="table-area">
      <h1>{{ page_heading }}</h1>
      <b-button variant="outline-primary" size="sm"
        ><router-link to="/profile">ToDo List</router-link></b-button
      >
      <div>
        <b-form @submit.prevent="onSubmit">
          <b-form-group
            id="input-group-1"
            label="Todo Title:"
            label-for="input-1"
          >
            <b-form-input
              id="input-1"
              type="text"
              placeholder="Enter todo title"
              required
              v-model="title"
            ></b-form-input>
          </b-form-group>

          <b-form-group
            id="input-group-2"
            label="Todo Description:"
            label-for="input-1"
          >
            <b-form-textarea
              id="input-2"
              type="text"
              placeholder="Enter todo desvription"
              required
              rows="5"
              v-model="description"
            ></b-form-textarea>
          </b-form-group>

          <b-button type="submit" variant="primary">{{ button_name }}</b-button>
        </b-form>
      </div>
    </div>
  </div>
</template>

<script>
import Header from '../components/Header'

export default {


  name: "AddTodo",

  components : {
    Header
  },

  data() {
    return {
      title: null,
      description: null,
      page_heading: null,
      button_name: null,
      headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Access-Control-Allow-Origin": "*",
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("user_token"),
      },
    };
  },


  methods: {
    onSubmit() {
      const data = {
        title: this.title,
        description: this.description,
      };

      if (!this.$route.params.id) {
        this.$axios
          .post(`${this.$base_path}/api/user/create-todo`, data, {
            headers: this.headers,
          })
          .then((response) => {
            if (response.data.todo_created) {
              this.$toast.success(`${response.data.todo_created}`, {
                position: "top",
              });
              this.$router.push("/profile");
            }
          })
          .catch((error) => {
            console.log(error)
          })
      } else {
        this.$axios
          .post(
            `${this.$base_path}/api/user/update-todo/${this.$route.params.id}`,
            data,
            { headers: this.headers }
          )
          .then((response) => {
            if (response.data.todo_updated) {
              this.$toast.success(`${response.data.todo_updated}`, {
                position: "top",
              });
              this.$router.push("/profile");
            }
          })
          .catch((error) => {
            console.log(error);
          })
      }
    },
  },

  mounted() {
    if (this.$route.params.id) {
      this.page_heading = "Update Todo";
      this.button_name = "Update now";
      this.$axios
        .get(`${this.$base_path}/api/user/my-todo/${this.$route.params.id}`, {
          headers: this.headers,
        })
        .then((response) => {
          this.title = response.data.title;
          this.description = response.data.description;
        })
        .catch((error) => {
            console.log(error);
          })
    } else {
      this.page_heading = "Add New Todo";
      this.button_name = "Add now";
    }
  },

  
};
</script>

<style scoped>
.table-area {
  width: 70%;
  height: auto;
  margin: 3% auto;
}

.table-area h1 {
  display: inline-block;
  margin-right: 20px;
}
</style>