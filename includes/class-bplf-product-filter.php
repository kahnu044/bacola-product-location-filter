<?php
defined('ABSPATH') || exit;

class BPLF_Product_Filter
{

    public function __construct()
    {
        add_action('pre_get_posts', [$this, 'filter_products']);
        add_action('template_redirect', [$this, 'block_single_product']);
    }

    public function filter_products($query)
    {

        if (is_admin() || ! $query->is_main_query()) return;
        if (! (is_shop() || is_product_category() || is_product_tag())) return;

        $location = BLPC_Helpers::get_user_location();
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
}
