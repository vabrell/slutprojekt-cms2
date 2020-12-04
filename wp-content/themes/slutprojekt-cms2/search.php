<?php
get_header();

?>
<h3 class="mb-4"><?php _e("Searching for", "spc2"); ?>: <strong><?php echo get_search_query(); ?></strong></h3>
<?php
if (have_posts()) {
	while(have_posts()) {
		the_post();
		$product = $product = wc_get_product( get_the_ID() );

		?>
		<a class="search-item" href="<?php echo get_the_permalink(); ?>">
			<div class="row align-items-center my-4 p-2">
				<?php if (get_post_type() === "product") { ?>
					<?php if (has_post_thumbnail()) { ?>
						<div class="col-2">
							<?php the_post_thumbnail("shop_thumbnail"); ?>
						</div>
					<?php } ?>
					<div class="col-8">
						<?php the_title(); ?>
					</div>
					<div class="col-2 price">
						<?php echo $product->price; ?>
						<?php echo get_woocommerce_currency_symbol(); ?>
					</div>
				<?php
				} else { ?>
					<?php
					if (has_post_thumbnail()) {
					?>
						<div class="col-2">
							<?php the_post_thumbnail("shop_thumbnail"); ?>
						</div>
					<?php
					} 
					?>
					<div class="col-8">
						<?php the_title(); ?>
					</div>
				<?php
				}
				?>
			</div>
		</a>
		<?php
	}
}

get_footer();