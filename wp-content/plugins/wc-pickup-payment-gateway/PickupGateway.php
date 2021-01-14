<?php

/**
 * Plugin Name: WooCommerce - Pick up at store
 * Author: David Kjellson
 * Version: 1.0
 * Description: Option to pick up product at store
 **/

if (class_exists('WooCommerce')) {
  class PickupGatway extends WC_Payment_Gateway
  {
    public function __construct()
    {
      $this->id = 'wcpp_pickup';
      $this->icon = '';
      $this->has_fields = true;
      $this->method_title = __('Pickup at store', 'wcpp');
      $this->method_description = __('Use the Pickup at store method', 'wcpp');

      $this->supports = array(
        'products'
      );

      $this->init_settings();
      $this->title = $this->get_option('title');
      $this->description = $this->get_option('description');
      $this->enabled = $this->get_option('enabled');
      $this->warehouseLocation = $this->get_option('warehouseLocation');

      $this->init_form_fields();

      add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
    }

    function init_form_fields()
    {
      $this->form_fields = [
        'enabled' => [
          'title' => __('Enable/Disable', 'wcpp'),
          'label' => __('Enable Pickup Gateway', 'wcpp'),
          'type' => 'checkbox',
          'description' => '',
          'default' => 'no'
        ],
        'title' => [
          'title' => __('Title', 'wcpp'),
          'type' => 'text',
          'description' => __('This controls the title which the user sees during checkout', 'wcpp'),
          'default' => 'Pickup',
          "desc_tip"    => true
        ],
        'description' => [
          'title' => __('Description', 'wcpp'),
          'type' => 'textarea',
          'description' => __('This controls the description which the user sees during checkout', 'wcpp'),
          'default' => 'Pay when you pick up at store'
        ]
      ];
    }
  }
}
