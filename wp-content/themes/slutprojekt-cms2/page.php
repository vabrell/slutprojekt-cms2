<?php
get_header();
?>

<div class="bd-example">
  <div id="carouselExampleCaptions" class="carousel" data-ride="carousel">
    <ol class="carousel-indicators">
			<?php if( have_rows('content')): 
				while (have_rows('content')): the_row(); ?>
					<?php $counter = get_row_index(); ?>
					<li data-target="" data-slide-to="<?php echo $counter-1;?>" class="<?php if(get_row_index() ==1 ) echo 'active';?>"></li>
			<?php 
				endwhile;
			endif; ?>
			
    </ol>

    <div class="carousel-inner">
		<?php if( have_rows('content')): 
		 while(have_rows('content')): the_row();?>
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
		<?php endwhile; endif;?>
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


<?php
if (have_posts()) {
	the_post();
	$title = get_the_title();
	echo "<h1>{$title}</h1>";
	the_content();
} else {
	the_content();
}
?>

<?php
get_footer();