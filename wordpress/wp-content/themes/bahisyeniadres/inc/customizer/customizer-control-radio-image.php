<?php

if ( is_customize_preview() ) {
    /**
     * Radio image customize control.
     *
     * @since  3.0.0
     * @access public
     */
    class Customize_Control_Radio_Image extends WP_Customize_Control {
        /**
         * The type of customize control being rendered.
         *
         * @since 3.0.0
         * @var   string
         */
        public $type = 'radio-image';

        /**
         * Displays the control content.
         *
         * @since  3.0.0
         * @access public
         * @return void
         */
        public function render_content() {
            /* If no choices are provided, bail. */
            if ( empty( $this->choices ) ) {
                return;
            } ?>

            <?php
                $out_id = str_replace( '[', '', $this->id );
                $out_id = str_replace( ']', '', $out_id );
            ?>

            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif; ?>

            <?php if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo $this->description; ?></span>
            <?php endif; ?>

            <div id="<?php echo esc_attr( "input_{$out_id}" ); ?>">

                <?php foreach ( $this->choices as $value => $args ) : ?>

                    <input type="radio" value="<?php echo esc_attr( $value ); ?>"
                           name="<?php echo esc_attr( "_customize-radio-{$this->id}" ); ?>"
                           id="<?php echo esc_attr( "{$this->id}-{$value}" ); ?>" <?php $this->link(); ?> <?php checked( $this->value(), $value ); ?> />

                    <label for="<?php echo esc_attr( "{$this->id}-{$value}" ); ?>">
                        <span class="screen-reader-text"><?php echo esc_html( $args['label'] ); ?></span>
                        <img src="<?php echo esc_url( sprintf( $args['url'], get_template_directory_uri(), get_stylesheet_directory_uri() ) ); ?>"
                             alt="<?php echo esc_attr( $args['label'] ); ?>"/>
                    </label>

                <?php endforeach; ?>

            </div><!-- .image -->

            <script>
                jQuery(document).ready(function () {
                    jQuery('#<?php echo esc_attr( "input_{$out_id}" ); ?>').buttonset();
                });
            </script>
        <?php }

        /**
         * Loads the jQuery UI Button script and hooks our custom styles in.
         *
         * @since  3.0.0
         * @access public
         * @return void
         */
        public function enqueue() {
            wp_enqueue_script( 'jquery-ui-button' );
            add_action( 'customize_controls_print_styles', array( $this, 'print_styles' ) );
        }

        /**
         * Outputs custom styles to give the selected image a visible border.
         *
         * @since  3.0.0
         * @access public
         * @return void
         */
        public function print_styles() { ?>

            <style id="hybrid-customize-radio-image-css">
                .customize-control-radio-image img {
                    border: 4px solid transparent;
                }

                .customize-control-radio-image .ui-state-active img {
                    border-color: #00a0d2;
                }

                #customize-control-root_options-typography_font_size,
                #customize-control-root_options-typography_line_height,
                #customize-control-root_options-typography_site_title_size,
                #customize-control-root_options-typography_site_title_line_height,
                #customize-control-root_options-typography_headers_bold,
                #customize-control-root_options-typography_headers_style,
                #customize-control-root_options-typography_links_size,
                #customize-control-root_options-typography_links_line_height,
                #customize-control-root_options-typography_links_bold,
                #customize-control-root_options-typography_links_style,
                #customize-control-root_options-typography_menu_links_size,
                #customize-control-root_options-typography_menu_links_line_height,
                #customize-control-root_options-typography_menu_links_bold,
                #customize-control-root_options-typography_menu_links_style {
                    width: 48%;
                    clear: none;
                }

                #customize-control-root_options-typography_font_size,
                #customize-control-root_options-typography_site_title_size,
                #customize-control-root_options-typography_headers_bold,
                #customize-control-root_options-typography_links_size,
                #customize-control-root_options-typography_links_bold,
                #customize-control-root_options-typography_menu_links_size,
                #customize-control-root_options-typography_menu_links_bold {
                    margin-right: 4%;
                }

                #customize-control-root_options-typography_site_title_family,
                #customize-control-root_options-typography_site_description_family,
                #customize-control-root_options-typography_headers_family,
                #customize-control-root_options-typography_menu_links_family {
                    margin-top: 25px;
                }
            </style>
        <?php }
    }
}