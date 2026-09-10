<?php
/**
 * Template part for displaying posts in archives.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'lct-post' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" class="lct-post__thumbnail-link" aria-hidden="true" tabindex="-1">
			<div class="lct-post__thumbnail">
				<?php the_post_thumbnail( 'lct-blog-thumb' ); ?>
			</div>
		</a>
	<?php endif; ?>

	<div class="lct-post__body">

		<header class="lct-post__header">

			<?php
			$categories = get_the_category_list( ', ' );
			if ( $categories ) :
				?>
				<div class="lct-post__categories">
					<?php echo wp_kses_post( $categories ); ?>
				</div>
			<?php endif; ?>

			<h2 class="lct-post__title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>

			<div class="lct-post__meta">
				<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
					<?php echo esc_html( get_the_date() ); ?>
				</time>
				<span class="lct-post__meta-sep">·</span>
				<span class="lct-post__author">
					<?php
					printf(
						/* translators: %s: author name */
						esc_html__( 'By %s', 'listingcore-theme' ),
						esc_html( get_the_author() )
					);
					?>
				</span>
			</div>

		</header>

		<div class="lct-post__excerpt">
			<?php the_excerpt(); ?>
		</div>

		<footer class="lct-post__footer">
			<a href="<?php the_permalink(); ?>" class="lct-button lct-button--outline">
				<?php esc_html_e( 'Read More', 'listingcore-theme' ); ?>
				<span class="screen-reader-text">
					<?php
					printf(
						/* translators: %s: post title */
						esc_html__( 'about %s', 'listingcore-theme' ),
						esc_html( get_the_title() )
					);
					?>
				</span>
			</a>
		</footer>

	</div>

</article>