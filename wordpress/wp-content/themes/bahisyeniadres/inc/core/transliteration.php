<?php
/**
 * Transliteration class by WPShop.ru
 *
 * @package     WPShop Core
 * @ver         1.0
 * @url         https://wpshop.ru/
 */

if ( ! class_exists( 'Wpshop_Transliteration' ) ):

    /**
     * Transliteration class by WPShop.ru
     */
    class Wpshop_Transliteration {

        /**
         * @var $utf array table of symbols
         */
        private $utf;


        /**
         * constructor.
         */
        public function __construct() {
            $this->set_utf();
        }


        /**
         * General sanitize
         *
         * @param $string
         * @param $file boolean
         *
         * @return mixed|string
         */
        public function transliterate( $string , $file = false ) {

            $string = html_entity_decode($string, ENT_QUOTES, 'utf-8');

            $string = strtr($string, $this->utf);
            $string = strtolower($string);
            $string = preg_replace("/[^A-Za-z0-9-_.]/", '-', $string);
            $string = preg_replace( '~([=+.-])\\1+~' , '\\1', $string);

            if ( ! $file ) {
                $string = str_replace('.', '-', $string);
                $string = preg_replace('/-{2,}/', '-', $string);
            }

            $string = trim($string, '-');

            return $string;

        }


        /**
         * Set utf
         */
        private function set_utf() {

            $this->utf = array(
                'Ä' => 'Ae',
                'ä' => 'ae',
                'Æ' => 'Ae',
                'æ' => 'ae',
                'À' => 'A',
                'à' => 'a',
                'Á' => 'A',
                'á' => 'a',
                'Â' => 'A',
                'â' => 'a',
                'Ã' => 'A',
                'ã' => 'a',
                'Å' => 'A',
                'å' => 'a',
                'ª' => 'a',
                'ₐ' => 'a',
                'ā' => 'a',
                'Ć' => 'C',
                'ć' => 'c',
                'Ç' => 'C',
                'ç' => 'c',
                'Ð' => 'D',
                'đ' => 'd',
                'È' => 'E',
                'è' => 'e',
                'É' => 'E',
                'é' => 'e',
                'Ê' => 'E',
                'ê' => 'e',
                'Ë' => 'E',
                'ë' => 'e',
                'ₑ' => 'e',
                'ƒ' => 'f',
                'ğ' => 'g',
                'Ğ' => 'G',
                'Ì' => 'I',
                'ì' => 'i',
                'Í' => 'I',
                'í' => 'i',
                'Î' => 'I',
                'î' => 'i',
                'Ï' => 'Ii',
                'ï' => 'ii',
                'ī' => 'i',
                'ı' => 'i',
                'I' => 'I',
                'Ñ' => 'N',
                'ñ' => 'n',
                'ⁿ' => 'n',
                'Ò' => 'O',
                'ò' => 'o',
                'Ó' => 'O',
                'ó' => 'o',
                'Ô' => 'O',
                'ô' => 'o',
                'Õ' => 'O',
                'õ' => 'o',
                'Ø' => 'O',
                'ø' => 'o',
                'ₒ' => 'o',
                'Ö' => 'Oe',
                'ö' => 'oe',
                'Œ' => 'Oe',
                'œ' => 'oe',
                'ß' => 'ss',
                'Š' => 'S',
                'š' => 's',
                'ş' => 's',
                'Ş' => 'S',
                'Ù' => 'U',
                'ù' => 'u',
                'Ú' => 'U',
                'ú' => 'u',
                'Û' => 'U',
                'û' => 'u',
                'Ü' => 'Ue',
                'ü' => 'ue',
                'Ý' => 'Y',
                'ý' => 'y',
                'ÿ' => 'y',
                'Ž' => 'Z',
                'ž' => 'z',
                '⁰' => '0',
                '¹' => '1',
                '²' => '2',
                '³' => '3',
                '⁴' => '4',
                '⁵' => '5',
                '⁶' => '6',
                '⁷' => '7',
                '⁸' => '8',
                '⁹' => '9' ,
                '₀' => '0',
                '₁' => '1',
                '₂' => '2',
                '₃' => '3',
                '₄' => '4',
                '₅' => '5',
                '₆' => '6',
                '₇' => '7',
                '₈' => '8',
                '₉' => '9',
                '±' => '-',
                '×' => 'x',
                '₊' => '-',
                '₌' => '=',
                '⁼' => '=',
                '⁻' => '-',
                '₋' => '-',
                '–' => '-',
                '—' => '-',
                '‑' => '-',
                '․' => '.',
                '‥' => '..',
                '…' => '...',
                '‧' => '.',
                ' ' => '-',
                ' ' => '-',
                'А' => 'A',
                'Б' => 'B',
                'В' => 'V',
                'Г' => 'G',
                'Д' => 'D',
                'Е' => 'E',
                'Ё' => 'YO',
                'Ж' => 'ZH',
                'З' => 'Z',
                'И' => 'I',
                'Й' => 'Y',
                'К' => 'K',
                'Л' => 'L',
                'М' => 'M',
                'Н' => 'N',
                'О' => 'O',
                'П' => 'P',
                'Р' => 'R',
                'С' => 'S',
                'Т' => 'T',
                'У' => 'U',
                'Ф' => 'F',
                'Х' => 'H',
                'Ц' => 'TS',
                'Ч' => 'CH',
                'Ш' => 'SH',
                'Щ' => 'SCH',
                'Ъ' => '',
                'Ы' => 'Y',
                'Ь' => '',
                'Э' => 'E',
                'Ю' => 'YU',
                'Я' => 'YA',
                'а' => 'a',
                'б' => 'b',
                'в' => 'v',
                'г' => 'g',
                'д' => 'd',
                'е' => 'e',
                'ё' => 'yo',
                'ж' => 'zh',
                'з' => 'z',
                'и' => 'i',
                'й' => 'y',
                'к' => 'k',
                'л' => 'l',
                'м' => 'm',
                'н' => 'n',
                'о' => 'o',
                'п' => 'p',
                'р' => 'r',
                'с' => 's',
                'т' => 't',
                'у' => 'u',
                'ф' => 'f',
                'х' => 'h',
                'ц' => 'ts',
                'ч' => 'ch',
                'ш' => 'sh',
                'щ' => 'sch',
                'ъ' => '',
                'ы' => 'y',
                'ь' => '',
                'э' => 'e',
                'ю' => 'yu',
                'я' => 'ya'
            );

        }

    }

endif;