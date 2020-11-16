<template>
    <div>
        <!--Catalogo de productos-->
        <div class="container" v-if="!show_detail">
            <div class="row">
                <div class="col-md-8">
                    <input
                        @keyup="Search()"
                        type="text"
                        class="form-control"
                        placeholder="Ecribe para buscar"
                        v-model="search"
                    />
                </div>
                <Cart />
            </div>
            <br /><br />
        </div>
        <div class="catalogo" v-if="!show_search && !show_detail">
            <div class="row">
                <div
                    v-for="producto in productos"
                    :key="producto.id"
                    class="col-md-3 catalogo-child card card-product"
                >
                    <div class="image">
                        <img :src="'/images/productos/' + producto.image" />
                    </div>
                    <div class="details">
                        <div class="center">
                            <h1>
                                {{ producto.nombre }}<br /><span
                                    class="badge badge-success text-white"
                                    >${{ producto.precio }}</span
                                >
                            </h1>
                            <p>Categoria: {{ producto.tipo }}</p>
                            <br />
                            <button
                                class="btn btn-sm btn-success"
                                @click="addCart(producto)"
                            >
                                Add to cart
                            </button>

                            <button
                                class="btn btn-sm btn-primary"
                                @click="Detail(producto)"
                            >
                                Ver mas
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Fin Catalogo de productos-->
        <!--Resultado de buscar producto-->
        <div class="catalogo" v-else-if="!show_detail">
            <h1 v-if="!prod_search.length" class="text-center text-white">
                No hay productos para mostrar
            </h1>
            <div class="row" v-else>
                <div
                    v-for="(prod, index) in prod_search"
                    :key="index"
                    class="col-md-3 catalogo-child card card-product"
                >
                    <div class="image">
                        <img :src="'/images/productos/' + prod.image" />
                    </div>
                    <div class="details">
                        <div class="center">
                            <h1>
                                {{ prod.nombre }}<br /><span
                                    class="badge badge-success text-white"
                                    >${{ prod.precio }}</span
                                >
                            </h1>
                            <p>Categoria: {{ prod.tipo }}</p>
                            <br />
                            <button class="btn btn-sm btn-success">
                                Add to cart
                            </button>
                            <button
                                class="btn btn-sm btn-primary"
                                @click="Detail(prod)"
                            >
                                Ver mas
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Fin de resultado buscar producto-->
        <!--PAaginacion de Catalogo de productos-->
        <div class="container mt-5" v-if="!show_detail">
            <div class="row mt-5" v-if="!show_search">
                <div class="col-md-8">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li
                                v-bind:class="{
                                    disabled: !pagination.first_link
                                }"
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
                                v-bind:class="{
                                    disabled: !pagination.prev_link
                                }"
                                class="page-item"
                                aria-current="page"
                            >
                                <a
                                    class="page-link"
                                    href="#"
                                    @click="GetResult(pagination.prev_link)"
                                    >Prev</a
                                >
                            </li>
                            <li
                                v-for="n in pagination.last_page"
                                :key="n"
                                v-bind:class="{
                                    active: pagination.current_page == n
                                }"
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
                                v-bind:class="{
                                    disabled: !pagination.next_link
                                }"
                                class="page-item"
                                aria-current="page"
                            >
                                <a
                                    class="page-link"
                                    href="#"
                                    @click="GetResult(pagination.next_link)"
                                    >Next</a
                                >
                            </li>
                            <li
                                v-bind:class="{
                                    disabled: !pagination.last_link
                                }"
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
                <div class="col-md-4">
                    Pagina:{{ pagination.from_page }} -
                    {{ pagination.to_page }} Total: {{ pagination.total_pages }}
                </div>
            </div>
        </div>
        <!--Fin de paginacion-->
        <!--Vista de detalle-->
        <div v-if="show_detail && !show_search">
            <div class="row">
                <div class="col-md-8 offset-2 mr-3">
                    <div class="card bg-dark text-white">
                        <div class="card-body">
                            <button
                                class="btn close"
                                @click="show_detail = false"
                                type="button"
                            >
                                <span aria-hidden="true" class="text-white"
                                    >&times;</span
                                >
                            </button>
                            <Detail :product="detail" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Fin vista de detalle-->
    </div>
</template>
<script>
//se importa el componente del carrito
import Cart from "./Cart";
//se importa el componente de detalle
import Detail from "./Detail";
//se importa VUE
import Vue from "vue";
//Se crea la constante que almacena el evento para gregar al carrito
export const AddCartEvent = new Vue();
export default {
    components: {
        Cart,
        Detail
    },
    data() {
        return {
            //para mostrar y ocultar el contenedor el detalle
            show_detail: false,
            //almacena el producto que se obtiene de la busqueda
            prod_search: {},
            //almacena el valor del input para buscar un producto
            search: "",
            //para mostrar y ocultar el contenedos de busqueda
            show_search: false,
            //almacena todos los productos que se obtienen
            productos: {},
            //sirve para la funcion de paginacion
            pagination: {},
            //se enviara como prop al componente DETAIL
            detail: {}
        };
    },
    methods: {
        //obtiener todos los productos
        GetResult(url) {
            //se recibe por axios
            axios
                .get(url)
                //respuesta que envia laravel
                .then(({ data: datos }) => {
                    //la variable se iguala al arreglo que envia laravel
                    this.productos = datos.data;
                    //se usa para la paginacion
                    this.pagination = {
                        //pagina actual
                        current_page: datos.meta.current_page,
                        //pagina anterior de la paginacion
                        last_page: datos.meta.last_page,
                        //pagina de destino de la paginacion
                        from_page: datos.meta.from,
                        //numero de resultados de la paginacion
                        to_page: datos.meta.to,
                        //total de paginas en la paginacion
                        total_pages: datos.meta.total,
                        path_page: datos.meta.path + "?page=",
                        //primera pagina de la paginacion
                        first_link: datos.links.first,
                        //ultima pagina de la paginacion
                        last_link: datos.links.last,
                        //pagina anterior de la paginacion
                        prev_link: datos.links.prev,
                        //pagina siguiente de la paginacion
                        next_link: datos.links.next
                    };
                })
                //en caso de error
                .catch(err => {
                    //se muestra por pantalla el mensaje de error
                    console.log(err.response.data);
                });
        },
        //metodo para buscar un producto
        Search() {
            axios
                .post("/producto/search", { nombre: this.search })
                //respuesta de laravel
                .then(({ data: prod }) => {
                    //se valida que el input de busqueda no este vacio
                    if (this.search != "") {
                        //se asigna los datos resividos a la variable prod_search
                        this.prod_search = prod.data;
                        //se muestra el contenido de busqueda
                        this.show_search = true;
                    } else {
                        //se oculta el contenido de busqueda
                        this.show_search = false;
                    }
                });
        }, //metodo para ver el detalle del producto
        //metodo para ver el detalle de un producto
        Detail(prod) {
            //esto servira para mandar por props el producto al componente DETAIL
            //se iguala al objeto del producto que resive
            this.detail = prod;
            //se oculata la barra de busqueda
            this.show_search = false;
            //se muestra el contenedor de detalle
            this.show_detail = true;
        },
        //metodo para agregar al carrito
        addCart(prod) {
            //emitimos el evento que activara la funcion del componente CART
            //Se envia el producto en el evento
            AddCartEvent.$emit("cart-load", prod);
        }
    },
    //se ejecutara al cargar la pagina
    mounted() {
        //ejecutamos la funcion que cargara los productos
        this.GetResult("/producto/show");
    }
};
</script>
<style lang="scss">
@import "Styles/catalogo.style";
</style>
