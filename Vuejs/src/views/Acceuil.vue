<template>
  <div>
    <Navbar />
    <div class="all">
      <form
        v-if="authentifier == true"
        @submit.prevent="registerPost()"
        class="mon-status"
      >
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
        <!-- 
        <div>
          <label>Choisir un image :</label>
          <input type="file"  required />
        </div> -->

        <input
          type="submit"
          value="postuler"
          name="submit"
          class="btn btn-primary "
        />
      </form>

      <!-- testing -->

      <div class="container posts-content">
        <div class="row alll " v-for="post in data" :key="post.id">
          <div class="col-lg-6 center-block container-bootdey">
            <div class="card  mb-4 ">
              <div class="carte-style  ">
                <div class="media mb-3">
                  <i style="font-size:40px" class="fas fa-user-circle"></i>

                  <div class="media-body ml-3">
                    Kenneth Frazier
                  </div>
                </div>
                <h3>{{ post.title }}</h3>
                <p>
                  {{ post.body }}
                </p>
                <a
                  href="javascript:void(0)"
                  class="ui-rect ui-bg-cover"
                  style="background-image: url('https://bootdey.com/img/Content/avatar/avatar1.png');"
                ></a>
              </div>
              <div class="card-footer">
                <a href="javascript:void(0)" class="d-inline-block text-muted">
                  <small class="align-middle">
                    <strong>123</strong> Likes</small
                  >
                </a>
                <a
                  href="javascript:void(0)"
                  class="d-inline-block text-muted ml-3"
                >
                  <small class="align-middle">
                    <strong>12</strong> Comments</small
                  >
                </a>
                <a
                  href="javascript:void(0)"
                  class="d-inline-block text-muted ml-3"
                >
                  <i class="ion ion-md-share align-middle"></i>&nbsp;
                  <small class="align-middle">Repost</small>
                </a>
              </div>
            </div>
          </div>

          <div class="container-bootdey">
            <div class="col-md-12 bootstrap snippets">
              <div class="panel">
                <form
                  v-if="authentifier == true"
                  class="panel-body"
                  @click.prevent="registerCommente(post.id)"
                >
                  <textarea
                    class="form-control"
                    v-model="comment"
                    rows="2"
                    placeholder="What are you thinking?"
                  ></textarea>
                  <div class="mar-top clearfix">
                    <button
                      class="btn btn-sm btn-primary pull-right"
                      type="submit"
                    >
                      <i class="fa fa-pencil fa-fw"></i> Share
                    </button>
                  </div>
                </form>
              </div>
              <div class="panel">
                <div class="panel-body">
                  <!-- Newsfeed Content -->
                  <!-- comments blok -->
                  <!--===================================================-->
                  <div
                    class="media-block"
                    v-for="commentaire in post.commentaires"
                    :key="commentaire.id"
                  >
                    <a class="media-left" href="#"
                      ><img
                        class="img-circle img-sm"
                        alt="Profile Picture"
                        src="https://bootdey.com/img/Content/avatar/avatar1.png"
                    /></a>
                    <div class="media-body">
                      <p>
                        {{ commentaire.body }}
                      </p>
                      <div class="pad-ver">
                        <div class="btn-group">
                          <a
                            v-if="authentifier == true"
                            class="btn btn-sm btn-default btn-hover-success"
                            href="#"
                            ><i class="fa fa-thumbs-up"></i
                          ></a>
                          <a
                            class="btn btn-sm btn-default btn-hover-danger"
                            href="#"
                            ><i class="fa fa-thumbs-down"></i
                          ></a>
                        </div>
                        <a
                          class="btn btn-sm btn-default btn-hover-primary"
                          href="#"
                          >Comment</a
                        >
                        <a @click="deleteCommentaire(commentaire.id)" href="#"
                          ><i class="fas fa-trash-alt"></i
                        ></a>
                      </div>
                      <hr />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ls autres status -->

      <!-- testing -->
    </div>
  </div>
</template>

<script>
import Navbar from "@/components/Navbar.vue";
export default {
  name: "Acceuil",
  components: {
    Navbar,
  },
  data() {
    return {
      authentifier: false,
      title: "",
      body: "",
      created_by: "",
      data: {},
      comment: "",
    };
  },

  methods: {
    async created() {
      if (localStorage.getItem("token")) {
        this.authentifier = true;
      } else {
        this.authentifier = false;
      }

      var requestOptions = {
        method: "POST",
        headers: {
          "Content-type": "application/json",
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        redirect: "follow",
      };

      var res = await fetch(
        "http://127.0.0.1:8000/api/posts/show",
        requestOptions
      );
      if (res.status == 200) {
        const result = await res.json();
        this.data = result.data;
        console.log(result);
        console.log(this.data[0].commentaires[1].body);
      }
    },

    async registerPost() {
      var raw = JSON.stringify({
        title: this.title,
        body: this.body,
        created_by: localStorage.getItem("id"),
      });
      console.log(raw);

      var requestOptions = {
        method: "POST",
        headers: {
          "Content-type": "application/json",
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        body: raw,
        redirect: "follow",
      };

      var res = await fetch("http://127.0.0.1:8000/api/posts", requestOptions);
      if (res.status == 201) {
        const result = await res.json();
        console.log(result.status);
      }
      this.created();
    },

    async registerCommente(id_post) {
      var comment = JSON.stringify({
        body: this.comment,
        id_user: localStorage.getItem("id"),
        id_post: id_post,
      });

      var requestOptions = {
        method: "POST",
        headers: {
          "Content-type": "application/json",
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        body: comment,
        redirect: "follow",
      };

      var res = await fetch(
        "http://127.0.0.1:8000/api/Commentaires",
        requestOptions
      );

      const result = await res.json();
      console.log(result.status);
      this.created();
    },
    async deleteCommentaire($id) {
      var requestOptions = {
        method: "DELETE",
        headers: {
          "Content-type": "application/json",
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        redirect: "follow",
      };

      var res = await fetch(
        "http://127.0.0.1:8000/api/Commentaires/" + $id,
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

<style>
.card {
  width: 100%;
}
.alll {
  display: flex;
  flex-direction: column;
  align-self: center;
}
.container-bootdey {
  display: flex;
  width: 53%;
  align-self: center;
}
.all {
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.tous-post {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

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
  align-self: center;
  justify-content: space-around;
  justify-content: center;
}
.mon-status textarea {
  width: 80%;
  height: 40%;
  margin-bottom: 3px;
}
.mon-status h3,
input {
  margin-bottom: 30px;
}

body {
  margin-top: 20px;
  background: #ebeef0;
}

.img-sm {
  width: 46px;
  height: 46px;
}

.panel {
  box-shadow: 0 2px 0 rgba(0, 0, 0, 0.075);
  border-radius: 0;
  border: 0;
  margin-bottom: 15px;
}

.panel .panel-footer,
.panel > :last-child {
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}

.panel .panel-heading,
.panel > :first-child {
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

.panel-body {
  padding: 25px 20px;
}

.media-block .media-left {
  display: block;
  float: left;
}

.media-block .media-right {
  float: right;
}

.media-block .media-body {
  display: block;
  overflow: hidden;
  width: auto;
}

.middle .media-left,
.middle .media-right,
.middle .media-body {
  vertical-align: middle;
}

.thumbnail {
  border-radius: 0;
  border-color: #e9e9e9;
}

.tag.tag-sm,
.btn-group-sm > .tag {
  padding: 5px 10px;
}

.tag:not(.label) {
  background-color: #fff;
  padding: 6px 12px;
  border-radius: 2px;
  border: 1px solid #cdd6e1;
  font-size: 12px;
  line-height: 1.42857;
  vertical-align: middle;
  -webkit-transition: all 0.15s;
  transition: all 0.15s;
}
.text-muted,
a.text-muted:hover,
a.text-muted:focus {
  color: #acacac;
}
.text-sm {
  font-size: 0.9em;
}
.text-5x,
.text-4x,
.text-5x,
.text-2x,
.text-lg,
.text-sm,
.text-xs {
  line-height: 1.25;
}

.btn-trans {
  background-color: transparent;
  border-color: transparent;
  color: #929292;
}

.btn-icon {
  padding-left: 9px;
  padding-right: 9px;
}

.btn-sm,
.btn-group-sm > .btn,
.btn-icon.btn-sm {
  padding: 5px 10px !important;
}

.mar-top {
  margin-top: 15px;
}
.card-body {
  align-items: center;
}
</style>
