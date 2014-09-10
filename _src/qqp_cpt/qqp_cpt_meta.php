<?php

// qqp_meta_field_generator :: Generate fields for custom post type
$qqp_cpt_meta_global = array();
class qqp_cpt_meta {
	function qqp_cpt_meta( $name, $title, $post_type = array( 'post' ), $fields = array() ) {
		$this->name = $name;
		$this->title = $title;
		$this->post_type = $post_type;
		$this->fields = $fields;
		
		$this->inject_datepicker_js = false;
		$this->inject_timepicker_js = false;
		$this->inject_image_js = false;

		add_action( 'add_meta_boxes', array(&$this, 'add_custom_metabox'), 0 );
		add_action( 'save_post', array(&$this, 'save_custom_meta') );
		add_filter('attachment_fields_to_edit', array(&$this, 'add_attachment_fields'), 12, 2 );
		add_action( 'admin_head-media-upload-popup', array(&$this, 'add_images_gallery_js_functions' ) );
		
		
	}
	
	function set_global_value( $name = '', $val = '' ) {
		global $qqp_cpt_meta_global;
		if ( !empty( $name ) ) {
			$qqp_cpt_meta_global[$name] = $val;
		}
	}
	
	function get_global_value( $name = '' ) {
		global $qqp_cpt_meta_global;
		$output = NULL;
		if ( !empty( $name ) && isset( $qqp_cpt_meta_global[$name] ) ) {
			$output =  $qqp_cpt_meta_global[$name];
		}
		return $output;
	}
	
	function add_custom_metabox() {
		global $_wp_post_type_features;
		// check id editor was defined, if so, remove the orriginal one.
		$remove_orr_editor = $this->find_in_aray( $this->fields, 'name', 'wp_editor');

		foreach ( $this->post_type as $post_type ) {
			if ( $remove_orr_editor ) {
				unset($_wp_post_type_features[$post_type]['editor']);
			}
		
			add_meta_box( 
				$this->name, 
				__( $this->title ), 
				array(&$this, 'generate_metabox'), 
				$post_type, 
				'normal', 
				'high', 
				$this->fields
			);
		}
	}
	
	
	function find_in_aray( $array, $key, $val ) {
	    foreach ( $array as $item ) {
		    	if ( is_array( $item ) ) {
		    		if ( $this->find_in_aray( $item, $key, $val ) ) {
			    		return true;
			    	}
		    	} else {
			    	if ( $item == $val ) {
			            return true;
			        }
		    	}
	    	}
	    return false;
	}
	
	
	
		
	function generate_metabox( $post, $args ) {
	
		$data = get_post_custom( $post->ID );
		$this->post_id = $post->ID;
		echo '<input type="hidden" name="' .$this->name .  '_noncename" id="' .$this->name .  '_noncename" value="' . wp_create_nonce( $this->name .'_nonce' ) . '" />';
	
		foreach( $this->fields as $field ) {
			
			if ( $field['name'] == 'wp_editor' ) {
				wp_editor( $post->post_content, 'content' );
			} else {
				$default = array(
							'type' => 'text',
							'name' => '',
							'label' => '',
							'value' => '',
							'default' => '',
							'description' => ''
						);
						
				$field = $this->extend( $default, $field );
				
				if ( isset( $data[$field['name']] ) ) {
					$val = array( 'value' => $data[$field['name']][0] );
				} else {
					$val = array( 'value' => $field['default'] );
				}
				$field = $this->extend( $field, $val );
				
				
				
				if ( $field['type'] == 'wp_editor' ) {
					
					wp_editor( $field['value'], $field['name'] );
					
				} else {
					
					
					
					$f = $this->generate_field( $field );
					echo $f;
					
				}
				
				
				
			}
		}
		add_action('admin_footer', array(&$this, 'admin_footer') ); 
	}
	
	
	function save_custom_meta( $post_id ) {
	    if ( !empty( $_POST ) ) {
	    
	    	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		    	return $post_id;
		    }
		    
		    if ( !empty( $_POST[ $this->name .'_noncename'] ) ) {
		    
		    	if ( !wp_verify_nonce( $_POST[ $this->name .'_noncename'], $this->name .'_nonce' ) ) {
			    	return $post_id;
			  	}
	
			    foreach( $this->fields as $field ) {
					if ( !empty( $_POST[$field['name']] ) ) {
						update_post_meta( $post_id, $field['name'], $_POST[$field['name']] );
					} else {
						delete_post_meta( $post_id, $field['name'] );
					}
				}	
			}
	    }
	}
	
	
	function generate_field( $args = array() ) {
	
		$result = '';
		
		switch( $args['type'] ) {
			
			case 'gallery':
				$result = '<div id="' . $this->name . '_' . $args['name'] . '" class="field field-gallery">';
				$result .= '<div  style="float: right;"><input type="button" class="image-gallery-button button" value="' . __( 'Manage images' ) . '"></div>';
				$result .= $args['description'] ? '<div style="cursor: pointer; margin: 0 0 10px 0;"><span class="description image-gallery-button">' . $args['description'] . '</span></div>' : '';
				
				$args = array(
					'numberposts' => -1,
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'post_mime_type' => 'image',
					'post_parent' => $this->post_id,
					'post_status' => null,
					'post_type' => 'attachment'
				);
				
				$gallery_images = get_children( $args );
				if ( $gallery_images ) {
					
					$result .= '<div class="input">';
					foreach( $gallery_images as $images )  {
						$result .= '<div class="image-gallery-thumbnail" style="float: left; width: 150px; height:150px; background-color:#fff; text-align:center; line-height: 150px ; margin:0 10px 10px 0;">';
						$img = wp_get_attachment_image_src( $images->ID , 'thumbnail' );
						$result .= $img['0'] ? '<img src="' . $img['0']	 . '" />' : '';
						$result .= '</div>';
					}
					$result .= '</div>';
				} else {
					$result .= '<div class="input"></div>';
				}
							
				$result .= '<div style="clear:both;"></div>';
				$result .= '</div>';
				$this->inject_image_js = true;
				break;			
			
			case 'image':
				$result = '<div id="' . $this->name . '_' . $args['name'] . '" class="field field-image">';
				$result .= '<p class="label">';
				$result .= '<label for="' . $args['name'] . '">' . $args['label'] . '</label>';
				$result .= '</p>';
				$result .= '<p class="input">';
				$result .= '<div class="image-thumbnail" style="width: 150px; height:150px; background-color:#fff; text-align:center; line-height: 150px ;cursor: pointer;">';
				
				$thumb = wp_get_attachment_image_src( $args['value'] , 'thumbnail' );
				
				
				$result .= $thumb['0'] ? '<img src="' . $thumb['0']	 . '" />' : __( 'Add an image' );
				
				$result .= '</div>';
				$result .= '<input type="hidden" name="' . $args['name'] . '" id="' .$args['name']. '" value="' . $args['value'] . '" class="image imagefield"/>';
				$result .= $args['description'] ? ' <span class="description">' . $args['description'] . '</span>' : '';
				$result .= '</p>';
				$result .= '</div>';
				$this->inject_image_js = true;
				break;

			case 'checkbox':
				$result = '<div id="' . $this->name . '_' . $args['name'] . '" class="field field-checkbox">';
				$result .= '<p class="label">';
				$result .= '<label for="' . $args['name'] . '">' . $args['label'] . '</label>';
				$result .= '</p>';
				$result .= '<p class="input">';
				$checked = $args['value'] ? ' checked="checked" ' : '';
				$result .= '<input type="checkbox" name="' . $args['name'] . '" id="' .$args['name']. '" value="true" ' . $checked . '/>';
				$result .= $args['description'] ? ' <span class="description">' . $args['description'] . '</span>' : '';
				$result .= '</p>';
				$result .= '</div>';
				break;

			case 'timepicker':
				$h = '0';
				$m = '00';
				if ( !empty( $args['value'] ) ) {
					$time = explode( ':', $args['value'] );
					if ( count( $time ) == 2 ) {
						$h = $time[0];
						$m = $time[1];	
					}
				}
				
				$result = '<div id="' . $this->name . '_' . $args['name'] . '" class="field field-time">';
				$result .= '<p class="label">';
				$result .= '<label for="' . $args['name'] . '">' . $args['label'] . '</label>';
				$result .= '</p>';
				$result .= '<p class="input">';
				// Hours
				$result .= '<select name="' . $args['name'] . '_h" id="' . $args['name'] . '_h" class="select select-hour hour">';
				for( $xx = 0; $xx < 24; $xx ++ ) {
					$selected = ( $xx == $h ) ? ' selected="selected" ' : '';
					$result .= '<option value="' . $xx . '" ' . $selected . '>' .  $xx . '</option>';
				}
				$result .= '</select>';
				
				$result .= ' : ';
				// Minutes
				$result .= '<select name="' . $args['name'] . '_m" id="' . $args['name'] . '_m" class="select select-minute minute">';
				for( $yy = 0; $yy < 60; $yy ++ ) {
					$fyy = $yy < 10 ? '0' . $yy : $yy;
					$selected = ( $fyy == $m ) ? ' selected="selected" ' : '';
					$result .= '<option value="' . $fyy . '" ' . $selected . '>' .  $fyy . '</option>';
				}
				$result .= '</select>';
				
				$result .= '<input type="hidden" name="' . $args['name'] . '" id="' . $args['name'] . '" value="' . $h . ':' . $m . '" class="time timepicker" />';
				$result .= '</p>';
				$result .= $args['description'] ? '<p class="description">' . $args['description'] . '</p>' : '';
				$result .= '</div>';
				$this->inject_timepicker_js = true;
				break;
				
				
		
			case 'datepicker':
				$result = '<div id="' . $this->name . '_' . $args['name'] . '" class="field field-date">';
				$result .= '<p class="label">';
				$result .= '<label for="' . $args['name'] . '">' . $args['label'] . '</label>';
				$result .= '</p>';
				$result .= '<p class="input">';
				$result .= '<input type="text" name="' . $args['name'] . '" id="' . $args['name'] . '" value="' . $args['value'] . '" class="date datepicker" readonly="readonly" />';
				$result .= '</p>';
				$result .= $args['description'] ? '<p class="description">' . $args['description'] . '</p>' : '';
				$result .= '</div>';
				$this->inject_datepicker_js = true;
				break;

			case 'textarea':	
				$result = '<div id="' . $this->name . '_' . $args['name'] . '" class="field field-textarea">';
				$result .= '<p class="label">';
				$result .= '<label for="' . $args['name'] . '">' . $args['label'] . '</label>';
				$result .= '</p>';
				$result .= '<p class="input">';
				$result .= '<textarea name="' . $args['name'] . '" id="' . $args['name'] . '" style="margin: 1px; width: 100%; height: 250px; " class="input_element">' . $args['value'] . '</textarea>';
				$result .= '</p>';
				$result .= $args['description'] ? '<p class="description">' . $args['description'] . '</p>' : '';
				$result .= '</div>';
				break;
				
			case 'hidden':	
				$result .= '<input type="hidden" name="' . $args['name'] . '" id="' . $args['name'] . '" value="' . $args['value'] . '" />';
				break;		
				
				
			default:
				$result = '<div id="' . $this->name . '_' . $args['name'] . '" class="field field-text">';
				$result .= '<p class="label">';
				$result .= '<label for="' . $args['name'] . '">' . $args['label'] . '</label>';
				$result .= '</p>';
				$result .= '<p class="input">';
				$result .= '<input type="text" name="' . $args['name'] . '" id="' . $args['name'] . '" value="' . $args['value'] . '" class="text" />';
				$result .= '</p>';
				$result .= $args['description'] ? '<p class="description">' . $args['description'] . '</p>' : '';
				$result .= '</div>';
				break;
			
			
		}
		return $result;
	}

	
	
	
	function admin_footer() {

		if ( $this->inject_timepicker_js && $this->get_global_value( 'inject_timepicker_js') === NULL ) {		
			$this->set_global_value( 'inject_timepicker_js', true );
			?>
			<script type="text/javascript">
			//<![CDATA[
				jQuery(document).ready(function(){
		
					jQuery( '.timepicker' ).each(function(){
						var $field = jQuery( this );
						var $hour = jQuery( this ).parents( 'p' ).find( '.hour' );
						var $minute = jQuery( this ).parents( 'p' ).find( '.minute' );
						
						$hour.change(function(){
							$field.val( timepicker_format_time( $hour.val(), $minute.val() ) );
						});
						
						$minute.change(function(){
							$field.val( timepicker_format_time( $hour.val(), $minute.val() ) );
						});
					});
	
					function timepicker_format_time( h, m ) {
						var output = h + ':' + m;
						return output;
					}
				});
			//]]>
			</script>	
			<?php
		}
		
		if ( $this->inject_datepicker_js && $this->get_global_value( 'inject_datepicker_js' ) === NULL  ) {
			$this->set_global_value( 'inject_datepicker_js', true );
			wp_enqueue_script( 'jquery-ui-datepicker' );
			global $wp_scripts;
			$ui = $wp_scripts->query( 'jquery-ui-core' );
		    $url = "https://ajax.googleapis.com/ajax/libs/jqueryui/{$ui->ver}/themes/overcast/jquery.ui.all.css";
		    wp_enqueue_style( 'jquery-ui-smoothness', $url, false, $ui->ver );
			?>
			<script type="text/javascript">
			//<![CDATA[
				jQuery(document).ready(function(){
				
					jQuery( '.datepicker' ).datepicker({
						dateFormat : 'yy-mm-dd'
					});
				});
			//]]>
			</script>	
			<?php
		}	
	
		
		if ( $this->inject_image_js && $this->get_global_value( 'inject_image_js' ) === NULL  ) {
			$this->set_global_value( 'inject_image_js', true );
			
			
			?>
			<script type="text/javascript">
			//<![CDATA[

                var formfield = '';
                var img_caller = '';

                jQuery(document).ready(function() {
                    // Store original function
                    var original_send_to_editor = window.send_to_editor;
                    var original_tb_remove = window.tb_remove;
                    var orriginal_tb_show = window.tb_show;
                    
                    
                    
                    window.send_to_editor = function( html ) {
                        if ( formfield == '' ) {
                            original_send_to_editor( html );
                        } else {
                            if ( jQuery( '#' + formfield ).hasClass( 'mceEditor' ) ) {
								// send to other tinyMCE editor
								focusTextArea( formfield );
								send_to_custom_field( html );
							} else if( jQuery( '#' + formfield ).hasClass( 'field-gallery' ) ) {
								if ( typeof html === 'object' ) {
									var img_array = new Array();
									$field = jQuery( 'div.input', '#' + formfield );
									$field.html('');
									console.log(html);
									for( var key in html ) {
										var role = html[key][2] ? html[key][1] : '';
										var img = jQuery( '<div>' )
														.addClass( 'image-gallery-thumbnail' )
														.css({
															'float'	:	'left',
															'width' :	'150px',
															'height' :	'150px',
															'background-color' :	'#fff',
															'margin':		'0 10px 10px 0',
														})
														.append( 
															jQuery( '<img>' )
																.addClass( 'image-gallery-thumbnail' )
																.attr( 'src', html[key][1] )
																.attr( 'role', role )
																.css({
																	'width' :	'150px',
																	'height' :	'150px',
																})
														)
														.click(function() {
									                    	var $this = jQuery( this );
									                    	formfield = $this.parents( 'div.field-gallery' ).attr( 'id' );
										                    tb_show('', 'media-upload.php?post_id=<?php echo $this->post_id; ?>&qqp_cpt_meta_gallery=true&type=image&TB_iframe=1');
									                        return false;
										                    
									                    });
														
										$field.append( img );
									}
									//tb_remove();								
								}
								
							} else {
								file_class = jQuery( 'img', html ).attr( 'class' );
								file_url = jQuery( 'img', html ).attr( 'src' );
								if ( typeof( file_class ) === "undefined" ) {
									file_class = jQuery( html ).attr( 'class' );
									file_url = jQuery( html ).attr( 'src' );
								}
								
								string_to_find = "wp-image-";
								file_id = file_class.substring( ( file_class.indexOf( string_to_find ) + string_to_find.length ) );
								jQuery( '#' + formfield ).val( file_id );
								img_caller.html( jQuery( '<img>' ).attr( 'src', file_url ) );
								tb_remove();
							}
                        }

                    }
                    
                    
                    window.tb_show = function( arg1, arg2 ) {
	                    orriginal_tb_show( arg1, arg2 );
                    }
                    
                    window.tb_remove = function() {
	                    formfield = '';
						img_caller = '';
						setCookie( "qqp_send_gallery_on_reload","true", -1 );
	                    original_tb_remove();
                    }

                    window.setCookie = function( c_name, value, exdays ) {
							var exdate = new Date();
							exdate.setDate( exdate.getDate() + exdays );
							var c_value=escape( value ) + ( ( exdays == null ) ? "" : "; expires="+exdate.toUTCString() );
							document.cookie=c_name + "=" + c_value;
					}
					window.setCookie( "qqp_send_gallery_on_reload","true",-1 );
					
						
                    jQuery( '.image-thumbnail' ).click(function() {
                    	$this = jQuery( this );
                    	$field = jQuery( this ).parent( 'div' ).find( '.imagefield' );
                    	formfield = $field.attr( 'id' );
                    	img_caller = $this;
                    	
	                    tb_show('', 'media-upload.php?post_id=<?php echo $this->post_id; ?>&qqp_cpt_meta_image=true&type=image&TB_iframe=1');
                        return false;
	                    
                    });
                    
                    jQuery( '#content-add_media' ).click(function() {
	                	formfield = ''; 
                    });
                    
                    
                    jQuery( '.image-gallery-button' ).click(function() {
                    	var $this = jQuery( this );
                    	formfield = $this.parents( 'div.field-gallery' ).attr( 'id' );
	                    tb_show('', 'media-upload.php?post_id=<?php echo $this->post_id; ?>&qqp_cpt_meta_gallery=true&type=image&TB_iframe=1');
                        return false;
	                    
                    });
                    
                });
			//]]>
			</script>	
			<?php
		}	
		
		
		
		

		
		
		
		
		
	}

	function add_attachment_fields( $form_fields, $post ) {
		
		if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
			$image = strpos( $_SERVER['HTTP_REFERER'], 'qqp_cpt_meta_image' );
			$delete_flag = false;
			if ( $image === false ) {
				// do nothing ...
			} else {
				$delete_flag = true;
				$form_fields['url']['value'] = '';
		        $form_fields['url']['input'] = 'hidden';
		
		        $form_fields['align']['value'] = 'aligncenter';
		        $form_fields['align']['input'] = 'hidden';
		
		        $form_fields['image-size']['value'] = 'thumbnail';
		        $form_fields['image-size']['input'] = 'hidden';
		
		        $form_fields['image-caption']['value'] = 'caption';
		        $form_fields['image-caption']['input'] = 'hidden';
		         
				$form_fields['buttons'] = array(
			            'label' => '',
			            'value' => '',
			            'input' => 'html'
			        );
			    $form_fields['buttons']['html'] = get_submit_button( __( 'Use this image' ), 'button', "send[" . $post->ID . "]", false );
			}
			
			$gallery = strpos( $_SERVER['HTTP_REFERER'], 'qqp_cpt_meta_gallery' );
			$gallery = $gallery === false ? false : true;
			$test_cookie = isset( $_COOKIE['qqp_send_gallery_on_reload'] ) ? true : false;
			
			if ( $test_cookie || $gallery ) {
				$delete_flag = true;
				$thumb_url = wp_get_attachment_image_src( $post->ID , 'thumbnail' );
				$file_url = wp_get_attachment_image_src( $post->ID, 'large' );
				
				$form_fields['url']['value'] = isset( $thumb_url[0] ) ? $thumb_url[0] : '';
		        $form_fields['url']['input'] = 'hidden';
		        
		        $form_fields['furl']['value'] = isset( $file_url[0] ) ? $file_url[0] : '';
		        $form_fields['furl']['input'] = 'hidden';
		
		        $form_fields['align']['value'] = 'aligncenter';
		        $form_fields['align']['input'] = 'hidden';
		
		        $form_fields['image-size']['value'] = 'thumbnail';
		        $form_fields['image-size']['input'] = 'hidden';
		
		        $form_fields['image-caption']['value'] = 'caption';
		        $form_fields['image-caption']['input'] = 'hidden';
		         
				$form_fields['buttons'] = array(
			            'label' => '',
			            'value' => '',
			            'input' => 'html'
			        );
			    $form_fields['buttons']['html'] = '';

			}
			
			$attachment_id = $post->ID;
			$filename = $post->post_title;
			if ( current_user_can( 'delete_post', $attachment_id ) ) {
				if ( !EMPTY_TRASH_DAYS ) {
					$delete = "<a class='button' href='" . wp_nonce_url( "post.php?action=delete&amp;post=$attachment_id", 'delete-attachment_' . $attachment_id ) . "' id='del[$attachment_id]' class='delete'>" . __( 'Delete Permanently' ) . '</a>';
				} elseif ( !MEDIA_TRASH ) {
					$delete = "<a href='#' class='button' onclick=\"document.getElementById('del_attachment_$attachment_id').style.display='block';return false;\">" . __( 'Delete' ) . "</a>
					 <div id='del_attachment_$attachment_id' class='del-attachment' style='display:none;'><p>" . sprintf( __( 'You are about to delete <strong>%s</strong>.' ), $filename ) . "</p>
					 <a href='" . wp_nonce_url( "post.php?action=delete&amp;post=$attachment_id", 'delete-attachment_' . $attachment_id ) . "' id='del[$attachment_id]' class='button'>" . __( 'Continue' ) . "</a>
					 <a href='#' class='button' onclick=\"this.parentNode.style.display='none';return false;\">" . __( 'Cancel' ) . "</a>
					 </div>";
				} else {
					$delete = "<a href='" . wp_nonce_url( "post.php?action=trash&amp;post=$attachment_id", 'trash-attachment_' . $attachment_id ) . "' id='del[$attachment_id]' class='delete'>" . __( 'Move to Trash' ) . "</a>
					<a href='" . wp_nonce_url( "post.php?action=untrash&amp;post=$attachment_id", 'untrash-attachment_' . $attachment_id ) . "' id='undo[$attachment_id]' class='undo hidden'>" . __( 'Undo' ) . "</a>";
				}
			} else {
				$delete = '';
			}
		
			if ( isset( $form_fields['buttons']['html'] ) && $delete_flag ) {
				$form_fields['buttons']['html'] .= $delete;
				
			}
		}
		
		return $form_fields;
	
	}
	
	function add_images_gallery_js_functions() {
		if ( $this->get_global_value( 'inject_images_gallery_js' ) === NULL  ) {
			$this->set_global_value( 'inject_images_gallery_js', true );
			
			$cookie_js = '';
			
			if ( isset( $_COOKIE['qqp_send_gallery_on_reload'] ) && ( ( isset( $_GET['tab'] ) && $_GET['tab'] != 'type' && $_GET['tab'] != 'library' ) || !empty( $_POST ) ) ) {
				$cookie_js .= 'qqp_send_gallery();';
			}

			$cookie_js_set = '';
			if ( isset( $_GET['qqp_cpt_meta_gallery'] ) ) {
				$cookie_js_set = 'parent.setCookie( "qqp_send_gallery_on_reload","true",1 );';
			}
			
	        print '
	        <script type="text/javascript">
			  	//<![CDATA[
                		var qqp_send_gallery = function() {
                			var qqp_send_gallery_array = new Array();
                			jQuery( ".media-item" ).each(function() {
                				var id = jQuery( "input[id^=\"type\"]", this ).attr( "id" );
                				
                				id = id.substr( 8 );
                				var thumb_id = "attachments[" + id + "][url]";
                				var thumb_url = false;
                				var file_id = "attachments[" + id + "][furl]";
                				var file_url = false;
                				
                				jQuery( "input", this ).each( function() {
                					var this_id = jQuery( this ).attr("id");
                					if ( this_id == thumb_id ) {
                						thumb_url = jQuery( this ).val();
                					}
                					if ( this_id == file_id ) {
                						file_url = jQuery( this ).val();
                					}
	                			});
                				
                				if ( thumb_url ) {
                					var temp_array = new Array( id, thumb_url, file_url);
                					qqp_send_gallery_array.push( temp_array );	
                				}
                			
                			});
                			
                			if ( parent.formfield != "" ) {
                				parent.send_to_editor( qqp_send_gallery_array );
                			}
                			
                			//parent.setCookie( "qqp_send_gallery_on_reload", "true", -1 );
                		}
                		
						
                		jQuery(document).ready(function() {
                			
                			' . $cookie_js . '
                			' . $cookie_js_set . '

	                		jQuery( "#save-all" ).click(function () {
	                			
	                			parent.setCookie( "qqp_send_gallery_on_reload","true",1 );
	                		});
                		});
                		
				//]]>
			</script>
			';
			
			
			if ( isset( $_GET['qqp_cpt_meta_image'] ) ) {
				print '
		            <style type="text/css">
		                .ml-submit {
		                	display:none!important;
		                }
		            </style>';
			}
			
		}
	}
	

	function extend() {
		$args = func_get_args();
		$extended = array();
		if( is_array( $args ) && count( $args ) ) {
			foreach( $args as $array ) {
				if( is_array( $array ) ) {
					$extended = array_merge( $extended, $array );
				}
			}
		}
		return $extended;
	}
} // END Class






?>