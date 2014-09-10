<?php


// qqp_option_page :: Generate options pages
class qqp_option_page {
	function qqp_option_page( $name = 'qqp_option_page', $ns = 'qqp_option_page-group', $fields = array(), $capability = 'administrator' ) {
		
		$this->name = $name;
		$this->ns = $ns;
		$this->fields = $fields;
		$this->capability = $capability;
		$this->default_field = array(
			'name' => '',
			'label' => '',
			'value' => '',
			'type' => 'text',
			'description' => '',
			'default' => ''
		);

		add_action('admin_menu', array(&$this, 'create_menu') );
	}


	function create_menu() {
		add_menu_page( $this->name, $this->name, $this->capability, __FILE__, array(&$this, 'generate_option_page') );
		add_action( 'admin_init', array(&$this, 'register_settings') );
	}
	
	
	function register_settings() {
		foreach( $this->fields as $feild ) {
			register_setting( $this->ns, $feild['name'] );
		}
	}

	function generate_option_page() {
		?>
		<div class="wrap">
		<h2><?php echo $this->name; ?></h2>
		<form method="post" action="options.php">
		    <?php settings_fields( $this->ns ); ?>
		    <table class="form-table">
			    <?php
				    
				    
				    
				    foreach( $this->fields as $feild ) {
				    	$feild = $this->extend( $this->default_field, $feild );
				    	echo $this->generate_feild( $feild );
					}  
				    
				    
				    
				    
				   
				    
				    
				    
			    ?>
		    </table>
		    
		    <p class="submit">
		    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		    </p>
		
		</form>
		</div>
		<?php
	}

	function generate_feild( $feild ) {
		$output = '';
		
		switch( $feild['type'] ) {
			case 'text':
				$output .= '<tr valign="top">';
		    	$output .= '<th scope="row">' . $feild['label'] . '</th>';
		    	$output .= '<td>';
		    	$output .= '<input type="text" name="' . $feild['name'] . '" value="';
		    	$value = get_option( $feild['name'] );
		    	$output .= $value ? $value : $feild['default'];
		    	$output .= '"  style="width:450px;" />';
		    	$output .= $feild['description'] != '' ? '<p>' . $feild['description'] . '</p>' : '';
		    	$output .= '</td>';
		    	$output .= '</tr>';
				break;
			
			case 'textarea':
				$output .= '<tr valign="top">';
		    	$output .= '<th scope="row">' . $feild['label'] . '</th>';
		    	$output .= '<td>';
		    	$output .= '<textarea name="' . $feild['name'] . '" id="' . $feild['name'] . '" style="width:450px;height:125px;">';
		    	$value = get_option( $feild['name'] );
		    	$output .= $value ? $value : $feild['default'];
		    	$output .= '</textarea>';
		    	$output .= $feild['description'] != '' ? '<p>' . $feild['description'] . '</p>' : '';
		    	$output .= '</td>';
		    	$output .= '</tr>';
				break;
				
				
			case 'separator':
				$output .= '<tr valign="top" style="background:#CFCFCF;">';
		    	$output .= '<th scope="row">' . $feild['label'] . '</th>';
		    	$output .= '<td>';
		    	$output .= $feild['description'] != '' ? $feild['description'] : '';
		    	$output .= '</td>';
		    	$output .= '</tr>';
				break;
		}
		
		
		
		
		return $output;
		
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