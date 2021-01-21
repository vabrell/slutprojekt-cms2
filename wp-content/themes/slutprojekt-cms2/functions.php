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
			'custom-fields', 'title'
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

add_action('acf/init', 'my_acf_init_blocks');
function my_acf_init_blocks() {

    // Kollar ifall functionen finns.
    if( function_exists('acf_register_block_type') ) {

        // Gör ett block.
        acf_register_block_type(array(
            'name'              => 'sort-by-purchased',
            'title'             => 'sort by purchased',
            'description'       => 'A function that sort products based on the amount purchased.',
            'category'          => 'formatting',
            'render_template' => 'template-parts/blocks/sort-by-purchased.php',
            )
            
          );
    }
}

/**
 * Bildspel
 */
if (function_exists('acf_add_local_field_group')) :

	acf_add_local_field_group(array(
		'key' => 'group_5fd9f2ab46a54',
		'title' => 'bildspel',
		'fields' => array(
			array(
				'key' => 'field_5fd9f2db0e41e',
				'label' => 'Content',
				'name' => 'content',
				'type' => 'repeater',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'collapsed' => '',
				'min' => 0,
				'max' => 0,
				'layout' => 'table',
				'button_label' => 'Add slide',
				'sub_fields' => array(
					array(
						'key' => 'field_5fda01a429f1b',
						'label' => 'Image',
						'name' => 'image',
						'type' => 'relationship',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'post_type' => array(
							0 => 'product',
						),
						'taxonomy' => '',
						'filters' => array(
							0 => 'search',
							1 => 'post_type',
							2 => 'taxonomy',
						),
						'elements' => '',
						'min' => '',
						'max' => '',
						'return_format' => 'object',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => array(
			0 => 'the_content',
		),
		'active' => true,
		'description' => '',
	));

endif;
