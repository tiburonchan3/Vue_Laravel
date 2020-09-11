let user = document.head.querySelector('meta[name="user"]');
let user_info = JSON.parse(user.content);
module.exports = {
    computed:{
        user_log(){
            return user_info
        },
        isAutenticated(){
            return !! user.content
        },
        isAdmin(){
           if(user_info.id_role===1){
               return true
           }
        }
    },
};
