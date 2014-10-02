<?php get_header(); ?>
<?php include( TEMPLATEPATH . '/functions/get-options.php' ); /* include theme options */ ?>
			
			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed">
			
				<?php include( TEMPLATEPATH . '/includes/latest-post.php' ); ?>
				
				
										<!-- BEGIN #featured-show -->
				    <div id="featured-show" class="clearfix">
				   
				   			<div class="hio-header-box">
									<div class="hio-header-logo-box">
										<img src="<?php bloginfo('template_directory'); ?>/_img/hio-show/hio_show_logo.png" alt="hio_show_logo" width="174" height="66" />
									</div>
									<div class="hio-header-intro-box">
										Host Stu Cowan and his guests engage in spirited, yet good natured, debates centered around the NHL, more specifically the Montreal Canadiens.
									</div>
								</div>
                              
				<!-- BEGIN #top-blocks -->
				<div id="top-blocks" class="clearfix">
				
					<?php 
						if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Special Spot homepage') )
						
					?>
		

				   
				    <?php
					    global $post;
					    $myposts = get_posts('showposts=1&category_name="Show"');
					    foreach($myposts as $post) :
					    ?>
					    <li id="latest_video"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( array(425, 230) ); ?></a></li>
					    
					<?php endforeach; ?>
					
					 <?php
					    global $post;
					    $myposts = get_posts('showposts=2&offset=1&category_name="Show"');
					    foreach($myposts as $post) :
					    ?>
					    <li id="previous_videos"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( array(195, 195) ); ?></a></li>
					<?php endforeach; ?>
					
				    </div>
				   <a id="latest_episode_link" href=" <?php
					    $myposts = get_posts('showposts=2&offset=1&category_name="Show"'); 
					    ?>">Watch/Comment</a>
				   <a id="previous_episodes_link" href="http://www.hockeyinsideout.com/show">Previous Episodes</a>
					<!-- END #featured-show-->
				
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

					<h3 class="widget-title">Videos</h3>
					
					
			
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
				
				
					
					
				
				<a href="/news" style="float:right;">More posts &rarr;</a>
				
				<!-- END #top-blocks-->
				</div>
				
				
				
			<!--END #primary .hfeed-->
			</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>