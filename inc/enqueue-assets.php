<?php
/**
 * Enqueue Scripts and Styles
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue theme assets
 */
function jld_enqueue_assets() {
    // Bootstrap CSS (CDN)
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', array(), '5.3.0');
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');
    
    // Main theme stylesheet
    $css_file = file_exists(JLD_THEME_DIR . '/assets/css/main.min.css') ? 'main.min.css' : 'main.css';
    wp_enqueue_style('jld-main-style', JLD_THEME_URL . '/assets/css/' . $css_file, array('bootstrap'), JLD_VERSION);
    
    // Bootstrap JS
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array(), '5.3.0', true);
    
    // Main theme JavaScript
    if (file_exists(JLD_THEME_DIR . '/assets/js/main.min.js')) {
        wp_enqueue_script('jld-main-js', JLD_THEME_URL . '/assets/js/main.min.js', array('jquery'), JLD_VERSION, true);
        
        // Localize script
        wp_localize_script('jld-main-js', 'jld_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('jld_nonce')
        ));
    }
    
    // Lightbox (if needed)
    if (is_singular('project')) {
        wp_enqueue_style(
            'glightbox',
            'https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css',
            [],
            '3.3.0'
        );
        wp_enqueue_script(
            'glightbox',
            'https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js',
            [],
            '3.3.0',
            true
        );
        wp_enqueue_script(
            'jld-gallery',
            JLD_THEME_URL . '/assets/js/gallery.js',
            [ 'glightbox' ],
            JLD_VERSION,
            true
        );
    }
}
/**
 * Enqueue admin assets
 */
function jld_enqueue_admin_assets($hook) {
    // Only load on post edit pages
    if ('post.php' !== $hook && 'post-new.php' !== $hook) {
        return;
    }
    
    // Enqueue WordPress media uploader
    wp_enqueue_media();
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'jld_enqueue_assets');
add_action('admin_enqueue_scripts', 'jld_enqueue_admin_assets');