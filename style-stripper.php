<?php 
/*
Plugin Name: Style Stripper
Plugin URI: http://judenware.com/projects/wordpress/style-stripper/
Description: Removes all inline style tags from the content of posts/pages/custom post types.
Author: ericjuden
Version: 1.0
Author URI: http://www.judenware.com
Network: true
*/

class Style_Stripper {
	private $done;
	
	function __construct(){
	    add_action('add_meta_boxes', array(&$this, 'show_filtered_content'), 1, 2);
		add_filter('the_content', array(&$this, 'filter_content'));
	}
	
    function clean_content($content){	
		// Search $content for style='' and style="" and remove
		$patterns = array('/(<[^>]+) style=".*?"/i', "/(<[^>]+) style='.*?'/i");
		$content = preg_replace($patterns, '$1', $content);
		
		return apply_filters('style_stripper_strip_styles', $content);
	}
	
	function filter_content($content){
	    $content = $this->clean_content($content);
	    return $content;
	}
	
	function show_filtered_content($post_type, $post){
	    $post->post_content = $this->clean_content($post->post_content);
	}
}
$style_stripper = new Style_Stripper();
?>