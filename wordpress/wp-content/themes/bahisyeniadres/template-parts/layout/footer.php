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


$is_show_arrow       = 'yes' == root_get_option( 'structure_arrow' );
$structure_arrow_mob = ( 'yes' == root_get_option( 'structure_arrow_mob' ) ) ? ' data-mob="on"' : '';

?>


<?php do_action( THEME_SLUG . '_before_footer' ); ?>

    <footer class="site-footer <?php root_site_footer_classes() ?>" itemscope itemtype="http://schema.org/WPFooter">
        <div class="site-footer-inner <?php root_site_footer_inner_classes() ?>">

            <div class="footer-info">
                <?php
                $footer_copyright = root_get_option( 'footer_copyright' );
                $footer_copyright = str_replace( '%year%', date( 'Y' ), $footer_copyright );
                echo $footer_copyright;
                ?>

                <?php
                $footer_text = root_get_option( 'footer_text' );
                if ( ! empty( $footer_text ) ) echo '<div class="footer-text">' . $footer_text . '</div>';
                ?>

                <?php if ( 'yes' == root_get_option( 'wpshop_partner_enable' ) ) : ?>
                <!--noindex-->
                    <div class="footer-partner">
                        <?php
                            wpshop_partner_link( array(
                                'prefix' => root_get_option( 'wpshop_partner_prefix' ),
                                'postfix' => root_get_option( 'wpshop_partner_postfix' )
                            ) );
                        ?>
                    </div>
                <!--/noindex-->
                <?php endif; ?>
            </div><!-- .site-info -->

            <?php if ( root_get_option(  'footer_social' ) == 'yes' ) {
                get_template_part( 'template-parts/social', 'links' );
            } ?>

            <?php
            $footer_counters = root_get_option( 'footer_counters' );
            if ( ! empty( $footer_counters ) ) echo '<div class="footer-counters">'. $footer_counters .'</div>';
            ?>

        </div><!-- .site-footer-inner -->
    </footer><!-- .site-footer -->


    <?php if ( $is_show_arrow ) { ?>
        <button type="button" class="scrolltop js-scrolltop"<?php echo $structure_arrow_mob ?>></button>
    <?php } ?>

<?php do_action( THEME_SLUG . '_after_footer' ); ?>