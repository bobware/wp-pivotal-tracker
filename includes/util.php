<?php

/**
 * util.php
 */

function pr( $data, $return = false ) {
	$data = "\n<pre>\n" . print_r( $data, true ) . "\n</pre>\n";
	if ( true !== $return ) {
		echo $data;
	}
	return $data;
}