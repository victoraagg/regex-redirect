<?php
/*
Plugin Name: Regex redirect
Description: Redirect by given regex
Author: Víctor Alonso
Version: 1.0
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/class/RegexRedirect.php';
use Regex\Redirect\RegexRedirect;

function custom_regex_redirect_old_site(){
    if(url_to_postid($_SERVER['REQUEST_URI']) === 0){
        RegexRedirect::redirect();
    }      
}
add_action('init', 'custom_regex_redirect_old_site');