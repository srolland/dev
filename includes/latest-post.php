				<?php /* show the latest post in the feature box */
				$tz_latest_post = new WP_Query(); $tz_latest_post->query('posts_per_page=1&caller_get_posts=1'); ?>
				<?php while ($tz_latest_post->have_posts()) : $tz_latest_post->the_post(); ?>
				
				<!-- BEGIN #latest-post -->
				<div id="latest-post" class="rounded clearfix">
				
					<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { /* if post has post thumbnail */ ?>
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
				<?php endwhile; /* end latest post */ ?>