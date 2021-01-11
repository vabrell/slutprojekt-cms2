<?php

get_header(); ?>

<h1>Våra butiker</h1>

<table class="table">
  <tbody>
    <?php
    while (have_posts()) {
      the_post();
      if (have_rows('karta')) {
        while (have_rows('karta')) {
          the_row(); ?>
          <tr>
            <td><?php the_sub_field('gata') ?> <?php the_sub_field('gatunummer') ?></td>
            <td><?php the_sub_field('postnummer') ?></td>
            <td><?php the_sub_field('stad'); ?></td>
          </tr>
    <?php
        }
      }
    } ?>
  </tbody>
</table>

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