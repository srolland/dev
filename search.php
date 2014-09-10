<?php get_header(); ?>
			
			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed">
			<?php if (have_posts()) : ?>

			<h1 class="page-title"><?php _e('Search Results', 'framework') ?></h1>

			<?php while (have_posts()) : the_post(); ?>

			<!--BEGIN .hentry -->
			<div id="<?php the_ID(); ?>" <?php post_class(); ?>>
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"><?php the_title(); ?></a></h2>
					
					<!--BEGIN .entry-meta .entry-header-->
					<div class="entry-meta entry-header">
						<span class="author"><?php _e('Written by', 'framework') ?> <?php the_author_posts_link(); ?></span>
						<span class="published"><?php _e('on', 'framework') ?> <?php the_time( get_option('date_format') ); ?></span>
						<span class="meta-sep">&mdash;</span>
						<span class="comment-count"><?php comments_popup_link(__('No comments', 'framework'), __('1 Comment', 'framework'), __('% Comments', 'framework')); ?></span>
						<?php edit_post_link( __('edit', 'framework'), '<span class="edit-post">[', ']</span>' ); ?>
					<!--END .entry-meta entry-header -->
					</div>
	
					<!--BEGIN .entry-summary -->
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					<!--END .entry-summary -->
					</div>
					
					<!--BEGIN .entry-meta .entry-footer-->
					<div class="entry-meta entry-footer">
						<span class="entry-categories"><?php _e('Posted in', 'framework') ?> <?php the_category(', ') ?></span>
                        <span class="entry-tags"><?php the_tags('|&nbsp;'.__('Tagged:', 'framework').' ', ', ', ''); ?></span>
					<!--END .entry-meta .entry-footer-->
					</div>
            
            <!--END .hentry -->
            </div>

			<?php endwhile; ?>

			<!--BEGIN .navigation .page-navigation -->
			<div class="navigation page-navigation">
				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
				<div class="nav-next"><?php next_posts_link(__('&larr; Older Entries', 'framework')) ?></div>
				<div class="nav-previous"><?php previous_posts_link(__('Newer Entries &rarr;', 'framework')) ?></div>
				<?php } ?>
			<!--END .navigation ,page-navigation -->
			</div>

			<?php else : ?>
				
				<h1 class="page-title"><?php _e('Your search did not match any entries','framework') ?></h1 >
				
				<!--BEGIN #post-0-->
				<div id="post-0">
					
					<!--BEGIN .entry-content-->
					<div class="entry-content">
						<?php get_search_form(); ?>
						<p><?php _e('Suggestions:','framework') ?></p>
						<ul>
							<li><?php _e('Make sure all words are spelled correctly.', 'framework') ?></li>
							<li><?php _e('Try different keywords.', 'framework') ?></li>
							<li><?php _e('Try more general keywords.', 'framework') ?></li>
						</ul>
					<!--END .entry-content-->
					</div>
					
				<!--END #post-0-->
				</div>

			<?php endif; ?>
			<!--END #primary .hfeed-->
			</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>