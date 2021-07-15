<?php

/**
 * Class Wpshop_Widget_Articles
 *
 * @version     1.2
 * @updated     2018-03-22
 */
class Wpshop_Widget_Articles extends WP_Widget {

    function __construct() {
        parent::__construct(
            'wpshop_widget_articles',
            __( 'Articles output', THEME_TEXTDOMAIN ),
            array( 'description' => __( 'Articles output', THEME_TEXTDOMAIN ) )
        );
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] ); // к заголовку применяем фильтр (необязательно)

        echo $args['before_widget'];

        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];

        // ID posts
        $post_ids = ( ! empty( $instance['post_ids'] ) ) ? trim( $instance['post_ids'] ) : '';

        // ID categories
        $category_ids = ( ! empty( $instance['category_ids'] ) ) ? trim( $instance['category_ids'] ) : '';

        // Sorting
        $posts_orderby = ( ! empty( $instance['posts_orderby'] ) ) ? trim( $instance['posts_orderby'] ) : '';

        // Number of days
        $posts_period  = ( ! empty( $instance['posts_period'] ) ) ? trim( $instance['posts_period'] ) : '';

        // Number of posts
        $post_limit = ( ! empty( $instance['post_limit'] ) ) ? trim( $instance['post_limit'] ) : '';

        // Appearance
        $articles_view = ! empty( $instance['articles_view'] ) ? $instance['articles_view'] : '';

        // Hide category
        global $hide_category;
        $hide_category = ! empty( $instance['hide_category'] ) ? $instance['hide_category'] : '';

        // Hide meta
        global $hide_meta;
        $hide_meta = ! empty( $instance['hide_meta'] ) ? $instance['hide_meta'] : '';

        // Link in a new window
        global $link_target;
        $link_target   = ! empty( $instance['link_target'] ) ? $instance['link_target'] : '';


        // default values
        $get_posts_args = array(
            'orderby'     => 'rand',
            'numberposts' => $post_limit,
        );

        // order
        if ( $posts_orderby == 'rand' ) {
            $get_posts_args = array(
                'orderby'     => 'rand',
                'numberposts' => $post_limit,
            );
        }
        if ( $posts_orderby == 'views' ) {
            $get_posts_args = array(
                'meta_key'    => 'views',
                'orderby'     => 'meta_value_num',
                'order'       => 'DESC',
                'numberposts' => $post_limit,
            );
        }
        if ( $posts_orderby == 'comments' ) {
            $get_posts_args = array(
                'orderby'     => 'comment_count',
                'order'       => 'DESC',
                'numberposts' => $post_limit,
            );
        }
        if ( $posts_orderby == 'new' ) {
            $get_posts_args = array(
                'orderby'     => 'date',
                'order'       => 'DESC',
                'numberposts' => $post_limit,
            );
        }

        if ( is_single() ) {
            global $post;
            $get_posts_args['post__not_in'] = array( $post->ID );
        }


        /**
         * Если заданы посты для исключения
         */
        if ( ! empty( $post_ids ) ) {

            $post_ids_exp = explode( ',', $instance['post_ids'] );

            if ( is_array( $post_ids_exp ) ) {
                $post_ids = array_map( 'trim', $post_ids_exp );
            } else {
                $post_ids = array( $instance['post_ids'] );
            }

            if ( is_single() ) {
                global $post;

                $post_ids = array_filter( $post_ids, function( $id ) use ( $post ) {
                    return $id != $post->ID;
                } );
            }

            $get_posts_args['post__in'] = $post_ids;

        }


        /**
         * Если заданы категории
         */
        if ( ! empty( $category_ids ) ) {

            $category_ids_exp = explode( ',', wpshop_sanitize_ids_string( $instance['category_ids'] ) );
            $category_ids = array_map( 'trim', $category_ids_exp );

            if ( ! empty( $category_ids ) ) {
                $get_posts_args['cat'] = $category_ids;
            }

        }


        /**
         * Если задано кол-во дней
         */
        if ( ! empty( $posts_period ) ) {
            $get_posts_args['date_query'] = array(
                'after' => $posts_period . ' days ago',
            );
        }


        $posts = get_posts( $get_posts_args );

        global $single_post;

        echo '<div class="widget-articles">';

        foreach ( $posts as $single_post ) {

            if ( $articles_view == 'normal' ) {
                get_template_part( 'template-parts/widgets/widget', 'articles-normal' );
            } else {
                get_template_part( 'template-parts/widgets/widget', 'articles-compact' );
            }

        }

        echo '</div>';


        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title               = ( isset( $instance[ 'title' ] ) )         ? $instance[ 'title' ] : '';
        $post_ids            = ( isset( $instance[ 'post_ids' ] ) )      ? $instance[ 'post_ids' ] : '';
        $category_ids        = ( isset( $instance[ 'category_ids' ] ) )  ? $instance[ 'category_ids' ] : '';
        $posts_orderby       = ( isset( $instance[ 'posts_orderby' ] ) ) ? $instance[ 'posts_orderby' ] : '';
        $posts_articles_view = ( isset( $instance[ 'articles_view' ] ) ) ? $instance[ 'articles_view' ] : '';
        $posts_period        = ( isset( $instance[ 'posts_period' ] ) )  ? $instance[ 'posts_period' ] : '';
        $post_limit          = ( isset( $instance[ 'post_limit' ] ) )    ? $instance[ 'post_limit' ] : '';
        $hide_category       = ! empty( $instance['hide_category'] )     ? $instance['hide_category'] : '';
        $hide_meta           = ! empty( $instance['hide_meta'] )         ? $instance['hide_meta'] : '';
        $link_target         = ! empty( $instance['link_target'] )       ? $instance['link_target'] : '';
        ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php echo __( 'Title', THEME_TEXTDOMAIN ) ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" type="text" value="<?php echo esc_attr( $title ) ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'posts_orderby' ) ?>"><?php echo __( 'Sorting', THEME_TEXTDOMAIN ) ?></label><br>
            <select name="<?php echo $this->get_field_name( 'posts_orderby' ) ?>" id="<?php echo $this->get_field_id( 'posts_orderby' ) ?>">
                <option value="rand" <?php selected( $posts_orderby, 'rand' ) ?>><?php echo __( 'Accidentally', THEME_TEXTDOMAIN ) ?></option>
                <option value="views" <?php selected( $posts_orderby, 'views' ) ?>><?php echo __( 'By views (views)', THEME_TEXTDOMAIN ) ?></option>
                <option value="comments" <?php selected( $posts_orderby, 'comments' ) ?>><?php echo __( 'By comments', THEME_TEXTDOMAIN ) ?></option>
                <option value="new" <?php selected( $posts_orderby, 'new' ) ?>><?php echo __( 'New on top', THEME_TEXTDOMAIN ) ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'post_ids' ) ?>"><?php echo __( 'ID of posts separated by commas, if you need to display specific posts', THEME_TEXTDOMAIN ) ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'post_ids' ) ?>" name="<?php echo $this->get_field_name( 'post_ids' ) ?>" type="text" value="<?php echo esc_attr( $post_ids ) ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'category_ids' ) ?>"><?php echo __( 'The ID of the category separated by commas, if you want to display the posts of certain category (add a minus sign before the category ID to exclude it)', THEME_TEXTDOMAIN ) ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'category_ids' ) ?>" name="<?php echo $this->get_field_name( 'category_ids' ) ?>" type="text" value="<?php echo esc_attr( $category_ids ) ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'post_limit' ) ?>"><?php echo __( 'Number of posts', THEME_TEXTDOMAIN ) ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'post_limit' ) ?>" name="<?php echo $this->get_field_name( 'post_limit' ) ?>" type="number" min="1" step="1" value="<?php echo esc_attr( $post_limit ) ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'posts_period' ) ?>"><?php echo __( 'Number of days to show posts', THEME_TEXTDOMAIN ) ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'posts_period' ) ?>" name="<?php echo $this->get_field_name( 'posts_period' ) ?>" type="number" value="<?php echo esc_attr( $posts_period ) ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'articles_view' ) ?>"><?php echo __( 'Output', THEME_TEXTDOMAIN ) ?></label><br>
            <select name="<?php echo $this->get_field_name( 'articles_view' ) ?>" id="<?php echo $this->get_field_id( 'articles_view' ) ?>">
                <option value="normal" <?php selected( $posts_articles_view, 'normal' ) ?>><?php echo __( 'Normal', THEME_TEXTDOMAIN ) ?></option>
                <option value="compact" <?php selected( $posts_articles_view, 'compact' ) ?>><?php echo __( 'Compact', THEME_TEXTDOMAIN ) ?></option>
            </select>
        </p>
        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'hide_category' ) ?>" name="<?php echo $this->get_field_name( 'hide_category' ) ?>" value="1" <?php checked( $hide_category ) ?>>
            <label for="<?php echo $this->get_field_id( 'hide_category' ) ?>"><?php echo __( 'Hide category', THEME_TEXTDOMAIN ) ?></label>
        </p>
        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'hide_meta' ) ?>" name="<?php echo $this->get_field_name( 'hide_meta' ) ?>" value="1" <?php checked( $hide_meta ) ?>>
            <label for="<?php echo $this->get_field_id( 'hide_meta' ) ?>"><?php echo __( 'Hide meta-information', THEME_TEXTDOMAIN ) ?></label>
        </p>
        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'link_target' ) ?>" name="<?php echo $this->get_field_name( 'link_target' ) ?>" value="1" <?php checked( $link_target ) ?>>
            <label for="<?php echo $this->get_field_id( 'link_target' ) ?>"><?php echo __( 'Open link in new window', THEME_TEXTDOMAIN ) ?></label>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title']         = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['post_ids']      = ( ! empty( $new_instance['post_ids'] ) ) ? wpshop_sanitize_ids_string( $new_instance['post_ids'] ) : '';
        $instance['category_ids']  = ( ! empty( $new_instance['category_ids'] ) ) ? wpshop_sanitize_ids_string ( $new_instance['category_ids'] ) : '';
        $instance['posts_orderby'] = ( ! empty( $new_instance['posts_orderby'] ) ) ? sanitize_text_field( $new_instance['posts_orderby'] ) : '';
        $instance['post_limit']    = ( ! empty( $new_instance['post_limit'] ) ) ? sanitize_text_field( $new_instance['post_limit'] ) : '';
        $instance['posts_period']  = ( ! empty( $new_instance['posts_period'] ) ) ? sanitize_text_field( $new_instance['posts_period'] ) : '';
        $instance['articles_view'] = ( ! empty( $new_instance['articles_view'] ) ) ? sanitize_text_field( $new_instance['articles_view'] ) : '';
        $instance['hide_category'] = ! empty( $new_instance['hide_category'] ) ? true : false;
        $instance['hide_meta']     = ! empty( $new_instance['hide_meta'] ) ? true : false;
        $instance['link_target']   = ! empty( $new_instance['link_target'] ) ? true : false;

        return $instance;
    }
}