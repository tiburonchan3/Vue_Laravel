<template>
  <div>
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-4 offset-1">
          <img
            class="avatar"
            :src="'/images/usuarios/' + user.avatar || url"
            alt="None"
            srcset=""
          />
        </div>
        <div class="col-md-6">
          <label class="text-left lead text-white text-lg mt-3">Nombre: </label
          ><span class="text-white"> {{ user.name }}</span>
          <br />
          <label class="text-left lead text-white text-lg mt-3">Email: </label
          ><span class="text-white"> {{ user.email }}</span>
          <br />
          <label class="text-left lead text-white text-lg mt-3"
            >Telefono: </label
          ><span class="text-white"> {{ user.telefono }}</span>
          <br />
          <label class="text-left lead text-white text-lg mt-3"
            >Direccion: </label
          ><span class="text-white"> {{ user.direccion }}</span>
          <br />
          <div class="d-flex mt-4">
            <button
              type="button"
              data-toggle="modal"
              data-target=".bd-example-modal-lg"
              class="btn btn-edit text-white"
            >
              Editar Perfil
            </button>
            <button @click="logout()" class="btn btn-exit ml-5 text-white">
              Cerrar Sesion
            </button>
          </div>
        </div>
      </div>
    </div>

    <div
      id="modal-edit-user"
      class="modal fade bd-example-modal-lg"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myLargeModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <EditFormComponent :user="user" />
      </div>
    </div>
  </div>
</template>

<script>
import EditFormComponent, { EditUser } from "../components/EditFormComponent";
export default {
  components: {
    EditFormComponent,
  },
  data() {
    return {
      user: {},
      url: "",
    };
  },
  mounted() {
    this.ObtenerUsuario();
    EditUser.$on("edit-user", (resp) => {
      this.ObtenerUsuario();
      $("#modal-edit-user").modal("hide");
    });
  },
  methods: {
    ObtenerUsuario() {
      axios
        .get("/user/profile")
        .then(({ data: datos }) => {
          this.user = datos.data;
        })
        .catch((err) => {
          console.log(err.response.data);
        });
    },
    logout() {
      axios
        .post("/logout")
        .then((response) => {
          this.$router.push("/login");
          location.reload();
        })
        .catch((error) => {
          location.reload();
        });
    },
  },
};
</script>

<style lang="scss">
.avatar {
  width: 300px;
  border-radius: 50%;
}
.btn-exit {
  padding: 10px;
  font-size: 15px;
  border: 2px solid orangered;
  border-radius: 10px;
  &:focus,
  &:active,
  &:hover {
    background: orangered;
  }
}
.btn-edit {
  border: 2px solid #1081E0;
  padding: 10px;
  font-size: 15px;
  border-radius: 10px;
  &:focus,
  &:active,
  &:hover {
    background: #1081E0;
  }
}
</style>
