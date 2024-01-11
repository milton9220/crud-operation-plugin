<?php
function rul_team_members_insert( $args = [] ) {
	global $wpdb;

	if ( empty( $args['name'] ) ) {
		return new \WP_Error( 'no-name', __( 'You must provide a name.', 'rul-teams' ) );
	}

	$defaults = [
		'name'        => '',
		'designation' => '',
		'member_id'   => '',
		'email'       => '',
	];

	$data = wp_parse_args( $args, $defaults );

	if (isset($data['id'])){
		$id = $data['id'];
		unset($data['id']);
		$updated = $wpdb->update(
			$wpdb->prefix . 'rul_team_members',
			$data,
			['id' => $id],
			[
				'%s',
				'%s',
				'%s',
				'%s'
			],
			['%d']
		);
		return $updated;
	}else{
		$inserted = $wpdb->insert(
			$wpdb->prefix . 'rul_team_members',
			$data,
			[
				'%s',
				'%s',
				'%s',
				'%s'
			]
		);

		if ( ! $inserted ) {
			return new \WP_Error( 'failed-to-insert', __( 'Failed to insert data', 'rul-teams' ) );
		}

		return $wpdb->insert_id;
	}

}

function rul_team_members_fetch( $args = [] ) {
	global $wpdb;
	$search_name ='';
	$defaults = [
		'number'  => 20,
		'offset'  => 0,
		'orderby' => 'id',
		'order'   => 'DESC'
	];

	$args = wp_parse_args( $args, $defaults );
	if (isset($args['search_name'])){
		$search_name = $args['search_name'];
	}
	$sql = $wpdb->prepare(
		"SELECT * FROM {$wpdb->prefix}rul_team_members
            WHERE name LIKE %s
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
		'%' . $wpdb->esc_like($search_name) . '%',
		$args['offset'], $args['number']
	);

	$team_members = $wpdb->get_results( $sql );

	return $team_members;
}
function rul_team_members_count() {
	global $wpdb;

	return (int) $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}rul_team_members" );
}
function get_rul_team_member( $id ) {
	global $wpdb;

	return $wpdb->get_row(
		$wpdb->prepare( "SELECT * FROM {$wpdb->prefix}rul_team_members WHERE id = %d", $id )
	);
}
function rul_team_member_delete( $id ) {
	global $wpdb;

	return $wpdb->delete(
		$wpdb->prefix . 'rul_team_members',
		[ 'id' => $id ],
		[ '%d' ]
	);
}
