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

$root_structure_home_h1   = root_get_option( 'structure_home_h1' );
$root_structure_home_text = root_get_option( 'structure_home_text' );

if ( ! empty( $root_structure_home_h1 ) || ! empty( $root_structure_home_text ) || is_customize_preview() ) {

    echo '<div class="home-content">';

    if ( ! empty( $root_structure_home_h1 ) || is_customize_preview() ) {
        echo '<h1 class="home-header">' . $root_structure_home_h1 . '</h1>';
    }
    if ( ( ! empty( $root_structure_home_text ) || is_customize_preview() ) && ! is_paged() ) {
        echo '<div class="home-text">' . do_shortcode( wpautop( $root_structure_home_text ) ) . '</div>';
    }

    echo '</div>';

}