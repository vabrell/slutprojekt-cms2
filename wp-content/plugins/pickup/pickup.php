<?php

/**
 * Plugin Name: Pickup at store
 * Author: David Kjellson
 * Version: 1.0
 * Description: Option to pick up product at store
 **/

class Pickup
{
  function pickupalt()
  {
    ob_start(); ?>
    <h1>God dag</h1>
<?php
    $pickupcode = ob_get_clean();
    echo $pickupcode;
  }

  public function __construct()
  {
    add_action('woocommerce_checkout_before_customer_details', [$this, 'pickupalt']);
  }
}

$pickup = new Pickup();
