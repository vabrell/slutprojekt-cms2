<?php

// Verify that WooCommerce is installed
if (class_exists("WooCommerce")) {
	class InvoiceGateway extends WC_Payment_Gateway {

		public function __construct() {
			$this->id = "ipg_invoice"; // payment gateway plugin ID
			$this->icon = ""; // URL of the icon
			$this->has_fields = true; // Custom form
			$this->method_title = __("Invoice", "ipg");
			$this->method_description = __("Use the Invoice payment method", "ipg"); // will be displayed on the options page
		
			// Support
			$this->supports = array(
				"products"
			);
	
			// Load the options
			$this->init_settings();
			$this->title = $this->get_option("title");
			$this->description = $this->get_option("description");
			$this->enabled = $this->get_option("enabled");
	
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
					"title"       => __("Enable/Disable", "ipg"),
					"label"       => __("Enable Invoice Gateway", "ipg"),
					"type"        => "checkbox",
					"description" => "",
					"default"     => "no"
				),
				"title" => array(
					"title"       => __("Title", "ipg"),
					"type"        => "text",
					"description" => __("This controls the title which the user sees during checkout", "ipg"),
					"default"     => "Invoice",
					"desc_tip"    => true,
				),
				"description" => array(
					"title"       => __("Description", "ipg"),
					"type"        => "textarea",
					"description" => __("This controls the description which the user sees during checkout", "ipg"),
					"default"     => __("Pay with invoice", "ipg"),
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
			?>
			<fieldset id="ipg-<?php echo esc_attr($this->id); ?>-ssn-form" class="ipg-ssn" style="background:transparent;">
				<div class="form-row form-row-wide">
					<label><?php _e("Social Security Number", "ipg"); ?> <span class="required">*</span></label>
					<input id="ipg_pnr" name="social_security_number" type="text" autocomplete="off">
				</div>
			</fieldset>
			<?php
		}
	
		/**
		 * Fields validation
		 */
		public function validate_fields() {
			// Get SSN from POST
			$ssn = $_POST["social_security_number"];
	
			if (empty($ssn)) {
				wc_add_notice(__("Social security number must be filled in", "ipg"), "error");
				return false;
			}
	
			$luhn = new Luhn;
	
			if (!$luhn->checkSSN($ssn)) {
				wc_add_notice(__("Social security number is not valid", "ipg"), "error");
				return false;
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
			$order->add_order_note(__("Thank you for your order!\nWe will process the order as fast as possible.", "ipg"), true );
	
			// Empty cart
			$woocommerce->cart->empty_cart();
	
			// Redirect to the thank you page
			return array(
				'result' => 'success',
				'redirect' => $this->get_return_url($order)
			);
		}
	}
}