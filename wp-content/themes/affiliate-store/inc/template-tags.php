<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Affiliate Store
 */

if ( ! function_exists( 'affiliate_store_the_attached_image' ) ) :
/**
 * Prints the attached image with a link to the next attached image.
 */
function affiliate_store_the_attached_image() {
	$post                = get_post();
	$attachment_size     = apply_filters( 'affiliate_store_attachment_size', array( 1200, 1200 ) );
	$next_attachment_url = wp_get_attachment_url();
	$attachment_ids 	 = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	wp_reset_postdata();

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category
 */
function affiliate_store_categorized_blog() {
	if ( false === ( $affiliate_store_all_the_cool_cats = get_transient( 'affiliate_store_all_the_cool_cats' ) ) ) {
		$affiliate_store_all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		$affiliate_store_all_the_cool_cats = count( $affiliate_store_all_the_cool_cats );

		set_transient( 'affiliate_store_all_the_cool_cats', $affiliate_store_all_the_cool_cats );
	}

	if ( '1' != $affiliate_store_all_the_cool_cats ) {
		return true;
	} else {
		return false;
	}
}

if ( ! function_exists( 'affiliate_store_the_custom_logo' ) ) :
	/**
	 * Displays the optional custom logo.
	 *
	 * Does nothing if the custom logo is not available.
	 *
	 * @since affiliate-store
	 */
	function affiliate_store_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			if( has_custom_logo() ){
				the_custom_logo();
			}else{
				echo "<a href='".esc_url( home_url() )."' rel='home'><img src='".esc_url(get_template_directory_uri())."/images/Logo.png' alt='" . esc_attr__("Affiliate Store logo", 'affiliate-store') . "'/></a>";
			}
		}
	}
endif;


/**
 * Flush out the transients used in affiliate_store_categorized_blog
 */
function affiliate_store_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'affiliate_store_all_the_cool_cats' );
}
add_action( 'edit_category', 'affiliate_store_category_transient_flusher' );
add_action( 'save_post',     'affiliate_store_category_transient_flusher' );