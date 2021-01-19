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
        $this->method_title = 'Hämta upp i butik';
        $this->method_description = 'Använd metoden för att hämta upp i butik';

        $this->supports = [
          'products'
        ];

        $this->init_form_fields();

        $this->init_settings();
        $this->title = $this->get_option('title');
        $this->description = $this->get_option('description');
        $this->enabled = $this->get_option('enabled');
        $this->deliveryFee = $this->get_option('deliveryFee');
        $this->freeDelivery = $this->get_option('freeDelivery');


        add_action('woocommerce_update_options_payment_gateways_' . $this->id, [$this, 'process_admin_options']);
      }

      public function init_form_fields()
      {
        $this->form_fields = [
          'enabled' => [
            'title' => 'Av/På',
            'label' => 'Aktivera Pickup Gateway',
            'type' => 'checkbox',
            'description' => '',
            'default' => 'no'
          ],
          'title' => [
            'title' => 'Titel',
            'type' => 'text',
            'description' => 'Detta kontrollerar titeln användaren ser i kassan',
            'default' => 'Pickup',
            "desc_tip"    => true
          ],
          'description' => [
            'title' => 'Beskrivning',
            'type' => 'textarea',
            'description' => 'Detta kontrollerar beskrivningen användaren ser i kassan',
            'default' => 'Betala när du hämtar i butik'
          ],
          'deliveryFee' => [
            'title' => 'Leveranskostnad',
            'type' => 'number',
            'description' => 'Detta kontrollerar leveranskostnaden',
            'default' => 0
          ],
          'freeDelivery' => [
            'title' => 'Gratis leverans',
            'type' => 'number',
            'description' => 'Detta kontrollerar priset för gratis leverans',
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
        <fieldset id="ipg-<?php echo esc_attr($this->id); ?>-ssn-form" class="ipg-ssn" style="background:transparent;">
          <div class="form-group col-md-4">
            <select id="inputState" class="form-control">
              <option value="" disabled selected>Välj butik</option>
              <?php while ($loop->have_posts()) {
                $loop->the_post(); ?>
                <option><?php print the_title();  ?></option>
              <?php } ?>
            </select>
          </div>
        </fieldset>
<?php
      }
      public function process_payment($order_id)
      {
        global $woocommerce;
        $order = wc_get_order($order_id);
        wc_reduce_stock_levels($order_id);
        $order->add_order_note('Tack för din beställning!', true);
        $woocommerce->cart->empty_cart();
        return [
          'result' => 'success',
          'redirect' => $this->get_return_url($order)
        ];
      }
      public function getShippingPrice()
      {
        $totals = WC()->cart->get_cart_contents_total();
        $free = $this->get_option('freeDelivery');
        if ($totals > $free) {
          $this->get_option('deliveryFee') === 0;
        }
      }
    }
  }
}
