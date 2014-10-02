<?php

/* Load required files
-------------------------------------------------------------------------------------- */	

	require "qqp_cpt/qqp_cpt.php";
	require "qqp_cpt/qqp_cpt_meta.php";
	require "qqp_ajax/qqp_pings.php";
	require "qqp_option/qqp_option.php";
/*
	require "qqp_ctax/qqp_ctax.php";
	require "qqp_ctax/qqp_ctax_meta.php";
	require "qqp_umeta/qqp_umeta.php";
*/



/* This section add all post type and taxonomies required to wordpresss
-------------------------------------------------------------------------------------- */	
	
/* -	Play-By-Play					- */
	// Play-By-Play post type
	$in_the_game_cpt_args = array( 
		'ctp_args' => array (
			'labels' => array( 'name' => _x( 'Play-by-Play' , 'post type general name') ),
			'supports' => array( 'title', 'thumbnail', 'comments' )
		),
		'rewrite' => array(
			'slug' => 'play-by-play',
			'structure' => '/%year%/%monthnum%/%day%'
		),

	);
	$in_the_game_cpt = new qqp_cpt( "qqp_in_the_game", 'Play-by-Play', $in_the_game_cpt_args );

	

	// Play-By-Play meta boxes
	$in_the_game_meta_arg_1 = array(
/* 		array( 'name' => 'wp_editor' ), */

		array( 'name' => 'onetwosee_date', 'label' => 'OneTwoSee Date', 'description' => 'ei: AAAA-MM-DD' ),
		array( 'name' => 'scribblelive_id', 'label' => 'ScribbleLive ID', 'description' => 'ei: http://embed.scribblelive.com/Embed/v5.aspx?Id=<strong style="font-size:1.1em;color:orange;">80829</strong>&ThemeId=3281' ),
		array( 'name' => 'comments_post_id', 'label' => 'Comments Post ID', 'description' => 'The post ID of the comments you want troll (leave empty to use this post\'s comments)', 'type' => 'hidden' ),
		
		
/* 		array( 'name' => 'onetwosee_url', 'label' => 'OneTwoSee URL', 'description' => 'ei: http://nhl.onetwosee.com/broadcaster/montrealgazette/team/mtl/date/aaaa-MM-DD' ), */
/* 		array( 'name' => 'scribblelive_url', 'label' => 'ScribbleLive URL', 'description' => 'ei: http://embed.scribblelive.com/Embed/v5.aspx?Id=80829&ThemeId=3281' ), */
	);
	$in_the_game_meta_1 = new qqp_cpt_meta( 'qqp_in_the_game_meta_box_1', 'Configuration', array( 'qqp_in_the_game' ), $in_the_game_meta_arg_1 );
	
	$in_the_game_meta_arg_2 = array(
		array( 'name' => 'concent_pre_game_title', 'label' => 'Title'  ),
/* 		array( 'name' => 'concent_pre_game_content', 'label' => 'Content', 'type' => 'textarea' ), */
		array( 'name' => 'concentpregamecontent', 'label' => 'Content', 'type' => 'wp_editor' ),
		
	);
	$in_the_game_meta_2 = new qqp_cpt_meta( 'qqp_in_the_game_meta_box_2', 'Pre-game', array( 'qqp_in_the_game' ), $in_the_game_meta_arg_2 );
	
	$in_the_game_meta_arg_3 = array(
		array( 'name' => 'concent_p1_title', 'label' => 'Title'  ),
/* 		array( 'name' => 'concent_p1_content', 'label' => 'Content', 'type' => 'textarea' ), */
		array( 'name' => 'concentp1content', 'label' => 'Content', 'type' => 'wp_editor' ),
	);
	$in_the_game_meta_3 = new qqp_cpt_meta( 'qqp_in_the_game_meta_box_3', '1st period', array( 'qqp_in_the_game' ), $in_the_game_meta_arg_3 );
	
	$in_the_game_meta_arg_4 = array(
		array( 'name' => 'concent_p2_title', 'label' => 'Title'  ),
/* 		array( 'name' => 'concent_p2_content', 'label' => 'Content', 'type' => 'textarea' ), */
		array( 'name' => 'concentp2content', 'label' => 'Content', 'type' => 'wp_editor' ),
	);
	$in_the_game_meta_4 = new qqp_cpt_meta( 'qqp_in_the_game_meta_box_4', '2nd period', array( 'qqp_in_the_game' ), $in_the_game_meta_arg_4 );
	
	$in_the_game_meta_arg_5 = array(
		array( 'name' => 'concent_p3_title', 'label' => 'Title'  ),
/* 		array( 'name' => 'concent_p3_content', 'label' => 'Content', 'type' => 'textarea' ), */
		array( 'name' => 'concentp3content', 'label' => 'Content', 'type' => 'wp_editor' ),
	);
	$in_the_game_meta_5 = new qqp_cpt_meta( 'qqp_in_the_game_meta_box_5', '3st period', array( 'qqp_in_the_game' ), $in_the_game_meta_arg_5 );
	
	
	$in_the_game_meta_arg_6 = array(
		array( 'name' => 'concent_overtime_title', 'label' => 'Title'  ),
/* 		array( 'name' => 'concent_overtime_content', 'label' => 'Content', 'type' => 'textarea' ), */
		array( 'name' => 'concentovertimecontent', 'label' => 'Content', 'type' => 'wp_editor' ),
	);
	$in_the_game_meta_6 = new qqp_cpt_meta( 'qqp_in_the_game_meta_box_6', 'Overtime / Shootout', array( 'qqp_in_the_game' ), $in_the_game_meta_arg_6 );
	
	$in_the_game_meta_arg_7 = array(
		array( 'name' => 'concent_post_game_title', 'label' => 'Title'  ),
/* 		array( 'name' => 'concent_post_game_content', 'label' => 'Content', 'type' => 'textarea' ), */
		array( 'name' => 'concentpostgamecontent', 'label' => 'Content', 'type' => 'wp_editor' ),
	);
	$in_the_game_meta_7 = new qqp_cpt_meta( 'qqp_in_the_game_meta_box_7', 'Post-game', array( 'qqp_in_the_game' ), $in_the_game_meta_arg_7 );
	
	
	
	
	
	
	
	
	
	// Post meta boxes
	$post_meta_arg_1 = array(
/* 		array( 'name' => 'wp_editor' ), */
		//array( 'name' => 'onetwosee_date', 'label' => 'OneTwoSee Date', 'description' => 'ei: aaaa-MM-DD' ),
		//array( 'name' => 'scribblelive_id', 'label' => 'ScribbleLive ID', 'description' => 'ei: 80829' ),
		array( 'name' => 'qqp_in_the_game_id', 'label' => 'Play-By-Play Post ID', 'description' => 'ei: 80829' ),
	);
	$post_meta_1 = new qqp_cpt_meta( 'post_qqp_in_the_game_meta_box_1', 'Play-By-Play Settings', array( 'post' ), $post_meta_arg_1 );






	







	



	function sync_qqp_in_the_game_with_post( $post_id ) {
		$p = get_post( $post_id );
		//print_r( $p );
		if ( isset( $p->post_type ) && $p->post_type == 'qqp_in_the_game' ) {
			$p_meta = get_post_custom( $p->ID );
			
			$post_status = isset( $p->post_status ) && !empty( $p->post_status ) ? $p->post_status : 'draft';
			$post_title = isset( $p->post_title ) && !empty( $p->post_title ) ? $p->post_title : '';
			$post_content = isset( $p_meta['concentpregamecontent'] ) && !empty( $p_meta['concentpregamecontent'] ) ? $p_meta['concentpregamecontent'][0] : '';
			
			
			
			if ( isset( $p_meta['comments_post_id'] ) && !empty( $p_meta['comments_post_id'] ) ) {

				$op = get_post( intval( $p_meta['comments_post_id'][0] ) );
				$np_args = array(
				  'ID'			  => $p_meta['comments_post_id'][0],
				  'post_title'    => 'Liveblog: ' . $post_title,
				  'post_date'     => $p->post_date,
				  'post_content'  => $post_content,
				  'post_status'   => $post_status,
				);
				
				
				$np = wp_update_post( $np_args );
				
				
		
				update_post_meta( $np, 'qqp_in_the_game_id', $p->ID );
				
				
				if ( isset( $p_meta['_thumbnail_id'] ) && !empty( $p_meta['_thumbnail_id'] ) ) {
					update_post_meta( $p_meta['comments_post_id'][0], '_thumbnail_id', $p_meta['_thumbnail_id'][0] );
				}
				
				if ( isset( $p_meta['scribblelive_id'] ) && !empty( $p_meta['scribblelive_id'] ) ) {
						update_post_meta(  $p_meta['comments_post_id'][0], 'ScribbleLiveId', $p_meta['scribblelive_id'][0] );
						update_post_meta(  $p_meta['comments_post_id'][0], 'LiveblogEmbedCode', "<iframe src='http://embed.scribblelive.com/Embed/v5.aspx?Id=" . $p_meta['scribblelive_id'][0] . "&ThemeId=7873' width='400' height='300' frameborder='0' style='border: 1px solid #000'></iframe>" );

					}

				
	/*
			var_dump( $np_args );
				echo( "<br><br>" );
				
				
*/
				//die('<br><br>have post');
			} else {
			
				// create post only it it's a non auto generated post
				if ( isset( $_REQUEST['user_ID'] ) && !empty( $_REQUEST['user_ID'] ) ) {
					
					if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
						return $post_id;
		    		}
					
					

					$np_args = array(
					  'post_title'    => 'Liveblog: ' . $post_title,
					  'post_type'     => 'post',
					  'post_date'     => $p->post_date,
					  'post_content'  => $post_content,
					  'post_status'   => $post_status,
					  'post_author'   => $_REQUEST['user_ID'],
					  'post_category' => array( 124 )
					);
					$np = wp_insert_post( $np_args );
					
					update_post_meta( $p->ID, 'comments_post_id', $np );
					update_post_meta( $np, 'qqp_in_the_game_id', $p->ID );
					
					if ( isset( $p_meta['_thumbnail_id'] ) && !empty( $p_meta['_thumbnail_id'] ) ) {
						update_post_meta( $np, '_thumbnail_id', $p_meta['_thumbnail_id'][0] );
					}
					
					if ( isset( $p_meta['scribblelive_id'] ) && !empty( $p_meta['scribblelive_id'] ) ) {
						update_post_meta( $np, 'ScribbleLiveId', $p_meta['scribblelive_id'][0] );
						update_post_meta( $np, 'LiveblogEmbedCode', "<iframe src='http://embed.scribblelive.com/Embed/v5.aspx?Id=" . $p_meta['scribblelive_id'][0] . "&ThemeId=7873' width='400' height='300' frameborder='0' style='border: 1px solid #000'></iframe>" );

					}
					
					
					
					
		/*
			var_dump( $_REQUEST );
				echo( "<br><br>" );
						
					var_dump( $np_args );
					echo( "<br><br>" );
				


					die('create new poast that post ... i think');
*/
				}
				//die('no post');
			}
			
			
			

		
		
		
		
		
				
		
		
		
		
		
		
		
		
		}	
		
	}
	
	add_action( 'save_post', 'sync_qqp_in_the_game_with_post' );








	
	
?>