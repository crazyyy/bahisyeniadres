<?php
/**
 * ****************************************************************************
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   DON'T EDIT THIS FILE
 *
 * *****************************************************************************
 *
 * @package root
 */

/**
 * Button wpshop.biz
 */
add_shortcode( 'button', 'shortcode_button' );

function shortcode_button( $atts, $content ) {
    $atts = shortcode_atts( array(
        'href'             => '',
        'hide_link'        => '',
        'background_color' => '',
        'color'            => '',
        'size'             => '',
        'target'           => '',
    ), $atts, 'button' );

    $href             = esc_attr( $atts['href'] );
    $hide_link        = esc_attr( $atts['hide_link'] );
    $background_color = esc_attr( $atts['background_color'] );
    $color            = esc_attr( $atts['color'] );
    $size             = esc_attr( $atts['size'] );
    $target           = esc_attr( $atts['target'] );

    $background_color_style = ( ! empty( $background_color ) ) ? 'background-color:' . $background_color . ';' : '';
    $color_style            = ( ! empty( $color ) ) ? 'color:' . $color . ';' : '';

    $out  = '';
    $out .= '<div class="btn-box">';
    if ( $hide_link != 'yes' ) {
        $out .= '<a href="' . $href . '" class="btn btn-size-' . $size .'" style="' . $background_color_style . $color_style . '" target="' . $target . '">' . $content .'</a>';
    } else {
        $out .= '<span data-href="' . base64_encode( $href ) . '" class="btn btn-size-' . $size .' js-link" style="' . $background_color_style . $color_style . '" target="' . $target . '">' . $content .'</span>';
    }
    $out .= '</div>';

    return $out;
}


/**
 * Spoiler wpshop.biz
 */
add_shortcode( 'spoiler', 'shortcode_spoiler' );

function shortcode_spoiler( $atts, $content ) {
    $atts = shortcode_atts( array(
        'title' => 'Показать скрытое содержание',
    ), $atts, 'spoiler' );

    $title = esc_attr( $atts['title'] );

    $out  = '';
    $out .= '<div class="spoiler-box">';
        $out .= '<div class="spoiler-box__title js-spoiler-box-title">' . $title . '</div>';
        $out .= '<div class="spoiler-box__body">' . do_shortcode ( $content ) . '</div>';
        $out .= '</div>';

    return $out;
}


/**
 * Columns
 */
add_shortcode( 'root-col-6-start', 'shortcode_wpshop_col_6_start' );
add_shortcode( 'root-col-6-end', 'shortcode_wpshop_col_6_end' );

function shortcode_wpshop_col_6_start( $atts, $content ) {
    return '<div class="root-row"><div class="root-col-6">' . shortcode_helper( $content ) . '</div>';
}

function shortcode_wpshop_col_6_end( $atts, $content ) {
    return '<div class="root-col-6">' . shortcode_helper( $content ) . '</div></div><!--.root-row-->';
}



function shortcode_helper( $content ) {
    return do_shortcode( shortcode_unautop( trim( $content ) ) );
}