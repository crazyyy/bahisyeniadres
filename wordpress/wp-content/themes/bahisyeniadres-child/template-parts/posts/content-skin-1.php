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

$tag             = root_get_option( 'structure_posts_tag' );
$is_show_excerpt = 'yes' == root_get_option( 'structure_posts_excerpt' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-box skin-1' ); ?> itemscope itemtype="http://schema.org/BlogPosting">

    <?php $thumb = get_the_post_thumbnail( $post->ID, 'thumb-big', array( 'itemprop'=>'image' ) ); if ( ! empty( $thumb ) ) : ?>
        <div class="entry-image">
            <a href="<?php the_permalink() ?>"><?php echo $thumb ?></a>
        </div>
    <?php endif ?>

    <header class="entry-header">
        <?php the_title( '<'.$tag.' class="entry-title" itemprop="name"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url"><span itemprop="headline">', '</span></a></'.$tag.'>' ) ?>
    </header><!-- .entry-header -->

    <?php get_template_part( 'template-parts/posts/content', 'meta' ); ?>

    <?php if ( $is_show_excerpt ) { ?>
        <div class="post-box__content" itemprop="articleBody">
            <?php the_excerpt(); ?>
        </div><!-- .entry-content -->

        <footer class="post-box__footer">
            <a href="<?php the_permalink() ?>" class="entry-footer__more"><?php _e( 'Read more', THEME_TEXTDOMAIN ) ?></a>
        </footer><!-- .entry-footer -->
    <?php } ?>

	<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink() ?>"/>
	<meta itemprop="dateModified" content="<?php the_modified_time( 'Y-m-d' )?>"/>

</article><!-- #post-## -->