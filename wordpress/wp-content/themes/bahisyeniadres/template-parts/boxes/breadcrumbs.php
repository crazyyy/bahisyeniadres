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

$breadcrumbs_display = root_get_option( 'breadcrumbs_display' );

if ( 'yes' == $breadcrumbs_display ) :

    $breadcrumbs_service = 'self';

    if ( function_exists( 'yoast_breadcrumb' ) ) {
        $wpseo_titles = get_option( 'wpseo_titles' );
        if ( $wpseo_titles['breadcrumbs-enable'] ) $breadcrumbs_service = 'yoast';
    }

    if ( $breadcrumbs_service == 'yoast' ) {
        yoast_breadcrumb('<div class="breadcrumb" id="breadcrumbs">','</div>');
    } else {
        echo wpshop_breadcrumbs();
    }

endif;