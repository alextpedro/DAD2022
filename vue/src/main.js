import { createApp, popScopeId } from 'vue';
import { createPinia } from 'pinia';
import axios from 'axios';
import Toaster from '@meforma/vue-toaster';
import { io } from 'socket.io-client';

import FieldErrorMessage from './components/global/FieldErrorMessage.vue';

import App from './App.vue';
import router from './router'; //go to this file to define routes

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'bootstrap';

const serverBaseUrl = import.meta.env.VITE_API_DOMAIN;
const socketUrl = import.meta.env.VITE_WS_CONNECTION;

const app = createApp(App);
const pinia = createPinia();


app.provide('serverBaseUrl', serverBaseUrl);
app.provide('axios', axios.create({
	baseURL: serverBaseUrl + '/api',
	headers: {
		'Access-Control-Allow-Origin': '*',
		'Content-type': 'application/json',
	},
}));

app.provide('socket', io(socketUrl));


app.use(Toaster, {
	// Global/Default options
	position: 'top',
	timeout: 3000,
	pauseOnHover: true
}).provide('toast', app.config.globalProperties.$toast);

app.use(router);
app.use(pinia);

app.component('FieldErrorMessage', FieldErrorMessage);

app.mount('#app');
