import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/auth/Login.vue'
import HomeView from '../views/HomeView.vue'
import Menu from '../components/menu/Menu.vue'

//Vue router routes
const routes = [
	{
		path: '/',
		name: 'home',
		component: HomeView
	  },
	{
		path: '/login',
		name: 'Login',
		component: Login
	},
	{
		path: '/menu',
		name: 'Menu',
		component: Menu
	},
];

const router = createRouter({
	history: createWebHistory(), //TODO: configure on server side for these urls
	routes,
});

export default router;
