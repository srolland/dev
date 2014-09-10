<?php
/*
Template Name: Past Games
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
                    
		             <?php 
					 
					 $team_names_query = $newdb->get_results( "SELECT t.team_key, t.id,team_names.first_name,team_names.last_name,team_names.abbreviation 
														  	FROM teams t JOIN display_names as team_names ON t.id = team_names.entity_id 
															WHERE team_names.entity_type = 'teams' ORDER BY id;");
						$team_names = array();
						foreach ( $team_names_query as $team) {
							$team_info = array();
							$team_key = $team->team_key;
							
							$team_info["city"] = $team->first_name;
							$team_info["name"] = $team->last_name;
							$team_info["abbrev"] = $team->abbreviation; 
							
							$team_names[$team_key] = $team_info;
						}



					$games = $newdb->get_results("SELECT events.event_key, ss.sub_season_key, events.event_status, t1.team_key as team_key, pe_team.score, t2.team_key as opponent_team_key, pe_opponent.score as score02, events.start_date_time as start_time, ihes.period_value as current_period, ihes.period_time_remaining

					FROM events
					LEFT JOIN ice_hockey_event_states ihes ON (events.id = ihes.event_id AND ihes.current_state = '1') JOIN participants_events pe_team ON pe_team.event_id = events.id JOIN participants_events pe_opponent ON pe_opponent.event_id = events.id JOIN teams t1 ON pe_team.participant_id = t1.id JOIN teams t2 ON pe_opponent.participant_id = t2.id JOIN events_sub_seasons ess ON ess.event_id = events.id JOIN sub_seasons ss ON ess.sub_season_id = ss.id JOIN seasons s ON ss.season_id = s.id JOIN affiliations a ON s.league_id = a.id JOIN publishers pub ON s.publisher_id = pub.id
					
					WHERE pe_team.participant_type = 'teams' 
					AND pe_opponent.participant_type = 'teams' 
					AND pe_opponent.participant_id != pe_team.participant_id AND pe_team.alignment='home'
					AND a.affiliation_type = 'league'
					AND a.affiliation_key = 'l.nhl.com'
					AND pub.publisher_key = 'nhl.com'
          AND events.event_status = 'post-event'
					AND (ss.sub_season_key = '2011' OR ss.sub_season_key = '2011_season_regular' OR ss.sub_season_key = '2011_pre_season') AND events.start_date_time IS NOT NULL AND (t1.team_key = 'l.nhl.com-t.8' OR t2.team_key = 'l.nhl.com-t.8') 
					/*AND events.event_key = 'l.nhl.com-2010-e.21217'*/
					GROUP BY events.event_key
					ORDER BY start_time DESC;
					
					 ");



					



$games_list = array();


foreach ($games as $game) {						
	
	if ( $game->event_status == "post-event") {
			$period_and_time = "Final";
		} else {  
			$period_and_time = $game->current_period. " " . $game->period_time_remaining;
		}
	
	$game_event_key = $game->event_key;
	$game_id_pos = strrpos($game_event_key, '.')+1;
	$game_id = substr($game_event_key, $game_id_pos);

	
	$new_game = array();
	
	$new_game["game_id"] = $game_id;
	
		$game_start = str_replace ( "-","/",substr($game->start_time, 0, 10));
		$game_date_raw = strtotime($game_start);
		$game_date = date('F d, Y', $game_date_raw);
		$new_game["date"] = $game_date ;
	
	
		$new_game["home_team_city"] =  $team_names[$game->team_key]["city"];
		$new_game["home_team_name"] = $team_names[$game->team_key]["name"];
		$new_game["home_team_abbrev"] = $team_names[$game->team_key]["abbrev"];	
		$new_game["home_team_final_score"] = $game->score;
		$new_game["home_team_key"] = $game->team_key;
	
	
		$new_game["away_team_city"] = $team_names[$game->opponent_team_key]["city"];
		$new_game["away_team_name"] = $team_names[$game->opponent_team_key]["name"];
		$new_game["away_team_abbrev"] = $team_names[$game->opponent_team_key]["abbrev"];	
		$new_game["away_team_final_score"] = $game->score02;
		$new_game["away_team_key"] = $game->opponent_team_key;
	
	
	$games_list[] = $new_game;
}	
         
									
		//print_r($games);
		
		foreach ($games_list as $game){
			
			echo "<table width='300' class='past_games'><thead><tr><th style='text-align:left;'bgcolor='#D0D8ED'><a href='/stats/score?gid=" . $game["game_id"] . "'> &raquo;" . $game["date"] . "</a></th><th>T</th></tr></thead>";
			echo "<tr class='even'><td style='text-align:left;'><img src='/wp-content/uploads/stats/team-logos/small/" . str_replace (" ", "", $game["home_team_city"]) . "@2x.png'/>" . $game["home_team_city"] . " </td><td style='color:#000; font-size:16px;'>" . $game["home_team_final_score"] . "</td></tr>";
			echo "<tr><td  style='text-align:left;'><img src='/wp-content/uploads/stats/team-logos/small/" . str_replace (" ", "", $game["away_team_city"]) . "@2x.png' />" . $game["away_team_city"] . " </td><td style='color:#000; font-size:16px;'>" . $game["away_team_final_score"] . "</td></tr>";
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