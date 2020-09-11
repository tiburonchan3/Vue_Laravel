<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <table class="table text-white">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Fecha de compra</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(order,index) in orders" :key="index">
                            <td>{{order.created_at}}</td>
                            <td>{{order.product_name}}</td>
                            <td>{{order.cantidad}}</td>
                            <td>${{order.total}}</td>
                        </tr>
                    </tbody>
                </table>
              <div class="row mt-5">
                   <div class="col-md-8">
                       <nav aria-label="Page navigation">
                           <ul class="pagination">
                               <li v-bind:class="{disabled:!pag.first_link}" class="page-item" aria-current="page">
                                   <a class="page-link" href="#" @click="GetResult(pag.first_link)">&laquo;</a>
                               </li>
                                <li v-bind:class="{disabled:!pag.prev_link}" class="page-item" aria-current="page">
                                   <a class="page-link" href="#" @click="GetResult(pag.prev_link)">Next</a>
                               </li>
                               <li v-for="n in pag.last_page" :key="n" v-bind:class="{active: pag.current_page == n}" class="page-item" aria-current="page">
                                   <a class="page-link" href="#" @click="GetResult(pag.path_page + n)">{{n}}</a>
                               </li>
                               <li v-bind:class="{disabled:!pag.next_link}" class="page-item" aria-current="page">
                                   <a class="page-link" href="#" @click="GetResult(pag.next_link)">Prev</a>
                               </li>
                               <li v-bind:class="{disabled:!pag.last_link}" class="page-item" aria-current="page">
                                   <a class="page-link" href="#" @click="GetResult(pag.last_link)">&raquo;</a>
                               </li>
                           </ul>
                       </nav>
                   </div>
                   <div class="col-md-4 text-white">
                   Pagina:{{pag.from_page}} - {{pag.to_page}}
                   Total: {{pag.total_pages}}
                   </div>
               </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
data(){
    return{
        orders:{},
        pag:{}
    }
},
mounted() {
   this.GetResult('/ventas/orders');
},
methods:{
    GetResult(url){
        axios
        .get(url)
        .then(({data:datos})=>{
            this.orders = datos.data
            this.pag={
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
        .catch(err=>{
            console.log(err.response.data)
        })
    },
}
}
</script>
<style lang="scss">

</style>
