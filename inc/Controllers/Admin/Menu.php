<?php
namespace RulTeams\Inc\Controllers\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

class Menu{
	private $parent_menu_slug='rul_teams';
	private $capability='manage_options';
	public function __construct() {
		add_action('admin_menu',[$this,'admin_menu']);
	}
	public function admin_menu(  ) {
		add_menu_page(
			__('Rul Teams','rul-teams'),
			__('Rul Teams','rul-teams'),
			$this->capability,
			$this->parent_menu_slug,
			[$this,'team_member_page'],
			'dashicons-businessperson',
			20
		);
		add_submenu_page('rul_teams',__('Team Members','rul-teams'),__('Team Members','rul-teams'),$this->capability,$this->parent_menu_slug,[$this,'team_member_page']);
	}

	public function team_member_page(  ) {
		$team_member = new TeamMember();
		$team_member->team_page();
	}
}