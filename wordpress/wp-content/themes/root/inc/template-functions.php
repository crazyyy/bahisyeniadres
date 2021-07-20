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


// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function root_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    return $classes;
}
add_filter( 'body_class', THEME_SLUG . '_body_classes' );


function wp_admin_bar_support() {
    global $wp_admin_bar;

    $wp_admin_bar->add_menu( array(
        'id'    => 'wp-admin-bar-support',
        'title' => '&rarr; Техническая поддержка',
        'href'  => 'https://wpshop.ru/support?utm_source=admin&utm_medium=admin_bar&utm_campaign=root',
        'meta'  => array(
            'target' => '_blank',
            'title'  => 'Техническая поддежка сайтов на WordPress',
        )
    ) );
}
add_action( 'wp_before_admin_bar_render', 'wp_admin_bar_support' );



/**
 * Возвращает форму слова в зависимости от колличества $number.
 *
 * @param int $number <p>число элементов</p>
 * @param array $forms <p>Формы слова для количества 1, 2 и 5, пример {носок,носка,носков}</p>
 * @return mixed
 */
function GetWordForms( $number,$forms ) {
    $cases = array (2, 0, 1, 1, 1, 2);
    return $forms[ ( $number%100 >4 && $number%100< 20 )? 2 : $cases[min( $number%10, 5 )] ];
};





if ( ! function_exists( 'do_excerpt' ) ) {
    /**
     * Short excerpt
     */
    function do_excerpt( $string, $word_limit ) {
        $string = strip_tags( $string );
        $words = explode( ' ', $string, ( $word_limit + 1 ) );
        if ( count( $words ) > $word_limit )
            array_pop( $words );
        $end = trim( implode( ' ', $words ) );

        $ret = $end;
        if ( count( $words ) > $word_limit ) $ret = $ret . '...';
        return $ret;
    }
}










/**
 * Single Paged class
 */
function single_paged_body_classes( $classes ) {
    global $wp_query;
    if ( is_single() && isset( $wp_query->query['page'] ) && $wp_query->query['page'] > 1 ) {
        $classes[] = 'single-paged';
    }

    return $classes;
}
add_filter( 'body_class', 'single_paged_body_classes' );


/**
 * Substring string by length
 *
 * @param $string
 * @param int $length
 *
 * @return string
 */
if ( ! function_exists( 'wpshop_substring_by_word' ) ) {
    function wpshop_substring_by_word( $string, $length = 200, $del = ' ' ) {
        if ( mb_strlen( $string ) > $length ) {
            $search = mb_strpos( $string, $del, $length );
            if ( $search ) {
                return mb_substr( $string, 0, $search );
            }
        }
        return $string;
    }
}


/**
 * Remove hentry from post classes
 */
add_filter( 'post_class', 'remove_hentry_from_post_classes' );
function remove_hentry_from_post_classes( $classes ) {
    $classes = str_replace( 'hentry', '', $classes );
    return $classes;
}


/**
 *  Remove text/css and text/javascript in styles and scripts
 */
function clean_style_tag( $src ) {
    return str_replace( "type='text/css'", '', $src );
}
add_filter( 'style_loader_tag', 'clean_style_tag' );

function clean_script_tag( $src ) {
    return str_replace( "type='text/javascript'", '', $src );
}
add_filter( 'script_loader_tag', 'clean_script_tag' );


/**
 * Microdata for images
 */
if ( ! function_exists( 'microformat_image' ) ) :
    function microformat_image($content) {
        $pattern  = '/<img (.*?) width="(.*?)" height="(.*?)" (.*?)>/i';
        $replace = '<span itemprop="image" itemscope itemtype="https://schema.org/ImageObject"><img itemprop="url image" \\1 width="\\2" height="\\3" \\4><meta itemprop="width" content="\\2"><meta itemprop="height" content="\\3"></span>';
        $content = preg_replace( $pattern, $replace, $content );
        return $content;
    }
    add_filter( 'the_content', 'microformat_image', 999 );
endif;


/**
 * Microdata publisher
 */
function get_microdata_publisher() {

    $logotype_image = root_get_option( 'logotype_image' );

    $out = '';
    $out .= '<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">';

    if ( ! empty( $logotype_image ) ) {
        $out .= '<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject" style="display: none;">';
        $out .= '<img itemprop="url image" src="' . $logotype_image . '" alt="' . get_bloginfo('name') . '">';
        $out .= '</div>';
    }

    $out .= '<meta itemprop="name" content="' . get_bloginfo( 'name' ) . '">';
    $out .= '<meta itemprop="telephone" content="' . apply_filters( 'wpshop_microdata_publisher_telephone', get_bloginfo( 'name' ) ) . '">';
    $out .= '<meta itemprop="address" content="' . apply_filters( 'wpshop_microdata_publisher_address', get_bloginfo( 'url' ) ) . '">';
    $out .= '</div>';

    return $out;
}


/**
 * Remove h2 from pagination and navigation
 */
function change_navigation_markup_template( $template, $class ) {
    $template = '
	<nav class="navigation %1$s" role="navigation">
		<div class="screen-reader-text">%2$s</div>
		<div class="nav-links">%3$s</div>
	</nav>';
    return $template;
};

add_filter( 'navigation_markup_template', 'change_navigation_markup_template', 10, 2 );


/**
 * Breadcrumbs
 */
/**
 * Remove last item from breadcrumbs SEO by YOAST
 * http://www.wpdiv.com/remove-post-title-yoast-seo-plugin-breadcrumb/
 */
function adjust_single_breadcrumb( $link_output) {
    if( strpos( $link_output, 'breadcrumb_last' ) !== false ) {
        $link_output = '';
    }
    return $link_output;
}
add_filter( 'wpseo_breadcrumb_single_link', 'adjust_single_breadcrumb' );


/**
 * Remove current link in menu
 *
 * @param $nav_menu
 * @param $args
 * @return mixed
 */
function remove_current_links_from_menu( $nav_menu, $args ) {
    preg_match_all( '/<li(.+?)class="(.+?)current-menu-item(.+?)>(<a(.+?)>(.+?)<\/a>)/ui', $nav_menu, $matches );

    if ( isset( $matches[4]) && ! empty( $matches[4] ) && preg_match( '/<a/ui', $matches[4][0] ) ) {
        foreach ( $matches[4] as $k => $v ) {
            if ( ! is_paged() ) {
                $nav_menu = str_replace( $v, '<span class="removed-link">' . $matches[6][$k] . '</span>', $nav_menu );
            }
        }
    }

    return $nav_menu;
}

add_filter( 'wp_nav_menu', 'remove_current_links_from_menu', PHP_INT_MAX, 2 );


/**
 * Remove role="navigation" for best validation w3
 *
 * @param $template
 * @param $class
 *
 * @return mixed
 */
function fix_validation_role_navigation( $template, $class ) {
    $template = str_replace( ' role="navigation"', '', $template );
    return $template;
}
add_filter( 'navigation_markup_template', 'fix_validation_role_navigation', 10, 2 );


/**
 * Allow work shortcode in term description
 */
add_filter( 'term_description','shortcode_unautop' );
add_filter( 'term_description','do_shortcode' );


/**
 * Disable shortcode wrapping in p
 */
if ( apply_filters( THEME_SLUG . '_disable_wrapping_shortcode', false ) ) {
    remove_filter( 'the_content', 'wpautop' );
    add_filter( 'the_content', 'wpautop', 99 );
    add_filter( 'the_content', 'shortcode_unautop', 999 );
}


/**
 * Add additional fields to user profile
 */
add_filter( 'user_contactmethods', 'wpshop_user_social_profiles', 0 );

function wpshop_user_social_profiles( $method ) {
    $user_social_profiles = [
        'facebook'      => __( 'Facebook profile link', THEME_TEXTDOMAIN ),
        'vk'            => __( 'Vkontakte profile link', THEME_TEXTDOMAIN ),
        'twitter'       => __( 'Twitter profile link', THEME_TEXTDOMAIN ),
        'ok'            => __( 'Odnoklassniki profile link', THEME_TEXTDOMAIN ),
        'telegram'      => __( 'Telegram profile link', THEME_TEXTDOMAIN ),
        'youtube'       => __( 'Youtube profile link', THEME_TEXTDOMAIN ),
        'instagram'     => __( 'Instagram profile link', THEME_TEXTDOMAIN ),
        'linkedin'      => __( 'Linkedin profile link', THEME_TEXTDOMAIN ),
        'whatsapp'      => __( 'Whatsapp profile link', THEME_TEXTDOMAIN ),
        'viber'         => __( 'Viber profile link', THEME_TEXTDOMAIN ),
        'pinterest'     => __( 'Pinterest profile link', THEME_TEXTDOMAIN ),
        'yandexzen'     => __( 'Yandex Zen profile link', THEME_TEXTDOMAIN ),
    ];

    $method = array_merge( $method, $user_social_profiles );

    return $method;
}


/**
 * Add shortcode for subscribe form
 */
function wpshop_subscribe_form() {
    get_template_part( 'template-parts/subscribe', 'box' );
}
add_shortcode( 'subscribeform', 'wpshop_subscribe_form' );


/**
 * Remove all symbols except numbers and minus
 *
 * @param $string
 *
 * @return mixed
 */
if ( ! function_exists( 'wpshop_sanitize_ids_string' ) ) {
    function wpshop_sanitize_ids_string( $string ) {

        $string = preg_replace( '/[^0-9-,]/', '', $string ); // оставляем цифры, минус, запятую
        $string = preg_replace( '/,{2,}/', ',', $string ); // удаляем две запятые и больше
        $string = preg_replace( '/-{2,}/', '-', $string ); // удаляем два и больше минуса

        return $string;
    }
}