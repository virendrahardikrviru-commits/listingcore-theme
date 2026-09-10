<?php
/**
 * Single post template.
 *
 * Displays individual blog posts.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="lct-main" role="main">
	<div class="lct-container">

		<?php listingcore_theme_breadcrumbs(); ?>

		<div class="lct-layout <?php echo esc_attr( listingcore_theme_get_layout_class() ); ?>">

			<div class="lct-layout__main">

				<?php
				while ( have_posts() ) :
					the_post();
					?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'lct-single' ); ?>>

						<header class="lct-single__header">

							<?php
							$categories = get_the_category_list( ', ' );
							if ( $categories ) :
								?>
								<div class="lct-single__categories">
									<?php echo wp_kses_post( $categories ); ?>
								</div>
							<?php endif; ?>

							<h1 class="lct-single__title"><?php the_title(); ?></h1>

							<div class="lct-single__meta">
								<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
									<?php echo esc_html( get_the_date() ); ?>
								</time>
								<span class="lct-single__meta-sep">·</span>
								<span class="lct-single__author">
									<?php
									printf(
										/* translators: %s: author name */
										esc_html__( 'By %s', 'listingcore-theme' ),
										esc_html( get_the_author() )
									);
									?>
								</span>
								<?php if ( has_tag() ) : ?>
									<span class="lct-single__meta-sep">·</span>
									<span class="lct-single__tags">
										<?php the_tags( '', ', ' ); ?>
									</span>
								<?php endif; ?>
							</div>

						</header>

						<?php if ( has_post_thumbnail() ) : ?>
							<div class="lct-single__thumbnail">
								<?php the_post_thumbnail( 'lct-blog-thumb' ); ?>
							</div>
						<?php endif; ?>

						<div class="lct-single__content">
							<?php
							the_content();

							wp_link_pages( [
								'before' => '<nav class="lct-page-links"><span class="lct-page-links__label">' . esc_html__( 'Pages:', 'listingcore-theme' ) . '</span>',
								'after'  => '</nav>',
							] );
							?>
						</div>

						<footer class="lct-single__footer">

							<?php
							// Post navigation (previous/next post).
							the_post_navigation( [
								'prev_text' => '<span class="lct-post-nav__label">' . esc_html__( 'Previous', 'listingcore-theme' ) . '</span><span class="lct-post-nav__title">%title</span>',
								'next_text' => '<span class="lct-post-nav__label">' . esc_html__( 'Next', 'listingcore-theme' ) . '</span><span class="lct-post-nav__title">%title</span>',
								'class'     => 'lct-post-nav',
							] );
							?>

							<?php if ( get_edit_post_link() ) : ?>
								<div class="lct-single__edit">
									<?php
									edit_post_link(
										sprintf(
											/* translators: %s: post title */
											esc_html__( 'Edit %s', 'listingcore-theme' ),
											'<span class="screen-reader-text">' . get_the_title() . '</span>'
										),
										'<span class="lct-single__edit-link">',
										'</span>'
									);
									?>
								</div>
							<?php endif; ?>

						</footer>

					</article>

					<?php
					// Comments.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}

				endwhile;
				?>

			</div>

			<?php get_sidebar(); ?>

		</div>

	</div>
</main>

<?php
get_footer();