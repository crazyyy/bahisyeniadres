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

$is_show_date     = 'yes' == root_get_option( 'structure_posts_date' );
$is_show_category = 'yes' == root_get_option( 'structure_posts_category' );
$is_show_author   = 'yes' == root_get_option( 'structure_posts_author' );
$is_show_comments = 'yes' == root_get_option( 'structure_posts_comments' );
$is_show_views    = 'yes' == root_get_option( 'structure_posts_views' );

?>

<?php if ( 'post' === get_post_type() && ( $is_show_date || $is_show_category || $is_show_author || $is_show_comments || $is_show_views ) ) : ?>
<div class="entry-meta">
    <?php

    if ( $is_show_date ) {
        echo '<span class="entry-date"><time itemprop="datePublished" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_date() . '</time></span>';
    }
    if ( $is_show_category ) {
        echo '<span class="entry-category"><span class="hidden-xs">'. __( 'Category', THEME_TEXTDOMAIN ) .':</span> ' . root_category() . '</span>';
    }
    if ( $is_show_author ) {
        echo '<span class="entry-author"><span class="hidden-xs">'. __( 'Author', THEME_TEXTDOMAIN ) .':</span> <span itemprop="author">' . get_the_author() . '</span></span>';
    }

    ?>

    <span class="entry-meta__info">
        <?php if ( $is_show_comments ) { ?>
            <span class="entry-meta__comments" title="<?php _e( 'Comments', THEME_TEXTDOMAIN ) ?>"><span class="fa fa-comment-o"></span> <?php echo get_comments_number() ?></span>
        <?php } ?>

        <?php if ( $is_show_views ) { ?>
            <?php if ( function_exists('the_views') ) { ?><span class="entry-meta__views" title="<?php _e( 'Views', THEME_TEXTDOMAIN ) ?>"><span class="fa fa-eye"></span> <?php the_views() ?></span><?php } ?>
        <?php } ?>
    </span>
</div><!-- .entry-meta -->
<?php endif; ?>