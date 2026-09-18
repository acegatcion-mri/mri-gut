/** Made to make the carousel appear on backend - not yet working - Ace */

(function () {
    'use strict';

    function initializeProductCarousel(carousel) {
        if (!carousel || carousel.dataset.carouselInitialized === 'true') {
            return;
        }

        const cards = Array.from(
            carousel.querySelectorAll('.product-card-slide')
        );

        const dots = Array.from(
            carousel.querySelectorAll('.carousel-dots button')
        );

        if (!cards.length) {
            return;
        }

        carousel.dataset.carouselInitialized = 'true';

        const positionClasses = [
            'product-card-slide---1',
            'product-card-slide--0',
            'product-card-slide--1'
        ];

        function updateCarousel(startIndex) {
            cards.forEach(function (card) {
                card.classList.remove(...positionClasses);
                card.setAttribute('aria-hidden', 'true');
            });

            positionClasses.forEach(function (positionClass, offset) {
                const card = cards[startIndex + offset];

                if (card) {
                    card.classList.add(positionClass);
                    card.setAttribute('aria-hidden', 'false');
                }
            });

            dots.forEach(function (dot, index) {
                const isActive = index === startIndex;

                dot.classList.toggle('active', isActive);
                dot.setAttribute(
                    'aria-selected',
                    isActive ? 'true' : 'false'
                );
            });
        }

        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                const startIndex = Number.parseInt(
                    dot.dataset.slideIndex,
                    10
                );

                if (!Number.isNaN(startIndex)) {
                    updateCarousel(startIndex);
                }
            });
        });

        updateCarousel(0);
    }

    function initializeAllProductCarousels(context) {
        const root = context || document;

        if (
            root.nodeType === 1 &&
            root.matches('.product-card-carousel')
        ) {
            initializeProductCarousel(root);
        }

        root.querySelectorAll('.product-card-carousel').forEach(
            initializeProductCarousel
        );
    }

    /*
     * Frontend initialization.
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            initializeAllProductCarousels(document);
        });
    } else {
        initializeAllProductCarousels(document);
    }

    /*
     * ACF Gutenberg preview initialization.
     */
    if (window.acf) {
        window.acf.addAction(
            'render_block_preview/type=mri-product-cards-section',
            function (block) {
                const element = block && block[0] ? block[0] : block;
                initializeAllProductCarousels(element);
            }
        );
    }
})();