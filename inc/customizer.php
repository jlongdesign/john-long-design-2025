<?php
/**
 * Theme Customizer
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customizer settings
 */
function jld_customize_register($wp_customize) {
        // Hero Section
    $wp_customize->add_section('jld_hero', array(
        'title' => 'Hero Section',
        'priority' => 30,
        'description' => 'Customize your homepage hero section'
    ));
    
    // Hero Image
    $wp_customize->add_setting('hero_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hero_image', array(
        'label' => 'Hero Image',
        'section' => 'jld_hero',
        'mime_type' => 'image',
        'description' => 'Upload an image for the hero section (recommended: 800x600px or larger).'
    )));
    
    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default' => 'Creating Digital Experiences That Matter',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_title', array(
        'label' => 'Hero Title',
        'section' => 'jld_hero',
        'type' => 'text',
        'description' => 'Main headline for your hero section'
    ));
    
    // Hero Subtitle - ADD THIS
    $wp_customize->add_setting('hero_subtitle', array(
        'default' => 'UX Designer & Digital Strategist',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_subtitle', array(
        'label' => 'Hero Subtitle',
        'section' => 'jld_hero',
        'type' => 'text',
        'description' => 'Your professional title or tagline'
    ));
    
    // Hero Description - ADD THIS
    $wp_customize->add_setting('hero_description', array(
        'default' => 'I help businesses create meaningful digital experiences through user-centered design and strategic thinking.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('hero_description', array(
        'label' => 'Hero Description',
        'section' => 'jld_hero',
        'type' => 'textarea',
        'description' => 'Brief description of what you do'
    ));

    // Contact Section
    $wp_customize->add_section('jld_contact', array(
        'title' => 'Contact Settings',
        'priority' => 40,
    ));

    // Contact Email
    $wp_customize->add_setting('contact_email', array(
        'default' => get_option('admin_email'),
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('contact_email', array(
        'label' => 'Contact Form Email',
        'section' => 'jld_contact',
        'type' => 'email',
        'description' => 'Email address where contact form messages will be sent.'
    ));
    // Add other customizer settings...
}
add_action('customize_register', 'jld_customize_register');