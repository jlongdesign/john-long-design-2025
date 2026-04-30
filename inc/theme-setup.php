<?php
/**
 * Theme Setup Functions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
 */
function jld_theme_setup() {
    // Add theme support for various features
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));
    
    // Add image sizes
    add_image_size('project-thumbnail', 400, 300, true);
    add_image_size('testimonial-avatar', 80, 80, true);
    add_image_size('hero-image', 800, 600, true);
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'jld-portfolio'),
        'footer' => __('Footer Menu', 'jld-portfolio'),
    ));
}
add_action('after_setup_theme', 'jld_theme_setup');

/**
 * Register sidebars
 */
function jld_register_sidebars() {
    register_sidebar(array(
        'name' => __('Main Sidebar', 'jld-portfolio'),
        'id' => 'main-sidebar',
        'description' => __('Main sidebar for blog posts', 'jld-portfolio'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'jld_register_sidebars');