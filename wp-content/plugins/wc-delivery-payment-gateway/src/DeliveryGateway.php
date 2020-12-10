<?php
// Verify that WooCommerce is installed

if (class_exists("WooCommerce")) {
	class WDPG_DeliveryGateway extends WC_Payment_Gateway {

		const CACHE_PREFIX = "DISTANCE_CACHE_";
		private $apiUrl = "http://open.mapquestapi.com/directions/v2/route?key=%s&from=%s&to=%s";
		private $apiKey;

		public function __construct() {
			$this->id = "wdpg_delivery"; // payment gateway plugin ID
			$this->icon = ""; // URL of the icon
			$this->has_fields = true; // Custom form
			$this->method_title = __("Delivery by carrier", "wdpg");
			$this->method_description = __("Use the Delivery by carrier payment method", "wdpg"); // will be displayed on the options page

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
			$this->apiKey = $this->get_option("apiKey");
			$this->distancePrice = $this->get_option("distancePrice");
	
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
				"apiKey" => array(
					"title"       => "MapQuest API-" . __("key"),
					"type"        => "text",
					"description" => __("Without this key the distance calculation will not work", "wdpg"),
					"default"     => 0,
				),
				"title" => array(
					"title"       => __("Title", "wdpg"),
					"type"        => "text",
					"description" => __("This controls the title which the user sees during checkout", "wdpg"),
					"default"     => __("Delivery by carrier", "wdpg"),
					"desc_tip"    => true,
				),
				"description" => array(
					"title"       => __("Description", "wdpg"),
					"type"        => "textarea",
					"description" => __("This controls the description which the user sees during checkout", "wdpg"),
					"default"     => __("Pay when you recieve the order", "wdpg"),
				),
				"warehouseLocation" => array(
					"title"       => __("Warehouse address", "wdpg"),
					"type"        => "text",
					"description" => __("This sets the from location when the delivery distance is calculated", "wdpg"),
				),
				"price" => array(
					"title"       => __("Price", "wdpg"),
					"type"        => "number",
					"description" => __("This sets the set price for the delivery", "wdpg"),
					"default"     => 0,
				),
				"smallPrice" => array(
					"title"       => __("Price", "wdpg") ." - " . __("Small", "wdpg"),
					"type"        => "number",
					"description" => __("This sets the price for small delivery", "wdpg"),
					"default"     => 0,
				),
				"mediumPrice" => array(
					"title"       => __("Price", "wdpg") ." - " . __("Medium", "wdpg"),
					"type"        => "number",
					"description" => __("This sets the price for medium delivery", "wdpg"),
					"default"     => 0,
				),
				"largePrice" => array(
					"title"       => __("Price", "wdpg") ." - " . __("Large", "wdpg"),
					"type"        => "number",
					"description" => __("This sets the price for large  delivery", "wdpg"),
					"default"     => 0,
				),
				"weightPrice" => array(
					"title"       => __("Price", "wdpg") ." - " . __("Weight", "wdpg") . " (x/kg)",
					"type"        => "number",
					"description" => __("This sets the price for the delivery weight", "wdpg"),
					"default"     => 0,
				),
				"distancePrice" => array(
					"title"       => __("Price", "wdpg") ." - " . __("Distance", "wdpg") . " (x/km)",
					"type"        => "number",
					"description" => __("This sets the price for the delivery distance", "wdpg"),
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
			$weightPrice = $this->getWeightPrice();
			if ($distancePrice = $this->getDistancePrice()) {
				$totals = $weightPrice + $shippingPrice + $distancePrice;

				echo "<p><strong>" . __("Price for delivery by carrier", "wdpg") . "</strong>: {$shippingPrice}{$this->currencySymbol}</p>";
				echo "<p><strong>" . __("Price for distance", "wdpg") . "</strong>: {$distancePrice}{$this->currencySymbol}</p>";
				echo "<p><strong>" . __("Price for weight of delivery", "wdpg") . "</strong>: {$weightPrice}{$this->currencySymbol}</p>";
				echo "<p><strong>" . __("Total shipping", "wdpg") . "</strong>: {$totals}{$this->currencySymbol}</p>";
			} else {
				echo "<div class='text-danger'>". __("We could not calculate the shipping cost as you address and/or city is missing or invalid", "wdpg") . "</div>";
			}
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
			// Loop through the cart items and get the largest shipping class
			foreach(WC()->cart->get_cart() as $item) {
				$slug = get_term($item["data"]->get_shipping_class_id())->slug;
				if (!in_array($slug, $shippingClasses)) {
					$shippingClasses[] = $slug;
				}
			}

			// Set the shipping price depending on what was the largest shipping class
			$shippingPrice = 0;
			if (in_array("large", $shippingClasses)) {
				$shippingPrice = $this->largePrice;
			} else if (in_array("medium", $shippingClasses)) {
				$shippingPrice = $this->mediumPrice;
			} else if (in_array("small", $shippingClasses)) {
				$shippingPrice = $this->smallPrice;
			}

			// Return the shipping price
			return $shippingPrice;
		}

		/**
		 * Get the cart weight shipping price from cart items
		 * 
		 * @return mixed int|float
		 */
		public function getWeightPrice() {
			// Get the cart items combined weight
			$cartWeight = WC()->cart->get_cart_contents_weight();

			// Return the the calculated price
			return  $cartWeight * $this->weightPrice;
		}

		/**
		 * Get the distance cost
		 * 
		 * @return mixed int|float
		 */
		public function getDistancePrice() {
			// Get the customer address
			$customerAddress = WC()->cart->get_customer()->get_shipping_address() ?? WC()->cart->get_customer()->get_billing_address();
			$customerCity = WC()->cart->get_customer()->get_shipping_city() ?? WC()->cart->get_customer()->get_billing_city();
			// Make sure that the address and city is filled in
			if (empty($customerAddress) || empty($customerCity)) {
				return false;
			}

			$customerFullAddress = $customerAddress . "," . $customerCity;
			$cacheHash = password_hash($customerFullAddress,  PASSWORD_DEFAULT);

			// Check if we can get cached data
			if (!$distaceCost = get_transient(self::CACHE_PREFIX . $cacheHash)){
				// Prepare API Url
				
				$url = sprintf($this->apiUrl,
					$this->apiKey, // The authentication key for MapQuest
					json_encode(["street" => $this->warehouseLocation]), // The _from_ location
					json_encode(["street" => $customerFullAddress]) // The _to_ location
				);
				// Fetch new distance data
				$response = wp_remote_get($url);
				// Format the JSON response
				$body = json_decode(wp_remote_retrieve_body($response));
				// Make sure that the response is not null
				if ($body->info->statuscode !== 0) {
					return false;
				}
				$distance = $body->route->distance;
				// Calculate the price of the distance
				$distaceCost = $distance * $this->distancePrice;
				// Cache the data for 15 minutes
				set_transient(self::CACHE_PREFIX . $cacheHash, $distaceCost, MINUTE_IN_SECONDS * 15);
			}

			// Return the price
			return $distaceCost;
		}
	}
}