<?php

/**
 * Модуль партнерской программы WPShop.ru
 */

define( 'WPSHOP_PARTNER', '3499' );

/**
 * Class Wpshop_Partner
 *
 * @version     1.0
 * @updated     2018-05-27
 * @package     Wpshop
 */
class Wpshop_Partner {


    public $partner_id = 0;


    public function __construct() {
        $this->partner_id = WPSHOP_PARTNER;
    }


    public function get_partner_id() {
        return $this->partner_id;
    }


    public function the_link() {
        echo $this->get_the_link();
    }


    public function get_the_link( $args = array() ) {
        $url = $this->prepare_link();

        $prefix = __( 'Powered by theme', THEME_TEXTDOMAIN );
        $postfix = '';
        if ( ! empty( $args['prefix'] ) ) $prefix = $args['prefix'];
        if ( ! empty( $args['postfix'] ) ) $postfix = $args['postfix'];

        $link = '<span data-href="' . $url . '" data-target="_blank" class="pseudo-link js-link">' . THEME_TITLE . '</span>';

        return $prefix . ' ' . $link . ' ' . $postfix;
    }


    public function prepare_link() {
        $url = $this->find_link();
        $home_url = home_url();
        $home_url = parse_url( $home_url, PHP_URL_HOST );
        $url .= '?partner=' . $this->partner_id;
        $url .= '&utm_source=site_partner';
        $url .= '&utm_medium=' . $this->partner_id;
        $url .= '&utm_campaign=' . $home_url;

        return $url;
    }


    public function find_link() {
        $url = 'https://wpshop.ru/';
        if ( defined( THEME_NAME ) ) $url = 'https://wpshop.ru/themes/' . THEME_NAME;

        return $url;
    }

}

function wpshop_partner_link( $args = array() ) {
    echo get_wpshop_partner_link( $args );
}

function get_wpshop_partner_link( $args = array() ) {
    $wpshop_partner = new Wpshop_Partner();
    return $wpshop_partner->get_the_link( $args );
}

function get_wpshop_partner_id() {
    $wpshop_partner = new Wpshop_Partner();
    return $wpshop_partner->get_partner_id();
}