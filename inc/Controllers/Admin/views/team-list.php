<div class="wrap">
	<h1 class="wp-heading-inline"><?php esc_html_e('Team Members','rul-teams'); ?></h1>
	<a class="page-title-action" href="<?php echo esc_url(admin_url('admin.php?page=rul_teams&action=new')); ?>"><?php esc_html_e("Add New","rul-teams"); ?></a>
	<?php if ( isset( $_GET['inserted'] ) ) { ?>
        <div class="notice notice-success">
            <p><?php _e( 'Team Member has been added successfully!', 'rul-teams' ); ?></p>
        </div>
	<?php } ?>
	<?php if ( isset( $_GET['rul-team-member-deleted'] ) && $_GET['rul-team-member-deleted'] == true ) {
        ?>
        <div class="notice notice-success">
            <p><?php _e( 'Team Member has been delete successfully!', 'rul-teams' ); ?></p>
        </div>
	<?php } ?>
    <?php
    $table = new RulTeams\Inc\Controllers\Admin\TeamMembersList();
    $table->prepare_items();
    ?>
    <form  method="get">
		<?php
		$table->search_box('Search','search_box');
		$table->display();
		?>
        <input type="hidden" name="page" value="rul_teams">
    </form>
</div>