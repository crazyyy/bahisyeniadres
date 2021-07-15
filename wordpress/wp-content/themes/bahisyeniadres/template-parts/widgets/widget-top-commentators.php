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
 * @package root
 */

global $comment_author_name;
global $comment_author_email;
global $comment_author_url;
global $comment_author_count;

?>

<li class="top-commentators__item">
    <?php if ( ! empty( $comment_author_email ) ) : ?>
        <div class="top-commentators__ava">
            <?php
            if ( ! empty( $comment_author_url ) ) {
                echo '<span class="js-link" data-href="' . $comment_author_url . '" data-target="_blank">' . get_avatar( $comment_author_email, 60 ) . '</span>';
            } else {
                echo get_avatar( $comment_author_email, 60 );
            }
            ?>
        </div>
    <?php endif; ?>

    <?php if ( ! empty( $comment_author_name ) ) : ?>
        <div class="top-commentators__name">
            <?php
            if ( ! empty( $comment_author_url ) ) {
                echo '<span class="js-link" data-href="' . $comment_author_url . '" data-target="_blank">' . $comment_author_name . '</span>';
            } else {
                echo $comment_author_name;
            }
            ?>
        </div>
    <?php endif; ?>

    <?php if ( ! empty( $comment_author_count ) ) : ?>
        <div class="top-commentators__count">
            <span class="meta-comments"><?php echo $comment_author_count ?></span>
        </div>
    <?php endif; ?>
</li>