<template>
  <div class="col-md-3 catalogo-child card card-product">
    <div class="image">
      <img :src="'/images/productos/' + product.image" />
    </div>
    <div class="details">
      <div class="center">
        <h1>
          {{ product.nombre }}<br /><span class="badge badge-success text-white"
            >${{ product.precio }}</span
          >
        </h1>
        <p>Categoria: {{ product.tipo }}</p>
        <br />
        <button class="btn btn-sm btn-success" @click="addCart(product)">
          Add to cart
        </button>

        <router-link
          class="btn btn-sm btn-primary"
          :to="{ name: 'detail', params: { id: product.id } }"
        >
          Ver mas
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
export const ShowDetailEvent = new Vue();
//Se crea la constante que almacena el evento para gregar al carrito
export const AddCartEvent = new Vue();
export default {
  props: {
    product: Object,
  },
  components: {},
  mounted() {},
  data() {
    return {
      //se enviara como prop al componente DETAIL
      detail: {},
    };
  },
  methods: {
    //metodo para ver el detalle de un producto
    Detail(prod) {
      ShowDetailEvent.$emit("show-detail", prod);
      this.$router.push("/detail", params);
    },
    //metodo para agregar al carrito
    addCart(prod) {
      //emitimos el evento que activara la funcion del componente CART
      //Se envia el producto en el evento
      AddCartEvent.$emit("cart-load", prod);
    },
  },
};
</script>

<style lang="scss">
@import "../Styles/catalogo_list.style";
</style>
