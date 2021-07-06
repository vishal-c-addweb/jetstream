require('./bootstrap');

require('alpinejs');

import Vue from 'vue'
import 'livewire-vue'
import moment from 'moment'
import VueChatScroll from 'vue-chat-scroll'

Vue.use(VueChatScroll)


Vue.filter('formatDate', function(value) {
    if (value) {
      return moment(String(value)).format('hh:mm a')
    }
  });

Vue.component('chatuser', require('./components/ChatUserComponent.vue').default);
Vue.component('chat', require('./components/ChatComponent.vue').default);
Vue.component('chats', require('./components/ChatsComponent.vue').default);

const app = new Vue({
    el: '#app'
});

const CryptoJS = require("crypto-js");

window.decrypt = (encrypted) => {
    let key = process.env.MIX_APP_KEY.substr(7);
    var encrypted_json = JSON.parse(atob(encrypted));
    return CryptoJS.AES.decrypt(encrypted_json.value, CryptoJS.enc.Base64.parse(key), {
        iv : CryptoJS.enc.Base64.parse(encrypted_json.iv)
    }).toString(CryptoJS.enc.Utf8);
};