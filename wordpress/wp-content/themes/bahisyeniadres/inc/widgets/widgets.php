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

require get_template_directory() . '/inc/widgets/widget-top-commentators.php';
require get_template_directory() . '/inc/widgets/widget-subscribe.php';
require get_template_directory() . '/inc/widgets/widget-social-links.php';
require get_template_directory() . '/inc/widgets/widget-articles.php';


function wpshop_widgets_register() {
    register_widget( 'Wpshop_Widget_Top_Commentators' );
    register_widget( 'Wpshop_Widget_Subscribe' );
    register_widget( 'Wpshop_Widget_Social_Links' );
    register_widget( 'Wpshop_Widget_Articles' );
}
add_action( 'widgets_init', 'wpshop_widgets_register' );


/**
 * Widget Classes
 *
 * Based on C.M. Kendrick Widget CSS Classes plugin
 */
class Vetteo_Widget_Classes {

    public function __construct() {
        add_action( 'init', array( $this, 'widget_css_classes_loader' ) );
        add_action( 'wp_loaded', array( $this, 'widget_css_classes_frontend_hook' ) );
    }

    function widget_css_classes_loader() {

        if ( is_admin() ) {

            add_action( 'in_widget_form', array( $this, 'extend_widget_form' ), 10, 3 );
            add_filter( 'widget_update_callback', array( $this, 'update_widget' ), 10, 2 );

        }
    }

    function widget_css_classes_frontend_hook() {
        if ( ! is_admin() ) {
            add_filter( 'dynamic_sidebar_params', array( $this, 'add_widget_classes' ) );
        }
    }




    function add_widget_classes( $params ) {

        global $wp_registered_widgets, $widget_number;

        $arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets
        $this_id                = $params[0]['id']; // Get the id for the current sidebar we're processing
        $widget_id              = $params[0]['widget_id'];
        $widget_obj             = $wp_registered_widgets[$widget_id];
        $widget_num             = $widget_obj['params'][0]['number'];
        $widget_css_classes     = ( get_option( 'WCSSC_options' ) ? get_option( 'WCSSC_options' ) : array() );
        $widget_opt             = null;

        // If Widget Logic plugin is enabled, use it's callback
        if ( in_array( 'widget-logic/widget_logic.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            $widget_logic_options = get_option( 'widget_logic' );
            if ( isset( $widget_logic_options['widget_logic-options-filter'] ) && 'checked' == $widget_logic_options['widget_logic-options-filter'] ) {
                $widget_opt = get_option( $widget_obj['callback_wl_redirect'][0]->option_name );
            } else {
                if ( is_array( $widget_obj ) && is_array( $widget_obj['callback'] ) && isset( $widget_obj['callback'][0] ) ) {
                    $widget_opt = get_option( $widget_obj['callback'][0]->option_name );
                } else {
                    return $params;
                }
            }

            // If Widget Context plugin is enabled, use it's callback
        } elseif ( in_array( 'widget-context/widget-context.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            $callback = isset( $widget_obj['callback_original_wc'] ) ? $widget_obj['callback_original_wc'] : null;
            $callback = ! $callback && isset( $widget_obj['callback'] ) ? $widget_obj['callback'] : null;

            if ( $callback && is_array( $widget_obj['callback'] ) ) {
                $widget_opt = get_option( $callback[0]->option_name );
            }
        }

        // Default callback
        else {
            // Check if WP Page Widget is in use
            global $post;
            $id = ( isset( $post->ID ) ? get_the_ID() : NULL );
            if ( isset( $id ) && get_post_meta( $id, '_customize_sidebars' ) ) {
                $custom_sidebarcheck = get_post_meta( $id, '_customize_sidebars' );
            }
            $_option_name = null;
            if ( is_array( $widget_obj['callback'] ) ) {
                $_option_name = isset( $widget_obj['callback'][0]->option_name ) ? $widget_obj['callback'][0]->option_name : null;
            }

            if ( $_option_name ) {
                $widget_opt = get_option(
                    isset( $custom_sidebarcheck[0] ) && ( $custom_sidebarcheck[0] == 'yes' )
                        ? 'widget_' . $id . '_' . substr( $_option_name, 7 )
                        : $_option_name
                );
            }
        }


        // Add classes
        if ( isset( $widget_opt[$widget_num]['classes'] ) && ! empty( $widget_opt[$widget_num]['classes'] ) ) {
            $params[0]['before_widget'] = preg_replace( '/class="/', "class=\"{$widget_opt[$widget_num]['classes']} ", $params[0]['before_widget'], 1 );
        }

        do_action( 'widget_css_classes_add_classes', $params, $widget_id, $widget_number, $widget_opt, $widget_obj );

        return $params;
    }

    function update_widget( $instance, $new_instance ) {
        $instance['classes'] = $new_instance['classes'];
        $instance['classes-defined'] = $new_instance['classes-defined'];
        if ( is_array( $instance['classes-defined'] ) ) {
            // Merge predefined classes with input classes
            $text_classes = explode( ' ', $instance['classes'] );
            foreach ( $instance['classes-defined'] as $key => $value ) {
                if ( ! in_array( $value, $text_classes ) ) {
                    $text_classes[] = $value;
                }
            }
            $instance['classes'] = implode( ' ', $text_classes );
        }
        // Do not store predefined array in widget, no need
        unset( $instance['classes-defined'] );

        do_action( 'widget_css_classes_update', $instance, $new_instance );
        return $instance;
    }


    function extend_widget_form( $widget, $return, $instance ) {
        if ( ! isset( $instance['classes'] ) ) $instance['classes'] = null;
        if ( ! isset( $instance['classes-defined'] ) ) $instance['classes-defined'] = array();

        $fields = '';
        $fields .= "\t<p><label for='widget-{$widget->id_base}-{$widget->number}-classes'>".apply_filters( 'widget_css_classes_class', esc_html__( 'CSS Classes', 'widget-css-classes' ) ).":</label>
                <input type='text' name='widget-{$widget->id_base}[{$widget->number}][classes]' id='widget-{$widget->id_base}-{$widget->number}-classes' value='{$instance['classes']}' class='widefat' /></p>\n";

        do_action( 'widget_css_classes_form', $fields, $instance );

        echo $fields;
        return $instance;
    }

}
new Vetteo_Widget_Classes;


/**
 * Exclude category in widget
 */
function exclude_category_widget( $args ) {
    if ( is_category() ) {
        $cat_id = get_query_var( 'cat' );
        $args['exclude'] = $cat_id;
    }
    return $args;
}
add_filter( 'widget_categories_args','exclude_category_widget' );