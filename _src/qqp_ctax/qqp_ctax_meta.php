<?php

// qqp_ctax_meta :: Add meta field to taxonomy
class qqp_ctax_meta {
	function qqp_ctax_meta( $taxo, $args = array() ) {
		global $wpdb;
		$this->taxo = $taxo;
		$this->args = $args;
		
		$db_path = $this->taxo . 'meta';

		$wpdb->$db_path = $wpdb->prefix . $db_path;
		$this->db_path = $wpdb->prefix . $db_path;
		
		if ( !$this->check_if_table_exist() ) {
			$this->create_table();
		}
		
		add_action( $taxo . '_edit_form_fields', array(&$this, 'edit_ctax_meta'), 10, 2 );
		add_action( 'edited_' . $taxo, array(&$this, 'save_ctax_meta'), 10, 2 );
		
	}
	
	function save_ctax_meta($term_id, $tt_id) {	
	 	if (!$term_id) return;
		
		global $wpdb;
	
		foreach( $this->args as $fields ) {
			if ( isset( $_POST[ $fields['name'] ] ) ) {
				//print_r('<hr />');
				//print_r($_POST['taxonomy']);
				//print_r($term_id);
				//print_r($fields['name']);
				//print_r($_POST[ $fields['name'] ] );
				$update = update_metadata( $_POST['taxonomy'], $term_id, $fields['name'], $_POST[ $fields['name'] ] );
				
			}
			
		}
	}
	
	
	
	
	function edit_ctax_meta( $tag, $taxonomy ) {
		foreach( $this->args as $fields ) {
			$value = get_metadata( $tag->taxonomy, $tag->term_id, $fields['name'], true );
			$value = array( 'value' => $value );
			if ( $value ) {
				$fields = $this->extend( $fields, $value );	
			}

			$field = $this->generate_field( $fields );
			echo $field;
		}
	}
	
	function generate_field( $args = array() ) {
		$result = false;
		$default = array(
						'type' => 'text',
						'name' => '',
						'label' => '',
						'value' => '',
						'description' => ''
					);
		$field = $this->extend( $default, $args );

		switch( $field['type'] ) {
			case 'text':
				$result = '<tr class="form-field">';
				$result .= '<th scope="row" valign="top"><label for="' . $field['name'] . '">' . $field['label'] . '</label></th>';
				$result .= '<td>';
				$result .= '<input type="' . $field['type'] . '" name="' . $field['name'] . '" id="' . $field['name'] . '" value="' . $field['value'] . '"/><br />';
				$result .= $field['description'] ? '<p class="description">' . $field['description'] . '</p>' : '';
				$result .= '</td>';
				$result .= '</tr>';
				break;
			
			case 'textarea':
				$result = '<tr class="form-field">';
				$result .= '<th scope="row" valign="top"><label for="' . $field['name'] . '">' . $field['label'] . '</label></th>';
				$result .= '<td>';
				$result .= '<textarea name="' . $field['name'] . '" id="' . $field['name'] . '">' . $field['value'] . '</textarea><br />';
				$result .= $field['description'] ? '<p class="description">' . $field['description'] . '</p>' : '';
				$result .= '</td>';
				$result .= '</tr>';
				break;
		}
		


		return $result;
	}
	
	
	function check_if_table_exist() {
		global $wpdb;
		
		$query = $wpdb->prepare( 
					"
						SELECT COUNT(*) as YES
						FROM information_schema.tables 
						WHERE table_schema = '%s' 
						AND table_name = '%s';
					", 
				    DB_NAME, 
					$this->db_path
				);
	
		
		$exist = $wpdb->get_results( $query );
		$exist = $exist[0]->YES ? true : false;
		return $exist;	
		
		
	}
	
	
	function create_table() {
		global $wpdb;
		
		$query = sprintf( 
					"
						CREATE TABLE IF NOT EXISTS `%s` (
						  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
						  `%s_id` bigint(20) unsigned NOT NULL DEFAULT '0',
						  `meta_key` varchar(255) DEFAULT NULL,
						  `meta_value` longtext,
						  PRIMARY KEY (`meta_id`),
						  KEY `%s_id` (`%s_id`),
						  KEY `meta_key` (`meta_key`)
						) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;
					", 
				    $this->db_path, 
					$this->taxo,
					$this->taxo,
					$this->taxo
				);
	
		$create = $wpdb->query( $query );
		$this->creation_query = $query;
		
		if ( $create == false ) {
			add_action( 'admin_notices', array(&$this, 'throw_creation_error') );
		} else {
			add_action( 'admin_notices', array(&$this, 'throw_creation_success') );
		}
	}
	
	function throw_creation_error() {
		echo '<div class="error fade"><p>';
		echo 'Your database could not be updated to allow meta data on ' . $this->taxo . ' taxonomy. Please manualy create the table in your database. You can use the following SQL request';
		echo '</p><p>';
		echo $this->creation_query;
		echo '</p></div>';
		
	}
	
	function throw_creation_success() {
		echo '<div class="updated fade"><p>';
		echo 'Your database was successfully updated to allow meta data on ' . $this->taxo . ' taxonomy';
		echo '</p></div>';
		
	}
	
	
	
	function extend() {
		$args = func_get_args();
		$extended = array();
		if(is_array($args) && count($args)) {
			foreach($args as $array) {
				if(is_array($array)) {
					$extended = array_merge($extended, $array);
				}
			}
		}
		return $extended;
	}
	
} // End Class	

?>