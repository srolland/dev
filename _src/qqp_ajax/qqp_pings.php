<?php


class qqp_pings {
	function qqp_pings() {
		if ( is_admin() ) {
			add_action( 'wp_ajax_qqp_pings', array( &$this, 'qqp_pings_callback' ) );
			add_action( 'wp_ajax_nopriv_qqp_pings', array( &$this, 'qqp_pings_callback' ) );
		}
		add_action( 'init', array(&$this, 'register_script') );
		add_action('wp_footer', array(&$this, 'print_script') );
		
		
		
		
	}

	function register_script() {
		wp_register_script( 'qqp_pings_js', get_template_directory_uri() . '/_js/jquery.qqp_pings.js', null, '1.2', true );
        wp_enqueue_script('jquery');
        wp_enqueue_style( 'qqp_pings_js' );
		wp_localize_script( 'qqp_pings_js', 'qqp_pings_js', array(
		    'ajaxurl' => admin_url( 'admin-ajax.php' ),
		    '_qqp_ping_nonce' => wp_create_nonce( 'qqp_ping_nonce' ),
		    'dico' => array(
		    	'E-000' => __( 'Invalid nonce', 'qqp_theme' ),	
		    	'E-001' => __( 'Generic comment error', 'qqp_theme' ),	    
		    ),
		) );		
	}
	
	function print_script() {
		wp_print_scripts('qqp_pings_js');
	}
	
	function qqp_pings_callback() {
		if ( ! isset( $_REQUEST['_qqp_ping_nonce'] ) || ! wp_verify_nonce( $_REQUEST['_qqp_ping_nonce'], 'qqp_ping_nonce' ) ) {
			//$this->generate_responce( false, array( 'E-000' ) );
		}
		
		
		

		// check the curent action acording the the ping _do
		switch( $_REQUEST['_do'] ) {
			
			
			case 'comment_post':
			
			if ( isset( $_REQUEST['data']['comment_content'] ) && !empty( $_REQUEST['data']['comment_content'] ) && 
				 isset( $_REQUEST['post_id'] ) && !empty( $_REQUEST['post_id'] ) && 
				 comments_open( $_REQUEST['post_id'] ) && is_user_logged_in() ) {

					
					$comment_parent = isset( $_REQUEST['data']['comment_parent'] ) && !empty( $_REQUEST['data']['comment_parent'] ) ? (int) $_REQUEST['data']['comment_parent'] : 0;
					
					
					
					$the_curent_user = wp_get_current_user();
					$time = current_time('mysql');
	
					$new_comment_data = array(
					    'comment_post_ID' => $_REQUEST['post_id'],
					    'comment_author' => $the_curent_user->display_name,
					    'comment_author_email' => $the_curent_user->user_email,
					    'comment_author_url' => $the_curent_user->user_url,
					    'comment_content' => $_REQUEST['data']['comment_content'],
					    'comment_parent' => $comment_parent,
					    'user_id' => $the_curent_user->ID,
					    'comment_date' => $time,
					    'comment_approved' => 1,
					);
					
					
					
					
					
					
					$new_comment = wp_insert_comment( $new_comment_data );
	
					
					
					
					
					$this->generate_responce( true, "Parent: " . $comment_parent );

				} else {
					$this->generate_responce( false, array( 'E-001' ) );
					
				}
				
			
				break;
			
			
			
			
			
			case 'ping':
				$response = array();
				$post_id = isset( $_REQUEST['post_id'] ) && !empty( $_REQUEST['post_id'] ) ? $_REQUEST['post_id'] : false;
				$last_ping_time = isset( $_REQUEST['last_ping_time'] ) && !empty( $_REQUEST['last_ping_time'] ) ? $_REQUEST['last_ping_time'] : 0;
				
				
				if ( $last_ping_time == 0 ) {
					$limt = "DESC LIMIT 100";	
					
				} else {
					
					$limt = "";	
				}
				
				// return new comments since last ping.


				global $wpdb;
				$sql = "
				    SELECT comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date, comment_content, comment_approved, comment_type, comment_parent
				    FROM wp_comments WHERE comment_date > '$last_ping_time' AND comment_post_ID = '" . $_REQUEST['post_id'] . "' AND comment_approved = '1' ORDER BY comment_ID " . $limt;
				$new_comments = $wpdb->get_results($sql);
				$new_comments_output = array();
				//print_r( $new_comments );
				foreach( $new_comments as $n ) {
					$n->comment_content = str_replace("\n", "</p>\n<p>", '<p>'. $n->comment_content . '</p>');
					$new_comments_output[] = $n;
					$response['comments_3'] = $n->comment_content;
					
				}
				
				
				if ( $last_ping_time == 0 ) {
					$new_comments_output = array_reverse($new_comments_output);
				}
				
				
				
				$response['comments'] = $new_comments_output;
					
				
				
				
				
				
				
				
				
				$this->generate_responce( true, $response );
				
				
			
				break;
			
			
			
			
			
			
			default:
			
				$this->generate_responce( true, $_REQUEST );
			
				break;
			
			
		}
		















		
	// Form Validation
		$err_msg = array();
		
		$username = false;
		if ( isset( $_REQUEST['log'] ) && !empty( $_REQUEST['log'] ) ) {
			$username = $_REQUEST['log'];
		} else {
			$err_msg['log'] = 'E-001';
		}
		
		$password = false;
		if ( isset( $_REQUEST['pwd'] ) && !empty( $_REQUEST['pwd'] ) ) {
			$password = $_REQUEST['pwd'];
		} else {
			$err_msg['pwd'] = 'E-002';
		}
		
	}
	
	
	
	function generate_responce( $status, $data ) {
		$status = $status ? 'success' : 'error';
		$did = isset( $_REQUEST['_do'] ) && !empty( $_REQUEST['_do'] ) ? $_REQUEST['_do'] : '';
		$offset = get_option( 'gmt_offset' ) * 3600;
		$time = date_i18n( "Y-m-d H:i:s", ( time() - 15 ) + $offset );
		
		header( "Content-Type: application/json" );
		
		
		
		
		echo json_encode( 
				array( 
					'status' => $status, 
					'did' => $did, 
					'time' => $time,
					'data' => $data,
				) 
			);
		die ();
	}
	
	
	
	
	
	
	function validate_ping_date_format( $date ) {
		
		$string = "10/15/2007";
		if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $string)) { 
		//echo "example 8 successful.";
		} 
		
	}
	
	
}

$qqp_pings = new qqp_pings();


?>