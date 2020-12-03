<?php
get_header();
?>

<?php
if (have_posts()) {
	the_post();
	the_content();
} else {
	the_content();
}
?>

<?php
get_footer();