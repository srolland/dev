<?php
/*
Template Name: User Profile
*/
?>
<?php get_header(); ?>

			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed">
			<?php
					//$thisauthor = get_userdata(intval($author));
					$url_segments = explode("/",$_SERVER["REQUEST_URI"]); 
    				$user_int = $url_segments[2];
					$thisauthor = get_userdata(intval($user_int));
					
					$user_full_name = get_user_meta( intval($user_int), 'full_name',true);
					$user_fan_since = get_user_meta( intval($user_int), 'habs_fan_since',true);
					$user_fav_current = get_user_meta( intval($user_int), 'favourite_player_current',true);
					$user_fav_alltime = get_user_meta( intval($user_int), 'favourite_player_alltime',true);
					$user_city = get_user_meta( intval($user_int), 'city',true);
					$user_sig = get_user_meta( intval($user_int), 'signature',true);
					
					//Reformat date the user joined:
					$join_timestamp = strtotime($thisauthor->user_registered);
					$newdate = date("F j, Y", $join_timestamp);
					
	
				?>
                
				<div style="float: right;">
				<?php if(function_exists('get_avatar')) { echo get_avatar($thisauthor->user_email, 96, "" ); } ?> </div>
				
				<h1><?php echo $thisauthor->display_name; if ($user_full_name != "" && $user_full_name != $thisauthor->display_name){ echo " - (" .$user_full_name . ")";} ?></h1>
                <?php echo "Member since ". $newdate; ?><br/><br/>
                
                <?php if ($user_city != "") {  echo $user_city . "<br/>"; } ?>
				<?php if ($thisauthor->user_url != "") {  echo "<a href=" . $thisauthor->user_url . ">" . $thisauthor->user_url . "</a><br/><br/>"; } ?>
                
				
                <p>
				<?php  echo "<strong>Habs fan since: </strong>" . $user_fan_since; ?><br/>
                <?php  echo "<strong>Favorite current player: </strong>" . $user_fav_current; ?><br/>
                <?php  echo "<strong>All-time favorite player: </strong>" . $user_fav_alltime; ?></p>
                
                <p><?php echo "<strong>Signature:</strong><br/>" . $user_sig; ?></p>
                
                
			
				
				
				<?php 
					// WP_Comment_Query arguments
					$comment_args = array (
						'status'         => 'approve',
						'user_id'        => $thisauthor->ID,
						'number'         => '10'
					);
					
					// The Comment Query
					$user_comment_query = new WP_Comment_Query;
					$user_comments = $user_comment_query->query( $comment_args );
					
					// The Comment Loop	
					if ( $user_comments ) { ?>
					<h3>Recent Comments </h3>
						<ul>
					<?php	
						
foreach ( $user_comments as $comment ) {  		

								//setup_postdata($comment);
								echo "<li><a href='". get_bloginfo('url') ."/?p=".$comment->comment_post_ID."/#comment-". $comment->comment_ID ."'>Comment on ". get_the_title($comment->comment_post_ID) ." (" . $comment->comment_date .")</a><br/>". $comment->comment_content ."</li>";
							
								}

					?>
							</ul>
				<?php	
					} else {
						echo 'No comments found.';
					}
									
				?>
				
				
				
				
			
			<!--END #primary .hfeed-->
			</div>
			
<?php get_sidebar(); ?>

<?php get_footer(); ?>