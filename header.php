<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <!-- Google reCAPTCHA v3 -->
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LcG4vIrAAAAANkNv_8l1_Vp3-KlUDHLW-qwgb0r"></script>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <div class="row align-items-center w-100">
                <div class="col-11 col-md-4 mb-3 mb-md-0">
                    <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
                        <?php if (has_custom_logo()) : ?>
                            <?php the_custom_logo(); ?>
                        <?php else : ?>
                            <strong><?php bloginfo('name'); ?></strong>
                        <?php endif; ?>
                    </a>
                </div><!-- end col -->
                <div class="col-12 col-md-8">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_class' => 'navbar-nav ms-auto',
                            'container' => false,
                            'depth' => 2,
                            'walker' => new class extends Walker_Nav_Menu {
                                function start_lvl(&$output, $depth = 0, $args = null) {
                                    $output .= '<ul class="dropdown-menu">';
                                }
                                function end_lvl(&$output, $depth = 0, $args = null) {
                                    $output .= '</ul>';
                                }
                                function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
                                    $classes = empty($item->classes) ? array() : (array) $item->classes;
                                    $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
                                    $class_names = $class_names ? ' class="nav-item ' . esc_attr($class_names) . '"' : ' class="nav-item"';
                                    
                                    $output .= '<li' . $class_names . '>';
                                    
                                    $link_class = 'nav-link';
                                    if (in_array('current-menu-item', $classes)) {
                                        $link_class .= ' active';
                                    }
                                    
                                    $output .= '<a class="' . $link_class . '" href="' . esc_attr($item->url) . '">';
                                    $output .= apply_filters('the_title', $item->title, $item->ID);
                                    $output .= '</a>';
                                }
                                function end_el(&$output, $item, $depth = 0, $args = null) {
                                    $output .= '</li>';
                                }
                            }
                        ));
                        ?>
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </nav>
</header>

<main class="site-main"><?php /** Main content starts here **/ ?>
