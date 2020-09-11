import AllBook from './components/AllBook.vue';
import Catalogo from './components/Catalogo.vue';
import MiCuenta from './components/MiCuenta.vue';
import Producto from './components/Producto.vue';
import Tipo from './components/Tipo.vue';
import User from './components/User.vue';
import Checkout from './components/Checkout.vue';
import MisCompras from './components/MisCompras.vue';
import Orders from './components/Orders';
import Home from './components/Home.vue';

export const routes = [
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
        name: 'home',
        path: '/home',
        component: Home
    }
];
