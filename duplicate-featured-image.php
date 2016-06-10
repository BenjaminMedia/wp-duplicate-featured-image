<?php
/**
 * @package wp-duplicate-featured-image
 * Plugin Name: Duplicate Featured Image
 * Version: 0.3
 * Description: Auto set first attachment image as feature image, remove duplicate first image
 * Author: Niteco
 * Author URI: http://niteco.se/
 * Plugin URI: PLUGIN SITE HERE
 * Text Domain: wp-duplicate-featured-image
 * Domain Path: /languages
 */

// no limit time
ini_set('max_execution_time', 300);
error_reporting(E_ERROR);

// require helper
require_once dirname(__FILE__). '/helper.php';

add_action('wp_head', 'featured_image_hide_first_attachment');
/**
 * remove duplicate first image
 * @param $content
 * @return mixed|string
 */
function featured_image_hide_first_attachment() {
    ?>
<script type="text/javascript">
    var array_url = [];
    jQuery(document).ready(function() {
        jQuery('article.post img').each(function(index) {
            thumbnail_url = jQuery(this).attr('src');
            if (array_url[thumbnail_url]) {
                jQuery(this).hide();
            } else {
                array_url[thumbnail_url] = 1;
            }
        });
    });
</script>
    <?php
}

add_action('save_post', 'featured_image_set_first_attachment');
/**
 * auto set first attachment image as feature image
 * @param $post_id
 */
function featured_image_set_first_attachment ($post_id)
{
    // if this is just a revision
    if (wp_is_post_revision( $post_id ) )
        return;

    $helper = new featured_image_helper();
    $helper->set_post_thumbnail($post_id);
}

if (function_exists( 'add_theme_support' ))
{
    add_filter('manage_posts_columns', 'posts_columns', 5);
    add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);
}

function posts_columns($defaults)
{
    $defaults['wps_post_thumbs'] = __('Thumbs');
    return $defaults;
}

function posts_custom_columns($column_name, $id)
{
    if ($column_name === 'wps_post_thumbs') {
        echo the_post_thumbnail(array(125, 80));
    }
}