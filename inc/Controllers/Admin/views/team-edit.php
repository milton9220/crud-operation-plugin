<div class="team-list-wrapper">
	<h1><?php esc_html_e('Edit Team Member','rul-teams'); ?></h1>
	<?php if ( isset( $_GET['team-update'] ) ) { ?>
        <div class="notice notice-success">
            <p><?php _e( 'Team Member has been updated successfully!', 'rul-teams' ); ?></p>
        </div>
	<?php } ?>
	<form action="" method="post">
		<table class="form-table">
			<tbody>
			<tr>
				<th scope="row">
					<label for="name"><?php esc_html_e('Name','rul-teams'); ?></label>
				</th>
				<td>
					<input type="text" name="name" id="name" value="<?php echo esc_attr($team_member->name); ?>" class="regular-text">
					<?php if (!empty(self::$errors['name'])){
						?>
						<p style="color:red"><?php esc_html_e("Please Provide team member name","rul-teams"); ?></p>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="designation"><?php esc_html_e('Designation','rul-teams'); ?></label>
				</th>
				<td>
					<input type="text" name="designation" id="designation" value="<?php echo esc_attr($team_member->designation); ?>" class="regular-text">
					<?php if (!empty(self::$errors['designation'])){
						?>
						<p style="color:red"><?php esc_html_e("Please Provide team member designation","rul-teams"); ?></p>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="member_id"><?php esc_html_e('ID','rul-teams'); ?></label>
				</th>
				<td>
					<input type="text" name="member_id" id="member_id" value="<?php echo esc_attr($team_member->member_id); ?>" class="regular-text">
					<?php if (!empty(self::$errors['member_id'])){
						?>
						<p style="color:red"><?php esc_html_e("Please Provide team member id","rul-teams"); ?></p>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="email"><?php esc_html_e('Email','rul-teams'); ?></label>
				</th>
				<td>
					<input type="email" name="email" id="email" value="<?php echo esc_attr($team_member->email); ?>" class="regular-text">
				</td>
			</tr>
			</tbody>
		</table>
		<?php wp_nonce_field('rul_add_team_nonce'); ?>
		<input type="hidden" name="id" value="<?php echo esc_attr( $team_member->id ); ?>">
		<?php submit_button(__('Edit Member','rul-teams'),'primary','submit_team_member'); ?>
	</form>
</div>