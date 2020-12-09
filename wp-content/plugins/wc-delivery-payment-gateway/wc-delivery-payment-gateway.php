<?php
/**
 * Plugin Name: WooCommerce - Delivery Payment Gateway
 * Author: Victor Abrell
 * Version: 1.0
 */
defined("ABSPATH") || exit;

define("WDPG_PATH", plugin_dir_path(__FILE__));

require WDPG_PATH . "/src/Plugin.php";

use WDPG\Plugin;


function activate_wc_delivery_payment_gateway() {
	Plugin::install();
}
register_activation_hook(__FILE__, "activate_wc_delivery_payment_gateway");

function deactivate_wc_delivery_payment_gateway() {
	Plugin::uninstall();
}
register_deactivation_hook(__FILE__, "deactivate_wc_delivery_payment_gateway");