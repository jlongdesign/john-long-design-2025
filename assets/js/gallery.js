document.addEventListener( 'DOMContentLoaded', () => {
    if ( typeof GLightbox === 'undefined' ) return;

    GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
        autoplayVideos: false,
        keyboardNavigation: true,
    });
} );