/**
 * Feria Libre - Interacciones del prototipo
 *
 * @package FeriaLibre
 */

(function() {
    'use strict';

    /**
     * Navegar entre paginas de la app
     * @param {string} pageId - Identificador de la pagina
     */
    function navTo(pageId) {
        var pages = document.querySelectorAll('.app-page');
        pages.forEach(function(page) {
            page.classList.remove('active');
        });

        var activePage = document.getElementById('page-' + pageId);
        if (activePage) {
            activePage.classList.add('active');
        }
    }

    /**
     * Inicializar eventos de navegacion
     */
    function initNavigation() {
        document.addEventListener('click', function(e) {
            var target = e.target.closest('[data-nav]');
            if (target) {
                e.preventDefault();
                var pageId = target.getAttribute('data-nav');
                navTo(pageId);
            }
        });
    }

    /**
     * Inicializar chips de categorias
     */
    function initChips() {
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('chip')) {
                var chips = e.target.parentElement.querySelectorAll('.chip');
                chips.forEach(function(chip) {
                    chip.classList.remove('active');
                });
                e.target.classList.add('active');
            }
        });
    }

    /**
     * Inicializar estrellas de calificacion
     */
    function initStars() {
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('star-btn')) {
                var stars = e.target.parentElement.querySelectorAll('.star-btn');
                var clickedIndex = Array.from(stars).indexOf(e.target);

                stars.forEach(function(star, index) {
                    if (index <= clickedIndex) {
                        star.classList.add('lit');
                    } else {
                        star.classList.remove('lit');
                    }
                });
            }
        });
    }

    /**
     * Exponer funcion navTo globalmente para onclick inline
     */
    window.navTo = navTo;

    /**
     * Inicializar cuando el DOM este listo
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initNavigation();
            initChips();
            initStars();
        });
    } else {
        initNavigation();
        initChips();
        initStars();
    }

})();
