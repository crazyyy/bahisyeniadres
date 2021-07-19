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

$rand_id = rand( 0,9999 );

?>

<form role="search" method="get" id="searchform_<?php echo $rand_id ?>" action="<?php echo home_url( '/' ) ?>" class="search-form">
    <label class="screen-reader-text" for="s_<?php echo $rand_id ?>"><?php _e( 'Search', THEME_TEXTDOMAIN ) ?>: </label>
    <input type="text" value="<?php echo get_search_query() ?>" name="s" id="s_<?php echo $rand_id ?>" class="search-form__text">
    <button type="submit" id="searchsubmit_<?php echo $rand_id ?>" class="search-form__submit"></button>
</form>