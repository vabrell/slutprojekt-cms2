<?php
/**
 * Plugin Name: WooCommerce - Delivery Payment Gateway
 * Author: Victor Abrell
 * Version: 1.0
 * Description: Adds Delivery payment option
 */
defined("ABSPATH") || exit;

define("WDPG_PATH", plugin_dir_path(__FILE__));

require WDPG_PATH . "/src/Plugin.php";

function activate_wc_delivery_payment_gateway() {
	WDPG_Plugin::install();
}
register_activation_hook(__FILE__, "activate_wc_delivery_payment_gateway");

function deactivate_wc_delivery_payment_gateway() {
	WDPG_Plugin::uninstall();
}
register_deactivation_hook(__FILE__, "deactivate_wc_delivery_payment_gateway");

add_action("plugins_loaded", "wdpg_init_gateway_class");

function wdpg_init_gateway_class() {
	require WDPG_PATH . "/src/DeliveryGateway.php";

	add_filter("woocommerce_payment_gateways", "wdpg_add_delivery_gateway");
	function wdpg_add_delivery_gateway( $gateways ) {
		$gateways[] = "WDPG_DeliveryGateway";
		return $gateways;
	}
}

/**
 * Add shipping fee if gateway is selected
 */
add_action('woocommerce_cart_calculate_fees', function() {
	if (is_admin() && !defined('DOING_AJAX')) {
		return;
	}

	$gateway = new WDPG_DeliveryGateway;
	$shippingPrice = $gateway->getShippingPrice();
	$weightPrice = $gateway->getWeightPrice();
	$distancePrice = $gateway->getDistancePrice();
	
	$chosen_payment_method = WC()->session->get("chosen_payment_method");
	if ($chosen_payment_method == "wdpg_delivery") {
		WC()->cart->add_fee(__("Shipping", "wdpg"), $weightPrice + $shippingPrice + $distancePrice);
	}
});

/**
 * Reload checkout form when payment method is changed
 */
add_action("woocommerce_review_order_before_payment", function() {
?>
	<script type="text/javascript">
		(function($){
			$("form.checkout").on("change", "input[name^='payment_method']", function() {
				$("body").trigger("update_checkout");
			});
		})(jQuery);
	</script>
<?php
});