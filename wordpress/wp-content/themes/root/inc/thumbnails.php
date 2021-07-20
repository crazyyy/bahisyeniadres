<?php
/**
 * ****************************************************************************
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   DON'T EDIT THIS FILE
 *
 * *****************************************************************************
 *
 * @package root
 */

function root_add_featured_image_display_settings( $content, $post_id ) {
    $field_text_before  = esc_html__( 'Рекомендуемый размер 770x330', THEME_TEXTDOMAIN );
    $content = '<p class="howto">'. $field_text_before . '</p>' . $content;

    return $content;
}
add_filter( 'admin_post_thumbnail_html', THEME_SLUG . '_add_featured_image_display_settings', 10, 2 );


function wpshop_core_thumbnails() {

    class Posts_Thumbnails extends Vetteo_Meta_Box {

        public function __construct() {
            $this->set_settings(
                'posts_thumb_',
                apply_filters( THEME_SLUG . '_metabox_thumbnail_post_type', array( 'post', 'page' ) ),
                __( 'Thumbnail settings', THEME_TEXTDOMAIN ),
                'side'
            );

            parent::__construct();
        }

        public function render_fields() {
            $field_text = '<p class="howto">' . sprintf( esc_html__( 'A thumbnail will be displayed on the page for the full width of the site. Recommended size %s', THEME_TEXTDOMAIN ), '1170x500' ) . '</p>';
            $this->field_checkbox( 'big_thumbnail_image',      '', __( 'Big thumbnail', THEME_TEXTDOMAIN ) . $field_text );
        }

    }

    new Posts_Thumbnails;

}
add_action( 'after_setup_theme', 'wpshop_core_thumbnails' );