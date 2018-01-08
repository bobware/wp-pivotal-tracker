<?php
/**
 * wp-pivotal-tracker-admin-display-notice.php
 *
 */

$notice_type = trim( 'notice ' . $notice_type );

$message = !empty( $message ) ? $message : 'Someone forgot the message...';

?>
<div class="<?php echo $notice_type; ?>">
	<p><?php echo $message; ?></p>
</div>