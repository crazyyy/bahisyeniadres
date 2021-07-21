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

            <?php if ( root_get_option( 'structure_archive_breadcrumbs' ) == 'yes' ) {
                get_template_part( 'template-parts/boxes/breadcrumbs' );
            } ?>

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
                    <?php do_action( THEME_SLUG . '_archive_before_title' ); ?>
					<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
                    <?php do_action( THEME_SLUG . '_archive_after_title' ); ?>

                    <?php if ( root_get_option( 'structure_child_categories' ) == 'yes' && is_category() ) {

                        $cat = get_query_var('cat');

                        $categories = get_categories( array(
                            'parent' => $cat
                        ) );

                        if ( ! empty( $categories ) ) {

                            echo '<div class="child-categories"><ul>';
                            foreach ( $categories as $category ) {
                                echo '<li>';
                                echo '<a href="' . get_category_link( $category->term_id ) . '">' . $category->name . '</a>';
                                echo '</li>';
                            }
                            echo '</ul></div>';
                        }
                    } ?>
					
					<?php if ( 'top' == root_get_option( 'structure_archive_description' ) && ! is_paged() ) the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
				</header><!-- .page-header -->

                <?php do_action( THEME_SLUG . '_archive_before_posts' ); ?>
				<?php get_template_part( 'template-parts/layout/archive', root_get_option( 'structure_archive_posts' ) ); ?>
                <?php do_action( THEME_SLUG . '_archive_after_posts' ); ?>

				<?php the_posts_pagination(); ?>
				
				<?php if ( 'bottom' == root_get_option( 'structure_archive_description' ) && ! is_paged() ) the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
				
			<?php else : ?>

				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

if ( root_get_option( 'structure_archive_sidebar' ) != 'none' ) get_sidebar();

get_footer();
