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
 * Icons provided free by EmojiOne
 * http://emojione.com/
 */


/**
 * Change path to theme
 */
add_filter( 'smilies_src', THEME_SLUG . '_smilies_src', 10, 3 );
function root_smilies_src( $img_src, $img, $siteurl ) {
    return get_bloginfo( 'template_url' ) . '/images/smilies/' . $img;
}

/**
 * Remove default styles
 */
add_filter( 'the_content', 'remove_style_from_smilies', 11 );
add_filter( 'the_excerpt', 'remove_style_from_smilies', 11 );
add_filter( 'comment_text', 'remove_style_from_smilies', 21 );
function remove_style_from_smilies( $content ) {
    return str_replace( 'class="wp-smiley" style="height: 1em; max-height: 1em;"', 'class="wp-smiley"', $content );
}


/**
 * Set new png images
 */
add_action( 'init', 'images_smilies_init', 1 );

function images_smilies_init() {
    global $wpsmiliestrans;
    $wpsmiliestrans = array(
        ':)'        => 'smile.png',
        ':D'        => 'biggrin.png',
        ':-D'       => 'biggrin.png',
        ':grin:'    => 'biggrin.png',
        ':-)'       => 'smile.png',
        ':smile:'   => 'smile.png',
        ':('        => 'sad.png',
        ':-('       => 'sad.png',
        ':sad:'     => 'sad.png',
        ':o'        => 'surprised.png',
        ':-o'       => 'surprised.png',
        ':eek:'     => 'surprised.png',
        '8O'        => 'eek.png',
        '8-O'       => 'eek.png',
        ':shock:'   => 'eek.png',
        ':?'        => 'confused.png',
        ':-?'       => 'confused.png',
        ':???:'     => 'confused.png',
        '8)'        => 'cool.png',
        '8-)'       => 'cool.png',
        ':cool:'    => 'cool.png',
        ':lol:'     => 'lol.png',
        ':x'        => 'mad.png',
        ':-x'       => 'mad.png',
        ':mad:'     => 'mad.png',
        ':P'        => 'razz.png',
        ':-P'       => 'razz.png',
        ':razz:'    => 'razz.png',
        ':oops:'    => 'redface.png',
        ':cry:'     => 'cry.png',
        ':evil:'    => 'evil.png',
        ':twisted:' => 'twisted.png',
        ':roll:'    => 'rolleyes.png',
        ':wink:'    => 'wink.png',
        ';)'        => 'wink.png',
        ';-)'       => 'wink.png',
        ':!:'       => 'exclaim.png',
        ':?:'       => 'question.png',
        ':idea:'    => 'idea.png',
        ':arrow:'   => 'arrow.png',
        ':|'        => 'neutral.png',
        ':-|'       => 'neutral.png',
        ':neutral:' => 'neutral.png',
        ':mrgreen:' => 'mrgreen.png',
    );
}


/**
 * Place smiles after textarea
 */
add_filter( 'comment_form_field_comment', 'comment_form_field_comment_add_smile' );
function comment_form_field_comment_add_smile( $comment_field ) {
    global $wpsmiliestrans;
    $dm_showsmiles = '';
    $dm_smiled = array();
	$is_show_comments_smiles = ( 'yes' == root_get_option( 'comments_smiles' ) ? true : false );
	
    foreach ( $wpsmiliestrans as $tag => $dm_smile ) {
        if ( ! in_array( $dm_smile,$dm_smiled ) ) {
            $dm_smiled[] = $dm_smile;
            $tag = str_replace( ' ', '', $tag );
            $dm_showsmiles .= '<img src="' . get_template_directory_uri() . '/images/smilies/' . $dm_smile . '" alt="' . $tag . '"> ';
        }
    }

	if ( $is_show_comments_smiles ) {
        $comment_field = $comment_field . '<div class="comment-smiles js-comment-smiles">' . $dm_showsmiles . '</div>';
    }
	
	return $comment_field;
}