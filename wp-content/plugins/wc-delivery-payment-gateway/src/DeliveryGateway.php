<?php
// Verify that WooCommerce is installed

use Automattic\WooCommerce\Admin\API\Products;

if (class_exists("WooCommerce")) {
	class WDPG_DeliveryGateway extends WC_Payment_Gateway {

		public function __construct() {
			$this->id = "wdpg_delivery"; // payment gateway plugin ID
			$this->icon = ""; // URL of the icon
			$this->has_fields = true; // Custom form
			$this->method_title = __("Delivery", "wdpg");
			$this->method_description = __("Use the Delivery payment method", "wdpg"); // will be displayed on the options page

			$this->currencySymbol = get_woocommerce_currency_symbol();
		
			// Support
			$this->supports = array(
				"products"
			);
	
			// Load the options
			$this->init_settings();
			$this->title = $this->get_option("title");
			$this->description = $this->get_option("description");
			$this->enabled = $this->get_option("enabled");
			$this->price = $this->get_option("price");
			$this->smallPrice = $this->get_option("smallPrice");
			$this->mediumPrice = $this->get_option("mediumPrice");
			$this->largePrice = $this->get_option("largePrice");
			$this->weightPrice = $this->get_option("weightPrice");
			$this->warehouseLocation = $this->get_option("warehouseLocation");
	
			// Method with all the options fields
			$this->init_form_fields();
	
			// This action hook saves the settings
			add_action("woocommerce_update_options_payment_gateways_" . $this->id, array( $this,"process_admin_options"));
		}
	
		/**
		 * Gateway options
		 */
		public function init_form_fields(){
			$this->form_fields = array(
				"enabled" => array(
					"title"       => __("Enable/Disable", "wdpg"),
					"label"       => __("Enable Invoice Gateway", "wdpg"),
					"type"        => "checkbox",
					"description" => "",
					"default"     => "no"
				),
				"title" => array(
					"title"       => __("Title", "wdpg"),
					"type"        => "text",
					"description" => __("This controls the title which the user sees during checkout", "wdpg"),
					"default"     => __("Delivery", "wdpg"),
					"desc_tip"    => true,
				),
				"description" => array(
					"title"       => __("Description", "wdpg"),
					"type"        => "textarea",
					"description" => __("This controls the description which the user sees during checkout", "wdpg"),
					"default"     => __("Pay when your order is deliverd to your home", "wdpg"),
				),
				"warehouseLocation" => array(
					"title"       => __("Warehouse location", "wdpg"),
					"type"        => "text",
					"description" => __("This sets the from location when the delivery distance is calculated", "wdpg"),
				),
				"price" => array(
					"title"       => __("Price", "wdpg"),
					"type"        => "number",
					"description" => __("This sets the price for the delivery", "wdpg"),
					"default"     => 0,
				),
				"smallPrice" => array(
					"title"       => __("Price - Small", "wdpg"),
					"type"        => "number",
					"description" => __("This sets the price for small the delivery", "wdpg"),
					"default"     => 0,
				),
				"mediumPrice" => array(
					"title"       => __("Price - Medium", "wdpg"),
					"type"        => "number",
					"description" => __("This sets the price for medium the delivery", "wdpg"),
					"default"     => 0,
				),
				"largePrice" => array(
					"title"       => __("Price - Large", "wdpg"),
					"type"        => "number",
					"description" => __("This sets the price for large the delivery", "wdpg"),
					"default"     => 0,
				),
				"weightPrice" => array(
					"title"       => __("Price - Weight (x/kg)", "wdpg"),
					"type"        => "number",
					"description" => __("This sets the price for the delivery weight", "wdpg"),
					"default"     => 0,
				),
			);
		}
	
		/**
		 * Custom form
		 */
		public function payment_fields() {
			// Display the description if it's set
			if ($this->description) {
				// Display the description with <p> tags etc.
				echo wpautop(wp_kses_post($this->description));
			}
		 
			// Display the form
			$shippingPrice = $this->getShippingPrice();
			$weightAndPrice = $this->getWeightAndPrice();

			$totals = $weightAndPrice["price"] + $shippingPrice;

			echo "<p><strong>" . __("Price for delivery") . "</strong>: {$shippingPrice}{$this->currencySymbol}</p>";
			echo "<p><strong>" . __("Price for weight of delivery") . "</strong>: {$weightAndPrice["weight"]}kg * {$this->weightPrice}{$this->currencySymbol} = {$weightAndPrice["price"]}{$this->currencySymbol}</p>";
			echo "<p><strong>" . __("Total shipping") . "</strong>: {$totals}{$this->currencySymbol}</p>";
		}
	
		/**
		 * Fields validation
		 */
		public function validate_fields() {
			// 
		}
	
		/**
		 * We're processing the payments here
		 */
		public function process_payment($order_id) {
			global $woocommerce;
	
			// Get order details
			$order = wc_get_order($order_id );
	
			// Complete order
			$order->payment_complete();
			wc_reduce_stock_levels($order_id);
	
			// Display notes to customer
			$order->add_order_note(__("Thank you for your order!\nWe will process the order as fast as possible.", "wdpg"), true );
	
			// Empty cart
			$woocommerce->cart->empty_cart();
	
			// Redirect to the thank you page
			return array(
				'result' => 'success',
				'redirect' => $this->get_return_url($order)
			);
		}

		/**
		 * HELPERS
		 */

		/**
		 * Get the shipping price from the cart items
		 * 
		 * @return mixed int|float
		 */
		public function getShippingPrice() {
			$shippingClasses = [];
			foreach(WC()->cart->get_cart() as $item) {
				$slug = get_term($item["data"]->get_shipping_class_id())->slug;
				if (!in_array($slug, $shippingClasses)) {
					$shippingClasses[] = $slug;
				}
			}
			$shippingPrice = 0;
			if (in_array("large", $shippingClasses)) {
				$shippingPrice = $this->largePrice;
			} else if (in_array("medium", $shippingClasses)) {
				$shippingPrice = $this->mediumPrice;
			} else if (in_array("small", $shippingClasses)) {
				$shippingPrice = $this->smallPrice;
			}

			return $shippingPrice;
		}

		/**
		 * Get the cart weight shipping price from cart items
		 * 
		 * @return mixed int|float
		 */
		public function getWeightAndPrice() {
			$cartWeight = WC()->cart->get_cart_contents_weight();

			return  [
				"weight" => $cartWeight,
				"price" => $cartWeight * $this->weightPrice,
			];
		}
	}
}