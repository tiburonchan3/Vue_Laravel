<template>
    <div>
       <div class="container mt-5">
           <div class="row">
               <div class="col-md-4 offset-1">
                    <img class="avatar" :src="'/images/usuarios/'+user.avatar" alt="" srcset="">
               </div>
               <div class="col-md-6">
                    <label class="text-left lead text-white text-lg mt-3">Nombre: </label><span class="text-white"> {{user.name}}</span>
                    <br>
                    <label class="text-left lead text-white text-lg mt-3">Email: </label><span class="text-white"> {{user.email}}</span>
                    <br>
                    <label class="text-left lead text-white text-lg mt-3">Telefono: </label><span class="text-white"> {{user.telefono}}</span>
                    <br>
                    <label class="text-left lead text-white text-lg mt-3">Direccion: </label><span class="text-white"> {{user.direccion}}</span>
                    <br>
                    <div class="d-flex mt-4">
                        <button class="btn btn-edit text-white">Editar Perfil</button>
                        <button @click="logout()" class="btn btn-exit ml-5 text-white"> Cerrar Sesion</button>
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
                user:{}
            }
        },
        mounted(){
            this.ObtenerUsuario();
        },
        methods:{
            ObtenerUsuario(){
                axios
                .get('/user/profile')
                .then(({data:datos}) =>{
                    this.user = datos.data
                    console.log(this.user);
                })
                .catch(err=>{
                    console.log(err.response.data);
                })
            },
             logout(){
                axios.post('/logout').then(response => {
                    this.$router.push("/login")
                    location.reload();

                }).catch(error => {
                    location.reload();
                });
        }
        }
    }
</script>

<style lang="scss">
    .avatar{
        width: 300px;
        border-radius: 50%;
    }
    .btn-exit{
        padding: 10px;
        font-size: 15px;
        border:2px solid orangered;
        border-radius: 10px;
        &:focus, &:active, &:hover{
            background: orangered;
        }
    }
    .btn-edit{
        border: 2px solid #1081E0;
        padding: 10px;
        font-size: 15px;
        border-radius: 10px;
        &:focus, &:active, &:hover{
            background: #1081E0;
        }
    }
</style>
