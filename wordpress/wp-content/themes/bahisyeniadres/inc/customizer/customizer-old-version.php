<?php

/********************************************************************
 * Convert to options
 *******************************************************************/
$root_theme = wp_get_theme();
$root_ver = $root_theme->get( 'Version' );

if ( version_compare( $root_ver, '2.1.0' ) <= 0 ) {
    update_to_2_1_0();

}

function update_to_2_1_0() {
    // already updated ?
    $root_options_update = get_option( 'root_options_update' );
    if ( $root_options_update == '2.1.0' ) return;

    $options = get_option( 'root_options', array() );

    $transform = array(
        'root_color_main'           => 'color_main',
        'root_color_link'           => 'color_link',
        'root_color_link_hover'     => 'color_link_hover',
        'root_color_text'           => 'color_text',
        'root_color_logo'           => 'color_logo',
        'root_color_menu_bg'        => 'color_menu_bg',
        'root_color_menu'           => 'color_menu',

        'root_logotype'             => 'logotype_image',
        'root_header_hide_title'    => 'header_hide_title',

        'root_structure_footer_copyright'   => 'footer_copyright',
        'root_structure_footer_counters'    => 'footer_counters',

        'root_structure_home_posts'         => 'structure_home_posts',
        'root_structure_home_sidebar'       => 'structure_home_sidebar',
        'root_structure_home_h1'            => 'structure_home_h1',
        'root_structure_home_text'          => 'structure_home_text',
        'root_structure_home_position'      => 'structure_home_position',

        'root_structure_single_sidebar'         => 'structure_single_sidebar',
        'root_structure_single_thumb'           => 'structure_single_thumb',
        'root_structure_single_author'          => 'structure_single_author',
        'root_structure_single_date'            => 'structure_single_date',
        'root_structure_single_category'        => 'structure_single_category',
        'root_structure_single_social'          => 'structure_single_social',
        'root_structure_single_excerpt'         => 'structure_single_excerpt',
        'root_structure_single_comments_count'  => 'structure_single_comments_count',
        'root_structure_single_views'           => 'structure_single_views',
        'root_structure_single_tags'            => 'structure_single_tags',
        'root_structure_single_social_bottom'   => 'structure_single_social_bottom',
        'root_structure_single_related'         => 'structure_single_related',
        'root_structure_single_comments'        => 'structure_single_comments',
        'root_structure_single_comments_date'   => 'comments_date',
        'root_structure_single_comments_smiles' => 'comments_smiles',

        'root_structure_page_sidebar'           => 'structure_page_sidebar',
        'root_structure_page_related'           => 'structure_page_related',
        'root_structure_page_comments'          => 'structure_page_comments',

        'root_structure_archive_posts'          => 'structure_archive_posts',
        'root_structure_archive_sidebar'        => 'structure_archive_sidebar',
        'root_structure_archive_description'    => 'structure_archive_description',

        'root_structure_posts_tag'          => 'structure_posts_tag',
        'root_structure_posts_author'       => 'structure_posts_author',
        'root_structure_posts_date'         => 'structure_posts_date',
        'root_structure_posts_category'     => 'structure_posts_category',
        'root_structure_posts_excerpt'      => 'structure_posts_excerpt',
        'root_structure_posts_comments'     => 'structure_posts_comments',
        'root_structure_posts_views'        => 'structure_posts_views',

        'root_structure_code_head'          => 'code_head',
        'root_structure_code_body'          => 'code_body',
        'root_structure_code_after_content' => 'code_after_content',

        'root_main_fonts'               => 'typography_family',
        'root_typography_font_size'     => 'typography_font_size',
        'root_typography_line_height'   => 'typography_line_height',
        'root_main_fonts_headers'       => 'typography_headers_family',
    );

    foreach ( $transform as $k => $v ) {
        $mod = get_theme_mod($k, false);
        if ( $mod ) $options[$v] = $mod;
        //remove_theme_mod( $k );
    }

    update_option( 'root_options', $options );
    update_option( 'root_options_update', '2.1.0' );
}