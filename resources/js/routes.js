import Catalogo from './pages/Catalogo.vue';
import MiCuenta from './pages/MiCuenta.vue';
import Producto from './pages/Producto.vue';
import Tipo from './pages/Tipo.vue';
import User from './pages/User.vue';
import Checkout from './pages/Checkout.vue';
import MisCompras from './pages/MisCompras.vue';
import Orders from './pages/Orders';
import Home from './pages/Home.vue';
import Detail from './pages/Detail.vue';

export const routes = [
    {
        name: 'home',
        path: '/home',
        component: Home
    },
    {
        name: 'cuenta',
        path: '/cuenta',
        component: MiCuenta
    },
    {
        name: 'catalogo',
        path: '/catalogo',
        component: Catalogo
    },
    {
        name: 'productos',
        path: '/productos',
        component: Producto
    },
    {
        name: 'tipos',
        path: '/tipos',
        component: Tipo
    },
    {
        name: 'users',
        path: '/users',
        component: User
    },
    {
        name: 'checkout',
        path: '/checkout',
        component: Checkout
    },
    {
        name: 'compras',
        path: '/compras',
        component: MisCompras
    },
    {
        name: 'orders',
        path: '/orders',
        component: Orders
    },
    {
        name: 'detail',
        path: '/detail/:id',
        component: Detail
    }
];
