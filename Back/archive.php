<?php get_header(); ?>
<?php /* Get author data */
	if(get_query_var('author_name')) :
	$curauth = get_userdatabylogin(get_query_var('author_name'));
	else :
	$curauth = get_userdata(get_query_var('author'));
	endif;
?>
			
			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed">
			<?php $i = 1; ?>
			<?php if (have_posts()) : ?>	
				
			<?php if ( function_exists('yoast_breadcrumb') ) : ?> <p class="breadcrumb archive"><?php yoast_breadcrumb(); ?></p>
					
		 	<?php else : /* if yoast_breadcrumb is not available, use a generic title */ ?> 
		 	
	 	  	<?php /* If this is a category archive */ if (is_category()) { ?>
				<h1 class="page-title"><?php printf(__('All posts in %s', 'framework'), single_cat_title('',false)); ?></h1>
	 	  	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
				<h1 class="page-title"><?php printf(__('All posts tagged %s', 'framework'), single_tag_title('',false)); ?></h1>
	 	  	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
				<h1 class="page-title"><?php _e('Archive for', 'framework') ?> <?php the_time('F jS, Y'); ?></h1>
	 	 	 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				<h1 class="page-title"><?php _e('Archive for', 'framework') ?> <?php the_time('F, Y'); ?></h1>
	 		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				<h1 class="page-title"><?php _e('Archive for', 'framework') ?> <?php the_time('Y'); ?></h1>
		  	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
				<h1 class="page-title"><?php _e('All posts by', 'framework') ?> <?php echo $curauth->display_name; ?></h1>
	 	  	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
				<h1 class="page-title"><?php _e('Blog Archives', 'framework') ?></h1>
	 	  	<?php } ?>
	 	  	
	 	  	<?php endif; ?>
	
	
			<?php $post = $posts[0]; /* Hack. Set $post so that the_date() works. */ ?>
			<?php while (have_posts()) : the_post(); ?>
			
			<?php if ($i == 1) : ?>
			
			
			<!-- BEGIN #archive-posts -->
			<div id="archive-posts">
						
			<!-- BEGIN #latest-post -->
			<div id="latest-post" class="rounded clearfix">
			
				<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { /* if post has post thumbnail */ ?>
				<div class="post-thumb">
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"><?php the_post_thumbnail('main-image'); /* post thumbnail settings configured in functions.php */ ?></a>
				</div>
				<?php } ?>
				
				<!--BEGIN .entry-meta .entry-header-->
				<div class="entry-meta entry-header">
					<span class="published"><?php the_time( get_option('date_format') ); ?></span>
					<span class="meta-sep">&middot;</span>
					<span class="comment-count"><?php comments_popup_link(__('No comments', 'framework'), __('1 Comment', 'framework'), __('% Comments', 'framework')); ?></span>
				<!--END .entry-meta entry-header -->
				</div>
			
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"> <?php the_title(); ?></a></h2>
				
				<!--BEGIN .entry-summary -->
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				<!--END .entry-summary -->
				</div>
				
				<a class="continue" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"><?php _e('Continue Reading...', 'framework') ?></a>
			
			<!-- END #latest-post -->
			</div>
			
			<?php else : ?>
			
			
				<!-- BEGIN .post-container -->
				<div class="post-container clearfix">
				
					<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { /* if post has post thumbnail */ ?>
					<div class="post-thumb">
						<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"><?php the_post_thumbnail('thumbnail-large'); /* post thumbnail settings configured in functions.php */ ?></a>
					</div>
					<?php } ?>
					
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"> <?php the_title(); ?></a></h2>
					
					<!--BEGIN .entry-meta .entry-header-->
					<div class="entry-meta entry-header">
						<span class="published"><?php the_time( get_option('date_format') ); ?></span>
						<span class="meta-sep">&middot;</span>
						<span class="comment-count"><?php comments_popup_link(__('No comments', 'framework'), __('1 Comment', 'framework'), __('% Comments', 'framework')); ?></span>
					<!--END .entry-meta entry-header -->
					</div>
					
					<!--BEGIN .entry-summary -->
					<div class="entry-summary">
						<p><?php content(28); ?></p>
					<!--END .entry-summary -->
					</div>
				
				<!-- END .post-container -->
				</div>
			
			
			
			<?php endif; ?>
			
			<?php $i++; ?>
			<?php endwhile; /* end latest post */ ?>
			
			<!-- END #archive-posts -->
			</div>
	
			<!--BEGIN .navigation .page-navigation -->
			<div class="navigation page-navigation">
			
			<?php if ( function_exists('wp_pagenavi') ) { wp_pagenavi(); } else { ?>
				<div class="nav-next"><?php next_posts_link(__('&larr; Older Entries', 'framework')) ?></div>
				<div class="nav-previous"><?php previous_posts_link(__('Newer Entries &rarr;', 'framework')) ?></div>
			<?php } ?>
			<!--END .navigation ,page-navigation -->
			</div>
			
			<?php else :
	
			if ( is_category() ) { // If this is a category archive
				printf(__('<h2>Sorry, but there aren\'t any posts in the %s category yet.</h2>', 'framework'), single_cat_title('',false));
			} else if ( is_date() ) { // If this is a date archive
				echo(__('<h2>Sorry, but there aren\'t any posts with this date.</h2>', 'framework'));
			} else if ( is_author() ) { // If this is a category archive
				$userdata = get_userdatabylogin(get_query_var('author_name'));
				printf(__('<h2>Sorry, but there aren\'t any posts by %s yet.</h2>', 'framework'), $userdata->display_name);
			} else {
				echo(__('<h2>No posts found.</h2>', 'framework'));
			}
			get_search_form();
	
			endif; ?>
			
			<!--END #primary .hfeed-->
			</div>
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>