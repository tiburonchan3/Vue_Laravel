<template>
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="lead">Editar mi perfil</h1>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-md-6">
          <form @submit="SubmitForm">
            <div class="form-group">
              <label>Nombre</label>
              <input id="name" class="form-control" :value="user.name" />
            </div>
            <div class="form-group">
              <label>Telefono</label>
              <input
                id="telefono"
                class="form-control"
                :value="user.telefono"
              />
            </div>
            <div class="form-group">
              <label>Direccion</label>
              <input
                id="direccion"
                class="form-control"
                :value="user.direccion"
              />
            </div>
            <div class="form-group">
              <input type="file" @change="onFileChange" />
            </div>
            <div class="form-group">
              <input type="submit" value="Guardar" class="btn btn-primary" />
            </div>
          </form>
        </div>
        <div class="col-md-6">
          <img
            :src="image || '/images/usuarios/' + user.avatar"
            alt=""
            class="img-thumbnail"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
export const EditUser = new Vue();
export default {
  props: {
    user: Object,
  },
  data() {
    return {
      image: "",
    };
  },
  methods: {
    onFileChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
    },
    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = (e) => {
        vm.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    SubmitForm(e) {
      e.preventDefault();
      let name = document.getElementById("name").value;
      let telefono = document.getElementById("telefono").value;
      let direccion = document.getElementById("direccion").value;
      axios
        .put("/user/update", {
          name: name,
          telefono: telefono,
          direccion: direccion,
          avatar: this.image,
        })
        .then((resp) => {
          toast.fire({
            icon: "success",
            title: "Se agrego correctamente",
          });
          EditUser.$emit("edit-user", resp);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
