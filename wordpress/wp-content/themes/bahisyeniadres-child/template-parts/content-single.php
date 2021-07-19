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

$is_show_thumb          = 'yes' == root_get_option( 'structure_single_thumb' ) && 'checked' != get_post_meta( $post->ID, 'thumb_hide', true );
$is_show_title          = 'checked' != get_post_meta( $post->ID, 'h1_hide', true );
$is_show_date           = 'yes' == root_get_option( 'structure_single_date' );
$is_show_author         = 'yes' == root_get_option( 'structure_single_author' );
$is_show_excerpt        = 'yes' == root_get_option( 'structure_single_excerpt' );
$is_show_comments_count = 'yes' == root_get_option( 'structure_single_comments_count' );
$is_show_views          = 'yes' == root_get_option( 'structure_single_views' );
$is_show_tags           = 'yes' == root_get_option( 'structure_single_tags' );
$is_show_rating         = 'yes' == root_get_option( 'structure_single_rating' ) && 'checked' != get_post_meta( $post->ID, 'rating_hide', true );
$is_show_author_box     = 'yes' == root_get_option( 'structure_single_author_box' ) && 'checked' != get_post_meta( $post->ID, 'author_box_hide', true );
$is_show_social_bottom  = 'yes' == root_get_option( 'structure_single_social_bottom' ) && 'checked' != get_post_meta( $post->ID, 'share_bottom_hide', true );
$is_show_related_posts  = 'checked' != get_post_meta( $post->ID, 'related_posts_hide', true );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if ( ! $big_thumbnail_image ) : ?>

        <header class="entry-header">
            <?php if ( $is_show_title ) { ?>
                <?php do_action( THEME_SLUG . '_single_before_title' ); ?>
                <?php the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' ); ?>
                <?php do_action( THEME_SLUG . '_single_after_title' ); ?>
            <?php } ?>

            <?php
            $excerpt = get_the_excerpt();
            if ( has_excerpt() && $is_show_excerpt ) {
                do_action( THEME_SLUG . '_single_before_excerpt' );
                echo '<div class="entry-excerpt">' . $excerpt . '</div>';
                do_action( THEME_SLUG . '_single_after_excerpt' );
            }
            ?>

            <?php if ( 'post' === get_post_type() ) : ?>
                <div class="entry-meta">
                    <?php get_template_part( 'template-parts/post', 'meta' ) ?>
                </div><!-- .entry-meta -->
            <?php endif; ?>
        </header><!-- .entry-header -->


        <?php
        $thumb = get_the_post_thumbnail( $post->ID, apply_filters( THEME_SLUG . '_post_thumbnail', 'full' ), array( 'itemprop'=>'image' ) );
        if ( $is_show_thumb && ! empty( $thumb ) ) : ?>
            <div class="entry-image">
                <?php echo $thumb ?>
            </div>
        <?php else : ?>
            <div class="page-separator"></div>
        <?php endif; ?>

    <?php else : ?>

        <?php
        $excerpt = get_the_excerpt();
        if ( has_excerpt() && $is_show_excerpt ) {
            do_action( THEME_SLUG . '_single_before_excerpt' );
            echo '<div class="entry-excerpt">' . $excerpt . '</div>';
            do_action( THEME_SLUG . '_single_after_excerpt' );
        }
        ?>

    <?php endif; ?>

	<div class="entry-content" itemprop="articleBody">
		<?php
        do_action( THEME_SLUG . '_single_before_the_content' );
        the_content();
        do_action( THEME_SLUG . '_single_after_the_content' );

        wp_link_pages( array(
            'before'        => '<div class="page-links">' . esc_html__( 'Pages:', THEME_TEXTDOMAIN ),
            'after'         => '</div>',
            'link_before'   => '<span class="page-links__item">',
            'link_after'    => '</span>',
        ) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->


<?php echo root_get_option( 'code_after_content' ) ?>

<?php if ( $is_show_rating ) { ?>
    <div class="entry-rating">
        <div class="entry-bottom__header"><?php echo apply_filters( THEME_SLUG . '_rating_title', __( 'Rating', THEME_TEXTDOMAIN ) ) ?></div>
        <?php
        $post_id = $post ? $post->ID : 0;
        $class_star_rating = new Wpshop_Star_Rating(); $class_star_rating->the_rating( $post_id, apply_filters( THEME_SLUG . '_rating_text_show', true ) );
        ?>
    </div>
<?php } ?>


<div class="entry-footer">
    <?php if ( $is_show_comments_count ) { ?>
        <span class="entry-meta__comments" title="<?php _e( 'Comments', THEME_TEXTDOMAIN ) ?>"><span class="fa fa-comment-o"></span> <?php echo get_comments_number() ?></span>
    <?php } ?>

    <?php if ( $is_show_views ) { ?>
        <?php if ( function_exists('the_views') ) { ?><span class="entry-meta__views" title="<?php _e( 'Views', THEME_TEXTDOMAIN ) ?>"><span class="fa fa-eye"></span> <?php the_views() ?></span><?php } ?>
    <?php } ?>

    <?php
    if ( $is_show_tags ) {
        $post_tags = get_the_tags();
        if ( $post_tags ) {
            foreach( $post_tags as $tag ) {
                echo '<a href="'. get_tag_link( $tag->term_id ) .'" class="entry-meta__tag">'. $tag->name . '</a> ';
            }
        }
    }
    ?>

    <?php
    $source_link = get_post_meta( $post->ID, 'source_link', true );
    $source_hide = get_post_meta( $post->ID, 'source_hide', true );

    if ( ! empty( $source_link ) ) {
        echo '<span class="entry-meta__source">';

        if ( $source_hide == 'checked' ) {
            echo '<span class="ps-link" data-uri="'. base64_encode( $source_link ) .'">' . __( 'Source', THEME_TEXTDOMAIN ) . '</span>';
        } else {
            echo '<a href="'. $source_link .'" target="_blank">' . __( 'Source', THEME_TEXTDOMAIN ) . '</a>';
        }

        echo '</span>';
    }
    ?>
</div>

<?php if ( $is_show_author_box ) get_template_part( 'template-parts/author', 'box' ); ?>

<?php if ( $is_show_social_bottom ) { ?>

    <div class="b-share b-share--post">
        <?php if ( apply_filters( THEME_SLUG . '_social_share_title_show', true ) ) : ?>
            <div class="b-share__title"><?php echo apply_filters( THEME_SLUG . '_social_share_title', __( 'Like this post? Please share to your friends:', THEME_TEXTDOMAIN ) ) ?></div>
        <?php endif; ?>

        <?php do_action( THEME_SLUG . '_single_before_social' ) ?>
        <?php get_template_part( 'template-parts/social', 'buttons' ) ?>
        <?php do_action( THEME_SLUG . '_single_after_social' ) ?>
    </div>

<?php } ?>


<?php
if ( $is_show_related_posts ) {
    do_action( THEME_SLUG . '_single_before_related' );
    get_template_part( 'template-parts/related', 'posts' );
    do_action( THEME_SLUG . '_single_after_related' );
}
?>


<?php if ( ! $is_show_author ) { ?>
    <meta itemprop="author" content="<?php the_author() ?>">
<?php } ?>
<?php if ( ! $is_show_date ) { ?>
    <meta itemprop="datePublished" content="<?php the_time( 'c' ) ?>"/>
<?php } ?>
<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink() ?>" content="<?php the_title(); ?>">
<meta itemprop="dateModified" content="<?php the_modified_time( 'Y-m-d' )?>">
<meta itemprop="datePublished" content="<?php the_time( 'c' ) ?>">
<?php echo get_microdata_publisher() ?>
<?php do_action( THEME_SLUG . '_content_card_meta' ); ?>