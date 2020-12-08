<?php

/**
 * Plugin Name: Map
 * Author: David Kjellson
 * Version: 1.0
 * Description: Display map
 **/

require 'acf-template.php';

class Map
{
  function map()
  {
    ob_start();
    if (have_rows('karta', 'options')) {
      while (have_rows('karta', 'options')) {
        the_row(); ?>
        <div id="map-container-google-1" class="z-depth-1-half map-container" style="height: 500px">
          <iframe src="https://www.google.com/maps/embed/v1/place?key=<?php the_sub_field('api-nyckel'); ?>&q=<?php the_sub_field('gata'); ?>+<?php the_sub_field('gatunummer'); ?>,+<?php the_sub_field('postnummer'); ?>+<?php the_sub_field('stad'); ?>" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
<?php }
    }
    $mapcode = ob_get_clean();
    return $mapcode;
  }

  function options()
  {
    acf_add_options_page([
      'page_title' => 'Karta',
      'menu_title' => 'Karta',
      'menu_slug' => 'karta'
    ]);
  }

  public function __construct()
  {
    add_action('init', [$this, 'options']);
    add_shortcode('map', [$this, 'map']);
  }
}

$map = new Map();
?>

<style>
  .map-container {
    overflow: hidden;
    padding-bottom: 56.25%;
    position: relative;
    height: 0;
  }

  .map-container iframe {
    left: 0;
    top: 0;
    height: 100%;
    width: 100%;
    position: absolute;
  }
</style>