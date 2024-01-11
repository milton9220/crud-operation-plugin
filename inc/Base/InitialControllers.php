<?php
namespace RulTeams\Inc\Base;
use RulTeams\Inc\Controllers\Admin\TeamMember;
use RulTeams\Inc\Traits\Constants;
use RulTeams\Inc\Controllers\Admin\Menu;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

class InitialControllers{
	use Constants;
	function register(){
		$this->load_hooks();
	}
	private function load_hooks() {
		register_activation_hook( self::get_file_locations('plugin'), [ Install::class, 'activate' ] );
//		register_deactivation_hook( $this->plugin, [ Install::class, 'deactivate' ] );
		add_action('plugins_loaded',array($this,'rul_teams_loaded_text_domain'));
		if (is_admin()){
			add_action('init',[$this,'admin_settings_page'],99);
		}

	}

	public function rul_teams_loaded_text_domain(){
		load_plugin_textdomain( 'rul-teams ', false, self::get_file_locations('plugin_path')."languages" );
	}

	public function admin_settings_page(  ) {
		new Menu();
		$this->team_actions();
	}

	public function team_actions(  ) {
		add_action('admin_init',[TeamMember::class,'form_handler']);
		add_action('admin_post_rul-team-member-delete',[TeamMember::class,'delete_rul_team_member']);
	}
}