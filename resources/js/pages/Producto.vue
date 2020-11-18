<template>
  <div class="container">
    <ProductoForm />
    <div class="row">
      <div class="col-12">
        <table class="table text-white">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Foto</th>
              <th scope="col">Nombre</th>
              <th scope="col">Precio</th>
              <th scope="col">Stock</th>
              <th scope="col">Tipo de comida</th>
              <th scope="col">Fecha de creacion</th>
              <th scope="col">Fecha de actualizacion</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <ProductItemListComponent v-for="(prod,index) in productos" :key="index" :producto="prod" />
          </tbody>
        </table>
        <div class="row mt-5">
          <div class="col-md-8">
            <nav aria-label="Page navigation">
              <ul class="pagination">
                <li
                  v-bind:class="{ disabled: !pagination.first_link }"
                  class="page-item"
                  aria-current="page"
                >
                  <a
                    class="page-link"
                    href="#"
                    @click="GetResult(pagination.first_link)"
                    >&laquo;</a
                  >
                </li>
                <li
                  v-bind:class="{ disabled: !pagination.prev_link }"
                  class="page-item"
                  aria-current="page"
                >
                  <a
                    class="page-link"
                    href="#"
                    @click="GetResult(pagination.prev_link)"
                    >Next</a
                  >
                </li>
                <li
                  v-for="n in pagination.last_page"
                  :key="n"
                  v-bind:class="{ active: pagination.current_page == n }"
                  class="page-item"
                  aria-current="page"
                >
                  <a
                    class="page-link"
                    href="#"
                    @click="GetResult(pagination.path_page + n)"
                    >{{ n }}</a
                  >
                </li>
                <li
                  v-bind:class="{ disabled: !pagination.next_link }"
                  class="page-item"
                  aria-current="page"
                >
                  <a
                    class="page-link"
                    href="#"
                    @click="GetResult(pagination.next_link)"
                    >Prev</a
                  >
                </li>
                <li
                  v-bind:class="{ disabled: !pagination.last_link }"
                  class="page-item"
                  aria-current="page"
                >
                  <a
                    class="page-link"
                    href="#"
                    @click="GetResult(pagination.last_link)"
                    >&raquo;</a
                  >
                </li>
              </ul>
            </nav>
          </div>
          <div class="col-md-4 text-white">
            Pagina:{{ pagination.from_page }} - {{ pagination.to_page }} Total:
            {{ pagination.total_pages }}
          </div>
          <br />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import ProductoForm from "../components/ProductoForm";
import ProductItemListComponent from "../components/ProductItemListComponent";
import {OnUpdateEvent} from "../components/EditProductFormComponent";
import {OnDeleteEvent} from "../components/ProductItemListComponent";
export default {
  components: {
    ProductoForm,
    ProductItemListComponent
  },
  data() {
    return {
      tipos: [],
      productos: [],
      pagination: {},
      nombre: "",
      id_tipo: "",
      id: "",
      stock: 0,
      precio: 0,
    };
  },
  mounted() {
    this.GetResult("/producto/show");
    OnDeleteEvent.$on('deleted',resp=>{
        this.GetResult("/producto/show")
    });
    OnUpdateEvent.$on('product-edit',resp=>{
        this.GetResult("/producto/show")
    })
  },
  methods: {
    GetProducto(url) {
      axios.get("/producto/edit").then((resp) => {
        this.tipos = resp.data.data;
      });
    },
    GetResult(url) {
      axios
        .get(url)
        .then(({ data: datos }) => {
          this.productos = datos.data;
          this.pagination = {
            current_page: datos.meta.current_page,
            last_page: datos.meta.last_page,
            from_page: datos.meta.from,
            to_page: datos.meta.to,
            total_pages: datos.meta.total,
            path_page: datos.meta.path + "?page=",
            first_link: datos.links.first,
            last_link: datos.links.last,
            prev_link: datos.links.prev,
            next_link: datos.links.next,
          };
        })
        .catch((err) => {
          console.log(err.response.data);
        });
    },
  },
};
</script>
<style lang="scss">
</style>
