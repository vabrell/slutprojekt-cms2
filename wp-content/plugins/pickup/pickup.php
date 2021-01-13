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
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
      <label class="form-check-label" for="inlineCheckbox1">Hämta i butik</label>
    </div>
    <div class="form-group col-md-4">
      <select id="inputState" class="form-control">
        <option value="" disabled selected>Välj butik</option>
        <option>...</option>
      </select>
    </div>
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
