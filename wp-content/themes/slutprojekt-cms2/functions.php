<?php

require get_theme_file_path("/Classes/Theme.php");
require get_theme_file_path("/Classes/Menus.php");

// Run theme activation
SPC2\Theme::activateTheme();
// Add deactivation hook
$Theme = new SPC2\Theme;

// Add theme menues
$menus = new SPC2\Menus;

/**
 * Theme support
 */
add_theme_support("menus");