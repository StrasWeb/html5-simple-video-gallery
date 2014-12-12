<?php
/**
 * Use OpenStreetMap in WordPress Events Manager
 * 
 * PHP Version 5.4
 * 
 * @category Plugin
 * @package  HTML5SimpleVideoGallery
 * @author   StrasWeb <contact@strasweb.fr>
 * @license  GPL http://www.gnu.org/licenses/gpl.html
 * @link     https://github.com/StrasWeb/html5-simple-video-gallery
 */
/*
Plugin Name: HTML5 Simple Video Gallery
Plugin URI: https://github.com/StrasWeb/html5-simple-video-gallery
Description: Shortcodes that help build a simple video gallery for WordPress
Author: StrasWeb
Version: 0.1
Author URI: https://strasweb.fr/
*/

/**
 * Display a gallery in a page
 * 
 * @param array $atts Shortcode attributes
 * 
 * @return void
 * */
function HTML5VideoGallery($atts)
{
    $posts = get_posts(array('category'=>$atts['cat'], 'posts_per_page'=>-1));
    foreach ($posts as $post) {
        $date = new DateTime($post->post_date);
        $duration = get_post_meta($post->ID, 'duration', true);
        $author = get_post_meta($post->ID, 'author', true);
        echo '<div class="html5_video_gallery_video">
            <a class="html5_video_gallery_link"
            href="'.get_permalink($post->ID).'">';
        echo '<div class="html5_video_gallery_thumb">',
            get_the_post_thumbnail($post->ID, 'thumbnail'), '</div>';
        echo '<div class="html5_video_gallery_info">';
        echo '<h4 class="html5_video_gallery_title">', $post->post_title;
        if (!empty($duration)) {
            echo ' <small>(',
                get_post_meta($post->ID, 'duration', true),
                ')</small>';
        }
        echo '</h4>';
        if (!empty($author)) {
            echo ' <div>',
                get_post_meta($post->ID, 'author', true),
                '</div>';
        }
        echo '<div>', $date->format('d/m/Y'), '</div>';
        echo '</a></div></div>';
    }
}

/**
 * Display an HTML5 video player
 * 
 * @param array $atts Shortcode attributes
 * 
 * @return void
 * */
function HTML5VideoPost($atts)
{
    $date = new DateTime(get_the_date('Ymd'));
    $thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
    $duration = get_post_meta(get_the_ID(), 'duration', true);
    $author = get_post_meta(get_the_ID(), 'author', true);
    echo '<video poster="'.$thumb_url[0].'"
        controls src="'.$atts['url'].'"></video>';
    echo '<h4 class="html5_video_gallery_title">', get_the_title();
    if (!empty($duration)) {
        echo ' <small>(',
            get_post_meta(get_the_ID(), 'duration', true),
            ')</small>';
    }
    echo '</h4>';
    if (!empty($author)) {
        echo ' <div>',
            get_post_meta(get_the_ID(), 'author', true),
            '</div>';
    }
    echo '<div>', $date->format('d/m/Y'), '</div>';
}

add_shortcode(html5_video_gallery, 'HTML5VideoGallery');
add_shortcode(html5_video_post, 'HTML5VideoPost');
wp_enqueue_style(
    'html5-simple-video-gallery',
    plugins_url('css/main.css', __FILE__)
);
?>
