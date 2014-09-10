<?php
/*
Template Name: Feedtest
*/
?>
<?php get_header(); ?>

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
                    
		            <style>
						.player_photo { float: left; margin-right:15px; }
						.player_info {}
						.player_info h3 {float: left; font-size:36px; font-weight:bold; padding-right:15px; height:65px; text-align:center; line-height:65px; border-right:1px solid #CCC; margin-right:15px;}
						.player_info h3 span { font-size: 20px; line-height: 20px; vertical-align: 15px;}
						.player_stats_table { width:620px; border: none;}
						.player_stats_table tbody { width:620px; border: 1px solid #CCC; }
						.player_stats_table tbody .player_first {width:200px; text-align:left;}
						.player_stats_table tbody td { width:30px;}
						.player_stats_table tbody td.odd { background-color:#F0F0F0;}
						.stats_legend { font-size:9px; color:#CCC;}
						
						
						
						
					</style>

                    <?php
                    	$montreal_players = $newdb->get_results("SELECT e.event_key, dn.full_name, t.team_key, pe.alignment, pe.score AS total_score, pe.event_outcome, e.event_status
 
FROM participants_events pe
JOIN teams t ON pe.participant_id = t.id
JOIN events e ON pe.event_id = e.id
JOIN display_names dn ON pe.participant_id = dn.entity_id
JOIN publishers pub ON e.publisher_id = pub.id
 
WHERE pub.publisher_key = 'nhl.com'
AND pe.participant_type = 'teams'
AND dn.entity_type = 'teams'

AND CONVERT_TZ(e.start_date_time, '+00:00', '-05:00') LIKE '2013-02-02%'
ORDER BY e.start_date_time, e.event_key;
						");
											
							echo ('live v 01');
								print_r($montreal_players);
				
					
						?>
 
						<?php the_content(); ?>
						<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:', 'framework').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<!--END .entry-content -->
					</div>

				<!--END .hentry-->
				</div>
				

				<?php endwhile; endif; ?>
			
			<!--END #primary .hfeed-->
			</div>
			
<?php get_sidebar(); ?>

<?php get_footer(); ?>