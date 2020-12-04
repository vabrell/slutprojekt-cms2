<form action="<?php echo site_url(); ?>" class="form-inline my-2 my-lg-0">
	<input
		class="form-control mr-sm-2"
		type="search"
		name="s"
		placeholder="<?php _e("Search"); ?>"
		aria-label="Search"
		value="<?php the_search_query(); ?>"
	>
	<button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?php _e("Search"); ?></button>
</form>