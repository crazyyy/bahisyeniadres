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


$patterns = array(
    'wood'          => array(
        'label'     => esc_html__( 'Wood', THEME_TEXTDOMAIN ),
        'mini'      => 'wood-mini.jpg',
        'pattern'   => 'wood.jpg',
    ),
    'wood-2'        => array(
        'label'     => esc_html__( 'Wood 2', THEME_TEXTDOMAIN ),
        'mini'      => 'wood-2-mini.jpg',
        'pattern'   => 'wood-2.jpg',
    ),
    'blue-waves'    => array(
        'label'     => esc_html__( 'Blue waves', THEME_TEXTDOMAIN ),
        'mini'      => 'blue-waves-mini.png',
        'pattern'   => 'blue-waves.png',
    ),
    'plaid'         => array(
        'label'     => esc_html__( 'Plaid', THEME_TEXTDOMAIN ),
        'mini'      => 'plaid-mini.jpg',
        'pattern'   => 'plaid.jpg',
    ),
    'wallpaper'     => array(
        'label'     => esc_html__( 'Wallpaper', THEME_TEXTDOMAIN ),
        'mini'      => 'wallpaper-mini.png',
        'pattern'   => 'wallpaper.png',
    ),
    'honey'         => array(
        'label'     => esc_html__( 'Honey', THEME_TEXTDOMAIN ),
        'mini'      => 'honey-mini.png',
        'pattern'   => 'honey.png',
    ),
    'wall'          => array(
        'label'     => esc_html__( 'Wall', THEME_TEXTDOMAIN ),
        'mini'      => 'wall-mini.png',
        'pattern'   => 'wall.png',
    ),
    'sea' => array(
        'label'     => esc_html__( 'Sea', THEME_TEXTDOMAIN ),
        'mini'      => 'sea-mini.png',
        'pattern'   => 'sea.png',
    ),
    'dots' => array(
        'label'     => esc_html__( 'Dots', THEME_TEXTDOMAIN ),
        'mini'      => 'dots-mini.png',
        'pattern'   => 'dots.png',
    ),
);


/**
 * Convert theme_mod to options for old versions
 */
require get_template_directory() . '/inc/customizer/customizer-old-version.php';


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function root_customize_register( $wp_customize ) {

    $defaults = root_options_defaults();

    $post_cards = array(
        'post-box'      => __( 'One post is big', THEME_TEXTDOMAIN ),
        'post-card-one' => __( 'One post is small', THEME_TEXTDOMAIN ),
        'post-card'     => __( 'Small cards (2 or 3 per line)', THEME_TEXTDOMAIN ),
    );

    $sidebar_position = array(
        'right' => __( 'Right', THEME_TEXTDOMAIN ),
        'left'  => __( 'Left', THEME_TEXTDOMAIN ),
        'none'  => __( 'Do not show', THEME_TEXTDOMAIN ),
    );

    $font_size = array(
        'min'  => 10,
        'max'  => 36,
        'step' => 1
    );

    $font_line_height = array(
        'min'  => 0.5,
        'max'  => 3,
        'step' => 0.1
    );

    $font_bold = array(
        'normal' => __( 'Usual', THEME_TEXTDOMAIN ),
        '300'    => __( 'Thin', THEME_TEXTDOMAIN ),
        'bold'   => __( 'Bold', THEME_TEXTDOMAIN ),
        '800'    => __( 'Over bold', THEME_TEXTDOMAIN )
    );

    $font_style = array(
        'normal'       => __( 'Usual', THEME_TEXTDOMAIN ),
        'italic'       => __( 'Italic', THEME_TEXTDOMAIN ),
        'underline'    => __( 'Underlined', THEME_TEXTDOMAIN ),
        'line-through' => __( 'Crossed out', THEME_TEXTDOMAIN )
    );

    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    $root_transport = 'postMessage';

    // layout
    $wp_customize->add_panel( 'root_layout_panel', array(
        'priority'       => 10,
        'capability'     => 'edit_theme_options',
        'title'          => __( 'Layout', THEME_TEXTDOMAIN ),
        'type'           => 'default',
    ) );

    // layout  >  header
    $wp_customize->add_section(
        'root_layout_header',
        array(
            'title'      => __( 'Header', THEME_TEXTDOMAIN ),
            'panel'      => 'root_layout_panel',
            'capability' => 'edit_theme_options',
        )
    );

    $wp_customize->add_setting(
        'root_options[header_width]',
        array(
            'default'   => $defaults['header_width'],
            'type'      => 'option',
        )
    );
    $wp_customize->add_control(
        'root_options[header_width]',
        array(
            'settings'  => 'root_options[header_width]',
            'type'      => 'select',
            'section'   => 'root_layout_header',
            'label'     => __( 'Header width', THEME_TEXTDOMAIN ),
            'choices'   => array(
                'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN )
            ),
        )
    );

    $wp_customize->add_setting(
        'root_options[header_inner_width]',
        array(
            'default'   => $defaults['header_inner_width'],
            'type'      => 'option',
        )
    );
    $wp_customize->add_control(
        'root_options[header_inner_width]',
        array(
            'settings'  => 'root_options[header_inner_width]',
            'type'      => 'select',
            'section'   => 'root_layout_header',
            'label'     => __( 'Header inner width', THEME_TEXTDOMAIN ),
            'choices'   => array(
                'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN )
            ),
        )
    );

    $wp_customize->add_setting( 'root_options[header_padding_top]', array(
        'default'       => $defaults['header_padding_top'],
        'type'          => 'option',
        'sanitize_callback' => 'root_sanitize_integer',
        //'transport'      => $root_transport,
    ) );
    $wp_customize->add_control(
        new WP_Customize_Range_Control(
            $wp_customize,
            'root_options[header_padding_top]',
            array(
                'settings'      => 'root_options[header_padding_top]',
                'label'         => __( 'Header padding top', THEME_TEXTDOMAIN ),
                'section'       => 'root_layout_header',
                'description'   => __( 'You can set padding top, ex. for background image', THEME_TEXTDOMAIN ),
                'input_attrs'   => array(
                    'min'       => 0,
                    'max'       => 200,
                    'step'      => 1,
                ),
            )
        )
    );

    $wp_customize->add_setting( 'root_options[header_padding_bottom]', array(
        'default'       => $defaults['header_padding_bottom'],
        'type'          => 'option',
        'sanitize_callback' => 'root_sanitize_integer',
        //'transport'      => $root_transport,
    ) );
    $wp_customize->add_control(
        new WP_Customize_Range_Control(
            $wp_customize,
            'root_options[header_padding_bottom]',
            array(
                'settings'      => 'root_options[header_padding_bottom]',
                'label'         => __( 'Header padding bottom', THEME_TEXTDOMAIN ),
                'section'       => 'root_layout_header',
                'description'   => __( 'You can set padding bottom, ex. for background image', THEME_TEXTDOMAIN ),
                'input_attrs'   => array(
                    'min'       => 0,
                    'max'       => 200,
                    'step'      => 1,
                ),
            )
        )
    );


    // layout  >  header menu
    $wp_customize->add_section(
        'root_layout_navigation_main',
        array(
            'title'         => __( 'Header menu', THEME_TEXTDOMAIN ),
            'panel'         => 'root_layout_panel',
            'capability'    => 'edit_theme_options',
        )
    );

    $wp_customize->add_setting( 'root_options[navigation_main_width]',array(
        'default'           => $defaults['navigation_main_width'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[navigation_main_width]',
        array(
            'settings'      => 'root_options[navigation_main_width]',
            'type'          => 'select',
            'section'       => 'root_layout_navigation_main',
            'label'         => __( 'Main navigation width', THEME_TEXTDOMAIN ),
            'choices'       => array(
                'full'      => __( 'Full width', THEME_TEXTDOMAIN ),
                'fixed'     => __( 'Fixed width', THEME_TEXTDOMAIN )
            ),
        )
    );

    $wp_customize->add_setting( 'root_options[navigation_main_inner_width]',
        array(
            'default'       => $defaults['navigation_main_inner_width'],
            'type'          => 'option',
        )
    );
    $wp_customize->add_control( 'root_options[navigation_main_inner_width]',
        array(
            'settings'      => 'root_options[navigation_main_inner_width]',
            'type'          => 'select',
            'section'       => 'root_layout_navigation_main',
            'label'         => __( 'Main navigation inner width', THEME_TEXTDOMAIN ),
            'choices'       => array(
                'full'      => __( 'Full width', THEME_TEXTDOMAIN ),
                'fixed'     => __( 'Fixed width', THEME_TEXTDOMAIN )
            ),
        )
    );

    $wp_customize->add_setting( 'root_options[navigation_main_fixed]', array(
        'default'           => $defaults['navigation_main_fixed'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[navigation_main_fixed]', array(
        'settings'          => 'root_options[navigation_main_fixed]',
        'section'           => 'root_layout_navigation_main',
        'label'             => __( 'Make menu fixed?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, do', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, no need', THEME_TEXTDOMAIN ),
        ),
    ) );


    // layout  >  footer menu
    $wp_customize->add_section(
        'root_layout_navigation_footer',
        array(
            'title'         => __( 'Footer menu', THEME_TEXTDOMAIN ),
            'panel'         => 'root_layout_panel',
            'capability'    => 'edit_theme_options',
        )
    );

    $wp_customize->add_setting( 'root_options[navigation_footer_width]',array(
        'default'           => $defaults['navigation_footer_width'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[navigation_footer_width]',
        array(
            'settings'      => 'root_options[navigation_footer_width]',
            'type'          => 'select',
            'section'       => 'root_layout_navigation_footer',
            'label'         => __( 'Footer navigation width', THEME_TEXTDOMAIN ),
            'choices'       => array(
                'full'      => __( 'Full width', THEME_TEXTDOMAIN ),
                'fixed'     => __( 'Fixed width', THEME_TEXTDOMAIN )
            ),
        )
    );

    $wp_customize->add_setting( 'root_options[navigation_footer_inner_width]',
        array(
            'default'       => $defaults['navigation_footer_inner_width'],
            'type'          => 'option',
        )
    );
    $wp_customize->add_control( 'root_options[navigation_footer_inner_width]',
        array(
            'settings'      => 'root_options[navigation_footer_inner_width]',
            'type'          => 'select',
            'section'       => 'root_layout_navigation_footer',
            'label'         => __( 'Footer navigation inner width', THEME_TEXTDOMAIN ),
            'choices'       => array(
                'full'      => __( 'Full width', THEME_TEXTDOMAIN ),
                'fixed'     => __( 'Fixed width', THEME_TEXTDOMAIN )
            ),
        )
    );

    $wp_customize->add_setting( 'root_options[navigation_footer_mob]', array(
        'default'           => $defaults['navigation_footer_mob'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[navigation_footer_mob]', array(
        'settings'          => 'root_options[navigation_footer_mob]',
        'section'           => 'root_layout_navigation_footer',
        'label'             => __( 'Display menu on mobile?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );


    // layout  >  footer
    $wp_customize->add_section(
        'root_layout_footer',
        array(
            'title'         => __( 'Footer', THEME_TEXTDOMAIN ),
            'panel'         => 'root_layout_panel',
            'capability'    => 'edit_theme_options',
        )
    );

    $wp_customize->add_setting( 'root_options[footer_width]', array(
        'default'       => $defaults['footer_width'],
        'type'          => 'option',
    ) );
    $wp_customize->add_control( 'root_options[footer_width]',
        array(
            'settings'  => 'root_options[footer_width]',
            'type'      => 'select',
            'section'   => 'root_layout_footer',
            'label'     => __( 'Footer width', THEME_TEXTDOMAIN ),
            'choices'   => array(
                'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN )
            ),
        )
    );

    $wp_customize->add_setting( 'root_options[footer_inner_width]', array(
        'default'       => $defaults['footer_inner_width'],
        'type'          => 'option',
    ) );
    $wp_customize->add_control( 'root_options[footer_inner_width]',
        array(
            'settings'  => 'root_options[footer_inner_width]',
            'type'      => 'select',
            'section'   => 'root_layout_footer',
            'label'     => __( 'Footer inner width', THEME_TEXTDOMAIN ),
            'choices'   => array(
                'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN )
            ),
        )
    );


    // skins
    /*$wp_customize->add_section( 'root_skins', array(
        'title'         => __( 'Skins', THEME_TEXTDOMAIN ),
        'description'   => 'В данной секции Вы можете выбрать готовое оформление для сайта.<br><br>В ближайшее время мы добавим еще больше скинов.<br><span style="color:red;">BETA</span>',
        'priority'      => 30,
        'capability'    => 'edit_theme_options',
    ) );

    $wp_customize->add_setting('root_options[skin]', array(
        'default'       => $defaults['skin'],
        'type'          => 'option',
    ) );
    $wp_customize->add_control('root_options[skin]', array(
        'settings'      => 'root_options[skin]',
        'label'         => __( 'Skin', THEME_TEXTDOMAIN ),
        'section'       => 'root_skins',
        'type'          => 'radio',
        'choices'       => array(
            'no'        => __( 'No skins', THEME_TEXTDOMAIN ),
            'skin-1'    => __( 'Skin 1', THEME_TEXTDOMAIN ),
        ),
    ) );*/


    // blocks
    $wp_customize->add_panel( 'panel_structure', array(
        'priority'       => 12,
        'capability'     => 'edit_theme_options',
        'title'          => __( 'Blocks', THEME_TEXTDOMAIN ),
        'type'           => 'default',
    ) );

    // blocks  >  header
    $wp_customize->add_section( 'root_structure_header', array(
        'title'             => __( 'Header', THEME_TEXTDOMAIN ),
        'description'       => __( 'In this section you can customize the elements of the site header', THEME_TEXTDOMAIN ),
        'panel'             => 'panel_structure',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_setting( 'root_options[logotype_image]', array(
        'default'           => $defaults['logotype_image'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,
        'root_options[logotype_image]', array(
            'settings'      => 'root_options[logotype_image]',
            'label'         => __( 'Logotype', THEME_TEXTDOMAIN ),
            'section'       => 'root_structure_header',
        )
    ) );

    $wp_customize->add_setting( 'root_options[header_hide_title]', array(
        'default'           => 'no',
        'type'              => 'option',
    ) );
    $wp_customize->add_control('root_options[header_hide_title]', array(
        'settings'          => 'root_options[header_hide_title]',
        'label'             => __( 'Hide site title and description?', THEME_TEXTDOMAIN ),
        'description'       => __( 'If you hide the title and description, it is desirable to set for the main page h1, for example, in the section Blocks > Home', THEME_TEXTDOMAIN ),
        'section'           => 'root_structure_header',
        'type'              => 'radio',
        'choices'           => array(
            'no'            => __( 'Do not hide', THEME_TEXTDOMAIN ),
            'yes'           => __( 'Hide', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[header_social]', array(
        'default'           => $defaults['header_social'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[header_social]', array(
        'settings'          => 'root_options[header_social]',
        'section'           => 'root_structure_header',
        'label'             => __( 'Show social links?', THEME_TEXTDOMAIN ),
        'description'       => __( 'Links to social networks can be set in Modules > Social Profiles', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, show', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not show', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[header_html_block_1]', array(
        'default'           => $defaults['header_html_block_1'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[header_html_block_1]', array(
        'settings'          => 'root_options[header_html_block_1]',
        'section'           => 'root_structure_header',
        'label'             => __( 'HTML code #1', THEME_TEXTDOMAIN ),
        'description'       => __( 'Code will be displayed after logotype', THEME_TEXTDOMAIN ),
        'type'              => 'textarea',
    ) );

    $wp_customize->add_setting( 'root_options[header_html_block_2]', array(
        'default'           => $defaults['header_html_block_2'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[header_html_block_2]', array(
        'settings'          => 'root_options[header_html_block_2]',
        'section'           => 'root_structure_header',
        'label'             => __( 'HTML code #2', THEME_TEXTDOMAIN ),
        'description'       => __( 'Code will be displayed after top menu', THEME_TEXTDOMAIN ),
        'type'              => 'textarea',
    ) );

    $wp_customize->add_setting( 'root_options[header_search_mob]', array(
        'default'           => $defaults['header_search_mob'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[header_search_mob]', array(
        'settings'          => 'root_options[header_search_mob]',
        'section'           => 'root_structure_header',
        'label'             => __( 'Show mobile search?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );


    // blocks  >  footer
    $wp_customize->add_section( 'root_structure_footer', array(
        'title'             => __( 'Footer', THEME_TEXTDOMAIN ),
        'description'       => __( 'In this section, you can customize the look and texts of the basement, add counters', THEME_TEXTDOMAIN ),
        'panel'             => 'panel_structure',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_setting( 'root_options[footer_copyright]', array(
        'default'           => $defaults['footer_copyright'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[footer_copyright]', array(
        'settings'          => 'root_options[footer_copyright]',
        'section'           => 'root_structure_footer',
        'label'             => __( 'Copyright', THEME_TEXTDOMAIN ),
        'description'       => __( 'Use %year% to add the current year', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[footer_text]', array(
        'default'           => $defaults['footer_text'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control('root_options[footer_text]', array(
        'settings'          => 'root_options[footer_text]',
        'label'             => __( 'Text under copyright', THEME_TEXTDOMAIN ),
        'section'           => 'root_structure_footer',
        'type'              => 'textarea',
    ) );

    $wp_customize->add_setting( 'root_options[footer_counters]', array(
        'default'           => $defaults['footer_counters'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control('root_options[footer_counters]', array(
        'settings'          => 'root_options[footer_counters]',
        'label'             => __( 'Counters', THEME_TEXTDOMAIN ),
        'section'           => 'root_structure_footer',
        'type'              => 'textarea',
    ) );

    $wp_customize->add_setting( 'root_options[footer_social]', array(
        'default'           => $defaults['footer_social'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[footer_social]', array(
        'settings'          => 'root_options[footer_social]',
        'section'           => 'root_structure_footer',
        'label'             => __( 'Show social links?', THEME_TEXTDOMAIN ),
        'description'       => __( 'Links to social networks can be set in Modules > Social Profiles', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, show', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not show', THEME_TEXTDOMAIN ),
        ),
    ) );


    // blocks  >  home
    $wp_customize->add_section( 'root_structure_home', array(
        'title'             => __( 'Home', THEME_TEXTDOMAIN ),
        'description'       => __( 'In this section you can customize the main page, display posts, additional text', THEME_TEXTDOMAIN ),
        'panel'             => 'panel_structure',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_setting( 'root_options[structure_home_posts]', array(
        'default'           => $defaults['structure_home_posts'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_home_posts]', array(
        'settings'          => 'root_options[structure_home_posts]',
        'label'             => __( 'Post cards on home', THEME_TEXTDOMAIN ),
        'section'           => 'root_structure_home',
        'type'              => 'radio',
        'choices'           => $post_cards,
    ) );

    $wp_customize->add_setting( 'root_options[structure_home_sidebar]', array(
        'default'           => $defaults['structure_home_sidebar'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_home_sidebar]', array(
        'settings'          => 'root_options[structure_home_sidebar]',
        'label'             => __( 'Sidebar', THEME_TEXTDOMAIN ),
        'section'           => 'root_structure_home',
        'type'              => 'radio',
        'choices'           => $sidebar_position,
    ) );

    $wp_customize->add_setting( 'root_options[structure_home_h1]', array(
        'default'           => $defaults['structure_home_h1'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_home_h1]', array(
        'settings'          => 'root_options[structure_home_h1]',
        'section'           => 'root_structure_home',
        'label'             => __( 'Header H1', THEME_TEXTDOMAIN ),
        'description'       => __( 'If the field is not specified, the logo (site name) becomes the h1 header', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_home_text]', array(
        'default'           => $defaults['structure_home_text'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_home_text]', array(
        'settings'          => 'root_options[structure_home_text]',
        'section'           => 'root_structure_home',
        'label'             => __( 'Text', THEME_TEXTDOMAIN ),
        'type'              => 'textarea',
        'description'       => __( 'The text under the heading H1 is displayed only on the main', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_home_position]', array(
        'default'           => $defaults['structure_home_position'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_home_position]', array(
        'settings'          => 'root_options[structure_home_position]',
        'section'           => 'root_structure_home',
        'label'             => __( 'H1 and text position', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'top'           => __( 'Top (under the menu)', THEME_TEXTDOMAIN ),
            'bottom'        => __( 'Bottom (after posts and pagination)', THEME_TEXTDOMAIN ),
        ),
    ) );


    // block  >  single
    $wp_customize->add_section( 'root_structure_single', array(
        'title'             => __( 'Single', THEME_TEXTDOMAIN ),
        'description'       => __( 'In this section, you can customize the appearance of the records, the output of posts, additional text', THEME_TEXTDOMAIN ),
        'panel'             => 'panel_structure',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_setting( 'root_options[structure_single_sidebar]', array(
        'default'           => $defaults['structure_single_sidebar'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_single_sidebar]', array(
        'settings'          => 'root_options[structure_single_sidebar]',
        'section'           => 'root_structure_single',
        'label'             => __( 'Sidebar', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => $sidebar_position,
    ) );

    $wp_customize->add_setting( 'root_options[structure_single_thumb]', array(
        'default'           => $defaults['structure_single_thumb'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_single_thumb]', array(
        'settings'          => 'root_options[structure_single_thumb]',
        'section'           => 'root_structure_single',
        'label'             => __( 'Show thumbnail?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'description'       => __( 'Post thumbnail', THEME_TEXTDOMAIN ),
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_single_date]', array(
        'default'           => $defaults['structure_single_date'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_single_date]', array(
        'settings'          => 'root_options[structure_single_date]',
        'section'           => 'root_structure_single',
        'label'             => __( 'Show date?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_single_category]', array(
        'default'           => $defaults['structure_single_category'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_single_category]', array(
        'settings'          => 'root_options[structure_single_category]',
        'section'           => 'root_structure_single',
        'label'             => __( 'Show category?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_single_author]', array(
        'default'           => $defaults['structure_single_author'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_single_author]', array(
        'settings'          => 'root_options[structure_single_author]',
        'section'           => 'root_structure_single',
        'label'             => __( 'Show author?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_single_social]', array(
        'default'           => $defaults['structure_single_social'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_single_social]', array(
        'settings'          => 'root_options[structure_single_social]',
        'section'           => 'root_structure_single',
        'label'             => __( 'Show social buttons at the top?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_single_excerpt]', array(
        'default'           => $defaults['structure_single_excerpt'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_single_excerpt]', array(
        'settings'          => 'root_options[structure_single_excerpt]',
        'section'           => 'root_structure_single',
        'label'             => __( 'Show excerpt?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_single_comments_count]', array(
        'default'           => $defaults['structure_single_comments_count'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_single_comments_count]', array(
        'settings'          => 'root_options[structure_single_comments_count]',
        'section'           => 'root_structure_single',
        'label'             => __( 'Show count comments?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_single_views]', array(
        'default'           => $defaults['structure_single_views'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_single_views]', array(
        'settings'          => 'root_options[structure_single_views]',
        'section'           => 'root_structure_single',
        'label'             => __( 'Show count views?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_single_tags]', array(
        'default'           => $defaults['structure_single_tags'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_single_tags]', array(
        'settings'          => 'root_options[structure_single_tags]',
        'section'           => 'root_structure_single',
        'label'             => __( 'Show tags if they are set?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_single_rating]', array(
        'default'           => $defaults['structure_single_rating'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_single_rating]', array(
        'settings'          => 'root_options[structure_single_rating]',
        'section'           => 'root_structure_single',
        'label'             => __( 'Show rating?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_single_author_box]', array(
        'default'           => $defaults['structure_single_author_box'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_single_author_box]', array(
        'settings'          => 'root_options[structure_single_author_box]',
        'section'           => 'root_structure_single',
        'label'             => __( 'Show the author\'s block?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_single_social_bottom]', array(
        'default'           => $defaults['structure_single_social_bottom'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_single_social_bottom]', array(
        'settings'          => 'root_options[structure_single_social_bottom]',
        'section'           => 'root_structure_single',
        'label'             => __( 'Show social buttons under the post?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_single_related]', array(
        'default'           => $defaults['structure_single_related'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_single_related]', array(
        'settings'          => 'root_options[structure_single_related]',
        'section'           => 'root_structure_single',
        'label'             => __( 'Count of related articles', THEME_TEXTDOMAIN ),
        'type'              => 'number',
        'description'       => __( '0 - for disable, maximum 50', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_single_comments]', array(
        'default'           => $defaults['structure_single_comments'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_single_comments]', array(
        'settings'          => 'root_options[structure_single_comments]',
        'section'           => 'root_structure_single',
        'label'             => __( 'Comments', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Show', THEME_TEXTDOMAIN ),
            'no'            => __( 'Do not show', THEME_TEXTDOMAIN ),
        ),
    ) );


    // blocks  >  page
    $wp_customize->add_section( 'root_structure_page', array(
        'title'             => __( 'Page', THEME_TEXTDOMAIN ),
        'description'       => __( 'In this section, you can customize the appearance of pages, output sidebars, a block of similar articles', THEME_TEXTDOMAIN ),
        'panel'             => 'panel_structure',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_setting( 'root_options[structure_page_sidebar]', array(
        'default'           => $defaults['structure_page_sidebar'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_page_sidebar]', array(
        'settings'          => 'root_options[structure_page_sidebar]',
        'section'           => 'root_structure_page',
        'label'             => __( 'Sidebar', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => $sidebar_position,
    ) );

    $wp_customize->add_setting( 'root_options[structure_page_thumb]', array(
        'default'           => $defaults['structure_page_thumb'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_page_thumb]', array(
        'settings'          => 'root_options[structure_page_thumb]',
        'section'           => 'root_structure_page',
        'label'             => __( 'Show thumbnail?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'description'       => __( 'Page thumbnail', THEME_TEXTDOMAIN ),
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_page_social]', array(
        'default'           => $defaults['structure_page_social'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_page_social]', array(
        'settings'          => 'root_options[structure_page_social]',
        'section'           => 'root_structure_page',
        'label'             => __( 'Show social buttons at the top?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_page_rating]', array(
        'default'           => $defaults['structure_page_rating'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_page_rating]', array(
        'settings'          => 'root_options[structure_page_rating]',
        'section'           => 'root_structure_page',
        'label'             => __( 'Show rating?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_page_social_bottom]', array(
        'default'           => $defaults['structure_page_social_bottom'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_page_social_bottom]', array(
        'settings'          => 'root_options[structure_page_social_bottom]',
        'section'           => 'root_structure_page',
        'label'             => __( 'Show social buttons under the post?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_page_related]', array(
        'default'           => $defaults['structure_page_related'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_page_related]', array(
        'settings'          => 'root_options[structure_page_related]',
        'label'             => __( 'Count of related articles', THEME_TEXTDOMAIN ),
        'section'           => 'root_structure_page',
        'type'              => 'number',
        'description'       => __( '0 - for disable, maximum 50', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_page_comments]', array(
        'default'           => $defaults['structure_page_comments'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_page_comments]', array(
        'settings'          => 'root_options[structure_page_comments]',
        'section'           => 'root_structure_page',
        'label'             => __( 'Comments', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Show', THEME_TEXTDOMAIN ),
            'no'            => __( 'Do not show', THEME_TEXTDOMAIN ),
        ),
    ) );


    // blocks  >  archive
    $wp_customize->add_section( 'root_structure_archive', array(
        'title'             => __( 'Archive', THEME_TEXTDOMAIN ),
        'description'       => __( 'In this section, you can set up posts archives', THEME_TEXTDOMAIN ),
        'panel'             => 'panel_structure',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_setting( 'root_options[structure_archive_posts]', array(
        'default'           => $defaults['structure_archive_posts'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_archive_posts]', array(
        'settings'          => 'root_options[structure_archive_posts]',
        'section'           => 'root_structure_archive',
        'label'             => __( 'Post cards in archive', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => $post_cards,
    ) );

    $wp_customize->add_setting( 'root_options[structure_archive_sidebar]', array(
        'default'           => $defaults['structure_archive_sidebar'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_archive_sidebar]', array(
        'settings'          => 'root_options[structure_archive_sidebar]',
        'section'           => 'root_structure_archive',
        'label'             => __( 'Sidebar', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => $sidebar_position,
    ) );

    $wp_customize->add_setting( 'root_options[structure_archive_breadcrumbs]', array(
        'default'           => $defaults['structure_archive_breadcrumbs'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_archive_breadcrumbs]', array(
        'settings'          => 'root_options[structure_archive_breadcrumbs]',
        'section'           => 'root_structure_archive',
        'label'             => __( 'Show breadcrumbs?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_child_categories]', array(
        'default'           => $defaults['structure_child_categories'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_child_categories]', array(
        'settings'          => 'root_options[structure_child_categories]',
        'section'           => 'root_structure_archive',
        'label'             => __( 'Show subcategories?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_archive_description]', array(
        'default'           => $defaults['structure_archive_description'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_archive_description]', array(
        'settings'          => 'root_options[structure_archive_description]',
        'section'           => 'root_structure_archive',
        'label'             => __( 'Position of archive description', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'top'           => __( 'Top (under the heading)', THEME_TEXTDOMAIN ),
            'bottom'        => __( 'Bottom (under pagination)', THEME_TEXTDOMAIN ),
        ),
    ) );


    // blocks  >  comments
    $wp_customize->add_section( 'root_structure_comments', array(
        'title'             => __( 'Comments', THEME_TEXTDOMAIN ),
        'panel'             => 'panel_structure',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_setting( 'root_options[comments_form_title]', array(
        'default'           => $defaults['comments_form_title'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control('root_options[comments_form_title]', array(
        'settings'          => 'root_options[comments_form_title]',
        'section'           => 'root_structure_comments',
        'label'             => __( 'Comments form title', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[comments_text_before_submit]', array(
        'default'           => $defaults['comments_text_before_submit'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control('root_options[comments_text_before_submit]', array(
        'settings'          => 'root_options[comments_text_before_submit]',
        'section'           => 'root_structure_comments',
        'label'             => __( 'Text before Send button', THEME_TEXTDOMAIN ),
        'description'       => 'Вы можете добавить любой HTML код, пример с ссылками (# нужно заменить на адрес ссылки):<br><br>Нажимая на кнопку "Отправить комментарий", я даю согласие на &lt;a href="#"&gt;обработку персональных данных&lt;/a&gt; и принимаю &lt;a href="#" target="_blank"&gt;политику конфиденциальности&lt;/a&gt;.',
        'type'              => 'textarea',
    ) );

    $wp_customize->add_setting( 'root_options[comments_date]', array(
        'default'           => $defaults['comments_date'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[comments_date]', array(
        'settings'          => 'root_options[comments_date]',
        'section'           => 'root_structure_comments',
        'label'             => __( 'Show date in comments?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[comments_time]', array(
        'default'           => $defaults['comments_time'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[comments_time]', array(
        'settings'          => 'root_options[comments_time]',
        'section'           => 'root_structure_comments',
        'label'             => __( 'Show time in comments?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[comments_smiles]', array(
        'default'           => $defaults['comments_smiles'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[comments_smiles]', array(
        'settings'          => 'root_options[comments_smiles]',
        'section'           => 'root_structure_comments',
        'label'             => __( 'Show smiles?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );


    // blocks  >  post cards
    $wp_customize->add_section( 'root_structure_posts', array(
        'title'             => __( 'Post cards', THEME_TEXTDOMAIN ),
        'description'       => __( 'In this section, you can customize the appearance of postcards that are displayed on the main, in headings, search, etc.', THEME_TEXTDOMAIN ),
        'panel'             => 'panel_structure',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_setting( 'root_options[structure_posts_tag]', array(
        'default'           => $defaults['structure_posts_tag'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_posts_tag]', array(
        'settings'          => 'root_options[structure_posts_tag]',
        'section'           => 'root_structure_posts',
        'label'             => __( 'Title tag', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'h2'            => 'h2',
            'div'           => 'div',
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_posts_author]', array(
        'default'           => $defaults['structure_posts_author'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_posts_author]', array(
        'settings'          => 'root_options[structure_posts_author]',
        'section'           => 'root_structure_posts',
        'label'             => __( 'Show the author?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'description'       => __( 'Only for the "One post is big" card', THEME_TEXTDOMAIN ),
        'choices'           => array(
            'yes'           => __( 'Yes, output if possible', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_posts_date]', array(
        'default'           => $defaults['structure_posts_date'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_posts_date]', array(
        'settings'          => 'root_options[structure_posts_date]',
        'section'           => 'root_structure_posts',
        'label'             => __( 'Show the date?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'description'       => __( 'Only for the "One post is big" card', THEME_TEXTDOMAIN ),
        'choices'           => array(
            'yes'           => __( 'Yes, output if possible', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_posts_category]', array(
        'default'           => $defaults['structure_posts_category'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_posts_category]', array(
        'settings'          => 'root_options[structure_posts_category]',
        'section'           => 'root_structure_posts',
        'label'             => __( 'Show category?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_posts_excerpt]', array(
        'default'           => $defaults['structure_posts_excerpt'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_posts_excerpt]', array(
        'settings'          => 'root_options[structure_posts_excerpt]',
        'section'           => 'root_structure_posts',
        'label'             => __( 'Show excerpt?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_posts_comments]', array(
        'default'           => $defaults['structure_posts_comments'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_posts_comments]', array(
        'settings'          => 'root_options[structure_posts_comments]',
        'section'           => 'root_structure_posts',
        'label'             => __( 'Show count comments?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_posts_views]', array(
        'default'           => $defaults['structure_posts_views'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_posts_views]', array(
        'settings'          => 'root_options[structure_posts_views]',
        'section'           => 'root_structure_posts',
        'label'             => __( 'Show count views?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );


    // blocks  >  sidebar
    $wp_customize->add_section( 'root_structure_sidebar', array(
        'title'             => __( 'Sidebar', THEME_TEXTDOMAIN ),
        'description'       => __( 'In this section, you can customize the appearance of the sidebar', THEME_TEXTDOMAIN ),
        'panel'             => 'panel_structure',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_setting( 'root_options[structure_sidebar_mob]', array(
        'default'           => $defaults['structure_sidebar_mob'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_sidebar_mob]', array(
        'settings'          => 'root_options[structure_sidebar_mob]',
        'section'           => 'root_structure_sidebar',
        'label'             => __( 'Show sidebar on mobile?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );


    // modules
    $wp_customize->add_panel( 'panel_modules', array(
        'priority'          => 12,
        'capability'        => 'edit_theme_options',
        'title'             => __( 'Modules', THEME_TEXTDOMAIN ),
        'type'              => 'default',
    ) );


    // modules  >  slider
    $wp_customize->add_section( 'root_modules_slider', array(
        'title'             => __( 'Slider', THEME_TEXTDOMAIN ),
        'description'       => __( 'In this section you can customize the slider for the main page', THEME_TEXTDOMAIN ),
        'panel'             => 'panel_modules',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_setting( 'root_options[structure_slider_width]', array(
        'default'           => $defaults['structure_slider_width'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_slider_width]',
        array(
            'settings'      => 'root_options[structure_slider_width]',
            'type'          => 'select',
            'section'       => 'root_modules_slider',
            'label'         => __( 'Slider width', THEME_TEXTDOMAIN ),
            'choices'       => array(
                'content'    => __( 'In content', THEME_TEXTDOMAIN ),
                'full'       => __( 'Full width', THEME_TEXTDOMAIN ),
                'fullscreen' => __( 'In full screen', THEME_TEXTDOMAIN )
            ),
        )
    );

    $wp_customize->add_setting( 'root_options[structure_slider_autoplay]', array(
        'default'           => $defaults['structure_slider_autoplay'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_slider_autoplay]', array(
        'settings'          => 'root_options[structure_slider_autoplay]',
        'section'           => 'root_modules_slider',
        'label'             => __( 'Autoplay', THEME_TEXTDOMAIN ),
        'type'              => 'number',
        'description'       => __( 'Autoplay slides in ms, 0 - for disable', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_slider_count]', array(
        'default'           => $defaults['structure_slider_count'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_slider_count]', array(
        'settings'          => 'root_options[structure_slider_count]',
        'section'           => 'root_modules_slider',
        'label'             => __( 'Count of slider posts', THEME_TEXTDOMAIN ),
        'type'              => 'number',
        'description'       => __( 'The latest posts with thumbnails will be displayed. 0 - for disable, maximum 15', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_slider_order_post]', array(
        'default'           => $defaults['structure_slider_order_post'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_slider_order_post]', array(
        'settings'          => 'root_options[structure_slider_order_post]',
        'type'              => 'select',
        'section'           => 'root_modules_slider',
        'label'             => __( 'Order posts', THEME_TEXTDOMAIN ),
        'choices'           => array(
            'rand'     => __( 'Rand', THEME_TEXTDOMAIN ),
            'views'    => __( 'By views', THEME_TEXTDOMAIN ),
            'comments' => __( 'By comments', THEME_TEXTDOMAIN ),
            'new'      => __( 'New top', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_slider_post_in]', array(
        'default'           => $defaults['structure_slider_post_in'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_slider_post_in]', array(
        'settings'          => 'root_options[structure_slider_post_in]',
        'section'           => 'root_modules_slider',
        'label'             => __( 'ID posts for the slider', THEME_TEXTDOMAIN ),
        'description'       => __( 'You can specify the ID of posts separated by commas to display certain posts in the slider. Missing will be filled with the latest posts.', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_slider_category_in]', array(
        'default'           => $defaults['structure_slider_category_in'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_slider_category_in]', array(
        'settings'          => 'root_options[structure_slider_category_in]',
        'section'           => 'root_modules_slider',
        'label'             => __( 'ID category posts for the slider', THEME_TEXTDOMAIN ),
        'description'       => __( 'You can specify the ID of category for posts separated by commas to display certain posts in the slider. Missing will be filled with posts in accordance with the sorting.', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_slider_show_on_paged]', array(
        'default'           => $defaults['structure_slider_show_on_paged'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_slider_show_on_paged]', array(
        'settings'          => 'root_options[structure_slider_show_on_paged]',
        'section'           => 'root_modules_slider',
        'label'             => __( 'Show on pagination pages', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );

    $wp_customize->add_setting( 'root_options[structure_slider_show_category]', array(
        'default'           => $defaults['structure_slider_show_category'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_slider_show_category]', array(
        'settings'          => 'root_options[structure_slider_show_category]',
        'section'           => 'root_modules_slider',
        'label'             => __( 'Show category', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );

    $wp_customize->add_setting( 'root_options[structure_slider_show_title]', array(
        'default'           => $defaults['structure_slider_show_title'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_slider_show_title]', array(
        'settings'          => 'root_options[structure_slider_show_title]',
        'section'           => 'root_modules_slider',
        'label'             => __( 'Show title', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );

    $wp_customize->add_setting( 'root_options[structure_slider_show_excerpt]', array(
        'default'           => $defaults['structure_slider_show_excerpt'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_slider_show_excerpt]', array(
        'settings'          => 'root_options[structure_slider_show_excerpt]',
        'section'           => 'root_modules_slider',
        'label'             => __( 'Show excerpt', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );


    // modules  >  toc
    $wp_customize->add_section( 'root_modules_toc', array(
        'title'             => __( 'Contents', THEME_TEXTDOMAIN ),
        'description'       => __( 'In this section, you can customize the output content of posts', THEME_TEXTDOMAIN ),
        'panel'             => 'panel_modules',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_setting( 'root_options[toc_enabled]', array(
        'default'           => $defaults['toc_enabled'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[toc_enabled]', array(
        'settings'          => 'root_options[toc_enabled]',
        'section'           => 'root_modules_toc',
        'label'             => __( 'Display the content of posts?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[toc_open]', array(
        'default'           => $defaults['toc_open'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[toc_open]', array(
        'settings'          => 'root_options[toc_open]',
        'section'           => 'root_modules_toc',
        'label'             => __( 'Default open', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );

    $wp_customize->add_setting( 'root_options[toc_noindex]', array(
        'default'           => $defaults['toc_noindex'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[toc_noindex]', array(
        'settings'          => 'root_options[toc_noindex]',
        'section'           => 'root_modules_toc',
        'label'             => __( 'Wrap the content in noindex', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );

    $wp_customize->add_setting( 'root_options[toc_place]', array(
        'default'           => $defaults['toc_place'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[toc_place]', array(
        'settings'          => 'root_options[toc_place]',
        'section'           => 'root_modules_toc',
        'label'             => __( 'Display the content at the beginning of the post', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );

    $wp_customize->add_setting( 'root_options[toc_title]', array(
        'default'           => $defaults['toc_title'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[toc_title]', array(
        'settings'          => 'root_options[toc_title]',
        'section'           => 'root_modules_toc',
        'label'             => __( 'Content title', THEME_TEXTDOMAIN ),
    ) );


    // modules  >  lightbox
    $wp_customize->add_section( 'root_modules_lightbox', array(
        'title'             => __( 'Lightbox', THEME_TEXTDOMAIN ),
        'description'       => __( 'In this section, you can turn on the zoom when clicking on it', THEME_TEXTDOMAIN ),
        'panel'             => 'panel_modules',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_setting( 'root_options[lightbox_enabled]', array(
        'default'           => $defaults['lightbox_enabled'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[lightbox_enabled]', array(
        'settings'          => 'root_options[lightbox_enabled]',
        'section'           => 'root_modules_lightbox',
        'label'             => __( 'Enable lightbox', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );


    // modules  >  breadcrumbs
    $wp_customize->add_section( 'root_modules_breadcrumbs', array(
        'title'             => __( 'Breadcrumbs', THEME_TEXTDOMAIN ),
        'description'       => __( 'In this section you can customize the output of breadcrumbs', THEME_TEXTDOMAIN ),
        'panel'             => 'panel_modules',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_setting( 'root_options[breadcrumbs_display]', array(
        'default'           => $defaults['breadcrumbs_display'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[breadcrumbs_display]', array(
        'settings'          => 'root_options[breadcrumbs_display]',
        'section'           => 'root_modules_breadcrumbs',
        'label'             => __( 'Show breadcrumbs?', THEME_TEXTDOMAIN ),
        'description'       => __( 'By default, bread crumbs embedded in the Root theme are displayed, but if you activate bread crumbs in the Yoast plugin, the Yoast bread crumbs will be displayed', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[breadcrumbs_home_text]', array(
        'default'           => $defaults['breadcrumbs_home_text'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[breadcrumbs_home_text]', array(
        'settings'          => 'root_options[breadcrumbs_home_text]',
        'section'           => 'root_modules_breadcrumbs',
        'label'             => __( 'Text link to home page', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[breadcrumbs_separator]', array(
        'default'           => $defaults['breadcrumbs_separator'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[breadcrumbs_separator]', array(
        'settings'          => 'root_options[breadcrumbs_separator]',
        'section'           => 'root_modules_breadcrumbs',
        'label'             => __( 'Separator', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[breadcrumbs_single_link]', array(
        'default'           => $defaults['breadcrumbs_single_link'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[breadcrumbs_single_link]', array(
        'settings'          => 'root_options[breadcrumbs_single_link]',
        'section'           => 'root_modules_breadcrumbs',
        'label'             => __( 'Display page title', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );


    // modules  >  author block
    $wp_customize->add_section( 'root_modules_author_block', array(
        'title'             => __( 'Author block', THEME_TEXTDOMAIN ),
        'description'       => __( 'In this section you can customize the output of the author block', THEME_TEXTDOMAIN ),
        'panel'             => 'panel_modules',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_setting( 'root_options[author_link]', array(
        'default'           => $defaults['author_link'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[author_link]', array(
        'settings'          => 'root_options[author_link]',
        'section'           => 'root_modules_author_block',
        'label'             => __( 'Display a link to the author’s page', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );

    $wp_customize->add_setting( 'root_options[author_link_target]', array(
        'default'           => $defaults['author_link_target'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[author_link_target]', array(
        'settings'          => 'root_options[author_link_target]',
        'section'           => 'root_modules_author_block',
        'label'             => __( 'Open link in new window', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );

    $wp_customize->add_setting( 'root_options[author_social_enable]', array(
        'default'           => $defaults['author_social_enable'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[author_social_enable]', array(
        'settings'          => 'root_options[author_social_enable]',
        'section'           => 'root_modules_author_block',
        'label'             => __( 'Display author social profiles', THEME_TEXTDOMAIN ),
        'description'       => __( 'Links to social profiles author can be set in Users', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );

    $wp_customize->add_setting( 'root_options[author_social_title]', array(
        'default'           => $defaults['author_social_title'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[author_social_title]', array(
        'settings'          => 'root_options[author_social_title]',
        'section'           => 'root_modules_author_block',
        'label'             => __( 'Social profiles title', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[author_social_title_show]', array(
        'default'           => $defaults['author_social_title_show'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[author_social_title_show]', array(
        'settings'          => 'root_options[author_social_title_show]',
        'section'           => 'root_modules_author_block',
        'label'             => __( 'Show title social profiles', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );

    $wp_customize->add_setting( 'root_options[author_social_js]', array(
        'default'           => $defaults['author_social_js'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[author_social_js]', array(
        'settings'          => 'root_options[author_social_js]',
        'section'           => 'root_modules_author_block',
        'label'             => __( 'Hide links social profiles by JS', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );


    // modules  >  contact_form
    $wp_customize->add_section( 'root_contact_form', array(
        'title'             => __( 'Contact Form', THEME_TEXTDOMAIN ),
        'panel'             => 'panel_modules',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_setting( 'root_options[contact_form_text_before_submit]', array(
        'default'           => $defaults['contact_form_text_before_submit'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control('root_options[contact_form_text_before_submit]', array(
        'settings'          => 'root_options[contact_form_text_before_submit]',
        'label'             => __( 'Text before Send button', THEME_TEXTDOMAIN ),
        'section'           => 'root_contact_form',
        'description'       => 'Вы можете добавить любой HTML код, пример с ссылками (# нужно заменить на адрес ссылки):<br><br>Нажимая на кнопку "Отправить комментарий", я даю согласие на &lt;a href="#"&gt;обработку персональных данных&lt;/a&gt; и принимаю &lt;a href="#" target="_blank"&gt;политику конфиденциальности&lt;/a&gt;.',
        'type'              => 'textarea',
    ) );


    // modules  >  social profiles
    $wp_customize->add_section( 'root_modules_social_profiles', array(
        'title'             => __( 'Social profiles', THEME_TEXTDOMAIN ),
        'description'       => __( 'In this section you can customize the display of links to your social networks', THEME_TEXTDOMAIN ),
        'panel'             => 'panel_modules',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_setting( 'root_options[social_facebook]', array(
        'default'           => $defaults['social_facebook'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[social_facebook]', array(
        'settings'          => 'root_options[social_facebook]',
        'section'           => 'root_modules_social_profiles',
        'label'             => __( 'Facebook', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[social_vk]', array(
        'default'           => $defaults['social_vk'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[social_vk]', array(
        'settings'          => 'root_options[social_vk]',
        'section'           => 'root_modules_social_profiles',
        'label'             => __( 'Vk', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[social_twitter]', array(
        'default'           => $defaults['social_twitter'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[social_twitter]', array(
        'settings'          => 'root_options[social_twitter]',
        'section'           => 'root_modules_social_profiles',
        'label'             => __( 'Twitter', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[social_ok]', array(
        'default'           => $defaults['social_ok'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[social_ok]', array(
        'settings'          => 'root_options[social_ok]',
        'section'           => 'root_modules_social_profiles',
        'label'             => __( 'Одноклассники', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[social_telegram]', array(
        'default'           => $defaults['social_telegram'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[social_telegram]', array(
        'settings'          => 'root_options[social_telegram]',
        'section'           => 'root_modules_social_profiles',
        'label'             => __( 'Telegram', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[social_youtube]', array(
        'default'           => $defaults['social_youtube'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[social_youtube]', array(
        'settings'          => 'root_options[social_youtube]',
        'section'           => 'root_modules_social_profiles',
        'label'             => __( 'YouTube', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[social_instagram]', array(
        'default'           => $defaults['social_instagram'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[social_instagram]', array(
        'settings'          => 'root_options[social_instagram]',
        'section'           => 'root_modules_social_profiles',
        'label'             => __( 'Instagram', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[social_linkedin]', array(
        'default'           => $defaults['social_linkedin'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[social_linkedin]', array(
        'settings'          => 'root_options[social_linkedin]',
        'section'           => 'root_modules_social_profiles',
        'label'             => __( 'Linkedin', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[social_whatsapp]', array(
        'default'           => $defaults['social_whatsapp'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[social_whatsapp]', array(
        'settings'          => 'root_options[social_whatsapp]',
        'section'           => 'root_modules_social_profiles',
        'label'             => __( 'WhatsApp', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[social_viber]', array(
        'default'           => $defaults['social_viber'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[social_viber]', array(
        'settings'          => 'root_options[social_viber]',
        'section'           => 'root_modules_social_profiles',
        'label'             => __( 'Viber', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[social_pinterest]', array(
        'default'           => $defaults['social_pinterest'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[social_pinterest]', array(
        'settings'          => 'root_options[social_pinterest]',
        'section'           => 'root_modules_social_profiles',
        'label'             => __( 'Pinterest', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[social_yandexzen]', array(
        'default'           => $defaults['social_yandexzen'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[social_yandexzen]', array(
        'settings'          => 'root_options[social_yandexzen]',
        'section'           => 'root_modules_social_profiles',
        'label'             => __( 'Yandex Zen', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_social_js]', array(
        'default'           => $defaults['structure_social_js'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_social_js]', array(
        'settings'          => 'root_options[structure_social_js]',
        'section'           => 'root_modules_social_profiles',
        'label'             => __( 'Hide links by JS?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Hide', THEME_TEXTDOMAIN ),
            'no'            => __( 'Do not hide', THEME_TEXTDOMAIN ),
        ),
    ) );


    // modules  >  sitemap
    $wp_customize->add_section( 'root_modules_sitemap', array(
        'title'             => __( 'Sitemap', THEME_TEXTDOMAIN ),
        'panel'             => 'panel_modules',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_setting( 'root_options[sitemap_category_exclude]', array(
        'default'           => $defaults['sitemap_category_exclude'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[sitemap_category_exclude]', array(
        'settings'          => 'root_options[sitemap_category_exclude]',
        'section'           => 'root_modules_sitemap',
        'label'             => __( 'ID of categories to exclude', THEME_TEXTDOMAIN ),
        'description'       => __( 'Enter the ID of the categories separated by commas to exclude them from the sitemap', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[sitemap_posts_exclude]', array(
        'default'           => $defaults['sitemap_posts_exclude'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[sitemap_posts_exclude]', array(
        'settings'          => 'root_options[sitemap_posts_exclude]',
        'section'           => 'root_modules_sitemap',
        'label' => __( 'ID of posts to exclude', THEME_TEXTDOMAIN ),
        'description' => __( 'Enter the ID of the posts separated by commas to exclude them from the sitemap', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[sitemap_pages_show]', array(
        'default'           => $defaults['sitemap_pages_show'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[sitemap_pages_show]', array(
        'settings'          => 'root_options[sitemap_pages_show]',
        'section'           => 'root_modules_sitemap',
        'label'             => __( 'Show pages in sitemap', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );

    $wp_customize->add_setting( 'root_options[sitemap_pages_exclude]', array(
        'default'           => $defaults['sitemap_pages_exclude'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[sitemap_pages_exclude]', array(
        'settings'          => 'root_options[sitemap_pages_exclude]',
        'section'           => 'root_modules_sitemap',
        'label'             => __( 'ID of pages to exclude', THEME_TEXTDOMAIN ),
        'description'       => __( 'Enter the ID of the pages separated by commas to exclude them from the sitemap', THEME_TEXTDOMAIN ),
    ) );


    // modules  >  scroll to top
    $wp_customize->add_section( 'root_modules_arrow', array(
        'title'             => __( 'Scroll to top button', THEME_TEXTDOMAIN ),
        'description'       => __( 'In this section, you can configure the up arrow', THEME_TEXTDOMAIN ),
        'panel'             => 'panel_modules',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_setting( 'root_options[structure_arrow]', array(
        'default'           => $defaults['structure_arrow'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_arrow]', array(
        'settings'          => 'root_options[structure_arrow]',
        'section'           => 'root_modules_arrow',
        'label'             => __( 'Show scroll to top button?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_arrow_bg]', array(
        'default'           => $defaults['structure_arrow_bg'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
        'root_options[structure_arrow_bg]',
        array(
            'settings'      => 'root_options[structure_arrow_bg]',
            'section'       => 'root_modules_arrow',
            'label'         => __( 'Background color', THEME_TEXTDOMAIN ),
        )
    ) );

    $wp_customize->add_setting( 'root_options[structure_arrow_color]', array(
        'default'           => $defaults['structure_arrow_color'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
        'root_options[structure_arrow_color]',
        array(
            'section'       => 'root_modules_arrow',
            'settings'      => 'root_options[structure_arrow_color]',
            'label'         => __( 'Arrow color', THEME_TEXTDOMAIN ),
        )
    ) );

    $wp_customize->add_setting( 'root_options[structure_arrow_width]', array(
        'default'           => $defaults['structure_arrow_width'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( new WP_Customize_Range_Control( $wp_customize,
        'root_options[structure_arrow_width]',
        array(
            'settings'      => 'root_options[structure_arrow_width]',
            'section'       => 'root_modules_arrow',
            'label'         => __( 'Button width, px', THEME_TEXTDOMAIN ),
            'description'   => __( 'Default is 50px', THEME_TEXTDOMAIN ),
            'input_attrs'   => array(
                'min'       => 30,
                'max'       => 80,
                'step'      => 1,
            ),
        ) )
    );

    $wp_customize->add_setting( 'root_options[structure_arrow_height]', array(
        'default'           => $defaults['structure_arrow_height'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( new WP_Customize_Range_Control( $wp_customize,
        'root_options[structure_arrow_height]',
        array(
            'settings'      => 'root_options[structure_arrow_height]',
            'section'       => 'root_modules_arrow',
            'label'         => __( 'Button height, px', THEME_TEXTDOMAIN ),
            'description'   => __( 'Default is 50px', THEME_TEXTDOMAIN ),
            'input_attrs'   => array(
                'min'       => 30,
                'max'       => 80,
                'step'      => 1,
            ),
        ) )
    );

    $wp_customize->add_setting( 'root_options[structure_arrow_icon]', array(
        'default'           => $defaults['structure_arrow_icon'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_arrow_icon]', array(
        'settings'          => 'root_options[structure_arrow_icon]',
        'section'           => 'root_modules_arrow',
        'type'              => 'select',
        'label'             => __( 'Button icon', THEME_TEXTDOMAIN ),
        'choices'           => array(
            '\f102'         => __( 'Double quote up', THEME_TEXTDOMAIN ),
            '\f106'         => __( 'Quote up', THEME_TEXTDOMAIN ),
            '\f139'         => __( 'Arrow in a circle', THEME_TEXTDOMAIN ),
            '\f148'         => __( 'Up arrow', THEME_TEXTDOMAIN ),
            '\f151'         => __( 'Arrow in a square', THEME_TEXTDOMAIN ),
            '\f176'         => __( 'Up arrow 2', THEME_TEXTDOMAIN ),
            '\f01b'         => __( 'Arrow in a circle 2', THEME_TEXTDOMAIN ),
            '\f077'         => __( 'Up arrow 3', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[structure_arrow_mob]', array(
        'default'           => $defaults['structure_arrow_mob'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[structure_arrow_mob]', array(
        'settings'          => 'root_options[structure_arrow_mob]',
        'section'           => 'root_modules_arrow',
        'label'             => __( 'Show scroll to top button on mobile?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, output', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, do not output', THEME_TEXTDOMAIN ),
        ),
    ) );


    // codes
    $wp_customize->add_section( 'root_code', array(
        'title'             => __( 'Codes', THEME_TEXTDOMAIN ),
        'capability'        => 'edit_theme_options',
        'priority'          => 14,
    ) );

    $wp_customize->add_setting( 'root_options[code_head]', array(
        'default'           => $defaults['code_head'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[code_head]', array(
        'settings'          => 'root_options[code_head]',
        'section'           => 'root_code',
        'label'             => __( 'In &lt;head&gt; section', THEME_TEXTDOMAIN ),
        'description'       => __( 'Before &lt;/head&gt; tag', THEME_TEXTDOMAIN ),
        'type'              => 'textarea',
    ) );

    $wp_customize->add_setting( 'root_options[code_body]', array(
        'default'           => $defaults['code_body'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[code_body]', array(
        'settings'          => 'root_options[code_body]',
        'section'           => 'root_code',
        'label'             => __( 'Before &lt;/body&gt;', THEME_TEXTDOMAIN ),
        'type'              => 'textarea',
    ) );

    $wp_customize->add_setting( 'root_options[code_after_content]', array(
        'default'           => $defaults['code_after_content'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[code_after_content]', array(
        'settings'          => 'root_options[code_after_content]',
        'section'           => 'root_code',
        'label'             => __( 'After content', THEME_TEXTDOMAIN ),
        'type'              => 'textarea',
    ) );


    // typography
    $wp_customize->add_section( 'root_typography', array(
        'title'             => __( 'Typography', THEME_TEXTDOMAIN ),
        'description'       => __( 'In this section you can customize the fonts on the site', THEME_TEXTDOMAIN ),
        'capability'        => 'edit_theme_options',
        'priority'          => 14,
    ) );

    global $class_fonts;
    $fonts_list = $class_fonts->get_fonts_key_value();

    $wp_customize->add_setting( 'root_options[typography_family]', array(
        'default'           => $defaults['typography_family'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[typography_family]', array(
        'settings'          => 'root_options[typography_family]',
        'section'           => 'root_typography',
        'label'             => __( 'Main font', THEME_TEXTDOMAIN ),
        'type'              => 'select',
        'choices'           => $fonts_list,
    ) );

    $wp_customize->add_setting( 'root_options[typography_font_size]', array(
        'default'           => $defaults['typography_font_size'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[typography_font_size]', array(
        'settings'          => 'root_options[typography_font_size]',
        'section'           => 'root_typography',
        'label'             => __( 'Size, px', THEME_TEXTDOMAIN ),
        'type'              => 'number',
        'description'       => sprintf( esc_html__( 'Default %s', THEME_TEXTDOMAIN ), '16' ),
        'input_attrs'       => $font_size,
    ) );

    $wp_customize->add_setting( 'root_options[typography_line_height]', array(
        'default'           => $defaults['typography_line_height'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[typography_line_height]', array(
        'settings'          => 'root_options[typography_line_height]',
        'section'           => 'root_typography',
        'label'             => __( 'Interline', THEME_TEXTDOMAIN ),
        'type'              => 'number',
        'description'       => sprintf( esc_html__( 'Default %s', THEME_TEXTDOMAIN ), '1.5' ),
        'input_attrs'       => $font_line_height,
    ) );

    $wp_customize->add_setting( 'root_options[typography_site_title_family]', array(
        'default'           => $defaults['typography_site_title_family'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[typography_site_title_family]', array(
        'settings'          => 'root_options[typography_site_title_family]',
        'section'           => 'root_typography',
        'label'             => __( 'Name of the site', THEME_TEXTDOMAIN ),
        'type'              => 'select',
        'choices'           => $fonts_list,
    ) );

    $wp_customize->add_setting( 'root_options[typography_site_title_size]', array(
        'default'           => $defaults['typography_site_title_size'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[typography_site_title_size]', array(
        'settings'          => 'root_options[typography_site_title_size]',
        'section'           => 'root_typography',
        'label'             => __( 'Size, px', THEME_TEXTDOMAIN ),
        'type'              => 'number',
        'description'       => sprintf( esc_html__( 'Default %s', THEME_TEXTDOMAIN ), '28' ),
        'input_attrs'       => $font_size,
    ) );

    $wp_customize->add_setting( 'root_options[typography_site_title_line_height]', array(
        'default'           => $defaults['typography_site_title_line_height'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[typography_site_title_line_height]', array(
        'settings'          => 'root_options[typography_site_title_line_height]',
        'section'           => 'root_typography',
        'label'             => __( 'Interline', THEME_TEXTDOMAIN ),
        'type'              => 'number',
        'description'       => sprintf( esc_html__( 'Default %s', THEME_TEXTDOMAIN ), '1.1' ),
        'input_attrs'       => $font_line_height,
    ) );

    $wp_customize->add_setting( 'root_options[typography_site_description_family]', array(
        'default'           => $defaults['typography_site_description_family'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[typography_site_description_family]', array(
        'settings'          => 'root_options[typography_site_description_family]',
        'section'           => 'root_typography',
        'label'             => __( 'Description of the site', THEME_TEXTDOMAIN ),
        'type'              => 'select',
        'choices'           => $fonts_list,
    ) );

    $wp_customize->add_setting( 'root_options[typography_site_description_size]', array(
        'default'           => $defaults['typography_site_description_size'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[typography_site_description_size]', array(
        'settings'          => 'root_options[typography_site_description_size]',
        'section'           => 'root_typography',
        'label'             => __( 'Size, px', THEME_TEXTDOMAIN ),
        'type'              => 'number',
        'description'       => sprintf( esc_html__( 'Default %s', THEME_TEXTDOMAIN ), '16' ),
        'input_attrs'       => $font_size,
    ) );

    $wp_customize->add_setting( 'root_options[typography_headers_family]', array(
        'default'           => $defaults['typography_headers_family'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[typography_headers_family]', array(
        'settings'          => 'root_options[typography_headers_family]',
        'section'           => 'root_typography',
        'label'             => __( 'Header Font', THEME_TEXTDOMAIN ),
        'type'              => 'select',
        'choices'           => $fonts_list,
    ) );

    $wp_customize->add_setting( 'root_options[typography_headers_bold]', array(
        'default'           => $defaults['typography_headers_bold'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[typography_headers_bold]', array(
        'settings'          => 'root_options[typography_headers_bold]',
        'section'           => 'root_typography',
        'label'             => __( 'Weight', THEME_TEXTDOMAIN ),
        'type'              => 'select',
        'choices'           => $font_bold,
    ) );

    $wp_customize->add_setting( 'root_options[typography_headers_style]', array(
        'default'           => $defaults['typography_headers_style'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[typography_headers_style]', array(
        'settings'          => 'root_options[typography_headers_style]',
        'section'           => 'root_typography',
        'label'             => __( 'Style', THEME_TEXTDOMAIN ),
        'type'              => 'select',
        'choices'           => $font_style,
    ) );

    $wp_customize->add_setting( 'root_options[typography_menu_links_family]', array(
        'default'           => $defaults['typography_menu_links_family'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[typography_menu_links_family]', array(
        'settings'          => 'root_options[typography_menu_links_family]',
        'section'           => 'root_typography',
        'label'             => __( 'Menu Link Font', THEME_TEXTDOMAIN ),
        'type'              => 'select',
        'choices'           => $fonts_list,
    ) );

    $wp_customize->add_setting( 'root_options[typography_menu_links_size]', array(
        'default'           => $defaults['typography_menu_links_size'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[typography_menu_links_size]', array(
        'settings'          => 'root_options[typography_menu_links_size]',
        'section'           => 'root_typography',
        'label'             => __( 'Size, px', THEME_TEXTDOMAIN ),
        'type'              => 'number',
        'description'       => sprintf( esc_html__( 'Default %s', THEME_TEXTDOMAIN ), '16' ),
        'input_attrs'       => $font_size,
    ) );

    $wp_customize->add_setting( 'root_options[typography_menu_links_line_height]', array(
        'default'           => $defaults['typography_menu_links_line_height'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[typography_menu_links_line_height]', array(
        'settings'          => 'root_options[typography_menu_links_line_height]',
        'section'           => 'root_typography',
        'label'             => __( 'Interline', THEME_TEXTDOMAIN ),
        'type'              => 'number',
        'description'       => sprintf( esc_html__( 'Default %s', THEME_TEXTDOMAIN ), '1.5' ),
        'input_attrs'       => $font_line_height,
    ) );

    $wp_customize->add_setting( 'root_options[typography_menu_links_bold]', array(
        'default'           => $defaults['typography_menu_links_bold'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[typography_menu_links_bold]', array(
        'settings'          => 'root_options[typography_menu_links_bold]',
        'section'           => 'root_typography',
        'label'             => __( 'Weight', THEME_TEXTDOMAIN ),
        'type'              => 'select',
        'choices'           => $font_bold,
    ) );

    $wp_customize->add_setting( 'root_options[typography_menu_links_style]', array(
        'default'           => $defaults['typography_menu_links_style'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[typography_menu_links_style]', array(
        'settings'          => 'root_options[typography_menu_links_style]',
        'section'           => 'root_typography',
        'label'             => __( 'Style', THEME_TEXTDOMAIN ),
        'type'              => 'select',
        'choices'           => $font_style,
    ) );


    // colors
    $wp_customize->get_setting( 'background_color' )->default = '#f9f8f5';

    $wp_customize->add_setting( 'root_options[color_main]', array(
        'default'           => $defaults['color_main'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
        'root_options[color_main]', array(
            'settings'      => 'root_options[color_main]',
            'section'       => 'colors',
            'label'         => __( 'Base site color', THEME_TEXTDOMAIN ),
            'description'   => __( 'Separators, pagination, lists, buttons, mob. menu, etc. It is desirable to choose a color that stands out on a white background', THEME_TEXTDOMAIN ),
        )
    ) );

    $wp_customize->add_setting( 'root_options[color_text]', array(
        'default'           => $defaults['color_text'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
        'root_options[color_text]', array(
            'settings'      => 'root_options[color_text]',
            'label'         => __( 'Site text color', THEME_TEXTDOMAIN ),
            'section'       => 'colors',
        )
    ) );

    $wp_customize->add_setting( 'root_options[color_link]', array(
        'default'           => $defaults['color_link'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
        'root_options[color_link]', array(
            'settings'      => 'root_options[color_link]',
            'label'         => __( 'Link color', THEME_TEXTDOMAIN ),
            'section'       => 'colors',
        )
    ) );

    $wp_customize->add_setting( 'root_options[color_link_hover]', array(
        'default'           => $defaults['color_link_hover'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
        'root_options[color_link_hover]', array(
            'settings'      => 'root_options[color_link_hover]',
            'label'         => __( 'Link hover color', THEME_TEXTDOMAIN ),
            'section'       => 'colors',
        )
    ) );

    $wp_customize->add_setting( 'root_options[color_header_bg]', array(
        'default'           => $defaults['color_header_bg'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
        'root_options[color_header_bg]', array(
            'settings'      => 'root_options[color_header_bg]',
            'label'         => __( 'Header background color', THEME_TEXTDOMAIN ),
            'section'       => 'colors',
        )
    ) );

    $wp_customize->add_setting( 'root_options[color_logo]', array(
        'default'           => $defaults['color_logo'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
        'root_options[color_logo]', array(
            'settings'      => 'root_options[color_logo]',
            'label'         => __( 'Site title color', THEME_TEXTDOMAIN ),
            'section'       => 'colors',
        )
    ) );

    $wp_customize->add_setting( 'root_options[color_description]', array(
        'default'           => $defaults['color_description'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
        'root_options[color_description]', array(
            'settings'      => 'root_options[color_description]',
            'label'         => __( 'Site description color', THEME_TEXTDOMAIN ),
            'section'       => 'colors',
        )
    ) );

    $wp_customize->add_setting( 'root_options[color_menu_bg]', array(
        'default'           => $defaults['color_menu_bg'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
        'root_options[color_menu_bg]', array(
            'settings'      => 'root_options[color_menu_bg]',
            'label'         => __( 'Menu background color', THEME_TEXTDOMAIN ),
            'section'       => 'colors',
        )
    ) );

    $wp_customize->add_setting( 'root_options[color_menu]', array(
        'default'           => $defaults['color_menu'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
        'root_options[color_menu]', array(
            'settings'      => 'root_options[color_menu]',
            'label'         => __( 'Menu link color', THEME_TEXTDOMAIN ),
            'section'       => 'colors',
        )
    ) );

    $wp_customize->add_setting( 'root_options[color_footer_bg]', array(
        'default'           => $defaults['color_footer_bg'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
        'root_options[color_footer_bg]', array(
            'settings'      => 'root_options[color_footer_bg]',
            'label'         => __( 'Footer background color', THEME_TEXTDOMAIN ),
            'section'       => 'colors',
        )
    ) );


    // background
    $wp_customize->add_setting( 'root_options[bg_pattern]', array(
        'default'           => $defaults['bg_pattern'],
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
    ) );
    $wp_customize->add_control( new Customize_Control_Radio_Image( $wp_customize,
        'root_options[bg_pattern]',
        array(
            'settings'      => 'root_options[bg_pattern]',
            'label'         => __( 'Pattern', THEME_TEXTDOMAIN ),
            'section'       => 'background_image',
            'choices'       => root_get_patterns(),
        )
    ) );

    $wp_customize->add_setting( 'root_options[body_bg_link]', array(
        'default'           => $defaults['body_bg_link'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[body_bg_link]', array(
        'settings'          => 'root_options[body_bg_link]',
        'section'           => 'background_image',
        'label'             => __( 'Site background link', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[body_bg_link_js]', array(
        'default'           => $defaults['body_bg_link_js'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[body_bg_link_js]', array(
        'settings'          => 'root_options[body_bg_link_js]',
        'section'           => 'background_image',
        'label'             => __( 'Hide link background by JS', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );

    $wp_customize->add_setting( 'root_options[header_bg]', array(
        'default'           => $defaults['header_bg'],
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'root_options[header_bg]', array(
        'settings'          => 'root_options[header_bg]',
        'label'             => __( 'Header background', THEME_TEXTDOMAIN ),
        'section'           => 'background_image',
    ) ) );

    $wp_customize->add_setting( 'root_options[header_bg_repeat]', array(
        'default'           => $defaults['header_bg_repeat'],
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[header_bg_repeat]', array(
        'settings'          => 'root_options[header_bg_repeat]',
        'type'              => 'select',
        'section'           => 'background_image',
        'label'             => __( 'Header background repeat', THEME_TEXTDOMAIN ),
        'description'       => __( 'If you need to repeat the background image of the header, you can set it in the box below', THEME_TEXTDOMAIN ),
        'choices'           => array(
            'no-repeat'     => __( 'No repeat', THEME_TEXTDOMAIN ),
            'repeat'        => __( 'Repeat horizontal and vertical', THEME_TEXTDOMAIN ),
            'repeat-x'      => __( 'Repeat horizontal', THEME_TEXTDOMAIN ),
            'repeat-y'      => __( 'Repeat vertical', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[header_bg_position]', array(
        'default'           => $defaults['header_bg_position'],
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[header_bg_position]', array(
        'settings'          => 'root_options[header_bg_position]',
        'type'              => 'select',
        'section'           => 'background_image',
        'label'             => __( 'Header background position', THEME_TEXTDOMAIN ),
        'choices'           => array(
            'left top'      => __( 'Top left', THEME_TEXTDOMAIN ),
            'center top'    => __( 'Top center', THEME_TEXTDOMAIN ),
            'right top'     => __( 'Top right', THEME_TEXTDOMAIN ),
            'left center'   => __( 'Middle left', THEME_TEXTDOMAIN ),
            'center center' => __( 'Middle center', THEME_TEXTDOMAIN ),
            'right center'  => __( 'Middle right', THEME_TEXTDOMAIN ),
            'left bottom'   => __( 'Bottom left', THEME_TEXTDOMAIN ),
            'center bottom' => __( 'Bottom center', THEME_TEXTDOMAIN ),
            'right bottom'  => __( 'Bottom right', THEME_TEXTDOMAIN ),
        ),
    ) );


    // tweak
    $wp_customize->add_section( 'root_tweak', array(
        'title'             => __( 'Tweak options', THEME_TEXTDOMAIN ),
        'capability'        => 'edit_theme_options',
        'priority'          => 200,
    ) );

    $wp_customize->add_setting( 'root_options[content_full_width]', array(
        'default'           => $defaults['content_full_width'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[content_full_width]', array(
        'settings'          => 'root_options[content_full_width]',
        'section'           => 'root_tweak',
        'label'             => __( 'Content on full width', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );

    $wp_customize->add_setting( 'root_options[social_share_title]', array(
        'default'           => $defaults['social_share_title'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[social_share_title]', array(
        'settings'          => 'root_options[social_share_title]',
        'section'           => 'root_tweak',
        'label'             => __( 'Social buttons title', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[social_share_title_show]', array(
        'default'           => $defaults['social_share_title_show'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[social_share_title_show]', array(
        'settings'          => 'root_options[social_share_title_show]',
        'section'           => 'root_tweak',
        'label'             => __( 'Show title social buttons', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );

    $wp_customize->add_setting( 'root_options[rating_title]', array(
        'default'           => $defaults['rating_title'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[rating_title]', array(
        'settings'          => 'root_options[rating_title]',
        'section'           => 'root_tweak',
        'label'             => __( 'Rating title', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[rating_text_show]', array(
        'default'           => $defaults['rating_text_show'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[rating_text_show]', array(
        'settings'          => 'root_options[rating_text_show]',
        'section'           => 'root_tweak',
        'label'             => __( 'Show rating statistics', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );

    $wp_customize->add_setting( 'root_options[related_posts_title]', array(
        'default'           => $defaults['related_posts_title'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[related_posts_title]', array(
        'settings'          => 'root_options[related_posts_title]',
        'section'           => 'root_tweak',
        'label'             => __( 'Related articles title', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[advertising_page_display]', array(
        'default'           => $defaults['advertising_page_display'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[advertising_page_display]', array(
        'settings'          => 'root_options[advertising_page_display]',
        'section'           => 'root_tweak',
        'label'             => __( 'Enable avertising on pages', THEME_TEXTDOMAIN ),
        'type'              => 'checkbox',
    ) );

    $wp_customize->add_setting( 'root_options[microdata_publisher_telephone]', array(
        'default'           => $defaults['microdata_publisher_telephone'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[microdata_publisher_telephone]', array(
        'settings'          => 'root_options[microdata_publisher_telephone]',
        'section'           => 'root_tweak',
        'label'             => __( 'The value of the telephone field for publisher microdata', THEME_TEXTDOMAIN ),
        'description'       => __( 'If the field is not specified, the site name will be displayed as the telephone value', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[microdata_publisher_address]', array(
        'default'           => $defaults['microdata_publisher_address'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[microdata_publisher_address]', array(
        'settings'          => 'root_options[microdata_publisher_address]',
        'section'           => 'root_tweak',
        'label'             => __( 'The value of the address field for publisher microdata', THEME_TEXTDOMAIN ),
        'description'       => __( 'If the field is not specified, the site address will be displayed as the address value', THEME_TEXTDOMAIN ),
    ) );


    // partner program
    $wp_customize->add_section( 'root_partner', array(
        'title'             => __( 'Affiliate program', THEME_TEXTDOMAIN ),
        'description'       => 'Мы добавили возможность зарабатывать Вам на нашей <a href="https://wpshop.ru/partner" target="_blank" rel="noopener">партнерской программе</a>. Вы можете втроить партнерскую ссылку в подвал сайта и зарабатывать 25% с продаж. Ваш партнерский ID уже встроен в тему.<br><br>Ссылка замаскирована через JS, она не индексируется и не передает вес страницы и обернута в noindex.<br><br>О продаже по партнерской ссылке мы сообщим Вам на e-mail, Вы ничего не пропустите.',
        'capability'        => 'edit_theme_options',
        'priority'          => 999,
    ) );

    $wp_customize->add_setting( 'root_options[wpshop_partner_enable]', array(
        'default'           => $defaults['wpshop_partner_enable'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[wpshop_partner_enable]', array(
        'settings'          => 'root_options[wpshop_partner_enable]',
        'section'           => 'root_partner',
        'label'             => __( 'Start earning money?', THEME_TEXTDOMAIN ),
        'type'              => 'radio',
        'choices'           => array(
            'yes'           => __( 'Yes, I want to earn', THEME_TEXTDOMAIN ),
            'no'            => __( 'No, not interested', THEME_TEXTDOMAIN ),
        ),
    ) );

    $wp_customize->add_setting( 'root_options[wpshop_partner_id]', array(
        'default'           => $defaults['wpshop_partner_id'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[wpshop_partner_id]', array(
        'settings'          => 'root_options[wpshop_partner_id]',
        'section'           => 'root_partner',
        'label'             => __( 'Your partner ID', THEME_TEXTDOMAIN ),
        'description'       => 'Ваш ID (' . get_wpshop_partner_id() . ') уже встроен в тему, можно найти в <a href="https://wpshop.ru/dashboard" target="_blank" rel="noopener">Личном кабинете</a>, выглядит так: /?partner=ВАШ_ID',
    ) );

    $wp_customize->add_setting( 'root_options[wpshop_partner_prefix]', array(
        'default'           => $defaults['wpshop_partner_prefix'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[wpshop_partner_prefix]', array(
        'settings'          => 'root_options[wpshop_partner_prefix]',
        'section'           => 'root_partner',
        'label'             => __( 'Text before link', THEME_TEXTDOMAIN ),
    ) );

    $wp_customize->add_setting( 'root_options[wpshop_partner_postfix]', array(
        'default'           => $defaults['wpshop_partner_postfix'],
        'type'              => 'option',
    ) );
    $wp_customize->add_control( 'root_options[wpshop_partner_postfix]', array(
        'settings'          => 'root_options[wpshop_partner_postfix]',
        'section'           => 'root_partner',
        'label'             => __( 'Text after link', THEME_TEXTDOMAIN ),
    ) );

}
add_action( 'customize_register', THEME_SLUG . '_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function root_customize_preview_js() {
    wp_enqueue_script( 'root_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), rand(1,9999), true );
}
add_action( 'customize_preview_init', THEME_SLUG . '_customize_preview_js' );


function root_customizer_body_classes( $classes ) {

    /**
     * Sidebar
     */

    $sidebar_class = '';

    // Sidebar on front page
    if ( root_get_option( 'structure_home_sidebar' ) == 'none' && is_front_page() ) {
        $sidebar_class = 'sidebar-none';
    }
    if ( root_get_option( 'structure_home_sidebar' ) == 'left' && is_front_page() ) {
        $sidebar_class = 'sidebar-left';
    }

    // Sidebar in archive
    if ( root_get_option( 'structure_archive_sidebar' ) == 'none' && is_archive() ) {
        $sidebar_class = 'sidebar-none';
    }
    if ( root_get_option( 'structure_archive_sidebar' ) == 'left' && is_archive() ) {
        $sidebar_class = 'sidebar-left';
    }

    // Sidebar in single
    if ( root_get_option( 'structure_single_sidebar' ) == 'none' && is_single() ) {
        $sidebar_class = 'sidebar-none';
    }
    if ( root_get_option( 'structure_single_sidebar' ) == 'left' && is_single() ) {
        $sidebar_class = 'sidebar-left';
    }

    // Sidebar on page
    if ( root_get_option( 'structure_page_sidebar' ) == 'none' && is_page() ) {
        $sidebar_class = 'sidebar-none';
    }
    if ( root_get_option( 'structure_page_sidebar' ) == 'left' && is_page() ) {
        $sidebar_class = 'sidebar-left';
    }

    // settings for a single article
    if ( is_single() || is_page() ) {
        global $post;
        if ( 'checked' == get_post_meta( $post->ID, 'sidebar_hide', true ) ) {
            $sidebar_class = 'sidebar-none';
        }
    }

    $classes[] = $sidebar_class;


    /**
     * Skin
     */
    $skin = root_get_option( 'skin' );
    if ( ! empty( $skin ) && $skin != 'no' ) {
        $classes[] = $skin;
    }


    return $classes;
}
add_filter( 'body_class', THEME_SLUG . '_customizer_body_classes' );


/**
 * Sanitize int value
 *
 * @param $val
 *
 * @return int
 */
function root_sanitize_integer( $val ) {
    return absint( $val );
}


/**
 * Get all patterns to customizer choicer
 *
 * @return array
 */
function root_get_patterns() {

    global $patterns;
    $pattern_choices = array(
        'no' => array(
            'label' => esc_html__( 'No', THEME_TEXTDOMAIN ),
            'url'   => '%s/images/backgrounds/no.png'
        ),
    );
    foreach ( $patterns as $key => $pattern ) {
        $pattern_choices[ $key ] = array(
            'label'     => $pattern['label'],
            'url'       => '%s/images/backgrounds/' . $pattern['mini'],
        );
    }

    return $pattern_choices;

}


/**
 * Get pattern file name
 *
 * @param string $pattern
 *
 * @return string
 */
function root_get_pattern_url( $pattern = '' ) {

    global $patterns;
    if ( isset( $patterns[$pattern] ) ) {
        return $patterns[$pattern]['pattern'];
    } else {
        return '';
    }

}


/**
 * Customizer CSS
 */
require get_template_directory() . '/inc/customizer/customizer-css.php';

/**
 * Customizer Control - Radio Image
 */
require get_template_directory() . '/inc/customizer/customizer-control-radio-image.php';

/**
 * Customizer Control - Range
 */
require get_template_directory() . '/inc/customizer/customizer-control-range.php';