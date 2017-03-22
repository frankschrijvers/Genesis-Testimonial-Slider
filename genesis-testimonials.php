<?php
/**
 * Plugin Name: Genesis Testimonial Slider
 * Plugin URI: http://wpstud.io/plugins
 * Description: The Genesis Testimonials Slider is a simple-to-use plugin for adding Testimonials to your Genesis Theme, using a shortcode or a widget.
 * Version: 1.2
 * Author: Frank Schrijvers
 * Author URI: http://www.wpstud.io
 * Text Domain: gts-plugin
 * License: GPLv2
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define constants.
define( 'GTS_PLUGIN_VERSION', '1' );
define( 'GTS_RELEASE_DATE', 'february, 2015' );

require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

register_activation_hook( __FILE__, 'wpstudio_gts_activation_check' );
/**
 * This function runs on plugin activation. It checks to make sure the required
 * minimum Genesis version is installed. If not, it deactivates itself.
 */
function wpstudio_gts_activation_check() {

	$latest = '2.0';
	$theme_info = wp_get_theme( 'genesis' );

	if ( ! function_exists( 'genesis_pre' ) ) {

		deactivate_plugins( plugin_basename( __FILE__ ) ); // Deactivate plugin.
		wp_die( sprintf( __( 'Sorry, you can\'t activate %1$sGenesis Slide-in Widget unless you have installed the %3$sGenesis Framework%4$s. Go back to the %5$sPlugins Page%4$s.', 'genesis-overlay-widget' ), '<em>', '</em>', '<a href="http://www.studiopress.com/themes/genesis" target="_blank">', '</a>', '<a href="javascript:history.back()">' ) );
	}

	if ( version_compare( $theme_info['Version'], $latest, '<' ) ) {

		deactivate_plugins( plugin_basename( __FILE__ ) ); // Deactivate plugin.
		/* translators: Genesis Framework version check. */
		wp_die( sprintf( __( 'Sorry, you can\'t activate %1$sGenesis Slide-in Widget unless you have installed the %3$sGenesis %4$s%5$s. Go back to the %6$sPlugins Page%5$s.', 'genesis-overlay-widget' ), '<em>', '</em>', '<a href="http://www.studiopress.com/themes/genesis" target="_blank">', $latest, '</a>', '<a href="javascript:history.back()">' ) );

	}

}

/**
 * This function runs on plugin deactivation.
 */
function wpstudio_gts_deactivate_check() {

	if ( ! function_exists( 'genesis_pre' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) ); // Deactivate plugin.
	}

}
add_action( 'after_switch_theme', 'wpstudio_gts_deactivate_check' );

/**
 * Enqueue scripts and styles.
 */
function wpstudio_gts_load_scripts() {

	wp_enqueue_script( 'gts-lighslider', plugin_dir_url( __FILE__ ) . 'assets/js/lightslider.min.js', array( 'jquery' ) );
	wp_enqueue_style( 'lightslider-style', plugin_dir_url( __FILE__ ) . 'assets/css/lightslider.css', array() );
	wp_enqueue_style( 'gts-style', plugin_dir_url( __FILE__ ) . 'assets/css/gts-style.css', array() );

}
add_action( 'wp_enqueue_scripts', 'wpstudio_gts_load_scripts', 99 );

/**
 * Load required files.
 */
function wpstudio_gts_init() {

	require( dirname( __FILE__ ) . '/inc/gts-admin.php' );
	include( dirname( __FILE__ ) . '/inc/gts-company.php' );
	include( dirname( __FILE__ ) . '/inc/gts-rating.php' );
	include( dirname( __FILE__ ) . '/inc/gts-cpt.php' );
	include( dirname( __FILE__ ) . '/inc/gts-widget.php' );
	include( dirname( __FILE__ ) . '/inc/gts-shortcode.php' );
	new WPSTUDIO_gts_Settings();

}
add_action( 'genesis_admin_init', 'wpstudio_gts_init' );

// Image size for testimonial thumb.
add_image_size( 'gts-thumbnail', 100, 100, true );

/**
 * Init Lighslider Params.
 */
function gts_params() {

	if ( genesis_get_option( 'gts_autoplay', 'gts-settings' ) === 'yes' ) {
		$gts_autoplay = 'true';
	} else {
		$gts_autoplay = 'false';
	}

	if ( genesis_get_option( 'gts_controls', 'gts-settings' ) === 'yes' ) {
		$gts_controls = 'true';
	} else {
		$gts_controls = 'false';
	}

	if ( genesis_get_option( 'gts_column', 'gts-settings' ) === 'one' ) {
		$gts_column = '1';
	}

	if ( genesis_get_option( 'gts_column', 'gts-settings' ) === 'two' ) {
		$gts_column = '2';
	}

	if ( genesis_get_option( 'gts_column', 'gts-settings' ) === 'three' ) {
		$gts_column = '3';
	}

	if ( genesis_get_option( 'gts_effect', 'gts-settings' ) === 'fade' ) {
		$gts_effect = 'fade';
	} else {
		$gts_effect = 'slide';
	}

	if ( genesis_get_option( 'gts_pause', 'gts-settings' ) === 'yes' ) {
		$gts_pause = 'true';
	} else {
		$gts_pause = 'false';
	}

	if ( genesis_get_option( 'gts_loop', 'gts-settings' ) === 'yes' ) {
		$gts_loop = 'true';
	} else {
		$gts_loop = 'false';
	}

	$output = 'jQuery( document ).ready(function() {
                    jQuery( ".testimonials-list" ).lightSlider( {
						auto:           ' . $gts_autoplay . ',
                        controls:       ' . $gts_controls . ',
						item:           ' . $gts_column . ',
                        mode:           \'' . $gts_effect . '\',
                        pauseOnHover:   ' . $gts_pause . ',
                        loop:           ' . $gts_loop . ',
						pause:          ' . genesis_get_option( 'gts_speed' , 'gts-settings' ) . ',
						responsive : [
						    {
						        breakpoint:1023,
						        settings: {
						            item:2
						        }
						    },
						    {
						        breakpoint:860,
						        settings: {
						            item:1
						        }
						    }
						]
					} );
				} );';

	$output = str_replace( array( "\n", "\t", "\r" ), '', $output );

	echo '<script type=\'text/javascript\'>' . $output . '</script>';

}
add_action( 'wp_footer', 'gts_params' );
