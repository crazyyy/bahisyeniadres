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

global $big_thumbnail_image;

$is_show_thumb          = 'yes' == root_get_option( 'structure_page_thumb' ) && 'checked' != get_post_meta( $post->ID, 'thumb_hide', true );
$is_show_title          = 'checked' != get_post_meta( $post->ID, 'h1_hide', true );
$is_shop_social_top     = 'yes' == root_get_option( 'structure_page_social' ) && 'checked' != get_post_meta( $post->ID, 'share_top_hide', true );
$is_show_rating         = 'yes' == root_get_option( 'structure_page_rating' ) && 'checked' != get_post_meta( $post->ID, 'rating_hide', true );
$is_show_social_bottom  = 'yes' == root_get_option( 'structure_page_social_bottom' ) && 'checked' != get_post_meta( $post->ID, 'share_bottom_hide', true );
$is_show_related_posts  = 'checked' != get_post_meta( $post->ID, 'related_posts_hide', true );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if ( ! $big_thumbnail_image ) : ?>

        <?php if ( $is_show_title ) { ?>
            <header class="entry-header">
                <?php do_action( THEME_SLUG . '_page_before_title' ); ?>
                <?php the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' ); ?>
                <?php do_action( THEME_SLUG . '_page_after_title' ); ?>
            </header><!-- .entry-header -->
        <?php } ?>

        <?php
        if ( $is_shop_social_top ) {
            echo '<div class="entry-meta"><span class="b-share b-share--small">';
            get_template_part( 'template-parts/social', 'buttons' );
            echo '</span></div>';
        }
        ?>

        <?php
        $thumb = get_the_post_thumbnail( $post->ID, apply_filters( THEME_SLUG . '_page_thumbnail', 'full' ), array( 'itemprop'=>'image' ) );
        if ( $is_show_thumb && ! empty( $thumb ) ) : ?>
            <div class="entry-image">
                <?php echo $thumb ?>
            </div>
        <?php else : ?>
            <div class="page-separator"></div>
        <?php endif; ?>

    <?php endif; ?>

    <div class="entry-content" itemprop="articleBody">
        <?php
            do_action( THEME_SLUG . '_page_before_the_content' );
            the_content();
            do_action( THEME_SLUG . '_page_after_the_content' );

            wp_link_pages( array(
                'before'        => '<div class="page-links">' . esc_html__( 'Pages:', THEME_TEXTDOMAIN ),
                'after'         => '</div>',
                'link_before'   => '<span class="page-links__item">',
                'link_after'    => '</span>',
            ) );
        ?>
    </div><!-- .entry-content -->
</article><!-- #post-## -->


<?php if ( $is_show_rating ) { ?>
    <div class="entry-rating">
        <div class="entry-bottom__header"><?php echo apply_filters( THEME_SLUG . '_rating_title', __( 'Rating', THEME_TEXTDOMAIN ) ) ?></div>
        <?php
        $post_id = $post ? $post->ID : 0;
        $class_star_rating = new Wpshop_Star_Rating(); $class_star_rating->the_rating( $post_id, apply_filters( THEME_SLUG . '_rating_text_show', true ) );
        ?>
    </div>
<?php } ?>


<?php if ( $is_show_social_bottom ) { ?>
    <div class="b-share b-share--post">
        <?php if ( apply_filters( THEME_SLUG . '_social_share_title_show', true ) ) : ?>
            <div class="b-share__title"><?php echo apply_filters( THEME_SLUG . '_social_share_title', __( 'Please share to your friends:', THEME_TEXTDOMAIN ) ) ?></div>
        <?php endif; ?>

        <?php get_template_part( 'template-parts/social', 'buttons' ) ?>
    </div>
<?php } ?>


<?php
if ( $is_show_related_posts ) {
    do_action( THEME_SLUG . '_page_before_related' );
    get_template_part( 'template-parts/related', 'posts' );
    do_action( THEME_SLUG . '_page_after_related' );
}
?>


<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink() ?>" content="<?php the_title(); ?>">
<meta itemprop="dateModified" content="<?php the_modified_time( 'Y-m-d' )?>">
<meta itemprop="datePublished" content="<?php the_time( 'c' ) ?>">
<meta itemprop="author" content="<?php the_author() ?>">
<?php echo get_microdata_publisher() ?>
<?php do_action( THEME_SLUG . '_content_card_meta' ); ?>