<?php
get_header();

while (have_posts()) {
  the_post();

  if (have_rows('karta')) {
    while (have_rows('karta')) {
      the_row(); ?>
      <div>
        <h2><?php the_sub_field('gata') ?> <?php the_sub_field('gatunummer') ?>, <?php the_sub_field('postnummer') ?>, <?php the_sub_field('stad'); ?></h2>
        <div id="map-container-google-1" class="z-depth-1-half map-container" style="height: 500px">
          <iframe src="https://www.google.com/maps/embed/v1/place?key=<?php echo get_field('api-nyckel'); ?>&q=<?php the_sub_field('gata'); ?>+<?php the_sub_field('gatunummer'); ?>,+<?php the_sub_field('postnummer'); ?>+<?php the_sub_field('stad'); ?>" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
      </div>
<?php
    }
  }
}

get_footer();
