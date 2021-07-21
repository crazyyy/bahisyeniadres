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
$article_tag     = ( $tag == 'div' ) ? 'div' : 'article';
$is_show_date    = 'yes' == root_get_option( 'structure_posts_date' );
$is_show_author  = 'yes' == root_get_option( 'structure_posts_author' );
$is_show_excerpt = 'yes' == root_get_option( 'structure_posts_excerpt' );
$root_skin       = root_get_option( 'skin' );

?>

<<?php echo $article_tag ?> id="post-<?php the_ID(); ?>" <?php post_class( 'post-box' ); ?> itemscope itemtype="http://schema.org/BlogPosting">
	<header class="entry-header">
		<?php the_title( '<'.$tag.' class="entry-title" itemprop="name"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url"><span itemprop="headline">', '</span></a></'.$tag.'>' ) ?>

        <?php if ( $root_skin != 'skin-1' && $root_skin != 'skin-2' ) get_template_part( 'template-parts/posts/content', 'meta' ); ?>
	</header><!-- .entry-header -->

    <?php $thumb = get_the_post_thumbnail( $post->ID, 'thumb-big', array( 'itemprop'=>'image' ) ); if ( ! empty( $thumb ) ) : ?>
        <div class="entry-image">
            <a href="<?php the_permalink() ?>"><?php echo $thumb ?></a>
        </div>
    <?php endif ?>

    <?php if ( $root_skin == 'skin-1' || $root_skin == 'skin-2' ) get_template_part( 'template-parts/posts/content', 'meta' ); ?>

    <?php if ( $is_show_excerpt ) { ?>
        <div class="post-box__content" itemprop="articleBody">
            <?php the_excerpt(); ?>
        </div><!-- .entry-content -->

        <footer class="post-box__footer">
            <a href="<?php the_permalink() ?>" class="entry-footer__more"><?php _e( 'Read more', THEME_TEXTDOMAIN ) ?></a>
        </footer><!-- .entry-footer -->
    <?php } ?>

    <?php if ( ! $is_show_excerpt ) { ?>
        <meta itemprop="articleBody" content="<?php echo get_the_excerpt() ?>">
    <?php } ?>
    <?php if ( ! $is_show_author ) { ?>
        <meta itemprop="author" content="<?php the_author() ?>">
    <?php } ?>
    <?php if ( ! $is_show_date ) { ?>
        <meta itemprop="datePublished" content="<?php the_time( 'c' ) ?>">
    <?php } ?>
	<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink() ?>" content="<?php the_title(); ?>">
	<meta itemprop="dateModified" content="<?php the_modified_time( 'Y-m-d' )?>">
    <?php echo get_microdata_publisher() ?>

    <?php do_action( THEME_SLUG . '_content_card_meta' ); ?>

</<?php echo $article_tag ?>><!-- #post-## -->