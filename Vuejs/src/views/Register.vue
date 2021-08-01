<template>
  <Navbar />
  <div class="container">
    <div class="row pt-5">
      <form class="col-lg-6 form" @submit.prevent="inscription()">
        <!-- Full Name -->
        <div class="box d-flex form-group ">
          <!-- Last Name -->

          <!-- Last Name -->
          <div class="col  mb-3">
            <label for="exampleInputEmail1"> Name</label>
            <input
              type="text"
              class="form-control"
              placeholder="Enter your last name"
              v-model="name"
              required
            />
          </div>
        </div>
        <p v-if="requireName">{{ requireName }}</p>

        <!-- date and id -->

        <!-- Email and tele number -->
        <div class="box ">
          <!-- date -->
          <div class="col me-3  mb-3">
            <label for="exampleInputEmail1">Email</label>
            <input
              type="text"
              class="form-control"
              placeholder="Enter your email"
              v-model="email"
              required
            />
          </div>

          <p v-if="validEmail">{{ validEmail }}</p>
          <p v-if="emailUnique">{{ emailUnique }}</p>
          <p v-if="requireEmail">{{ requireEmail }}</p>
          <!-- Last Name -->
        </div>
        <!-- Password -->
        <div class="box d-flex ">
          <!-- Last Name -->
          <div class="col  me-3 mb-3">
            <label for="exampleInputPassword1">Password</label>
            <input
              type="password"
              class="form-control"
              placeholder="**************"
              v-model="password"
              required
            />
          </div>
          <!-- test -->
          <p v-if="samePasswords">{{ samePasswords }}</p>
          <p v-if="requirePassword">{{ requirePassword }}</p>
          <!-- Last Name -->
          <div class="col mb-3">
            <label for="exampleInputPassword1">Repeat Password</label>
            <input
              type="password"
              class="form-control"
              placeholder="**************"
              v-model="repeatPassword"
              required
            />
          </div>
        </div>
        <p v-if="requireRepeatPassword">{{ requireRepeatPassword }}</p>

        <!-- Button -->
        <button type="submit" class="btn btn-primary btn-lg ">
          Register
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import Navbar from "@/components/Navbar.vue";
export default {
  name: "Register",
  components: {
    Navbar,
  },
  date() {
    return {
      name: "",
      email: "",
      password: "",
      repeatPassword: "",
      validEmail: "",
      errorSame: "",
      emailUnique: "",
      requireEmail: "",
      requireName: "",
      requirePassword: "",
      requireRepeatPassword: "",
      samePasswords: "",
      RedirectLogin: false,
    };
  },

  methods: {
    async inscription() {
      var myHeaders = new Headers();
      myHeaders.append("Content-Type", "application/json");

      var raw = JSON.stringify({
        name: this.name,
        email: this.email,
        password: this.password,
        c_password: this.repeatPassword,
        id_role: 1,
      });

      var requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: raw,
        redirect: "follow",
      };

      var res = await fetch(
        "http://127.0.0.1:8000/api/auth/register",
        requestOptions
      );
      if (res.status === 201) {
        const result = await res.json();
        console.log(result.status);
        alert("Félicitation vous avez creer un compte");
        this.RedirectLogin = true;
        this.redirection();
      } else if (res.status === 401) {
        const result = await res.json();
        console.log(result.error.email);
        if (result.error.email == "The email must be a valid email address.") {
          this.validEmail = "The email must be a valid email address.";
        }
        if (result.error.email == "The email field is required.") {
          this.requireEmail = result.error.email;
        }
        if (result.error.email == "The email has already been taken.") {
          this.emailUnique = result.error.email;
        }
        if (result.error.password == "The password field is required.") {
          this.requirePassword = result.error.password;
        }
        if (result.error.name == "The name field is required.") {
          this.requireName = result.error.name;
        }
        if (result.error.c_password == "The c password field is required.") {
          this.requireRepeatPassword = result.error.c_password;
        }
        if (result.error.c_password == "The c password field is required.") {
          this.requireRepeatPassword = result.error.c_password;
        }
        if (
          result.error.c_password == "The c password and password must match."
        ) {
          this.samePasswords = result.error.c_password;
        }
      }
    },

    redirection() {
      if (this.RedirectLogin == true) {
        this.$router.push({ path: "/login" });
      }
    },
  },
};
</script>
