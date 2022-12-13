import { createApp, popScopeId } from 'vue';
import { createPinia } from 'pinia';
import axios from 'axios';
import Toaster from '@meforma/vue-toaster';
import { io } from 'socket.io-client';

import App from './App.vue';
import router from './router'; //go to this file to define routes

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'bootstrap';

const serverBaseUrl = 'http://127.0.0.1'; 
const socketUrl = 'http://192.168.56.56';
const apiPort = ':8000';
const socketPort = ':8080';

const app = createApp(App);
const pinia = createPinia();


app.provide('serverBaseUrl', serverBaseUrl);
app.provide('apiPort', apiPort);
app.provide('axios', axios.create({
	baseURL: serverBaseUrl + apiPort + '/api',
	headers: {
		'Access-Control-Allow-Origin': '*',
		'Content-type': 'application/json',
	},
}));

app.provide('socket', io(socketUrl + socketPort));


app.use(Toaster, {
	// Global/Default options
	position: 'top',
	timeout: 3000,
	pauseOnHover: true
}).provide('toast', app.config.globalProperties.$toast);

app.use(router);
app.use(pinia);

app.mount('#app');
