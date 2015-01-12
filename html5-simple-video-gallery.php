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
    wp_enqueue_style(
        'html5-simple-video-gallery',
        plugins_url('css/main.css', __FILE__)
    );
    $posts = get_posts(array('category'=>$atts['cat'], 'posts_per_page'=>-1));
    $html = '';
    foreach ($posts as $post) {
        $date = new DateTime($post->post_date);
        $duration = get_post_meta($post->ID, 'duration', true);
        $author = get_post_meta($post->ID, 'author', true);
        $html .= '<div class="html5_video_gallery_video"
            itemscope itemtype="http://schema.org/VideoObject">
                <a class="html5_video_gallery_link" itemprop="url"
                href="'.get_permalink($post->ID).'">';
        $html .= '<div class="html5_video_gallery_thumb">'.
            get_the_post_thumbnail(
                $post->ID, 'thumbnail', array('itemprop'=>'thumbnail')
            ).'</div>';
        $html .= '<div class="html5_video_gallery_info">';
        $html .= '<h4 class="html5_video_gallery_title" itemprop="name">'.
            $post->post_title;
        if (!empty($duration)) {
            $html .= ' <small>(<span itemprop="duration">'.
                get_post_meta($post->ID, 'duration', true).
                '</span>)</small>';
        }
        $html .= '</h4>';
        if (!empty($author)) {
            $html .= ' <div itemprop="author">'.
                get_post_meta($post->ID, 'author', true).
                '</div>';
        }
        $html .= '<div itemprop="dateCreated" content="'.$date->format('Y-m-d').'">'.
            $date->format('d/m/Y').'</div>';
        $html .= '</a></div></div>';
    }
    return $html;
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
    wp_enqueue_style(
        'html5-simple-video-gallery',
        plugins_url('css/main.css', __FILE__)
    );
    $date = new DateTime(get_the_date('Ymd'));
    $thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
    $duration = get_post_meta(get_the_ID(), 'duration', true);
    $author = get_post_meta(get_the_ID(), 'author', true);
    $html = '<div itemscope itemtype="http://schema.org/VideoObject">';
    if (isset($atts['title'])) {
        $html .= '<h4 itemprop="alternativeHeadline"
            class="html5_video_gallery_title">'.
            $atts['title'].'</h4>';
    }
    $html .= '<video itemprop="contentUrl" poster="'.$thumb_url[0].'"
        controls src="'.$atts['url'].'">
            <meta itemprop="image" content="'.$thumb_url[0].'" />
        </video>';
    if (!isset($atts['noinfo'])) {
        $html .= '<h4 class="html5_video_gallery_title">
            <span itemprop="name">'.get_the_title();
        if (!empty($duration)) {
            $html .= '</span> <small>(<span itemprop="duration">'.
                get_post_meta(get_the_ID(), 'duration', true).
                '</span>)</small>';
        }
        $html .= '</h4>';
        if (!empty($author)) {
            $html .= ' <div itemprop="author">'.
                get_post_meta(get_the_ID(), 'author', true).
                '</div>';
        }
        $html .= '<div itemprop="dateCreated" content="'.$date->format('Y-m-d').'">'.
            $date->format('d/m/Y').'</div>';
    }
    $html .= '</div>';
    return $html;
}

add_shortcode('html5_video_gallery', 'HTML5VideoGallery');
add_shortcode('html5_video_post', 'HTML5VideoPost');
?>
