<?php

namespace SPC2;

defined("ABSPATH") || exit;

use WC_Tax;

class Theme
{
	const THEME_NAME = "slutprojekt-cms2";
	const OPTION_PREFIX = "theme_is_activated_";

	public function __construct()
	{
		add_action("switch_theme", [$this, "deactivateTheme"]);
	}

	/**
	 * Run deactivation of theme
	 */
	public function deactivateTheme()
	{
		// Check if the theme is activated
		if (get_option(self::OPTION_PREFIX . self::THEME_NAME)) {
			// Find all tax rates
			$taxRates = WC_Tax::get_rates_for_tax_class('');
			// Remove the tax rates
			foreach ($taxRates as $rate) {
				WC_Tax::_delete_tax_rate($rate->tax_rate_id);
			}
			// Set the theme active in options
			update_option(self::OPTION_PREFIX . self::THEME_NAME, 0);
		}
	}

	/**
	 * Run activation of theme
	 */
	static function activateTheme()
	{
		// Check if the theme hasn't been activated
		if (!get_option(self::OPTION_PREFIX . self::THEME_NAME)) {
			// Run tax activation
			self::activateWooCommerceTax();
			// Run end user activation
			self::activateEndUserRegistration();
			// Set the theme active in options
			update_option(self::OPTION_PREFIX . self::THEME_NAME, 1);
		}
	}

	/**
	 * Activate WooCommerce Tax and add tax rate
	 */
	static function activateWooCommerceTax()
	{
		// Check if WooCommerce is activated
		if (class_exists("WooCommerce")) {
			// Activate tax calculation
			update_option("woocommerce_calc_taxes", "yes");
			update_option("woocommerce_prices_include_tax", "yes");
			update_option("woocommerce_tax_display_cart", "incl");
			update_option("woocommerce_tax_display_shop", "incl");

			// Insert Swedish tax rate
			WC_Tax::_insert_tax_rate([
				"tax_rate_country" => "SE",
				"tax_rate" => 25.0000,
				"tax_rate_name" => "Moms",
				"tax_rate_priority" => 1,
				"tax_rate_order" => 0,
			]);
		}
	}



	/**
	 * Activate WooCommerce end user registration and login
	 */
	static function activateEndUserRegistration()
	{
		update_option("woocommerce_enable_myaccount_registration", "yes");
		update_option("woocommerce_enable_signup_and_login_from_checkout", "yes");
		update_option("woocommerce_enable_checkout_login_reminder", "yes");
	}
}
