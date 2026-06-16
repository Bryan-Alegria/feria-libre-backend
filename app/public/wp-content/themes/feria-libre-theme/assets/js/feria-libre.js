/**
 * Feria Libre - Interacciones del tema
 *
 * @package FeriaLibre
 */

(function() {
    'use strict';

    function initChips() {
        document.addEventListener('click', function(e) {
            if (!e.target.classList.contains('fl-chip')) return;
            var chips = e.target.parentElement.querySelectorAll('.fl-chip');
            chips.forEach(function(c) { c.classList.remove('fl-chip-active'); });
            e.target.classList.add('fl-chip-active');
        });
    }

    function initNav() {
        document.addEventListener('click', function(e) {
            var item = e.target.closest('.fl-nav-item');
            if (!item) return;
            var nav = item.parentElement;
            nav.querySelectorAll('.fl-nav-item').forEach(function(n) {
                n.classList.remove('fl-nav-active');
            });
            item.classList.add('fl-nav-active');
        });
    }

    function ready(fn) {
        if (document.readyState !== 'loading') { fn(); return; }
        document.addEventListener('DOMContentLoaded', fn);
    }

    ready(function() {
        initChips();
        initNav();
    });

})();
