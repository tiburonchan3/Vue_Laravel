<template>
  <div>
    <div class="text-left container mt-4">
      <router-link exact to="/home"
        ><img src="/images/the.png" width="200px"
      /></router-link>
    </div>

    <nav class="navbar-dark container mt-4">
      <div class="navbar-content">
        <div class="verify" v-if="isAutenticated && !isAdmin">
          <router-link exact to="/cuenta" class="nav-child"
            ><span @click="Show()">Mi cuenta</span></router-link
          >
          <router-link exact to="/catalogo" class="nav-child"
            ><span @click="Show()">Catalogo de comida</span></router-link
          >
          <router-link exact to="/compras" class="nav-child"
            ><span @click="Show()">Mis compras</span></router-link
          >
        </div>
        <div v-if="isAdmin && isAutenticated" class="verify">
          <router-link to="/productos" class="nav-child"
            ><span @click="Show()">Productos</span></router-link
          >
          <router-link to="/tipos" class="nav-child"
            ><span @click="Show()">Tipos de comida</span></router-link
          >
          <router-link to="/users" class="nav-child"
            ><span @click="Show()">Usuarios</span></router-link
          >
          <router-link to="/orders" class="nav-child"
            ><span @click="Show()">Ordenes</span></router-link
          >
          <router-link to="/cuenta" class="nav-child"
            ><span @click="Show()">Mi cuenta</span></router-link
          >
        </div>
      </div>
    </nav>
    <br />
    <router-view></router-view>
    <FooterComponent />
  </div>
</template>

<script>
import user from "./mixins/user";
import FooterComponent from "./components/FooterComponent";
import Home from "./pages/Home";
export default {
  mixins: [user],
  data() {
    return {
      show_home: true,
    };
  },
  components: {
    FooterComponent,
    Home,
  },
  methods: {
    Show() {
      this.show_home = false;
    },
  },
};
</script>

<style lang="scss">
$first-color: #E40754;
$second-color: #FF4B2B;
* {
  margin: 0;
  padding: 0;
}
body {
  background: #424A60;
  margin-bottom: 80px;
  div {
    .navbar-dark {
      .navbar-content {
        width: 100%;
        height: 40px;
        padding: 0;
        margin: 0;
        border-bottom: 2px solid $second-color;
        .verify {
          .nav-child {
            color: #fff;
            text-decoration: none;
            font-size: 15px;
            padding: 50px;
            padding-bottom: 18px;
            padding-top: 10px;
          }
          .router-link-active {
            background: linear-gradient(to right, $second-color, $first-color);
            width: 200px;
            height: 30px;
          }
        }
      }
    }
  }
}
</style>
