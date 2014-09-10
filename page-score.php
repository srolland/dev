<?php
/*
Template Name: Game Score
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



$games = $newdb->get_results("SELECT dn.full_name, dn.first_name as city, dn.last_name as team_name, dn.abbreviation as abbrev, t.team_key, pe.alignment, pe.score as total_score, pe.event_outcome, states.period_value as current_period, states.period_time_remaining, e.event_status
							 
FROM participants_events pe
JOIN teams t ON pe.participant_id = t.id
JOIN events e ON pe.event_id = e.id
JOIN display_names dn ON pe.participant_id = dn.entity_id
JOIN ice_hockey_event_states states ON states.event_id = e.id
JOIN publishers pub ON e.publisher_id = pub.id

WHERE pub.publisher_key = 'nhl.com'
AND pe.participant_type = 'teams'
AND dn.entity_type = 'teams'
AND states.current_state = '1'
AND states.context = 'event-score'
AND e.event_key = 'l.nhl.com-2011-e.". $_GET["gid"] ."';
 ");

$game_periods = $newdb->get_results("SELECT dn.full_name, dn.first_name as city, dn.last_name as team_name, dn.abbreviation as abbrev, t.team_key, pe.alignment, per.period_value, per.score, per.score_attempts

FROM participants_events pe
JOIN periods per ON per.participant_event_id = pe.id
JOIN teams t ON pe.participant_id = t.id
JOIN events e ON pe.event_id = e.id
JOIN display_names dn ON pe.participant_id = dn.entity_id
JOIN ice_hockey_event_states states ON states.event_id = e.id
JOIN publishers pub ON e.publisher_id = pub.id

WHERE pub.publisher_key = 'nhl.com'
AND pe.participant_type = 'teams'
AND dn.entity_type = 'teams'
AND states.current_state = '1'
AND states.context = 'event-score'
AND e.event_key = 'l.nhl.com-2011-e.". $_GET["gid"] ."';");

$game_events = $newdb->get_results("SELECT states.period_value, states.period_time_elapsed, t.team_key, p.person_key, dn_player.full_name, players.participant_role, plays.play_result, plays.penalty_type, plays.ice_hockey_event_state_id, plays.strength 

FROM ice_hockey_action_participants players
JOIN display_names dn_player ON players.person_id = dn_player.entity_id
JOIN ice_hockey_action_plays plays ON plays.id = players.ice_hockey_action_play_id
JOIN ice_hockey_event_states states ON plays.ice_hockey_event_state_id = states.id
JOIN teams t ON plays.team_id = t.id
JOIN persons p ON players.person_id = p.id
JOIN events e ON states.event_id = e.id
JOIN publishers pub ON e.publisher_id = pub.id

WHERE pub.publisher_key = 'nhl.com' 
AND e.event_key = 'l.nhl.com-2011-e.". $_GET["gid"] ."'
AND (players.participant_role = 'penalty-committed-by' OR players.participant_role = 'penalty-served-by' OR players.participant_role = 'scorer' OR players.participant_role = 'assist' OR players.participant_role='shooter')
AND dn_player.entity_type = 'persons'
AND states.context = 'event' ORDER BY period_value, period_time_elapsed, plays.shootout_shot_order;

");


$goalies_time = $newdb->get_results("SELECT DISTINCT dn_player.last_name, p.person_key, dn_team.abbreviation as abbrev, t.team_key, time.time_total, time.time_power_play, time.time_short_handed, time.time_even_strength

FROM stats s
JOIN ice_hockey_time_on_ice_stats time ON s.stat_repository_id = time.id
JOIN teams t ON s.stat_membership_id = t.id
JOIN persons p ON s.stat_holder_id = p.id
JOIN events e ON s.stat_coverage_id = e.id
JOIN display_names dn_player ON s.stat_holder_id = dn_player.entity_id
JOIN display_names dn_team ON s.stat_membership_id = dn_team.entity_id
JOIN person_event_metadata pem ON (s.stat_holder_id = pem.person_id AND s.stat_coverage_id = e.id)
JOIN positions pos ON pem.position_id = pos.id
JOIN publishers pub ON e.publisher_id = pub.id

WHERE pub.publisher_key = 'nhl.com'
AND s.stat_holder_type = 'persons'
AND s.stat_repository_type = 'ice_hockey_time_on_ice_stats'
AND s.stat_coverage_type = 'events'
AND s.context = 'event'
AND pos.abbreviation = 'goalie'
AND dn_player.entity_type = 'persons'
AND dn_team.entity_type = 'teams'
AND e.event_key = 'l.nhl.com-2011-e.". $_GET["gid"] ."';
");

$goalies_shots = $newdb->get_results("SELECT DISTINCT dn_player.last_name, p.person_key, dn_team.abbreviation as abbrev, t.team_key, def.goals_allowed, def.shots_allowed

FROM stats s
JOIN ice_hockey_defensive_stats def ON s.stat_repository_id = def.id
JOIN teams t ON s.stat_membership_id = t.id
JOIN persons p ON s.stat_holder_id = p.id
JOIN events e ON s.stat_coverage_id = e.id
JOIN display_names dn_player ON s.stat_holder_id = dn_player.entity_id
JOIN display_names dn_team ON s.stat_membership_id = dn_team.entity_id
JOIN person_event_metadata pem ON (s.stat_holder_id = pem.person_id AND s.stat_coverage_id = e.id)
JOIN positions pos ON pem.position_id = pos.id
JOIN publishers pub ON e.publisher_id = pub.id

WHERE pub.publisher_key = 'nhl.com'
AND s.stat_holder_type = 'persons'
AND s.stat_repository_type = 'ice_hockey_defensive_stats'
AND s.stat_coverage_type = 'events'
AND s.context = 'event'
AND pos.abbreviation = 'goalie'
AND dn_player.entity_type = 'persons'
AND dn_team.entity_type = 'teams'

AND e.event_key = 'l.nhl.com-2011-e.". $_GET["gid"] ."';
");





// Home Team and Visiting team City, Name, and Abbreviation
/*$home_team_city = "";
$home_team_name = "";
$home_team_abbrev = "";

$away_team_city = "";
$away_team_name = "";
$away_team_abbrev = "";
*/

//Score by period
/*
$period01_home_score = 0;
$period02_home_score = 0;
$period03_home_score = 0;
$period04_home_score = 0;
$period05_home_score = 0;
$total_home_score = 0;
$period01_away_score = 0;
$period02_away_score = 0;
$period03_away_score = 0;
$period04_away_score = 0;
$period05_away_score = 0;
$total_away_score = 0;*/

//Score Breakdown
$goals_period_1 = array();
$goals_period_2 = array();
$goals_period_3 = array();
$goals_period_4 = array();
$goals_period_5 = array();

$penalties_period_1 = array();
$penalties_period_2 = array();
$penalties_period_3 = array();
$penalties_period_4 = array();
$penalties_period_5 = array();

$home_goalies = array();
$away_goalies = array();

foreach ($games as $game) {						
	
	if ( $game->event_status == "post-event") {
			$period_and_time = "Final";
		} else {  
			$period_and_time = $game->current_period. " " . $game->period_time_remaining;
		}
	
	if ($game->alignment == 'home') {
		$home_team_city = $game->city;
		$home_team_name = $game->team_name;
		$home_team_abbrev = $game->abbrev;	
		$home_team_final_score = $game->total_score;
		$home_team_key = $game->team_key;
	}
	if ($game->alignment == 'away') {
		$away_team_city = $game->city;
		$away_team_name = $game->team_name;
		$away_team_abbrev = $game->abbrev;	
		$away_team_final_score = $game->total_score;
		$away_team_key = $game->team_key;
	}
}


//Goalies 
foreach ( $goalies_time as $goalie) {
	if ( $goalie->team_key == $home_team_key && $goalie->time_total > 0){
		$add_goalie = array("goalie"=>$goalie->person_key, "last_name" => $goalie->last_name , "team" => $goalie->abbrev, "time" => $goalie->time_total) ;
		foreach ($goalies_shots as $goalie_shot) {
			if( $goalie_shot->person_key == $goalie->person_key){
				$add_goalie["shots"]= $goalie_shot->shots_allowed;
				$saves = ($goalie_shot->shots_allowed - $goalie_shot->goals_allowed);
				$add_goalie["saves"]= $saves;
			}
		}
		array_push( $home_goalies, $add_goalie);
	}
	if ( $goalie->team_key == $away_team_key  && $goalie->time_total > 0){
		$add_goalie = array("goalie"=>$goalie->person_key, "last_name" => $goalie->last_name , "team" => $goalie->abbrev, "time" => $goalie->time_total) ;
		foreach ($goalies_shots as $goalie_shot) {
			if( $goalie_shot->person_key == $goalie->person_key){
				$add_goalie["shots"]= $goalie_shot->shots_allowed;
				$saves = ($goalie_shot->shots_allowed - $goalie_shot->goals_allowed);
				$add_goalie["saves"]= $saves;
			}
		}
		array_push( $away_goalies, $add_goalie);
	}	
}

foreach ($game_periods as $period ) {
	if ($period->alignment == "home"){
		if ($period->period_value == 1) {
			$home_score_period_1 = 	$period->score;
			$home_shots_period_01 = $period->score_attempts;
		}
		if ($period->period_value == 2) {
			$home_score_period_2 = 	$period->score;
			$home_shots_period_02 = $period->score_attempts;
		}
		if ($period->period_value == 3) {
			$home_score_period_3 = 	$period->score;
			$home_shots_period_03 = $period->score_attempts;
		}
		if ($period->period_value == 4) {
			$home_score_period_4 = 	$period->score;
			$home_shots_period_4 = $period->score_attempts;
		}
		if ($period->period_value == 5) {
			$home_score_period_5 = 	$period->score;
			$home_shots_period_05 = $period->score_attempts;
		}
		$home_shots_total = ($home_shots_period_01 + $home_shots_period_02 + $home_shots_period_03 + $home_shots_period_04 );
	}
	if ($period->alignment == "away"){
		if ($period->period_value == 1) {
			$away_score_period_1 = 	$period->score;
			$away_shots_period_01 = $period->score_attempts;
		}
		if ($period->period_value == 2) {
			$away_score_period_2 = 	$period->score;
			$away_shots_period_02 = $period->score_attempts;
		}
		if ($period->period_value == 3) {
			$away_score_period_3 = 	$period->score;
			$away_shots_period_03 = $period->score_attempts;
		}
		if ($period->period_value == 4) {
			$away_score_period_4 = 	$period->score;
			$away_shots_period_04= $period->score_attempts;
		}
		if ($period->period_value == 5) {
			$away_score_period_5 = 	$period->score;
			$away_shots_period_05 = $period->score_attempts;
		}
		$away_shots_total = ($away_shots_period_01 + $away_shots_period_02 + $away_shots_period_03 + $away_shots_period_04 );
	}
}

foreach ($game_events as $game_event) {
	
	if ( $game_event->strength == 'power-play') {
		$game_event->strength = "PP";	
	}elseif ( $game_event->strength == 'short-handed'){
		$game_event->strength = "SH";
	}elseif( $game_event->strength == 'even-strength') {
		$game_event->strength = "";
	}
	
	// Goal Arrays by period
	//Period 01
	if ( $game_event->period_value == 1 && $game_event->play_result == "goal" && $game_event->participant_role == "scorer"){
		
		$goal_id = $game_event->ice_hockey_event_state_id;
		
		$goal_assists = array();
		
		foreach ($game_events as $game_event_score_check) {
			if ( $game_event_score_check->ice_hockey_event_state_id == $goal_id && $game_event_score_check->participant_role == "assist") {
					array_push($goal_assists, $game_event_score_check->full_name); 
				}	
		}
		
		if ($game_event->team_key == $home_team_key ) {
				$goals_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $home_team_abbrev, "player" => $game_event->full_name, "assist" => $goal_assists, "strength" => $game_event->strength);
		}
		elseif ($game_event->team_key == $away_team_key ){
				$goals_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $away_team_abbrev, "player" => $game_event->full_name, "assist" => $goal_assists, "strength" => $game_event->strength);	
		}
		array_push( $goals_period_1, $goals_period_add);
	}
	
	//Period 02
	if ( $game_event->period_value == 2 && $game_event->play_result == "goal" && $game_event->participant_role == "scorer"){
		
		$goal_id = $game_event->ice_hockey_event_state_id;
		
		$goal_assists = array();
		
		foreach ($game_events as $game_event_score_check) {
			if ( $game_event_score_check->ice_hockey_event_state_id == $goal_id && $game_event_score_check->participant_role == "assist") {
					array_push($goal_assists, $game_event_score_check->full_name); 
				}	
		}
		
			if ($game_event->team_key == $home_team_key ) {
				$goals_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $home_team_abbrev, "player" => $game_event->full_name, "assist" => $goal_assists, "strength" => $game_event->strength);
			}
			elseif ($game_event->team_key == $away_team_key ){
				$goals_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $away_team_abbrev, "player" => $game_event->full_name, "assist" => $goal_assists, "strength" => $game_event->strength);	
			}
			array_push( $goals_period_2, $goals_period_add);
	}
	
	//Period 03
	if ( $game_event->period_value == 3 && $game_event->play_result == "goal" && $game_event->participant_role == "scorer"){
		
		$goal_id = $game_event->ice_hockey_event_state_id;
		//echo "Goal by: " . $game_event->full_name. " " . $goal_id ;
		
		$goal_assists = array();
		
		foreach ($game_events as $game_event_score_check) {
			if ( $game_event_score_check->ice_hockey_event_state_id == $goal_id && $game_event_score_check->participant_role == "assist") {
					//echo "Assist by: " .$game_event_score_check->full_name . "<br/>";
					array_push($goal_assists, $game_event_score_check->full_name); 
				}	
		}
		
		if ($game_event->team_key == $home_team_key ) {
				$goals_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $home_team_abbrev, "player" => $game_event->full_name, "assist" => $goal_assists, "strength" => $game_event->strength);
		}
		elseif ($game_event->team_key == $away_team_key ){
				$goals_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $away_team_abbrev, "player" => $game_event->full_name, "assist" => $goal_assists, "strength" => $game_event->strength);	
		}
		array_push( $goals_period_3, $goals_period_add);
	}
	
	//Period 04
	if ( $game_event->period_value == 4 && $game_event->play_result == "goal" && $game_event->participant_role == "scorer"){
		
		$goal_id = $game_event->ice_hockey_event_state_id;
		//echo "Goal by: " . $game_event->full_name. " " . $goal_id ;
		
		$goal_assists = array();
		
		foreach ($game_events as $game_event_score_check) {
			if ( $game_event_score_check->ice_hockey_event_state_id == $goal_id && $game_event_score_check->participant_role == "assist") {
					//echo "Assist by: " .$game_event_score_check->full_name . "<br/>";
					array_push($goal_assists, $game_event_score_check->full_name); 
				}	
		}
		
		if ($game_event->team_key == $home_team_key ) {
				$goals_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $home_team_abbrev, "player" => $game_event->full_name, "assist" => $goal_assists, "strength" => $game_event->strength);
		}
		elseif ($game_event->team_key == $away_team_key ){
				$goals_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $away_team_abbrev, "player" => $game_event->full_name, "assist" => $goal_assists, "strength" => $game_event->strength);	
		}
		array_push( $goals_period_4, $goals_period_add);
	}
	
	//Period 05
	if ( $game_event->period_value == 5 && $game_event->play_result == "goal" && $game_event->participant_role == "scorer"){
		
		$goal_id = $game_event->ice_hockey_event_state_id;
		//echo "Goal by: " . $game_event->full_name. " " . $goal_id ;
		
		$goal_assists = array();
		
		foreach ($game_events as $game_event_score_check) {
			if ( $game_event_score_check->ice_hockey_event_state_id == $goal_id && $game_event_score_check->participant_role == "assist") {
					//echo "Assist by: " .$game_event_score_check->full_name . "<br/>";
					array_push($goal_assists, $game_event_score_check->full_name); 
				}	
		}
		
		if ($game_event->team_key == $home_team_key ) {
				$goals_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $home_team_abbrev, "player" => $game_event->full_name, "assist" => $goal_assists, "strength" => $game_event->strength);
		}
		elseif ($game_event->team_key == $away_team_key ){
				$goals_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $away_team_abbrev, "player" => $game_event->full_name, "assist" => $goal_assists, "strength" => $game_event->strength);	
		}
		array_push( $goals_period_5, $goals_period_add);
	}


		// Penalties Arrays by period	
		//Period 01
		if ( $game_event->period_value == 1 && $game_event->participant_role == "penalty-committed-by"){
			if ($game_event->team_key == $home_team_key ) {
					$penalties_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $home_team_abbrev, "player" => $game_event->full_name, "penalty" => $game_event->penalty_type);
			}
			elseif ($game_event->team_key == $away_team_key ){
					$penalties_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $away_team_abbrev, "player" => $game_event->full_name, "penalty" => $game_event->penalty_type);	
			}
			array_push( $penalties_period_1, $penalties_period_add);
		}
			
			
		//Period 01
		if ( $game_event->period_value == 2 && $game_event->participant_role == "penalty-committed-by"){
			if ($game_event->team_key == $home_team_key ) {
					$penalties_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $home_team_abbrev, "player" => $game_event->full_name, "penalty" => $game_event->penalty_type);
			}
			elseif ($game_event->team_key == $away_team_key ){
					$penalties_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $away_team_abbrev, "player" => $game_event->full_name, "penalty" => $game_event->penalty_type);	
			}
			array_push( $penalties_period_2, $penalties_period_add);
		}
			
		//Period 01
		if ( $game_event->period_value == 3 && $game_event->participant_role == "penalty-committed-by"){
			if ($game_event->team_key == $home_team_key ) {
					$penalties_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $home_team_abbrev, "player" => $game_event->full_name, "penalty" => $game_event->penalty_type);
			}
			elseif ($game_event->team_key == $away_team_key ){
					$penalties_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $away_team_abbrev, "player" => $game_event->full_name, "penalty" => $game_event->penalty_type);	
			}
			array_push( $penalties_period_3, $penalties_period_add);
		}
		
			
		//Period 01
		if ( $game_event->period_value == 4 && $game_event->participant_role == "penalty-committed-by"){
			if ($game_event->team_key == $home_team_key ) {
					$penalties_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $home_team_abbrev, "player" => $game_event->full_name, "penalty" => $game_event->penalty_type);
			}
			elseif ($game_event->team_key == $away_team_key ){
					$penalties_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $away_team_abbrev, "player" => $game_event->full_name, "penalty" => $game_event->penalty_type);	
			}
			array_push( $penalties_period_4, $penalties_period_add);
		}
			
		//Period 01
		if ( $game_event->period_value == 5 && $game_event->participant_role == "penalty-committed-by"){
			if ($game_event->team_key == $home_team_key ) {
					$penalties_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $home_team_abbrev, "player" => $game_event->full_name, "penalty" => $game_event->penalty_type);
			}
			elseif ($game_event->team_key == $away_team_key ){
					$penalties_period_add = array("period_time" => $game_event->period_time_elapsed, "team" => $away_team_abbrev, "player" => $game_event->full_name, "penalty" => $game_event->penalty_type);	
			}
			array_push( $penalties_period_5, $penalties_period_add);	
		}	
}


function display_scorers ( $period_num , $period_number , $period_num_penalties) {
	if ( !empty($period_num) || !empty($period_num_penalties) ) {
		echo "<h3 class='widget-title'>" . $period_number . " period</h3> " ; 
		
		if ( !empty($period_num) ) {
			echo "<table class='stats_table'><thead> <th colspan='5' align='left'  style='text-align:left;'>Goals</th> </thead>" ; 
			$c = true;
			foreach ( $period_num as $goal_period) {			
			$var_assists = $goal_period['assist'];
			$num_assists = count($var_assists);
			$var_assists_list = "(" . implode(", ", $var_assists) . ")";
							
			echo "<tr " . (($c = !$c)?" class='odd'":" class='even'") . "> <td>" . $goal_period['strength'] . "</td> <td>" . $goal_period['period_time'] . "</td> <td>" . $goal_period['team'] . "</td> <td>" . $goal_period['player'] . "</td> <td>" . $var_assists_list . "</td> </tr>";						
			}		
		echo "</table>";
		}
		if ( !empty($period_num_penalties) ) {
		echo "<table class='stats_table'><thead> <th colspan='4' align='left' style='text-align:left;'>Penalties</th> </thead>" ; 
		$d = true;
		foreach ( $period_num_penalties as $penalty) {			
			echo "<tr " . (($d = !$d)?" class='odd'":" class='even'") . "> <td>" . $penalty['period_time'] . "</td> <td>" . $penalty['team'] . "</td> <td>" . $penalty['player'] . "</td> <td>" . $penalty['penalty'] . "</td> </tr>";						
			}		
		echo "</table><br/>";
		}
	} 
}

function display_penalties ( $period_num ) {
	if ( !empty($period_num) ) {
		echo "<table class='stats_table'><thead> <th colspan='4' align='left' style='text-align:left;'>Penalties</th> </thead>" ; 
		$d = true;
		foreach ( $period_num as $penalty) {			
			echo "<tr " . (($d = !$d)?" class='odd'":" class='even'") . "> <td>" . $penalty['period_time'] . "</td> <td>" . $penalty['team'] . "</td> <td>" . $penalty['player'] . "</td> <td>" . $penalty['penalty'] . "</td> </tr>";						
			}		
		echo "</table><br/>";
	}
}

		echo "<div id='livescore'><img class='home_team_img' src='/wp-content/uploads/stats/team-logos/" . str_replace (" ", "", $home_team_city) . "@2x.png' width='89' height='60'/><span class='home_team_score'>" . $home_team_final_score . "</span><img src='/wp-content/uploads/stats/separator.gif' class='separator'/><span class='away_team_score'>" . $away_team_final_score . "</span><img class='away_team_img' src='/wp-content/uploads/stats/team-logos/" . str_replace (" ", "", $away_team_city) . "@2x.png' width='89' height='60' /> <div class='period_time_display'>" . $period_and_time . "</div>";



		echo " <table ><thead><th width='125' class='left'></th> <th>1</th> <th>2</th> <th>3</th> <th>O</th> <th width='105' class='left'>S/O</th> <th>T</th></thead><tbody><tr><td class='left'>" . $home_team_city . "</td> <td>" . $home_score_period_1 . "</td> <td>" . $home_score_period_2 . "</td> <td>" . $home_score_period_3 . "</td> <td>" . $home_score_period_4 . "</td> <td  class='left'>" . $home_score_period_5 . "</td> <td>" . $home_team_final_score . "</td> </tr><tr> <td class='left'>" . $away_team_city . "</td> <td>" . $away_score_period_1 . "</td> <td>" . $away_score_period_2 . "</td> <td>" . $away_score_period_3 . "</td> <td>" . $away_score_period_4 . "</td> <td>" . $away_score_period_5 . "</td> <td>" . $away_team_final_score . "</td></tr></tbody></table>";
        echo "</div>";           
									
		display_scorers( $goals_period_1, "1st" , $penalties_period_1 );
		
		display_scorers( $goals_period_2, "2nd" , $penalties_period_2 );
		
		display_scorers( $goals_period_3, "3rd" , $penalties_period_3 );
		
		display_scorers( $goals_period_4, "4th", $penalties_period_4 );
		
		display_scorers( $goals_period_5, "5th" , $penalties_period_5 );
		
		//Shots on goal
		echo "<div style='float:left; width:360px; margin-right:15px;'><h3 class='widget-title'>Shots on Goal</h3><table class='shots_stats_table'><thead> <th></th> <th>1</th> <th>2</th> <th>3</th> <th>O</th> <th>T</th> </thead>" ; 
		//Home			
		echo "<tr class='even'> <td style='text-align:left;'>" . $home_team_city . "</td> <td>" . $home_shots_period_01 . "</td> <td>" . $home_shots_period_02 . "</td> <td>" . $home_shots_period_03 . "</td> <td>" . $home_shots_period_04 . "</td> <td>" . $home_shots_total . "</td> </tr>";
		//Away
		echo "<tr class='odd'> <td style='text-align:left;'>" . $away_team_city . "</td> <td>" . $away_shots_period_01 . "</td> <td>" . $away_shots_period_02 . "</td> <td>" . $away_shots_period_03 . "</td> <td>" . $away_shots_period_04 . "</td> <td>" . $away_shots_total . "</td> </tr>";
				
		echo "</table></div>";
		
		//Goalies
		echo "<div style='float:right; width:240px;'><h3 class='widget-title'>Goalies</h3><table class='goalie_stats_table'><thead> <th>Team</th> <th>Name</th> <th>Shots</th> <th>Saves</th> <th>Min</th></thead>" ; 
		$e = true;
		//Home			
		foreach ($home_goalies as $home_goalie) {
			echo "<tr" . (($e = !$e)?" class='odd'":" class='even'") . "> <td>" . $home_goalie['team'] . "</td> <td>" . $home_goalie['last_name'] . "</td> <td>" . $home_goalie['shots'] . "</td> <td>" . $home_goalie['saves']. "</td> <td>" . $home_goalie['time'] . "</td> </tr>";
		}
		//Away
		foreach ($away_goalies as $away_goalie) {
			echo "<tr" . (($e = !$e)?" class='odd'":" class='even'") . "> <td>" . $away_goalie['team'] . "</td> <td>" . $away_goalie['last_name'] . "</td> <td>" . $away_goalie['shots'] . "</td> <td>" . $away_goalie['saves']. "</td> <td>" . $away_goalie['time'] . "</td> </tr>";
		}
				
		echo "</table></div>";
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