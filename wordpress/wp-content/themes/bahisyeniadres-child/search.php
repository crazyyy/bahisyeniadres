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

    <section id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

        <?php
        if ( have_posts() ) : ?>

            <header class="page-header">
                <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', THEME_TEXTDOMAIN ), '<span>' . get_search_query() . '</span>' ); ?></h1>
            </header><!-- .page-header -->

            <div class="page-separator"></div>

            <?php
            get_template_part( 'template-parts/layout/archive', root_get_option( 'structure_archive_posts' ) );

            the_posts_pagination();

        else :

            get_template_part( 'template-parts/content', 'none' );

        endif; ?>

        </main><!-- #main -->
    </section><!-- #primary -->

<?php
get_sidebar();
get_footer();
