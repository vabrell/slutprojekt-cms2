<?php
get_header();
?>

<h2>Blogg</h2>

<?php
if (have_posts()) {
	while (have_posts()) {
		the_post();
?>
		<a class="search-item" href="<?php echo get_the_permalink(); ?>">
			<div class="row align-items-center my-4 p-2">
				<?php
				if (has_post_thumbnail()) {
				?>
					<div class="col-4 col-md-3 col-lg-2">
						<?php the_post_thumbnail("shop_thumbnail"); ?>
					</div>
				<?php
				} 
				?>
				<div class="col-5 col-md-6 col-lg-8">
					<?php the_title(); ?>
				</div>
			</div>
		</a>
		<?php
	}
} else {
	echo __("No blog posts could be found", "spc2");
}

get_footer();