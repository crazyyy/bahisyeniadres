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

<header id="masthead" class="site-header <?php root_site_header_classes() ?>" itemscope
  itemtype="http://schema.org/WPHeader">
  <div class="site-header-inner <?php root_site_header_inner_classes() ?>">
    <div class="site-branding">
      <?php
      $root_logotype = root_get_option('logotype_image');
      $logotype_alt = apply_filters(THEME_SLUG . '_logotype_alt', get_bloginfo('name'));

      if (!empty($root_logotype)) {
        if (is_front_page()) {
          if (is_home() && is_paged()) {
            echo '<div class="site-logotype"><a href="' . esc_url(home_url('/')) . '"><img src="' . $root_logotype . '" alt="' . $logotype_alt . '"></a></div>';
          } else {
            echo '<div class="site-logotype"><img src="' . $root_logotype . '" alt="' . $logotype_alt . '"></div>';
          }
        } else {
          echo '<div class="site-logotype"><a href="' . esc_url(home_url('/')) . '"><img src="' . $root_logotype . '" alt="' . $logotype_alt . '"></a></div>';
        }
      }
      ?>

      <div class="header-buttons">
        <a href="" class="header-buttons-button header-buttons-button-1">Giriş yap</a>
        <a href="" class="header-buttons-button header-buttons-button-2">Kayıt ol</a>
      </div>
      <!-- /.header-buttons -->

      <?php if (root_get_option('header_hide_title') == 'no') { ?>
      <div class="site-branding-container">

        <?php
          $root_structure_home_h1 = root_get_option('structure_home_h1');
          if (!$root_structure_home_h1) $root_structure_home_h1 = '';

          $site_title_text = get_bloginfo('name');
          $site_title_tag = 'div';

          if (is_front_page() && is_home()) {

            if (empty($root_structure_home_h1)) {
              $site_title_tag = 'h1';
            }

            if (is_paged()) {
              $site_title_text = '<a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a>';
            }
          } else {
            if (!is_front_page()) {
              $site_title_text = '<a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a>';
            }
          }

          echo '<' . $site_title_tag . ' class="site-title">' . $site_title_text . '</' . $site_title_tag . '>';
          ?>

        <?php

          $description = get_bloginfo('description', 'display');
          if ($description || is_customize_preview()) : ?>
        <p class="site-description"><?php echo $description; ?></p>
        <?php
          endif; ?>

      </div>
      <?php } ?>
    </div><!-- .site-branding -->

    <?php $header_html_block_1 = root_get_option('header_html_block_1');
    if (!empty($header_html_block_1)) { ?>
    <div class="header-html-1">
      <?php echo do_shortcode($header_html_block_1) ?>
    </div>
    <?php } ?>

    <?php if (root_get_option('header_social') == 'yes') {
      get_template_part('template-parts/social', 'links');
    } ?>

    <?php if (has_nav_menu('top_menu')) { ?>
    <div class="top-menu">
      <?php wp_nav_menu(array('theme_location' => 'top_menu', 'menu_id' => 'top_menu')); ?>
    </div>
    <?php } ?>

    <?php $header_html_block_2 = root_get_option('header_html_block_2');
    if (!empty($header_html_block_2)) { ?>
    <div class="header-html-2">
      <?php echo do_shortcode($header_html_block_2) ?>
    </div>
    <?php } ?>

    <div class="mob-hamburger"><span></span></div>

    <?php $root_header_search_mob = root_get_option('header_search_mob');
    if ($root_header_search_mob == 'yes') { ?>
    <div class="mob-search"><?php get_search_form(); ?></div>
    <?php } ?>
  </div>
  <!--.site-header-inner-->
</header><!-- #masthead -->