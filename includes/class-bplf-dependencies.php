<?php
defined('ABSPATH') || exit;

/**
 * Handles dependency checks
 */
class BPLF_Dependencies
{

    /**
     * Check required theme & plugins
     */
    public static function check()
    {

        if (! class_exists('WooCommerce')) {
            add_action('admin_notices', [__CLASS__, 'woocommerce_missing']);
            return false;
        }

        $theme = wp_get_theme();
        if (stripos($theme->get('Name'), 'Bacola') === false) {
            add_action('admin_notices', [__CLASS__, 'theme_missing']);
            return false;
        }

        return true;
    }

    public static function woocommerce_missing()
    {
        echo '<div class="notice notice-error"><p>';
        echo esc_html__('Bacola Location Product Control requires WooCommerce to be installed and active.', 'bplf');
        echo '</p></div>';
    }

    public static function theme_missing()
    {
        echo '<div class="notice notice-warning"><p>';
        echo esc_html__('This plugin is designed for the Bacola theme. Some features may not work properly.', 'bplf');
        echo '</p></div>';
    }
}
