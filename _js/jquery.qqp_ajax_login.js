






































































/* AJAX LOGIN and USER INIT
-------------------------------------------------------------------------------------- */	

	var qqp_user_init = function() {
		if ( typeof qqp_data['user'] === "undefined" ) {
			//alert('not logeged')
		} else {

			var $user_option_box = jQuery( '.user_option_box' ),
				$user_util_box = jQuery( '.user_util_box', $user_option_box );
			
			$user_option_box.css( 'display', 'none' );
			$user_util_box.css( 'display', 'block' );
			
			jQuery( '.link', $user_util_box ).click(function() {
				//TODO go to link on click
				
			});
		}
	}
				
	qqp_user_init();				
						
	jQuery( '.user_box' ).each( function() {				
		var $this = jQuery( this ),
			$toggle_btn = jQuery( '.user_toggle_btn_box', $this ),
			$user_option_box = jQuery( '.user_option_box', $this ),
			$form_login = jQuery( '.user_login_form', $this );
			$login_btn = jQuery( '.user_login_form_submit_btn_box', $this );
			
			
			$toggle_btn.click( function() {
				$user_option_box.animate( { width: 'toggle' } , 100);
			});
			
			$login_btn.click( function() {
				if ( ! $login_btn.hasClass( 'disabled' ) ) {
					$user_name = jQuery( '#log', $this ),
					$password = jQuery( '#pwd', $this );
					
					if ( $user_name.val() == '' || $password.val() == '' ) {
						if ( $user_name.val() == '' ) { $user_name.addClass( 'error' ); }
						if ( $password.val() == '' ) { $password.addClass( 'error' ); }
					} else {
						// submit the form
						$login_btn.addClass( 'disabled' );
						qqp_send_login_request( $form_login );
					}
				}
			});			
	});					

	var qqp_send_login_request = function( $form ) {
		var $submit_btn = jQuery( '.user_login_form_submit_btn_box', $form ),
			$user_name = jQuery( '#log', $form ),
			$password = jQuery( '#pwd', $form );
			
		$user_name.removeClass( 'error' );
		$password.removeClass( 'error' );
			
		var form_data = $form.serialize();
		jQuery.ajax({
			url: qqp_ajax_login_js.ajaxurl,
			datatype: 'json', 
			data: form_data,
			success: function(data, textStatus, jqXHR) {
				//console.log(data)
				if ( data.status == 'error' ) {
					$submit_btn.removeClass( 'disabled' );
					for( var ii in data.msg ) {
						jQuery( '#' + ii , $form ).addClass( 'error' );
					}
				}
				if ( data.status == 'success' ) {
					
					if ( typeof data.data.user === "undefined" ) {
						
					} else {
						qqp_data['user'] = data.data.user;
						$toggle_btn.addClass( 'login' );
						$form.parents( '.user_option_box' ).animate( { width: 'hide' } , 100, function() {
							$form.parents( '.user_login_form_box' ).remove();
							qqp_user_init();
						});
					}					
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {  }
		});
			
	}
	
	
	
	
	
	
