<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://8-b.co
 * @since      1.0.0
 *
 * @package    Wp_Pivotal_Tracker
 * @subpackage Wp_Pivotal_Tracker/admin/partials
 */
?>

<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

<?php 
// use notice hooks instead!
// display errors, if any
include_once 'wp-pivotal-tracker-admin-display-errors.php'; 
?>

	<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
		<?php /* to emulate native WP forms */ ?>
		<table class="form-table">
			<tr>
				<th scope="row">
					<label for="name">Name</label>
				</th>
				<td>
					<input type="text" name="name" id="name" value="<?php echo $data['name']; ?>" class="regular-text">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="description">Description</label>
				</th>
				<td>
					<textarea name="description" id="description" cols="80" rows="10" class=""><?php echo $data['description']; ?></textarea>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="labels">Labels</label>
				</th>
				<td>
					<input type="text" name="labels" id="labels" value="<?php echo $data['labels']; ?>" class="regular-text">
				</td>
			</tr>
		</table>
		<input type="hidden" name="action" value="<?php echo $pt_action; ?>">
		<?php
			wp_nonce_field('add-story', '_add_story' );
			submit_button();
		?>
	</form>
</div>
