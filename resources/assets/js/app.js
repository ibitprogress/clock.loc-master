
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('@fortawesome/fontawesome-free/js/all.js');


window.Vue = require('vue');
window.Vuex = require('vuex');
import {StfSelect, StfSelectOption} from "stf-vue-select";


require('./vendor/toastmessage');


//Localization in Vue
const _ = require('lodash');
window.trans = (string) => _.get(window.i18n, string);
Vue.prototype.trans = string => _.get(window.i18n, string);



window.store = new Vuex.Store({
    state: {
        items: [],
        totalPrice: 0,
        totalQty: 0,
        clientInfo: {},

    },
    getters: {
        getTotalPrice: (state) => {return state.totalPrice},
        getTotalQty: (state) => {return state.totalQty},
        getItems: (state) => {return state.items},
    },
    mutations: {

        updateData(state, payload){
            state.items = payload.items;
            state.totalPrice = payload.totalPrice;
            state.totalQty = payload.totalQty;
        },
        updateState(state, payload){
            state.items = payload.items;
            state.totalPrice = payload.totalPrice;
            state.totalQty = payload.totalQty;
        },
        updateClientInfo (state, clientInfo){
            state.clientInfo = clientInfo;
        }
    },
    actions:{
        async addToCart (context, clockId) {
            axios.post('/cart/add', {
                clockId: clockId,
            })
                .then((response) => {
                    context.commit('updateData', response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        async updateQty (context, clock){
            axios.post('/cart/update', {
                clockId: clock.clockId,
                qty: clock.qty

            })
                .then((response) => {
                    context.commit('updateData', response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        async removeFromCart (context, clock){
            axios.post('/cart/remove', {
                clockId: clock.clockId,

            })
                .then((response) => {
                    context.commit('updateData', response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        async getCart (context){
            axios.post('/cart/get')
                .then((response) => {
                    context.commit('updateData', response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
    }
})



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('clock-form', require('./components/ClockForm.vue').default);
Vue.component('descriptions-form', require('./components/DescriptionsForm.vue').default);
Vue.component('descriptions', require('./components/Descriptions.vue').default);
Vue.component('characteristics-form', require('./components/CharacteristicsForm.vue').default);
Vue.component('characteristics', require('./components/Characteristics.vue').default);
Vue.component('images-form', require('./components/ImagesForm.vue').default);
Vue.component('clocks-table', require('./components/ClocksTable.vue').default); //Адмін таблиця годинників
Vue.component('clocks-list', require('./components/ClocksList.vue').default); //Прайслист
Vue.component('orders-table', require('./components/OrdersTable.vue').default); //Адмін таблиця замовлень
Vue.component('filters', require('./components/Filters.vue').default); //Фільтри
Vue.component('clock-page', require('./components/ClockPage.vue').default); //Сторінка конкретного товару
Vue.component('cart-button', require('./components/CartButton.vue').default); //Кнопка корзини
Vue.component('cart-button-min', require('./components/CartButtonMin.vue').default); //Кнопка (зменшена) корзини
Vue.component('cart', require('./components/Cart.vue').default); //Корзина
Vue.component('checkout', require('./components/Checkout').default); //Оформлення заказів
Vue.component('feedback-modal', require('./components/FeedbackModal').default); //Зворотній звязок (модальне вікно)
Vue.component('feedbacks-table', require('./components/FeedbacksTable').default); //Адмін таблиця зворотнього звязку
Vue.component('article-form', require('./components/ArticleForm').default); //Форма створення та редагування статей
Vue.component('article-image', require('./components/ArticleImage').default); //Форма створення та редагування статей
Vue.component('stf-select-option', StfSelectOption);
Vue.component('stf-select', StfSelect);





const app = new Vue({
    el: '#app',
    store,
});

require('./admin');
require('./site');



