<?php
/* Template Name: In The Game Archive */
 get_header(); ?>
<?php /* Get author data */


	global $query_string;
	query_posts( "post_type=qqp_in_the_game&post_status=publish&posts_per_page=-1" );


	

	if(get_query_var('author_name')) :
	$curauth = get_userdatabylogin(get_query_var('author_name'));
	else :
	$curauth = get_userdata(get_query_var('author'));
	endif;
?>
			
			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed pbp-archive">
			<?php $i = 1; ?>
			<?php if (have_posts()) : ?>
			
			<p class="breadcrumb archive">You are here: <a href="/">Home</a> &raquo; <strong>Play-By-Play Archives</strong></p>
			
					
	
	 	  	<style>
				

			
			</style>
			<?php $post = $posts[0]; /* Hack. Set $post so that the_date() works. */ ?>
			<?php while (have_posts()) : the_post(); ?>
			
			<?php if ($i == 1) : ?>
			
			
			<!-- BEGIN #archive-posts -->
			<div id="archive-posts">
						
			<!-- BEGIN #latest-post -->
			
			
				<?php
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'pbp-large' );
					$url = $thumb['0'];
				?>
			
			
				<div id="latest-post" class="rounded clearfix pbp-archive-first" style="background-image:url(<?php echo $url; ?>);" >
					<h2 class="hidden"><?php the_title(); ?></h2>
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>">
						<span class="title">
							<?php the_title(); ?>
						</span>
						<span>
						<?php the_time( get_option('date_format') ); ?>
						</span>
					</a>
				<!-- END #latest-post -->
				</div>
				
				<p class="breadcrumb archive_header"><strong>Previous Play-By-Play</strong></p>
				
			<?php else : ?>
				
				<?php
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'pbp-small' );
					$url = $thumb['0'];
				?>
			
				<!-- BEGIN .post-container -->
				<div class="post-container clearfix pbp-archive-element"  style="background-image:url(<?php echo $url; ?>);" >
				
					<h2 class="hidden"><?php the_title(); ?></h2>
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>">
						<span class="title">
							<?php the_title(); ?>
						</span>
						<span>
						<?php the_time( get_option('date_format') ); ?>
						</span>
					</a>
					
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
<!-- 				<div class="nav-next"><?php next_posts_link(__('&larr; Older Entries', 'framework')) ?></div> -->
<!-- 				<div class="nav-previous"><?php previous_posts_link(__('Newer Entries &rarr;', 'framework')) ?></div> -->
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
				<div class="clear_it"></div>
			</div>
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>