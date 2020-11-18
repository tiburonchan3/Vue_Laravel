<template>
  <tr>
    <th scope="row">{{ producto.id }}</th>
    <td>
      <img
        :src="'/images/productos/' + producto.image"
        width="80"
        height="80"
      />
    </td>
    <td>{{ producto.nombre }}</td>
    <td>$ {{ producto.precio }}</td>
    <td>{{ producto.stock }}</td>
    <td>{{ producto.tipo }}</td>
    <td>{{ producto.created_at }}</td>
    <td>{{ producto.updated_at }}</td>
    <td>
      <button
        @click="Edit(producto.id)"
        class="btn btn-sm btn-info text-white"
        data-target="#product-modal-edit"
        data-toggle="modal"
      >
        Editar
      </button>
      <button @click="Destroy(producto)" class="btn btn-sm btn-danger">
        Eliminar
      </button>
    </td>
    <EditProductFormComponent :productoEdit="productoEdit" />
  </tr>
</template>

<script>
import EditProductFormComponent from "./EditProductFormComponent";
import Vue from "vue";
export const OnDeleteEvent = new Vue();
export default {
  props: {
    producto: Object,
  },
  components: {
    EditProductFormComponent,
  },
  data() {
    return {
      productoEdit: {},
    };
  },
  methods: {
    Destroy(prod) {
      toast
        .fire({
          toast: false,
          title: "Estas seguro de eliminar este producto?",
          showCancelButton: true,
          confirmButtonText: `Eliminar`,
          showConfirmButton: true,
          denyButtonText: `Cancelar`,
          position: "center",
          timer: 9000,
        })
        .then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            axios
              .delete("/producto/destroy/" + prod.id, {
                id: prod.id,
              })
              .then((resp) => {
                OnDeleteEvent.$emit('deleted',resp);
                toast.fire({
                  icon: "success",
                  title: "Se Elimino correctamente",
                });
              })
              .catch((err) => {
                console.log(err);
              });
          } else {
            toast.fire("Se cancelo la peticion", "", "info");
          }
        });
    },
    Edit(id) {
      axios
        .get("/producto/edit/" + id)
        .then(({ data: datos }) => {
          this.productoEdit = datos.data;
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
