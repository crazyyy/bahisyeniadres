<?php

namespace Wpshop\Core;

/**
 * Class Fonts
 */
class Fonts {

    public $fonts = array();

    public function __construct() {

        /**
         * family sans-serif default
         */
        $this->fonts = apply_filters( 'wpshop_fonts_list', array(
            'arial'             => array(
                'name'          => 'Arial',
            ),
            'roboto'            => array(
                'name'          => 'Roboto',
                'url'           => 'Roboto',
                'weight'        => '400,400i,700',
            ),
            'roboto_condensed'  => array(
                'name'          => 'Roboto Condensed',
                'url'           => 'Roboto+Condensed',
                'weight'        => '400,400i,700',
            ),
            'roboto_slab'       => array(
                'name'          => 'Roboto Slab',
                'url'           => 'Roboto+Slab',
                'weight'        => '400,700',
                'family'        => 'serif',
            ),
            'times_serif'       => array(
                'name'          => 'Times New Roman',
                'family'        => 'serif',
            ),
            'pt_sans'           => array(
                'name'          => 'PT Sans',
                'url'           => 'PT+Sans',
                'weight'        => '400,400i,700',
            ),
            'pt_serif'          => array(
                'name'          => 'PT Serif',
                'url'           => 'PT+Serif',
                'weight'        => '400,400i,700',
            ),
            'open_sans'         => array(
                'name'          => 'Open Sans',
                'url'           => 'Open+Sans',
                'weight'        => '400,400i,700',
            ),
            'open_sans_condensed'=> array(
                'name'          => 'Open Sans Condensed',
                'url'           => 'Open+Sans+Condensed',
                'weight'        => '300,300i,700',
            ),
            'ubuntu'            => array(
                'name'          => 'Ubuntu',
                'url'           => 'Ubuntu',
                'weight'        => '400,400i,700',
            ),
            'ubuntu_condensed'  => array(
                'name'          => 'Ubuntu Condensed',
                'url'           => 'Ubuntu+Condensed',
            ),
            'exo_2'             => array(
                'name'          => 'Exo 2',
                'url'           => 'Exo+2',
                'weight'        => '400,400i,700',
            ),
            'tinos'             => array(
                'name'          => 'Tinos',
                'url'           => 'Tinos',
                'weight'        => '400,400i,700',
            ),
            'fira_sanscondensed'=> array(
                'name'          => 'Fira Sans Condensed',
                'url'           => 'Fira+Sans+Condensed',
                'weight'        => '400,400i,700',
            ),
            'merriweather'      => array(
                'name'          => 'Merriweather',
                'url'           => 'Merriweather',
                'weight'        => '400,400i,700',
                'family'        => 'serif',
            ),
            'oswald'            => array(
                'name'          => 'Oswald',
                'url'           => 'Oswald',
                'weight'        => '400,700',
            ),
            'lora'              => array(
                'name'          => 'Lora',
                'url'           => 'Lora',
                'weight'        => '400,400i,700',
            ),
            'lobster'           => array(
                'name'          => 'Lobster',
                'url'           => 'Lobster',
            ),
            'yanone_kaffeesatz' => array(
                'name'          => 'Yanone Kaffeesatz',
                'url'           => 'Yanone+Kaffeesatz',
                'weight'        => '400,700',
            ),
            'bad_script'        => array(
                'name'          => 'Bad Script',
                'url'           => 'Bad+Script',
            ),
            'kurale'            => array(
                'name'          => 'Kurale',
                'url'           => 'Kurale',
            ),
            'pacifico'            => array(
                'name'          => 'Pacifico',
                'url'           => 'Pacifico',
            ),
            'amatic_sc'            => array(
                'name'          => 'Amatic SC',
                'url'           => 'Amatic+SC',
                'weight'        => '400,700',
            ),
            'montserrat'        => array(
                'name'          => 'Montserrat',
                'url'           => 'Montserrat',
                'weight'        => '400,400i,700',
            ),
            'caveat'            => array(
                'name'          => 'Caveat',
                'url'           => 'Caveat',
                'weight'        => '400,700',
            ),
        ) );

    }


    /**
     * @return array
     */
    public function get_fonts() {
        return $this->fonts;
    }

    /**
     * @return array
     */
    public function get_fonts_key_value() {
        $fonts_list = array();
        foreach ( $this->fonts as $key => $val ) {
            $fonts_list[$key] = $val['name'];
        }
        return $fonts_list;
    }


    /**
     * Get google enqueue link
     * Возвращает ссылку для добавления шрифтов
     * Удаляет дубли
     *
     * @param array $fonts
     *
     * @return string
     */
    public function get_enqueue_link( $fonts = array() ) {

        if ( ! empty( $fonts ) ) {

            // удаляем дубли
            $fonts = array_unique( $fonts );

            $list = array();

            foreach ( $fonts as $font ) {
                if ( isset( $this->fonts[$font]['url'] ) ) {
                    $font_name = $this->fonts[$font]['url'];

                    // если есть жирность шрифта
                    if ( ! empty( $this->fonts[$font]['weight'] ) ) {
                        $font_name .= ':' . $this->fonts[$font]['weight'];
                    }
                    $list[] = $font_name;
                }
            }

            if ( ! empty( $list ) ) {
                $fonts_enqueue = implode( '|', $list );
                $fonts_enqueue = 'https://fonts.googleapis.com/css?family=' . $fonts_enqueue . '&amp;subset=cyrillic&amp;display=swap';

                return $fonts_enqueue;
            }
        }
        return '';

    }


    public function get_font_family( $font ) {
        if ( ! empty( $this->fonts[$font] ) ) {
            if ( ! empty( $this->fonts[$font]['family'] ) && $this->fonts[$font]['family'] == 'serif' ) {
                return '"'. $this->fonts[$font]['name'] .'" ,"Georgia", "Times New Roman", "Bitstream Charter", "Times", serif';
            } else {
                return '"'. $this->fonts[$font]['name'] .'" ,"Helvetica Neue", Helvetica, Arial, sans-serif';
            }
        }
        return '';
    }
}