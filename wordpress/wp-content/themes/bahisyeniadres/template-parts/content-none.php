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

?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php _e( 'Nothing Found', THEME_TEXTDOMAIN ) ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', THEME_TEXTDOMAIN ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', THEME_TEXTDOMAIN ); ?></p>

			<h3><?php esc_html_e( 'What can be done?', THEME_TEXTDOMAIN ); ?></h3>
			<ul>
				<li><?php esc_html_e( 'Try to change search phrase', THEME_TEXTDOMAIN ) ?></li>
                <li><?php printf( __( 'Go to <a href="%1$s">Homepage</a>.', THEME_TEXTDOMAIN ), esc_url( home_url( '/' ) ) ) ?></li>
			</ul>

			<?php get_template_part( 'template-parts/related', 'posts' ) ?>

			<?php
		//get_search_form();

		else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', THEME_TEXTDOMAIN ); ?></p>

			<h3><?php esc_html_e( 'What can be done?', THEME_TEXTDOMAIN ); ?></h3>
			<ul>
                <li><?php esc_html_e( 'Try to change search phrase', THEME_TEXTDOMAIN ) ?></li>
                <li><?php printf( __( 'Go to <a href="%1$s">Homepage</a>.', THEME_TEXTDOMAIN ), esc_url( home_url( '/' ) ) ) ?></li>
			</ul>

			<?php get_template_part( 'template-parts/related', 'posts' ) ?>


			<?php
			//get_search_form();

		endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->