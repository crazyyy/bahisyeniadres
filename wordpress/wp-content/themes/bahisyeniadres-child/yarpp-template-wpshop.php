<?php
/**
 * YARPP Template: WPShop YARPP Template
 * Description: WPShop YARPP Template
 * Author: WPShop
 */
?>

<?php if ( have_posts() ) : ?>

<!-- yarpp -->
<div class="b-related">
    <div class="b-related__header"><span><?php echo apply_filters( THEME_SLUG . '_related_title', __( 'Related articles', THEME_TEXTDOMAIN ) ) ?></span></div>
 .
    <div class="b-related__items">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'template-parts/posts/content', 'card' ); ?>
        <?php endwhile; ?>
    </div>
</div>

<?php else : ?>
<!-- no YARPP related -->
<?php endif; ?>