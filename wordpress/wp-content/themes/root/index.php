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

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

            <?php if ( 'top' == root_get_option( 'structure_home_position' ) ) get_template_part( 'template-parts/home', 'content' ); ?>

            <?php
            if ( is_front_page() || is_home() ) {
                if ( root_get_option( 'structure_slider_width' ) == 'content' ) {
                    $is_show_on_paged   = root_get_option( 'structure_slider_show_on_paged' );
                    if ( ! is_paged() || ( $is_show_on_paged && is_paged() ) ) {
                        get_template_part( 'template-parts/slider', 'posts' );
                    }
                }
            }
            ?>

            <?php get_template_part( 'template-parts/layout/archive', root_get_option( 'structure_home_posts' ) ); ?>

            <?php the_posts_pagination(); ?>

            <?php if ( 'bottom' == root_get_option( 'structure_home_position' ) ) get_template_part( 'template-parts/home', 'content' ); ?>


        <?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

if ( root_get_option( 'structure_home_sidebar' ) != 'none' ) get_sidebar();

get_footer();
