<?php
/*
Plugin Name: Lite Google Map
Plugin URI:https://wordpress.org/plugins/lite-google-map
Description: WP Google Maps is a simple Lite Version of Google Map.
Author: B.M. Rafiul Alam
Author URI: https://themeforest.net/user/3rtheme/portfolio
Text Domain: gmap
Version: 1.2
*/

if ( file_exists( dirname( __FILE__ ) . '/inc/settings.php' ) ) {
	require_once dirname( __FILE__ ). '/inc/settings.php';
}
if ( file_exists( dirname( __FILE__ ) . '/map-functions.php' ) ) {
	require_once dirname( __FILE__ ). '/map-functions.php';
}
if ( file_exists( dirname( __FILE__ ) . '/inc/lib/cmb2-radio-image.php' ) ) {
	require_once dirname( __FILE__ ). '/inc/lib/cmb2-radio-image.php';
}
if ( file_exists( dirname( __FILE__ ) . '/inc/lib/cmb2-yesno-field.php' ) ) {
	require_once dirname( __FILE__ ). '/inc/lib/cmb2-yesno-field.php';
}