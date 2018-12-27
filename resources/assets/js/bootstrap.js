window.moment = require('moment');
window._ = require('lodash');
window.Popper = require('popper.js').default;

 try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
    require('./common');
} catch (e) {
    console.log(e)
}

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.axios.defaults.headers.common['Access-Control-Allow-Credentials'] = true

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    // console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
