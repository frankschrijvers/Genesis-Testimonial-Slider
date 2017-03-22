<?php
/**
 * This file adds the testimonial company class.
 */

/**
 * Calls the class on the testimonial edit screen.
 */
function call_gts_company() {
	new GTS_Company();
}

if ( is_admin() ) {
	add_action( 'load-post.php',     'call_gts_company' );
	add_action( 'load-post-new.php', 'call_gts_company' );
}

/**
 * The Class.
 */
class GTS_Company {

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	/**
	 * Adds the meta box container.
	 *
	 * @param string $post_type Current post type.
	 */
	public function add_meta_box( $post_type ) {

		// Limit meta box to certain post types.
		if ( 'testimonial' === $post_type ) {
		    add_meta_box(
		        'gts_company_meta_box',
		        __( 'Company Name', 'gts-plugin' ),
		        array( $this, 'render_meta_box_content' ),
		        $post_type,
		        'side',
		        'default'
		    );
		}
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id ) {

		/**
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['gts_company_inner_custom_box_nonce'] ) ) {
		    return $post_id;
		}

		$nonce = $_POST['gts_company_inner_custom_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'gts_company_inner_custom_box' ) ) {
		    return $post_id;
		}

		/*
		 * If this is an autosave, our form has not been submitted,
		 * so we don't want to do anything.
		 */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		    return $post_id;
		}

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {
		    if ( ! current_user_can( 'edit_page', $post_id ) ) {
		        return $post_id;
		    }
		} else {
		    if ( ! current_user_can( 'edit_post', $post_id ) ) {
		        return $post_id;
		    }
		}

		/* OK, it's safe for us to save the data now. */

		// Sanitize the user input.
		$company_data = sanitize_text_field( $_POST['gts_company'] );

		// Update the meta field.
		update_post_meta( $post_id, '_gts_company', $company_data );
	}

	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'gts_company_inner_custom_box', 'gts_company_inner_custom_box_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$value = get_post_meta( $post->ID, '_gts_company', true );

		// Display the form, using the current value.
		?>
		<label for="gts_company">
			<?php _e( 'Enter company name or job title', 'gts-plugin' ); ?>
		</label>
		<input type="text" id="gts_company" name="gts_company" value="<?php echo esc_attr( $value ); ?>" size="25" />
		<?php
	}
}
