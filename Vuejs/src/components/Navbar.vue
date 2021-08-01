<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Navbar</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div
        v-if="authentifier == false"
        class="collapse navbar-collapse"
        id="navbarNav"
      >
        <ul class="navbar-nav">
          <li class="nav-item">
            <router-link to="/acceuil">
              <a class="nav-link active" aria-current="page" href="#"
                >Acceuil</a
              >
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/login">
              <a class="nav-link active" aria-current="page" href="#">Login</a>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/register">
              <a class="nav-link active" aria-current="page" href="#"
                >resgister</a
              >
            </router-link>
          </li>
        </ul>
      </div>

      <div
        v-if="authentifier == true"
        class="collapse navbar-collapse"
        id="navbarNav"
      >
        <ul class="navbar-nav">
          <li class="nav-item">
            <router-link to="/acceuil">
              <a class="nav-link active" aria-current="page" href="#"
                >Acceuil</a
              >
            </router-link>
          </li>
          <li class="nav-item" v-if="user == true">
            <router-link to="/posts">
              <a class="nav-link active" aria-current="page" href="#">Posts</a>
            </router-link>
          </li>
          <li class="nav-item" v-if="admin == true">
            <router-link to="/dashboard">
              <a class="nav-link active" aria-current="page" href="#"
                >Dasboard</a
              >
            </router-link>
          </li>

          <li class="nav-item">
            <a
              @click="deconexion()"
              class="nav-link active"
              aria-current="page"
              href="#"
              >Deconexion</a
            >
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: "Navbar",

  data() {
    return {
      authentifier: false,
      admin: false,
      user: false,
    };
  },

  methods: {
    deconexion() {
      localStorage.setItem("token", "");
      this.authentifier = false;

      this.$router.push({ path: "/login" });
    },
  },

  async created() {
    if (localStorage.getItem("token")) {
      this.authentifier = true;
    } else {
      this.authentifier = false;
    }
    if (localStorage.getItem("id_role") == 0) {
      this.admin = true;
    } else if (localStorage.getItem("id_role") == 1) {
      this.user = true;
    }
  },
};
</script>
