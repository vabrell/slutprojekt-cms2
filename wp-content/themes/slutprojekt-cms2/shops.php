<?php /* Template Name: Butiker */

get_header(); ?>


<div id="map-container-google-1" class="z-depth-1-half map-container" style="height: 500px">
  <!-- iFrame-tagg här -->
</div>

<!-- z-depth-1-half -->

<?php get_footer(); ?>

<style>
  .map-container {
    overflow: hidden;
    padding-bottom: 56.25%;
    position: relative;
    height: 100px;
  }

  .map-container iframe {
    left: 0;
    top: 0;
    height: 50%;
    width: 40%;
    position: absolute;
  }
</style>