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
// display errors, if any
include_once 'wp-pivotal-tracker-admin-display-errors.php'; 
?>

<?php if ( !empty( $pt_data ) ): ?>
<?php foreach( $pt_data as $story ): ?>
	<div class="wrap">
		<h3><?php echo stripslashes( $story['name'] ); ?></h3>
		<p><?php echo stripslashes( $story['description'] ); ?></p>
	<?php if ( !empty( $story['labels'] ) ): ?>
		<h4>Labels</h4>
		<ul>
		<?php foreach( $story['labels'] as $label ): ?>
			<li><span><?php echo stripslashes( $label['name'] ); ?></span></li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	</div>
	<hr>
<?php endforeach; ?>
<?php endif; ?>
</div>
