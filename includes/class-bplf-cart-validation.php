<?php
defined('ABSPATH') || exit;

class BPLF_Cart_Validation
{

    public function __construct()
    {
        add_filter('woocommerce_add_to_cart_validation', [$this, 'validate_add_to_cart'], 10, 2);
        add_action('woocommerce_check_cart_items', [$this, 'validate_cart']);
        add_action('woocommerce_checkout_process', [$this, 'validate_checkout']);
        add_action('woocommerce_after_checkout_validation', [$this, 'validate_checkout_shipping_state'], 10, 2);
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

    /**
     * Validate cart products against selected shipping state during checkout
     */
    public function validate_checkout_shipping_state($data, $errors)
    {
        // Get the selected shipping state
        $shipping_state = isset($data['shipping_state']) ? sanitize_text_field($data['shipping_state']) : '';
        
        // If no shipping state, try billing state
        if (empty($shipping_state)) {
            $shipping_state = isset($data['billing_state']) ? sanitize_text_field($data['billing_state']) : '';
        }

        // If still no state selected, return
        if (empty($shipping_state)) {
            return;
        }

        // Check each cart item
        foreach (WC()->cart->get_cart() as $item) {
            $product_id = $item['product_id'];
            $product_name = get_the_title($product_id);
            
            // Check if product is available in the selected state
            if (! BPLF_Helpers::product_has_location($product_id, $shipping_state)) {
                $errors->add(
                    'shipping_state_validation',
                    sprintf(
                        BPLF_Messages::product_not_available_in_state(),
                        '<strong>' . $product_name . '</strong>',
                        $shipping_state
                    )
                );
            }
        }
    }
}

new BPLF_Cart_Validation();
