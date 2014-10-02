<?php

class qqp_ajax_login {
	function qqp_ajax_login() {
		if ( is_admin() ) {
			add_action( 'wp_ajax_qqp_ajax_login', array( &$this, 'qqp_ajax_login_callback' ) );
			add_action( 'wp_ajax_nopriv_qqp_ajax_login', array( &$this, 'qqp_ajax_login_callback' ) );
		}
		add_action( 'init', array(&$this, 'register_script') );
		add_action('wp_footer', array(&$this, 'print_script') );
	}

	function register_script() {
		wp_register_script( 'qqp_ajax_login_js', get_template_directory_uri() . '/_js/jquery.qqp_ajax_login.js', null, false, true );
        wp_enqueue_script('jquery');
        wp_enqueue_style( 'qqp_ajax_login_js' );
		wp_localize_script( 'jquery', 'qqp_ajax_login_js', array(
		    'ajaxurl' => admin_url( 'admin-ajax.php' ),
		    'dico' => array(
		    	'E-000' => __( 'Invalid nonce', 'qqp_theme' ),
		    	'E-001' => __( 'Invalid username', 'qqp_theme' ),
		    	'E-002' => __( 'Invalid password', 'qqp_theme' ),		    
		    ),
		) );
	}
	
	function print_script() {
		wp_print_scripts('qqp_ajax_login_js');
	}

	function qqp_ajax_login_callback() {
		header( "Content-Type: application/json" );
		if ( ! isset( $_REQUEST['_qqp_ajax_login_nonce'] ) || ! wp_verify_nonce( $_REQUEST['_qqp_ajax_login_nonce'], 'qqp_ajax_login_nonce' ) ) {
			die ( json_encode( array( 'status' => 'error', 'msg' => 'E-000' ) ) );
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
		
				
	// Try to login the user and return the result
		if ( empty( $err_msg ) ) {
		
			$creds = array(
				'user_login' => $username,
				'user_password' => $password,
				'remember' => true
			);

			$user = wp_signon( $creds, false );
			if ( is_wp_error( $user ) ) {
				if ( isset( $user->errors['invalid_username'] ) ) {
					$err_msg['log'] = 'E-001';
				}
				if ( isset( $user->errors['incorrect_password'] ) ) {
					$err_msg['pwd'] = 'E-002';
				}
			} else {
				unset( $user->data->user_pass );
				echo json_encode( array( 'status' => 'success', 'data' => array( 'user' => $user->data ) ) );
				die;
			}   
   
		}
		
		echo json_encode( array( 'status' => 'error', 'msg' => $err_msg ) );
		die;

	}

}

$qqp_ajax_login = new qqp_ajax_login();

?>