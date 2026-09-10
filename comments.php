<?php
/**
 * Comments template.
 *
 * Displays the comment list and comment form.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="lct-comments">

	<?php if ( have_comments() ) : ?>

		<h2 class="lct-comments__title">
			<?php
			$comment_count = get_comments_number();

			if ( '1' === $comment_count ) {
				printf(
					/* translators: %s: post title */
					esc_html__( 'One comment on &ldquo;%s&rdquo;', 'listingcore-theme' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf(
					/* translators: 1: comment count, 2: post title */
					esc_html( _n( '%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $comment_count, 'listingcore-theme' ) ),
					number_format_i18n( $comment_count ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2>

		<ol class="lct-comments__list">
			<?php
			wp_list_comments( [
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 60,
				'callback'    => 'listingcore_theme_comment_callback',
			] );
			?>
		</ol>

		<?php
		the_comments_navigation( [
			'prev_text' => esc_html__( 'Older comments', 'listingcore-theme' ),
			'next_text' => esc_html__( 'Newer comments', 'listingcore-theme' ),
		] );
		?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="lct-comments__closed">
			<?php esc_html_e( 'Comments are closed.', 'listingcore-theme' ); ?>
		</p>

	<?php endif; ?>

	<?php
	comment_form( [
		'class_container'    => 'lct-comment-form',
		'class_form'         => 'lct-comment-form__form',
		'title_reply'        => esc_html__( 'Leave a Comment', 'listingcore-theme' ),
		'title_reply_before' => '<h2 id="reply-title" class="lct-comment-form__title">',
		'title_reply_after'  => '</h2>',
		'comment_notes_before' => '<p class="lct-comment-form__notes">' . esc_html__( 'Your email address will not be published. Required fields are marked *', 'listingcore-theme' ) . '</p>',
		'comment_field'      => sprintf(
			'<p class="lct-comment-form__field"><label for="comment">%1$s</label><textarea id="comment" name="comment" cols="45" rows="6" required aria-required="true"></textarea></p>',
			esc_html__( 'Comment *', 'listingcore-theme' )
		),
		'label_submit'       => esc_html__( 'Post Comment', 'listingcore-theme' ),
		'submit_button'      => '<input name="%1$s" type="submit" id="%2$s" class="%3$s lct-button lct-button--primary" value="%4$s" />',
		'submit_field'       => '<p class="lct-comment-form__submit">%1$s %2$s</p>',
	] );
	?>

</div>