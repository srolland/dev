<?php

	// Include class to create cutom post type and taxo
		require("qqp_cpt.php");
		require("qqp_cpt_meta.php");
		require("qqp_ctax.php");
		require("qqp_ctax_meta.php");

	
// Setup a new post type for random sampler
		$rs_args = array( 
			'ctp_args' => array (
				'rewrite' => array( 'slug' => 'random-sampler' ),
				'supports' => array( 'title', 'editor','excerpt', 'thumbnail' )
			)
        );
        
        $rs = new qqp_cpt( "qqp_rs", 'Random Sampler', $rs_args );
          
        
    // Setup some custom meta for the random sampler post type
    	// Address
		$args = array(
        			array( 'name' => 'rs_address_1', 'label' => 'Address 1', 'default' => '' ),
        			array( 'name' => 'rs_address_2', 'label' => 'Address 2', 'default' => '' ),
        			array( 'name' => 'rs_city', 'label' => 'City', 'default' => '' ),
        			array( 'name' => 'rs_zip', 'label' => 'Postal code', 'default' => '' )
        		);
		$rs_amb = new qqp_cpt_meta('rs_address_meta_box', 'Address', array( 'qqp_rs' ), $args);	
		// Taxes
		$args = array(
        			array( 'name' => 'rs_taxes', 'label' => 'Taxes', 'default' => '0' ),
        			array( 'name' => 'rs_valuation', 'label' => 'Valuation', 'default' => '0' ),
        			array( 'name' => 'rs_asking_price', 'label' => 'Asking price', 'default' => '0' ),
        			array( 'name' => 'rs_sold_for', 'label' => 'Sold for', 'default' => '0' )
        		);
        $rs_tmb = new qqp_cpt_meta('rs_taxes_meta_box', 'Listing agents', array( 'qqp_rs' ), $args);
        // Listing agents
		$args = array(
        			array( 'name' => 'rs_property_link', 'label' => 'Property link', 'default' => '' ),
        			array( 'name' => 'rs_listing_agents', 'label' => 'Listing agents', 'default' => '' ),
        			array( 'name' => 'rs_real_estate_agency', 'label' => 'Real estate agency', 'default' => '' ),
        			array( 'name' => 'rs_real_estate_agency_link', 'label' => 'Real estate agency link', 'default' => '' )
        		);
        $rs_lmb = new qqp_cpt_meta('rs_listing_agents_meta_box', 'Listing agents', array( 'qqp_rs' ), $args);	
  
    
    // Setup a new taxonomy neighbourhood
        $nt = new qqp_ctax( "neighbourhood", 'Neighbourhoods', array( 'post', 'qqp_rs' ), array( 'rewrite' => array( 'slug' => 'neighbourhoods' ) ) );
        
        
    // Setup some custom meta data for taxonomy neighbourhood
        $ntm_args = array(
        			array( 'name' => 'map', 'label' => 'Map', 'type' => 'textarea' ),
        			array( 'name' => 'map_center_lng', 'label' => 'Map Center (lng)' ),
        			array( 'name' => 'map_center_lat', 'label' => 'Map Center (lat)' ),
        			array( 'name' => 'map_info_window', 'label' => 'Map Infowindow Content', 'type' => 'textarea' ),
        			array( 'name' => 'map_overlay', 'label' => 'Map Overlay (polygone)', 'type' => 'textarea' ),
        			array( 'name' => 'superficie', 'label' => 'Superficie' ),
        			array( 'name' => 'density', 'label' => 'Density' ),
        			array( 'name' => 'population', 'label' => 'Population' ),
        			array( 'name' => 'men', 'label' => 'Men' ),
        			array( 'name' => 'men_percent', 'label' => 'Men Percent' ),
        			array( 'name' => 'women', 'label' => 'Women' ),
        			array( 'name' => 'women_percent', 'label' => 'Women Percent' ),
        			array( 'name' => 'parks', 'label' => 'Parks' ),
        			array( 'name' => 'outdoor_pools', 'label' => 'Outdoor Pools' ),
        			array( 'name' => 'indoor_pools', 'label' => 'Indoor Pools' ),
        			array( 'name' => 'arenas', 'label' => 'Arenas' ),
        			array( 'name' => 'libraries', 'label' => 'Libraries' ),
        			array( 'name' => 'borough_hall_address', 'label' => 'Borough Hall Address' ),
        			array( 'name' => 'borough_hall_postal_code', 'label' => 'Borough Hall Postal Code' ),
        			array( 'name' => 'borough_hall_telephone', 'label' => 'Borough Hall Telephone' ),
        			array( 'name' => 'borough_hall_email', 'label' => 'Borough Hall Email' )
        		);
	
        $rstm = new qqp_ctax_meta( "neighbourhood", $ntm_args );


    // Setup a new taxonomy rs_type
        $rst = new qqp_ctax( "rs_type", 'Type', array( 'qqp_rs' ) );
		
		
		
	
		
	
?>