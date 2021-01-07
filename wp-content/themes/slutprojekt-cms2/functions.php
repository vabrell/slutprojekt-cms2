<?php

require get_theme_file_path("/Classes/Theme.php");
require get_theme_file_path("/Classes/class-wp-bootstrap-navwalker.php");
require get_theme_file_path("/Classes/Menus.php");
require get_theme_file_path("/Classes/WooCommerceHooks.php");

// Run theme activation
SPC2\Theme::activateTheme();
// Add deactivation hook
$Theme = new SPC2\Theme;

// Add theme menues
$menus = new SPC2\Menus;

// Run the WooCommerce Hooks
$wooComHooks = new SPC2\WooCommerceHooks;

function butiker()
{
  $labels = [
    'name' => 'Butiker',
    'singular_name' => 'Butik',
    'menu_name' => 'Butiker',
    'add_new_item' => 'Lägg till butik',
    'add_new' => 'Lägg till',
    'edit_item' => 'Redigera',
    'update_item' => 'Uppdatera'
  ];
  $args = [
    'labels' => 'butiker',
    'labels' => $labels,
    'supports' => [
      'custom-fields'
    ],
    'public' => true,
    'has_archive' => true,
  ];
  register_post_type('butiker', $args);
}
add_action('init', 'butiker');

/**
 * Theme support
 */
add_theme_support("menus");
