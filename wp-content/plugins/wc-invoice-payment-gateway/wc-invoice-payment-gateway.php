<?php
/**
 * Plugin Name: WooCommerce - Invoice payment
 * Author: Victor Abrell
 * Version: 1.0
 * Description: Add the option of invoice payment
 * Text Domain: ipg
 * Domain Path: /languages
 */

defined("ABSPATH") || exit;

define("PLUGIN_PATH", plugin_dir_path(__FILE__));

add_action( 'plugins_loaded', 'ipg_init_gateway_class' );
function ipg_init_gateway_class() {
	load_plugin_textdomain("ipg", false, basename( dirname( __FILE__ ) ) . "/languages/");
	if ( is_readable( PLUGIN_PATH . '/vendor/autoload.php' ) ) {
		require PLUGIN_PATH . '/vendor/autoload.php';
	}
}


add_filter( 'woocommerce_payment_gateways', 'ipg_add_invoice_gateway' );
function ipg_add_invoice_gateway( $gateways ) {
	$gateways[] = 'InvoiceGateway';
	return $gateways;
}
