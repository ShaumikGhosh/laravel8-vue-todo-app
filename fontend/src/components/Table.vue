<template>
  <div>
    <Header/>
    <div class="table-area">
      <h1>My Todo List</h1>
      <b-button variant="outline-primary" size="sm"
        ><router-link to="add-todo">Add New Todo</router-link></b-button
      >
      <b-form style="margin-top:20px; margin-bottom:20px" @submit.prevent="onClickSearch">
        <div style="display:flex; justify-content:space-between">
          <b-form-input
            id="input-1"
            type="text"
            placeholder="Enter search title"
            required
            style="width:90%"
            v-model="searchedFor"
            @keyup="onChangeEffect"
          ></b-form-input>
          <b-button variant="primary" type="submit">Search</b-button>
        </div>
      </b-form>
      <b-table striped hover :items="items" :fields="fields" v-if="this.items.length">
        <template #cell(actions)="row">
          <b-button
            variant="primary"
            size="sm"
            @click.prevent="onClickEdit(row.item.id)"
            class="mr-2"
            >Edit</b-button
          >
          <b-button
            variant="warning"
            size="sm"
            @click.prevent="onClickView(row.item.id)"
            class="mr-2"
            >View</b-button
          >
          <b-button
            variant="danger"
            size="sm"
            @click.prevent="OnClickDelete(row.item.id)"
            class="mr-2"
            >Delete</b-button
          >
        </template>
      </b-table>
      <p style="color:red; text-align:center;font-size:23px">{{message}}</p>
    </div>
    <infinite-loading @infinite="getAllTodos"></infinite-loading>
  </div>
</template>

<script>

import InfiniteLoading from 'vue-infinite-loading';

export default {

  name: "Table",

  components: {
    InfiniteLoading,
  },

  data() {
    return {
      fields: ["id", "title", "description", "created_at", "actions"],
      items: [],
      headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Access-Control-Allow-Origin": "*",
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("user_token"),
      },
      searchedFor: null,
      item_limit:10,
      message: null,
      page:1,
    };
  },

  methods: {


    onClickEdit(id) {
      this.$router.push(`edit-todo/${id}`);
    },

    getAllTodos($state) {
      this.$axios
        .get(`${this.$base_path}/api/user/my-todos/?page=${this.page}`, { headers: this.headers })
        .then((response) => {
          if(response.data.data.length > 0)
          {
            this.message = null;
            this.page += 1;
            response.data.data.forEach((element) => {
              let date = new Date(element.created_at);
              this.items.push({
                id:element.id,
                title: (element.title.length > 25) ? element.title.substring(0, 25)+" ...": element.title,
                description:(element.description.length > 35) ? element.description.substring(0, 35)+" ...": element.description,
                created_at: `${date.getDate()}-${date.getMonth()}-${date.getFullYear()}`
              });
            });
            $state.loaded();
          }else{
            $state.complete();
          }
        })
        .catch((error) => {
          console.log(error);
        })
    },

    OnClickDelete(id) {
      if (confirm("Are you sure to delete it ?") === true) {
        this.$axios
          .get(`${this.$base_path}/api/user/delete-todo/${id}`, {
            headers: this.headers,
          })
          .then((response) => {
            if (response.data.todo_delete) {
              const index = this.items.findIndex((item) => item.id === id); // find the post index
              if (~index){
                this.items.splice(index, id);
              }
              this.$toast.success(`${response.data.todo_delete}`, {
                position: "top",
              });
            }
          });
      }
    },

    onClickView(id) {
      this.$router.push(`/view-todo/${id}`);
    },


    onClickSearch () {
      const data = {
        title: this.searchedFor
      }
      this.$axios.post(`${this.$base_path}/api/user/search-todo/`, data, {headers:this.headers})
      .then((response) => {
        if(response.data.length !== 0){
          response.data.forEach(element => {
            this.items.length = 0;
            const date = new Date(element.created_at)
            this.items.push({
              id:element.id,
              title: element.title.substring(0, 20)+" ...",
              description:element.description.substring(0, 20)+" ...",
              created_at: `${date.getDate()}-${date.getMonth()}-${date.getFullYear()}`
            });
          });
        }else{
          this.items.length = 0;
          this.message = "No match found!";
        }
      })
      .catch((error) => {
        console.log(error);
      })
    },

    onChangeEffect () {
      if(this.searchedFor === '' || this.searchedFor === null) {
        this.$router.go(0);
      }
    },
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