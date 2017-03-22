<?php
/**
 * This file displays the shortcode output.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Shortcode Output.
 *
 * @return string $data The shortcode output.
 */
function wps_carouselle(){

	ob_start();

	include( dirname( __FILE__ ) . '/gts-frontend.php' );

	$data = ob_get_clean();

	return $data;

}

add_shortcode( 'gts-slider', 'wps_carouselle' );
