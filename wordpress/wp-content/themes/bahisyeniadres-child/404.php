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

			<section class="error-404 not-found">
				<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', THEME_TEXTDOMAIN ); ?></h1>

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', THEME_TEXTDOMAIN ); ?></p>
                    <h3><?php esc_html_e( 'What can be done?', THEME_TEXTDOMAIN ); ?></h3>
                    <ul>
                        <li><?php esc_html_e( 'Try to use search', THEME_TEXTDOMAIN ) ?></li>
                        <li><?php printf( __( 'Go to <a href="%1$s">Homepage</a>.', THEME_TEXTDOMAIN ), esc_url( home_url( '/' ) ) ) ?></li>
                    </ul>

					<?php get_template_part( 'template-parts/related', 'posts' ) ?>
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();