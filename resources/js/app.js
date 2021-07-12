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

Vue.component('chat', require('./components/ChatComponent.vue').default);
Vue.component('chats', require('./components/ChatsComponent.vue').default);
Vue.component('chatuser', require('./components/ChatUserComponent.vue').default);
Vue.component('chatgroup', require('./components/ChatGroupComponent.vue').default);
Vue.component('groupmessage', require('./components/GroupMessageComponent.vue').default);
Vue.component("video-chat", require("./components/VideoChat.vue").default);
Vue.component("agora-chat", require("./components/AgoraChat.vue").default);

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