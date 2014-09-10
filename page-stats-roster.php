<?php
/*
Template Name: Roster
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
						.player_stats_table tr { border-bottom: 1px solid #CCC; }
						.player_stats_table tbody { width:620px; border:none; }
						.player_stats_table tbody .player_first {width:200px; text-align:left;}
						.player_stats_table tbody td { width:30px;}
						.player_stats_table tbody td.odd, .player_stats_table th.odd { background-color:#F0F0F0;}
						.stats_legend { font-size:9px; color:#CCC;}
						
						
						
						
					</style>
                    
                    <?php
                    	$montreal_players = $newdb->get_results("SELECT pp.person_id, p.person_key, pp.membership_id, pp.regular_position_id, positions.abbreviation as position, dn_player.full_name, pp.uniform_number, cs.events_played, pst.plus_minus, pen.value, off.points, off.goals, off.assists, off.goals_power_play, off.goals_short_handed, off.goals_game_winning, off.goals_overtime, off.shots, team_names.full_name as team_name
					
							FROM stats stats1
							JOIN stats stats2
							JOIN stats stats3
							JOIN stats stats4
							JOIN sub_seasons ss ON (stats1.stat_coverage_id=ss.id AND stats2.stat_coverage_id=ss.id AND	stats3.stat_coverage_id=ss.id AND stats4.stat_coverage_id=ss.id)
							JOIN seasons seasons ON ss.season_id = seasons.id
							JOIN publishers pub ON seasons.publisher_id = pub.id
							JOIN core_stats cs ON stats1.stat_repository_id = cs.id
							JOIN ice_hockey_player_stats pst ON stats2.stat_repository_id = pst.id
							JOIN penalty_stats pen ON stats3.stat_repository_id = pen.id
							JOIN ice_hockey_offensive_stats off ON stats4.stat_repository_id = off.id
							JOIN persons p ON (stats1.stat_holder_id = p.id AND stats2.stat_holder_id = p.id AND
							stats3.stat_holder_id = p.id AND stats4.stat_holder_id = p.id)
							JOIN person_phases pp ON p.id = pp.person_id
							JOIN display_names dn_player ON pp.person_id = dn_player.entity_id	
							JOIN positions ON positions.id = pp.regular_position_id
							JOIN display_names as team_names ON pp.membership_id = team_names.entity_id
					
							WHERE pub.publisher_key = 'nhl.com'
							AND stats1.stat_coverage_type = 'sub_seasons'
							AND stats1.stat_repository_type = 'core_stats'
							AND stats1.stat_holder_type = 'persons'
							AND stats2.stat_coverage_type = 'sub_seasons'
							AND stats2.stat_repository_type = 'ice_hockey_player_stats'
							AND stats2.stat_holder_type = 'persons'
							AND stats3.stat_coverage_type = 'sub_seasons'
							AND stats3.stat_repository_type = 'penalty_stats'
							AND stats3.stat_holder_type = 'persons'
							AND stats4.stat_coverage_type = 'sub_seasons'
							AND stats4.stat_repository_type = 'ice_hockey_offensive_stats'
							AND stats4.stat_holder_type = 'persons'
							AND dn_player.entity_type = 'persons'
							AND team_names.entity_type = 'teams'
							AND (ss.sub_season_key = '2010_season_regular' OR ss.sub_season_key = '2010_season_post_season')
							AND team_names.entity_id = '12';
						");
											
											
							
								if ( !empty($montreal_players) ) {
									echo "<table class='player_stats_table'><thead> <th>#</th> <th width='120'>Player</th> <th class='odd'>Pos</th> <th>GP</th> <th class='odd'>G</th> <th>A</th> <th class='odd'>P</th> <th>+/-</th> <th class='odd'>PIM</th> <th>PP</th> <th class='odd'>SH</th> <th>GW</th> <th class='odd'>OT</th> <th>S</th> <th class='odd'>S%</th></thead>" ; 
									foreach ($montreal_players as $player) {	
										$player_position = substr($player->position, 0,1);
										$player_position = strtoupper($player_position);
										$shot_percentage = round(($player->goals*100)/$player->shots, 1);
										$player_id = $player->person_key;
										$player_id = substr(strrchr($player_id, "."),1);
										 
										echo "<tr> <td>" . $player->uniform_number . "</td> <td style='text-align:left;'> <a href='/stats/player-stats?id=" . $player_id ."'>" . $player->full_name . "</a> </td> <td class='odd'>" . $player_position . "</td> <td>" . $player->events_played . "</td> <td class='odd'>" . $player->goals . "</td> <td>" . $player->assists . "</td> <td class='odd'>" . $player->points . "</td> <td>" . $player->plus_minus . "</td> <td class='odd'>" . $player->points . "</td> <td>" . $player->goals_power_play . "</td> <td class='odd'>" . $player->goals_short_handed . "</td> <td>" . $player->goals_game_winning . "</td> <td class='odd'>" . $player->goals_overtime . "</td><td>" . $player->shots . "</td><td class='odd'>" . $shot_percentage . "</td></tr>";						
									}		
								echo "</table>";
								}
				
					
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