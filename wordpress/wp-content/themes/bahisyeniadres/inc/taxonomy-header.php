<?php



/**
 * Remove word Category, Tag in archives
 */
add_filter( 'get_the_archive_title', 'get_the_archive_title_change' );
function get_the_archive_title_change( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    }
    return $title;
}




// since 4.4
// h1
if ( function_exists( 'get_term_meta' ) ) :

    /**
     * Get all taxonomies
     * Set action priority to 99 because get_taxonomies don't show all regisstred
     */
    function add_taxonomy_actions() {
        $get_taxonomies = get_taxonomies( array( 'public' => true ) );
        if ( is_array( $get_taxonomies ) ) {
            foreach ( $get_taxonomies as $get_taxonomy ) {
                add_action( $get_taxonomy . '_add_form_fields', 'add_taxonomy_header_field', 10, 2 );
                add_action( 'created_' . $get_taxonomy, 'save_taxonomy_header_field', 10, 2 );

                add_action( $get_taxonomy . '_edit_form_fields', 'edit_taxonomy_header_field', 10, 2 );
                add_action( 'edited_' . $get_taxonomy, 'update_taxonomy_header_field', 10, 2 );
            }
        }
    }
    add_action( 'init', 'add_taxonomy_actions', 99 );




    /**
     * Add and save taxonomy field in creating form
     */
    //add_action( 'category_add_form_fields', 'add_taxonomy_header_field', 10, 2 );
    function add_taxonomy_header_field( $taxonomy ) {
        ?>
        <div class="form-field term-group">
            <label for="taxonomy_header">Заголовок</label>
            <input name="taxonomy_header" id="taxonomy_header" type="text" value="" size="40">
            <p class="description">Заголовок H1 в архивах таксономий</p>
        </div>
        <?php
    }


    //add_action( 'created_category', 'save_taxonomy_header_field', 10, 2 );
    function save_taxonomy_header_field( $term_id, $tt_id ){
        if( isset( $_POST['taxonomy_header'] ) ) {
            $taxonomy_header = trim( $_POST['taxonomy_header'] );
            add_term_meta( $term_id, 'taxonomy_header', $taxonomy_header, true );
        }
    }


    /**
     * Add and save taxonomy field in edit form
     */
    //add_action( 'category_edit_form_fields', 'edit_taxonomy_header_field', 10, 2 );
    function edit_taxonomy_header_field( $term, $taxonomy ){
        // get current
        $feature_group = get_term_meta( $term->term_id, 'taxonomy_header', true );

        ?><tr class="form-field term-group-wrap">
        <th scope="row"><label for="taxonomy_header">Заголовок</label></th>
        <td>
            <input name="taxonomy_header" id="taxonomy_header" type="text" value="<?php echo $feature_group ?>" size="40">
            <p class="description">Заголовок H1 в архивах таксономий</p>
        </td>
        </tr><?php
    }

    //add_action( 'edited_category', 'update_taxonomy_header_field', 10, 2 );
    function update_taxonomy_header_field( $term_id, $tt_id ) {

        if( isset( $_POST['taxonomy_header'] ) ) {
            $taxonomy_header = trim( $_POST['taxonomy_header'] );
            update_term_meta( $term_id, 'taxonomy_header', $taxonomy_header );
        }
    }



    /**
     * Change the_archive_title
     */
    add_filter( 'get_the_archive_title', 'taxonomy_header_archive_title' );
    function taxonomy_header_archive_title( $title ) {
        if ( is_tax() || is_category() || is_tag() ) {
            $taxonomy_header = get_term_meta( get_queried_object()->term_id, 'taxonomy_header', true );
            if ( ! empty( $taxonomy_header ) ) {
                $title = do_shortcode( $taxonomy_header );
            }
        }
        return $title;
    }



endif;