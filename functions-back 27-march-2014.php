<?php
/* 
	Here we have all the custom functions for the theme
	Please be extremely cautious editing this file,
	When things go wrong, they tend to go wrong in a big way.
	You have been warned!
*/
 require '_src/setup.php';
/*

add_action('transition_comment_status', 'my_approve_comment_callback', 10, 3);
function my_approve_comment_callback($new_status, $old_status, $comment) {
    if($old_status != $new_status) {
        if($new_status == 'approved') {
            $comments_count = wp_count_comments();

            $limit = get_option( '1m_comments_magic_number' );
            $limit = $limit == '' ? 1000000 : $limit;

            if ( $comments_count->approved+1 == $limit ) {
	            update_option( '1m_lucky_id', $comment->comment_ID );
            }
        }
    }
}
add_action('wp_insert_comment', 'comment_inserted', 10, 2);
function comment_inserted($comment_id, $comment) {

    $status = wp_get_comment_status( $comment_id );
	if ( $status == "approved" ) {
	   $comments_count = wp_count_comments();
	   
        $limit = get_option( '1m_comments_magic_number' );
        $limit = $limit == '' ? 1000000 : $limit;

        if ( $comments_count->approved+1 == $limit ) {
            update_option( '1m_lucky_id', $comment->comment_ID );
        }
	  
	}
}
*/
/* Site options
-------------------------------------------------------------------------------------- */
/*
$comments_count = wp_count_comments();
$onem_lucky_id_txt = get_option( '1m_lucky_id' );
$onem_lucky_id_txt = $onem_lucky_id_txt == '' ? $comments_count->approved . " so far." : "We have a winner: " . $onem_lucky_id_txt;
$option_args = array(
	
	array( 'name' => '1m_comments_magic_number', 'label' => 'Magic number', 'description' => '' ),
	array( 'name' => '1m_lucky_id', 'label' => 'Winner ID', 'type' => 'text', 'description' => 'This the ID of the 1000000th comment.' ),
	array( 'name' => 'sep_000', 'label' => $onem_lucky_id_txt, 'type' => 'separator' ),
);

$theme_options = new qqp_option_page( '1m comments', 'qqp_options', $option_args );
*/
// Register the wp 3.0 Menus
add_action( 'init', 'register_my_menus' );

function register_my_menus() {
	register_nav_menus(
		array(
			'primary-menu' => __( 'Primary Menu' ),
			'secondary-menu' => __( 'Secondary Menu' )
		)
	);
}


// Add extra Database Object Instance for XMLTeam Stats
$newdb = new wpdb('np_srolland', 'hio_st@ts', 'np_sportsdb', '10.22.199.137');
$newdb->show_errors();


// Ready for theme localisation
load_theme_textdomain ('framework');


// Register the sidebars and widget classes
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Main Sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Footer 1',
		'before_widget' => '<div id="%1$s" class="widget %2$s foot-widget-one">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Footer 2',
		'before_widget' => '<div id="%1$s" class="widget %2$s foot-widget-two">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Footer 3',
		'before_widget' => '<div id="%1$s" class="widget %2$s foot-widget-three">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Footer 4',
		'before_widget' => '<div id="%1$s" class="widget %2$s foot-widget-four">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Narrow Left',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Narrow Right',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Sidebar Page',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Narrow Left Page',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Narrow Right Page',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Main Right Block',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Special Spot homepage',
		'before_widget' => '<div id="%1$s" class="widget %2$s special_spot">',
		'after_widget' => '</div>',
		'before_title' => '<h3 style="display:none;">',
		'after_title' => '</h3>',
	));
}

// Add support for WP 2.9 post thumbnails
if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-thumbnails', array( 'post', 'custom-type', 'qqp_in_the_game', 'Play-by-Play' ) );
	set_post_thumbnail_size( 55, 55, true ); // Main theme thumbnails
	add_image_size( 'thumbnail-large', 75, 75, true ); // Large thumbnails
	add_image_size( 'thumbnail-large2', 100, 100, true ); // Large thumbnails
	add_image_size( 'thumbnail-wide', 300, 100, true ); // Wide thumbnails
	add_image_size( 'main-image', 285, 280, true ); // Main (latest) image
	add_image_size( 'main-image-pictures', 290, 280, true ); // Main (pictures) image
	add_image_size( 'lead-image', 460, 250, false ); // Post Page Main image
	add_image_size( 'pbp-large', 620, 349, true ); // Post Page Main image
	add_image_size( 'pbp-small', 300, 169, true ); // Post Page Main image
	add_image_size( 'show-big', 588, 329, true ); // Show Page Main image
}


// Add option for custom gravatar
function tz_custom_gravatar( $avatar_defaults ) {
    $tz_avatar = get_bloginfo('template_directory') . '/images/gravatar.png';
    $avatar_defaults[$tz_avatar] = 'Custom Gravatar (/images/gravatar.png)';
    return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'tz_custom_gravatar' );







//Seb: Add Category clean name Class to body tag 
// Add specific CSS class by filter

function url_categories($classes) {
	$url_segments = explode("/",$_SERVER["REQUEST_URI"]); 
    $category_class = $url_segments[1];//print_r($segment[0]); 
	// add 'class-name' to the $classes array
	$classes[] = $category_class;
	// return the $classes array
	return $classes;
}
add_filter('body_class','url_categories');


//Seb: Add HIO namespace to RSS feeds
function hio_namespace() {
    echo 'xmlns:hio="http://staging.hockeyinsideout.com/namespace.php/"';
}

add_filter( 'rss2_ns', 'hio_namespace' );

function hio_liveblog_info() {
      if (get_post_custom_values('ScribbleLiveId')) : 
		echo "<hio:liveblog>";
			 foreach (get_post_custom_values('ScribbleLiveId') as $scribbleliveid) { echo $scribbleliveid; } 
		echo "</hio:liveblog>";
	 endif;
}

add_filter( 'rss2_item', 'hio_liveblog_info' );



// Change Excerpt Length
function tz_excerpt_length($length) {
return 40; }
add_filter('excerpt_length', 'tz_excerpt_length');


// Change Excerpt [...] to new string : WP2.8+
function tz_excerpt_more($excerpt) {
return str_replace('[...]', '...', $excerpt); }
add_filter('wp_trim_excerpt', 'tz_excerpt_more');


// Replace WP local jQuery with Google latest jQuery
function tz_google_jquery() {
	if (!is_admin()) {
		// comment out the next two lines to load the local copy of jQuery
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js', false, '1.3.2');
		wp_enqueue_script('jquery');
	}
}
add_action('init', 'tz_google_jquery');


// Add browser detection class to body tag
add_filter('body_class','tz_browser_body_class');
function tz_browser_body_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}

// Output the styling for the seperated Pings
function tz_list_pings($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment; ?>
<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
<?php }


// Make a custom login logo and link
function tz_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.get_bloginfo('template_directory').'/images/custom-login-logo.png) !important; background-size:auto !important; }
    </style>';
}
/*
function tz_wp_login_url() {
echo bloginfo('url');
}
*/
/*
function tz_wp_login_title() {
echo get_option('blogname');
}
*/

add_action('login_head', 'tz_custom_login_logo');
/*
add_filter('login_headerurl', 'tz_wp_login_url');
add_filter('login_headertitle', 'tz_wp_login_title');
*/


// Find and close unclosed xhtml tags
function close_tags($text) {
    $patt_open    = "%((?<!</)(?<=<)[\s]*[^/!>\s]+(?=>|[\s]+[^>]*[^/]>)(?!/>))%";
    $patt_close    = "%((?<=</)([^>]+)(?=>))%";

    if (preg_match_all($patt_open,$text,$matches))
    {
        $m_open = $matches[1];
        if(!empty($m_open))
        {
            preg_match_all($patt_close,$text,$matches2);
            $m_close = $matches2[1];
            if (count($m_open) > count($m_close))
            {
                $m_open = array_reverse($m_open);
                foreach ($m_close as $tag) $c_tags[$tag]++;
                foreach ($m_open as $k => $tag)    if ($c_tags[$tag]--<=0) $text.='</'.$tag.'>';
            }
        }
    }
    return $text;
}

// Content Limit
function content($num, $more_link_text = '(more...)') {  
$theContent = get_the_content($more_link_text);  
$output = preg_replace('/<img[^>]+./','', $theContent);  
$limit = $num+1;  
$content = explode(' ', $output, $limit);  
array_pop($content);  
$content = implode(" ",$content);  
$content = strip_tags($content, '<p><a><address><a><abbr><acronym><b><big><blockquote><br><caption><cite><class><code><col><del><dd><div><dl><dt><em><font><h1><h2><h3><h4><h5><h6><hr><i><img><ins><kbd><li><ol><p><pre><q><s><span><strike><strong><sub><sup><table><tbody><td><tfoot><tr><tt><ul><var>');
echo close_tags($content);
}

// Custom Comments Display
function tz_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-body">
			<?php echo "<a href=" . home_url() . "/users/" . $comment->user_id .  ">" . get_avatar($comment,$size='50') . "</a>"; ?>
			<div class="comment-author vcard cleafix">
				<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
			</div>			
			<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','') ?>
			</div>
			
			<?php if ($comment->comment_approved == '0') : ?>
			<em><?php _e('Your comment is awaiting moderation.') ?></em>
			<br />
			<?php endif; ?>
			
			<div class="comment-text"><?php comment_text() ?></div>		
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>	
		</div>
<?php
        }


// Add the 125x125 Ad Block Custom Widget
include("functions/widget-ad125.php");

// Add the 300x250 Ad Block Custom Widget
include("functions/widget-ad300x250.php");

// Add the 120x240 Ad Block Custom Widget
include("functions/widget-ad120x240.php");

// Add the Latest Tweets Custom Widget
include("functions/widget-tweets.php");


// Add the Latest Habs Tweets Custom Widget
include("functions/widget-habs-list-tweets.php");

// Add the HIO Latest Tweets Custom Widget
include("functions/widget-hio-list-tweets.php");

// Add the Flickr Photos Custom Widget
include("functions/widget-flickr.php");

// Add the Custom Video Widget
include("functions/widget-video.php");

// Add the Custom Tabbed Widget
include("functions/widget-tabbed.php");

// Add the Shortcodes
include("functions/theme-shortcodes.php");

// Add the Theme Options Pages
include("functions/theme-options.php");

/*
// HIO Show custom post-type
function create_post_type() {  
    register_post_type( 'hio_show',  
        array(  
            'labels' => array(  
                'name' => __( 'Shows' ),  
                'singular_name' => __( 'Show' )  
            ),  
        'public' => true,  
        'menu_position' => 5,  
        'rewrite' => array('slug' => 'shows')  
        )  
    );  
}  
  
add_action( 'init', 'create_post_type' );

//Hio Show Featured Image Support
add_theme_support('post-thumbnails');
function setup_types() {
    register_post_type('hio_show', array(
        'label' => __('hio_show'),
        'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
        'show_ui' => true,
    ));
}
*/

add_action('init', 'setup_types');

add_action('thesis_hook_byline_item','fb_share');




/*
//ooyala video id custom field on every post
add_action('wp_insert_post', 'mk_set_default_custom_fields');
 
function mk_set_default_custom_fields($post_id)
{
    if ( $_GET['post_type'] != 'page' ) {
 
       add_post_meta($post_id, 'ooyala_id', true);
    }
    
    return true;
}
*/







/*<?php

add_filter( 'stylesheet_uri', 'my_stylesheet', 10, 2 );

function my_stylesheet( $stylesheet_uri, $stylesheet_dir_uri ) {

	if ( is_page( 'show' ) )
		$stylesheet_uri = $stylesheet_dir_uri . '/style-show.css';
	return $stylesheet_uri;
}

?>*/


//Hio Show Featured Post Support
/*add_filter( 'pre_get_posts', 'my_get_posts' );

		function my_get_posts( $query ) {

			if ( ( is_home() && $query->is_main_query() )
			$query->set( 'post_type', array( 'post', 'hio_show' ) );

		return $query;
		}*/

/*
Plugin Name: Category pagination fix
Plugin URI: http://www.htmlremix.com/projects/category-pagination-wordpress-plugin
Description: Fixes 404 page error in pagination of category page while using custom permalink
Version: 2.0
Author: Remiz Rahnas
Author URI: http://www.htmlremix.com

Copyright 2009 Creative common (email: mail@htmlremix.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You are allowed to use, change and redistibute without any legal issues. I am not responsible for any damage caused by this program. Use at your own risk
Tested with WordPress 2.7, 2.8.4 only. Works with wp-pagenavi
*/

/**
* This plugin will fix the problem where next/previous of page number buttons are broken on list
* of posts in a category when the custom permalink string is:
* /%category%/%postname%/
* The problem is that with a url like this:
* /categoryname/page/2
* the 'page' looks like a post name, not the keyword "page"
*/
function remove_page_from_query_string($query_string)
{
if ($query_string['name'] == 'page' && isset($query_string['page'])) {
unset($query_string['name']);
// 'page' in the query_string looks like '/2', so i'm spliting it out
list($delim, $page_index) = split('/', $query_string['page']);
$query_string['paged'] = $page_index;
}
return $query_string;
}
// I will kill you if you remove this. I died two days for this line
add_filter('request', 'remove_page_from_query_string');
?>
<?php

define('MY_WORDPRESS_FOLDER',$_SERVER['DOCUMENT_ROOT']);
define('deadline',str_replace('\\','/',dirname(__FILE__)));
define('MY_THEME_PATH','/' . substr(deadline,stripos(deadline,'wp-content')));

add_action('admin_init','ooyala_id_init');

function ooyala_id_init()
{
	// review the function reference for parameter details
	// http://codex.wordpress.org/Function_Reference/wp_enqueue_script
	// http://codex.wordpress.org/Function_Reference/wp_enqueue_style

	//wp_enqueue_script('my_meta_js', MY_THEME_PATH . '/custom/meta.js', array('jquery'));
	wp_enqueue_style('ooyala_id_css', MY_THEME_PATH . '/custom/meta.css');

	// review the function reference for parameter details
	// http://codex.wordpress.org/Function_Reference/add_meta_box

	foreach (array('post','page') as $type) 
	{
		add_meta_box('my_all_meta', 'HIO Show', 'ooyala_id_setup', $type, 'normal', 'high');
	}
	
	add_action('save_post','ooyala_id_save');
}

function ooyala_id_setup()
{
	global $post;
 
	// using an underscore, prevents the meta variable
	// from showing up in the custom fields section
	$meta = get_post_meta($post->ID,'_ooyala_id',TRUE);
 
	// instead of writing HTML here, lets do an include
	include(deadline . '/custom/meta.php');
 
	// create a custom nonce for submit verification later
	echo '<input type="hidden" name="ooyala_id_noncename" value="' . wp_create_nonce(__FILE__) . '" />';
}
 
function ooyala_id_save($post_id) 
{
	// authentication checks

	// make sure data came from our meta box
	if (!wp_verify_nonce($_POST['ooyala_id_noncename'],__FILE__)) return $post_id;

	// check user permissions
	if ($_POST['post_type'] == 'page') 
	{
		if (!current_user_can('edit_page', $post_id)) return $post_id;
	}
	else 
	{
		if (!current_user_can('edit_post', $post_id)) return $post_id;
	}

	// authentication passed, save data

	// var types
	// single: _my_meta[var]
	// array: _my_meta[var][]
	// grouped array: _my_meta[var_group][0][var_1], _my_meta[var_group][0][var_2]

	$current_data = get_post_meta($post_id, '_ooyala_id', TRUE);	
 
	$new_data = $_POST['_ooyala_id'];

	ooyala_id_clean($new_data);
	
	if ($current_data) 
	{
		if (is_null($new_data)) delete_post_meta($post_id,'_ooyala_id');
		else update_post_meta($post_id,'_ooyala_id',$new_data);
	}
	elseif (!is_null($new_data))
	{
		add_post_meta($post_id,'_ooyala_id',$new_data,TRUE);
	}

	return $post_id;
}

function ooyala_id_clean(&$arr)
{
	if (is_array($arr))
	{
		foreach ($arr as $i => $v)
		{
			if (is_array($arr[$i])) 
			{
				ooyala_id_clean($arr[$i]);

				if (!count($arr[$i])) 
				{
					unset($arr[$i]);
				}
			}
			else 
			{
				if (trim($arr[$i]) == '') 
				{
					unset($arr[$i]);
				}
			}
		}

		if (!count($arr)) 
		{
			$arr = NULL;
		}
	}
}

?>
