<?php
/****
Plugin Name:Rul Teams
Plugin URI:
Author: milton
Author URI:
Description: This is a rul teams plugin
Version: 1.0.0
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Text Domain:rul-teams
 ******/

if(! defined('ABSPATH')){
	die;
}



if(file_exists(dirname(__FILE__).'/vendor/autoload.php')){
	require_once dirname(__FILE__).'/vendor/autoload.php';
}
if(class_exists('RulTeams\\Inc\\Init')){
	RulTeams\Inc\Init::register_services();
}