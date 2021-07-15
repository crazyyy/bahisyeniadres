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

/**
 * Metaboxes
 */

function wpshop_core_metabox() {

    class Posts_Meta_Box extends Vetteo_Meta_Box {

        public function __construct() {
            $this->set_settings(
                'meta_posts_',
                apply_filters( THEME_SLUG . '_metabox_hide_elements_post_type', array( 'post' ) ),
                __( 'Root: Post settings', THEME_TEXTDOMAIN ),
                'advanced'
            );

            parent::__construct();
        }

        public function render_fields() {
            echo '<table class="form-table">';

            $this->field_text( 'source_link',            __( 'Source', THEME_TEXTDOMAIN ), 'http://...', __( 'If you need to provide a link to an external site as a source, fill in this field', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'source_hide',        __( 'Hide link', THEME_TEXTDOMAIN ), __( 'Hide link to source using JS', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'header_hide',        __( 'Hide header', THEME_TEXTDOMAIN ), __( 'Do not show the header on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'header_menu_hide',   __( 'Hide top menu', THEME_TEXTDOMAIN ), __( 'Do not show the top menu on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'thumb_hide',         __( 'Hide thumbnail', THEME_TEXTDOMAIN ), __( 'Do not show thumbnail or separator on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'breadcrumbs_hide',   __( 'Hide breadcrumbs', THEME_TEXTDOMAIN ), __( 'Do not show breadcrumbs on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'h1_hide',            __( 'Hide title', THEME_TEXTDOMAIN ), __( 'Do not show title H1 on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'meta_hide',          __( 'Hide meta-information', THEME_TEXTDOMAIN ), __( 'Do not show meta-information (date, category, author) on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'share_top_hide',     __( 'Hide top social buttons', THEME_TEXTDOMAIN ), __( 'Do not show top social buttons on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'toc_hide',           __( 'Hide contents', THEME_TEXTDOMAIN ), __( 'Do not show contents on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'rating_hide',        __( 'Hide rating', THEME_TEXTDOMAIN ), __( 'Do not show rating on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'author_box_hide',    __( 'Hide author box', THEME_TEXTDOMAIN ), __( 'Do not show author box on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'share_bottom_hide',  __( 'Hide bottom social buttons', THEME_TEXTDOMAIN ), __( 'Do not show bottom social buttons on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'related_posts_hide', __( 'Hide related posts', THEME_TEXTDOMAIN ), __( 'Do not show related posts on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'comments_hide',      __( 'Hide comments', THEME_TEXTDOMAIN ), __( 'Do not show comments on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'sidebar_hide',       __( 'Hide sidebar', THEME_TEXTDOMAIN ), __( 'Do not show sidebar on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'footer_menu_hide',   __( 'Hide bottom menu', THEME_TEXTDOMAIN ), __( 'Do not show the bottom menu on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'footer_hide',        __( 'Hide footer', THEME_TEXTDOMAIN ), __( 'Do not show footer on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'content_full_width', __( 'Content across the width', THEME_TEXTDOMAIN ), __( 'Make content across the entire width of the page without the sidebar', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'site_full_width',    __( 'Site across the width', THEME_TEXTDOMAIN ), __( 'Make the site across the width', THEME_TEXTDOMAIN ) );
            $this->field_text( 'related_posts_ids',      __( 'ID related posts', THEME_TEXTDOMAIN ), '', __( 'Enter the ID of the posts separated by commas to display certain posts in related posts', THEME_TEXTDOMAIN ) );

            echo '</table>';
        }

    }

    new Posts_Meta_Box;


    class Pages_Meta_Box extends Vetteo_Meta_Box {

        public function __construct() {
            $this->set_settings(
                'meta_pages_',
                'page',
                __( 'Root: Page settings', THEME_TEXTDOMAIN ),
                'advanced'
            );

            parent::__construct();
        }

        public function render_fields()
        {
            echo '<table class="form-table">';

            $this->field_checkbox( 'header_hide',        __( 'Hide header', THEME_TEXTDOMAIN ), __( 'Do not show the header on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'header_menu_hide',   __( 'Hide top menu', THEME_TEXTDOMAIN ), __( 'Do not show the top menu on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'thumb_hide',         __( 'Hide thumbnail', THEME_TEXTDOMAIN ), __( 'Do not show thumbnail or separator on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'breadcrumbs_hide',   __( 'Hide breadcrumbs', THEME_TEXTDOMAIN ), __( 'Do not show breadcrumbs on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'h1_hide',            __( 'Hide title', THEME_TEXTDOMAIN ), __( 'Do not show title H1 on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'share_top_hide',     __( 'Hide top social buttons', THEME_TEXTDOMAIN ), __( 'Do not show top social buttons on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'toc_hide',           __( 'Hide contents', THEME_TEXTDOMAIN ), __( 'Do not show contents on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'rating_hide',        __( 'Hide rating', THEME_TEXTDOMAIN ), __( 'Do not show rating on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'share_bottom_hide',  __( 'Hide bottom social buttons', THEME_TEXTDOMAIN ), __( 'Do not show bottom social buttons on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'related_posts_hide', __( 'Hide related posts', THEME_TEXTDOMAIN ), __( 'Do not show related posts on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'comments_hide',      __( 'Hide comments', THEME_TEXTDOMAIN ), __( 'Do not show comments on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'sidebar_hide',       __( 'Hide sidebar', THEME_TEXTDOMAIN ), __( 'Do not show sidebar on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'footer_menu_hide',   __( 'Hide bottom menu', THEME_TEXTDOMAIN ), __( 'Do not show the bottom menu on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'footer_hide',        __( 'Hide footer', THEME_TEXTDOMAIN ), __( 'Do not show footer on this page', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'content_full_width', __( 'Content across the width', THEME_TEXTDOMAIN ), __( 'Make content across the entire width of the page without the sidebar', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'site_full_width',    __( 'Site across the width', THEME_TEXTDOMAIN ), __( 'Make the site across the width', THEME_TEXTDOMAIN ) );

            echo '</table>';
        }

    }

    new Pages_Meta_Box;

}
add_action( 'after_setup_theme', 'wpshop_core_metabox' );