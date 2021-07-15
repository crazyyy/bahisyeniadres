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

get_header();

$big_thumbnail_image   = ( 'checked' == get_post_meta( $post->ID, 'big_thumbnail_image', true ) ) ? true : false ;

$is_show_thumb         = 'yes' == root_get_option( 'structure_page_thumb' ) && 'checked' != get_post_meta( $post->ID, 'thumb_hide', true );
$is_show_breadcrumbs   = 'checked' != get_post_meta( $post->ID, 'breadcrumbs_hide', true );
$is_show_title         = 'checked' != get_post_meta( $post->ID, 'h1_hide', true );
$is_shop_social_top    = 'yes' == root_get_option( 'structure_page_social' ) && 'checked' != get_post_meta( $post->ID, 'share_top_hide', true );
$is_show_social_bottom = 'yes' == root_get_option( 'structure_page_social' );
$is_show_comments      = 'yes' == root_get_option( 'structure_page_comments' ) && 'checked' != get_post_meta( $post->ID, 'comments_hide', true );
$is_show_sidebar       = root_get_option( 'structure_page_sidebar' ) != 'none' && 'checked' != get_post_meta( $post->ID, 'sidebar_hide', true );
$is_show_sidebar       = apply_filters( 'root_page_sidebar_show', $is_show_sidebar );


?>

<?php while ( have_posts() ) : the_post(); ?>

<div itemscope itemtype="http://schema.org/Article">

    <?php if ( $big_thumbnail_image ) : ?>

        <?php $thumb = get_the_post_thumbnail( $post->ID, 'full', array( 'itemprop'=>'image' ) ); if ( ! empty( $thumb ) && $is_show_thumb ) : ?>
            <div class="entry-image entry-image--big">
                <?php echo $thumb ?>
        <?php else : ?>
            <div class="entry-image entry-image--big entry-image--no-thumb">
        <?php endif; ?>

                <div class="entry-image__title">
                    <?php if ( ! is_front_page() && $is_show_breadcrumbs ) get_template_part( 'template-parts/boxes/breadcrumbs' ); ?>

                    <?php if ( $is_show_title ) { ?>
                        <?php do_action( THEME_SLUG . '_page_before_title' ); ?>
                        <h1 itemprop="headline"><?php the_title() ?></h1>
                        <?php do_action( THEME_SLUG . '_page_after_title' ); ?>
                    <?php } ?>

                    <?php
                    if ( $is_shop_social_top ) {
                        echo '<div class="entry-meta"><span class="b-share b-share--small">';
                        get_template_part( 'template-parts/social', 'buttons' );
                        echo '</span></div>';
                    }
                    ?>
                </div>

            </div>

    <?php endif;?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

            <?php if ( ! is_front_page() && ! $big_thumbnail_image && $is_show_breadcrumbs ) get_template_part( 'template-parts/boxes/breadcrumbs' ); ?>

            <?php

            get_template_part( 'template-parts/content', 'page' );

            // If comments are open or we have at least one comment, load up the comment template.
            if ( $is_show_comments ) {
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
            }

            ?>

		</main><!-- #main -->
	</div><!-- #primary -->

</div><!-- micro -->

<?php endwhile; ?>

<?php if ( $is_show_sidebar ) get_sidebar(); ?>

<?php
get_footer();
