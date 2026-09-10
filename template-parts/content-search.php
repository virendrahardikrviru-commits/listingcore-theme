<?php
/**
 * Template part for displaying search results.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$listingcore_theme_post_type = get_post_type();
$listingcore_theme_type_obj  = get_post_type_object( $listingcore_theme_post_type );
$listingcore_theme_type_name = $listingcore_theme_type_obj
	? $listingcore_theme_type_obj->labels->singular_name
	: __( 'Result', 'listingcore-theme' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'lct-search-result' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" class="lct-search-result__thumbnail-link" aria-hidden="true" tabindex="-1">
			<div class="lct-search-result__thumbnail">
				<?php the_post_thumbnail( 'lct-listing-grid' ); ?>
			</div>
		</a>
	<?php endif; ?>

	<div class="lct-search-result__body">

		<header class="lct-search-result__header">

			<span class="lct-search-result__type-badge">
				<?php echo esc_html( $listingcore_theme_type_name ); ?>
			</span>

			<h2 class="lct-search-result__title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>

			<?php if ( 'post' === $listingcore_theme_post_type ) : ?>
				<div class="lct-search-result__meta">
					<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
						<?php echo esc_html( get_the_date() ); ?>
					</time>
					<span class="lct-search-result__meta-sep">·</span>
					<span class="lct-search-result__author">
						<?php
						printf(
							/* translators: %s: author name */
							esc_html__( 'By %s', 'listingcore-theme' ),
							esc_html( get_the_author() )
						);
						?>
					</span>
				</div>
			<?php endif; ?>

		</header>

		<div class="lct-search-result__excerpt">
			<?php the_excerpt(); ?>
		</div>

		<footer class="lct-search-result__footer">
			<a href="<?php the_permalink(); ?>" class="lct-search-result__link">
				<?php
				printf(
					/* translators: %s: post type name */
					esc_html__( 'View %s', 'listingcore-theme' ),
					esc_html( strtolower( $listingcore_theme_type_name ) )
				);
				?>
				<span class="screen-reader-text">
					<?php
					printf(
						/* translators: %s: post title */
						esc_html__( ': %s', 'listingcore-theme' ),
						esc_html( get_the_title() )
					);
					?>
				</span>
				<span class="lct-search-result__arrow" aria-hidden="true">→</span>
			</a>
		</footer>

	</div>

</article>