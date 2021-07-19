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
?>

<?php
$social_buttons = apply_filters( THEME_SLUG . '_social_share_buttons', array(
    'vk', 'fb', 'twitter', 'ok', 'whatsapp', 'viber', 'telegram', //'mail', 'linkedin', 'reddit', 'pinterest',
) );
?>

<?php foreach ( $social_buttons as $social_button ) : ?>

<?php if ( $social_button == 'fb' ) : ?>
<span class="b-share__ico b-share__fb js-share-link" data-uri="https://www.facebook.com/sharer.php?u=<?php echo urlencode( get_the_permalink() ) ?>"></span>
<?php elseif ( $social_button == 'vk' ) : ?>
<span class="b-share__ico b-share__vk js-share-link" data-uri="https://vk.com/share.php?url=<?php echo urlencode( get_the_permalink() ) ?>"></span>
<?php elseif ( $social_button == 'twitter' ) : ?>
<span class="b-share__ico b-share__tw js-share-link" data-uri="https://twitter.com/share?text=<?php echo urlencode( get_the_title() ) ?>&url=<?php echo urlencode( get_the_permalink() ) ?>"></span>
<?php elseif ( $social_button == 'ok' ) : ?>
<span class="b-share__ico b-share__ok js-share-link" data-uri="https://connect.ok.ru/dk?st.cmd=WidgetSharePreview&service=odnoklassniki&st.shareUrl=<?php echo urlencode( get_the_permalink() ) ?>"></span>
<?php elseif ( $social_button == 'whatsapp' ) : ?>
<span class="b-share__ico b-share__whatsapp js-share-link js-share-link-no-window" data-uri="whatsapp://send?text=<?php echo urlencode( get_the_title() ) ?>%20<?php echo urlencode( get_the_permalink() ) ?>"></span>
<?php elseif ( $social_button == 'viber' ) : ?>
<span class="b-share__ico b-share__viber js-share-link js-share-link-no-window" data-uri="viber://forward?text=<?php echo urlencode( get_the_title() ) ?>%20<?php echo urlencode( get_the_permalink() ) ?>"></span>
<?php elseif ( $social_button == 'telegram' ) : ?>
<span class="b-share__ico b-share__telegram js-share-link js-share-link-no-window" data-uri="https://t.me/share/url?url=<?php echo urlencode( get_the_permalink() ) ?>&text=<?php echo urlencode( get_the_title() ) ?>"></span>
<?php elseif ( $social_button == 'linkedin' ) : ?>
<span class="b-share__ico b-share__ln js-share-link" data-uri="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode( get_the_permalink() ) ?>&title=<?php echo urlencode( get_the_title() ) ?>&summary=&source=<?php bloginfo( 'name' ) ?>"></span>
<?php elseif ( $social_button == 'reddit' ) : ?>
<span class="b-share__ico b-share__rd js-share-link" data-uri="https://www.reddit.com/submit?url=<?php the_permalink() ?>&title=<?php echo esc_attr( get_the_title() ) ?>"></span>
<?php elseif ( $social_button == 'pinterest' ) : ?>
<span class="b-share__ico b-share__pt js-share-link" data-uri="https://www.pinterest.com/pin/create/button/?url=<?php the_permalink() ?>&media=<?php $thumb_id = get_post_thumbnail_id(); $thumb_url = wp_get_attachment_image_src( $thumb_id ); echo $thumb_url[0]; ?>&description=<?php echo esc_attr( get_the_title() ) ?> - <?php bloginfo( 'name' ) ?>"></span>
<?php elseif ( $social_button == 'mail' ) : ?>
<span class="b-share__ico b-share__mail js-share-link" data-uri="https://connect.mail.ru/share?url=<?php echo urlencode( get_the_permalink() ) ?>&text=<?php echo urlencode( get_the_title() ) ?>"></span>
<?php endif; ?>

<?php endforeach;