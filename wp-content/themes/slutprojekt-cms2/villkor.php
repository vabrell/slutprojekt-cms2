<?php

/* Template Name: Villkor och regler */

get_header();

$title = get_the_title();
echo "<h1>{$title}</h1>";
the_content();

get_footer();
