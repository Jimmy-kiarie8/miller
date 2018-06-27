

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vuetify from 'vuetify'
import VueRouter from 'vue-router'

Vue.use(VueRouter) 
Vue.use(Vuetify)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

let myHeader = require('./components/include/Header.vue')
let myUser = require('./components/users/User.vue')
let mySociety = require('./components/society/Society.vue')
let myBuyers = require('./components/buyers/Buyers.vue')
let myCoffee = require('./components/coffeeType/CoffeeType.vue')
let myUnits = require('./components/units/Units.vue')
let myDerivery = require('./components/derivery/Derivery.vue')
let mySupply = require('./components/supply/Supply.vue')
let myMiller = require('./components/miller/Miller.vue')
let myInvoice = require('./components/invoices/Invoice.vue')
let myReceipt = require('./components/receipt/Receipt.vue')
let myTest = require('./components/test/Invoice.vue')

const routes = [
	// {path: '/', component: myView},
	{path: '/users', component: myUser},
	{path: '/society', component: mySociety},
	{path: '/buyers', component: myBuyers},
	{path: '/coffee', component: myCoffee},
	{path: '/units', component: myUnits},
	{path: '/derivery', component: myDerivery},
	{path: '/supply', component: mySupply},
	{path: '/millers', component: myMiller},
	{path: '/invoices', component: myInvoice},
	{path: '/receipts', component: myReceipt},
	{path: '/test', component: myTest},
]
const router = new VueRouter({
// mode: 'history',
	routes // short for `routes: routes`
})
const app = new Vue({
    el: '#app',
    router,
    components: {
    	myHeader, myUser, mySociety, myBuyers, myCoffee, myUnits, myDerivery, myMiller,
    	myInvoice, myReceipt, myTest
    }
});
