<?php
/**
 * This file displays the testimonials on the front end.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

echo '<div id="gts-testimonials"><div class="wrap">';
echo '<ul class="testimonials-list">';

$loop = new WP_Query( array(
	'post_type' => 'Testimonial',
	'posts_per_page' => -1,
) );

/**
 * Opening Markup.
 */
function gts_markup_open() {
	echo '<li itemprop="review" itemscope itemtype="http://schema.org/Review">';
}

/**
 * Testimonial Image Top.
 */
function gts_image_top() {

	if ( genesis_get_option( 'gts_image', 'gts-settings' ) === 'top' && has_post_thumbnail() ) {

		echo the_post_thumbnail( 'gts-thumbnail' );

	}
}

/**
 * Testimonial Rating.
 */
function gts_rating() {

	$rating = get_post_meta( get_the_ID(), '_gts_rating', true );

	if ( ! empty( $rating ) ) {

		echo '<div class="gts-rating">';
		echo sprintf( '<span class="screen-reader-text" itemprop="reviewRating">%s</span>', $rating );

		// Loop through rating number and display star.
		for ( $i = 0; $i < $rating ; $i++ ) {
			echo '<span class="star"></span>';
		}

		echo '</div>';
	}

}

/**
 * Testimonial Content.
 */
function gts_content() {
	echo '<blockquote itemprop="reviewBody">' . get_the_content() . '</blockquote>';
}

/**
 * Testimonial Title.
 */
function gts_title() {
	echo '<h5 itemprop="name">' . get_the_title() . '</h5>';
}

/**
 * Testimonial Image Bottom.
 */
function gts_image_bottom() {

	if ( genesis_get_option( 'gts_image', 'gts-settings' ) === 'bottom' && has_post_thumbnail() ) {

		echo the_post_thumbnail( 'gts-thumbnail' );

	}
}

/**
 * Testimonial Company.
 */
function gts_company() {

	$company = get_post_meta( get_the_ID(), '_gts_company', true );

	if ( ! empty( $company ) ) {
		echo wp_kses_post( sprintf( '<span class="gts-company">%s</span>', $company ) );
	}
}


/**
 * Closing Markup.
 */
function gts_markup_close() {
	echo '</li>';
}

// Add actions to hook.
add_action( 'gts', 'gts_markup_open', 2 );
add_action( 'gts', 'gts_image_top', 4 );
add_action( 'gts', 'gts_rating', 6 );
add_action( 'gts', 'gts_content', 8 );
add_action( 'gts', 'gts_title', 10 );
add_action( 'gts', 'gts_image_bottom', 9 );
add_action( 'gts', 'gts_company', 12 );
add_action( 'gts', 'gts_markup_close', 14 );

while ( $loop->have_posts() ) : $loop->the_post();

	// Run hook.
	do_action( 'gts' );

endwhile;

wp_reset_postdata();

echo '</ul></div></div>';
