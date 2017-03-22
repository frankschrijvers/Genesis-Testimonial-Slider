<?php
/**
 * This file adds the options to the Admin.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Register a metabox and default settings for the Genesis Simple Logo.
 *
 * @package Genesis\Admin
 */
class WPSTUDIO_GTS_Settings extends Genesis_Admin_Boxes {

	/**
	 * Create an archive settings admin menu item and settings page for relevant custom post types.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$settings_field = 'gts-settings';
		$page_id = 'genesis-testimonials';
		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'genesis',
				'page_title'  => __( 'Genesis Testimonial Settings', 'gts-widget' ),
				'menu_title'  => __( 'Testimonials', 'gts-widget' ),
			),
		);
		$page_ops = array(); // use defaults.
		$center = current_theme_supports( 'genesis-responsive-viewport' ) ? 'mobile' : 'never';
		$default_settings = apply_filters(
			'gsw_settings_defaults',
			array(
				'gts_autoplay'      => 'yes',
				'gts_column'		=> 'one',
				'gts_controls'      => 'yes',
				'gts_loop'		 => 'no',
				'gts_effect'        => 'slide',
				'gts_pause'         => 'yes',
				'gts_speed'         => '6000',
			)
		);
		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );
		add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitizer_filters' ) );
	}
	/**
	 * Register each of the settings with a sanitization filter type.
	 *
	 * @since 1.0.0
	 * @uses genesis_add_option_filter() Assign filter to array of settings.
	 * @see \Genesis_Settings_Sanitizer::add_filter()
	 */
	public function sanitizer_filters() {
		genesis_add_option_filter(
			'no_html',
			$this->settings_field,
			array(
				'gts_autoplay',
				'gts_column',
				'gts_controls',
				'gts_effect',
				'gts_loop',
				'gts_number',
				'gts_pause',
				'gts_speed',
			)
		);
	}
	/**
	 * Register Metabox for the Genesis Simple Logo.
	 *
	 * @uses  add_meta_box()
	 * @since 1.0.0
	 */
	function metaboxes() {
		add_meta_box( 'genesis-theme-settings-version', __( 'Plugin Information', 'gts-widget' ), array( $this, 'info_box' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'gts-settings', __( 'Plugin Settings', 'gts-widget' ), array( $this, 'gsw_settings' ), $this->pagehook, 'main', 'high' );
	}
	/**
	 * Create Metabox which links to and explains the WordPress customizer.
	 *
	 * @uses  wp_customize_url()
	 * @since 1.0.0
	 */
	function info_box() {

		echo '<ul>
		<li><strong style="width: 180px; margin: 0 40px 20px 0; display: inline-block; font-weight: 600;">' . __( 'Developed By:', 'glmb' ) . '</strong> <a href="https://www.wpstud.io" target="_blank">WPStudio</a></li>
		<li><strong style="width: 180px; margin: 0 40px 20px 0; display: inline-block; font-weight: 600;">' . __( 'Follow on twitter:', 'glmb' ) . '</strong> <a href="https://twitter.com/wpstudiowp">https://twitter.com/wpstudiowp</a></li>
		<li><strong style="width: 180px; margin: 0 40px 20px 0; display: inline-block; font-weight: 600;">' . __( 'Contact:', 'glmb' ) . '</strong> <a href="mailto:info@wpstud.io">info@wpstud.io</a></li>
	    </ul>';
	}

	/**
	 * Display Settings.
	 */
	function gsw_settings() {

		?>

		<p>
			<label style="width: 180px; margin: 0 40px 0 0; font-weight: bold; display: inline-block;" for="<?php echo $this->get_field_name( 'gts_effect' ); ?>"><?php _e( 'Effect:', 'gts-widget' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'gts_effect' ); ?>">
				<?php
				$positions = array( 'fade', 'slide' );
				foreach ( $positions as $position ) {
					echo '<option value="' . $position . '"' . selected( $this->get_field_value( 'gts_effect' ), '' . $position ) . '>' . $position . '</option>';
				}
				?>
			</select>

		</p>

		<p>
			<label style="width: 180px; margin: 0 40px 0 0; font-weight: bold; display: inline-block;" for="<?php echo $this->get_field_name( 'gts_autoplay' ); ?>"><?php _e( 'Auto play:', 'gts-widget' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'gts_autoplay' ); ?>">
				<?php
				$positions = array( 'yes', 'no' );
				foreach ( $positions as $position ) {
					echo '<option value="' . $position . '"' . selected( $this->get_field_value( 'gts_autoplay' ), '' . $position ) . '>' . $position . '</option>';
				}
				?>
			</select>

		</p>

		<p>
			<label style="width: 180px; margin: 0 40px 0 0; font-weight: bold; display: inline-block;" for="<?php echo $this->get_field_name( 'gts_controls' ); ?>"><?php _e( 'Show controls:', 'gts-widget' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'gts_controls' ); ?>">
				<?php
				$positions = array( 'yes', 'no' );
				foreach ( $positions as $position ) {
					echo '<option value="' . $position . '"' . selected( $this->get_field_value( 'gts_controls' ), '' . $position ) . '>' . $position . '</option>';
				}
				?>
			</select>

		</p>

		<p>
			<label style="width: 180px; margin: 0 40px 0 0; font-weight: bold; display: inline-block;" for="<?php echo $this->get_field_name( 'gts_pause' ); ?>"><?php _e( 'Pause on hover:', 'gts-widget' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'gts_pause' ); ?>">
				<?php
				$positions = array( 'yes', 'no' );
				foreach ( $positions as $position ) {
					echo '<option value="' . $position . '"' . selected( $this->get_field_value( 'gts_pause' ), '' . $position ) . '>' . $position . '</option>';
				}
				?>
			</select>

		</p>

		<p>
			<label style="width: 180px; margin: 0 40px 0 0; font-weight: bold; display: inline-block;" for="<?php echo $this->get_field_name( 'gts_loop' ); ?>"><?php _e( 'Loop:', 'gts-widget' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'gts_loop' ); ?>">
				<?php
				$positions = array( 'yes', 'no' );
				foreach ( $positions as $position ) {
					echo '<option value="' . $position . '"' . selected( $this->get_field_value( 'gts_loop' ), '' . $position ) . '>' . $position . '</option>';
				}
				?>
			</select>

		</p>

		<p>
			<label style="width: 180px; margin: 0 40px 0 0; font-weight: bold; display: inline-block;" for="<?php echo $this->get_field_name( 'gts_speed' ); ?>"><?php _e( 'Speed:', 'gts-widget' ); ?></label>
			<input type="text" data-default-color="#ffffff" name="<?php echo $this->get_field_name( 'gts_speed' );?>" id="<?php echo $this->get_field_id( 'gts_speed' );?>?" value="<?php echo $this->get_field_value( 'gts_speed' ); ?>"/> ms
		</p>

		<p>
			<label style="width: 180px; margin: 0 40px 0 0; font-weight: bold; display: inline-block;" for="<?php echo $this->get_field_name( 'gts_column' ); ?>"><?php _e( 'Columns:', 'gts-widget' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'gts_column' ); ?>">
				<?php
				$positions = array( 'one', 'two', 'three' );
				foreach ( $positions as $position ) {
					echo '<option value="' . $position . '"' . selected( $this->get_field_value( 'gts_column' ), '' . $position ) . '>' . $position . '</option>';
				}
				?>
			</select>

		</p>

		<p>
			<label style="width: 180px; margin: 0 40px 0 0; font-weight: bold; display: inline-block;" for="<?php echo $this->get_field_name( 'gts_image' ); ?>"><?php _e( 'Position Image:', 'gts-widget' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'gts_image' ); ?>">
				<?php
				$positions = array( 'top', 'bottom' );
				foreach ( $positions as $position ) {
					echo '<option value="' . $position . '"' . selected( $this->get_field_value( 'gts_image' ), '' . $position ) . '>' . $position . '</option>';
				}
				?>
			</select>

		</p>

		<?php
	}
}
