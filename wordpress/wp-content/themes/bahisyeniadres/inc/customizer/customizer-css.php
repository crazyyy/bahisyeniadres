<?php

function root_customizer_css() {

    $root_skin  = root_get_option( 'skin' );
    $bg_pattern = root_get_option( 'bg_pattern' );

    echo '<style>';

    // layout  >  header
    $header_padding_top = root_get_option( 'header_padding_top' );
    if ( ! empty( $header_padding_top ) && $header_padding_top > 0 ) {
        echo '@media (min-width: 768px) {';
        echo '.site-header { padding-top: '. $header_padding_top .'px; }';
        echo '}';
    }

    $header_padding_bottom = root_get_option( 'header_padding_bottom' );
    if ( ! empty( $header_padding_bottom ) && $header_padding_bottom > 0 ) {
        echo '@media (min-width: 768px) {';
        echo '.site-header { padding-bottom: '. $header_padding_bottom .'px; }';
        echo '}';
    }

    // layout  >  header menu
    $root_navigation_main_fixed = root_get_option( 'navigation_main_fixed' );
    if ( $root_navigation_main_fixed == 'yes' ) {
        echo '.site-navigation-fixed { position: fixed; display: none; top: 0; z-index: 9999; } .admin-bar .site-navigation-fixed { top: 32px; }';
    }

    // layout  >  footer menu
    $root_navigation_footer_mob = root_get_option( 'navigation_footer_mob' );
    if ( $root_navigation_footer_mob == 'yes' ) {
        echo '@media (max-width: 991px) { .footer-navigation {display: block;} }';
    }


    // blocks  >  header
    $root_header_search_mob = root_get_option( 'header_search_mob' );
    if ( $root_header_search_mob == 'yes' ) {
        echo '@media (max-width: 991px) { .mob-search {display: block; margin-bottom: 25px;} }';
    }

    // blocks  >  sidebar
    $root_structure_sidebar_mob = root_get_option( 'structure_sidebar_mob' );
    if ( $root_structure_sidebar_mob == 'yes' ) {
        echo '@media (max-width: 991px) { .widget-area {display: block; float: none !important; padding: 15px 20px;} }';
    }


    // modules  >  scroll to top
    $root_color_arrow_bg = root_get_option( 'structure_arrow_bg' );
    if ( ! empty( $root_color_arrow_bg ) ) {
        echo '.scrolltop { background-color: ' . $root_color_arrow_bg . ';}';
    }

    $root_color_arrow = root_get_option( 'structure_arrow_color' );
    if ( ! empty( $root_color_arrow ) ) {
        echo '.scrolltop:after { color: ' . $root_color_arrow . ';}';
    }

    $root_arrow_width = root_get_option( 'structure_arrow_width' );
    if ( ! empty( $root_arrow_width ) ) {
        echo '.scrolltop { width: ' . $root_arrow_width . 'px;}';
    }

    $root_arrow_height = root_get_option( 'structure_arrow_height' );
    if ( ! empty( $root_arrow_height ) ) {
        echo '.scrolltop { height: ' . $root_arrow_height . 'px;}';
    }

    $root_icon = root_get_option( 'structure_arrow_icon' );
    if ( ! empty( $root_icon ) ) {
        echo '.scrolltop:after { content: "'. $root_icon .'"; }';
    }


    // typography
    $root_main_fonts                  = root_get_option( 'typography_family' );
    $root_main_fonts_site_title       = root_get_option( 'typography_site_title_family' );
    $root_main_fonts_site_description = root_get_option( 'typography_site_description_family' );
    $root_main_fonts_headers          = root_get_option( 'typography_headers_family' );
    $root_main_fonts_menu_links       = root_get_option( 'typography_menu_links_family' );

    //global $fonts;
    global $class_fonts;

    echo 'body { font-family: '. $class_fonts->get_font_family( $root_main_fonts ) .'; }';
    echo '.site-title, .site-title a { font-family: '. $class_fonts->get_font_family( $root_main_fonts_site_title ) .'; }';
    echo '.site-description { font-family: '. $class_fonts->get_font_family( $root_main_fonts_site_description ) .'; }';

    echo '.entry-content h1, .entry-content h2, .entry-content h3, .entry-content h4, .entry-content h5, .entry-content h6, ';
    echo '.entry-image__title h1, .entry-title, .entry-title a ';
    echo '{ font-family: '. $class_fonts->get_font_family( $root_main_fonts_headers ) .'; }';

    echo '.main-navigation ul li a, .main-navigation ul li .removed-link, .footer-navigation ul li a, .footer-navigation ul li .removed-link';
    echo '{ font-family: '. $class_fonts->get_font_family( $root_main_fonts_menu_links ) .'; }';

    $root_typography_font_size = root_get_option( 'typography_font_size' );
    if ( ! empty( $root_typography_font_size ) ) {
        echo '@media (min-width: 576px) { body { font-size: ' . $root_typography_font_size . 'px;} }';
    }

    $root_typography_site_title_size = root_get_option( 'typography_site_title_size' );
    if ( ! empty( $root_typography_site_title_size ) ) {
        echo '@media (min-width: 576px) { .site-title, .site-title a { font-size: ' . $root_typography_site_title_size . 'px;} }';
    }

    $root_typography_site_description_size = root_get_option( 'typography_site_description_size' );
    if ( ! empty( $root_typography_site_description_size ) ) {
        echo '@media (min-width: 576px) { .site-description { font-size: ' . $root_typography_site_description_size . 'px;} }';
    }

    $root_typography_menu_links_size = root_get_option( 'typography_menu_links_size' );
    if ( ! empty( $root_typography_menu_links_size ) ) {
        echo '@media (min-width: 576px) { .main-navigation ul li a, .main-navigation ul li .removed-link, .footer-navigation ul li a, .footer-navigation ul li .removed-link { font-size: ' . $root_typography_menu_links_size . 'px;} }';
    }

    $root_typography_line_height = root_get_option( 'typography_line_height');
    if ( ! empty( $root_typography_line_height ) ) {
        echo '@media (min-width: 576px) { body { line-height: ' . $root_typography_line_height . ';} }';
    }

    $root_typography_site_title_line_height = root_get_option( 'typography_site_title_line_height');
    if ( ! empty( $root_typography_site_title_line_height ) ) {
        echo '@media (min-width: 576px) { .site-title, .site-title a { line-height: ' . $root_typography_site_title_line_height . ';} }';
    }

    $root_typography_menu_links_line_height = root_get_option( 'typography_menu_links_line_height');
    if ( ! empty( $root_typography_menu_links_line_height ) ) {
        echo '@media (min-width: 576px) { .main-navigation ul li a, .main-navigation ul li .removed-link, .footer-navigation ul li a, .footer-navigation ul li .removed-link { line-height: ' . $root_typography_menu_links_line_height . ';} }';
    }

    $root_typography_headers_bold = root_get_option( 'typography_headers_bold' );
    if ( isset( $root_typography_headers_bold ) && $root_typography_headers_bold != 'bold' ) {
        echo '.entry-content h1, .entry-content h2, .entry-content h3, .entry-content h4, .entry-content h5, .entry-content h6, ';
        echo '.entry-image__title h1, .entry-title ';
        echo '{ font-weight: '. $root_typography_headers_bold .'; }';
    }

    $root_typography_menu_links_bold = root_get_option( 'typography_menu_links_bold' );
    if ( isset( $root_typography_menu_links_bold ) && $root_typography_menu_links_bold != 'normal' ) {
        echo '.main-navigation ul li a, .main-navigation ul li .removed-link, .footer-navigation ul li a, .footer-navigation ul li .removed-link { font-weight: '. $root_typography_menu_links_bold .'; }';
    }

    $root_typography_headers_style = root_get_option( 'typography_headers_style' );
    if ( isset( $root_typography_headers_style ) && $root_typography_headers_style != 'normal' ) {
        echo '.entry-content h1, .entry-content h2, .entry-content h3, .entry-content h4, .entry-content h5, .entry-content h6, ';
        echo '.entry-image__title h1, .entry-title ';
        if ( $root_typography_headers_style == 'italic' ) {
            echo '{ font-style: italic; }';
        }
        else {
            echo '{ text-decoration: '. $root_typography_headers_style .'; }';
        }
        if ( $root_typography_headers_style == 'underline' ) {
            echo '.entry-title a, .entry-title a:hover { border: none; }';
        }
    }

    $root_typography_menu_links_style = root_get_option( 'typography_menu_links_style' );
    if ( isset( $root_typography_menu_links_style ) && $root_typography_menu_links_style != 'normal' ) {
        echo '.main-navigation ul li a, .main-navigation ul li .removed-link, .footer-navigation ul li a, .footer-navigation ul li .removed-link ';
        if ( $root_typography_menu_links_style == 'italic' ) {
            echo '{ font-style: italic; }';
        }
        else {
            echo '{ text-decoration: '. $root_typography_menu_links_style .'; }';
        }
    }


    // colors
    $root_color_main = root_get_option( 'color_main' );
    if ( ! empty( $root_color_main ) ) {
        echo '.mob-hamburger span, .card-slider__category, .card-slider-container .swiper-pagination-bullet-active, .page-separator, .pagination .current, .pagination a.page-numbers:hover, .entry-content ul > li:before, .entry-content ul:not([class])>li:before, .taxonomy-description ul:not([class])>li:before, .btn, .comment-respond .form-submit input, .contact-form .contact_submit, .page-links__item';
        echo ' { background-color: ' . $root_color_main . ';}';
        echo '.spoiler-box, .entry-content ol li:before, .entry-content ol:not([class]) li:before, .taxonomy-description ol:not([class]) li:before, .mob-hamburger, .inp:focus, .search-form__text:focus, .entry-content blockquote,
         .comment-respond .comment-form-author input:focus, .comment-respond .comment-form-author textarea:focus, .comment-respond .comment-form-comment input:focus, .comment-respond .comment-form-comment textarea:focus, .comment-respond .comment-form-email input:focus, .comment-respond .comment-form-email textarea:focus, .comment-respond .comment-form-url input:focus, .comment-respond .comment-form-url textarea:focus { border-color: ' . $root_color_main . ';}';
        echo '.entry-content blockquote:before, .spoiler-box__title:after, .sidebar-navigation .menu-item-has-children:after,
        .star-rating--score-1:not(.hover) .star-rating-item:nth-child(1),
        .star-rating--score-2:not(.hover) .star-rating-item:nth-child(1), .star-rating--score-2:not(.hover) .star-rating-item:nth-child(2),
        .star-rating--score-3:not(.hover) .star-rating-item:nth-child(1), .star-rating--score-3:not(.hover) .star-rating-item:nth-child(2), .star-rating--score-3:not(.hover) .star-rating-item:nth-child(3),
        .star-rating--score-4:not(.hover) .star-rating-item:nth-child(1), .star-rating--score-4:not(.hover) .star-rating-item:nth-child(2), .star-rating--score-4:not(.hover) .star-rating-item:nth-child(3), .star-rating--score-4:not(.hover) .star-rating-item:nth-child(4),
        .star-rating--score-5:not(.hover) .star-rating-item:nth-child(1), .star-rating--score-5:not(.hover) .star-rating-item:nth-child(2), .star-rating--score-5:not(.hover) .star-rating-item:nth-child(3), .star-rating--score-5:not(.hover) .star-rating-item:nth-child(4), .star-rating--score-5:not(.hover) .star-rating-item:nth-child(5), .star-rating-item.hover { color: ' . $root_color_main . ';}';

        if ( $root_skin == 'skin-1' ) {
            echo '.widget-header, .entry-footer__more { background-color: ' . $root_color_main . ';}';
        }
    }

    $color_text = root_get_option( 'color_text' );
    if ( ! empty( $color_text ) ) {
        echo 'body { color: ' . $color_text . ';}';
    }

    $color_link = root_get_option( 'color_link' );
    if ( ! empty( $color_link ) ) {
        echo 'a, .spanlink, .comment-reply-link, .pseudo-link, .root-pseudo-link { color: ' . $color_link . ';}';
    }

    $color_link_hover = root_get_option( 'color_link_hover' );
    if ( ! empty( $color_link_hover ) ) {
        echo 'a:hover, a:focus, a:active, .spanlink:hover, .comment-reply-link:hover, .pseudo-link:hover { color: ' . $color_link_hover . ';}';
    }

    $color_header_bg = root_get_option( 'color_header_bg' );
    if ( ! empty( $color_header_bg ) ) {
        echo '.site-header { background-color: ' . $color_header_bg . ';}';
    }

    $color_logo = root_get_option( 'color_logo' );
    if ( ! empty( $color_logo ) ) {
        echo '.site-title, .site-title a { color: ' . $color_logo . ';}';
    }

    $color_description = root_get_option( 'color_description' );
    if ( ! empty( $color_description ) ) {
        echo '.site-description, .site-description a { color: ' . $color_description . ';}';
    }

    $color_menu_bg = root_get_option( 'color_menu_bg' );
    if ( ! empty( $color_menu_bg ) ) {
        echo '.main-navigation, .footer-navigation, .main-navigation ul li .sub-menu, .footer-navigation ul li .sub-menu { background-color: ' . $color_menu_bg . ';}';
    }

    $color_menu = root_get_option( 'color_menu' );
    if ( ! empty( $color_menu ) ) {
        echo '.main-navigation ul li a, .main-navigation ul li .removed-link, .footer-navigation ul li a, .footer-navigation ul li .removed-link { color: ' . $color_menu . ';}';
    }

    $color_footer_bg = root_get_option( 'color_footer_bg' );
    if ( ! empty( $color_footer_bg ) ) {
        echo '.site-footer { background-color: ' . $color_footer_bg . ';}';
    }


    // background
    $background_color = get_theme_mod( 'background_color', '' );
    if ( ! empty( $background_color ) && ( $background_color == 'fff' || $background_color == 'ffffff' ) ) {
        echo 'body { background-color: #fff;}';
    }

    if ( ! empty( $bg_pattern ) && $bg_pattern != 'no' ) {
        $pattern_url = root_get_pattern_url( $bg_pattern );
        if ( ! empty( $pattern_url ) ) echo 'body { background-image: url(' . get_bloginfo( 'template_url' ) . '/images/backgrounds/' . $pattern_url . ') }';
    }

    $header_bg = root_get_option( 'header_bg' );
    if ( ! empty( $header_bg ) ) {
        echo '@media (min-width: 768px) {';
        echo '.site-header { background-image: url("'. $header_bg .'"); }';
        echo '.site-header-inner {background: none;}';
        echo '}';
    }

    $header_bg_repeat = root_get_option( 'header_bg_repeat' );
    if ( ! empty( $header_bg_repeat ) ) {
        echo '@media (min-width: 768px) {';
        echo '.site-header { background-repeat: '. $header_bg_repeat .'; }';
        echo '}';
    }

    $header_bg_position = root_get_option( 'header_bg_position' );
    if ( ! empty( $header_bg_position ) ) {
        echo '@media (min-width: 768px) {';
        echo '.site-header { background-position: '. $header_bg_position .'; }';
        echo '}';
    }

    echo '</style>';
}
$customizer_styles_position = apply_filters( THEME_SLUG . '_customizer_styles_position', 'wp_head' );
$customizer_styles_priority = apply_filters( THEME_SLUG . '_customizer_styles_priority', 10 );
add_action( $customizer_styles_position, 'root_customizer_css', $customizer_styles_priority );