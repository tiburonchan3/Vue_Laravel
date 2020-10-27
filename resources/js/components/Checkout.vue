<template>
    <div class="container">
        <table class="table text-white">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Producto</th>
                            <th scope="col">Imagen</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody v-for="(cart, index) in carts" :key="index">
                        <tr>
                            <th scope="row" v-text="cart.nombre"></th>
                            <td><img :src="'/images/productos/'+cart.image" class="img-thumbnail" width="75" height="75" alt=""></td>
                            <td><input style="width:40px" readonly class="val" :value="cart.cantidad"/>
                                <button class="btn btn-sm btn-success" @click="addCart(cart)">+</button>
                                <button class="btn btn-sm btn-danger" @click="removeCart(cart)">-</button>
                            </td>
                            <td>${{cart.precio}}</td>
                            <td>${{cart.cantidad * cart.precio}}</td>
                        </tr>
                    </tbody>
                </table>
                <h4 class="text-right text-white lead">
                    Total a pagar: ${{total}}
                    <br>
                    <button class="btn btn-sm btn-success mt-4" @click="SaveOrder()">
                        Realizar Compra
                    </button>
                </h4>
    </div>
</template>

<script>
export default {
    data(){
        return{
            carts:[],
            total:0,
            cantidad: 0
        }
    },
    mounted(){
        this.viewCart();
    },
    methods:{
         viewCart(){

        //se comprueba que exitan productos en el carrito
        if(localStorage.getItem('carts')){

            //se iguala la variable al arreglo de productos del carrito
            this.carts = JSON.parse(localStorage.getItem('carts'));
            console.log(this.carts)
            //se inicializa la cantidad de productos del carrito
            //se establece el total de la orden
            this.total = this.carts.reduce((total,item)=>{
                return total + item.cantidad* item.precio
            },0);
            }
        },storeCart(){
                //variable que almacena el arreglo del producto convertido
                let parsed = JSON.stringify(this.carts);
                //se agrega el producto al carrito
                localStorage.setItem('carts',parsed);
                //se ejecuta el metodo para actualizar el carrito
                this.viewCart();
            },
             SaveOrder(){

        //variable que obtiene los productos del carrito
        let data = {
           data:this.carts
        };
       // se envia un post por axios a laravel con los datos del carrito
        axios
        .post('/order/store',{data})
        //respuesta de laravel
        .then(resp=>{
            //se vacia el arreglo de productos del carrito
            this.carts = [];
            //se vacia el total de la compra
            this.total=0;
            //se vacia la cantidad de productos del carrito
            this.badge=0;
            //se vacia el local storage
            localStorage.removeItem('carts');
            //se muestra una alerta
            toast.fire({
                icon: 'success',
                title: 'Se orden a sido registrada ',
            });
       })
       //en caso de error
       .catch(err=>{
           //se muestra el mensaje de error en la consola
           console.log(err.response.data);
       })
    },
     addCart(prod){
                //variable que se usa para buscar un producto en el carrito
                var f =_.find(this.carts,['id',prod.id]);
                //se comprueba si hay un producto con el id de la variable
                if(typeof f == 'object'){
                    //variable que guarda la posicion del producto repetido
                    var index = _.indexOf(this.carts,f)
                    //se incrementa la cantida del producto repetido
                    this.carts[index].cantidad++
                    //se muestra una alerta de exito
                    // toast.fire({
                    //     icon: 'success',
                    //     title: 'Su orden se ah actualizado',
                    // });
                    //se ejecuta el metodo para guardar el producto en el carrito
                    this.storeCart();
                    //se ejecuta el metodo para ver los carritos del producto
                    this.viewCart();
                    console.log(this.carts)
                }
     },
            //metodo para eliminar productos del carrito
         removeCart(cart){
            /*variable que se creo para buscar el id del
            producto que se eliminara del carrito*/
            var f =_.find(this.carts,['id',cart.id]);
            //se compreba que el id exista
            if(typeof f == 'object'){
                //variable que almacena la pocision del producto repetido
                var index = _.indexOf(this.carts,f)
                //se verifica que el producto a eliminar sea menor o igual a uno
                if(this.carts[index].cantidad <= 1){
                    //se elimina del arreglo de productos en el carrito
                    this.carts.splice(cart,1);
                  toast.fire({
                    icon: 'warning',
                    title: 'eliminaste el producto',
                });
                    //se ejecuta el metodo que guarda el carrito para refrescar
                    this.storeCart();
                //si la cantidad es mayor a uno
                }else{
                    //la cantidad del producto disminuye uno
                    this.carts[index].cantidad--
                    //se ejecuta el metodo que guarda el carrito para refrescar
                    this.storeCart();
                }
            }
        },
    },


}
</script>

<style>

</style>
