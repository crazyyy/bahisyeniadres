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




/**
 * ВНИМАНИЕ!
 *
 * НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ,
 * ПРИ ОБНОВЛЕНИИ ВЫ ПОТЕРЯЕТЕ ВСЕ ВАШИ ИЗМЕНЕНИЯ
 *
 * Используйте наш плагин https://docs.wpshop.ru/profunctions/
 */





/**
 * ВНИМАНИЕ!
 *
 * НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ,
 * ПРИ ОБНОВЛЕНИИ ВЫ ПОТЕРЯЕТЕ ВСЕ ВАШИ ИЗМЕНЕНИЯ
 *
 * Используйте наш плагин https://docs.wpshop.ru/profunctions/
 */







$theme = wp_get_theme();
if ( $theme->parent() ) {
    $theme = $theme->parent();
}
define( 'THEME_VERSION', $theme->get( 'Version' ) );
define( 'THEME_TEXTDOMAIN', $theme->get( 'TextDomain' ) );
define( 'THEME_NAME',       'root' );
define( 'THEME_TITLE',      'Root' );
define( 'THEME_SLUG',       'root' );

$theme_version = THEME_VERSION;


load_theme_textdomain( THEME_TEXTDOMAIN, get_template_directory() . '/languages' );


if ( ! function_exists( 'root_setup' ) ) :
    function root_setup() {

        // Add default posts and comments RSS feed links to head.
        if ( apply_filters( THEME_SLUG . '_allow_rss_links', false ) ) {
            add_theme_support( 'automatic-feed-links' );
        }


        // Let WordPress manage the document title.
	    add_theme_support( 'title-tag' );


        // Switch default core markup to output valid HTML5.
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );


        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support( 'post-thumbnails' );
        $thumb_big_sizes  = apply_filters( 'root_thumb_big_sizes', array( 770, 330, true ) );
        $thumb_wide_sizes = apply_filters( 'root_thumb_wide_sizes', array( 330, 140, true ) );
        if ( function_exists( 'add_image_size' ) ) {
            add_image_size( 'thumb-big', $thumb_big_sizes[0], $thumb_big_sizes[1], $thumb_big_sizes[2]);
            add_image_size( 'thumb-wide', $thumb_wide_sizes[0], $thumb_wide_sizes[1], $thumb_wide_sizes[2] );
        }


        // Set up the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'revelation_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        ) ) );


        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'top_menu'    => esc_html__( 'Top menu', THEME_TEXTDOMAIN ),
            'header_menu' => esc_html__( 'Header menu', THEME_TEXTDOMAIN ),
            'footer_menu' => esc_html__( 'Footer menu', THEME_TEXTDOMAIN ),
        ) );

    }
endif;
add_action( 'after_setup_theme', 'root_setup' );



/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function root_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'root_content_width', 700 );
}
add_action( 'after_setup_theme', 'root_content_width', 0 );



/**
 * Register widget area.
 */
function root_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', THEME_TEXTDOMAIN ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', THEME_TEXTDOMAIN ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-header">',
		'after_title'   => '</div>',
	) );
}
add_action( 'widgets_init', 'root_widgets_init' );



/**
 * Enqueue scripts and styles.
 */
function root_scripts() {
    global $theme_version;

    // get list of font families options
    $fonts_options = array(
        'typography_family',
        'typography_headers_family',
        'typography_site_title_family',
        'typography_site_description_family',
        'typography_menu_links_family',
    );

    // get list of font families
    $fonts_list = array();
    foreach ( $fonts_options as $fonts_option ) {
        $fonts_list[] = root_get_option( $fonts_option );
    }

    // get enqueue link
    //$class_fonts = new \Wpshop\Core\Fonts();
    global $class_fonts;
    $google_fonts = $class_fonts->get_enqueue_link( $fonts_list );

    // enqueue link
    if ( ! empty( $google_fonts ) ) {
        wp_enqueue_style( 'google-fonts', $google_fonts, false );
    }

    $style_version = apply_filters( 'root_style_version', $theme_version );

	wp_enqueue_style(  'root-style',   get_template_directory_uri() . '/css/style.min.css', array(), $style_version );

    if ( is_front_page() || is_home() ) {
        wp_enqueue_script( 'root-swiper', get_template_directory_uri() . '/js/swiper.min.js', array(), $style_version, true );
    }

    wp_enqueue_script( 'root-lightbox', get_template_directory_uri() . '/js/lightbox.js', array(), $style_version, true );

    wp_enqueue_script( 'root-scripts', get_template_directory_uri() . '/js/scripts.min.js', array('jquery'), $style_version, true );

    wp_localize_script( THEME_NAME . '-scripts', 'settings_array', array(
            'rating_text_average' => __( 'average', THEME_TEXTDOMAIN ),
            'rating_text_from'    => __( 'from', THEME_TEXTDOMAIN ),
            'lightbox_enabled'    => root_get_option( 'lightbox_enabled' )
        )
    );

    // ajax
    wp_localize_script( THEME_NAME . '-scripts' , 'wps_ajax', array(
        'url'   => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'wpshop-nonce' )
    ) );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
function root_admin_scripts() {
    wp_enqueue_style( 'root-admin-style', get_template_directory_uri() . '/css/style.admin.min.css', array(), null );
    wp_enqueue_script( 'root-admin-scripts', get_template_directory_uri() . '/js/admin.js', array('jquery'), null, true );
}
add_action( 'wp_enqueue_scripts', 'root_scripts' );
add_action( 'admin_enqueue_scripts', 'root_admin_scripts' );



/**
 * Editor styles
 */
function wpshop_add_editor_style() {
    add_editor_style( 'css/editor-styles.min.css' );
}
add_action( 'current_screen', 'wpshop_add_editor_style' );



/**
 * Gutenberg scripts and styles
 */
function wpshop_enqueue_gutenberg() {
    wp_enqueue_script(
        THEME_SLUG . '-gutenberg',
        get_template_directory_uri() . '/js/gutenberg.js',
        array( 'wp-blocks', 'wp-dom' ),
        THEME_VERSION,
        true
    );

    wp_enqueue_style(
        THEME_SLUG . '-gutenberg',
        get_template_directory_uri() . '/css/gutenberg.min.css',
        array(),
        THEME_VERSION
    );
}
add_action( 'enqueue_block_editor_assets', 'wpshop_enqueue_gutenberg' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';


/**
 * New Core WPShop
 */
require get_template_directory() . '/inc/core/core.php';


/**
 * Partner
 */
require get_template_directory() . '/inc/partner.php';


/**
 * WPShop.biz functions
 */
require get_template_directory() . '/inc/template-functions.php';


/**
 * Clear WP
 */
require get_template_directory() . '/inc/clear-wp.php';


/**
 * Pseudo links
 */
require get_template_directory() . '/inc/pseudo-links.php';


/**
 * Sitemap
 */
require get_template_directory() . '/inc/core/sitemap.php';


/**
 * Contact Form
 */
require get_template_directory() . '/inc/contact-form.php';


/**
 * Widgets
 */
require get_template_directory() . '/inc/widgets/widgets.php';


/**
 * Shortcodes
 */
require get_template_directory() . '/inc/shortcodes.php';


/**
 * TinyMCE
 */
if ( is_admin() ) {
    require get_template_directory() . '/inc/tinymce.php';
}


/**
 * Comments
 */
require get_template_directory() . '/inc/comments.php';


/**
 * Smiles
 */
require get_template_directory() . '/inc/smiles.php';


/**
 * Taxonomy header h1
 */
require get_template_directory() . '/inc/taxonomy-header.php';


/**
 * Metaboxes
 */
require get_template_directory() . '/inc/core/metaboxes.php';
require get_template_directory() . '/inc/metaboxes.php';


/**
 * Thumbnails
 */
require get_template_directory() . '/inc/thumbnails.php';


/**
 * Breadcrumbs
 */
require get_template_directory() . '/inc/core/breadcrumbs.php';


/**
 * Transliteration
 */
require get_template_directory() . '/inc/core/transliteration.php';


/**
 * TOC
 */
require get_template_directory() . '/inc/core/toc.php';


/**
 * Star rating
 */
require get_template_directory() . '/inc/core/star-rating.php';


/**
 * Admin
 */
require get_template_directory() . '/inc/admin.php';


/**
 * Admin Ad
 */
require get_template_directory() . '/inc/admin-ad.php';


/**
 * Theme updater
 */
require get_template_directory() . '/inc/theme-update-checker.php';

$theme_name 		= 'root';

$revelation_options = get_option( 'revelation_options' );
if ( isset( $revelation_options['license'] ) && ! empty( $revelation_options['license'] ) ) {

    $update_checker = new ThemeUpdateChecker(
        'root',
        'https://api.wpgenerator.ru/wp-update-server/?action=get_metadata&slug='. $theme_name . '&license_key=' . $revelation_options['license']
    );

}



/**
 * Excerpt
 */
if ( ! function_exists( 'new_excerpt_length' ) ) :
    function new_excerpt_length( $length ) {
        return apply_filters( 'root_excerpt_length', 28 );
    }
    add_filter( 'excerpt_length', 'new_excerpt_length' );
endif;

if ( ! function_exists( 'change_excerpt_more' ) ) :
    function change_excerpt_more( $more ) {
        return apply_filters( 'root_excerpt_more', '...' );
    }
    add_filter( 'excerpt_more', 'change_excerpt_more' );
endif;



function root_options_defaults() {
    $defaults = apply_filters( 'root_options_defaults', array(

        // layout  >  header
        'header_width'                       => 'fixed',
        'header_inner_width'                 => 'full',
        'header_padding_top'                 => 0,
        'header_padding_bottom'              => 0,

        // layout  >  header menu
        'navigation_main_width'              => 'fixed',
        'navigation_main_inner_width'        => 'full',
        'navigation_main_fixed'              => 'no',

        // layout  >  footer menu
        'navigation_footer_width'            => 'fixed',
        'navigation_footer_inner_width'      => 'full',
        'navigation_footer_mob'              => 'no',

        // layout  >  footer
        'footer_width'                       => 'fixed',
        'footer_inner_width'                 => 'full',


        // blocks  >  header
        'logotype_image'                     => '',
        'header_hide_title'                  => 'no',
        'header_social'                      => 'yes',
        'header_html_block_1'                => '',
        'header_html_block_2'                => '',
        'header_search_mob'                  => 'yes',

        // blocks  >  footer
        'footer_copyright'                   => '© %year% ' . get_bloginfo( 'name' ),
        'footer_text'                        => '',
        'footer_counters'                    => '',
        'footer_social'                      => 'yes',

        // blocks  >  home
        'structure_home_posts'               => 'post-box',
        'structure_home_sidebar'             => 'right',
        'structure_home_h1'                  => '',
        'structure_home_text'                => '',
        'structure_home_position'            => 'bottom',

        // block  >  single
        'structure_single_sidebar'           => 'right',
        'structure_single_thumb'             => 'yes',
        'structure_single_author'            => 'yes',
        'structure_single_date'              => 'yes',
        'structure_single_category'          => 'yes',
        'structure_single_social'            => 'yes',
        'structure_single_excerpt'           => 'yes',
        'structure_single_comments_count'    => 'yes',
        'structure_single_views'             => 'yes',
        'structure_single_tags'              => 'yes',
        'structure_single_rating'            => 'no',
        'structure_single_author_box'        => 'no',
        'structure_single_social_bottom'     => 'yes',
        'structure_single_related'           => '6',
        'structure_single_comments'          => 'yes',

        // blocks  >  page
        'structure_page_sidebar'             => 'right',
        'structure_page_thumb'               => 'no',
        'structure_page_social'              => 'no',
        'structure_page_rating'              => 'no',
        'structure_page_social_bottom'       => 'no',
        'structure_page_related'             => '6',
        'structure_page_comments'            => 'no',

        // blocks  >  archive
        'structure_archive_posts'            => 'post-box',
        'structure_archive_sidebar'          => 'right',
        'structure_archive_breadcrumbs'      => 'yes',
        'structure_child_categories'         => 'yes',
        'structure_archive_description'      => 'top',

        // blocks  >  comments
        'comments_form_title'                => __( 'Add a comment', THEME_TEXTDOMAIN ),
        'comments_text_before_submit'        => '',
        'comments_date'                      => 'yes',
        'comments_time'                      => 'yes',
        'comments_smiles'                    => 'yes',

        // blocks  >  post cards
        'structure_posts_tag'                => 'div',
        'structure_posts_author'             => 'yes',
        'structure_posts_date'               => 'yes',
        'structure_posts_category'           => 'yes',
        'structure_posts_excerpt'            => 'yes',
        'structure_posts_comments'           => 'yes',
        'structure_posts_views'              => 'yes',

        // blocks  >  sidebar
        'structure_sidebar_mob'              => 'no',


        // modules  >  slider
        'structure_slider_width'             => 'content',
        'structure_slider_autoplay'          => 2500,
        'structure_slider_count'             => 0,
        'structure_slider_order_post'        => 'new',
        'structure_slider_post_in'           => '',
        'structure_slider_category_in'       => '',
        'structure_slider_show_category'     => true,
        'structure_slider_show_title'        => true,
        'structure_slider_show_excerpt'      => true,
        'structure_slider_show_on_paged'     => false,

        // modules  >  toc
        'toc_enabled'                        => 'no',
        'toc_open'                           => true,
        'toc_noindex'                        => false,
        'toc_place'                          => false,
        'toc_title'                          => __( 'Contents', THEME_TEXTDOMAIN ),

        // modules  >  lightbox
        'lightbox_enabled'                   => false,

        // modules  >  breadcrumbs
        'breadcrumbs_display'                => 'yes',
        'breadcrumbs_home_text'              => __( 'Home', THEME_TEXTDOMAIN ),
        'breadcrumbs_separator'              => '»',
        'breadcrumbs_single_link'            => false,

        // modules  >  author block
        'author_link'                        => false,
        'author_link_target'                 => false,
        'author_social_enable'               => false,
        'author_social_title'                => __( 'Author profiles', THEME_TEXTDOMAIN ),
        'author_social_title_show'           => true,
        'author_social_js'                   => true,

        // modules  >  contact form
        'contact_form_text_before_submit'    => '',

        // modules  >  social profiles
        'social_facebook'                    => '',
        'social_vk'                          => '',
        'social_twitter'                     => '',
        'social_ok'                          => '',
        'social_telegram'                    => '',
        'social_youtube'                     => '',
        'social_instagram'                   => '',
        'social_linkedin'                    => '',
        'social_whatsapp'                    => '',
        'social_viber'                       => '',
        'social_pinterest'                   => '',
        'social_yandexzen'                   => '',
        'structure_social_js'                => 'yes',

        // modules  >  sitemap
        'sitemap_category_exclude'           => '',
        'sitemap_posts_exclude'              => '',
        'sitemap_pages_show'                 => true,
        'sitemap_pages_exclude'              => '',

        // modules  >  scroll to top
        'structure_arrow'                    => 'yes',
        'structure_arrow_bg'                 => '#cccccc',
        'structure_arrow_color'              => '#ffffff',
        'structure_arrow_width'              => '50',
        'structure_arrow_height'             => '50',
        'structure_arrow_icon'               => '\f102',
        'structure_arrow_mob'                => 'no',


        // codes
        'code_head'                          => '',
        'code_body'                          => '',
        'code_after_content'                 => '',


        // typography
        'typography_family'                  => 'roboto',
        'typography_font_size'               => '16',
        'typography_line_height'             => '1.5',
        'typography_site_title_family'       => 'roboto',
        'typography_site_title_size'         => '28',
        'typography_site_title_line_height'  => '1.1',
        'typography_site_description_family' => 'roboto',
        'typography_site_description_size'   => '16',
        'typography_headers_family'          => 'roboto',
        'typography_headers_style'           => 'normal',
        'typography_headers_bold'            => 'bold',
        'typography_links_family'            => 'roboto',
        'typography_links_size'              => '16',
        'typography_links_line_height'       => '1.5',
        'typography_links_style'             => 'normal',
        'typography_links_bold'              => 'normal',
        'typography_menu_links_family'       => 'roboto',
        'typography_menu_links_size'         => '16',
        'typography_menu_links_line_height'  => '1.5',
        'typography_menu_links_style'        => 'normal',
        'typography_menu_links_bold'         => 'normal',


        // colors
        'color_main'                         => '#5a80b1',
        'color_text'                         => '#333333',
        'color_link'                         => '#428bca',
        'color_link_hover'                   => '#e66212',
        'color_header_bg'                    => '#ffffff',
        'color_logo'                         => '#5a80b1',
        'color_description'                  => '#666666',
        'color_menu_bg'                      => '#5a80b1',
        'color_menu'                         => '#ffffff',
        'color_footer_bg'                    => '#ffffff',


        // background
        'body_bg_link'                       => '',
        'body_bg_link_js'                    => false,
        'header_bg'                          => '',
        'header_bg_repeat'                   => 'no-repeat',
        'header_bg_position'                 => 'center center',


        // tweak
        'content_full_width'                 => false,
        'social_share_title'                 => __( 'Like this post? Please share to your friends:', THEME_TEXTDOMAIN ),
        'social_share_title_show'            => true,
        'rating_title'                       => __( 'Rating', THEME_TEXTDOMAIN ),
        'rating_text_show'                   => true,
        'related_posts_title'                => __( 'Related articles', THEME_TEXTDOMAIN ),
        'advertising_page_display'           => false,
        'microdata_publisher_telephone'      => '',
        'microdata_publisher_address'        => '',


        // partner program
        'wpshop_partner_enable'              => 'no',
        'wpshop_partner_id'                  => get_wpshop_partner_id(),
        'wpshop_partner_prefix'              => __( 'Powered by theme', THEME_TEXTDOMAIN ),
        'wpshop_partner_postfix'             => '',


        'skin'                               => 'no',
        'bg_pattern'                         => 'no',
    ) );

    return $defaults;
}

function root_options() {
    $root_options = wp_parse_args(
        get_option( 'root_options', array() ),
        root_options_defaults()
    );

    return $root_options;
}

function root_get_option( $option ) {
    $root_options = root_options();

    return ( isset( $root_options[$option] ) ) ? $root_options[$option] : '' ;
}



/**
 * Site header classes
 */
function root_site_header_classes() {
    $option = root_get_option( 'header_width' );
    $out_class = ( $option == 'fixed' ) ? 'container' : '';

    $classes = apply_filters( 'root_site_header_classes', $out_class );
    echo $classes;
}



/**
 * Site header inner classes
 */
function root_site_header_inner_classes() {
    $option = root_get_option( 'header_inner_width' );
    $out_class = ( $option == 'fixed' ) ? 'container' : '';

    $classes = apply_filters( 'root_site_header_inner_classes', $out_class );
    echo $classes;
}



/**
 * Main navigation classes
 */
function root_navigation_main_classes() {
    $option = root_get_option( 'navigation_main_width' );
    $out_class = ( $option == 'fixed' ) ? 'container' : '';

    $classes = apply_filters( 'root_navigation_main_classes', $out_class );
    echo $classes;
}



/**
 * Main navigation inner classes
 */
function root_navigation_main_inner_classes() {
    $option = root_get_option( 'navigation_main_inner_width' );
    $out_class = ( $option == 'fixed' ) ? 'container' : '';

    $classes = apply_filters( 'root_navigation_main_inner_classes', $out_class );
    echo $classes;
}



/**
 * Fixed main navigation
 */
$root_navigation_main_fixed = root_get_option( 'navigation_main_fixed' );
if ( $root_navigation_main_fixed == 'yes' ) {
    add_action( 'wp_head', function() {
        echo "<script>var fixed_main_menu = 'yes';</script>";
    } );
}

function root_site_content_classes() {
    global $post;
    if ( ( is_single() || is_page() ) && 'checked' == get_post_meta( $post->ID, 'site_full_width', true ) ) {
        $classes = apply_filters( 'root_site_content_classes', '' );
        echo $classes;
    }
    else {
        $classes = apply_filters( 'root_site_content_classes', 'container' );
        echo $classes;
    }
}

function root_site_footer_classes() {
    $option = root_get_option( 'footer_width' );
    $out_class = ( $option == 'fixed' ) ? 'container' : '';

    $classes = apply_filters( 'root_site_footer_classes', $out_class );
    echo $classes;
}

function root_site_footer_inner_classes() {
    $option = root_get_option( 'footer_inner_width' );
    $out_class = ( $option == 'fixed' ) ? 'container' : '';

    $classes = apply_filters( 'root_site_footer_inner_classes', $out_class );
    echo $classes;
}

function root_navigation_footer_classes() {
    $option = root_get_option( 'navigation_footer_width' );
    $out_class = ( $option == 'fixed' ) ? 'container' : '';

    $classes = apply_filters( 'root_navigation_footer_classes', $out_class );
    echo $classes;
}

function root_navigation_footer_inner_classes() {
    $option = root_get_option( 'navigation_footer_inner_width' );
    $out_class = ( $option == 'fixed' ) ? 'container' : '';

    $classes = apply_filters( 'root_navigation_footer_inner_classes', $out_class );
    echo $classes;
}



/**
 * Content full width
 */
function root_styles_content_full_width() {
    if ( is_single() || is_page() ) {
        global $post;

        if ( 'checked' == get_post_meta( $post->ID, 'content_full_width', true ) ) {
            echo '<style>body.sidebar-none .breadcrumb, body.sidebar-none .entry-title, body.sidebar-none .entry-meta, body.sidebar-none .entry-content, body.sidebar-none .b-subscribe {max-width: 1090px;}body.sidebar-none .comments-area {max-width: 1090px; margin-left: auto; margin-right: auto;}</style>';
        }
    }
}
add_action( 'wp_head', 'root_styles_content_full_width' );



/**
 * Site full width
 */
function root_styles_site_full_width() {
    if ( is_single() || is_page() ) {
        global $post;
      
        if ( 'checked' == get_post_meta( $post->ID, 'site_full_width', true ) ) {
            echo '<style>@media (min-width: 992px) {.content-area { width: calc(100% - 360px); max-width: 820px;}body.sidebar-none .content-area {width: auto; max-width: 100%;}.b-related {margin-bottom: 30px; max-width: 700px; margin-left: auto; margin-right: auto;}body.sidebar-none .b-related {max-width: 940px; margin-right: auto; margin-left: auto;}}@media (min-width: 1200px) {.content-area {width: calc(100% - 430px); max-width: 1400px;}body.sidebar-none .b-related {max-width: 1090px; margin-right: auto; margin-left: auto;}}</style>';
        }
    }
}
add_action( 'wp_head', 'root_styles_site_full_width' );



/**
 * Body background link
 */
$wpshop_body_bg_link    = root_get_option( 'body_bg_link' );
$wpshop_body_bg_link_js = root_get_option( 'body_bg_link_js' );

if ( ! empty( $wpshop_body_bg_link ) ) {
    add_action( 'root_after_body', function() {
        global $wpshop_body_bg_link;
        global $wpshop_body_bg_link_js;

        echo '<div style="position:fixed; overflow:hidden; top:0px; left:0px; width:100%; height:100%;">';

        if ( $wpshop_body_bg_link_js ) {
            echo '<span class="js-link" data-href="' . base64_encode( $wpshop_body_bg_link ) . '" data-target="_blank" style="display:block; height:100%; width:100%;"></span>';
        } else {
            echo '<a href="' . $wpshop_body_bg_link . '" target="_blank" style="display:block; height:100%; width:100%;"></a>';
        }

        echo '</div>';
    } );
}



/**
 * Show comment time
 */
$comments_time = root_get_option( 'comments_time' );
if ( $comments_time != 'yes' ) {
    add_filter( 'root_comments_show_time', '__return_false' );
}



/**
 * TOC
 */
function root_toc_enabled() {
    $show = true;

    if ( is_single() || is_page() ) {
        global $post;

        if ( 'checked' == get_post_meta( $post->ID, 'toc_hide', true ) ) {
            $show = false;
        }
    }

    if ( 'no' != root_get_option( 'toc_enabled' ) && $show ) {
        $wpshop_toc = new Wpshop_Table_Of_Contents;
        $wpshop_toc->init();
    }


    $toc_open = root_get_option( 'toc_open' );
    if ( ! $toc_open ) {
        add_filter( 'wpshop_toc_open', '__return_false' );
    }


    $toc_noindex = root_get_option( 'toc_noindex' );
    if ( $toc_noindex ) {
        add_filter( 'wpshop_toc_noindex', '__return_true' );
    }


    $toc_place = root_get_option( 'toc_place' );
    if ( $toc_place ) {
        add_filter( 'wpshop_toc_place', '__return_false' );
    }


    $toc_title = root_get_option( 'toc_title' );
    if ( ! empty( $toc_title ) && $toc_title != 'Contents' ) {
        add_filter( 'wpshop_toc_header', 'wpshop_wpshop_toc_header_change' );
    }
    function wpshop_wpshop_toc_header_change() {
        global $wpshop_core;
        $toc_title = root_get_option( 'toc_title' );
        return $toc_title;
    }
}
add_action( 'wp', 'root_toc_enabled' );



/**
 * Breadcrumbs home text
 */
$breadcrumbs_home_text = root_get_option( 'breadcrumbs_home_text' );
if ( ! empty( $breadcrumbs_home_text ) ) {
    add_filter( 'wpshop_breadcrumbs_home_text', function() {
        $breadcrumbs_home_text = root_get_option( 'breadcrumbs_home_text' );
        return $breadcrumbs_home_text;
    } );
}



/**
 * Breadcrumbs separator
 */
$breadcrumbs_separator = root_get_option( 'breadcrumbs_separator' );
if ( ! empty( $breadcrumbs_separator ) ) {
    add_filter( 'wpshop_breadcrumbs_separator', function() {
        $wpshop_breadcrumbs_separator = root_get_option( 'breadcrumbs_separator' );
        return $wpshop_breadcrumbs_separator;
    } );
}



/**
 * Breadcrumbs single link
 */
$breadcrumbs_single_link = root_get_option( 'breadcrumbs_single_link' );
if ( $breadcrumbs_single_link ) {
    add_filter( 'wpshop_breadcrumb_single_link', '__return_true' );
}



/**
 * Author social title
 */
$author_social_title = root_get_option( 'author_social_title' );
if ( ! empty( $author_social_title ) && $author_social_title != 'Author profiles' ) {
    add_filter( 'root_author_social_title', 'author_social_title_change' );
}
function author_social_title_change() {
    $author_social_title = root_get_option( 'author_social_title' );
    return $author_social_title;
}



/**
 * Show title author social
 */
$author_social_title_show = root_get_option( 'author_social_title_show' );
if ( ! $author_social_title_show ) {
    add_filter( 'root_author_social_title_show', '__return_false' );
}



/**
 * Contact Form
 */
add_action( 'root_contact_form_before_button', function() {
    $contact_form_text_before_submit = root_get_option( 'contact_form_text_before_submit' );

    if ( ! empty( $contact_form_text_before_submit ) ) {
        echo '<div class="contact-form-notes-after">'. $contact_form_text_before_submit .'</div>';
    }
} );



/**
 * Exclude category in sitemap
 */
add_filter( 'wpshop_sitemap_category_exclude', function() {
    $sitemap_category_exclude = root_get_option( 'sitemap_category_exclude' );

    if ( ! empty( $sitemap_category_exclude ) ) {
        $sitemap_category_exclude_id = explode( ',', $sitemap_category_exclude );

        if ( is_array( $sitemap_category_exclude_id ) ) {
            $sitemap_category_exclude = array_map( 'trim', $sitemap_category_exclude_id );
        } else {
            $sitemap_category_exclude = array( $sitemap_category_exclude );
        }
    }

    return $sitemap_category_exclude;
} );



/**
 * Exclude posts in sitemap
 */
add_filter( 'wpshop_sitemap_posts_exclude', function() {
    $sitemap_posts_exclude = root_get_option( 'sitemap_posts_exclude' );

    if ( ! empty( $sitemap_posts_exclude ) ) {
        $sitemap_posts_exclude_id = explode( ',', $sitemap_posts_exclude );

        if ( is_array( $sitemap_posts_exclude_id ) ) {
            $sitemap_posts_exclude = array_map( 'trim', $sitemap_posts_exclude_id );
        } else {
            $sitemap_posts_exclude = array( $sitemap_posts_exclude );
        }
    }

    return $sitemap_posts_exclude;
} );



/**
 * Show pages in sitemap
 */
$sitemap_pages_show = root_get_option( 'sitemap_pages_show' );
if ( ! $sitemap_pages_show ) {
    add_filter( 'wpshop_sitemap_show_pages', '__return_false' );
}



/**
 * Exclude pages in sitemap
 */
add_filter( 'wpshop_sitemap_pages_exclude', function() {
    $sitemap_pages_exclude = root_get_option( 'sitemap_pages_exclude' );

    if ( ! empty( $sitemap_pages_exclude ) ) {
        $sitemap_pages_exclude_id = explode( ',', $sitemap_pages_exclude );

        if ( is_array( $sitemap_pages_exclude_id ) ) {
            $sitemap_pages_exclude = array_map( 'trim', $sitemap_pages_exclude_id );
        } else {
            $sitemap_pages_exclude = array( $sitemap_pages_exclude );
        }
    }

    return $sitemap_pages_exclude;
} );



/**
 * Content on full width
 */
$content_full_width = root_get_option( 'content_full_width' );
if ( $content_full_width ) {
    add_filter( 'root_site_content_classes', '__return_false' );
}



/**
 * Social buttons title
 */
$social_share_title = root_get_option( 'social_share_title' );
if ( ! empty( $social_share_title ) && $social_share_title != 'Like this post? Please share to your friends:' ) {
    add_filter( 'root_social_share_title', function() {
        $social_share_title = root_get_option( 'social_share_title' );
        return $social_share_title;
    } );
}



/**
 * Show title social buttons
 */
$social_share_title_show = root_get_option( 'social_share_title_show' );
if ( ! $social_share_title_show ) {
    add_filter( 'root_social_share_title_show', '__return_false' );
}



/**
 * Rating title
 */
$rating_title = root_get_option( 'rating_title' );
if ( ! empty( $rating_title ) && $rating_title != 'Rating' ) {
    add_filter( 'root_rating_title', function() {
        $rating_title = root_get_option( 'rating_title' );
        return $rating_title;
    } );
}



/**
 * Rating text
 */
$rating_text_show = root_get_option( 'rating_text_show' );
if ( ! $rating_text_show ) {
    add_filter( 'root_rating_text_show', '__return_false' );
}



/**
 * Related posts title
 */
$related_posts_title = root_get_option( 'related_posts_title' );
if ( ! empty( $related_posts_title ) && $related_posts_title != 'Related articles' ) {
    add_filter( 'root_related_title', function() {
        $related_posts_title = root_get_option( 'related_posts_title' );
        return $related_posts_title;
    } );
}



/**
 * Enable advertising on pages
 */
$advertising_page_display = root_get_option( 'advertising_page_display' );
if ( $advertising_page_display ) {
    add_filter( 'root_ad_single', '__return_false' );
}



/**
 * Microdata publisher telephone
 */
$microdata_publisher_telephone = root_get_option( 'microdata_publisher_telephone' );
if ( ! empty( $microdata_publisher_telephone ) ) {
    add_filter( 'wpshop_microdata_publisher_telephone', function() {
        $microdata_publisher_telephone = root_get_option( 'microdata_publisher_telephone' );
        return $microdata_publisher_telephone;
    } );
}



/**
 * Microdata publisher address
 */
$microdata_publisher_address = root_get_option( 'microdata_publisher_address' );
if ( ! empty( $microdata_publisher_address ) ) {
    add_filter( 'wpshop_microdata_publisher_address', function() {
        $microdata_publisher_address = root_get_option( 'microdata_publisher_address' );
        return $microdata_publisher_address;
    } );
}