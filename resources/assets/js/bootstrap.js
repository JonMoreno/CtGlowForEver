
/**
* We'll load jQuery, Popper and the Bootstrap jQuery plugin which provides support
* for JavaScript based Bootstrap features such as modals and tabs. This
* code may be modified to fit the specific needs of your application.
*/  
//JQuery_________________________________________
    window.$ = window.jQuery = require('jquery');
//Popper.js______________________________________
    import Popper from 'popper.js/dist/umd/popper.js';
    window.Popper = Popper;
//Bootstrap______________________________________
    try{ require('bootstrap'); } catch(e){ alert(e); } 
//_______________________________________________



/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
//Axios__________________________________________
    window.axios = require('axios');
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
//_______________________________________________



/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */
//CSRF-TOKEN____________________________________
    let token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) { window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content; } 
    else { console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token'); }
//_______________________________________________




/** 
* We'll load all of this project's JavaScript dependencies at this point.
* Any other required dependencies should be initialized in this file.
*/

//Vue____________________________________________
    window.Vue = require('vue');
    require('./helpers/vue-event-dispatcher');
    require('./helpers/vue-v-scroll');

//Vue Debug Mode_________________________________
    Vue.config.devtools = true
//_______________________________________________






















/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
