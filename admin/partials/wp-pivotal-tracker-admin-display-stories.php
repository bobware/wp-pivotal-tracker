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
	<h3>Stories, if any</h3>
	<pre><?php print_r( $pt_data ); ?></pre>
	<hr>
</div>
