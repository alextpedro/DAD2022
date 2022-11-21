import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/Login.vue'

//Vue router routes
const routes = [
	{ path: '/login', component: Login },
	// { path: '/', component: Home },
	// { path: '/about', component: About },
];

const router = createRouter({
	history: createWebHistory(), //TODO: configure on server side for these urls
	routes,
});

export default router;
