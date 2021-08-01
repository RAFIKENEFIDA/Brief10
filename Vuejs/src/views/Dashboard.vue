<template>
  <div>
    <Navbar />
    <div class="container">
      <div class="row my-4">
        <div class="col-md-12 mx-auto">
          <!-- to show alert -->
          <div class="card">
            <div class="card-body bg-light">
              <!-- the add button -->

              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Nom de l'utilisateur</th>
                    <th scope="col">Titre de poste</th>
                    <th scope="col">le contenu du poste</th>
                    <th scope="col">L'image du posts</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="post in data" :key="post.id">
                    <th scope="row">{{ post.name }}</th>
                    <td>{{ post.title }}</td>
                    <td>{{ post.body }}</td>
                    <td>image</td>

                    <td class="d-flex flex-row">
                      <!-- update and delete button -->

                      <form>
                        <!-- send us to delete page with the id  -->
                        <input type="hidden" name="id" value="" />
                        <button
                          @click.prevent="supp(post.id)"
                          class="btn btn-sm btn-danger"
                        >
                          <i class="fa fa-trash"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from "@/components/Navbar.vue";
export default {
  name: "Dahboard",
  components: {
    Navbar,
  },
  data() {
    return {
      data: {},
    };
  },

  methods: {
    async created() {
      var requestOptions = {
        method: "POST",
        headers: {
          "Content-type": "application/json",
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        redirect: "follow",
      };

      var res = await fetch(
        "http://127.0.0.1:8000/api/posts/showAllPostWithName",
        requestOptions
      );

      const response = await res.json();
      this.data = response.data;
      console.log(this.data);
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
      this.created();
    },
  },

  mounted() {
    this.created();
  },
};
</script>
