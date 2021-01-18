<?php

/**
 * Plugin Name: WooCommerce - Pick up at store
 * Author: David Kjellson
 * Version: 1.0
 * Description: Option to pick up product at store
 **/

add_filter('woocommerce_payment_gateways', 'pickup_add_gateway_class');
function pickup_add_gateway_class($gateways)
{
  $gateways[] = 'PickupGateway';
  return $gateways;
}

add_action('plugins_loaded', 'pickup_init_gateway_class');
function pickup_init_gateway_class()
{

  if (class_exists('WooCommerce')) {
    class PickupGateway extends WC_Payment_Gateway
    {
      public function __construct()
      {
        $this->id = 'pickup';
        $this->icon = '';
        $this->has_fields = true;
        $this->method_title = 'Pickup at store';
        $this->method_description = 'Use the Pickup at store method';

        $this->supports = [
          'products'
        ];

        $this->init_form_fields();

        $this->init_settings();
        $this->title = $this->get_option('title');
        $this->description = $this->get_option('description');
        $this->enabled = $this->get_option('enabled');
        $this->warehouseLocation = $this->get_option('warehouseLocation');


        add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
      }

      public function init_form_fields()
      {
        $this->form_fields = [
          'enabled' => [
            'title' => 'Enable/Disable',
            'label' => 'Enable Pickup Gateway',
            'type' => 'checkbox',
            'description' => '',
            'default' => 'no'
          ],
          'title' => [
            'title' => 'Title',
            'type' => 'text',
            'description' => 'This controls the title which the user sees during checkout',
            'default' => 'Pickup',
            "desc_tip"    => true
          ],
          'description' => [
            'title' => 'Description',
            'type' => 'textarea',
            'description' => 'This controls the description which the user sees during checkout',
            'default' => 'Pay when you pick up at store'
          ],
          'deliveryFee' => [
            'title' => 'Price',
            'type' => 'number',
            'description' => 'This sets the set price for the delivery',
            'default' => 0
          ],
          'freeDelivery' => [
            'title' => 'Free delivery',
            'type' => 'number',
            'description' => 'This controls the price for free delivery',
            'default' => 0
          ]
        ];
      }
      public function payment_fields()
      {
        $args = [
          'post_type' => 'butiker',
          'post_status' => 'publish',
          'posts_per_page' => 8,
          'orderby' => 'title',
          'order' => 'ASC'
        ];
        $loop = new WP_Query($args);
?>
        <div class="form-group col-md-4">
          <select id="inputState" class="form-control">
            <option value="" disabled selected>Välj butik</option>
            <?php while ($loop->have_posts()) {
              $loop->the_post(); ?>
              <option><?php print the_title();  ?></option>
            <?php } ?>
          </select>
        </div>
<?php
      }
    }
  }
}
