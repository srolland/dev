<?php get_header(); ?>
<?php include( TEMPLATEPATH . '/functions/get-options.php' ); /* include theme options */ ?>
			
			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed">
			
				<?php include( TEMPLATEPATH . '/includes/latest-post.php' ); ?>
				
                               
				<!-- BEGIN #top-blocks -->
				<div id="top-blocks" class="clearfix">
				
					<?php 
						if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Special Spot homepage') )
						
					?>
				
				
					<?php include( TEMPLATEPATH . '/includes/recent-posts.php' ); ?>
					
				
				<!-- END #top-blocks-->
				</div>
				
				<?php if ($tz_news_pictures == "true") { /* if news by pictures is enabled in theme options */ ?>
				<?php include( TEMPLATEPATH . '/includes/picture-posts.php' ); ?>
				<?php } ?>
				
				<?php if ($tz_news_pictures == "true") { /* if news by pictures is enabled in theme options */ ?>
				<?php include( TEMPLATEPATH . '/includes/picture-posts.php' ); ?>
				<?php } ?>
				
             


				
                
				<div id="picture-posts">

					<h3 class="widget-title">Latest Videos</h3>
					
					<br/>
			
					<div style="width:298px;border:1px solid #EEE; background-color:#f8f8f8; float:left;">
						<div class="padd" style="margin:4px;">
							<?php echo do_shortcode("[external-videos feature='embed' width='290' height='250']"); ?>
						</div>
					</div>

				

					<!-- BEGIN #thumbs .navigation -->
					<div id="thumbs" class="navigation" style="width:300px; float:right;">

						<!-- BEGIN ul.thumbs -->
						<ul class="thumbs noscript">
							
							<?php echo do_shortcode("[external-videos feature='thumbs']"); ?>

						<!-- END ul.thumbs -->	
						</ul>

					<!-- END #thumbs .navigation -->	
					</div>

				<!-- END #picture-posts -->
				</div>
				<div style="clear:both;">&nbsp;</div>
				<div style="clear:both;">&nbsp;</div>
				
				
				<!-- BEGIN #top-blocks -->
				<div id="top-blocks" class="clearfix">
				
				
					<?php include( TEMPLATEPATH . '/includes/recent-posts-contd.php' ); ?>
					
				
				<a href="/news" style="float:right;">More posts &rarr;</a>
				
				<!-- END #top-blocks-->
				</div>
				
				
				
			<!--END #primary .hfeed-->
			</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>