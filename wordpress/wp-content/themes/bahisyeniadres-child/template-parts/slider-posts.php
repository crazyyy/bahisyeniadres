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

$slider_count_mod = root_get_option( 'structure_slider_count' );

if ( ! empty( $slider_count_mod  ) ) {

    $slider_articles = array();

    $slider_count = 3;
    if ( is_numeric( $slider_count_mod ) && $slider_count_mod > -1 ) {
        if ( $slider_count_mod > 15 ) $slider_count_mod = 15;
        $slider_count = $slider_count_mod;
    }

    $slider_posts_order = root_get_option( 'structure_slider_order_post' );

    $slider_posts_meta_key = '';
    $slider_meta_query = array(
        array(
            'key' => '_thumbnail_id',
            'compare' => 'EXISTS'
        ),
    );
    $slider_posts_orderby = 'date';

    if ( $slider_posts_order == 'rand' ) {
        $slider_posts_orderby = 'rand';
    }

    if ( $slider_posts_order == 'views' ) {
        $slider_posts_orderby  = 'meta_value_num';
        $slider_posts_meta_key = 'views';
    }

    if ( $slider_posts_order == 'comments' ) {
        $slider_posts_orderby = 'comment_count';
    }

    if ( $slider_posts_order == 'new' ) {
        $slider_posts_orderby = 'date';
    }

    $slider_posts_ids = root_get_option( 'structure_slider_post_in' );

    // если указаны посты - набираем их
    if ( ! empty( $slider_posts_ids ) ) {

        $slider_posts_id_exp = explode( ',', $slider_posts_ids );

        if ( is_array( $slider_posts_id_exp ) ) {
            $slider_posts_ids = array_map( 'trim', $slider_posts_id_exp );
        } else {
            $slider_posts_ids = array( $slider_posts_ids );
        }

        $slider_articles = get_posts( array(
            'posts_per_page' => $slider_count,
            'post__in'       => $slider_posts_ids,
            'meta_key'       => $slider_posts_meta_key,
            'orderby'        => $slider_posts_orderby,
        ) );

    }

    $slider_category_ids = root_get_option( 'structure_slider_category_in' );

    // если указаны рубрики - набираем их
    if ( ! empty( $slider_category_ids ) ) {

        if ( count( $slider_articles ) < $slider_count ) {

            // сколько осталось постов
            $delta = $slider_count - count( $slider_articles );

            // убираем уже выведенные
            $post__not_in = array();
            foreach ( $slider_articles as $article ) {
                $post__not_in[] = $article->ID;
            }

            $slider_category_id_exp = explode( ',', $slider_category_ids );

            if ( is_array( $slider_category_id_exp ) ) {
                $slider_category_ids = array_map( 'trim', $slider_category_id_exp );
            } else {
                $slider_category_ids = array( $slider_category_ids );
            }

            $slider_category_articles = get_posts(array(
                'posts_per_page' => $delta,
                'post__not_in'   => $post__not_in,
                'category__in'   => $slider_category_ids,
                'meta_key'       => $slider_posts_meta_key,
                'orderby'        => $slider_posts_orderby,
                'meta_query'     => $slider_meta_query,
            ) );

            // если все ок, объединяем
            if ( ! empty( $slider_category_articles ) ) {
                $slider_articles = array_merge( $slider_articles, $slider_category_articles );
            }

        }

    }


    // если не хватило, добираем из последних
    if ( count( $slider_articles ) < $slider_count ) {

        // сколько осталось постов
        $delta = $slider_count - count( $slider_articles );

        // убираем уже выведенные
        $post__not_in = array();
        foreach ( $slider_articles as $article ) {
            $post__not_in[] = $article->ID;
        }

        $slider_articles_second = get_posts( array(
            'posts_per_page' => $delta,
            'post__not_in'   => $post__not_in,
            'meta_key'       => $slider_posts_meta_key,
            'orderby'        => $slider_posts_orderby,
            'meta_query'     => $slider_meta_query,
        ) );

        // если все ок, объединяем
        if ( ! empty( $slider_articles_second ) ) {
            $slider_articles = array_merge( $slider_articles, $slider_articles_second );
        }

    }

    if ( ! empty( $slider_articles ) ) {

        ?>

        <?php do_action( THEME_SLUG . '_slider_before' ) ?>

        <div class="card-slider-container swiper-container js-swiper-home <?php if ( root_get_option( 'structure_slider_width' ) == 'content' ) echo 'slider-content' ?>">
            <div class="swiper-wrapper">

                <?php foreach ( $slider_articles as $post ) {
                    setup_postdata( $post ); ?>

                    <?php get_template_part( 'template-parts/posts/slider', 'card' ); ?>

                <?php }
                wp_reset_postdata(); ?>

            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next swiper-button-white"></div>
            <div class="swiper-button-prev swiper-button-white"></div>
        </div>

        <?php do_action( THEME_SLUG . '_slider_after' ) ?>

        <?php
    }

}