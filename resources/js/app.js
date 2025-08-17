import './bootstrap';
import './chatbot.js';
import 'bootstrap/dist/js/bootstrap.bundle.js';

import jQuery from 'jquery';
window.$ = jQuery;

$(document).ready(function() {
    var triggerTabList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tab"]'));
    triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl);
        triggerEl.addEventListener('click', function (event) {
            event.preventDefault();
            tabTrigger.show();
        });
    });
});
