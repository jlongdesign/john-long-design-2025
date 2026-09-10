<?php
/**
 * General theme helper functions
 */

/**
 * WordPress compresses JPEGs to quality 82 and auto-downscales any upload
 * wider/taller than 2560px ("big image" scaling), which softens crisp
 * retina UI screenshots. Raise both for sharper portfolio images.
 * Only affects images uploaded after this is active — re-upload existing
 * screenshots to get the higher-quality versions.
 */
add_filter( 'wp_editor_set_quality', function() {
    return 92;
});

add_filter( 'jpeg_quality', function() {
    return 92;
});

add_filter( 'big_image_size_threshold', function( $threshold, $imagesize, $file ) {
    // PNG screenshots are lossless already — don't let WP downscale tall full-page captures.
    if ( $file && 'png' === strtolower( pathinfo( $file, PATHINFO_EXTENSION ) ) ) {
        return false;
    }
    return 4096;
}, 10, 3 );
