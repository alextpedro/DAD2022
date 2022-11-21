import { createApp } from 'vue';
import { createPinia } from 'pinia';
import axios from 'axios'

import App from './App.vue';
import router from './router'; //go to this file to define routes

import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"

const app = createApp(App);
const pinia = createPinia();

const serverBaseUrl = 'http://localhost'
app.provide('axios', axios.create({
    baseURL: serverBaseUrl + '/api',
    headers: {
      'Content-type': 'application/json',
    },
  }))
app.provide('serverBaseUrl', serverBaseUrl);  

app.use(router);
app.use(pinia);

app.mount('#app');
