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

<div class="container">
  <div class="row my-1">
    <?php
    while ($loop->have_posts()) {
      $loop->the_post(); ?>
      <a href="<?php the_permalink(); ?>" class="text-center col-4 border">
        <div class="mx-3"><?php print the_title();  ?></div>
      </a>
    <?php } ?>
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