<?php

/**
 * Plugin Name: Bacola Product Location Filter
 * Plugin URI:  https://github.com/kahnu044
 * Description: Enforces location-based product availability across shop, cart, and checkout for Bacola theme.
 * Version:     1.0.0
 * Author:      kahnu044
 * Author URI:  https://github.com/kahnu044
 * Text Domain: bplf
 */

defined('ABSPATH') || exit;

/**
 * Plugin constants
 */
define('BPLF_VERSION', '1.0.0');
define('BPLF_PATH', plugin_dir_path(__FILE__));
define('BPLF_URL', plugin_dir_url(__FILE__));

/**
 * Load dependencies
 */
require_once BPLF_PATH . 'includes/class-bplf-dependencies.php';

if ( ! BPLF_Dependencies::check() ) {
    return;
}

require_once BPLF_PATH . 'includes/class-bplf-messages.php';
require_once BPLF_PATH . 'includes/class-bplf-helpers.php';
require_once BPLF_PATH . 'includes/class-bplf-product-filter.php';
require_once BPLF_PATH . 'includes/class-bplf-cart-validation.php';