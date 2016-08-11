<?php
/**************************************************
 * fix for wordpress 4.4 under
 **************************************************/

global $wp_version;
if($wp_version < "4.4")
{
	if (!function_exists('get_the_post_thumbnail_url')) {
		function get_the_post_thumbnail_url( $post = null, $size = 'post-thumbnail' ) {
			$post_thumbnail_id = get_post_thumbnail_id( $post );
			if ( ! $post_thumbnail_id ) {
				return false;
			}
			return wp_get_attachment_image_url( $post_thumbnail_id, $size );
		}
	}

	if (!function_exists('wp_get_attachment_image_url')) {
		function wp_get_attachment_image_url( $attachment_id, $size = 'thumbnail', $icon = false ) {
			$image = wp_get_attachment_image_src( $attachment_id, $size, $icon );
			return isset( $image['0'] ) ? $image['0'] : false;
		}
	}
}