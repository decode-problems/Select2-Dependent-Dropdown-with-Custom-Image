import './bootstrap';

// import Vue from 'vue/dist/vue.js';
// import Vue from 'vue/dist/vue.esm.js';
import Vue from 'vue'
window.Vue = Vue;

import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

import Popper from 'popper.js';
window.Popper = Popper;

import 'bootstrap';
import 'select2';

$('[data-toggle="tooltip"]').tooltip();

Vue.directive('select2', {
    inserted(el) {
        $(el).on('select2:select', () => {
            const event = new Event('change', {bubbles: true, cancelable: true});
            el.dispatchEvent(event);
        });
        $(el).on('select2:unselect', () => {
            const event = new Event('change', {bubbles: true, cancelable: true})
            el.dispatchEvent(event)
        })
    },
});
