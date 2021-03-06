<?php
/*
Plugin Name: Navgu Email Logs
Plugin URI:  https://virson.wordpress.com/
Description: A custom wordpress plugin for Navgu website that provides email logs with filtering options and the ability to view email contents.
Version:     0.0.1a
Author:      Virson Ebillo
Author URI:  https://virson.wordpress.com/
*/

//Exit if accessed directly.
defined('ABSPATH') or exit;

//Define our constants
define('NEL_DIR_URL', preg_replace('/\s+/', '', plugin_dir_url(__FILE__)));
define('NEL_DIR_PATH', preg_replace('/\s+/', '', plugin_dir_path(__FILE__)));

//Include the main class.
if( !class_exists( 'NAVGU\Classes\Email_Logs', false ) ){
	include_once NEL_DIR_PATH . 'classes/Email_Logs.php';
}

/**
 * Class would be available as a function
 * Note: Attach the version number as well
 */
function NEL(){
	return \NAVGU\Classes\Email_Logs::instance('0.0.1a');
}
NEL();