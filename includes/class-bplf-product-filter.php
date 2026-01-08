<?php
defined('ABSPATH') || exit;

class BPLF_Product_Filter
{

    public function __construct()
    {
        add_action('pre_get_posts', [$this, 'filter_products']);
        add_action('template_redirect', [$this, 'block_single_product']);
        add_filter('woocommerce_related_products', [$this, 'filter_related_products'], 10, 3);
    }

    public function filter_products($query)
    {

        if (is_admin() || ! $query->is_main_query()) return;
        if (! (is_shop() || is_product_category() || is_product_tag())) return;

        $location = BPLF_Helpers::get_user_location();
        if ($location === 'all') return;

        $query->set('tax_query', [
            [
                'taxonomy' => 'location',
                'field'    => 'slug',
                'terms'    => [$location],
            ]
        ]);
    }

    public function block_single_product()
    {

        if (! is_product()) return;

        global $post;
        $location = BPLF_Helpers::get_user_location();

        if (! BPLF_Helpers::product_has_location($post->ID, $location)) {
            wc_add_notice(BPLF_Messages::product_not_available(), 'error');
            wp_redirect(wc_get_page_permalink('shop'));
            exit;
        }
    }

    public function filter_related_products($related_posts, $product_id, $args)
    {

        // Get location from cookie
        $location = BPLF_Helpers::get_user_location();

        // If location is NOT set → return blank
        if (empty($location)) {
            return $related_posts;
        }

        $filtered_products = [];

        foreach ($related_posts as $related_post_id) {

            // Get location terms of related product
            $terms = get_the_terms($related_post_id, 'location');

            if (is_wp_error($terms) || empty($terms)) {
                continue;
            }

            // Extract slugs
            $slugs = wp_list_pluck($terms, 'slug');

            // Match cookie location with product location
            if (in_array($location, $slugs, true)) {
                $filtered_products[] = $related_post_id;
            }
        }

        // Return ONLY matched products (blank if none found)
        return $filtered_products;
    }
}

new BPLF_Product_Filter();
