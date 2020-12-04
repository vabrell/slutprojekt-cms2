<?php

/**
 * Plugin Name: Contact Page
 * Author: David Kjellson
 * Version: 1.0
 * Description: Add contact information
 **/

function contactform()
{
  ob_start();
?>
  <form action="">
    <input type="radio" name="contact" id="kontakt" value="kontakt">
    <label for="kontakt">Kontakt</label>
    <input type="radio" name="contact" id="reklamation" value="reklamation">
    <label for="reklamation">Reklamation</label>
    <input type="radio" name="contact" id="faktura" value="faktura">
    <label for="faktura">Faktura</label>
  </form>
<?php
  $htmlkoden = ob_get_clean();
  return $htmlkoden;
}
add_shortcode('DK', 'contactform');
?>