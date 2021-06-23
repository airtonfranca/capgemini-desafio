require('./bootstrap');

window.Vue = require('vue');

require('./filter');
require('./progressbar');
require('./customEvents');


import VueCurrencyInput from 'vue-currency-input'
Vue.use(VueCurrencyInput, {
    globalOptions: {
        currency: "BRL",
        locale: "pt",
        distractionFree: false,
        valueRange: {min: 0.01, max: 99999999},
        allowNegative: false
    }, componentName: 'CurrencyInput'
});


import { Form, HasError, AlertError } from 'vform'
window.Form = Form;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('user-component', require('./components/UserComponent.vue').default);

//Import Sweetalert2
import Swal from 'sweetalert2'
window.Swal = Swal

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
window.Toast = Toast


const app = new Vue({
    el: '#app',
    // router
});
