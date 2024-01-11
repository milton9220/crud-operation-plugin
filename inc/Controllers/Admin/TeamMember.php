<?php

namespace RulTeams\Inc\Controllers\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

class TeamMember {
	public static $errors = [];

	public function team_page() {
		$action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
		$id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;
		switch ( $action ) {
			case 'new':
				$template = __DIR__ . '/views/team-new.php';
				break;
			case 'edit':
				$team_member = get_rul_team_member( $id );
				$template    = __DIR__ . '/views/team-edit.php';
				break;
			case 'view':
				$template = __DIR__ . '/views/team-view.php';
				break;
			default:
				$template = __DIR__ . '/views/team-list.php';
				break;
		}
		if ( file_exists( $template ) ) {
			include $template;
		}
	}

	public static function form_handler() {
		if ( ! isset( $_POST['submit_team_member'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'rul_add_team_nonce' ) ) {
			wp_die( 'Access Denied' );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Access Denied' );
		}

		$id          = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;
		$name        = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
		$designation = isset( $_POST['designation'] ) ? sanitize_text_field( $_POST['designation'] ) : '';
		$member_id   = isset( $_POST['member_id'] ) ? sanitize_text_field( $_POST['member_id'] ) : '';
		$email       = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';

		if ( empty( $name ) ) {
			self::$errors['name'] = __( 'Please provide a name', 'rul-teams' );
		}

		if ( empty( $designation ) ) {
			self::$errors['designation'] = __( 'Please provide member designation.', 'rul-teams' );
		}
		if ( empty( $member_id ) ) {
			self::$errors['member_id'] = __( 'Please provide member id.', 'rul-teams' );
		}

		if ( ! empty( self::$errors ) ) {
			return;
		}
		$args = [
			'name'        => $name,
			'designation' => $designation,
			'member_id'   => $member_id,
			'email'       => $email,
		];
		if ($id){
			$args['id'] = $id;
		}
		$insert_id = rul_team_members_insert( $args );

		if ( is_wp_error( $insert_id ) ) {
			wp_die( $insert_id->get_error_message() );
		}
		if ($id){
			$redirected_to = admin_url( 'admin.php?page=rul_teams&action=edit&team-update=true&id='.$id );
		}else{
			$redirected_to = admin_url( 'admin.php?page=rul_teams&inserted=success' );
		}
		wp_redirect( $redirected_to );
		exit;
	}
	public function delete_rul_team_member() {
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'rul-team-member-delete' ) ) {
			wp_die( 'Access Denied' );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Access Denied' );
		}

		$id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;

		if ( rul_team_member_delete( $id ) ) {
			$redirected_to = admin_url( 'admin.php?page=rul_teams&rul-team-member-deleted=true' );
		} else {
			$redirected_to = admin_url( 'admin.php?page=rul_teams&rul-team-member-deleted=false' );
		}

		wp_redirect( $redirected_to );
		exit;
	}
}