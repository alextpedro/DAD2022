import { createRouter, createWebHistory, parseQuery } from 'vue-router';
import Login from '@/components/auth/Login.vue';
import RegisterView from '@/components/auth/Register.vue';
import Menu from '@/components/menu/Menu.vue';
import Order from '@/components/orders/Order.vue';
import Orders from '@/components/orders/Orders.vue';
import Item from '@/components/menu/Item.vue';
import Chefs from '@/components/employees/Chefs.vue';
import MyOrders from '@/components/orders/MyOrders.vue';
import EditUser from '@/components/users/EditUser.vue';
import ListUsers from '@/components/users/ListUsersEx.vue';
import PlataformStatisticsEx from '@/components/statistics/PlataformStatisticsEx.vue';

import { useUserStore } from '@/stores/user.js';

//Vue router routes
const routes = [
	{
		path: '/',
		name: 'Home',
		component: Orders
	},
	{
		path: '/login',
		name: 'Login',
		component: Login
	},
	{
		path: '/register',
		name: 'RegisterView',
		component: RegisterView
	},
	{
		path: '/menu',
		name: 'Menu',
		component: Menu
	},
	{
		path: '/order',
		name: 'Order',
		component: Order,
	},
	{
		path: '/myorders',
		name: 'MyOrders',
		component: MyOrders,
	},
	{
		path: '/listusers',
		name: 'ListUsers',
		component: ListUsers
	},
	{
		path: '/editUser/:id',
		name: 'EditUser',
		component: EditUser,
		props: route => ({ id: parseInt(route.params.id) })
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
	{
		path: '/chefs',
		name: 'Chefs',
		component: Chefs
	},
];

const router = createRouter({
	history: createWebHistory(),
	routes,
});

let handlingFirstRoute = true;
router.beforeEach(async (to, from, next) => {
	const userStore = useUserStore();
	if (handlingFirstRoute) {
		handlingFirstRoute = false;
		await userStore.restoreToken();
	}
	if ((to.name == 'Login') || (to.name == 'Home')) {
		next();
		return;
	}
	if (!userStore.user && !(to.name == 'Menu')) {
		next({ name: 'Login' });
		return;
	}
	if (to.name == 'Plataformstatistics') {
		if (userStore.user.type != 'EM') {
			next({ name: 'Home' });
			return;
		}
	}
	if (to.name == 'EditUser') {
		if ((userStore.user.type == 'A') || (userStore.user.id == to.params.id)) {
			next();
			return;
		}
	}
	if (to.name == 'EditItem') {
		if (userStore.user.type != 'EM') {
			next({ name: 'Home' });
			return;
		}
	}
	if ((to.name == 'Chefs')) {
		if (userStore.user.type != 'EC') {
			next({ name: 'Home' });
			return;
		}
	}
	next();
});

export default router;
