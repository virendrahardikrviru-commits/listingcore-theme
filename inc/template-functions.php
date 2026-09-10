<?php
/**
 * Template functions and helpers.
 *
 * Reusable presentation helpers used across the theme templates.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get the site logo or fallback text.
 */
function listingcore_theme_site_logo() {
	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}

	printf(
		'<a href="%1$s" class="lct-site-title" rel="home">%2$s</a>',
		esc_url( home_url( '/' ) ),
		esc_html( get_bloginfo( 'name' ) )
	);
}

/**
 * Get the site tagline.
 *
 * @return string
 */
function listingcore_theme_site_tagline() {
	$description = get_bloginfo( 'description', 'display' );

	if ( empty( $description ) ) {
		return '';
	}

	return sprintf(
		'<p class="lct-site-description">%s</p>',
		esc_html( $description )
	);
}

/**
 * Display the primary navigation menu.
 */
function listingcore_theme_primary_nav() {
	if ( ! has_nav_menu( 'primary' ) ) {
		return;
	}

	wp_nav_menu( [
		'theme_location'  => 'primary',
		'container'       => 'nav',
		'container_class' => 'lct-nav lct-nav--primary',
		'menu_class'      => 'lct-menu',
		'depth'           => 3,
		'fallback_cb'     => false,
	] );
}

/**
 * Display the mobile navigation menu.
 */
function listingcore_theme_mobile_nav() {
	if ( ! has_nav_menu( 'mobile' ) ) {
		return;
	}

	wp_nav_menu( [
		'theme_location'  => 'mobile',
		'container'       => 'nav',
		'container_class' => 'lct-nav lct-nav--mobile',
		'menu_class'      => 'lct-menu lct-menu--mobile',
		'depth'           => 2,
		'fallback_cb'     => false,
	] );
}

/**
 * Display the footer navigation menu.
 */
function listingcore_theme_footer_nav() {
	if ( ! has_nav_menu( 'footer' ) ) {
		return;
	}

	wp_nav_menu( [
		'theme_location'  => 'footer',
		'container'       => 'nav',
		'container_class' => 'lct-nav lct-nav--footer',
		'menu_class'      => 'lct-menu lct-menu--footer',
		'depth'           => 1,
		'fallback_cb'     => false,
	] );
}

/**
 * Get the post thumbnail URL with fallback.
 *
 * @param int    $post_id Post ID.
 * @param string $size    Image size.
 * @return string
 */
function listingcore_theme_get_thumbnail_url( $post_id = 0, $size = 'lct-listing-grid' ) {
	$post_id = $post_id ? $post_id : get_the_ID();

	if ( has_post_thumbnail( $post_id ) ) {
		$url = get_the_post_thumbnail_url( $post_id, $size );

		if ( $url ) {
			return $url;
		}
	}

	return LISTINGCORE_THEME_URI . '/assets/images/placeholder.jpg';
}

/**
 * Render the post thumbnail or a fallback placeholder.
 *
 * @param int    $post_id Post ID.
 * @param string $size    Image size.
 * @param array  $attr    Extra attributes.
 */
function listingcore_theme_post_thumbnail( $post_id = 0, $size = 'lct-listing-grid', $attr = [] ) {
	$post_id = $post_id ? $post_id : get_the_ID();

	if ( has_post_thumbnail( $post_id ) ) {
		echo get_the_post_thumbnail(
			$post_id,
			$size,
			wp_parse_args( $attr, [ 'loading' => 'lazy' ] )
		);
		return;
	}

	printf(
		'<img src="%1$s" alt="%2$s" loading="lazy" class="lct-placeholder" />',
		esc_url( LISTINGCORE_THEME_URI . '/assets/images/placeholder.jpg' ),
		esc_attr__( 'No image available', 'listingcore-theme' )
	);
}

/**
 * Get breadcrumb trail.
 */
function listingcore_theme_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}

	$items   = [];
	$items[] = sprintf(
		'<a href="%s">%s</a>',
		esc_url( home_url( '/' ) ),
		esc_html__( 'Home', 'listingcore-theme' )
	);

	if ( is_singular() ) {
		$items[] = sprintf( '<span>%s</span>', esc_html( get_the_title() ) );
	} elseif ( is_archive() ) {
		$items[] = sprintf( '<span>%s</span>', esc_html( get_the_archive_title() ) );
	} elseif ( is_search() ) {
		$items[] = sprintf(
			'<span>%s</span>',
			sprintf(
				/* translators: %s: search query */
				esc_html__( 'Search: %s', 'listingcore-theme' ),
				esc_html( get_search_query() )
			)
		);
	}

	echo '<nav class="lct-breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'listingcore-theme' ) . '">';
	echo '<ol class="lct-breadcrumbs__list">';
	foreach ( $items as $item ) {
		echo '<li class="lct-breadcrumbs__item">' . wp_kses_post( $item ) . '</li>';
	}
	echo '</ol>';
	echo '</nav>';
}

/**
 * Pagination wrapper.
 */
function listingcore_theme_pagination() {
	the_posts_pagination( [
		'mid_size'           => 2,
		'prev_text'          => esc_html__( 'Previous', 'listingcore-theme' ),
		'next_text'          => esc_html__( 'Next', 'listingcore-theme' ),
		'screen_reader_text' => esc_html__( 'Posts navigation', 'listingcore-theme' ),
		'class'              => 'lct-pagination',
	] );
}

/**
 * Check if the ListingCore plugin is active.
 *
 * @return bool
 */
function listingcore_theme_has_plugin() {
	return class_exists( 'ListingCore\\Core\\Plugin' );
}

/**
 * Display a notice when the ListingCore plugin is not active.
 *
 * Only shown to logged-in administrators.
 */
function listingcore_theme_plugin_missing_notice() {
	if ( listingcore_theme_has_plugin() ) {
		return;
	}

	if ( ! current_user_can( 'install_plugins' ) ) {
		return;
	}

	printf(
		'<div class="lct-plugin-notice">%s</div>',
		esc_html__( 'This theme works best with the ListingCore plugin. Some features may not be available until the plugin is installed.', 'listingcore-theme' )
	);
}

/**
 * Get the current year for copyright.
 *
 * @return string
 */
function listingcore_theme_current_year() {
	return esc_html( gmdate( 'Y' ) );
}

/**
 * Get the layout class based on customizer settings.
 *
 * @return string
 */
function listingcore_theme_get_layout_class() {
	$sidebar_position = get_theme_mod( 'listingcore_theme_sidebar_position', 'right' );

	$classes = [ 'lct-layout--sidebar-' . $sidebar_position ];

	if ( 'none' === $sidebar_position ) {
		$classes[] = 'lct-layout--no-sidebar';
	}

	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'lct-layout--no-widgets';
	}

	return implode( ' ', $classes );
}

/**
 * Custom comment callback.
 *
 * Renders each comment with theme markup.
 *
 * @param WP_Comment $comment Comment object.
 * @param array      $args    Comment args.
 * @param int        $depth   Depth of comment.
 */
function listingcore_theme_comment_callback( $comment, $args, $depth ) {
	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'lct-comment' ); ?>>

		<article class="lct-comment__body">

			<header class="lct-comment__header">

				<div class="lct-comment__avatar">
					<?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
				</div>

				<div class="lct-comment__meta">
					<span class="lct-comment__author">
						<?php echo wp_kses_post( get_comment_author_link( $comment ) ); ?>
					</span>

					<time class="lct-comment__date" datetime="<?php echo esc_attr( get_comment_date( DATE_W3C, $comment ) ); ?>">
						<?php
						printf(
							/* translators: %s: comment date */
							esc_html__( '%s ago', 'listingcore-theme' ),
							esc_html( human_time_diff( get_comment_time( 'U', true, $comment ), current_time( 'timestamp' ) ) )
						);
						?>
					</time>

					<?php if ( '0' === $comment->comment_approved ) : ?>
						<span class="lct-comment__awaiting">
							<?php esc_html_e( 'Your comment is awaiting moderation.', 'listingcore-theme' ); ?>
						</span>
					<?php endif; ?>
				</div>

			</header>

			<div class="lct-comment__content">
				<?php comment_text( $comment ); ?>
			</div>

			<footer class="lct-comment__footer">
				<?php
				comment_reply_link( array_merge( $args, [
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<span class="lct-comment__reply">',
					'after'     => '</span>',
				] ), $comment );
				?>
			</footer>

		</article>

	<?php
	// Note: closing </li> is added by WordPress automatically.
}