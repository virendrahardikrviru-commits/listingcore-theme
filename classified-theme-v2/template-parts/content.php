<?php
/**
 * Template part for displaying general fallback content loops
 *
 * @package ListingCoreTheme
 */

defined( 'ABSPATH' ) || exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('listingcore-loop-fallback-item'); ?> style="background: #ffffff; padding: 24px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 20px;">
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title" style="font-size: 28px; margin: 0 0 15px 0; color: #0f172a;">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title" style="font-size: 20px; margin: 0 0 10px 0; font-weight: 700;"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" style="color: #0f172a; text-decoration: none;">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta" style="font-size: 13px; color: #64748b; margin-bottom: 15px;">
				<?php
				printf(
					/* translators: %s: post date. */
					esc_html__( 'Published %s', 'listingcore-theme' ),
					'<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time>'
				);
				?>
			</div>
		<?php endif; ?>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail" style="margin-bottom: 15px; border-radius: 6px; overflow: hidden;">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php the_post_thumbnail( 'medium', array( 'style' => 'max-width: 100%; height: auto; display: block;' ) ); ?>
			</a>
		</div>
	<?php endif; ?>

	<div class="entry-content" style="line-height: 1.6; color: #334155;">
		<?php
		the_excerpt();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'listingcore-theme' ),
			'after'  => '</div>',
		) );
		?>
	</div>
</article>
