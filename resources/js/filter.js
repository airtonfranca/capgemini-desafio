//filtro para deixar as letras maiusculas
Vue.filter("strToUpper", function(text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
});

//Vue moment para mostrar a data
import moment from "moment"; //Import Moment

Vue.filter("formatDate", function(date, format = 'DD/MM/YY - HH:mm:ss') {
    return moment(date).format(format);
});


Vue.filter("formatPrice", function(value) {
    let val = (value/1).toFixed(2).replace('.', ',')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
})
