<?php

get_header(); ?>

<h1>Våra butiker</h1>

<?php
while (have_posts()) {
  the_post();

  if (have_rows('karta')) {
    while (have_rows('karta')) {
      the_row(); ?>
      <div class="mapdiv">
        <a href="<?php the_permalink(); ?>">
          <p class="address"><?php the_sub_field('gata') ?> <?php the_sub_field('gatunummer') ?>, <?php the_sub_field('postnummer') ?>, <?php the_sub_field('stad'); ?></p>
        </a>
        <div id="map-container-google-1" class="z-depth-1-half map-container">
          <iframe src="https://www.google.com/maps/embed/v1/place?key=<?php echo get_field('api-nyckel'); ?>&q=<?php the_sub_field('gata'); ?>+<?php the_sub_field('gatunummer'); ?>,+<?php the_sub_field('postnummer'); ?>+<?php the_sub_field('stad'); ?>" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
      </div>
<?php
    }
  }
}
get_footer(); ?>

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