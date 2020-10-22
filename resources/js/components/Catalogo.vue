<template>
    <div>
        <!--Catalogo de productos-->
        <div class="container" v-if="!show_detail">
           <div class="row">
               <div class="col-md-8">
                    <input @keyup="Search()" type="text" class="form-control" placeholder="Ecribe para buscar" v-model="search">
               </div>
               <div class="col-md-1 offset-2">
                    <button class="btn" data-target="#myModalRight" data-toggle="modal">
                    <i class="fa fa-shopping-cart" style="font-size:30px"></i>
                    <span style="position:absolute;top:-4px;left:10px" class="badge badge-info text-white">{{badge}}</span>
                    </button>
                </div>
           </div>
            <br><br>
        </div>
        <div class="catalogo" v-if="!show_search && !show_detail">
            <div class="row">
                 <div v-for="producto in productos" :key="producto.id" class="col-md-3 catalogo-child card card-product">
                     <div class="image">
                        <img :src="'/images/productos/'+producto.image"/>
                    </div>
                    <div class="details">
                        <div class="center">
                            <h1>{{producto.nombre}}<br><span class="badge badge-success text-white">${{producto.precio}}</span></h1>
                            <p>Categoria: {{producto.tipo}}</p><br>
                            <button class="btn btn-sm btn-success" @click="addCart(producto)">Add to cart</button>
                            <button class="btn btn-sm btn-primary" @click="Detail(producto.id)">Ver mas</button>
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
                 <div v-for="(prod,index) in prod_search" :key="index"  class="col-md-3 catalogo-child card card-product">
                     <div class="image">
                        <img :src="'/images/productos/'+prod.image"/>
                    </div>
                    <div class="details">
                        <div class="center">
                            <h1>{{prod.nombre}}<br><span class="badge badge-success text-white">${{prod.precio}}</span></h1>
                            <p>Categoria: {{prod.tipo}}</p><br>
                            <button class="btn btn-sm btn-success">Add to cart</button>
                            <button class="btn btn-sm btn-primary" @click="Detail(prod.id)">Ver mas</button>
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
                            <li v-bind:class="{disabled:!pagination.first_link}" class="page-item" aria-current="page">
                                <a class="page-link" href="#" @click="GetResult(pagination.first_link)">&laquo;</a>
                            </li>
                            <li v-bind:class="{disabled:!pagination.prev_link}" class="page-item" aria-current="page">
                                <a class="page-link" href="#" @click="GetResult(pagination.prev_link)">Prev</a>
                            </li>
                            <li v-for="n in pagination.last_page" :key="n" v-bind:class="{active: pagination.current_page == n}" class="page-item" aria-current="page">
                                <a class="page-link" href="#" @click="GetResult(pagination.path_page + n)">{{n}}</a>
                            </li>
                            <li v-bind:class="{disabled:!pagination.next_link}" class="page-item" aria-current="page">
                                <a class="page-link" href="#" @click="GetResult(pagination.next_link)">Next</a>
                            </li>
                            <li v-bind:class="{disabled:!pagination.last_link}" class="page-item" aria-current="page">
                                <a class="page-link" href="#" @click="GetResult(pagination.last_link)">&raquo;</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-4">
                    Pagina:{{pagination.from_page}} - {{pagination.to_page}}
                    Total: {{pagination.total_pages}}
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
                            <button class="btn close" @click="show_detail=false" type="button">
                                <span aria-hidden="true" class="text-white">&times;</span>
                            </button>
                            <h5 class="card-title">{{detail.nombre}}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="lead mb-5"><span class="badge badge-success mb-3">${{detail.precio}}</span> <br>
                                        Tipo de comida: {{detail.tipo}}
                                    </h3>
                                    <button class="btn btn-success btn-sm mb-4" @click="addCart(detail)">Ordenar</button>
                                    <h3 class="heading">Reviews</h3>
                                    <div class="review-rating">
                                        <div class="left-review">
                                            <div class="review-title">{{ totalrate }}</div>
                                            <div class="review-people"><i class="fa fa-user"></i> {{ totaluser }} total</div>
                                        </div>
                                        <div class="right-review">
                                            <div class="row-bar">
                                                <div class="left-bar">5</div>
                                                <div class="right-bar">
                                                    <div class="bar-container">
                                                        <div class="bar-5" id="bar__5" :style="'width:'+bar5+'%;'"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-bar">
                                                <div class="left-bar">4</div>
                                                <div class="right-bar">
                                                    <div class="bar-container">
                                                        <div class="bar-4" style="width: 0%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-bar">
                                                <div class="left-bar">3</div>
                                                <div class="right-bar">
                                                    <div class="bar-container">
                                                        <div class="bar-3" style="width: 0%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-bar">
                                                <div class="left-bar">2</div>
                                                <div class="right-bar">
                                                    <div class="bar-container">
                                                        <div class="bar-2" style="width: 0%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-bar">
                                                <div class="left-bar">1</div>
                                                <div class="right-bar">
                                                    <div class="bar-container">
                                                        <div class="bar-1" style="width: 0%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-5" v-if="!myRating.length">
                                        <p class="text-muted text-small">Puedes opinar acerca de este platillo</p>
                                        <star-rating :star-size="30" v-model="rating" :increment="0.5" text-class="custom-text" ></star-rating>
                                        <textarea placeholder="Escribe un comentario acerca de este producto" v-model="comment" name="comment" class="form-control mt-2 mb-2" id="comment" cols="4" rows="3"></textarea>
                                        <button @click="setRating(detail.id)" class="btn btn-primary btn-sm d-flex">Votar</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <img :src="'/images/productos/'+detail.image" class=" img-thumbnail" alt="">
                                </div>
                            </div>
                            <div>
                            <p class="lead text-center text-white mt-3">Comentarios acerca del producto</p>
                                <div class="row mb-3" v-for="comment in AllRating" :key="comment.id">
                                    <div class="col-md-1">
                                        <img :src="'/images/'+comment.avatar" class="rounded-circle" alt="no-image" width="50" height="50">
                                    </div>
                                    <div class="col-md-11 pl-3 rating">
                                        <p class="text-info">{{comment.user}}
                                        <star-rating :star-size="15" :read-only="true" :rating="comment.rating"></star-rating>
                                        <p class="text-justify text-white text-small">{{comment.comment}}</p>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Fin vista de detalle-->
        <!--Carrito de compras-->
        <div id="myModalRight" class="modal fade modal-right" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tu carrito</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class=" table table-striped text-left">
                            <tbody>
                                <tr v-for="(cart) in  carts" :key="cart.id">
                                    <td>
                                        <img :src="'/images/productos/'+cart.image" alt="" width="50" height="50">
                                    </td>
                                    <td>{{cart.nombre}}</td>
                                    <td>{{cart.precio}}</td>
                                    <td>{{cart.cantidad}}</td>
                                    <td>
                                        <button @click="removeCart(cart)" class="btn btn-danger btn-sm">X</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        Total: ${{total}} &nbsp;
                        <button @click="Checkout()" class="btn btn-sm btn-success">
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
    export default {
        data(){
            return{
               carts:[],
                //varible temporal que obtiene el  producto del carrito
                cartAdd:{
                    id:'',
                    nombre:'',
                    precio:'',
                    cantidad:1,
                    image:"",
                },
                //variable que obtiene la cantidad de productos del carrito
                badge:0,
                //variable que inicializa la cantidad de productos del carrito
                quantity:1,
                //variable que obtiene el total de la orden
                total:'0',
                totaluser:0,
                totalrate:0,
                product_detail:{},
                show_detail:false,
                prod_search:{},
                search:"",
                show_search:false,
                productos:{},
                pagination:{},
                detail:{},
                //se inicializa el rating del producto
                rating:0,
                //variable de comentario del rating
                comment:'',
                //obtiene el rating del usuario loggeado
                myRating:[],
                //obtiene todos los ratings del producto
                AllRating:[],
                bar1:0,
                bar2:0,
                bar3:0,
                bar4:0,
                bar5:0

            }
        },
        methods:{
            //obtiener todos los productos
            GetResult(url){
                //se recibe por axios
                axios
                .get(url)
                //respuesta que envia laravel
                .then(({data:datos})=>{
                    //la variable se iguala al arreglo que envia laravel
                    this.productos = datos.data
                    //se usa para la paginacion
                    this.pagination={
                        //pagina actual
                        current_page:datos.meta.current_page,
                        //pagina anterior de la paginacion
                        last_page:datos.meta.last_page,
                        //pagina de destino de la paginacion
                        from_page:datos.meta.from,
                        //numero de resultados de la paginacion
                        to_page:datos.meta.to,
                        //total de paginas en la paginacion
                        total_pages:datos.meta.total,
                        path_page:datos.meta.path+"?page=",
                        //primera pagina de la paginacion
                        first_link:datos.links.first,
                        //ultima pagina de la paginacion
                        last_link:datos.links.last,
                        //pagina anterior de la paginacion
                        prev_link:datos.links.prev,
                        //pagina siguiente de la paginacion
                        next_link:datos.links.next
                    };
                })
                //en caso de error
                .catch(err=>{
                    //se muestra por pantalla el mensaje de error
                    console.log(err.response.data)
                })
            },
            //metodo para buscar un producto
            Search(){
                axios
                .post('/producto/search',{nombre:this.search})
                //respuesta de laravel
                .then(({data:prod})=>{
                    if(this.search!=""){
                        this.prod_search=prod.data;
                        this.show_search=true;
                    }else{
                        this.show_search=false;
                    }
                })
            },//metodo para ver el detalle del producto
            //metodo para ver el detalle de un producto
            Detail(id){
                //se ejecuta el metodo para obtener el rating
                this.ShowRating(id);
                //se ejecuta el metodo para obtener el rating del usuario loggeado
                this.MyRating(id);
                //se recibe un get
                axios
                .get('/producto/detail/'+id)
                //respuesta de laravel
                .then(resp=>{
                    //la variable recibe el arreglo de datos que envia laravel
                    this.detail=resp.data.data;
                    //se muestra la seccion de detalle
                    this.show_search=false;
                    this.show_detail = true;
                })
                //en caso de error
                .catch(err=>{
                    //se muestra el mensaje de error
                    console.log(err.response.data)
                })
            },
            //metodo para agregar el rating de un producto
            setRating(id){
                //se envia por axios
                axios
                .post('/rating/new',{product_id:id,comment:this.comment,rating:this.rating})
                //respuesta de que se recibe
                .then(resp=>{
                    //se ejecuta el metodo para mostrar todos los rating
                    this.ShowRating(id);
                    //se ejecuta el metodo para mostrar el rating del usuario loggeado
                    this.MyRating(id);
                })
            },
            //metodo que obtiene el rating del producto seleccionado
            ShowRating(id){
                //se envia por axios el id por post a laravel
                axios
                .post('/rating/all',{id:id})
                //respuesta de laravel
                .then(({data:datos})=>{
                    //la varaiabel recibe el arreglo de datos
                    this.AllRating = datos.data;
                    this.totaluser = datos.data.length;
                    let sum = 0;
                    for(let i = 0; i < datos.data.length; i++){
                    sum += parseFloat(datos.data[i]['rating']);
                    }
                    let avg = sum/datos.data.length
                    this.totalrate = parseFloat(avg.toFixed(1));
                    for(let j = 0; j < datos.data.length; j++){
                        if(parseInt(datos.data[j]['rating']) == '1'){
                            this.bar1 += 1
                        }
                        if(parseInt(datos.data[j]['rating']) == '2'){
                            this.bar2 += 1
                        }
                        if(parseInt(datos.data[j]['rating']) == '3'){
                            this.bar3 += 1
                        }
                        if(parseInt(datos.data[j]['rating']) == '4'){
                            this.bar4 += 1
                        }
                        if(parseInt(datos.data[j]['rating']) == '5'){
                            this.bar5 += 1
                        }
                    }
                })
                //en caso de error
                .catch(err=>{
                    //se muestra el mensaje de error
                    console.log(err.response.data)
                })
            },
            //metodo para obtener el rating del usuario loggeado
            MyRating(id){
                //se envia un post con axios a laravel con el id del producto
                axios
                .post('/rating/show',{id:id})
                //respuesta de laravel
                .then(({data:datos})=>{
                    //la variable recibe el arreglo de datos
                    this.myRating = datos.data;
                })
                //en caso de error
                .catch(err=>{
                //se muestra el mensaje de error
                    console.log(err.response.data)
                })
            },
            //metodo para ver los prosuctos del carrito
            viewCart(){
                //se comprueba que exitan productos en el carrito
                if(localStorage.getItem('carts')){
                    //se iguala la variable al arreglo de productos del carrito
                    this.carts = JSON.parse(localStorage.getItem('carts'));
                    //se inicializa la cantidad de productos del carrito
                    this.badge = this.carts.length;
                    //se establece el total de la orden
                    this.total = this.carts.reduce((total,item)=>{
                        return total + item.cantidad* item.precio
                    },0);
                 }
            },
            //metodo para agregar al carrito
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
                    toast.fire({
                        icon: 'success',
                        title: 'Su orden se ah actualizado',
                    });
                    //se ejecuta el metodo para guardar el producto en el carrito
                    this.storeCart();
                    //se ejecuta el metodo para ver los carritos del producto
                    this.viewCart();
                }
                //si el producto no existe en el carrito
                else{
                    //se iguala a la variable el id del producto
                    this.cartAdd.id = prod.id;
                    //se iguala a la variable el nombre del producto
                    this.cartAdd.nombre = prod.nombre;
                    //se iguala a la variable el precio del producto
                    this.cartAdd.precio = prod.precio;
                    //se iguala a la variable la cantidad del producto
                    this.cartAdd.cantidad = this.quantity;
                    //se iguala a la variable la imagen del producto
                    this.cartAdd.image = prod.image;
                    //se agrega producto al arreglo del carrito
                    if(this.carts.push(this.cartAdd)){
                        //se muestra una alerta de exito
                        toast.fire({
                            icon: 'success',
                            title: 'Se agrego a la orden ',
                        });
                    }
                    //se vacia la variable temporal de los productos
                    this.cartAdd={};
                    //se ejecuta el metodo para guardar el producto
                    this.storeCart();
                    //se ejecuta el metodo para ver los productos del carrito
                    this.viewCart();
                }
            },
            //metodo que guarda el producto seleccionado en el carrito
            storeCart(){
                //variable que almacena el arreglo del producto convertido
                let parsed = JSON.stringify(this.carts);
                //se agrega el producto al carrito
                localStorage.setItem('carts',parsed);
                //se ejecuta el metodo para actualizar el carrito
                this.viewCart();
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
            Checkout(){
                $('#myModalRight').modal('hide');
                this.$router.push("/checkout");
            }
        },
        mounted(){
            this.GetResult('/producto/show');
            this.viewCart();
        },
    }
</script>
<style lang="scss">
    @import 'Styles/catalogo.style';
</style>
