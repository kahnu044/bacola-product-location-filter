# Bacola Product Location Filter

A WordPress plugin that enforces location-based product availability across shop, cart, and checkout pages for the Bacola WooCommerce theme.

## Description

Bacola Product Location Filter seamlessly integrates with WooCommerce and the Bacola theme to provide comprehensive location-based product filtering. The plugin automatically filters products based on user-selected locations (stored in cookies), validates cart items, and ensures checkout compliance with location restrictions.

### Key Features

- **Smart Product Filtering**: Automatically filters shop and category pages based on user location
- **Single Product Protection**: Blocks access to products unavailable in the user's location
- **Cart Validation**: Validates products when added to cart and during cart review
- **Checkout Validation**: Ensures all cart items are deliverable to the selected shipping state
- **Location Taxonomy Integration**: Works with WooCommerce custom taxonomy for product locations
- **Customizable Messages**: Filterable error messages for developer customization
- **Performance Optimized**: Lightweight with minimal database queries

## Requirements

- **WordPress**: 5.0 or higher
- **WooCommerce**: 3.0 or higher
- **Bacola Theme**: Required for full functionality
- **PHP**: 7.4 or higher

## Installation

### Method 1: Manual Installation

1. Download the plugin files
2. Upload the `bacola-product-location-filter` folder to `/wp-content/plugins/`
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Ensure WooCommerce is installed and active
5. Ensure you're using the Bacola theme

### Method 2: Git Clone

```bash
cd wp-content/plugins
git clone https://github.com/kahnu044/bacola-product-location-filter.git
```

Then activate the plugin from the WordPress admin panel.

## Usage

### Setting Up Location Taxonomy

1. Ensure your WooCommerce products have a custom taxonomy called `location`
2. Assign location terms (e.g., state names, city names) to your products
3. The Bacola theme should set a `location` cookie based on user selection

### How It Works

The plugin operates automatically once activated:

1. **Shop Page Filtering**: Products are filtered based on the `location` cookie value
2. **Product Access**: Users are redirected if they try to access unavailable products
3. **Add to Cart**: Validates product availability before adding to cart
4. **Cart Review**: Continuously validates cart items against current location
5. **Checkout**: Final validation against both cookie location and shipping state

### Location Cookie

The plugin reads from `$_COOKIE['location']` which should be set by the Bacola theme. Supported values:

- `all`: Shows all products (no filtering)
- Any valid location slug from your `location` taxonomy

## Developer Documentation

### Available Filters

Customize error messages using these filters:

```php
// Product not available message
add_filter('bplf_product_not_available_message', function($message) {
    return 'Custom message: This product is not available in your area.';
});

// Cart not deliverable message
add_filter('bplf_cart_not_deliverable_message', function($message) {
    return 'Some items cannot be delivered to your location.';
});

// State validation message (uses sprintf with product name and state)
add_filter('bplf_product_not_available_in_state_message', function($message) {
    return '%s is not available for delivery to %s.';
});
```

### Helper Functions

```php
// Get current user location
$location = BPLF_Helpers::get_user_location();

// Check if product is available in location
$is_available = BPLF_Helpers::product_has_location($product_id, $location);
```

### Plugin Constants

```php
BPLF_VERSION  // Plugin version
BPLF_PATH     // Plugin directory path
BPLF_URL      // Plugin directory URL
```

## File Structure

```
bacola-product-location-filter/
├── bacola-product-location-filter.php   # Main plugin file
├── uninstall.php                        # Uninstall cleanup
├── includes/
│   ├── class-bplf-dependencies.php      # Dependency checker
│   ├── class-bplf-helpers.php           # Helper utilities
│   ├── class-bplf-messages.php          # Message templates
│   ├── class-bplf-product-filter.php    # Shop filtering logic
│   └── class-bplf-cart-validation.php   # Cart & checkout validation
├── LICENSE                              # MIT License
└── README.md                            # This file
```

## Troubleshooting

### Products not filtering

- Verify the `location` taxonomy exists in your WooCommerce setup
- Check that products have location terms assigned
- Ensure the `location` cookie is being set by the theme
- Check browser console for cookie values: `document.cookie`

### Error messages not showing

- Verify WooCommerce notices are enabled
- Check your theme supports `wc_print_notices()`
- Try clearing WordPress and browser cache

### Plugin won't activate

- Ensure WooCommerce is installed and active first
- Check PHP version meets minimum requirements (7.4+)
- Review error logs at `wp-content/debug.log` (if debug mode is enabled)

## Changelog

### Version 1.0.0
- Initial release
- Product filtering on shop/category pages
- Single product access control
- Add to cart validation
- Cart and checkout validation
- Shipping state validation at checkout
- Customizable error messages

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Author

**Kahnu Charan Swain**
- GitHub: [@kahnu044](https://github.com/kahnu044)

## Support

For issues, questions, or feature requests, please use the [GitHub Issues](https://github.com/kahnu044/bacola-product-location-filter/issues) page.

---

Made with ❤️ for the Bacola WooCommerce theme