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
 * в комментариях в ответить ссылку убираем
 */
function comment_reply_link_change_to_span( $link ) {
    global $user_ID;

    if ( get_option( 'comment_registration' ) && ! $user_ID )
        return $link;
    else
        $link = str_replace( '<a', '<span', $link );
        $link = str_replace( '</a>', '</span>', $link );
        $link = str_replace( "rel='nofollow'", "", $link );
        $link = str_replace( "rel=\"nofollow\"", "", $link );
        $link = str_replace( 'href=', 'data-href=', $link );
    return $link;
}
add_filter( 'comment_reply_link', 'comment_reply_link_change_to_span' );



/**
 * comment form field order
 */
add_filter( 'comment_form_fields', 'kama_reorder_comment_fields' );
function kama_reorder_comment_fields( $fields ) {
    $new_fields = array(); // сюда соберем поля в новом порядке

    $myorder = array( 'author','email','url','comment' ); // нужный порядок

    foreach( $myorder as $key ){
        if ( isset( $fields[ $key ] ) ) {
            $new_fields[ $key ] = $fields[ $key ];
            unset( $fields[ $key ] );
        }
    }

    // если остались еще какие-то поля добавим их в конец
    if( $fields )
        foreach( $fields as $key => $val )
            $new_fields[ $key ] = $val;

    return $new_fields;
}

                
/**
 * Comments
 */
function vetteo_comment( $comment, $args, $depth ) {
    global $post;
    $GLOBALS['comment'] = $comment; ?>
    
<?php $is_show_comments_date = ( 'yes' == root_get_option( 'comments_date' ) ? true : false ); ?>


<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>" itemprop="comment" itemscope itemtype="http://schema.org/Comment">
    <div class="comment-box" id="comment-<?php comment_ID(); ?>">

        <div class="comment-header">

            <div class="comment-avatar">
                <?php echo get_avatar( $comment,$size='50' ); ?>
            </div>

            <div class="comment-meta">

                <?php
                $comment_url = get_comment_author_url( $comment->user_id );
                if ( ! empty( $comment_url ) ) $microformat_comment_url = ' data-href="' . $comment_url . '"';
                else $microformat_comment_url = '';

                if ( $comment->user_id ) {
                    $userdata = get_userdata( $comment->user_id );
                    if ( ! empty( $comment_url ) ) {
                        echo '<cite class="comment-author spanlink js-link" itemprop="creator"' . $microformat_comment_url . ' data-target="_blank">' . $userdata->display_name . '</cite>';
                    } else {
                        echo '<cite class="comment-author" itemprop="creator">' . $userdata->display_name . '</cite>';
                    }
                } else {

                    if ( ! empty( $comment_url ) ) {
                        echo '<cite class="comment-author spanlink js-link" itemprop="creator"' . $microformat_comment_url . ' data-target="_blank">' . get_comment_author( $comment->user_id ) . '</cite>';
                    } else {
                        echo '<cite class="comment-author" itemprop="creator">' . get_comment_author( $comment->user_id ) . '</cite>';
                    }
                }
                ?>

                <?php if ( $comment->user_id === $post->post_author ) echo '<span class="comment-author-post">(' . __( 'author', THEME_TEXTDOMAIN ) . ')</span>'; ?>
                
                <?php if ( $is_show_comments_date ) { ?>
                    <time class="comment-time" itemprop="datePublished" datetime="<?php comment_date( 'Y-m-d' ) ?>">
                        <?php comment_date( 'd.m.Y' ) ?>
                        <?php if ( apply_filters( THEME_SLUG . '_comments_show_time', true ) ) { ?><?php echo __( 'in', THEME_TEXTDOMAIN ) ?> <?php comment_time( 'H:i' ) ?><?php } ?>
                    </time>
                <?php } ?>
                
            </div>

        </div>

        <div class="comment-body">
            <?php if ( $comment->comment_approved == '0' ) : ?>
                <p><em><?php _e( 'Your comment is awaiting moderation.' ) ?></em></p>
            <?php endif; ?>
            <div class="comment-text" itemprop="text"><?php comment_text() ?></div>
            <div class="comment-footer">
                <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
            </div>
        </div>
    </div>

    <?php
}