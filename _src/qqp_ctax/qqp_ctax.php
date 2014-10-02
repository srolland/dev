<?php


// qqp_ctax :: Register custom taxonomy
class qqp_ctax {
	function qqp_ctax( $name = 'qqp_ctax', $title = 'qqp ctax', $post_type = array( 'post' ) , $args = array(), $default_cat = false ) {
	// Taxo labels
		$taxo_labels = array(
			'name' => __( $title , 'taxonomy general name' ),
			'singular_name' => __( $title, 'taxonomy singular name' ),
			'search_items' =>  __( 'Search ' . $title ),
			'all_items' => __( 'All ' . $title ),
			'parent_item' => __( 'Parent ' . $title ),
			'parent_item_colon' => __( 'Parent ' . $title . ':' ),
			'edit_item' => __( 'Edit ' . $title ),
			'update_item' => __( 'Update ' . $title ),
			'add_new_item' => __( 'Add New ' . $title ),
			'new_item_name' => __( 'New ' . $title )
		); 
	// Taxo args
		$taxo_args = array (
			'labels' => $taxo_labels, /* array from above */
			'hierarchical' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => $name )
		);
		
		$this->name = $name;
		$this->title = $title;
		$this->post_type = $post_type;
		$this->args = $this->extend( $taxo_args, $args );
		$this->default_cat = $default_cat;
		

		add_action( 'init', array(&$this, 'register_taxo'), 0 );
		
	}
	
	function register_taxo() {
		register_taxonomy( $this->name, $this->post_type, $this->args ); /* must have CPT as 2nd argument */
		add_action( 'admin_init', array(&$this, 'register_taxo_dd_filter'), 0 );
		if ( is_array( $this->default_cat ) ) {
			add_action( 'save_post', array(&$this, 'set_default_object_terms'), 100, 2 );
		}
	}
	
	function set_default_object_terms( $post_id, $post ) {
        $defaults = array(
            	$this->name => $this->default_cat
            );
        $taxonomies = get_object_taxonomies( $post->post_type );
        foreach ( (array) $taxonomies as $taxonomy ) {
            $terms = wp_get_post_terms( $post_id, $taxonomy );
            if ( empty( $terms ) && array_key_exists( $taxonomy, $defaults ) ) {
                wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy );
            }
        }
	}
	
	function register_taxo_dd_filter() {
		global $pagenow, $typenow;
		
		$tn = $typenow ? $typenow : 'post';

		if ( $pagenow == 'edit.php' && in_array( $tn , $this->post_type ) ) {
			add_filter( 'parse_query', array(&$this, 'taxonomy_filter_post_type_request') );
			add_action( 'restrict_manage_posts', array(&$this, 'build_taxo_dd_filter') );
			
			add_filter( 'manage_edit-' . $tn . '_columns', array(&$this, 'add_new_edit_columns') );
			add_action('manage_' . $tn . '_posts_custom_column', array(&$this, 'manage_edit_columns'), 10, 2);
		}
	}

	function build_taxo_dd_filter() {
			$tax_name = $this->name;
			$tax_obj = get_taxonomy( $tax_name );
			$selected = empty( $_GET[$tax_name] ) ? '' : $_GET[$tax_name];
			wp_dropdown_categories( 
				array(
					'show_option_all' => __('Show All ' . $tax_obj->label . '&nbsp;'),
					'taxonomy'=> $tax_name,
					'name'=> $tax_obj->name,
					'orderby'=> 'name',
					'selected'=> $selected,
					'hierarchical'=> $tax_obj->hierarchical,
					'show_count'=> false,
					'hide_empty'=> false
				)
			);
	}


	function taxonomy_filter_post_type_request( $query ) { //add filter to query so dropdown will work
		global $pagenow;
		$qv = &$query->query_vars;
		if( $pagenow=='edit.php' && isset($qv[$this->name]) && is_numeric($qv[$this->name]) ) {
			$term = get_term_by('id',$qv[$this->name],$this->name);
			$qv[$this->name] = $term->slug;
		}
	}	

	function add_new_edit_columns($columns) {

		return array_merge($columns,
              		array(
              			'qqp_ctaxo_' . $this->name => __( $this->title )
                    ));
		return $new_columns;
	}
	
	function manage_edit_columns( $column_name, $post_id ) {
		switch ( $column_name ) {
			case 'qqp_ctaxo_' . $this->name:
				$term_list = wp_get_post_terms( $post_id, $this->name, array("fields" => "names") );
				echo implode( ', ', $term_list );
			    break;
	
			default:
				break;
		}
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
	
	function replace_in_array( $needle, $replacement, $stack ) {
		for( $i=0; $i<count($stack); $i++ ) {
		   if( $stack[$i] == $needle ) {
		   	$stack[$i] = $replacement;
		   }
		}
		return $stack;
	}

	
} // END Class

?>