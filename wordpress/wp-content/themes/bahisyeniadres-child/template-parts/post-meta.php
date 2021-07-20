<?php
/**
 * ****************************************************************************
 *
 *   DON'T EDIT THIS FILE
 *   After update you will lose all changes. Use child theme
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   После обновления Вы потереяете все изменения. Используйте дочернюю тему
 *
 *   https://docs.wpshop.ru/child-themes/
 *
 * *****************************************************************************
 *
 * @package root
 */

$is_show_meta       = 'checked' != get_post_meta( $post->ID, 'meta_hide', true );
$is_show_date       = 'yes' == root_get_option( 'structure_single_date' );
$is_show_category   = 'yes' == root_get_option( 'structure_single_category' );
$is_show_author     = 'yes' == root_get_option( 'structure_single_author' );
$is_shop_social_top = 'yes' == root_get_option( 'structure_single_social' ) && 'checked' != get_post_meta( $post->ID, 'share_top_hide', true );

if ( $is_show_meta ) {
    if ( $is_show_date ) {
        echo '<span class="entry-date"><time itemprop="datePublished" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_date() . '</time></span>';
    }
    if ( $is_show_category ) {
        echo '<span class="entry-category"><span class="hidden-xs">'. __( 'Category', THEME_TEXTDOMAIN ) .':</span> ' . root_category() . '</span>';
    }
    if ( $is_show_author ) {
        echo '<span class="entry-author"><span class="hidden-xs">' . __( 'Author', THEME_TEXTDOMAIN ) . ':</span> <span itemprop="author">' . get_the_author() . '</span></span>';
    }
}

if ( $is_shop_social_top ) {
    echo '<span class="b-share b-share--small">';
    get_template_part( 'template-parts/social', 'buttons' );
    echo '</span>';
}