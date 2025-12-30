<?php
defined( 'ABSPATH' ) || exit;

/**
 * Centralized plugin messages
 */
class BPLF_Messages {

    public static function product_not_available() {
        return apply_filters(
            'bplf_product_not_available_message',
            __( 'This product is not available in your location.', 'bplf' )
        );
    }

    public static function cart_not_deliverable() {
        return apply_filters(
            'bplf_cart_not_deliverable_message',
            __( 'Some items are not deliverable to your location.', 'bplf' )
        );
    }

    public static function product_not_available_in_state() {
        return apply_filters(
            'bplf_product_not_available_in_state_message',
            __( '%s is not available in the selected state (%s).', 'bplf' )
        );
    }
}
