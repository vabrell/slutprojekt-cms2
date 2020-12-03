<?php
namespace SPC2;

defined("ABSPATH") || exit;

class WooCommerceHooks {

	public function __construct() {
		add_action("woocommerce_before_single_product_summary", [$this, "beforeSingleProductSummary"], 0);
		add_action("woocommerce_after_single_product_summary", [$this, "afterSingleProductSummary"], 16);
	}
	
	public function beforeSingleProductSummary() {
		echo "<div>";
	}

	public function afterSingleProductSummary() {
		echo "<div class='clear'></div>";
		echo "</div>";
	}
}