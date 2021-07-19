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

$thumb_url = get_the_post_thumbnail_url( $post, 'full' );

$is_show_category = root_get_option( 'structure_slider_show_category' );
$is_show_title    = root_get_option( 'structure_slider_show_title' );
$is_show_excerpt  = root_get_option( 'structure_slider_show_excerpt' );

?>


    <div class="swiper-slide">

        <a href="<?php the_permalink() ?>">
            <div class="card-slider__image" <?php if ( ! empty( $thumb_url ) ) echo ' style="background-image: url('. $thumb_url .');"' ?>></div>

            <div class="card-slider__body">
                <?php if ( $is_show_category ) : ?>
                    <?php echo root_category( $post->ID, 'card-slider__category', false, false ) ?>
                <?php endif; ?>

                <?php if ( $is_show_title ) : ?>
                    <div class="card-slider__title"><?php the_title() ?></div>
                <?php endif; ?>

                <?php
                if ( $is_show_excerpt ) :
                    echo '<div class="card-slider__excerpt">';
                    add_filter( 'get_the_excerpt', 'remove_the_content_add_ad_filter', 9 );
                    echo do_excerpt( get_the_excerpt(), 14 );
                    add_filter( 'get_the_excerpt', 'add_the_content_add_ad_filter', 11 );
                    echo '</div>';
                endif;
                ?>
            </div>
        </a>

    </div>