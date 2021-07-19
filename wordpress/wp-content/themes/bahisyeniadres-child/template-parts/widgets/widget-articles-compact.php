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

global $wpshop_template;
global $single_post;
global $hide_category;
global $hide_meta;
global $link_target;

?>

<div class="widget-article widget-article--compact">
    <?php $thumb = get_the_post_thumbnail( $single_post->ID, 'thumbnail' ); if ( ! empty( $thumb ) ) : ?>
    <div class="widget-article__image">
        <a href="<?php echo get_permalink( $single_post->ID ) ?>"<?php echo ( $link_target == true ) ? ' target="_blank"' : ''; ?>>
            <?php echo $thumb ?>
        </a>
    </div>
    <?php endif ?>
    <div class="widget-article__body">
        <div class="widget-article__title"><a href="<?php echo get_permalink( $single_post->ID ) ?>"<?php echo ( $link_target == true ) ? ' target="_blank"' : ''; ?>><?php echo get_the_title( $single_post->ID ) ?></a></div>

        <?php if ( ! $hide_category ) : ?>
            <div class="widget-article__category">
                <?php echo root_category( $single_post->ID, '', false ) ?>
            </div>
        <?php endif ?>

        <?php if ( ! $hide_meta ) { ?>
            <div class="entry-meta">
                <span class="entry-meta__comments" title="<?php _e( 'Comments', THEME_TEXTDOMAIN ) ?>"><span class="fa fa-comment-o"></span> <?php echo get_comments_number() ?></span>
                <?php if ( function_exists('the_views') ) { ?><span class="entry-meta__views" title="<?php _e( 'Views', THEME_TEXTDOMAIN ) ?>"><span class="fa fa-eye"></span> <?php the_views() ?></span><?php } ?>
            </div>
        <?php } ?>
    </div>
</div>