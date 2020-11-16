<template>
    <div>
        <div class="col-md-1 offset-2">
            <button class="btn" data-target="#myModalRight" data-toggle="modal">
                <i class="fa fa-shopping-cart" style="font-size:30px"></i>
                <span
                    style="position:absolute;top:-4px;left:10px"
                    class="badge badge-info text-white"
                    >{{ badge }}</span
                >
            </button>
        </div>
        <!--Carrito de compras-->
        <div
            id="myModalRight"
            class="modal fade modal-right"
            tabindex="-1"
            role="dialog"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tu carrito</h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class=" table table-striped text-left">
                            <tbody>
                                <tr v-for="cart in carts" :key="cart.id">
                                    <td>
                                        <img
                                            :src="
                                                '/images/productos/' +
                                                    cart.image
                                            "
                                            alt=""
                                            width="50"
                                            height="50"
                                        />
                                    </td>
                                    <td>{{ cart.nombre }}</td>
                                    <td>{{ cart.precio }}</td>
                                    <td>{{ cart.cantidad }}</td>
                                    <td>
                                        <button
                                            @click="removeCart(cart)"
                                            class="btn btn-danger btn-sm"
                                        >
                                            X
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        Total: ${{ total }} &nbsp;
                        <button
                            @click="Checkout()"
                            class="btn btn-sm btn-success"
                        >
                            checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!--Fin de carrito de compras-->
    </div>
</template>

<script>
import { AddCartEvent } from "./Catalogo";
import { AddOnDetail } from "./Detail";
export default {
    data() {
        return {
            resultado: 0,
            carts: [],
            cartAdd: {
                id: "",
                nombre: "",
                precio: "",
                cantidad: 1,
                image: ""
            },
            //variable que obtiene la cantidad de productos del carrito
            badge: 0,
            //variable que inicializa la cantidad de productos del carrito
            quantity: 1,
            //variable que obtiene el total de la orden
            total: "0"
        };
    },
    methods: {
        addOnDetail() {
            AddOnDetail.$on("add-on-detail", prod => {
                this.cartAddProd(prod);
            });
        },
        addCart() {
            AddCartEvent.$on("cart-load", prod => {
                this.cartAddProd(prod);
            });
        },
        cartAddProd(cart) {
            //variable que se usa para buscar un producto en el carrito
            var f = _.find(this.carts, ["id", cart.id]);
            //se comprueba si hay un producto con el id de la variable
            if (typeof f == "object") {
                //variable que guarda la posicion del producto repetido
                var index = _.indexOf(this.carts, f);
                //se incrementa la cantida del producto repetido
                this.carts[index].cantidad++;
                //se muestra una alerta de exito
                toast.fire({
                    icon: "success",
                    title: "Su orden se ah actualizado"
                });
                //se ejecuta el metodo para guardar el producto en el carrito
                this.storeCart();
                //se ejecuta el metodo para ver los carritos del producto
                this.viewCart();
            }
            //si el producto no existe en el carrito
            else {
                //se iguala a la variable el id del producto
                this.cartAdd.id = this.cart.id;
                //se iguala a la variable el nombre del producto
                this.cartAdd.nombre = this.cart.nombre;
                //se iguala a la variable el precio del producto
                this.cartAdd.precio = this.cart.precio;
                //se iguala a la variable la cantidad del producto
                this.cartAdd.cantidad = this.quantity;
                //se iguala a la variable la imagen del producto
                this.cartAdd.image = this.cart.image;
                //se agrega producto al arreglo del carrito
                if (this.carts.push(this.cartAdd)) {
                    //se muestra una alerta de exito
                    toast.fire({
                        icon: "success",
                        title: "Se agrego a la orden "
                    });
                }
                //se vacia la variable temporal de los productos
                this.cartAdd = {};
                //se ejecuta el metodo para guardar el producto
                this.storeCart();
                //se ejecuta el metodo para ver los productos del carrito
                this.viewCart();
            }
        },
        //metodo que guarda el producto seleccionado en el carrito
        storeCart() {
            //variable que almacena el arreglo del producto convertido
            let parsed = JSON.stringify(this.carts);
            //se agrega el producto al carrito
            localStorage.setItem("carts", parsed);
            //se ejecuta el metodo para actualizar el carrito
            this.viewCart();
        },
        //metodo para eliminar productos del carrito
        removeCart(cart) {
            /*variable que se creo para buscar el id del
                producto que se eliminara del carrito*/
            var f = _.find(this.carts, ["id", cart.id]);
            //se compreba que el id exista
            if (typeof f == "object") {
                //variable que almacena la pocision del producto repetido
                var index = _.indexOf(this.carts, f);
                //se verifica que el producto a eliminar sea menor o igual a uno
                if (this.carts[index].cantidad <= 1) {
                    //se elimina del arreglo de productos en el carrito
                    this.carts.splice(cart, 1);
                    //se ejecuta el metodo que guarda el carrito para refrescar
                    this.storeCart();
                    //si la cantidad es mayor a uno
                } else {
                    //la cantidad del producto disminuye uno
                    this.carts[index].cantidad--;
                    //se ejecuta el metodo que guarda el carrito para refrescar
                    this.storeCart();
                }
            }
        },
        viewCart() {
            //se comprueba que exitan productos en el carrito
            if (localStorage.getItem("carts")) {
                //se iguala la variable al arreglo de productos del carrito
                this.carts = JSON.parse(localStorage.getItem("carts"));
                //se inicializa la cantidad de productos del carrito
                this.badge = this.carts.length;
                //se establece el total de la orden
                this.total = this.carts.reduce((total, item) => {
                    return total + item.cantidad * item.precio;
                }, 0);
            }
        },
        Checkout() {
            $("#myModalRight").modal("hide");
            this.$router.push("/checkout");
        }
    },
    mounted() {
        this.addCart();
        this.viewCart();
        this.addOnDetail();
    }
};
</script>

<style lang="scss" scoped></style>
