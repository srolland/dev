<?php


// Add right pullquote shortcode
function quote_right($atts, $content = null) {
	return '<span class="quote_right">'.$content.'</span>';
}

add_shortcode('quote_right', 'quote_right');

// Add left pullquote shortcode
function quote_left($atts, $content = null) {
	return '<span class="quote_left">'.$content.'</span>';
}

add_shortcode('quote_left', 'quote_left');

?>