require('./bootstrap');

require('alpinejs');

import Vue from 'vue'
import 'livewire-vue'
 
window.Vue = Vue

const CryptoJS = require("crypto-js");

window.decrypt = (encrypted) => {
    let key = process.env.MIX_APP_KEY.substr(7);
    var encrypted_json = JSON.parse(atob(encrypted));
    return CryptoJS.AES.decrypt(encrypted_json.value, CryptoJS.enc.Base64.parse(key), {
        iv : CryptoJS.enc.Base64.parse(encrypted_json.iv)
    }).toString(CryptoJS.enc.Utf8);
};