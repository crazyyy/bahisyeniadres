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


$is_show_social_js = 'yes' == root_get_option( 'structure_social_js' );

$social_profiles = apply_filters( THEME_SLUG . '_social_share_links', array(
    'facebook', 'vk', 'twitter', 'ok', 'telegram', 'youtube',
    'instagram','linkedin', 'whatsapp', 'viber', 'pinterest', 'yandexzen',
) );

foreach ( $social_profiles as $social_profile ) {
    if ( root_get_option( 'social_' . $social_profile ) ) {
        $social_profile_links[$social_profile] = root_get_option( 'social_' . $social_profile );
    }
}

if ( ! empty( $social_profile_links ) ) {

    ?>

<div class="social-links">
    <div class="social-buttons social-buttons--square social-buttons--circle social-buttons--small">

    <?php
        foreach ( $social_profiles as $social_profile ) {
            $social_profile_link = root_get_option( 'social_' . $social_profile );
            if ( ! empty( $social_profile_link ) ) {
                if ( $social_profile == 'whatsapp' ) $social_profile_link = 'https://api.whatsapp.com/send?phone=' . $social_profile_link;
                if ( $social_profile == 'viber' ) $social_profile_link = 'viber://chat?number=' . $social_profile_link;

                if ( $is_show_social_js ) {
                    echo '<span class="social-button social-button__'. $social_profile .' js-link" data-href="' . base64_encode( $social_profile_link ) . '" data-target="_blank"></span>';
                } else {
                    echo '<a class="social-button social-button__'. $social_profile .'" href="' . esc_attr( $social_profile_link ) . '" target="_blank"></a>';
                }
            }
        }
    ?>

    </div>
</div>

<?php } ?>