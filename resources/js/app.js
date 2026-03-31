import './bootstrap';

import { createApp } from 'vue'
import App from './components/App.vue'
import Login from './components/Login.vue'
import Register from './components/Register.vue'
import Products from './components/Products.vue'

const Appin = document.getElementById('app')
if(Appin){
createApp(App).mount('#app')
}

const Logindiv = document.getElementById('Login')
if(Logindiv){
createApp(Login).mount('#Login')
}

const Registerin = document.getElementById('Register')
if(Registerin){
createApp(Register).mount('#Register')
}

const Productsin = document.getElementById('Products')
if(Productsin){
createApp(Products).mount('#Products')
}