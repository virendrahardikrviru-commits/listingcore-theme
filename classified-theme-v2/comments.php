<?php
/**
 * Comments Template
 *
 * @package ClassiPressPro
 */

if ( post_password_required() ) return;
?>

<div id="comments" class="comments-area" style="margin-top:2rem;">

    <?php if ( have_comments() ) : ?>

        <h2 class="comments-title" style="font-size:1.25rem;font-weight:800;margin-bottom:1.5rem;">
            <?php
            $comment_count = get_comments_number();
            if ( '1' === $comment_count ) {
                printf( esc_html__( '1 Comment on %s', 'classipress-pro' ), '<span>' . esc_html( get_the_title() ) . '</span>' );
            } else {
                printf( esc_html( _n( '%1$s Comments on %2$s', '%1$s Comments on %2$s', $comment_count, 'classipress-pro' ) ), number_format_i18n( $comment_count ), '<span>' . esc_html( get_the_title() ) . '</span>' );
            }
            ?>
        </h2>

        <ol class="comment-list" style="list-style:none;display:flex;flex-direction:column;gap:1rem;">
            <?php
            wp_list_comments( [
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 48,
                'callback'    => 'classipress_comment_template',
            ] );
            ?>
        </ol>

        <?php the_comments_navigation(); ?>

    <?php endif; ?>

    <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
        <p class="no-comments" style="text-align:center;color:var(--cp-gray-500);padding:1rem 0;"><?php esc_html_e( 'Comments are closed.', 'classipress-pro' ); ?></p>
    <?php endif; ?>

    <?php
    comment_form( [
        'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title" style="font-size:1.25rem;font-weight:800;margin-bottom:1.5rem;">',
        'title_reply_after'  => '</h3>',
        'class_form'         => 'cp-comment-form',
        'class_submit'       => 'cp-btn cp-btn-primary',
        'submit_button'      => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
    ] );
    ?>

</div>

<?php
if ( ! function_exists( 'classipress_comment_template' ) ) :
function classipress_comment_template( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class( 'cp-comment-item' ); ?> id="comment-<?php comment_ID(); ?>" style="background:var(--cp-white);border:1px solid var(--cp-gray-100);border-radius:var(--cp-border-radius-lg);padding:1.25rem;">
        <div style="display:flex;gap:1rem;">
            <div style="flex-shrink:0;">
                <?php echo get_avatar( $comment, 48, '', get_comment_author(), [ 'style' => 'border-radius:50%;' ] ); ?>
            </div>
            <div style="flex:1;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:.5rem;">
                    <div>
                        <strong><?php comment_author(); ?></strong>
                        <time datetime="<?php comment_date( 'c' ); ?>" style="font-size:.8125rem;color:var(--cp-gray-500);margin-left:.5rem;"><?php comment_date(); ?></time>
                    </div>
                    <?php
                    comment_reply_link( array_merge( $args, [
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'before'    => '<div>',
                        'after'     => '</div>',
                    ] ) );
                    ?>
                </div>
                <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p style="font-style:italic;color:var(--cp-gray-500);"><?php esc_html_e( 'Your comment is awaiting moderation.', 'classipress-pro' ); ?></p>
                <?php endif; ?>
                <div class="comment-content"><?php comment_text(); ?></div>
            </div>
        </div>
    <?php
}
endif;
