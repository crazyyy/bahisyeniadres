<?php
/**
 * ****************************************************************************
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   DON'T EDIT THIS FILE
 *
 * *****************************************************************************
 *
 * Clear WP code from some trash, unused queries, links from admin
 *
 * @version 2.0.0
 * @package wpshopbiz
 * @url https://wpshop.ru/
 */

// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}



/**
 * Remove unnecessary tags from head
 */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action( 'wp_head', 'rel_canonical' );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );




/**
 * Remove styles for .recentcomments a
 * .recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}
 * https://github.com/nickyurov/
 */
function remove_recent_comments_style() {
    global $wp_widget_factory;
    remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'remove_recent_comments_style' );




/**
 * Deleted unnecessary link in admin bar
 */
function wps_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu( 'wp-logo' );
    $wp_admin_bar->remove_menu( 'about' );
    $wp_admin_bar->remove_menu( 'wporg' );
    $wp_admin_bar->remove_menu( 'documentation' );
    $wp_admin_bar->remove_menu( 'support-forums' );
    $wp_admin_bar->remove_menu( 'feedback' );
    $wp_admin_bar->remove_menu( 'view-site' );
}
add_action( 'wp_before_admin_bar_render', 'wps_admin_bar' );