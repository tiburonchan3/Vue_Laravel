<template>
  <div
    id="product-modal-edit"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body bg-dark p-4">
          <h5 class="lead text-center mb-3">Editar Producto</h5>
          <div class="row">
            <div class="col-8" v-if="productoEdit">
              <form @submit="UpdateProduct">
                <div class="form-group row">
                  <label class="col-form-label col-3">Nombre</label>
                  <input
                    :value="productoEdit.nombre"
                    class="form-control col-9 nombre_producto"
                    type="text"
                    id="nombre_producto"
                  />
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-3">Tipo</label>
                  <select id="id_tipo" class="form-control col-9">
                    <option :value="productoEdit.id_tipo" selected>
                      {{ productoEdit.tipo }}
                    </option>
                    <option
                      v-for="(tipo, index) in tipos"
                      :key="index"
                      :value="tipo.id"
                      v-text="tipo.name"
                    ></option>
                  </select>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-3">Stock</label>
                  <input
                    id="stock"
                    :value="productoEdit.stock"
                    class="form-control col-9"
                    type="text"
                    name=""
                  />
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-3">Precio</label>
                  <input
                    id="precio"
                    :value="productoEdit.precio"
                    class="form-control col-9"
                    type="text"
                    name=""
                  />
                </div>
                <div class="row">
                  <button type="submit" class="btn btn-primary col-3 offset-5">
                    Editar
                  </button>
                  <button
                    class="btn btn-danger col-3 ml-1"
                    data-dismiss="modal"
                  >
                    cancelar
                  </button>
                </div>
              </form>
            </div>
            <div class="col-4 d-flex">
              <img
                v-if="productoEdit"
                :src="'images/productos/' + productoEdit.image"
                class="rounded-circle img"
                alt=""
                width="200"
                height="200"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
export const OnUpdateEvent = new Vue();
export default {
  props: {
    productoEdit: Object,
  },
  data() {
    return {
      tipos: Object,
    };
  },
  mounted() {
    this.GetTipos();
  },
  methods: {
    GetTipos() {
      axios.get("/tipo/show").then((resp) => {
        this.tipos = resp.data.data;
      });
    },
    UpdateProduct(e) {
      e.preventDefault();
      this.nombre = document.getElementById("nombre_producto").value;
      this.id_tipo = document.getElementById("id_tipo").value;
      this.stock = document.getElementById("stock").value;
      this.precio = document.getElementById("precio").value;
      if (
        this.nombre != "" &&
        this.id_tipo != "" &&
        this.stock != "" &&
        this.precio != ""
      ) {
        axios
          .put("/producto/update/" + this.productoEdit.id, {
            id: this.productoEdit.id,
            nombre: this.nombre,
            id_tipo: this.id_tipo,
            stock: this.stock,
            precio: this.precio,
          })
          .then((resp) => {
            $("#product-modal-edit").modal("hide");
            OnUpdateEvent.$emit("product-edit", resp);
            toast.fire({
              icon: "success",
              title: "Se Actualizo correctamente",
            });
          })
          .catch((err) => {
            console.log(err.response.data);
          });
      }
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
