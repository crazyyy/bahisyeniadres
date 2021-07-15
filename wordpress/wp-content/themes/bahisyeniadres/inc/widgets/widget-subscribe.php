<?php

/**
 * Class Wpshop_Widget_Subscribe
 *
 * @version     1.1
 * @updated     2018-03-21
 */
class Wpshop_Widget_Subscribe extends WP_Widget {

    function __construct() {
        parent::__construct(
            'wpshop_widget_subscribe',
            __( 'Subscription', THEME_TEXTDOMAIN ),
            array( 'description' => __( 'Update subscription form', THEME_TEXTDOMAIN ) )
        );
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        echo $args['before_widget'];

        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        echo do_shortcode( '[subscribeform]' );

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $title = sanitize_text_field( $instance['title'] );

        echo '<p>';
        echo '<label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title', THEME_TEXTDOMAIN ) . '</label>';
        echo '<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '">';
        echo '</p>';
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

        return $instance;
    }
}