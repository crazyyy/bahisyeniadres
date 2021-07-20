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

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area" itemscope itemtype="http://schema.org/WPSideBar">

    <?php do_action( THEME_SLUG . '_sidebar_before_widgets' ); ?>

	<?php dynamic_sidebar( 'sidebar-1' ); ?>

    <?php do_action( THEME_SLUG . '_sidebar_after_widgets' ); ?>

</aside><!-- #secondary -->
