<?php
/**
 * ****************************************************************************
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   DON'T EDIT THIS FILE
 *
 * *****************************************************************************
 *
 *
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Revelation
 */




/**
 * Output category with Yoast support
 *
 * @package Root
 * @author Aleynikov Sergey
 * @url http://wpshop.ru/
 */
if ( ! function_exists( 'root_category' ) ) {

	/**
	 * @param bool $post
	 * @param string $classes
	 * @param bool $micro
	 * @param bool $link
	 * @return bool|string
	 */
	function root_category( $post = false, $classes = '', $micro = true, $link = true ) {

		if ( ! $post = get_post( $post ) )
			return false;

		$classes_out = '';
		if ( ! empty( $classes ) ) $classes_out = ' class="' . $classes . '"';

		$category = get_the_category( $post->ID );
		$cat_id = $category[0]->cat_ID;

		if ( class_exists( 'WPSEO_Primary_Term' ) ) {
			$primary_cat = new WPSEO_Primary_Term( 'category', $post->ID );
			$primary_cat = $primary_cat->get_primary_term();
			if ( $primary_cat ) {
				$cat_id = $primary_cat;
			}
		}

		if ( $micro ) {
            $micro_out = ' itemprop="articleSection"';
        } else {
            $micro_out = '';
        }

		if ( $link ) {
			return '<a href="' . get_category_link( $cat_id ) . '"' . $micro_out . $classes_out . '>' . get_cat_name( $cat_id ) . '</a>';
		} else {
			return '<span' . $micro_out . $classes_out . '>' . get_cat_name( $cat_id ) . '</span>';
		}

	}

}


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function root_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'root_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'root_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so root_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so root_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in root_categorized_blog.
 */
function root_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'root_categories' );
}
add_action( 'edit_category', 'root_category_transient_flusher' );
add_action( 'save_post',     'root_category_transient_flusher' );