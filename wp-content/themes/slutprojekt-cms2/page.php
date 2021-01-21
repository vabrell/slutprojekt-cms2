<?php
get_header();
?>



<?php
if (have_posts()) {
	the_post();
	$title = get_the_title();
	echo "<h1>{$title}</h1>";

	if( have_rows('content')): 
		?>
		<div class="bd-example">
		<div id="carouselExampleCaptions" class="carousel" data-ride="carousel">
			<ol class="carousel-indicators">
				<?php while (have_rows('content')): the_row(); ?>
					<?php $counter = get_row_index(); ?>
					<li data-target="" data-slide-to="<?php echo $counter-1;?>" class="<?php if(get_row_index() ==1 ) echo 'active';?>"></li>
				<?php endwhile; ?>
			</ol>

			<div class="carousel-inner">
				<?php while(have_rows('content')): the_row();?>
				<div class="carousel-item text-center <?php if (get_row_index() == 1) echo 'active';?>">
					<?php 
						$getImg = get_sub_field('image')[0];
						$image = get_the_post_thumbnail($getImg->ID, [500, 500]);

					?>
							
					<?php echo $image; ?>
					<div class="carousel-caption">
					<h5 class="bg-primary-opacity text-white font-weight-bold p-3"><?php echo $getImg->post_title; ?></h5>
					
					</div>
				</div>
				<?php endwhile; ?>
			</div>
			<a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
			<span class="bg-primary py-1 px-2 rounded-circle d-block">
						<span class="carousel-control-prev-icon mt-1" aria-hidden="true"></span>
					</span>
			<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
			<span class="bg-primary py-1 px-2 rounded-circle d-block">
					<span class="carousel-control-next-icon mt-1" aria-hidden="true"></span>
					</span>
			<span class="sr-only">Next</span>
			</a>
		</div>
		</div>
		<?php endif;
	the_content();
} else {
	the_content();
}
 ?>
<?php
	// Best sellers

    $args = array(
    'post_type' => 'product',
    'posts_per_page' => 6, //Antal produkter som visas. 
        'meta_key' => 'total_sales', //Antalet sålda av en specifik produkt. 
        'orderby' => 'meta_value_num', 
    );
    ?>
<div class="container">
    <h1> Bästsäljare </h1>
    <div class="row">
			
			<?php $loop = new WP_Query( $args );
			while ( $loop->have_posts() ) { $loop->the_post(); global $product; ?>
			<div class="col-3">
				<div class="card mb-3" style="width: 16rem; height:30rem">
					<div class="card-body">
						<a id="id-
							<?php the_id();?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

							<?php 
							if (has_post_thumbnail( $loop->post->ID )) { echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); 
							}?>
							<h3 class="card-title"><?php the_title(); ?></h3>
							<?php echo $product->get_price_html(); ?>
						</a>
						<div class="d-flex align-items-end">
							<?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>
						</div>
					</div>
				</div>
		</div>
		<?php } ?>
		<?php wp_reset_query(); ?>
    </div>
</div>


<?php
	// REA products

    $args = array(
    'post_type' => 'product',
    'posts_per_page' => 6, //Antal produkter som visas. 
        'meta_key' => 'total_sales', //Antalet sålda av en specifik produkt. 
        'orderby' => 'meta_value_num', 
    
    );
    ?>

<div class="container">
    <h1>REA produkter</h1>
    <div class="row">
        <?php $loop = new WP_Query( $args );
					while ( $loop->have_posts() ) { $loop->the_post(); global $product; 
						if($product->is_on_sale()) { ?>
							<div class="col-3">
								<div class="card mb-3" style="width: 16rem; height:30rem">
									<div class="card-body">
									<a id="id-
									<?php the_id();?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

									<?php 
										if (has_post_thumbnail( $loop->post->ID )) { 
											echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); 
										}
										?>
										<h3 class="card-title"><?php the_title(); ?></h3>
										<?php echo $product->get_price_html(); ?>
								</a>
								<div class="d-flex align-items-end">
									<?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>
								</div>
								</div>
							</div>
						</div>
					<?php	}	?>
				<?php } ?>
        <?php wp_reset_query(); ?>
    </div>
</div>

<?php 
 // featured products
?>
<div class="container">
    <h1 class="">Kommande produkter</h1>
    <div class="row">
			<?php
				 if(have_rows('featured_products')) {
					$get_featured_products = get_field('featured_products');
						foreach($get_featured_products as $value) {
							echo "<div class=\"col-3\">";
								echo "<div class=\"card mb-3\" style=\"width: 16rem; height:30rem\">";
									echo "<div class=\"card-body\">";
										echo get_the_post_thumbnail($value->ID, [200, 200]);
										echo "<h3 class=\"card-title\">$value->post_title</h3>";
									echo "</div>"; 
								echo "</div>"; 
							echo "</div>"; 
						}
				 }
			?>
		 </div>
</div>



<?php
get_footer();

// <div class="card" style="width: 18rem;">
//   <img class="card-img-top" src="..." alt="Card image cap">
//   <div class="card-body">
//     <h5 class="card-title">Card title</h5>
//     <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
//     <a href="#" class="btn btn-primary">Go somewhere</a>
//   </div>
// </div>