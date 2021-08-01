<template>
  <div>
    <Navbar />

    <center>
      <!-- mes posts -->
      <div v-for="post in donnes" :key="post.id" class="cart">
        <div class="part1">
          <img src="../assets/logo.png" alt="#" />
        </div>

        <div class="part2">
          <div class="title">
            <h3>{{ post.title }}</h3>
          </div>
          <div class="body">
            <p>{{ post.body }}</p>
          </div>

          <form class="buttons">
            <button @click="edit(post)" class="btn btn-primary ">
              Update
            </button>
            <button class="btn btn-danger " @click.prevent="supp(post.id)">
              DELETE
            </button>
          </form>
        </div>
      </div>
    </center>
  </div>
</template>

<script>
import Navbar from "@/components/Navbar.vue";
export default {
  name: "Posts",
  components: {
    Navbar,
  },
  data() {
    return {
      title: "",
      body: "",
      created_by: "",
      donnes: {},
    };
  },
  methods: {
    async created() {
      var id = localStorage.getItem("id");

      var requestOptions = {
        method: "GET",
        headers: {
          "Content-type": "application/json",
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        redirect: "follow",
      };

      var res = await fetch(
        "http://127.0.0.1:8000/api/showPosts/" + id,
        requestOptions
      );
      if (res.status == 200) {
        const response = await res.json();
        this.donnes = response.data;
        console.log(this.donnes);
      }
      this.created();
    },

    async supp($id) {
      var requestOptions = {
        method: "DELETE",
        headers: {
          "Content-type": "application/json",
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        redirect: "follow",
      };

      var res = await fetch(
        "http://127.0.0.1:8000/api/posts/" + $id,
        requestOptions
      );

      const response = await res.json();

      console.log(response);
    },

    async edit(post) {
      sessionStorage.setItem("title", post.title);
      sessionStorage.setItem("body", post.body);
      sessionStorage.setItem("id_post", post.id);

      this.$router.push({ path: "/Edit" });
    },
  },

  mounted() {
    this.created();
  },
};
</script>

<style>
.cart {
  display: flex;
  width: 50%;
  height: 30vh;
  margin-top: 50px;
}
.part1,
.part2 {
  height: 100%;
  width: 50%;
}
.part1 img {
  height: 100%;
  width: 100%;
  border: 1px solid black;
}

.title,
.body {
  display: flex;
  align-items: flex-start;
}
.buttons {
  align-items: flex-start;
  display: flex;
}
.mon-status {
  margin-top: 50px;
  display: flex;
  height: 40vh;
  width: 50%;
  flex-direction: column;
  align-items: flex-start;
  justify-content: space-around;
}
.mon-status textarea {
  width: 80%;
  height: 40%;
}
</style>
