<?php

add_shortcode( 'base_url', 'base_url_handler' );
function base_url_handler( $atts ) {
	return get_bloginfo('url');
}

add_shortcode( 'uploads_url', 'uploads_url_handler' );
function uploads_url_handler( $atts ) {
	$uploads_dir = wp_upload_dir();
	return $uploads_dir['baseurl'];
}

add_shortcode('select', 'select_handler');
function select_handler( $atts, $content = null ) {
	return '<label>What do you want to do?</label><div id="select-container"><select id="dynamic_select">
	<option selected="selected">Choose an option</option>
    <option value="'.get_bloginfo('url').'/get-a-sample/">Request a free design template</option>
    <option value="'.get_bloginfo('url').'/create-your-own/">Create your own design</option>
</select></div>';
}