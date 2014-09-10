<?php
/*
Template Name: Standings
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
							$team_key = $team->team_key;
							$team_name = $team->first_name;
							
							if ($team_name == 'New York') {
								$team_name = "NY " . $team->last_name;
							}
							$team_names[$team_key] = $team_name;
						}

						$standings = file_get_contents('http://apps.hockeyinsideout.com/standings');
						$standings_array = json_decode( $standings, true );
						
						$standings = $standings_array[standings];
										
						$atlantic_standings = array();
						$northeast_standings = array();
						$southeast_standings = array();
						$central_standings = array();
						$northwest_standings = array();
						$pacific_standings = array();
						
						$atlantic_division_teams = "";
						$northeast_division_teams = "";
						$southeast_division_teams = "";
						$central_division_teams = "";
						$northwest_division_teams = "";
						$pacific_division_teams = "";
						
						$eastern_conference_standings = array();
						$western_conference_standings = array();
						
						foreach ( $standings as $standing ) {
							if ( $standing[type] == 'division' && $standing[name] == 'Atlantic Division' ) {
									$atlantic_division_teams = $standing[teams];		
							}
							if ( $standing[type] == 'division' && $standing[name] == 'Northeast Division' ) {
									$northeast_division_teams = $standing[teams];
							}
							if ( $standing[type] == 'division' && $standing[name] == 'Southeast Division' ) {
									$southeast_division_teams = $standing[teams];
							}
							if ( $standing[type] == 'division' && $standing[name] == 'Central Division' ) {
									$central_division_teams = $standing[teams];
							}
							if ( $standing[type] == 'division' && $standing[name] == 'Northwest Division' ) {
									$northwest_division_teams = $standing[teams];
							}
							if ( $standing[type] == 'division' && $standing[name] == 'Pacific Division' ) {
									$pacific_division_teams = $standing[teams];
							}	
							if ( $standing[type] == 'conference' && $standing[name] == 'Eastern Conference' ) {
									$eastern_conference_standings = $standing[teams];
							}
							if ( $standing[type] == 'conference' && $standing[name] == 'Western Conference' ) {
									$western_conference_standings = $standing[teams];
							}
						}
						
						
						//Division Standings
						foreach ( $atlantic_division_teams as $team ) {
										$team_listing = array( 'losses' => $team[losses], 'games_played' => $team['events-played'], 'wins' => $team[wins], 'id' => $team[id], 'points' => $team['standing-points'], 'gf' => $team['points-scored-for'], 'ga' => $team['points-scored-against'], 'overtime' => $team['losses-overtime'], 'rank' => $team['rank']  );
										$team_listing[name] = $team_names[$team[id]];
										$atlantic_standings[] = $team_listing;
						}
						foreach ( $northeast_division_teams as $team ) {
										$team_listing = array( 'losses' => $team[losses], 'games_played' => $team['events-played'], 'wins' => $team[wins], 'id' => $team[id], 'points' => $team['standing-points'], 'gf' => $team['points-scored-for'], 'ga' => $team['points-scored-against'], 'overtime' => $team['losses-overtime'], 'rank' => $team['rank']   );
										$team_listing[name] = $team_names[$team[id]];
										$northeast_standings[] = $team_listing;
						}
						foreach ( $southeast_division_teams as $team ) {
										$team_listing = array( 'losses' => $team[losses], 'games_played' => $team['events-played'], 'wins' => $team[wins], 'id' => $team[id], 'points' => $team['standing-points'], 'gf' => $team['points-scored-for'], 'ga' => $team['points-scored-against'], 'overtime' => $team['losses-overtime'], 'rank' => $team['rank']  );
										$team_listing[name] = $team_names[$team[id]];
										$southeast_standings[] = $team_listing;
						}
						foreach ( $central_division_teams as $team ) {
										$team_listing = array( 'losses' => $team[losses], 'games_played' => $team['events-played'], 'wins' => $team[wins], 'id' => $team[id], 'points' => $team['standing-points'], 'gf' => $team['points-scored-for'], 'ga' => $team['points-scored-against'], 'overtime' => $team['losses-overtime'], 'rank' => $team['rank']  );
										$team_listing[name] = $team_names[$team[id]];
										$central_standings[] = $team_listing;
						}
						foreach ( $northwest_division_teams as $team ) {
										$team_listing = array( 'losses' => $team[losses], 'games_played' => $team['events-played'], 'wins' => $team[wins], 'id' => $team[id], 'points' => $team['standing-points'], 'gf' => $team['points-scored-for'], 'ga' => $team['points-scored-against'], 'overtime' => $team['losses-overtime'], 'rank' => $team['rank']  );
										$team_listing[name] = $team_names[$team[id]];
										$northwest_standings[] = $team_listing;
						}
						foreach ( $pacific_division_teams as $team ) {
										$team_listing = array( 'losses' => $team[losses], 'games_played' => $team['events-played'], 'wins' => $team[wins], 'id' => $team[id], 'points' => $team['standing-points'], 'gf' => $team['points-scored-for'], 'ga' => $team['points-scored-against'], 'overtime' => $team['losses-overtime'], 'rank' => $team['rank']  );
										$team_listing[name] = $team_names[$team[id]];
										$pacific_standings[] = $team_listing;
						}
						
						//Conference Standings
						foreach ( $eastern_conference_standings as $team ) {
										$team_listing = array( 'losses' => $team[losses], 'games_played' => $team['events-played'], 'wins' => $team[wins], 'id' => $team[id], 'points' => $team['standing-points'], 'gf' => $team['points-scored-for'], 'ga' => $team['points-scored-against'], 'overtime' => $team['losses-overtime'], 'rank' => $team['rank']  );
										$team_listing[name] = $team_names[$team[id]];
										$eastern_standings[] = $team_listing;
						}
						foreach ( $western_conference_standings as $team ) {
										$team_listing = array( 'losses' => $team[losses], 'games_played' => $team['events-played'], 'wins' => $team[wins], 'id' => $team[id], 'points' => $team['standing-points'], 'gf' => $team['points-scored-for'], 'ga' => $team['points-scored-against'], 'overtime' => $team['losses-overtime'], 'rank' => $team['rank']  );
										$team_listing[name] = $team_names[$team[id]];
										$western_standings[] = $team_listing;
						}
						
						
						
						
						function display_standings ( &$division_teams, $division_name ) {
							
								//echo "<h3 class='widget-title'>" . $division_name . "</h3> " ; 
								
								echo "<table class='stats_table'><thead> <th align='left' style='text-align:left;' colspan='2'>" . strtoupper($division_name) . " </th><th align='left' style='text-align:left;'> GP </th> <th align='left'  style='text-align:left;'> W</th><th align='left' style='text-align:left;'>L</th><th align='left' style='text-align:left;'>OT</th><th align='left' style='text-align:left;'>PTS</th><th align='left' style='text-align:left;'>GF</th><th align='left' style='text-align:left;'>GA</th></thead> <tbody>" ; 
								//global $atlantic_standings;
								$c = true;
								
								foreach( $division_teams as $team ){
									echo "<tr " . (($c = !$c)?" class='odd ":" class='even ") . "  " . (($team[name] == "Montreal")? " mtl'": " '") . "> <td width='20' align='center'>" . $team[rank] . "</td> <td width='175'>" . $team[name] . "</td> <td>" . $team[games_played] . "</td> <td>" . $team[wins] . "</td> <td>" . $team[losses] . "</td>  <td>" . $team[overtime] . "</td> <td>" . $team[points] . "</td> <td>" . $team[gf] . "</td> <td>" . $team[ga] . "</td></tr>";	
								}
								echo "</tbody></table>";		
						}
						
						/*echo "<script type='text/javascript' src='/js/tabber.js'></script><link rel='stylesheet' href='/css/example.css' TYPE='text/css'>";*/
						echo "<div id='tabber_widget-6' class='widget tabber_widget' style='background:none;'><div id='tabber_widget-6-content' class='tabber-widget-0 tabber-widget-basic-light' style='background:none; padding:0;'>
		<ul class='tabber-widget-tabs' style='display:block;width:230px; margin:0 auto 50px auto!important;'>
											<li style='width:110px;text-align:center;border:1px solid #E8E8E8;'><a class='selected' href='#tab-tabber_widget-6-1'>Division</a></li>
											<li style='width:110px;text-align:center;border:1px solid #E8E8E8;'><a href='#tab-tabber_widget-6-2' style=''>Conference</a></li>
											
					</ul>
					<div id='tab-tabber_widget-6-1' class='tabber-widget-content' style='background:none; padding:0;'>";
						echo "<h3 class='widget-title'>Eastern Conference</h3> " ;
						
						display_standings( $northeast_standings, 'northeast' );
						
						display_standings( $atlantic_standings, 'atlantic' );
						
						display_standings( $southeast_standings, 'southeast' );
						
						echo "<br/><h3 class='widget-title'>Western Conference</h3> " ;
						display_standings( $central_standings, 'central' );
						
						display_standings( $northwest_standings, 'northwest' );
						
						display_standings( $pacific_standings, 'pacific' );
						
						echo "</div><div id='tab-tabber_widget-6-2' class='tabber-widget-content' style='background:none; padding:0;'>";
						echo "<h3 class='widget-title'>Eastern Conference</h3>" ;
						display_standings( $eastern_standings, '' );
						
						echo "<br/><h3 class='widget-title'>Western Conference</h3> " ;
						display_standings( $western_standings, '' );
						
						echo "</div></div></div>";
						
					?>
 
 					<script type="text/javascript">
						jQuery("#tabber_widget-6-content ul").idTabs();
					</script>
                    
                    
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