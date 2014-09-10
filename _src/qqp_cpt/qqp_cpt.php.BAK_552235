<?php

// qqp_cpt :: Register custom post type
class qqp_cpt {
	
	function qqp_cpt( $name = 'qqp_cpt', $title = 'qqp cpt', $args = array() ){
	// Post type labels
		$ctp_labels = array(
			'name' => _x( $title . 's', 'post type general name'),
			'singular_name' => _x( $title, 'post type singular name'),
			'add_new' => _x( 'Add New', $title ),
			'add_new_item' => __( 'Add New ' . $title ),
			'edit' => __( 'Edit'),
			'edit_item' => __( 'Edit ' . $title ),
			'new_item' => __( 'New ' . $title ),
			'view_item' => __( 'View ' . $title . ' Page' ),
			'search_items' => __( 'Search ' . $title ),
			'not_found' =>  __( 'No ' . $title . ' found' ),
			'not_found_in_trash' => __( 'No ' . $title . ' found in Trash' ), 
			'parent_item_colon' => ''
		);
	// Post type args
		$ctp_args = array(
			'labels' => $ctp_labels, /* array from above */
			'public' => true,
			'show_ui' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'_builtin' => false, 
			'_edit_link' => 'post.php?post=%d',
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => false, // Permalinks
			'query_var' => true,
			'menu_position' => 20,
			'supports' => array( 'title', 'thumbnail' )
		);
		
		$ctp_rewrite = array(
			'slug' => $name,
			'structure' => '/%year%/%monthnum%'
		);

		$default = array( 
			'name' => $name,
			'title' => $title,
			'ctp_args' => $ctp_args,
			'rewrite' => $ctp_rewrite,
			'help' => false
        );
        

		$this->args = $this->set_defaults( $default, $args );
		
		
		
	// Register post type
		add_action('init', array(&$this, 'register_cpt') );

	}
	
	

	function register_cpt() {
		
		global $wp_rewrite;
		
		register_post_type( $this->args['name'], $this->args['ctp_args'] );
		//add_action( 'contextual_help', array(&$this, 'cpt_help_text' ), 10, 3 );
		
		add_action( "load-{$GLOBALS['pagenow']}", array( $this, 'cpt_help_text' ), 20 );

		// Set parmalink rewrite			
		$_structure = '/' . $this->args['rewrite']['slug'] . $this->args['rewrite']['structure'] . '/%' . $this->args['name'] . '%';
		$wp_rewrite->add_rewrite_tag("%" . $this->args['name'] . "%", '([^/]+)', $this->args['name'] . "=");
		$wp_rewrite->add_permastruct($this->args['name'], $_structure, false);
		add_filter('post_type_link',  array(&$this, 'cpt_permalink' ), 10, 3);
		
		
		add_filter( 'post_updated_messages', array(&$this, 'cpt_updated_messages' ) );
		
	}
	

	function cpt_permalink($permalink, $post_id, $leavename) {
		$post = get_post($post_id);
		$rewritecode = array(
			'%year%',
			'%monthnum%',
			'%day%',
			'%hour%',
			'%minute%',
			'%second%',
			$leavename ? '' : '%postname%',
			'%post_id%',
			'%category%',
			'%author%',
			$leavename ? '' : '%pagename%',
		);
	 
		if ( '' != $permalink && !in_array($post->post_status, array('draft', 'pending', 'auto-draft')) ) {
			$unixtime = strtotime($post->post_date);
	 
			$category = '';
			if ( strpos($permalink, '%category%') !== false ) {
				$cats = get_the_category($post->ID);
				if ( $cats ) {
					usort($cats, '_usort_terms_by_ID'); // order by ID
					$category = $cats[0]->slug;
					if ( $parent = $cats[0]->parent )
						$category = get_category_parents($parent, false, '/', true) . $category;
				}
				// show default category in permalinks, without
				// having to assign it explicitly
				if ( empty($category) ) {
					$default_category = get_category( get_option( 'default_category' ) );
					$category = is_wp_error( $default_category ) ? '' : $default_category->slug;
				}
			}
	 
			$author = '';
			if ( strpos($permalink, '%author%') !== false ) {
				$authordata = get_userdata($post->post_author);
				$author = $authordata->user_nicename;
			}
	 
			$date = explode(" ",date('Y m d H i s', $unixtime));
			$rewritereplace = array(
				$date[0],
				$date[1],
				$date[2],
				$date[3],
				$date[4],
				$date[5],
				$post->post_name,
				$post->ID,
				$category,
				$author,
				$post->post_name,
			);
			$permalink = str_replace($rewritecode, $rewritereplace, $permalink);
		} else { // if they're not using the fancy permalink option
		}
		return $permalink;
	}

		
	function cpt_updated_messages( $messages ) {
		  global $post, $post_ID;
		
		  $name = $this->args['ctp_args']['labels']['singular_name'];
		
		  $messages[$this->args['name']] = array(
		    0 => '', // Unused. Messages start at index 1.
		    1 => sprintf( __( '%s updated. <a href="%s">View %s</a>' ), $name, esc_url( get_permalink($post_ID) ), $name ),
		    2 => __( 'Custom field updated.' ),
		    3 => __( 'Custom field deleted.' ),
		    4 => sprintf( __( '$s updated.' ), $name ),
		    /* translators: %s: date and time of the revision */
		    5 => isset($_GET['revision']) ? sprintf( __('%s restored to revision from %s'), $name, wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		    6 => sprintf( __('%s published. <a href="%s">Preview %s</a>'), $name, esc_url( get_permalink( $post_ID ) ),$name ),
		    7 => sprintf( __('%s saved.'), $name),
		    8 => sprintf( __('%s submitted. <a target="_blank" href="%s">Preview %s</a>'), $name, esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ), $name ),
		    9 => sprintf( __('%s scheduled for: <strong>%s</strong>. <a target="_blank" href="%s">Preview %s</a>'), $name, 
		      // translators: Publish box date format, see http://php.net/date
		      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ), $name ),
		    10 => sprintf( __('%s draft updated. <a target="_blank" href="%s">Preview %s</a>'), $name, esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ), $name ),
		  );
		
		  return $messages;
	}
	
	//display contextual help for Books

	function cpt_help_text() { 
		if ( isset( $this->args['help'] ) && is_array( $this->args['help'] ) ) {
			foreach( $this->args['help'] as $help_name=>$content ) {
				$screen_id = get_current_screen()->id;
				if ( $screen_id == $help_name && is_array( $content ) && !empty( $content ) ) {
					foreach( $content as $tab_name=>$data ) {
						get_current_screen()->add_help_tab( array(
							'id'       => $tab_name,
							'title'    => __( $data['title'] ),
							// Use the content only if you want to add something
							// static on every help tab. Example: Another title inside the tab
							//'content'  => '<p>Some stuff that stays above every help text</p>',
							'callback' => array( $this, 'prepare_help_tab' )
						) );
					}
				}
			}
		}
	}
	
	function prepare_help_tab( $screen, $tab ) {
		print $tab['callback'][0]->args['help'][$screen->id][ $tab['id'] ]['content'];		
	}
	

	function set_defaults( array &$array1, &$array2 = null ){
		$merged = $array1;
	
		if ( is_array( $array2 )) {
			foreach( $array2 as $key => $val ) {
				if ( is_array( $array2[$key] ) ) {
					$merged[$key] = is_array( $merged[$key] ) ? $this->set_defaults( $merged[$key], $array2[$key] ) : $array2[$key];
				} else {
					$merged[$key] = $val;
				}
			}
			return $merged;	
		}
	}
	
	
	
	
	
} // END Class


?>