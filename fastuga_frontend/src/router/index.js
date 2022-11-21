import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/auth/Login.vue'

//Vue router routes
const routes = [
	{
		path: '/login',
		name: 'Login',
		component: Login
	},
];

const router = createRouter({
	history: createWebHistory(), //TODO: configure on server side for these urls
	routes,
});

export default router;
