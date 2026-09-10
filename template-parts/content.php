<?php
/**
 * Template part for displaying posts in archives.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'listingcore-post' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" class="listingcore-post__thumbnail-link" aria-hidden="true" tabindex="-1">
			<div class="listingcore-post__thumbnail">
				<?php the_post_thumbnail( 'listingcore-blog-thumb' ); ?>
			</div>
		</a>
	<?php endif; ?>

	<div class="listingcore-post__body">

		<header class="listingcore-post__header">

			<?php
			$categories = get_the_category_list( ', ' );
			if ( $categories ) :
				?>
				<div class="listingcore-post__categories">
					<?php echo wp_kses_post( $categories ); ?>
				</div>
			<?php endif; ?>

			<h2 class="listingcore-post__title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>

			<div class="listingcore-post__meta">
				<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
					<?php echo esc_html( get_the_date() ); ?>
				</time>
				<span class="listingcore-post__meta-sep">·</span>
				<span class="listingcore-post__author">
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

		<div class="listingcore-post__excerpt">
			<?php the_excerpt(); ?>
		</div>

		<footer class="listingcore-post__footer">
			<a href="<?php the_permalink(); ?>" class="listingcore-button listingcore-button--outline">
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