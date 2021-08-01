<template>
  <div>
    <Navbar />

    <center>
      <form @submit.prevent="updatePost()" class="mon-status">
        <h3>Postuler un post :</h3>
        <input
          type="text"
          placeholder="entrer le titre"
          v-model="title"
          required
        />
        <textarea
          type=""
          placeholder="Votre post"
          v-model="body"
          required
        ></textarea>
        <input type="submit" value="postuler" class="btn btn-primary " />
      </form>
    </center>
  </div>
</template>

<script>
import Navbar from "@/components/Navbar.vue";
export default {
  name: "Edit",
  components: {
    Navbar,
  },
  data() {
    return {
      authentifier: false,
      title: "",
      body: "",
      created_by: "",
      id: "",
    };
  },

  methods: {
    async updatePost() {
      var id = this.id;
      var raw = JSON.stringify({
        title: this.title,
        body: this.body,
        created_by: localStorage.getItem("id"),
      });

      var requestOptions = {
        method: "PUT",
        headers: {
          "Content-type": "application/json",
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        body: raw,
        redirect: "follow",
      };

      var res = await fetch(
        "http://127.0.0.1:8000/api/posts/" + id,
        requestOptions
      );
      if (res.status == 201) {
        const result = await res.json();
        console.log(result.status);
      }
      this.$router.push({ path: "/posts" });
    },
  },

  async created() {
    if (!localStorage.getItem("token")) {
      this.$router.push({ path: "/login" });
    }
    this.title = sessionStorage.getItem("title");
    this.body = sessionStorage.getItem("body");
    this.id = sessionStorage.getItem("id_post");
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
