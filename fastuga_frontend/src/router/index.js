import { createRouter, createWebHistory } from 'vue-router';
//import HomeView from '../views/HomeView.vue';

//define route components. I.e:
//const Home = { template: '<div>Home</div>' }

//Vue router routes
const routes = [
	// { path: '/', component: Home },
	// { path: '/about', component: About },
];

const router = createRouter({
	history: createWebHistory(), //TODO: configure on server side for these urls
	routes,
});

export default router;
