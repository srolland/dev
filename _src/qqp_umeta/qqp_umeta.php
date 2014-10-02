<?php


// qqp_user_meta :: Register custom post type
class qqp_user_meta {
	
	function qqp_user_meta( $name = 'qqp_user_meta', $title = 'User Meta', $fields = array() ){
	// Post type labels
		$this->name = $name;
		$this->title = $title;
		$this->fields = $fields;
		$this->default_field = array(
							'type' => 'text',
							'name' => '',
							'label' => '',
							'value' => '',
							'default' => '',
							'description' => '',
							'registration' => false,
							'error_msg' => '',
							'data' => false
						);

	// Register fields
		add_action( 'show_user_profile', array(&$this, 'register_fields') );
		add_action( 'edit_user_profile', array(&$this, 'register_fields') );
	
	// Save fields
		add_action( 'personal_options_update', array(&$this, 'save_custom_fields') );
		add_action( 'edit_user_profile_update', array(&$this, 'save_custom_fields') );
	
	// 
		add_action('register_form', array(&$this, 'form_register_fields') );
		add_action('register_post', array(&$this, 'form_check_custom_fields'), 10, 3 );
		add_action('user_register',  array(&$this, 'form_save_custom_fields') );
	}

	function form_register_fields() {
		if ( is_array( $this->fields ) ) {
			foreach( $this->fields as $field ) {
				$field = $this->extend( $this->default_field, $field );
				if ( $field['registration'] ) {
					$field['type'] = $field['type'] . '-form';
					echo $this->generate_field( $field );
				}
			}
			echo '<p>&nbsp;</p>';		
		}
	}

	function register_fields( $user ) {
		$this->user = $user;
		echo '<h3>' . __( $this->title ) . '</h3>';
		if ( is_array( $this->fields ) ) {
			echo '<table class="form-table">';
			foreach( $this->fields as $field ) {
				$field = $this->extend( $this->default_field, $field );
				if ( $field['registration'] !== 'only' && $field['registration'] !== 'require-only' && $field['name'] !== 'first_name' && $field['name'] !== 'last_name' && $field['name'] != 'description' ) {
					echo $this->generate_field( $field );
				}
			}
			echo '</table>';	
		}
	}
	
	function generate_field( $arg = array() ) {
				
		$result = '';
		switch( $arg['type'] ) {

	/* -	Select					- */ //
			case 'select-form':
				$result .= '<p style="width: 100%; margin-bottom: 15px;">';
				$result .= '<label for"' . $arg['name'] . '">';
				$result .= $arg['label'];
				$result .= '<br>';
				$result .= '</label>';
				$result .= '<select style="margin: 2px 0 0 0;" name="' . $arg['name'] . '" id="' .$arg['name']. '" class="input" >';
				if ( is_array( $arg['data'] ) ) {
					foreach( $arg['data'] as $key=>$val ) {
						if ( isset( $_POST[$arg['name']] ) ) {
							$selected = $_POST[$arg['name']] == $key ? ' selected="selected" ' : '';
						} else {
							$selected = $arg['default'] == $key ? ' selected="selected" ' : '';
						}
						
						$result .= '<option value="' . $key . '" ' . $selected . ' >';
						$result .= $val;
						$result .= '</option>';
					}	
				}
				$result .= '</select><br>';
				
				
				$result .= $arg['description'] ? '<div class="description" style="margin:-12px 0 10px 0;">' . $arg['description'] . '</div>' : '';
				$result .= '</p>';
				break;

			case 'select':
				$result .= '<tr>';
				$result .= '<th>';
				$result .= '<label for"' . $arg['name'] . '">';
				$result .= $arg['label'];
				$result .= '</label>';
				$result .= '</th>';
				$result .= '<td>';
				$result .= '<select name="' . $arg['name'] . '" id="' .$arg['name']. '" >';
				if ( is_array( $arg['data'] ) ) {
					$fval = get_the_author_meta( $arg['name'], $this->user->ID );
					foreach( $arg['data'] as $key=>$val ) {
						if ( $fval && $fval != '' ) {
							$selected = $key == $fval ? ' selected="selected" ' : '';
						} else {
							$selected = $arg['default'] == $key ? ' selected="selected" ' : '';
						}
						
						$result .= '<option value="' . $key . '" ' . $selected . ' >';
						$result .= $val;
						$result .= '</option>';
					}	
				}
				$result .= '</select>';
				$result .= $arg['description'] ? '<span class="description">' . $arg['description'] . '</span>' : '';
				$result .= '</td>';
				$result .= '</tr>';
				break;	
		
	/* -	Textbox					- */ //
			case 'textbox-form':
				$result .= '<p>';
				$result .= '<label for"' . $arg['name'] . '">';
				$result .= $arg['label'];
				$result .= '<br>';
				$result .= '</label>';
				$read_only = $arg['registration'] === 'only' ? ' readonly="readonly" ': '';
				$result .= '<textarea rows="5" style="width: 100%; margin:0 0 10px 0;" name="' . $arg['name'] . '" id="' .$arg['name']. '" ' . $read_only . ' >';
				$result .= isset( $_POST[$arg['name']] ) ? $_POST[$arg['name']] : $arg['default'];
				$result .= '</textarea>';
				$result .= $arg['description'] ? '<div class="description" style="margin:-10px 0 10px 0;">' . $arg['description'] . '</div>' : '';
				$result .= '</p>';
				break;

			case 'textbox':
				$result .= '<tr>';
				$result .= '<th>';
				$result .= '<label for"' . $arg['name'] . '">';
				$result .= $arg['label'];
				$result .= '</label>';
				$result .= '</th>';
				$result .= '<td>';
				$result .= '<textarea rows="5" cols="30" name="' . $arg['name'] . '" id="' .$arg['name']. '" >';
				$val = get_the_author_meta( $arg['name'], $this->user->ID );
				$result .= $val ? $val : $arg['default'];
				$result .= '</textarea>';
				$result .= $arg['description'] ? ' <span class="description">' . $arg['description'] . '</span>' : '';
				$result .= '</td>';
				$result .= '</tr>';
				break;		
			
	/* -	Checkbox					- */
			case 'checkbox-form':
				$result .= '<p>';
				$result .= '<label for"' . $arg['name'] . '">';
				$result .= $arg['label'];
				$result .= '<br>';
				$checked_1 = isset( $_POST[$arg['name']] ) ? true : false;
				$checked_2 = $arg['default'] ? true : false;
				$checked = $checked_1 || $checked_2 ? ' checked="checked" ' :'';
				$result .= '</label>';
				$result .= '<div class="description" style="margin: 0 0 10px 0; padding: 0;">';
				$result .= '<input type="checkbox" style="margin: 0 10px 0 0; padding: 0; display:block; float:left;" name="' . $arg['name'] . '" id="' .$arg['name']. '" value="true" ' . $checked . '/>';
				$result .= $arg['description'] ? $arg['description'] : '';
				$result .= '</div>';
				$result .= '</p>';
				break;

			case 'checkbox':
				$result .= '<tr>';
				$result .= '<th>';
				$result .= '<label for"' . $arg['name'] . '">';
				$result .= $arg['label'];
				$result .= '</label>';
				$result .= '</th>';
				$result .= '<td>';
				$val = get_the_author_meta( $arg['name'], $this->user->ID );
				$checked = !empty( $val ) ? ' checked="checked" ' : '';
				$result .= '<input type="checkbox" name="' . $arg['name'] . '" id="' .$arg['name']. '" value="true" ' . $checked . '/>';
				$result .= $arg['description'] ? ' <span class="description">' . $arg['description'] . '</span>' : '';
				$result .= '</td>';
				$result .= '</tr>';
				break;
/* -	text					- */
			case 'text-form':
				$result .= '<p>';
				$result .= '<label for"' . $arg['name'] . '">';
				$result .= $arg['label'];
				$result .= '<br>';
				$result .= '<input class="input" type="text" tabindex="20" size="25" id="' . $arg['name'] . '" name="' . $arg['name'] . '" value="';
				$result .= isset( $_POST[$arg['name']] ) ? $_POST[$arg['name']] : $arg['default'];
				$result .= '" />';
				$result .= '</label>';
				$result .= $arg['description'] ? '<div class="description" style="margin:-10px 0 10px 0;">' . $arg['description'] . '</div>' : '';
				$result .= '</p>';
				break;
				
			case 'text':
				$result .= '<tr>';
				$result .= '<th>';
				$result .= '<label for"' . $arg['name'] . '">';
				$result .= $arg['label'];
				$result .= '</label>';
				$result .= '</th>';
				$result .= '<td>';
				$result .= '<input type="text" name="' . $arg['name'] . '" id="' . $arg['name'] . '" value="';
				$val = get_the_author_meta( $arg['name'], $this->user->ID );
				$result .= $val ? $val : $arg['default'];
				$result .= '" class="text" />';
				$result .= $arg['description'] ? ' <span class="description">' . $arg['description'] . '</span>' : '';
				$result .= '</td>';
				$result .= '</tr>';
				break;
		}
		return $result;
	}
	
	
	
	function save_custom_fields( $user_id ) {
		if ( !current_user_can( 'edit_user', $user_id ) ) {
			return false;	
		}
		
		if ( is_array( $this->fields ) ) {
			foreach( $this->fields as $field ) {
				if ( isset( $_POST[$field['name']] ) && $field['name'] !== 'first_name' && $field['name'] !== 'last_name' ) {
					if ( !empty( $_POST[$field['name']] )  ) {
						update_user_meta( $user_id, $field['name'], $_POST[$field['name']] );
					}else {
						delete_user_meta( $user_id, $field['name'] );
					} 
				} else {
					delete_user_meta( $user_id, $field['name'] );
				}
			}
		}
	}
	
	function form_check_custom_fields( $login, $email, $errors ) {
			foreach( $this->fields as $field ) {
				$field = $this->extend( $this->default_field, $field );
				if ( $field['registration'] === 'require' || $field['registration'] === 'require-only' ) {
					if ( empty( $_POST[$field['name']] ) ) {
						$error_msg = !empty( $field['error_msg'] ) ? $field['error_msg'] : 'Please fill in ' . $field['label'];
						$errors->add('empty_' . $field['name'], "<strong>ERROR</strong>: " . $error_msg );
					}
				}
			}
	}
	
	function form_save_custom_fields( $user_id, $password="", $meta=array() ) {
		$user_data = array();
		foreach( $this->fields as $field ) {
			if ( isset( $_POST[$field['name']] ) ) {
				if ( $field['registration'] !== 'only' && $field['registration'] !== 'require-only' ) {
					if ( !empty( $_POST[$field['name']] ) ) {
						if ( $field['name'] == 'first_name' || $field['name'] == 'last_name' ) {
							$user_data['ID'] = $user_id;
							$user_data[$field['name']] = $_POST[$field['name']];
						} else {
							update_user_meta( $user_id, $field['name'], $_POST[$field['name']] );
						}
					}
				}
			}
		}
		
		
		
		if ( !empty( $user_data ) ) {
			wp_update_user( $user_data );
			
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