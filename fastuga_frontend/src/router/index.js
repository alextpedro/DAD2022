import { createRouter, createWebHistory, parseQuery } from 'vue-router';
import Login from '@/components/auth/Login.vue';
import Register from '@/components/auth/Register.vue';
import HomeView from '@/views/HomeView.vue';
import Menu from '@/components/menu/Menu.vue';
import Order from '@/components/menu/Order.vue';
import Item from '@/components/menu/Item.vue';

import ListUsers from '@/components/users/ListUsersEx.vue';
import PlataformStatisticsEx from '@/components/statistics/PlataformStatisticsEx.vue';

//Vue router routes
const routes = [
	{
		path: '/',
		name: 'Home',
		component: HomeView
	},
	{
		path: '/login',
		name: 'Login',
		component: Login
	},
	{
		path: '/register',
		name: 'Register',
		component: Register
	},
	{
		path: '/menu',
		name: 'Menu',
		component: Menu
	},
	{
		path: '/order/',
		name: 'Order',
		component: Order,
	},
	{
		path: '/listusers',
		name: 'listusers',
		component: ListUsers
	},
	{
		path: '/plataformstatistics',
		name: 'Plataformstatistics',
		component: PlataformStatisticsEx
	},
	{
		path: '/itemEdit',
		name: 'EditItem',
		component: Item
	},
];

const router = createRouter({
	history: createWebHistory(), //TODO: configure on server side for these urls
	routes,
});

export default router;
