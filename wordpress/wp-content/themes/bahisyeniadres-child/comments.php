<?php
/**
 * ****************************************************************************
 *
 *   DON'T EDIT THIS FILE
 *   After update you will lose all changes. Use child theme
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   После обновления Вы потереяете все изменения. Используйте дочернюю тему
 *
 *   https://docs.wpshop.ru/child-themes/
 *
 * *****************************************************************************
 *
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @package root
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<div class="comments-title"><?php echo apply_filters( THEME_SLUG . '_comments_title', __( 'Comments', THEME_TEXTDOMAIN ) ) ?>: <?php echo get_comments_number() ?></div>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-above" class="navigation comment-navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', THEME_TEXTDOMAIN ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', THEME_TEXTDOMAIN ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', THEME_TEXTDOMAIN ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'type'		=> 'comment',
					'style'     => 'ol',
					'callback'	=> 'vetteo_comment',
				) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-below" class="navigation comment-navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', THEME_TEXTDOMAIN ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', THEME_TEXTDOMAIN ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', THEME_TEXTDOMAIN ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-below -->
		<?php
		endif; // Check for comment navigation.

	endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', THEME_TEXTDOMAIN ); ?></p>
	<?php
	endif;



    $commenter = wp_get_current_commenter();
    $req      = get_option( 'require_name_email' );
    $html_req = ( $req ? " required='required'" : '' );
    $html5 = true;
    $consent  = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

    $comment_form_args = array(
        'comment_notes_before' => '',
        'title_reply_before'   => '<div id="reply-title" class="comment-reply-title">',
        'title_reply_after'	   => '</div>',

        'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label> <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea></p>',
        'fields'               => array(
            'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                        '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245" ' . $html_req . ' /></p>',
            'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                        '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" maxlength="100" ' . $html_req  . ' /></p>',
            'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label> ' .
                        '<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" /></p>',
        ),

        /* SHORT FORM WITHOUT LABELS
		'fields'					=> array(
			'author' => '<p class="comment-form-author"><input id="author" name="author" placeholder="Введите имя" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
			'email'  => '<p class="comment-form-email"><input id="email" name="email" placeholder="Введите e-mail" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
			'url'    => '<p class="comment-form-url"><input id="url" name="url" placeholder="Введите сайт (не обяз.)" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
		),
		'comment_field'				=> '<p class="comment-form-comment"><textarea id="comment" name="comment" placeholder="Введите текст" cols="45" rows="6" aria-required="true"></textarea></p>',*/

    );

    $title_comments = root_get_option( 'comments_form_title' );

    if ( ! empty( $title_comments && $title_comments != 'Add a comment' ) ) {
        $comment_form_args['title_reply'] = $title_comments;
    }

    // Text before submit button
    $comments_text_before_submit = root_get_option( 'comments_text_before_submit' );
    if ( ! empty( $comments_text_before_submit ) ) {
        $comment_form_args['comment_notes_after'] = '<div class="comment-notes-after">'. $comments_text_before_submit .'</div>';
    }

    $comment_form_args = apply_filters( THEME_SLUG . '_comment_form_args', $comment_form_args );
	comment_form( $comment_form_args );
	?>

</div><!-- #comments -->