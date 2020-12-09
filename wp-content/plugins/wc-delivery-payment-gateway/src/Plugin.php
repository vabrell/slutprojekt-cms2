<?php

class WDPG_Plugin {
	const SHIPPING_CLASSES = [
		[
			"name" => "Liten",
			"slug" => "small",
			"description" => "Mindre leveranser",
		],
		[
			"name" => "Mellan",
			"slug" => "medium",
			"description" => "Mellan stora leveranser",
		],
		[
			"name" => "Stora",
			"slug" => "large",
			"description" => "Stora leveranser",
		],
	];

	public static function install() {
		self::addShippingClasses();
	}

	public static function uninstall() {
		self::removeShippingClasses();
	}

	public static function addShippingClasses() {
		foreach(self::SHIPPING_CLASSES as $options) {
			wp_insert_term($options["name"], "product_shipping_class", $options);
		}
	}

	public static function removeShippingClasses() {
		foreach(self::SHIPPING_CLASSES as $options) {
			$termId = get_term_by("slug", $options["slug"], "product_shipping_class")->term_id;
			wp_delete_term($termId, "product_shipping_class");
		}
	}
}