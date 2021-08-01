<template>
  <Navbar />

  <div class="container pt-5">
    <div class="row pt-5">
      <form name="" @submit.prevent="login()" class="col-lg-6 pt-5">
        <!--login mail and password -->
        <div class="box ">
          <!-- Email -->
          <div class="col-md-8  mb-3">
            <label for="exampleInputEmail1">Email</label>
            <input
              class="form-control rounded"
              v-model="email"
              type="text"
              placeholder="Enter your email"
              id="example-date-input"
            />
          </div>
          <!-- password -->
          <div class="col-md-8  mb-3">
            <label for="exampleInputPassword1">Password</label>
            <input
              class="form-control rounded"
              v-model="password"
              type="password"
              placeholder="**************"
            />
          </div>
        </div>

        <!-- Button -->
        <div class="col-lg-8 d-grid gap-2">
          <button type="submit" class="btn btn-primary btn-lg">
            Login
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Navbar from "@/components/Navbar.vue";
export default {
  name: "Login",
  components: {
    Navbar,
  },

  date() {
    return {
      email: "",
      password: "",
      admin: false,
      user: false,
    };
  },

  methods: {
    async login() {
      //recupere le token

      var myHeaders = new Headers();
      myHeaders.append("Content-Type", "application/json");

      var raw = JSON.stringify({
        email: this.email,
        password: this.password,
      });

      var requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: raw,
        redirect: "follow",
      };

      var res = await fetch(
        "http://127.0.0.1:8000/api/auth/login",
        requestOptions
      );
      if (res.status == 200) {
        const result = await res.json();
        console.log(result);
        localStorage.setItem("token", result.token);
        console.log(localStorage.getItem("token"));
      }

      // recuperer id_role

      requestOptions = {
        method: "GET",
        headers: {
          "Content-type": "application/json",
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
      };

      var rese = await fetch(
        "http://127.0.0.1:8000/api/auth/get_user",
        requestOptions
      );
      if (rese.status == 200) {
        const results = await rese.json();
        console.log(results);
        localStorage.setItem("id_role", results.user.id_role);
        localStorage.setItem("id", results.user.id);

        console.log(localStorage.getItem("id_role"));
        if (localStorage.getItem("id_role") == 0) {
          this.admin = true;
        } else if (localStorage.getItem("id_role") == 1) {
          this.user = true;
        }
        this.redirection();
      }
    },

    redirection() {
      if (this.admin == true) {
        this.$router.push({ path: "/dashboard" });
      } else if (this.user == true) {
        this.$router.push({ path: "/acceuil" });
      }
    },
  },
};
</script>
