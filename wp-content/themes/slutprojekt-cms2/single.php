<?php
get_header();

if (have_posts()) {
	the_post();
	$title = get_the_title();
	echo "<h1>{$title}</h1>";
	if (has_post_thumbnail()) {
		echo "<div class='my-3'>";
			the_post_thumbnail();
		echo "</div>";
	}
	the_content();

	if (!is_product()) {
		echo "<div class='my-3 pr-3 text-muted'>";
			echo __("by", "spc2") . " " . get_the_author_meta("display_name");
		echo "</div>";
	}
}

get_footer();