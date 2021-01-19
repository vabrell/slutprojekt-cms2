<?php

get_header();

$args = [
  'post_type' => 'butiker',
  'post_status' => 'publish',
  'posts_per_page' => 8,
  'orderby' => 'title',
  'order' => 'ASC'
];
$loop = new WP_Query($args); ?>

<h1>Våra butiker</h1>

<!-- <table class="table">
  <tbody> -->
<div class="container">
  <!-- <div class="list-group list-group-horizontal">
    <div class="d-flex align-content-around flex-wrap"> -->
  <div class="row my-1">
    <?php
    while ($loop->have_posts()) {
      $loop->the_post(); ?>
      <div class="text-center col-4">
        <div class=" mx-3"><a class="text-dark" href="<?php echo get_the_permalink(); ?>"><?php print the_title();  ?></a></div>
      </div>
    <?php

    } ?>
    <!-- </tbody>
</table> -->
    <!-- </div>
  </div> -->
  </div>
</div>

<?php get_footer(); ?>

<style>
  .mapdiv {
    margin-left: 20%;
    /* margin-bottom: -20%; */
  }

  .address {
    margin-left: 25%;
  }

  .map-container {
    overflow: hidden;
    padding-bottom: 56.25%;
    position: relative;
    height: 0;
  }

  .map-container iframe {
    left: 0;
    top: 0;
    height: 50%;
    width: 70%;
    position: absolute;
  }
</style>