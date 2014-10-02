					<!-- BEGIN #cateory-left-summary .category-block-summary -->
					<div id="category-left-summary" class="category-block-summary alignleft">
						
						<?php /* Category credentials */
    					$category_name = $tz_cat_three_select;
    					$category_id = get_cat_ID( $category_name );
   						$category_link = get_category_link( $category_id ); ?>

						<h3 class="widget-title"><a href="<?php echo ($category_link); ?>" title="<?php echo ($category_name); ?>"><?php echo ($category_name); ?></a></h3>
						
						<?php /* show category one list */
						$tz_cat_three_posts = new WP_Query(); $tz_cat_three_posts->query('caller_get_posts=1&posts_per_page=' . $tz_cat_three_number . '&cat=' . $category_id . ''); ?>
						<?php while ($tz_cat_three_posts->have_posts()) : $tz_cat_three_posts->the_post(); ?>
						
						<!-- BEGIN .post-container -->
						<div class="post-container clearfix">
							
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"> <?php the_title(); ?></a></h2>
							
							<!--BEGIN .entry-meta .entry-header-->
							<div class="entry-meta entry-header">
								<span class="published"><?php the_time( get_option('date_format') ); ?></span>
								<span class="meta-sep">&middot;</span>
								<span class="comment-count"><?php comments_popup_link(__('No comments', 'framework'), __('1 Comment', 'framework'), __('% Comments', 'framework')); ?></span>
							<!--END .entry-meta entry-header -->
							</div>
						
						<!-- END .post-container -->
						</div>
						
						<?php endwhile; /* end category three list */ ?>
					
					<!-- BEGIN #cateory-left-summary .category-block-summary -->
					</div>