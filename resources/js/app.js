require('./bootstrap');

require('alpinejs');
require('livewire-vue');

import Vue from 'vue';
import 'livewire-vue';

window.Vue = Vue // 'require('vue');' won't work!

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
});