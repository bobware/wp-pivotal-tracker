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
	<h1>Bob WP PT Admin Display!</h1>
	<p>Here I am!</p>
	<h2>Data, if any</h2>
	<pre><?php print_r( $pt_data ); ?></pre>
</div>
