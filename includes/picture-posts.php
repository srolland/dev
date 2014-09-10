				<!-- BEGIN #picture-posts -->
				<div id="picture-posts">
				
					<h3 class="widget-title"><?php _e('News in Pictures', 'framework') ?></h3>
					
					<!-- BEGIN #gallery .content -->
					<div id="gallery" class="content">
						
						<div class="slideshow-container">
							<div id="loading" class="loader"></div>
							<div id="slideshow" class="slideshow"></div>
						</div>
						
						<div id="caption" class="caption-container"></div>
					
					<!-- END #gallery .content -->	
					</div>
					
					<!-- BEGIN #thumbs .navigation -->
					<div id="thumbs" class="navigation">
						
						<!-- BEGIN ul.thumbs -->
						<ul class="thumbs noscript">
						
							<?php /* show picture post list */
							$tz_picture_posts = new WP_Query(); $tz_picture_posts->query('tag=pictures&posts_per_page=16'); ?>
							<?php while ($tz_picture_posts->have_posts()) : $tz_picture_posts->the_post(); ?>
							
							<?php /* get the image url rather than the whole img tag */
							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'main-image-pictures');
							$image_url = $image_url[0]; ?>
							
							<li>
								<a class="thumb" href="<?php echo($image_url); ?>" title="<?php the_title(); ?>">
									<?php the_post_thumbnail(); /* post thumbnail settings configured in functions.php */ ?>
								</a>
								
								<!-- BEGIN .caption -->
								<div class="caption">
								
									<div class="image-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"><?php the_title(); ?></a></div>
									
									<!--BEGIN .entry-meta .entry-header-->
									<div class="entry-meta entry-header">
										<span class="published"><?php the_time( get_option('date_format') ); ?></span>
										<span class="meta-sep">&middot;</span>
										<span class="comment-count"><?php comments_popup_link(__('No comments', 'framework'), __('1 Comment', 'framework'), __('% Comments', 'framework')); ?></span>
									<!--END .entry-meta entry-header -->
									</div>
								
								<!-- END .caption -->
								</div>
							</li>
	
							<?php endwhile; /* end latest post */ ?>
						
						<!-- END ul.thumbs -->	
						</ul>
					
					<!-- END #thumbs .navigation -->	
					</div>
				
				<!-- END #picture-posts -->
				</div>