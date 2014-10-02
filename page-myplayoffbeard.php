<?php
/*
Template Name: Beard App Page
*/

get_header(); ?>

			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<!--BEGIN .hentry-->
				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
					<h1 class="entry-title"><?php the_title(); ?></h1>
                    <?php if ( current_user_can( 'edit_post', $post->ID ) ): ?>
                    
                    <!--BEGIN .entry-meta .entry-header-->
					<div class="entry-meta entry-header">
						<?php edit_post_link( __('edit', 'framework'), '<span class="edit-post">[', ']</span>' ); ?>
					<!--END .entry-meta .entry-header-->
                    </div>
                    <?php endif; ?>

					<!--BEGIN .entry-content -->
					<div class="entry-content">
						<?php the_content(); ?>
						
						<h3 class="widget-title">More playoff beards</h3>
						<br/>
						<div id="mosaic_link">
							
						</div>
						
						<a href="http://staging.hockeyinsideout.com/my-playoff-beard-photo/mosaic">Browse our mosaic of playoff beards &rarr;</a>
						<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
						
						<script type="text/javascript">
						
						var jPics;
						var waypoint = 0;
							
						$(document).ready(function( event) {
						
							jQuery.ajax( {
								url      : 'http://myplayoffbeard.hockeyinsideout.com/status.php?get_name',
								dataType : 'jsonp',
								success  : function ( data ) {
								
									jPics = data;
									//writPics();
									nextPage = jPics.slice(waypoint,(waypoint+12));
									
									jQuery.each(nextPage, function(i) { 
											$('#mosaic_link').append('<a href="http://staging.hockeyinsideout.com/my-playoff-beard-photo/mosaic"><img src="'+ this.thumb +'" style="margin: 0 15px 20px 0;"/></a>');
															
									});

								}
							});
						
						});
						
						
						</script>
						
						
						
						<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:', 'framework').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<!--END .entry-content -->
					</div>

				<!--END .hentry-->
				</div>
				
				<?php comments_template('', true); ?>

				<?php endwhile; endif; ?>
			
			<!--END #primary .hfeed-->
			</div>
			
<?php get_sidebar(); ?>

<?php get_footer(); ?>