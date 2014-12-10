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
        echo '<div class="html5_video_gallery_video">
            <a class="html5_video_gallery_link"
            href="'.get_permalink($post->ID).'">';
        echo '<div class="html5_video_gallery_thumb">',
            get_the_post_thumbnail($post->ID, 'medium'), '</div>';
        echo '<h4 class="html5_video_gallery_title">', $post->post_title;
        if (!empty($duration)) {
            echo ' <small>(',
                get_post_meta($post->ID, 'duration', true),
                ')</small>';
        }
        echo '</h4>';
        echo '<div>', $date->format('d/m/Y'), '</div>';
        echo '</a></div>';
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
    echo '<video controls src="'.$atts['url'].'"></video>';
}

add_shortcode(html5_video_gallery, 'HTML5VideoGallery');
add_shortcode(html5_video_post, 'HTML5VideoPost');
wp_enqueue_style(
    'html5-simple-video-gallery',
    plugins_url('css/main.css', __FILE__)
);
?>
