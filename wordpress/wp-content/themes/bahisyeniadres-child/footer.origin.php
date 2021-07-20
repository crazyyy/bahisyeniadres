<?php
/**
 * ****************************************************************************
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *
 *   ВНИМАНИЕ!!!!!!!
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   ПРИ ОБНОВЛЕНИИ ТЕМЫ - ВЫ ПОТЕРЯЕТЕ ВСЕ ВАШИ ИЗМЕНЕНИЯ
 *   ИСПОЛЬЗУЙТЕ ДОЧЕРНЮЮ ТЕМУ ИЛИ НАСТРОЙКИ ТЕМЫ В АДМИНКЕ
 *
 *   ПОДБРОБНЕЕ:
 *   https://docs.wpshop.ru/child-themes/
 *
 * *****************************************************************************
 *
 * @package Root
 */

?>

	</div><!-- #content -->

    <?php do_action( THEME_SLUG . '_after_site_content' ); ?>

    <?php
        $ad_options = get_option( 'root_ad_options' );
        $ad_visible = ( ! empty( $ad_options['r_after_site_content_visible'] ) ) ? $ad_options['r_after_site_content_visible'] : array();

        $show_ad = false;
        if ( is_front_page()    && in_array( 'home', $ad_visible ) )      $show_ad = true;
        if ( is_single()        && in_array( 'post', $ad_visible ) )      $show_ad = true;
        if ( is_page()          && in_array( 'page', $ad_visible ) )      $show_ad = true;
        if ( is_archive()       && in_array( 'archive', $ad_visible ) )   $show_ad = true;
        if ( is_search()        && in_array( 'search', $ad_visible ) )    $show_ad = true;

        if ( is_single() && in_array( 'post', $ad_visible ) ) {
            $show_ad = do_show_ad(
                $post->ID,
                isset( $ad_options['r_after_site_content_exclude'] ) ? $ad_options['r_after_site_content_exclude'] : array(),
                isset( $ad_options['r_after_site_content_include'] ) ? $ad_options['r_after_site_content_include'] : array(),
                isset( $ad_options['r_after_site_content_category_exclude'] ) ? $ad_options['r_after_site_content_category_exclude'] : array()
            );
        }

        if ( is_page() && in_array('page', $ad_visible) ) {
            $show_ad = do_show_ad(
                $post->ID,
                isset( $ad_options['r_after_site_content_exclude'] ) ? $ad_options['r_after_site_content_exclude'] : array(),
                isset( $ad_options['r_after_site_content_include'] ) ? $ad_options['r_after_site_content_include'] : array(),
                isset( $ad_options['r_after_site_content_category_exclude'] ) ? $ad_options['r_after_site_content_category_exclude'] : array()
            );
        }

        if ( ! wp_is_mobile() && ! empty( $ad_options['r_after_site_content'] ) && $show_ad ) {
            echo '<div class="b-r--after-site-content container">' . do_shortcode( $ad_options['r_after_site_content'] ) . '</div>';
        }

        if ( wp_is_mobile() && ! empty( $ad_options['r_after_site_content_mob'] ) && $show_ad ) {
            echo '<div class="b-r--after-site-content container">' . do_shortcode( $ad_options['r_after_site_content_mob'] ) . '</div>';
        }
    ?>

    <?php
        if ( ! is_singular() || 'checked' != get_post_meta( $post->ID, 'footer_menu_hide', true ) ) {
            get_template_part( 'template-parts/layout/footer', 'navigation' );
        }

        if ( ! is_singular() || 'checked' != get_post_meta( $post->ID, 'footer_hide', true ) ) {
            get_template_part( 'template-parts/layout/footer' );
        }
    ?>

</div><!-- #page -->


<?php wp_footer(); ?>
<?php echo root_get_option( 'code_body' ) ?>

<?php
$slider_count_mod = root_get_option( 'structure_slider_count' );

if ( ( is_front_page() || is_home() ) && $slider_count_mod != 0 ) { ?>
    <!-- Initialize Swiper -->
    <script>
        var wpshopSwiperThumbs = new Swiper('.js-swiper-home', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            <?php if ( is_numeric( root_get_option( 'structure_slider_autoplay' ) ) && root_get_option( 'structure_slider_autoplay' ) > 0 ) { ?>
            autoplay: {
                delay: <?php echo root_get_option( 'structure_slider_autoplay' ) ?>,
                disableOnInteraction: true,
            },
            <?php } ?>
        });
    </script>
<?php } ?>

</body>
</html>