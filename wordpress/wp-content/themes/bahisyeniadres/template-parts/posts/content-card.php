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

$tag              = root_get_option( 'structure_posts_tag' );
$article_tag      = ( $tag == 'div' ) ? 'div' : 'article';
$is_show_category = 'yes' == root_get_option( 'structure_posts_category' );
$is_show_excerpt  = 'yes' == root_get_option( 'structure_posts_excerpt' );
$is_show_comments = 'yes' == root_get_option( 'structure_posts_comments' );
$is_show_views    = 'yes' == root_get_option( 'structure_posts_views' );

?>

<<?php echo $article_tag ?> id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?> itemscope itemtype="http://schema.org/BlogPosting">

    <div class="post-card__image">
        <a href="<?php the_permalink() ?>">
            <?php $thumb = get_the_post_thumbnail( $post->ID, 'thumb-wide', array( 'itemprop'=>'image' ) ); if ( ! empty( $thumb ) ) : ?>
                <?php echo $thumb ?>
            <?php endif ?>


            <?php if ( 'post' === get_post_type() && ( $is_show_category || $is_show_comments || $is_show_views ) ) : ?>

                <?php if ( empty( $thumb ) ) echo '<div class="thumb-wide"></div>'; ?>

                <div class="entry-meta">
                    <?php
                    if ( $is_show_category ) {
                        echo '<span class="entry-category">' . root_category( $post->ID, '', true, false ) . '</span>';
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
        </a>
    </div>


	<header class="entry-header">
		<?php the_title( '<'.$tag.' class="entry-title" itemprop="name"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url"><span itemprop="headline">', '</span></a></'.$tag.'>' ) ?>
	</header><!-- .entry-header -->

    <?php if ( $is_show_excerpt ) { ?>
	<div class="post-card__content" itemprop="articleBody">
		<?php
            add_filter( 'get_the_excerpt', 'remove_the_content_add_ad_filter', 9 );
			echo do_excerpt( get_the_excerpt(), 14 );
            add_filter( 'get_the_excerpt', 'add_the_content_add_ad_filter', 11 );
		?>
	</div><!-- .entry-content -->
    <?php } ?>

    <?php if ( ! $is_show_excerpt ) { ?>
        <meta itemprop="articleBody" content="<?php echo get_the_excerpt() ?>">
    <?php } ?>
	<meta itemprop="author" content="<?php the_author() ?>"/>
	<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink() ?>" content="<?php the_title(); ?>">
	<meta itemprop="dateModified" content="<?php the_modified_time( 'Y-m-d' )?>">
	<meta itemprop="datePublished" content="<?php the_time( 'c' ) ?>">
    <?php echo get_microdata_publisher() ?>
    <?php do_action( THEME_SLUG . '_content_card_meta' ); ?>

</<?php echo $article_tag ?>><!-- #post-## -->