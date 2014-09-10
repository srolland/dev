<?php get_header(); ?>
<?php include( TEMPLATEPATH . '/functions/get-options.php' ); /* include theme options */ ?>
			
			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed">
			
				<?php include( TEMPLATEPATH . '/includes/latest-post.php' ); ?>
				
				<!-- BEGIN #top-blocks -->
				<div id="top-blocks" class="clearfix">
				
					<?php include( TEMPLATEPATH . '/includes/recent-posts.php' ); ?>
					
				
				<!-- END #top-blocks-->
				</div>
				
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
				
				
				
				<?php if ($tz_top_blocks == "true") { /* if top blocks are enabled*/ ?>
				<!-- BEGIN #category-blocks -->
               <!-- <div><h3 class="widget-title"><a title="Boone" href="http://staging.hockeyinsideout.com/category/boone">Videos</a></h3><img src="http://staging.hockeyinsideout.com/wp-content/themes/deadline/images/video-placeholder.png" alt="facebook"  title="Live Scoce" border="0" ></div>-->
				<div id="category-blocks" class="clearfix">
					
					<?php if ($tz_cat_one_select) { /* if block one category is set */ ?>
					<?php include( TEMPLATEPATH . '/includes/home-block-one.php' ); ?>
					<?php } ?>
                    
                    	
                	<div id="category-right" class="category-block alignright">    
                    	<?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Main Right Block') ) ?>
                	<!-- end #category-right .category-block -->
                	</div>

						



				
				<!-- END #category-blocks -->
				</div>
				<?php } ?>
				
				
				<?php if ($tz_bottom_blocks == "true") { /* if top blocks are enabled*/ ?>
				<!-- BEGIN #category-blocks-summary -->
				<div id="category-blocks-summary" class="clearfix">
					
					<?php if ($tz_cat_three_select) { /* if block three category is set */ ?>
					<?php include( TEMPLATEPATH . '/includes/home-block-three.php' ); ?>
					<?php } ?>
					
					<?php if ($tz_cat_four_select) { /* if block four category is set */ ?> 
					<?php include( TEMPLATEPATH . '/includes/home-block-four.php' ); ?>
					<?php } ?>
				
				<!-- END #category-blocks-summary -->
				</div>
				<?php } ?>
				
			<!--END #primary .hfeed-->
			</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>