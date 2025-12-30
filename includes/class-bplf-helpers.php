<?php
defined('ABSPATH') || exit;

/**
 * Helper utilities
 */
class BPLF_Helpers
{

    /**
     * Get selected location from Bacola cookie
     */
    public static function get_user_location()
    {
        return isset($_COOKIE['location']) ? sanitize_text_field($_COOKIE['location']) : 'all';
    }

    /**
     * Check if product is available for location
     */
    public static function product_has_location($product_id, $location)
    {

        if ($location === 'all') {
            return true;
        }

        $terms = get_the_terms($product_id, 'location');

        if (empty($terms) || is_wp_error($terms)) {
            return false;
        }

        $slugs = wp_list_pluck($terms, 'slug');
        return in_array($location, $slugs, true);
    }
}
