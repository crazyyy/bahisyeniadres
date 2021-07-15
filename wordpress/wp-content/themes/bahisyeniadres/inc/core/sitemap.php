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
 * Class Sitemap
 *
 * 1.0.2    2020-06-04      Add filter 'wpshop_sitemap_posts_exclude' for posts exclude
 *                          Add filter 'wpshop_sitemap_category_exclude' for categories exclude
 *                          Add filter 'wpshop_sitemap_pages_exclude' for pages exclude
 * 1.0.1    2019-10-18      Add attribute post_types to show custom post_types
 * 1.0.0
 */
class Sitemap {

    /**
     * Sitemap constructor
     */
    public function __construct() {
        add_shortcode( 'htmlsitemap', array( $this, 'sitemap_shortcode' ) );
    }

    public function sitemap_shortcode( $atts , $content = null ) {
        $atts = shortcode_atts( array(
            'post_types' => '',
            'taxonomies' => ''
        ), $atts );

        global $post;

        $out = '<div class="sitemap-list">' . PHP_EOL;

        $out .= '<ul>' . PHP_EOL;
        $out .= $this->get_posts_list();
        $out .= '</ul>' . PHP_EOL;

        if ( ! empty( $atts['post_types'] ) ) {
            $out .= '<ul>' . PHP_EOL;
            $out .= $this->get_posts_by_post_type( $atts['post_types'] );
            $out .= '</ul>' . PHP_EOL;
        }

        if ( apply_filters( 'wpshop_sitemap_show_pages', true ) ) :
            $out .= '<h2>' . __( 'Pages', THEME_TEXTDOMAIN ) . '</h2>' . PHP_EOL;
            $out .= $this->get_pages_list();
        endif;

        $out .= '</div>';

        return $out;
    }


    /**
     * @param string|array $post_type
     *
     * @return string
     */
    public function get_posts_by_post_type( $post_type ) {
        $out = '';

        $post_type_obj = get_post_type_object( $post_type );

        $out .= '<li class="sitemap-list__header"><h2>' . $post_type_obj->label . '</h2></li>' . PHP_EOL;
        $out .= '<li class="sitemap-list__block"><ul>' . PHP_EOL;

        $posts = get_posts( array(
            'numberposts'     => 1000,
            'orderby'         => 'post_date',
            'order'           => 'DESC',
            'post_type'       => $post_type,
        ) );
        if ( ! empty( $posts ) ) {
            $posts_exclude = apply_filters( 'wpshop_sitemap_posts_exclude', '' );

            foreach( $posts as $post ) {
                if ( empty( $posts_exclude ) || ( ! empty( $posts_exclude ) && ! in_array( $post->ID, $posts_exclude ) ) ) {
                    $out .= '  <li><a href="' . get_the_permalink( $post->ID ) . '" target="_blank">'. get_the_title( $post->ID ) . '</a></li>' . PHP_EOL;
                }
            }
        }

        $out .= '</ul></li>' . PHP_EOL;
        return $out;
    }


    public function get_posts_list( $category_ID = 0 ) {
        $out = '';

        $next = get_categories( 'orderby=name&order=ASC&parent=' . $category_ID );

        if ( $next ) {
            $category_exclude = apply_filters( 'wpshop_sitemap_category_exclude', '' );

            foreach ( $next as $cat ) {
                if ( empty( $category_exclude ) || ( ! empty( $category_exclude ) && ! in_array( $cat->cat_ID, $category_exclude ) ) ) {
                    $out .= '<li class="sitemap-list__header category-' . $cat->cat_ID . '"><h3><a href="' . get_term_link( $cat->cat_ID ) . '" target="_blank">' . $cat->name . '</a></h3></li>' . PHP_EOL;

                    $out .= '<li class="sitemap-list__block category-' . $cat->cat_ID . '"><ul>' . PHP_EOL;

                    $posts = get_posts( array(
                        'numberposts'     => -1,
                        'category__in'    => array( $cat->cat_ID ),
                        'orderby'         => 'post_date',
                        'order'           => 'DESC',
                        'exclude'         => ''
                    ) );

                    if ( ! empty( $posts ) ) {
                        $posts_exclude = apply_filters( 'wpshop_sitemap_posts_exclude', '' );

                        foreach( $posts as $post ) {
                            if ( empty( $posts_exclude ) || ( ! empty( $posts_exclude ) && ! in_array( $post->ID, $posts_exclude ) ) ) {
                                $out .= '  <li><a href="' . get_the_permalink( $post->ID ) . '" target="_blank">'. get_the_title( $post->ID ) . '</a></li>' . PHP_EOL;
                            }
                        }
                    }

                    $out .= $this->get_posts_list( $cat->cat_ID );

                    $out .= '</ul></li>' . PHP_EOL;
                }
            }
        }

        return $out;

    }


    public function get_pages_list( $page_id = 0 ) {
        global $post;
        $out = '';

        $pages = get_pages( array(
            'exclude'   => array( $post->ID ),
            'parent'    => $page_id,
        ) );

        if ( ! empty( $pages ) ) {
            $pages_exclude = apply_filters( 'wpshop_sitemap_pages_exclude', '' );

            $out .= '<ul>' . PHP_EOL;
            foreach ( $pages as $page ) {
                if ( empty( $pages_exclude ) || ( ! empty( $pages_exclude ) && ! in_array( $page->ID, $pages_exclude ) ) ) {
                    $out .= '<li><a href="' . get_page_link( $page->ID ) . '">' . $page->post_title . '</a>';

                    $subpages = $this->get_pages_list( $page->ID );
                    if ( ! empty( $subpages ) ) $out .= $subpages;

                    $out .= '</li>';
                }
            }
            $out .= '</ul>' . PHP_EOL;
        }

        return $out;
    }

}

new Sitemap;