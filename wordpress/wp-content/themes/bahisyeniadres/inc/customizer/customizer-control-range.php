<?php
if ( is_customize_preview() ) {

class WP_Customize_Range_Control extends WP_Customize_Control {
    public $type = 'root_range';

    public function render_content() {
        ?>
        <label class="root-customizer-range">
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif; ?>

            <input data-input-type="range" type="range" <?php $this->input_attrs(); ?> value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
            <div class="root-customizer-range-val"><?php echo esc_attr( $this->value() ); ?></div>

            <?php if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description root-customizer-range-description"><?php echo $this->description; ?></span>
            <?php endif; ?>
        </label>
        <?php
    }
}

}