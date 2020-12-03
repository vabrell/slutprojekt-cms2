<?php
namespace SPC2;

defined("ABSPATH") || exit;

class Menus {

	public function __construct() {
		add_action("init", [$this, "addThemeMenus"]);
	}

	public function addThemeMenus() {
		register_nav_menus([
			// Primary menu
			"primary" => __("Primary Menu", "spc2"),
		]);
	}
}