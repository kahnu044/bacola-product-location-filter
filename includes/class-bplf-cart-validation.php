<?php
defined('ABSPATH') || exit;

class BPLF_Cart_Validation
{

    public function __construct()
    {
        add_filter('woocommerce_add_to_cart_validation', [$this, 'validate_add_to_cart'], 10, 2);
        add_action('woocommerce_check_cart_items', [$this, 'validate_cart']);
        add_action('woocommerce_checkout_process', [$this, 'validate_checkout']);
    }

    public function validate_add_to_cart($passed, $product_id)
    {

        $location = BPLF_Helpers::get_user_location();

        if (! BPLF_Helpers::product_has_location($product_id, $location)) {
            wc_add_notice(BPLF_Messages::product_not_available(), 'error');
            return false;
        }

        return $passed;
    }

    public function validate_cart()
    {

        $location = BPLF_Helpers::get_user_location();

        foreach (WC()->cart->get_cart() as $item) {
            if (! BPLF_Helpers::product_has_location($item['product_id'], $location)) {
                wc_add_notice(
                    get_the_title($item['product_id']) . ' — ' . BPLF_Messages::product_not_available(),
                    'error'
                );
            }
        }
    }

    public function validate_checkout()
    {

        $location = BPLF_Helpers::get_user_location();

        foreach (WC()->cart->get_cart() as $item) {
            if (! BPLF_Helpers::product_has_location($item['product_id'], $location)) {
                wc_add_notice(BPLF_Messages::cart_not_deliverable(), 'error');
                return;
            }
        }
    }
}

new BPLF_Cart_Validation();
