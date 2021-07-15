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
 * Class WPShop_Breadcrumbs
 */
class WPShop_Breadcrumbs {

    /**
     * What show on front page or posts
     *
     * @var string
     */
    private $show_on_front;

    /**
     * Page id or false
     *
     * @var mixed
     */
    private $page_for_posts;

    /**
     * Current post
     * @var mixed
     */
    private $post;

    /**
     * Before wrap
     * @var string
     */
    public $before = '<div class="breadcrumb">';

    /**
     * After wrap
     * @var string
     */
    public $after = '</div>';

    /**
     * @var string
     */
    private $separator;

    /**
     * Markup
     *
     * @var string
     */
    private $markup = 'schema.org';
    private $itemlist_markup = '';
    private $item_markup = '';
    private $name_markup = '';
    private $position_markup = '';

    /**
     * Link pattern
     * @var string
     */
    private $pattern_link = '<span class="breadcrumb-item"><a href="%s"><span>%s</span></a></span>';

    /**
     * All crumbs
     * @var array
     */
    private $crumbs = array();

    private $crumb_count = 0;

    private $links = array();


    /**
     * WPShop_Breadcrumbs constructor.
     *
     * @param array $args
     */
    public function __construct( $args = array() ) {

        $this->post             = ( isset( $GLOBALS['post'] ) ? $GLOBALS['post'] : null );
        $this->show_on_front    = get_option( 'show_on_front' );
        $this->page_for_posts   = get_option( 'page_for_posts' );
        $this->separator        = ' <span class="breadcrumb-separator">'. apply_filters( 'wpshop_breadcrumbs_separator', '»' ) .'</span> ';

    }

    public function markup() {

        if ( $this->markup == 'schema.org' ) {

            $this->before          = '<div class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';
            $this->itemlist_markup = 'itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"';
            $this->item_markup     = 'itemprop="item"';
            $this->name_markup     = 'itemprop="name"';
            $this->position_markup = '<meta itemprop="position" content="%d">';

        }

    }


    public function prepare_crumbs() {

        global $wp_query;

        
        // Home 
        $this->crumbs[] = array(
            'url'   => home_url( '/' ),
            'text'  => apply_filters( 'wpshop_breadcrumbs_home_text', __( 'Home', THEME_TEXTDOMAIN ) ),
        );
        

        // front page
        if ( ( 'page' === $this->show_on_front && is_front_page() ) || ( 'posts' === $this->show_on_front && is_home() ) ) {

        }

        // home page
        elseif ( $this->show_on_front == 'page' && is_home() ) {
            $this->add_single_crumb( $this->page_for_posts );
        }

        // single
        elseif ( is_singular() ) {

            // TODO: check post types

            if ( isset( $this->post->post_parent ) && 0 === $this->post->post_parent ) {
                $this->check_taxonomy_for_post();
            } else {
                $this->post_ancestor_crumbs();
            }

            if ( isset( $this->post->ID ) && apply_filters( 'wpshop_breadcrumb_single_link', false ) ) {
                $this->add_single_crumb( $this->post->ID );
            }
        }

        else {
            if ( is_post_type_archive() ) {
                $post_type = $wp_query->get( 'post_type' );

                if ( $post_type && is_string( $post_type ) ) {
                    // TODO: add
                }
            } elseif ( is_tax() || is_tag() || is_category() ) {
                $this->taxonomy_crumbs();
            } elseif ( is_date() ) {
                if ( is_day() ) {
                    // TODO: add
                } elseif ( is_month() ) {
                    // TODO: add
                } elseif ( is_year() ) {
                    // TODO: add
                }
            }
        }

        $this->crumb_count = count( $this->crumbs );

    }

    /**
     * Make crumbs
     */
    private function make_crumbs() {

        $this->prepare_crumbs();
        $this->markup();

        if ( ! is_array( $this->crumbs ) || empty( $this->crumbs ) ) {
            return;
        }

        $n = 0;
        $links = array();

        foreach ( $this->crumbs as $k => $crumb ) {
            $crumb_link = $crumb;

            if ( isset( $crumb['post_id'] ) ) {
                $crumb_link = $this->get_link_post_id( $crumb['post_id'] );
            }
            if ( isset( $crumb['term'] ) ) {
                $crumb_link = $this->get_link_term( $crumb['term'] );
            }
            // todo: post type archive

            if ( $n == ( $this->crumb_count - 1 ) && apply_filters( 'wpshop_breadcrumb_single_link', false ) ) {
                $this->pattern_link = '<span class="breadcrumb-item breadcrumb_last" ' . $this->itemlist_markup . '>' .
                    '<span ' . $this->name_markup . '>%s</span>' .
                    $this->position_markup .
                    '</span>';
                $links[] = sprintf( $this->pattern_link, $crumb_link['text'], $n );
            } else {
                $this->pattern_link = '<span class="breadcrumb-item" ' . $this->itemlist_markup . '>' .
                    '<a href="%s" ' . $this->item_markup . '>' .
                    '<span ' . $this->name_markup . '>%s</span>' .
                    '</a>' . $this->position_markup .
                    '</span>';
                $links[] = sprintf( $this->pattern_link, $crumb_link['url'], $crumb_link['text'], $n );
            }

            $n++;

        }

        return implode( $this->separator, $links );
    }


    /**
     * Output breadcrumbs
     *
     * @return string
     */
    public function output() {

        $make_crumbs = $this->make_crumbs();

        $out  = $this->before;
        $out .= $make_crumbs;
        $out .= $this->after;

        return apply_filters( 'wpshop_breadcrumbs_out', $out );

    }


    private function get_link_term( $term ) {
        $link = array();

        $link['url']  = get_term_link( $term );
        $link['text'] = $term->name;

        return $link;
    }



    /**
     * Get post link
     *
     * @param $post_id
     *
     * @return array
     */
    private function get_link_post_id( $post_id ) {
        $link = array();

        $link['url']  = get_permalink( $post_id );
        $link['text'] = strip_tags( get_the_title( $post_id ) );


        $link['text'] = apply_filters( 'wpshop_breadcrumbs_title', $link['text'], $post_id );

        return $link;
    }



    private function check_taxonomy_for_post() {

        // TODO: options for different taxonomies
        $tax = 'category';

        if ( isset( $this->post->ID ) ) {
            $terms = get_the_terms( $this->post, $tax );

            if ( is_array( $terms ) && $terms !== array() ) {

                $breadcrumb_term = '';

                if ( class_exists( 'WPSEO_Primary_Term' ) ) {
                    $primary_term = new WPSEO_Primary_Term( $tax, $this->post->ID );
                    if ( $primary_term->get_primary_term() ) {
                        $breadcrumb_term = get_term( $primary_term->get_primary_term(), $tax );
                    }
                }

                if ( empty( $breadcrumb_term ) ) {
                    // TODO: get by order
                    $breadcrumb_term = $terms[0];
                }

                if ( is_taxonomy_hierarchical( $tax ) && $breadcrumb_term->parent != 0 ) {
                    $parent_terms = $this->get_term_parents( $breadcrumb_term );
                    foreach ( $parent_terms as $parent_term ) {
                        $this->add_term_crumb( $parent_term );
                    }
                }

                $this->add_term_crumb( $breadcrumb_term );

            }
        }

    }


    /**
     * @param $term
     *
     * @return array
     */
    private function get_term_parents( $term ) {

        $tax     = $term->taxonomy;
        $parents = array();
        while ( $term->parent != 0 ) {
            $term      = get_term( $term->parent, $tax );
            $parents[] = $term;
        }

        return array_reverse( $parents );
    }


    /**
     * Hierarchical ancestors
     */
    private function post_ancestor_crumbs() {
        $ancestors = $this->get_post_ancestors();
        if ( is_array( $ancestors ) && $ancestors !== array() ) {
            foreach ( $ancestors as $ancestor ) {
                $this->add_single_crumb( $ancestor );
            }
        }
    }


    /**
     * Retrieve the hierachical ancestors for the current 'post'
     *
     * @return array
     */
    private function get_post_ancestors() {
        $ancestors = array();

        if ( isset( $this->post->ancestors ) ) {
            if ( is_array( $this->post->ancestors ) ) {
                $ancestors = array_values( $this->post->ancestors );
            } else {
                $ancestors = array( $this->post->ancestors );
            }
        } elseif ( isset( $this->post->post_parent ) ) {
            $ancestors = array( $this->post->post_parent );
        }

        // меняем сортировку от старых до новых
        $ancestors = array_reverse( $ancestors );

        return $ancestors;
    }


    /**
     * Add taxonomy
     */
    private function taxonomy_crumbs() {

        $term = $GLOBALS['wp_query']->get_queried_object();

        $this->taxonomy_parent_crumbs( $term );

        if ( apply_filters( 'wpshop_breadcrumb_single_link', false ) ) {
            $this->add_term_crumb( $term );
        }
    }


    /**
     * Taxonomy parent
     *
     * @param $term
     */
    private function taxonomy_parent_crumbs( $term ) {

        if ( is_taxonomy_hierarchical( $term->taxonomy ) && $term->parent != 0 ) {
            foreach ( $this->get_term_parents( $term ) as $parent_term ) {
                $this->add_term_crumb( $parent_term );
            }
        }

    }



    /**
     * Add single
     * @param $post_id
     */
    private function add_single_crumb( $post_id ) {
        $this->crumbs[] = array(
            'post_id' => $post_id,
        );
    }


    /**
     * Add term
     * @param $term
     */
    private function add_term_crumb( $term ) {
        $this->crumbs[] = array(
            'term' => $term,
        );
    }



}


function wpshop_breadcrumbs( $args = array() ){
    $breadcrumbs = new WPShop_Breadcrumbs( $args );
    return $breadcrumbs->output();
}