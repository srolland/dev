<!--BEGIN #searchform-->
<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
	<div class="search-container">
		<div class="search-inner clearfix">
			<label class="hidden" for="s"><?php _e('Search for:', 'framework'); ?></label>
			<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" />
			<input type="submit" id="searchsubmit" value="Search" />
		</div>
	</div>
<!--END #searchform-->
</form>