<?php

/**
 * Plugin Name: Contact Form
 * Author: David Kjellson
 * Version: 1.0
 * Description: Add contact information
 **/

function contactform()
{
  ob_start();
?>
  <form action="">
    <fieldset class="form-group">
      <div class="row">
        <legend class="col-form-label col-sm-2 pt-0">Ärende</legend>
        <div class="col-sm-10">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="errand" id="contact" value="contact">
            <label class="form-check-label" for="contact">
              Kontakt
            </label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="errand" id="reclaim" value="reclaim">
            <label class="form-check-label" for="reclaim">
              Reklamation
            </label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="errand" id="invoice" value="invoice">
            <label class="form-check-label" for="invoice">
              Faktura
            </label>
          </div>
        </div>
      </div>
    </fieldset>
    <div class="form-group row">
      <label for="name" class="col-sm-2 col-form-label">Namn</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="name" placeholder="Namn">
      </div>
    </div>
    <div class="form-group row">
      <label for="email" class="col-sm-2 col-form-label">E-post</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" id="email" placeholder="E-post">
      </div>
    </div>
    <div class="form-group row">
      <label for="message" class="col-sm-2 col-form-label">Meddelande</label>
      <div class="col-sm-10">
        <textarea class="form-control" id="message" placeholder="Meddelande" rows="3"></textarea>
      </div>
    </div>
  </form>
<?php
  $htmlkoden = ob_get_clean();
  return $htmlkoden;
}
add_shortcode('DK', 'contactform');
?>