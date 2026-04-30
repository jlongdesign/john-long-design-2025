<?php
/**
 * John Long Design Theme Functions
 */

if (!defined('ABSPATH')) {
    exit;
}

// Theme constants
define('JLD_VERSION', '1.0');
define('JLD_THEME_DIR', get_template_directory());
define('JLD_THEME_URL', get_template_directory_uri());

// Include theme files in order
require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/enqueue-assets.php';
require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/meta-boxes.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/ajax-handlers.php';
require_once get_template_directory() . '/inc/helper-functions.php';
require_once get_template_directory() . '/inc/gallery-functions.php';
require_once get_template_directory() . '/inc/glightbox.php';