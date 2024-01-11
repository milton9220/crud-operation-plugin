<?php
namespace RulTeams\Inc\Base;

class Install{
	public static function activate(){
		
		self::create_db_table();

		flush_rewrite_rules();
	}

	public static function create_db_table(  ) {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name=$wpdb->prefix.'rul_team_members';
		$sql="CREATE TABLE {$table_name} (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(250),
        designation VARCHAR(250),
        member_id VARCHAR(250),
        email VARCHAR(230),
        PRIMARY KEY (id)
	    ) $charset_collate";

		require_once (ABSPATH."wp-admin/includes/upgrade.php");
		dbDelta($sql);
	}

	public static function deactivate(  ) {
			global $wpdb;
			$table_name=$wpdb->prefix.'rul_team_members';
			$query="TRUNCATE TABLE {$table_name}";
			$wpdb->query($query);
	}
}