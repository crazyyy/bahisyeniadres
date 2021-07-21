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

if ( is_page() ) {
    $related_count_mod = root_get_option( 'structure_page_related' );
} else {
    $related_count_mod = root_get_option( 'structure_single_related' );
}
$related_yarpp_enabled = apply_filters( THEME_SLUG . '_yarpp_enabled', false );


if ( ! empty( $related_count_mod  ) && ! $related_yarpp_enabled ) {

    $related_articles = array();

    $related_count = 6;
    if ( is_numeric( $related_count_mod ) && $related_count_mod > -1 ) {
        if ( $related_count_mod > 50 ) $related_count_mod = 50;
        $related_count = $related_count_mod;
    }

    if ( is_single() ) {
        $related_posts_ids = get_post_meta( $post->ID, 'related_posts_ids', true );

        // если указаны посты - набираем их
        if ( ! empty( $related_posts_ids ) ) {

            $related_posts_id_exp = explode( ',', $related_posts_ids );

            if ( is_array( $related_posts_id_exp ) ) {
                $related_posts_ids = array_map( 'trim', $related_posts_id_exp );
            } else {
                $related_posts_ids = array( $related_posts_ids );
            }

            $related_articles = get_posts( array(
                'posts_per_page' => $related_count,
                'post__not_in'   => array( $post->ID ),
                'post__in'       => $related_posts_ids,
            ) );

        }


        // если не хватило, добираем из категории
        if ( count( $related_articles ) < $related_count ) {

            // сколько осталось постов
            $delta = $related_count - count( $related_articles );

            // убираем текущий пост + уже выведенные
            $post__not_in = array( $post->ID );
            foreach ( $related_articles as $article ) {
                $post__not_in[] = $article->ID;
            }

            // подготавливаем категории
            $category_ids = array();
            $categories = get_the_category($post->ID);
            if ( $categories ) {
                foreach( $categories as $_category ) {
                    $category_ids[] = $_category->term_id;
                }
            }

            $related_articles_category = get_posts( array(
                'category__in'   => $category_ids,
                'posts_per_page' => $delta,
                'post__not_in'   => $post__not_in,
            ) );

            if ( ! empty( $related_articles_category ) ) $related_articles = array_merge( $related_articles, $related_articles_category );


            // если не хватило - добираем рандом
            if ( count( $related_articles ) < $related_count ) {
                $delta = $related_count - count( $related_articles );

                // убираем текущий пост + уже выведенные
                $post__not_in = array( $post->ID );
                foreach ( $related_articles as $article ) {
                    $post__not_in[] = $article->ID;
                }

                $related_articles_second = get_posts( array(
                    'posts_per_page' => $delta,
                    'orderby'        => 'rand',
                    'post__not_in'   => $post__not_in,
                ) );

                // если все ок, объединяем
                if ( ! empty( $related_articles_second ) ) {
                    $related_articles = array_merge( $related_articles, $related_articles_second );
                }
            }
        }
    } else {
        $related_articles = get_posts( array(
            'posts_per_page' => $related_count,
            'orderby'        => 'rand',
        ) );
    }

    if ( ! empty( $related_articles ) ) {

        ?>

        <div class="b-related">
            <?php do_action( THEME_SLUG . '_related_before' ) ?>
            <div class="b-related__header"><span><?php echo apply_filters( THEME_SLUG . '_related_title', __( 'Related articles', THEME_TEXTDOMAIN ) ) ?></span></div>
            <?php do_action( THEME_SLUG . '_related_after_title' ) ?>
            <div class="b-related__items">

                <?php foreach ( $related_articles as $post ) {
                    setup_postdata( $post ); ?>

                    <?php get_template_part( 'template-parts/posts/content', 'card-without-micro' ); ?>

                <?php }
                wp_reset_postdata(); ?>

            </div>
            <?php do_action( THEME_SLUG . '_related_after' ) ?>
        </div>

        <?php
    }

} else {

    /**
     * If yarpp enabled
     */
    if ( function_exists( 'related_posts' ) && $related_yarpp_enabled ) {
        related_posts();
    }

}