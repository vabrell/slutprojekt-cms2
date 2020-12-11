<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo get_bloginfo("name"); ?></title>

	<?php wp_head(); ?>
</head>
<body <?php body_class() ?>>
<?php wp_body_open(); ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
  <a class="navbar-brand" href="<?php echo get_bloginfo("url"); ?>"><?php echo get_bloginfo("name"); ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <?php
	  	wp_nav_menu([
			"menu" => "primary",
			"menu_class" => "navbar-nav mr-auto",
			"container" => "",
			"fallback_cb"		=> "SPC2\WP_Bootstrap_Navwalker::fallback",
			"walker"			=> new SPC2\WP_Bootstrap_Navwalker()
		]);
	  ?>
	
	<?php get_search_form(); ?>
  </div>
</nav>

<!-- Open page container -->
<div class="container">