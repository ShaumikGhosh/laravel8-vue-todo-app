<template>
  <div>
    <Header/>
    <div class="table-area">
      <h1>Single ToDo View</h1>
      <b-button variant="outline-primary" size="sm"
        ><router-link to="/profile">ToDo Item</router-link></b-button
      >
      <div>
        <b-card
          :title="title"
          img-alt="Image"
          img-top
          tag="article"
          style="max-width: 100%"
          class="mb-12 md-12"
        >
          <b-card-text>
            {{description}}
          </b-card-text>
        </b-card>
      </div>
    </div>
  </div>
</template>

<script>
import Header from '../components/Header'

export default {
  name: "Single",
    components : {
      Header
    },

  data() {
    return {
      title: null,
      description: null,
      headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Access-Control-Allow-Origin": "*",
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("user_token"),
      },
    };
  },


  mounted() {
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
      });
  }
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