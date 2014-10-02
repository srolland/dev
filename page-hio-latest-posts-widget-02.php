<?php
/*
Template Name: Latest Posts Widget 02
*/
?>				<style type="text/css">
					body { margin:0; }
					#latest-posts-widget ul {list-style:none; padding:0; margin:0 0 10px 0;}
					#latest-posts-widget ul li {list-style:none; padding:0; }
					
					#latest-posts-widget { width:300px;line-height:18px; /*outline:1px solid red;*/padding-top:10px;}
					
					#latest-posts-widget .entry-meta{ font-size: 10px;text-transform: uppercase; color: #999999; font-family:arial; margin-left:2em;}
					#latest-posts-widget .entry-meta a{ color: #999999;}
					
					#latest-posts-widget a.post-link {color: #035A91; font-family: georgia; font-size: 14px; text-decoration:none; padding-left:20px; background: url(<?php bloginfo('template_directory'); ?>/images/link_arrow.gif) no-repeat 0 0;}
																																													 					#latest-posts-widget a.post-link:hover {text-decoration: underline;}
					
					#latest-posts-widget a.hio-link { float:right;}
				</style>
				<div id="latest-posts-widget">
				<ul>
				<?php /* show the latest posts  */
					$tz_latest_post = new WP_Query(); $tz_latest_post->query('posts_per_page=3&caller_get_posts=3'); ?>
				<?php while ($tz_latest_post->have_posts()) : $tz_latest_post->the_post(); ?>
				
				<!-- BEGIN #latest-post -->
				
					<li><a href="<?php the_permalink(); ?>?utm_source=MG-sports&utm_medium=text-link&utm_campaign=hio-widget" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>" class="post-link" target="_blank"><?php the_title(); ?></a>
					
					<!--BEGIN .entry-meta .entry-header-->
					<div class="entry-meta entry-header">
						<span class="published"><?php the_time( get_option('date_format') ); ?></span>
						<span class="meta-sep">&middot;</span>
						<span class="comment-count"><?php  comments_number( 'No comments', 'One comment', '% comments' ); ?> </span>
						
					<!--END .entry-meta entry-header -->
					</div>
					</li>
					
				
				
				<!-- END #latest-post -->
			
				<?php endwhile; /* end latest posts */ ?>
				</ul>
                <a href="http://staging.hockeyinsideout.com?utm_source=MG-sports&utm_medium=text-link&utm_campaign=hio-widget" class="post-link hio-link" target="_blank">Visit Hockey Inside/Out</a>
                </div>