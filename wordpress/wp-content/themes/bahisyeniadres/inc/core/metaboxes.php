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
 * Metaboxes
 */
class Vetteo_Meta_Box {

    protected $to_save;
    protected $pid;
    protected $prefix = 'meta_posts_';
    protected $post_type = 'post';
    protected $metabox_title = 'Настройки';
    protected $context = 'advanced';

    public function __construct() {

        $this->to_save = array();
        $this->pid = 0;

        $this->set_settings( $this->prefix, $this->post_type, $this->metabox_title, $this->context );

        if ( is_admin() ) {
            add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
        }

    }

    /**
     * @param string $prefix
     * @param string $post_type
     * @param string $metabox_title
     * @param string $context
     */
    public function set_settings( $prefix = 'meta_posts_', $post_type = '', $metabox_title = 'Настройки', $context = 'advanced' ) {
        $this->prefix = $prefix;
        $this->post_type = $post_type;
        $this->metabox_title = $metabox_title;
        $this->context = $context;
    }

    public function init_metabox() {

        add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
        add_action( 'save_post',      array( $this, 'save_metabox' ), 11, 2 );

        // color
        add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts_styles')  );
        add_action( 'admin_footer',          array( $this, 'color_field_js' )      );

    }

    public function add_metabox() {

        add_meta_box(
            $this->prefix . 'meta_box',
            $this->metabox_title,
            array( $this, 'render_metabox' ),
            $this->post_type,
            $this->context,
            'default'
        );

    }

    public function render_metabox( $post ) {

        // Set post id
        $this->pid = $post->ID;

        // Add nonce for security and authentication.
        wp_nonce_field( $this->prefix . 'nonce_action', $this->prefix . 'nonce' );



        // Form fields.
        echo '<table class="form-table">';

        $this->render_fields();

        //$this->field_number('number_tz', 'Номер ТЗ', '', '', '');

        /*$this->field_select(        'company_type', 'Тип', array( 'mfo' => 'МФО', 'bank' => 'Банк' ) );
        $this->field_text(          'company_phone', 'Телефон', '8 (800) 000-00-00', '', '' );
        $this->field_text(          'company_site', 'Сайт', 'http://', '', '' );
        $this->field_text(          'company_mail', 'E-mail', '', '', '' );
        $this->field_text(          'company_address', 'Адрес', '', '', '' );*/

        /*$this->field_text(          'offer_partner', 'Ссылка на ПП', 'http://', '', '' );
        $this->field_number(        'offer_order', 'Сортировка', '0', 'Чем меньше значение, тем выше размещается оффер', '' );
        $this->field_checkbox(      'offer_special',  'Спецразмещение' );
        $this->field_checkbox(      'offer_geo_russia',  'По всей РФ', 'Без привязки к ГЕО' );

        $this->field_post(          'offer_company', 'Компания', array('post_type'=>'companies', 'posts_per_page'=>-1) );
        //$this->field_select(        'offer_category', 'Категория', $company_categories_list );

        $this->field_number(        'offer_rate', 'Ставка', '0', '', '%', 0.01 );
        $this->field_number(        'offer_limit', 'Кредитный лимит', '0', '', 'руб.' );
        $this->field_number(        'offer_grace', 'Льготный период', '0', '', 'дней' );
        $this->field_number(        'offer_cost', 'Стоимость обслуживания', '0', '', 'руб' );
        $this->field_number(        'offer_profit', 'Доходность', '0', '', '%', 0.01 );
        $this->field_number(        'offer_period', 'Макс. срок', '0', '', 'мес' );

        // Кредитные карты
        $this->field_checkbox(      'offer_card_paypass',  'Бесконтактная оплата' );
        $this->field_number(        'offer_card_cashback', 'Cashback', '', '', '%' );
        $this->field_checkbox(      'offer_card_3d_secure',  '3D Secure' );
        $this->field_checkbox(      'offer_card_sms',  'SMS уведомления' );
        $this->field_checkbox(      'offer_card_cheap',  'Карта с чипом' );
        $this->field_select(        'offer_card_company',  'Платежная система', array( '' => 'Не выбрано', 'visa' => 'Visa', 'mastercard' => 'MasterCard' ) );
*/
        echo '</table>';

        // fields to save
        echo '<input type="hidden" name="' . $this->prefix . 'fields_to_save" value="' . esc_attr(base64_encode(json_encode( $this->to_save ))) . '">';

    }

    public function render_fields() {

    }

    public function save_metabox( $post_id, $post ) {

        // Add nonce for security and authentication.
        $nonce_name   = ( ! empty( $_POST[ $this->prefix . 'nonce' ] ) ) ? $_POST[ $this->prefix . 'nonce' ] : '' ;
        $nonce_action = $this->prefix . 'nonce_action';

        // Check if a nonce is set.
        if ( ! isset( $nonce_name ) )
            return;

        // Check if a nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
            return;

        // Check if the user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return;

        // Check if it's not an autosave.
        if ( wp_is_post_autosave( $post_id ) )
            return;

        // Check if it's not a revision.
        if ( wp_is_post_revision( $post_id ) )
            return;


        $fields_to_save = json_decode( base64_decode( $_POST[ $this->prefix . 'fields_to_save' ] ) );

        foreach ($fields_to_save as $field_to_save) {


            if ( $field_to_save->type == 'select' ) {
                $field_variable = isset( $_POST[ $field_to_save->name ] ) ? $_POST[ $field_to_save->name ] : '';
                update_post_meta( $post_id, $field_to_save->name, $field_variable );
            }

            if ( $field_to_save->type == 'text' || $field_to_save->type == 'number'  || $field_to_save->type == 'color' ) {
                $field_variable = isset( $_POST[ $field_to_save->name ] ) ? sanitize_text_field( $_POST[ $field_to_save->name ] ) : '';
                update_post_meta( $post_id, $field_to_save->name, $field_variable );
            }

            if ( $field_to_save->type == 'number_range' ) {
                $field_variable_start = isset( $_POST[ $field_to_save->name . '_start' ] ) ? sanitize_text_field( $_POST[ $field_to_save->name . '_start' ] ) : '';
                $field_variable_end = isset( $_POST[ $field_to_save->name . '_end' ] )     ? sanitize_text_field( $_POST[ $field_to_save->name . '_end' ] ) : '';
                update_post_meta( $post_id, $field_to_save->name . '_start', $field_variable_start );
                update_post_meta( $post_id, $field_to_save->name . '_end',   $field_variable_end );
            }

            if ( $field_to_save->type == 'checkbox' ) {
                $field_variable = isset( $_POST[ $field_to_save->name ] ) ? 'checked' : '';
                update_post_meta( $post_id, $field_to_save->name, $field_variable );
            }

            if ( $field_to_save->type == 'checkboxes' ) {
                $field_variable = isset( $_POST[ $field_to_save->name ] ) ? $_POST[ $field_to_save->name ] : '';

                $keys = 0;
                if ( is_array($field_variable) ) {
                    foreach ($field_variable as $key => $value) {
                        $keys = $keys + $key;
                    }
                }

                update_post_meta( $post_id, $field_to_save->name, $keys );
            }

        }


        // Sanitize user input.


        /*$account_number = isset( $_POST[ 'account_number' ] ) ? sanitize_text_field( $_POST[ 'account_number' ] ) : '';
        // sanitize
        $created_date = strtotime($created_date);
        $rollover_next = strtotime($rollover_next);

        $profit_7 = str_replace('%', '', $profit_7);
        $profit_7 = str_replace(',', '.', $profit_7);
        $profit_7 = str_replace(' ', '', $profit_7);
*/

    }




    /**
     * Input number
     *
     * @param string $name
     * @param string $label
     * @param string $placeholder
     * @param string $description
     * @param string $text
     */
    public function field_text( $name = '', $label = '', $placeholder = '', $description = '', $text = '' ) {

        $this->add_to_save( $name, 'number' );

        $value = get_post_meta( $this->pid, $name, true );
        if( empty( $value ) ) $value = '';

        echo '	<tr>';
        echo '		<th><label for="'. $name .'">' . $label . '</label></th>';
        echo '		<td>';
        echo '			<input type="text" id="'. $name .'" name="'. $name .'" placeholder="' . esc_attr( $placeholder ) . '" value="' . esc_attr( $value ) . '" style="width: 80%"> ' . $text;
        echo '          <p class="description">' . $description . '</p>';
        echo '		</td>';
        echo '	</tr>';
    }


    /**
     * Input number
     *
     * @param string $name
     * @param string $label
     * @param string $placeholder
     * @param string $description
     * @param string $text
     */
    public function field_number( $name = '', $label = '', $placeholder = '', $description = '', $text = '', $step = 1 ) {

        $this->add_to_save( $name, 'number' );

        $value = get_post_meta( $this->pid, $name, true );
        if( empty( $value ) ) $value = '';

        echo '	<tr class="'. $name .'_tr">';
        echo '		<th><label for="'. $name .'">' . $label . '</label></th>';
        echo '		<td>';
        echo '			<input type="number" step="'. $step .'" id="'. $name .'" name="'. $name .'" placeholder="' . esc_attr( $placeholder ) . '" value="' . esc_attr( $value ) . '" style="width: 150px;"> ' . $text;
        echo '          <p class="description">' . $description . '</p>';
        echo '		</td>';
        echo '	</tr>';
    }

    /**
     * Input number range
     *
     * @param string $name
     * @param string $label
     * @param string $placeholder
     * @param string $description
     * @param string $text
     */
    public function field_number_range( $name = '', $label = '', $placeholder = '', $description = '', $text = '' ) {

        $this->add_to_save( $name, 'number_range' );

        $value_start = get_post_meta( $this->pid, $name . '_start', true );
        $value_end = get_post_meta( $this->pid, $name . '_end', true );
        if( empty( $value_start ) ) $value_start = '';
        if( empty( $value_end ) )   $value_end = '';

        echo '	<tr>';
        echo '		<th><label for="'. $name .'_start">' . $label . '</label></th>';
        echo '		<td>';
        echo '			<input type="number" id="'. $name .'_start" name="'. $name .'_start" placeholder="' . esc_attr( $placeholder ) . '" value="' . esc_attr( $value_start ) . '" style="width: 100px;"> — ';
        echo '			<input type="number" id="'. $name .'_end" name="'. $name .'_end" placeholder="' . esc_attr( $placeholder ) . '" value="' . esc_attr( $value_end ) . '" style="width: 100px;"> ' . $text;
        echo '          <p class="description">' . $description . '</p>';
        echo '		</td>';
        echo '	</tr>';
    }

    /**
     * Select
     *
     * @param string $name
     * @param string $label
     * @param array $options
     * @param string $description
     */
    public function field_select( $name = '', $label = '', $options = array(), $description = '' ) {

        $this->add_to_save( $name, 'select' );

        $value = get_post_meta( $this->pid, $name, true );
        if( empty( $value ) ) $value = '';

        echo '	<tr>';
        echo '		<th><label for="'. $name .'">' . $label . '</label></th>';
        echo '		<td>';
        echo '			<select id="'. $name .'" name="'. $name .'" class="'. $name .'_field">';

        foreach ( $options as $key=>$option ) {
            echo '			<option value="' . $key . '" ' . selected($value, $key, false) . '> ' . $option . '</option>';
        }

        echo '			</select>';
        echo '          <p class="description">' . $description . '</p>';
        echo '		</td>';
        echo '	</tr>';
    }

    /**
     * @param string $name
     * @param string $label
     * @param array $args
     * @param string $description
     */
    public function field_post( $name = '', $label = '', $args = array(), $description = '' ) {

        $this->add_to_save( $name, 'select' );

        $value = get_post_meta( $this->pid, $name, true );
        if( empty( $value ) ) $value = '';

        echo '	<tr>';
        echo '		<th><label for="'. $name .'">' . $label . '</label></th>';
        echo '		<td>';
        echo '			<select id="'. $name .'" name="'. $name .'" class="'. $name .'_field">';

        $get_posts = get_posts( $args );

        echo '			<option value="0" ' . selected($value, 0, false) . '>Не выбрано</option>';

        foreach ( $get_posts as $get_post ) {
            echo '			<option value="' . $get_post->ID . '" ' . selected($value, $get_post->ID, false) . '> ' . $get_post->post_title . '</option>';
        }

        echo '			</select>';
        echo '          <p class="description">' . $description . '</p>';
        echo '		</td>';
        echo '	</tr>';
    }

    /**
     * Checkbox
     *
     * @param string $name
     * @param string $label
     * @param string $text
     */
    public function field_checkbox( $name = '', $label = '', $text = '' ) {

        $this->add_to_save( $name, 'checkbox' );

        $value = get_post_meta( $this->pid, $name, true );
        if( empty( $value ) ) $value = '';

        echo '	<tr class="'. $name .'_tr">';
        if ( ! empty( $label ) ) echo '		<th><label for="'. $name .'">' . $label . '</label></th>';
        echo '		<td>';
        echo '			<input type="checkbox" id="'. $name .'" name="'. $name .'" class="'. $name .'_field" value="' . $value . '" ' . checked( $value, 'checked', false ) . '> <label for="'. $name .'">' . $text . '</label>';
        echo '		</td>';
        echo '	</tr>';
    }

    /**
     * Checkboxes
     *
     * @param string $name
     * @param string $label
     * @param array $options
     * @param string $description
     */
    public function field_checkboxes( $name = '', $label = '', $options = array(), $description = '' ) {

        $this->add_to_save( $name, 'checkboxes' );

        $value = get_post_meta( $this->pid, $name, true );
        if( empty( $value ) ) $value = '';

        echo '	<tr>';
        if ( ! empty( $label ) ) echo '		<th><label for="'. $name .'">' . $label . '</label></th>';
        echo '		<td>';

        $keys = array();

        foreach ($options as $key=>$val) {
            $keys[$key] = '';

            if ( $value & $key ) {
                $keys[$key] = ' checked';
            }
        }

        foreach ( $options as $key=>$checkbox ) {
            echo '			<p><label><input type="checkbox" name="'. $name .'[' . $key . ']" class="'. $name .'_field" value="' . $value . '" ' . $keys[$key] . '> ' . $checkbox . '</label></p>';
        }

        echo '          <p class="description">' . $description . '</p>';
        echo '		</td>';
        echo '	</tr>';
    }

    /**
     * Color box
     *
     * @param string $name
     * @param string $label
     * @param string $default
     * @param string $description
     */
    public function field_color( $name = '', $label = '', $default = '#000000', $description = '' ) {

        $this->add_to_save( $name, 'color' );

        $value = get_post_meta( $this->pid, $name, true );
        if( empty( $value ) ) $value = $default;

        echo '	<tr>';
        echo '		<th><label for="'. $name .'" class="'. $name .'_label">' . $label . '</label></th>';
        echo '		<td>';
        echo '			<input type="text" id="'. $name .'" name="'. $name .'" class="'. $name .'_field vetteo-color-picker" placeholder="" value="' . esc_attr__( $value ) . '">';
        echo '          <p class="description">' . $description . '</p>';
        echo '		</td>';
        echo '	</tr>';
    }

    /*public function field_image( $name = '', $label = '', $value = '', $w = 115, $h = 90) {
        $default = get_stylesheet_directory_uri() . '/img/no-image.png';
        if ( $value ) {
            $image_attributes = wp_get_attachment_image_src( $value, array($w, $h) );
            $src = $image_attributes[0];
        } else {
            $src = $default;
        }

        echo '	<tr>';
        echo '		<th><label for="'. $name .'" class="'. $name .'_label">' . $label . '</label></th>';
        echo '		<td>';
        echo '			<img data-src="' . $default . '" src="' . $src . '" width="' . $w . 'px" height="' . $h . 'px" />';
        echo '          <input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />';
        echo '          <p class="description">' . $description . '</p>';
        echo '		</td>';
        echo '	</tr>';

        echo '
	<div>
		<img data-src="' . $default . '" src="' . $src . '" width="' . $w . 'px" height="' . $h . 'px" />
		<div>
			<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />
			<button type="submit" class="upload_image_button button">Загрузить</button>
			<button type="submit" class="remove_image_button button">&times;</button>
		</div>
	</div>
	';
    }*/


    /**
     * @param string $name
     * @param string $type
     */
    public function add_to_save( $name = '', $type = 'text' ) {
        $this->to_save[] = array( 'name' => $name, 'type' => $type );
    }

    public function load_scripts_styles() {

        // color picker
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_style( 'wp-color-picker' );

        // image uploader
        if ( ! did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }

    }

    public function color_field_js() {

        // Print js only once per page
        if ( did_action( $this->prefix . 'color_picker_js' ) >= 1 ) {
            return;
        }

        ?>
        <script>
            jQuery(document).ready(function($){
                // color
                $('.vetteo-color-picker').wpColorPicker();

                /*
                 * действие при нажатии на кнопку загрузки изображения
                 * вы также можете привязать это действие к клику по самому изображению
                 */
                $('.upload_image_button').click(function(){
                    var send_attachment_bkp = wp.media.editor.send.attachment;
                    var button = $(this);
                    wp.media.editor.send.attachment = function(props, attachment) {
                        $(button).parent().prev().attr('src', attachment.url);
                        $(button).prev().val(attachment.id);
                        wp.media.editor.send.attachment = send_attachment_bkp;
                    }
                    wp.media.editor.open(button);
                    return false;
                });
                /*
                 * удаляем значение произвольного поля
                 * если быть точным, то мы просто удаляем value у input type="hidden"
                 */
                $('.remove_image_button').click(function(){
                    var r = confirm("Уверены?");
                    if (r == true) {
                        var src = $(this).parent().prev().attr('data-src');
                        $(this).parent().prev().attr('src', src);
                        $(this).prev().prev().val('');
                    }
                    return false;
                });

            });
        </script>
        <?php
        do_action( $this->prefix . 'color_picker_js', $this );

    }

}