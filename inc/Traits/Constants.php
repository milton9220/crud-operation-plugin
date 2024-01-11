<?php
namespace RulTeams\Inc\Traits;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
trait Constants{
	public static $plugin_version = "1.0.0";
	private static $plugin_path;
	private static $plugin_url;
	private static $plugin;
	public static function get_file_locations($location_type){

		if('plugin_path'==$location_type){
			return self::$plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
		}else if('plugin_url'==$location_type){
			return self::$plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
		}elseif('plugin'==$location_type){
			return self::$plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/rul-teams.php';
		}else{
			return self::$plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
		}


	}
	public static function get_template_path() {
		return apply_filters( 'gym_builder_template_path', 'rul-teams/' );
	}
}