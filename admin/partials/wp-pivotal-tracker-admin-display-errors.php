<?php

/**
 * Reusable snippet to display errors.
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

<?php if ( !empty( $pt_errors ) ): ?>
	<div class="notice notice-error">
		<h3>Errors!</h3>
<?php foreach( $pt_errors as $error ): ?>
		<p><?php echo $error; ?></p>
<?php endforeach; ?>
<?php if ( count( $pt_errors ) > 1 ): ?>
		<hr>
<?php endif; ?>
	</div>
<?php endif; ?>
