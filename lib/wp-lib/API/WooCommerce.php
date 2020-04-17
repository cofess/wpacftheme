<?php 
/** 
 * Author: Vitali Lupu <vitaliix@gmail.com> 
 */

namespace Lib\API;

use WC_Customer;
use WC_Validation;

final class WooCommerce
{
    protected static $instance = null;

    public static function i()
    {
        if (!self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    protected function __construct()
    {
        $activePlugins = apply_filters('active_plugins', get_option('active_plugins'));
        if (in_array('woocommerce/woocommerce.php', $activePlugins)) {
            /** Add WooComerce Theme Support */
            add_action('after_setup_theme', [$this, 'addSupportOfWooCommerce']);
            add_action('woocommerce_login_redirect', [$this, 'handleWooCommerceLoginRedirect'], 10, 1);
            /** Add: Menu Item Add to cart*/
            add_filter(WPActions::NAV_MENU_ITEM_LINK_ATTRIBUTES, [$this, 'handleNavMenuItemLinkAttributes'], 10, 4);
            add_filter('woocommerce_add_to_cart_fragments', [$this, 'handleNavMenuItemsAddToCart']);
            /** Remove: Product Link open and close tag*/
            remove_action('woocommerce_before_shop_loop_item',
                'woocommerce_template_loop_product_link_open', 10);
            remove_action('woocommerce_after_shop_loop_item',
                'woocommerce_template_loop_product_link_close', 5);

            add_action('woocommerce_before_shop_loop_item', [$this, 'handleBeforeShopLoopItem'], 10);
            add_action('woocommerce_after_shop_loop_item', [$this, 'handleAfterShopLoopItem'], 5);
            /* Remove: Thumbnail */
            remove_action('woocommerce_before_shop_loop_item_title',
                'woocommerce_template_loop_product_thumbnail', 10);
            add_action('woocommerce_before_shop_loop_item_title', [$this, 'handleBeforeShopLoopItemTitleThumb'], 10);
            /* Remove: Product Title*/
            remove_action('woocommerce_shop_loop_item_title',
                'woocommerce_template_loop_product_title', 10);
            add_action('woocommerce_shop_loop_item_title', [$this, 'handleBeforeShopLoopItemTitle']);
            /* Remove: Rating*/
            remove_action('woocommerce_after_shop_loop_item_title',
                'woocommerce_template_loop_rating', 5);
            /* Remove: Price*/
            remove_action('woocommerce_after_shop_loop_item_title',
                'woocommerce_template_loop_price', 10);
            add_action('woocommerce_after_shop_loop_item_title', [$this, 'handleAfterShopLoopItemTitle']);
            /* Remove: Add to Cart*/
            remove_action('woocommerce_after_shop_loop_item',
                'woocommerce_template_loop_add_to_cart', 10);
            /* Remove: Default Handle for Address Editing Page*/
            remove_action('woocommerce_account_edit-address_endpoint',
                'woocommerce_account_edit_address');
            add_action('woocommerce_account_edit-address_endpoint',
                [$this, 'handleEditAddressEndpoint']);
            remove_action('template_redirect', [\WC_Form_Handler::class, 'save_address']);
            add_action('template_redirect', [$this, 'saveAddress']);
            //https://github.com/woocommerce/woocommerce/issues/14618
            //https://docs.woocommerce.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/#
            //add_filter( 'woocommerce_billing_fields' , [$this, 'handleFieldsBilling']);
            //add_filter( 'woocommerce_shipping_fields' , [$this, 'handleFieldsShipping']);
            //add_filter( 'woocommerce_checkout_fields' , [$this, 'handleFieldsCheckout']);
            add_filter('woocommerce_default_address_fields', [$this, 'handleFieldsDefault']);
            $nameSetting = 'woocommerce_enable_guest_checkout';
            add_filter("pre_option_{$nameSetting}", [$this, 'handlePreOptionEnableGuestCheckout']);

            add_action(WPActions::ENQUEUE_SCRIPTS_THEME, [$this, 'enqueueScriptsWooCommerce']);

            /*remove_action('wp_loaded', [\WC_Form_Handler::class, 'update_cart_action'], 20);
            add_action('wp_loaded', [__CLASS__, 'update_cart_action'], 20);*/
            add_filter('woocommerce_gateway_icon', [$this, 'handleGatewayIcon'], 10, 2);
            remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
        }
    }

    public function handleGatewayIcon($iconHtml, $idGateway)
    {
        if ($idGateway === 'paypal') {
            $textWhatIsPayPal = __('What is PayPal?', 'woocommerce');
            $country = strtoupper(WPUtils::getLanguageShortCode());
            if ($country === 'EN'){
                $country = 'US';
            }
            $urlToWhatIsPayPal = 'https://www.paypal.com/' . strtolower($country);
            $home_counties = ['BE', 'CZ', 'DK', 'HU', 'IT', 'JP', 'NL', 'NO', 'ES', 'SE', 'TR', 'IN'];
            $countries = ['DZ', 'AU', 'BH', 'BQ', 'BW', 'CA', 'CN', 'CW', 'FI', 'FR', 'DE', 'GR', 'HK',
                'ID', 'JO', 'KE', 'KW', 'LU', 'MY', 'MA', 'OM', 'PH', 'PL', 'PT', 'QA', 'IE', 'RU', 'BL',
                'SX', 'MF', 'SA', 'SG', 'SK', 'KR', 'SS', 'TW', 'TH', 'AE', 'GB', 'US', 'VN'];

            if (in_array($country, $home_counties, true)) {
                $urlToWhatIsPayPal .= '/webapps/mpp/home';
            } elseif (in_array($country, $countries, true)) {
                $urlToWhatIsPayPal .= '/webapps/mpp/paypal-popup';
            } else {
                $urlToWhatIsPayPal .= '/cgi-bin/webscr?cmd=xpt/Marketing/general/WIPaypal-outside';
            }
            $iconHtml = "<a href='{$urlToWhatIsPayPal}' 
            onclick=\"javascript:window.open('{$urlToWhatIsPayPal}','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1220, height=700'); return false;\">
            <small>{$textWhatIsPayPal}</small></a>";

        }
        return $iconHtml;
    }

    /**
     * Remove from cart/update.
     */
    public static function update_cart_action()
    {
        if (isset($_REQUEST['apply_coupon']) ||
            isset($_REQUEST['remove_coupon']) ||
            isset($_REQUEST['remove_item']) ||
            isset($_REQUEST['undo_item']) ||
            isset($_REQUEST['update_cart']) ||
            isset($_REQUEST['proceed'])) {
            wc_nocache_headers();
            $nonce_value = wc_get_var($_REQUEST['woocommerce-cart-nonce'], wc_get_var($_REQUEST['_wpnonce'], '')); // @codingStandardsIgnoreLine.

            if (!empty($_POST['apply_coupon']) && !empty($_POST['coupon_code'])) {
                WC()->cart->add_discount(sanitize_text_field(wp_unslash($_POST['coupon_code'])));
            } elseif (isset($_GET['remove_coupon'])) {
                WC()->cart->remove_coupon(wc_clean(wp_unslash($_GET['remove_coupon'])));
            } elseif (!empty($_GET['remove_item']) && wp_verify_nonce($nonce_value, 'woocommerce-cart')) {
                $cart_item_key = sanitize_text_field(wp_unslash($_GET['remove_item']));
                $cart_item = WC()->cart->get_cart_item($cart_item_key);
                if ($cart_item) {
                    WC()->cart->remove_cart_item($cart_item_key);
                    $product = wc_get_product($cart_item['product_id']);
                    $item_removed_title = apply_filters('woocommerce_cart_item_removed_title', $product ? sprintf(_x('&ldquo;%s&rdquo;', 'Item name in quotes', 'woocommerce'), $product->get_name()) : __('Item', 'woocommerce'), $cart_item);
                    // Don't show undo link if removed item is out of stock.
                    if ($product && $product->is_in_stock() && $product->has_enough_stock($cart_item['quantity'])) {
                        /* Translators: %s Product title. */
                        $removed_notice = sprintf(__('%s removed.', 'woocommerce'), $item_removed_title);
                        $removed_notice .= ' <a href="' . esc_url(wc_get_cart_undo_url($cart_item_key)) . '" class="restore-item">' . __('Undo?', 'woocommerce') . '</a>';
                    } else {
                        /* Translators: %s Product title. */
                        $removed_notice = sprintf(__('%s removed.', 'woocommerce'), $item_removed_title);
                    }
                    wc_add_notice($removed_notice);
                }
                $referer = wp_get_referer() ? remove_query_arg(['remove_item', 'add-to-cart', 'added-to-cart'], add_query_arg('removed_item', '1', wp_get_referer())) : wc_get_cart_url();
                wp_safe_redirect($referer);
                exit;
            } elseif (!empty($_GET['undo_item']) && isset($_GET['_wpnonce']) && wp_verify_nonce($nonce_value, 'woocommerce-cart')) {
                // Undo Cart Item.
                $cart_item_key = sanitize_text_field(wp_unslash($_GET['undo_item']));
                WC()->cart->restore_cart_item($cart_item_key);
                $referer = wp_get_referer() ? remove_query_arg(['undo_item', '_wpnonce'], wp_get_referer()) : wc_get_cart_url();
                wp_safe_redirect($referer);
                exit;
            }
            // Update Cart - checks apply_coupon too because they are in the same form.
            if ((!empty($_POST['apply_coupon']) || !empty($_POST['update_cart']) || !empty($_POST['proceed'])) &&
                wp_verify_nonce($nonce_value, 'woocommerce-cart')) {
                $cart_updated = false;
                $cart_totals = isset($_POST['cart']) ? wp_unslash($_POST['cart']) : '';

                if (!WC()->cart->is_empty() && is_array($cart_totals)) {
                    foreach (WC()->cart->get_cart() as $cart_item_key => $values) {

                        $_product = $values['data'];

                        // Skip product if no updated quantity was posted.
                        if (!isset($cart_totals[$cart_item_key]) || !isset($cart_totals[$cart_item_key]['qty'])) {
                            continue;
                        }

                        // Sanitize.
                        $quantity = apply_filters('woocommerce_stock_amount_cart_item', wc_stock_amount(preg_replace('/[^0-9\.]/', '', $cart_totals[$cart_item_key]['qty'])), $cart_item_key);

                        if ('' === $quantity || $quantity === $values['quantity']) {
                            continue;
                        }

                        // Update cart validation.
                        $passed_validation = apply_filters('woocommerce_update_cart_validation', true, $cart_item_key, $values, $quantity);

                        // is_sold_individually.
                        if ($_product->is_sold_individually() && $quantity > 1) {
                            /* Translators: %s Product title. */
                            wc_add_notice(sprintf(__('You can only have 1 %s in your cart.', 'woocommerce'), $_product->get_name()), 'error');
                            $passed_validation = false;
                        }

                        if ($passed_validation) {
                            WC()->cart->set_quantity($cart_item_key, $quantity, false);
                            $cart_updated = true;
                        }
                    }
                }

                // Trigger action - let 3rd parties update the cart if they need to and update the $cart_updated variable.
                $cart_updated = apply_filters('woocommerce_update_cart_action_cart_updated', $cart_updated);
                if ($cart_updated) {
                    WC()->cart->calculate_totals();
                }
                $proceedToCheckout = !empty($_POST['proceed']);
                if ($proceedToCheckout) {
                    $referer = wc_get_checkout_url();
                    /*wp_safe_redirect($referer);
                    exit;*/
                    header('Content-Type: application/json');
                    echo json_encode(['url' => $referer]);
                } else if ($cart_updated) {
//                wc_add_notice(__('Cart updated.', 'woocommerce'));
                    $referer = wp_get_referer();
                    if (!$referer) {
                        $referer = wc_get_cart_url();
                    }
                    $referer = remove_query_arg(['remove_coupon', 'add-to-cart'], $referer);
                    /*wp_safe_redirect($referer);
                    exit;*/
                    header('Content-Type: application/json');
                    echo json_encode(['url' => $referer]);
                }
            }
        }
    }

    static function getQuantityInputFormat($args = [], $product = null)
    {
        if (is_null($product) && isset($GLOBALS['product'])) {
            $product = $GLOBALS['product'];
        }
        if ($product) {
            $defaults = [
                'input_id' => uniqid('quantity_'),
                'input_name' => 'quantity',
                'input_value' => '1',
                'max_value' => apply_filters('woocommerce_quantity_input_max', -1, $product),
                'min_value' => apply_filters('woocommerce_quantity_input_min', 1, $product),
                'step' => apply_filters('woocommerce_quantity_input_step', 1, $product),
                'pattern' => apply_filters('woocommerce_quantity_input_pattern', has_filter('woocommerce_stock_amount', 'intval') ? '[0-9]*' : ''),
                'inputmode' => apply_filters('woocommerce_quantity_input_inputmode', has_filter('woocommerce_stock_amount', 'intval') ? 'numeric' : ''),
            ];

            $args = apply_filters('woocommerce_quantity_input_args', wp_parse_args($args, $defaults), $product);

            // Apply sanity to min/max args - min cannot be lower than 0.
            $args['min_value'] = max($args['min_value'], 0);
            $args['max_value'] = 0 < $args['max_value'] ? $args['max_value'] : '';

            // Max cannot be lower than min if defined.
            if ('' !== $args['max_value'] && $args['max_value'] < $args['min_value']) {
                $args['max_value'] = $args['min_value'];
            }
        }
        return $args;
    }

    static function getFormatOfPrice(array $args = [])
    {
        $currency = '';
        if (isset($args['currency'])) {
            $currency = $args['currency'];
        }
        return apply_filters('wc_price_args', wp_parse_args($args, [
            'ex_tax_label' => false,
            'currency' => get_woocommerce_currency(),
            'currencySymbol' => get_woocommerce_currency_symbol($currency),
            'decimal_separator' => wc_get_price_decimal_separator(),
            'thousand_separator' => wc_get_price_thousand_separator(),
            'decimals' => wc_get_price_decimals(),
            'price_format' => get_woocommerce_price_format(),
        ]));
    }

    static function getFormattedPrice(float $price, array $args = [], bool $showCurrency = true)
    {

        $args = self::getFormatOfPrice($args);
        $unformatted_price = $price;
        $negative = $price < 0;
        $price = apply_filters('raw_woocommerce_price', floatval($negative ? $price * -1 : $price));
        $price = apply_filters('formatted_woocommerce_price', number_format($price,
            $args['decimals'],
            $args['decimal_separator'],
            $args['thousand_separator']),
            $price,
            $args['decimals'],
            $args['decimal_separator'],
            $args['thousand_separator']);

        if (apply_filters('woocommerce_price_trim_zeros', false) && $args['decimals'] > 0) {
            $price = wc_trim_zeros($price);
        }
        $return = ($negative ? '-' : '');

        if ($showCurrency) {
            $return .= sprintf($args['price_format'], $args['currency'], $price);
        } else {
            $return .= $price;
        }
        if ($args['ex_tax_label'] && wc_tax_enabled()) {
            $return .= wc()->countries->ex_tax_or_vat();
        }
        /**
         * Filters the string of price markup.
         *
         * @param string $return Price HTML markup.
         * @param string $price Formatted price.
         * @param array $args Pass on the args.
         * @param float $unformatted_price Price as float to allow plugins custom formatting. Since 3.2.0.
         */
        return apply_filters('wc_price', $return, $price, $args, $unformatted_price);
    }

    static public function getCartSubtotal(\WC_Product $product, $quantity, bool $showCurrency = true)
    {
        $productPrice = $product->get_price();
        $cart = wc()->cart;
        if ($product->is_taxable()) {
            if ($cart->display_prices_including_tax()) {
                $pricePerRow = wc_get_price_including_tax($product, ['qty' => $quantity]);
                $productSubtotal = self::getFormattedPrice($pricePerRow, [], $showCurrency);
                if (!wc_prices_include_tax() && $cart->get_subtotal_tax() > 0) {
                    $productSubtotal .= wc()->countries->inc_tax_or_vat();
                }
            } else {
                $pricePerRow = wc_get_price_excluding_tax($product, ['qty' => $quantity]);
                $productSubtotal = self::getFormattedPrice($pricePerRow, [], $showCurrency);
                if (wc_prices_include_tax() && $cart->get_subtotal_tax() > 0) {
                    $productSubtotal .= wc()->countries->ex_tax_or_vat();
                }
            }
        } else {
            $pricePerRow = $productPrice * $quantity;
            $productSubtotal = self::getFormattedPrice($pricePerRow, [], $showCurrency);
        }
        return apply_filters('woocommerce_cart_product_subtotal', $productSubtotal, $product, $quantity, $cart);
    }

    public static function getCartItems()
    {
        $contentCartItems = [
            'texts' => [
                'textAvailableOnBackOrder' => __('Available on backorder', 'woocommerce'),
                'textRemove' => __('Remove', 'woocommerce'),
                'textQuantity' => __('Quantity', 'woocommerce')
            ],
            'items' => []
        ];
        $filterNameCartItemVisible = 'woocommerce_widget_cart_item_visible';
        $filterNameCartItemQty = 'woocommerce_widget_cart_item_quantity';
        $cartItemClass = 'woocommerce-mini-cart-item mini_cart_item';
        if (is_page('cart') || is_cart()) {
            $filterNameCartItemVisible = 'woocommerce_cart_item_visible';
            $filterNameCartItemQty = 'woocommerce_cart_item_quantity';
            $cartItemClass = 'woocommerce-cart-form__cart-item cart_item';
        }
        foreach (wc()->cart->get_cart() as $cartItemKey => $cartItem) {
            /**@var  $cartProduct \WC_Product */
            $cartProduct = apply_filters('woocommerce_cart_item_product', $cartItem['data'], $cartItem, $cartItemKey);
            if ($cartProduct && $cartProduct->exists() && $cartItem['quantity'] > 0 &&
                apply_filters($filterNameCartItemVisible, true, $cartItem, $cartItemKey)) {
                //Name
                $cartProductName = $cartProduct->get_name();
                $cartProductName = apply_filters('woocommerce_cart_item_name', $cartProductName, $cartItem, $cartItemKey);
                $cartProductName = wp_kses_post($cartProductName);
                //Link
                $cartProductLink = '';
                if ($cartProduct->is_visible()) {
                    $cartProductLink = $cartProduct->get_permalink();
                }
                $cartProductLink = apply_filters('woocommerce_cart_item_permalink', $cartProductLink, $cartItem, $cartItemKey);
                $cartProductLink = esc_url($cartProductLink);
                //Attributes
                $cartProductId = apply_filters('woocommerce_cart_item_product_id', $cartItem['product_id'], $cartItem,
                    $cartItemKey);
                $cartProductUrl = esc_url(wc_get_cart_remove_url($cartItemKey));
                //Image
                $cartProductImage = get_the_post_thumbnail_url($cartProductId, 'woocommerce_thumbnail');
                $cartProductImage = apply_filters('woocommerce_cart_item_thumbnail', $cartProductImage, $cartItem, $cartItemKey);
                $cartProductImage = wp_kses_post($cartProductImage);
                //Price
                if (wc()->cart->display_prices_including_tax()) {
                    $cartProductPrice = wc_get_price_including_tax($cartProduct);
                } else {
                    $cartProductPrice = wc_get_price_excluding_tax($cartProduct);
                }
                $unformattedProductPrice = $cartProductPrice;
                $cartProductPrice = self::getFormattedPrice($cartProductPrice, [], false);
                $cartProductPrice = apply_filters('woocommerce_cart_product_price', $cartProductPrice, $cartProduct);
                $cartProductPrice = apply_filters('woocommerce_cart_item_price', $cartProductPrice, $cartItem, $cartItemKey);
                //Quantity
                $cartProductQty = apply_filters($filterNameCartItemQty, $cartItem['quantity'], $cartItemKey, $cartItem);
                //Total
                $cartProductPriceSubTotal = self::getCartSubtotal($cartProduct, $cartItem['quantity'], false);
                /*$cartProductPriceSubTotal = apply_filters('woocommerce_cart_item_subtotal', $cartProductPriceSubTotal,
                    $cartItem, $cartItemKey);*/
                $cssCartItem = apply_filters("woocommerce_{$cartItemClass}_class", $cartItemClass, $cartItem, $cartItemKey);
                $cssCartItem = esc_attr($cssCartItem);
                $cssCartItem = "row {$cssCartItem}";
                $contentCartItems['items'] [] = [
                    'id' => $cartProductId,
                    'key' => $cartItemKey,
                    'sku' => $cartProduct->get_sku(),
                    'link' => $cartProductLink,
                    'linkRemove' => $cartProductUrl,
                    'img' => ['src' => $cartProductImage],
                    'name' => $cartProductName,
                    'soldIndividually' => $cartProduct->is_sold_individually(),
                    'isOnBackorder' => ($cartProduct->backorders_require_notification() && $cartProduct->is_on_backorder($cartProductQty)),
                    'qty' => self::getQuantityInputFormat([
                        'input_name' => "cart[{$cartItemKey}][qty]",
                        'input_value' => $cartProductQty,
                        'max_value' => $cartProduct->get_max_purchase_quantity(),
                        'product_name' => $cartProductName
                    ], $cartProduct),
                    'unformattedPrice' => $unformattedProductPrice,
                    'price' => $cartProductPrice,
                    'priceTotal' => $cartProductPriceSubTotal,
                    'priceFormat' => self::getFormatOfPrice(),
                    'css' => $cssCartItem
                ];
            }
        }
        return $contentCartItems;
    }

    public static function getCartContents()
    {
        $contentCartItems = '';
        $filterNameCartItemVisible = 'woocommerce_widget_cart_item_visible';
        $filterNameCartItemQty = 'woocommerce_widget_cart_item_quantity';
        $cartItemClass = 'woocommerce-mini-cart-item mini_cart_item';
        if (is_page('cart') || is_cart()) {
            $filterNameCartItemVisible = 'woocommerce_cart_item_visible';
            $filterNameCartItemQty = 'woocommerce_cart_item_quantity';
            $cartItemClass = 'woocommerce-cart-form__cart-item cart_item';
        }
        foreach (wc()->cart->get_cart() as $cartItemKey => $cartItem) {
            /**@var  $cartProduct \WC_Product */
            $cartProduct = apply_filters('woocommerce_cart_item_product', $cartItem['data'], $cartItem, $cartItemKey);
            if ($cartProduct && $cartProduct->exists() && $cartItem['quantity'] > 0 &&
                apply_filters($filterNameCartItemVisible, true, $cartItem, $cartItemKey)) {
                //Image
                //'woocommerce_thumbnail'
                $cartProductImage = $cartProduct->get_image([78, 108], ['class' => 'align-middle']);
                $cartProductImage = apply_filters('woocommerce_cart_item_thumbnail', $cartProductImage, $cartItem, $cartItemKey);
                $cartProductImage = wp_kses_post($cartProductImage);
                //Name
                $cartProductName = $cartProduct->get_name();
                $cartProductName = apply_filters('woocommerce_cart_item_name', $cartProductName, $cartItem, $cartItemKey);
                $cartProductName = wp_kses_post($cartProductName);
                //Link
                $cartProductLink = '';
                if ($cartProduct->is_visible()) {
                    $cartProductLink = $cartProduct->get_permalink();
                }
                $cartProductLink = apply_filters('woocommerce_cart_item_permalink', $cartProductLink, $cartItem,
                    $cartItemKey);
                $cartProductLink = esc_url($cartProductLink);
                //Attributes
                $cartProductAttr = wc_get_formatted_cart_item_data($cartItem);
                //Back Order Notifications
                $cartProductBackOrder = '';
                if ($cartProduct->backorders_require_notification() && $cartProduct->is_on_backorder($cartItem['quantity'])) {
                    $textAvailableOnBackOrder = __('Available on backorder', 'woocommerce');
                    $cartProductBackOrder = apply_filters('woocommerce_cart_item_backorder_notification',
                        "<p class='backorder_notification'>{$textAvailableOnBackOrder}</p>");
                    $cartProductBackOrder = wp_kses_post($cartProductBackOrder);
                }
                //Price
                $cartProductPrice = wc()->cart->get_product_price($cartProduct);
                $cartProductPrice = apply_filters('woocommerce_cart_item_price', $cartProductPrice, $cartItem,
                    $cartItemKey);
                //Quantity
                if ($cartProduct->is_sold_individually()) {
                    $cartProductQty = "<input name='cart[{$cartItemKey}][qty]' value='1' type='hidden'>";
                } else {
                    $cartProductQty = woocommerce_quantity_input([
                        'input_name' => "cart[{$cartItemKey}][qty]",
                        'input_value' => $cartItem['quantity'],
                        'max_value' => $cartProduct->get_max_purchase_quantity(),
                        'min_value' => '0',
                        'product_name' => $cartProductName,
                    ], $cartProduct, false);
                }
                $cartProductQty = apply_filters($filterNameCartItemQty, $cartProductQty, $cartItemKey, $cartItem);
                //Total
                $cartProductPriceSubTotal = wc()->cart->get_product_subtotal($cartProduct, $cartItem['quantity']);
                $cartProductPriceTotal = apply_filters('woocommerce_cart_item_subtotal', $cartProductPriceSubTotal,
                    $cartItem, $cartItemKey);
                //Remove Action
                $textRemove = __('Remove', 'woocommerce');
                $cartProductUrl = esc_url(wc_get_cart_remove_url($cartItemKey));
                $cartProductId = apply_filters('woocommerce_cart_item_product_id', $cartItem['product_id'], $cartItem,
                    $cartItemKey);
                $cartProductDataAttr = '';
                if ($cartProductId) {
                    $cartProductDataAttr .= " data-product_id='{$cartProductId}'";
                }
                $cartProductSku = esc_attr($cartProduct->get_sku());
                if ($cartProductSku) {
                    $cartProductDataAttr .= " data-product_sku='{$cartProductSku}'";
                }
                if ($cartItemKey) {
                    $cartProductDataAttr .= " data-cart_item_key='{$cartItemKey}'";
                }

                $cartProductRemoveButton = "<a href='{$cartProductUrl}' title='{$textRemove}' class='remove_from_cart_button' {$cartProductDataAttr}>
                <i class='fa fa-trash'></i>{$textRemove}</a>";
                $cartProductRemoveButton = apply_filters('woocommerce_cart_item_remove_link', $cartProductRemoveButton, $cartItemKey);
                //Content
                $cssCartItem = apply_filters("woocommerce_{$cartItemClass}_class", $cartItemClass, $cartItem, $cartItemKey);
                $cssCartItem = esc_attr($cssCartItem);
                $textPrice = __('Price', 'woocommerce');
                $contentCartItems .= "<div class='row {$cssCartItem}'>
                <div class='col-xs-5'>
                    <div class='float-xs-left text-xs-center'>{$cartProductImage}</div>
                    <a href='{$cartProductLink}'>{$cartProductName}</a>
                    <br>
                    {$cartProductAttr}
                    {$cartProductBackOrder}
                    {$cartProductRemoveButton}
                </div>
                <div class='col-xs-2'>{$cartProductPrice}</div>
                <div class='col-xs-2 text-xs-center'>{$cartProductQty}</div>
                <div class='col-xs-3 text-xs-center'>{$cartProductPriceTotal}</div></div>";
            }
        }
        return $contentCartItems;
    }

    public static function getShippingMethodLabel(\WC_Shipping_Rate $method)
    {
        $label = $method->get_label();
        $methodKeyId = str_replace(':', '_', $method->id);
        $methodLabel = get_option("woocommerce_{$methodKeyId}_settings", true)['title'];
        if ($methodLabel) {
            $label = $methodLabel;
        }
        return $label;
    }

    public static function getShippingMethodPrice(\WC_Shipping_Rate $method)
    {
        $shippingMethodPrice = '';
        if ($method->cost >= 0 && $method->get_method_id() !== 'free_shipping') {
            if (wc()->cart->display_prices_including_tax()) {
                $shippingMethodPrice .= wc_price($method->cost + $method->get_shipping_tax());
                if ($method->get_shipping_tax() > 0 && !wc_prices_include_tax()) {
                    $shippingMethodPrice .= ' <small class="tax_label">' . wc()->countries->inc_tax_or_vat() . '</small>';
                }
            } else {
                $shippingMethodPrice .= wc_price($method->cost);
                if ($method->get_shipping_tax() > 0 && wc_prices_include_tax()) {
                    $shippingMethodPrice .= ' <small class="tax_label">' . wc()->countries->ex_tax_or_vat() . '</small>';
                }
            }
        }
        return $shippingMethodPrice;
    }

    public static function getShippingMethodLabelFull(\WC_Shipping_Rate $method)
    {
        $label = self::getShippingMethodLabel($method);
        $label .= ': ' . self::getShippingMethodPrice($method);
        return apply_filters('woocommerce_cart_shipping_method_full_label', $label, $method);
    }

    public static function handlePreOptionEnableGuestCheckout()
    {
        return 'no';
    }

    public static function handleFieldsBilling($addressFields)
    {
        /*
        billing_first_name 10
        billing_last_name  20
        billing_company    30  110
        billing_country    40  50
        billing_address_1  50  80
        billing_address_2  60  90
        billing_city       70  70
        billing_state      80  60
        billing_postcode   90  100
        billing_email      100 30
        billing_phone      110 40
        Ex: $addressFields['billing_first_name']['priority'] = 10;
        */
        return $addressFields;
    }

    public static function handleFieldsShipping($addressFields)
    {
        /*
        shipping_first_name 10
        shipping_last_name  20
        shipping_company    30
        shipping_address_1  40
        shipping_address_2  50
        shipping_city       60
        shipping_postcode   70
        shipping_country    80
        shipping_state      90
        Ex: $addressFields['shipping_first_name']['priority'] = 10;
        */
        return $addressFields;
    }

    public static function handleFieldsCheckout($addressFields)
    {
        //$addressFields['billing']['billing_first_name']['priority'] = 10;
        //$addressFields['shipping']['shipping_first_name']['priority'] = 10;
        //$addressFields['order']['order_comments']['priority'] = 10;
        return $addressFields;
    }

    public static function handleFieldsDefault($addressFields)
    {
        /*
        first_name 10
        last_name  20
        company    30  90
        country    40  30
        address_1  50  60
        address_2  60  70
        city       70  40
        state      80  50
        postcode   90  80 */
        $addressFields['country']['priority'] = 30;
        $addressFields['state']['priority'] = 40;
        $addressFields['city']['priority'] = 50;
        $addressFields['address_1']['priority'] = 60;
        $addressFields['address_2']['priority'] = 70;
        $addressFields['postcode']['priority'] = 80;
        $addressFields['company']['priority'] = 90;
        return $addressFields;
    }

    /**
     * Load Required CSS Styles and Javascript Files
     * Docs: https://developer.wordpress.org/themes/basics/including-css-javascript/
     */
    function enqueueScriptsWooCommerce()
    {
        wp_deregister_script('selectWoo');
        $uriToLibs = get_template_directory_uri() . '/libs/';
        wp_deregister_script('wc-address-i18n');
        wp_enqueue_script('wc-address-i18n', $uriToLibs . 'address-i18n.js', ['jquery'],
            false, true);
        wp_deregister_script('wc-cart');
        wp_enqueue_script('wc-cart', $uriToLibs . 'cart.js',
            ['jquery', 'woocommerce', 'wc-country-select', 'wc-address-i18n'], false, true);
        wp_localize_script('wc-cart', 'jsonCart', self::getCartItems());
    }

    function handleEditAddressEndpoint()
    {
        wc_get_template('myaccount/my-address.php');
    }

    /** Add WooComerce Theme Support */
    function addSupportOfWooCommerce()
    {
        add_theme_support('woocommerce');
        /*add_theme_support( 'woocommerce', array(
            'thumbnail_image_width' => 150,
            'single_image_width'    => 300,
            'product_grid'          => array(
                'default_rows'    => 3,
                'min_rows'        => 2,
                'max_rows'        => 8,
                'default_columns' => 4,
                'min_columns'     => 2,
                'max_columns'     => 5,
            ),
        ) );*/
    }

    static public function getProductLink()
    {
        /**@var $product \WC_Product */
        global $product;
        return esc_url(apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product));
    }

    function getProductRatingMessage()
    {
        /**@var $product \WC_Product */
        global $product;
        //$countReviews = $product->get_review_count();
        $countRating = $product->get_rating_count();
        $averageRating = $product->get_average_rating();
        $textRating = sprintf(__('Rated %s out of 5', 'woocommerce'), $countRating);
        if (0 < $countRating) {
            /* translators: 1: rating 2: rating count */
            $textRating = _n('Rated %1$s out of 5 based on %2$s customer rating',
                'Rated %1$s out of 5 based on %2$s customer ratings', $countRating, 'woocommerce');
            $textRating = sprintf($textRating, $averageRating, $countRating);
        }
        return $textRating;
    }

    function getCartTitle()
    {
        $result = __('Cart', 'woocommerce');
        $countCartContents = wc()->cart->get_cart_contents_count();
        if ($countCartContents !== 0) {
            $textCartTotal = wc()->cart->get_cart_total();
            $textCartItems = _n('%s item', '%s items', $countCartContents, 'woocommerce');
            $textCartItems = sprintf($textCartItems, $countCartContents);
            $result = "<i class='fa fa-shopping-cart'></i>{$textCartItems} - {$textCartTotal}";
            $attributes['title'] = __('View cart', 'woocommerce');
        } else {
            $result = "<i class='fa fa-shopping-cart'></i> {$result}";
        }

        return "<span class='cart-contents'>$result</span>";
    }

    /**
     * Filters the HTML attributes applied to a menu item's anchor element.
     * @param array $attributes The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
     * @param \WP_Post $item The current menu item.
     * @param \stdClass $args An object of wp_nav_menu() arguments.
     * @param int $depth Depth of menu item. Used for padding.
     * @return array
     */
    function handleNavMenuItemLinkAttributes(array $attributes, \WP_Post $item, \stdClass $args, int $depth)
    {
        if ($args->theme_location == '' && $depth == 0) {
//            $urlMenuItem = wc_get_cart_url();
            $urlMenuItem = wc_get_checkout_url();
            if ($urlMenuItem === $attributes['href']) {
                $item->title = $this->getCartTitle();
            }
        }
        return $attributes;
    }

    function handleNavMenuItemsAddToCart($fragments)
    {
        $fragments['span.cart-contents'] = $this->getCartTitle();
        return $fragments;
    }

    function handleWooCommerceLoginRedirect($redirect)
    {
        $redirect_page_id = url_to_postid($redirect);
        $checkout_page_id = wc_get_page_id('checkout');

        if ($redirect_page_id == $checkout_page_id) {
            return $redirect;
        }
        return get_permalink(get_option('woocommerce_myaccount_page_id')) . 'edit-account/';
    }

    function handleBeforeShopLoopItem()
    {
        echo "<div class='card card-product'>";
    }

    function handleAfterShopLoopItem()
    {
        echo "</div>";
    }

    function handleBeforeShopLoopItemTitleThumb()
    {
        $productThumb = woocommerce_get_product_thumbnail();
        echo "<div class='card-image'><a href='{$this->getProductLink()}'>{$productThumb}</a></div>";
    }

    function handleBeforeShopLoopItemTitle()
    {
        $productTitle = get_the_title();
        echo "<h5 class='card-title text-hide-overflow'><a href='{$this->getProductLink()}'>{$productTitle}</a></h5>";
    }

    function handleAfterShopLoopItemTitle()
    {
        /**@var $product \WC_Product */
        global $product;
        //[Rating]
        $htmlRating = '';
        if (get_option('woocommerce_enable_review_rating') !== 'no') {
            $ratingWidth = (($product->get_average_rating() / 5) * 100);
            $htmlRating = "<div class='star-rating' style='display: inline-block'><span style='width:{$ratingWidth}%'></span></div>";
        }
        //[Price]
        if ($htmlPrice = $product->get_price_html()) {
            $htmlPrice = "<h5>{$htmlPrice}</h5>";
        }
        //[Add To Cart]
        ob_start();
        woocommerce_template_loop_add_to_cart();
        $htmlAddToCart = ob_get_clean();
        echo "<div class='text-xs-center'>{$htmlRating}{$htmlPrice}<p>{$htmlAddToCart}</p></div>";
    }

    /**
     * Outputs a checkout/address form field.
     *
     * @param string $key Key.
     * @param mixed $args Arguments.
     * @param string $value (default: null).
     * @return string
     */
    static function getFormField($key, $args, $value = null)
    {
        $args = wp_parse_args($args, [
            'type' => 'text',
            'label' => '',
            'description' => '',
            'placeholder' => '',
            'maxlength' => false,
            'required' => false,
            'autocomplete' => false,
            'id' => $key,
            'class' => [],
            'label_class' => [],
            'input_class' => [],
            'return' => false,
            'options' => [],
            'custom_attributes' => [],
            'validate' => [],
            'default' => '',
            'autofocus' => '',
            'priority' => '',
        ]);
        $args['class'] = [];
        $args = apply_filters('woocommerce_form_field_args', $args, $key, $value);
        if ($args['required']) {
            $args['class'][] = 'validate-required';
            $args['label_class'][] = 'required';
        }
        if (is_string($args['label_class'])) {
            $args['label_class'] = [$args['label_class']];
        }
        if (is_null($value)) {
            $value = $args['default'];
        }
        // Custom attribute handling.
        $custom_attributes = [];
        $args['custom_attributes'] = array_filter((array)$args['custom_attributes'], 'strlen');
        if ($args['maxlength']) {
            $args['custom_attributes']['maxlength'] = absint($args['maxlength']);
        }
        if (!empty($args['autocomplete'])) {
            $args['custom_attributes']['autocomplete'] = $args['autocomplete'];
        }
        if (true === $args['autofocus']) {
            $args['custom_attributes']['autofocus'] = 'autofocus';
        }
        $inputId = esc_attr($args['id']);
        if ($args['description']) {
            $args['custom_attributes']['aria-describedby'] = $inputId . '-description';
        }
        if (!empty($args['custom_attributes']) && is_array($args['custom_attributes'])) {
            foreach ($args['custom_attributes'] as $attribute => $attribute_value) {
                $custom_attributes[] = esc_attr($attribute) . '="' . esc_attr($attribute_value) . '"';
            }
        }
        if (!empty($args['validate'])) {
            foreach ($args['validate'] as $validate) {
                $args['class'][] = 'validate-' . $validate;
            }
        }
        $field = '';
        $sort = $args['priority'] ? $args['priority'] : '';
        $sort = esc_attr($sort);
        $fieldContainer = '<fieldset id="%2$s" class="row %1$s" data-priority="' . $sort . '">%3$s</fieldset>';

        $inputName = esc_attr($key);
        $inputAttrs = implode(' ', $custom_attributes);
        $inputClass = esc_attr(implode(' ', $args['input_class']));
        $inputPlaceHolder = esc_attr($args['placeholder']);
        $inputType = esc_attr($args['type']);
        switch ($args['type']) {
            case 'text':
            case 'password':
            case 'datetime':
            case 'datetime-local':
            case 'date':
            case 'month':
            case 'time':
            case 'week':
            case 'number':
            case 'email':
            case 'url':
            case 'tel':
                $inputValue = esc_attr($value);
                $field .= "<input id='{$inputId}' name='{$inputName}'  type='{$inputType}' value='{$inputValue}' 
                placeholder='{$inputPlaceHolder}' class='input-text {$inputClass}' {$inputAttrs}>";
                break;
            case 'textarea':
                if (empty($args['custom_attributes']['rows'])) {
                    $inputAttrs .= ' rows="2"';
                }
                if (empty($args['custom_attributes']['cols'])) {
                    $inputAttrs .= ' cols="5"';
                }
                $inputValue = esc_textarea($value);
                $field .= "<textarea id='{$inputId}' name='{$inputName}' placeholder='{$inputPlaceHolder}' 
                class='input-text {$inputClass}' {$inputAttrs}>{$inputValue}</textarea>";
                break;
            case 'checkbox':
                $inputChecked = checked($value, 1, false);
                $inputLabelClass = implode(' ', $args['label_class']);
                $inputLabelText = $args['label'];
                $inputLabelTitle = __('required', 'woocommerce');
                if (!$args['required']) {
                    $inputLabelTitle = __('optional', 'woocommerce');
                    $inputLabelText .= " ({$inputLabelTitle})";
                }
                $field = "<label title='{$inputLabelTitle}' class='checkbox {$inputLabelClass}' {$inputAttrs}>
                <input id='{$inputId}' name='{$inputName}' type='{$inputType}' class='{$inputClass}' 
                value='1' {$inputChecked}>{$inputLabelText}</label>";
                break;
            case 'radio':
                if (!empty($args['options'])) {
                    $inputLabelClass = implode(' ', $args['label_class']);
                    foreach ($args['options'] as $optionKey => $optionText) {
                        $inputValue = esc_attr($optionKey);
                        $optionSelected = checked($value, $optionKey, false);
                        $optionText = esc_attr($optionText);
                        $field .= "<input id='{$inputId}_{$inputValue}' name='{$inputName}' value='{$inputValue}' 
                        type='radio' class='input-radio {$inputClass}' {$inputAttrs} {$optionSelected}>
                        <label for='{$inputId}_{$inputValue}' class='radio {$inputLabelClass}'>{$optionText}</label>";
                    }
                }
                break;
            case 'select':
                $field = '';
                if (!empty($args['options'])) {
                    $options = '';
                    foreach ($args['options'] as $optionKey => $optionText) {
                        if ($optionKey === '') {
                            if (empty($args['placeholder'])) {
                                $args['placeholder'] = __('Choose an option', 'woocommerce');
                                if ($optionText) {
                                    $args['placeholder'] = $optionText;
                                }
                            }
                            $custom_attributes[] = 'data-allow_clear="true"';
                        }
                        $inputValue = esc_attr($optionKey);
                        $optionSelected = selected($value, $optionKey, false);
                        $optionText = esc_attr($optionText);
                        $options .= "<option value='{$inputValue}' {$optionSelected}>{$optionText}</option>";
                    }
                    $field .= "<select id='{$inputId }' name='{$inputName}' data-placeholder='{$inputPlaceHolder}' 
                    class='select {$inputClass}' {$inputAttrs}>{$options}</select>";
                }
                break;
            case 'country':
                if ($key === 'shipping_country') {
                    $countries = wc()->countries->get_shipping_countries();
                } else {
                    $countries = wc()->countries->get_allowed_countries();
                }
                if (1 === count($countries)) {
                    $inputValue = current(array_keys($countries));
                    $currentCountry = current(array_values($countries));
                    $field .= "<strong>{$currentCountry}</strong>
                    <input id='{$inputId}' name='{$inputName}' type='hidden'  value='{$inputValue}' {$inputAttrs} 
                    class='country_to_state' readonly='readonly'>";
                } else {
                    $textSelectCountry = __('Select a country&hellip;', 'woocommerce');
                    $textUpdateCountry = __('Update country', 'woocommerce');
                    $field = "<select id='{$inputId}' name='{$inputName}' {$inputAttrs}
                    class='country_to_state country_select {$inputClass}'><option value=''>{$textSelectCountry}</option>";
                    foreach ($countries as $countryKey => $countryValue) {
                        $inputValue = esc_attr($countryKey);
                        $optionSelected = selected($value, $countryKey, false);
                        $field .= "<option value='{$inputValue}' {$optionSelected}>{$countryValue}</option>";
                    }
                    $field .= "</select><noscript>
                    <button type='submit' name='woocommerce_checkout_update_totals' value='{$textUpdateCountry}'>
                    {$textUpdateCountry}</button></noscript>";
                }
                break;
            case 'state':
                /* Get country this state field is representing */
                if (isset($args['country'])) {
                    $currentCountry = $args['country'];
                } else {
                    $billingState = 'shipping_country';
                    if ('billing_state' === $key) {
                        $billingState = 'billing_country';
                    }
                    $currentCountry = wc()->checkout->get_value($billingState);
                }
                $states = wc()->countries->get_states($currentCountry);
                if (is_array($states) && empty($states)) {
                    $field .= "<input id='{$inputId}' name='{$inputName}' placeholder='{$inputPlaceHolder}' {$inputAttrs}  
                    class='hidden' value='' readonly='readonly' type='hidden'>";
                    $fieldContainer = '<fieldset class="row %1$s" id="%2$s" style="display: none">%3$s</fieldset>';
                } elseif (!is_null($currentCountry) && is_array($states)) {
                    $textSelectState = __('Select a state&hellip;', 'woocommerce');
                    $field .= "<select id='{$inputId}' name='{$inputName}' class='state_select {$inputClass}' 
                    {$inputAttrs} data-placeholder='{$inputPlaceHolder}'><option value=''>{$textSelectState}</option>";
                    foreach ($states as $stateKey => $stateValue) {
                        $inputValue = esc_attr($stateKey);
                        $optionSelected = selected($value, $stateKey, false);
                        $field .= "<option value='{$inputValue}' {$optionSelected}>{$stateValue}</option>";
                    }
                    $field .= '</select>';
                } else {
                    $inputValue = esc_attr($value);
                    $field .= "<input id='{$inputId}' name='{$inputName}' value='{$inputValue}' {$inputAttrs} 
                    placeholder='{$inputPlaceHolder}' class='input-text {$inputClass}' type='text'>";
                }
                break;
        }

        if (!empty($field)) {
            $fieldHtml = '';
            if ($args['type'] !== 'checkbox') {
                $labelId = $inputId;
                $labelClass = esc_attr(implode(' ', $args['label_class']));
                if ($args['type'] == 'radio') {
                    $labelId = current(array_keys($args['options']));
                }
                $inputLabelText = '';
                if ($args['label']) {
                    $inputLabelText = $args['label'];
                }
                $inputLabelTitle = __('required', 'woocommerce');
                if (!$args['required']) {
                    $inputLabelTitle = __('optional', 'woocommerce');
                    if ($args['description']) {
                        $args['description'] .= " ({$inputLabelTitle})";
                    } else {
                        $args['description'] = "({$inputLabelTitle})";
                    }
                }
                $fieldHtml .= "<label for='{$labelId}' class='col-xs-6 col-md-5 title text-xs-right {$labelClass}' 
                title='{$inputLabelTitle}'>{$inputLabelText}</label>";
            }
            $fieldDescription = '';
            if ($args['description']) {
                $fieldDescription = wp_kses_post($args['description']);
                $fieldDescription = "<span class='description' id='{$inputId}-description' aria-hidden='true'>
                {$fieldDescription}</span>";
            }
            $fieldHtml .= "<div class='woocommerce-input-wrapper col-xs-6 col-md-7'>{$field}{$fieldDescription}</div>";
            $containerClass = esc_attr(implode(' ', $args['class']));
            $containerId = $inputId . '_field';
            $field = sprintf($fieldContainer, $containerClass, $containerId, $fieldHtml);
        }
        /**
         * Filter by type.
         */
        $field = apply_filters('woocommerce_form_field_' . $args['type'], $field, $key, $args, $value);
        /**
         * General filter on form fields.
         * @since 3.4.0
         */
        $field = apply_filters('woocommerce_form_field', $field, $key, $args, $value);

        if ($args['return']) {
            return $field;
        } else {
            echo $field;
        }
    }

    /**
     * Save and and update a billing or shipping address if the
     * form was submitted through the user account page.
     */
    public static function saveAddress()
    {
        if ('POST' == strtoupper($_SERVER['REQUEST_METHOD'])) {
            if (isset($_POST['action']) && strpos($_POST['action'], 'edit_address') === 0) {
                wc_nocache_headers();
                $nonce_value = wc_get_var($_REQUEST['woocommerce-edit-address-nonce'], wc_get_var($_REQUEST['_wpnonce'], '')); // @codingStandardsIgnoreLine.
                if (wp_verify_nonce($nonce_value, 'woocommerce-edit_address')) {
                    $user_id = get_current_user_id();
                    $load_address = substr($_POST['action'], strlen('edit_address_'));
                    if ($user_id > 0 && empty($load_address) === false) {
                        $address = wc()->countries->get_address_fields(esc_attr($_POST[$load_address . '_country']), $load_address . '_');
                        foreach ($address as $key => $field) {
                            if (!isset($field['type'])) {
                                $field['type'] = 'text';
                            }

                            // Get Value.
                            switch ($field['type']) {
                                case 'checkbox' :
                                    $_POST[$key] = (int)isset($_POST[$key]);
                                    break;
                                default :
                                    $_POST[$key] = isset($_POST[$key]) ? wc_clean($_POST[$key]) : '';
                                    break;
                            }

                            // Hook to allow modification of value.
                            $_POST[$key] = apply_filters('woocommerce_process_myaccount_field_' . $key, $_POST[$key]);

                            // Validation: Required fields.
                            if (!empty($field['required']) && empty($_POST[$key])) {
                                wc_add_notice(sprintf(__('%s is a required field.', 'woocommerce'), $field['label']), 'error');
                            }

                            if (!empty($_POST[$key])) {

                                // Validation rules.
                                if (!empty($field['validate']) && is_array($field['validate'])) {
                                    foreach ($field['validate'] as $rule) {
                                        switch ($rule) {
                                            case 'postcode' :
                                                $_POST[$key] = strtoupper(str_replace(' ', '', $_POST[$key]));

                                                if (!WC_Validation::is_postcode($_POST[$key], $_POST[$load_address . '_country'])) {
                                                    wc_add_notice(__('Please enter a valid postcode / ZIP.', 'woocommerce'), 'error');
                                                } else {
                                                    $_POST[$key] = wc_format_postcode($_POST[$key], $_POST[$load_address . '_country']);
                                                }
                                                break;
                                            case 'phone' :
                                                $_POST[$key] = wc_format_phone_number($_POST[$key]);

                                                if (!WC_Validation::is_phone($_POST[$key])) {
                                                    wc_add_notice(sprintf(__('%s is not a valid phone number.', 'woocommerce'), '<strong>' . $field['label'] . '</strong>'), 'error');
                                                }
                                                break;
                                            case 'email' :
                                                $_POST[$key] = strtolower($_POST[$key]);

                                                if (!is_email($_POST[$key])) {
                                                    wc_add_notice(sprintf(__('%s is not a valid email address.', 'woocommerce'), '<strong>' . $field['label'] . '</strong>'), 'error');
                                                }
                                                break;
                                        }
                                    }
                                }
                            }
                        }
                        do_action('woocommerce_after_save_address_validation', $user_id, $load_address, $address);
                        if (0 === wc_notice_count('error')) {
                            $customer = new WC_Customer($user_id);
                            if ($customer) {
                                foreach ($address as $key => $field) {
                                    if (is_callable(array($customer, "set_$key"))) {
                                        $customer->{"set_$key"}(wc_clean($_POST[$key]));
                                    } else {
                                        $customer->update_meta_data($key, wc_clean($_POST[$key]));
                                    }

                                    if (wc()->customer && is_callable(array(wc()->customer, "set_$key"))) {
                                        wc()->customer->{"set_$key"}(wc_clean($_POST[$key]));
                                    }
                                }
                                $customer->save();
                            }

                            wc_add_notice(__('Address changed successfully.', 'woocommerce'));
                            do_action('woocommerce_customer_save_address', $user_id, $load_address);
                            wp_safe_redirect(wc_get_endpoint_url('edit-address', '', wc_get_page_permalink('myaccount')));
                            exit;
                        }
                    }
                }
            }
        }
    }
}