/**
 * Simple Lightbox functionality
 */

(function() {
    'use strict';

    const lightbox = {
        init: function() {
            this.bindEvents();
            this.createModal();
        },

        bindEvents: function() {
            document.addEventListener('click', function(e) {
                if (e.target.closest('[data-lightbox]')) {
                    e.preventDefault();
                    const link = e.target.closest('[data-lightbox]');
                    const imageSrc = link.href || link.querySelector('img').src;
                    lightbox.open(imageSrc);
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    lightbox.close();
                }
            });
        },

        createModal: function() {
            const modal = document.createElement('div');
            modal.id = 'lightbox-modal';
            modal.className = 'lightbox-modal';
            modal.innerHTML = `
                <div class="lightbox-backdrop"></div>
                <div class="lightbox-content">
                    <button class="lightbox-close">&times;</button>
                    <img class="lightbox-image" src="" alt="">
                    <div class="lightbox-loading">
                        <div class="spinner"></div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);

            // Close events
            modal.querySelector('.lightbox-close').addEventListener('click', this.close);
            modal.querySelector('.lightbox-backdrop').addEventListener('click', this.close);
        },

        open: function(imageSrc) {
            const modal = document.getElementById('lightbox-modal');
            const image = modal.querySelector('.lightbox-image');
            const loading = modal.querySelector('.lightbox-loading');
            
            modal.classList.add('active');
            loading.style.display = 'block';
            image.style.display = 'none';
            
            // Prevent body scroll
            document.body.style.overflow = 'hidden';
            
            // Load image
            const img = new Image();
            img.onload = function() {
                image.src = imageSrc;
                loading.style.display = 'none';
                image.style.display = 'block';
                image.classList.add('loaded');
            };
            img.src = imageSrc;
        },

        close: function() {
            const modal = document.getElementById('lightbox-modal');
            const image = modal.querySelector('.lightbox-image');
            
            modal.classList.remove('active');
            image.classList.remove('loaded');
            
            // Restore body scroll
            document.body.style.overflow = '';
            
            // Clear image src after animation
            setTimeout(function() {
                image.src = '';
            }, 300);
        }
    };

    // Initialize when DOM is loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', lightbox.init.bind(lightbox));
    } else {
        lightbox.init();
    }

})();

document.addEventListener( 'DOMContentLoaded', () => {
    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,   // swipe on mobile
        loop: true,              // loop back to first image
        autoplayVideos: false,
        keyboardNavigation: true // arrow keys
    });
} );