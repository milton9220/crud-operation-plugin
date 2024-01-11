<?php

namespace RulTeams\Inc\Controllers\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . "wp-admin/includes/class-wp-list-table.php";
}

class TeamMembersList extends \WP_List_Table {
	function __construct() {
		parent::__construct( [
			'singular' => 'team member',
			'plural'   => 'team members',
			'ajax'     => false
		] );
	}

	function no_items() {
		_e( 'No members found', 'rul-teams' );
	}

	public function get_columns() {
		return [
			'cb'          => '<input type="checkbox" />',
			'name'        => __( 'Name', 'rul-teams' ),
			'designation' => __( 'Designation', 'rul-teams' ),
			'member_id'   => __( 'Member ID', 'rul-teams' ),
			'email'       => __( 'Email', 'rul-teams' ),
		];
	}

	protected function column_default( $item, $column_name ) {

		switch ( $column_name ) {
			case 'value':
				break;
			default:
				return isset( $item->$column_name ) ? $item->$column_name : '';
		}
	}

	public function column_name( $item ) {
		$actions = [];

		$actions['edit'] = sprintf( '<a href="%s" title="%s">%s</a>', admin_url( 'admin.php?page=rul_teams&action=edit&id=' . $item->id ), $item->id, __( 'Edit', 'rul-teams' ) );

		$actions['delete'] = sprintf( '<a href="%s" class="submitdelete" onclick="return confirm(\'Are you sure?\');" title="%s">%s</a>', wp_nonce_url( admin_url( 'admin-post.php?action=rul-team-member-delete&id=' . $item->id ), 'rul-team-member-delete' ), $item->id, __( 'Delete', 'rul-teams' ) );


		return sprintf(
			'<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url( 'admin.php?page=rul_teams&action=view&id' . $item->id ), $item->name, $this->row_actions( $actions )
		);
	}

	protected function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="rup_team_id[]" value="%d" />', $item->id
		);
	}

	function get_sortable_columns() {
		return [
			'name'        => [ 'name', true ],
			'designation' => [ 'designation', true ],
		];
	}
	function get_bulk_actions() {
		$actions = array(
			'trash'  => __( 'Move to Trash', 'rul-teams' ),
		);

		return $actions;
	}
	public function prepare_items() {
		$column   = $this->get_columns();
		$hidden   = [];
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = [ $column, $hidden, $sortable ];
		$per_page              = 2;
		$current_page          = $this->get_pagenum();
		$offset                = ( $current_page - 1 ) * $per_page;
		$args                  = [
			'number' => $per_page,
			'offset' => $offset,
		];
		if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
			$args['orderby'] = $_REQUEST['orderby'];
			$args['order']   = $_REQUEST['order'] ;
		}
		$search_term = isset($_REQUEST['s']) ? sanitize_text_field($_REQUEST['s']) : '';
		if ($search_term){
			$args['search_name'] = $search_term;
		}

		$this->items           = rul_team_members_fetch( $args );

		$this->set_pagination_args( [
			'total_items' => rul_team_members_count(),
			'per_page'    => $per_page
		] );
	}
}