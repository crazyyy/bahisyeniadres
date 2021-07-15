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
 * URLSPAN
 */

/* замена ссылок на боки span */
if ( ! function_exists( 'pseudo_replace_link' ) ) {
    function pseudo_replace_link( $content ) {
        $pattern = '/\[mask_link\](.*?)<a (.*?)href=[\"\']([a-zA-Z]+:\/\/)?(.*?)[\"\'](.*?)>(.*?)<\/a>(.*?)\[\/mask_link\]/i';

        //$content = preg_replace( $pattern, "$1<span class='pseudo-link js-link' data-href=\"$3$4\" $5>$6</span>$7", $content );
        $content = preg_replace_callback( $pattern, 'pseudo_replace_link_callback', $content, -1, $count );

        return $content;
    }
    add_filter( 'the_content', 'pseudo_replace_link' );
    add_filter( 'term_description', 'pseudo_replace_link' );

    function pseudo_replace_link_callback( $match ){
        // удалить классы во втором и пятом
        $class = '';
        if ( mb_substr_count( $match[2], 'class=' ) ) {
            preg_match( '/class="(.+?)"/', $match[2], $class_match );
            $class = ' ' . $class_match[1];
            $match[2] = preg_replace( '/class="(.+?)"/', '', $match[2] );
        }
        if ( mb_substr_count( $match[5], 'class=' ) ) {
            preg_match( '/class="(.+?)"/', $match[5], $class_match );
            $class = ' ' . $class_match[5];
            $match[5] = preg_replace( '/class="(.+?)"/', '', $match[5] );
        }

        // base64 для ссылки
        $href = $match[3] . $match[4];
        $href = do_shortcode( $href );
        $href = htmlspecialchars_decode( $href );
        $href = base64_encode( $href );

        // replace target on data-target
        $match[2] = str_replace( 'target="_blank"', 'data-target="_blank"', $match[2] );
        $match[5] = str_replace( 'target="_blank"', 'data-target="_blank"', $match[5] );

        $return = $match[1] . '<span '. $match[2] .' class="root-pseudo-link js-link'. $class .'" data-href="'. $href .'" '. $match[5] .'>'. $match[6] .'</span>' . $match[7];
        return $return;
    }
}


/* замена ссылок на боки span */
if ( ! function_exists( 'urlspan_replace_link' ) ) {
    function urlspan_replace_link( $content ) {
        $pattern = '/\[urlspan\](.*?)<a (.*?)href=[\"\']([a-zA-Z]+:\/\/)?(.*?)[\"\'](.*?)>(.*?)<\/a>(.*?)\[\/urlspan\]/i';
        $content = preg_replace( $pattern, "$1<span class='spanlink' onclick=\"GoTo('_$4')\"><span>$6</span></span>$7", $content );
        return $content;
    }
    add_filter( 'the_content', 'urlspan_replace_link' );
}