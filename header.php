<?php
/**
 * Site header.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="listingcore-site">

	<?php do_action( 'listingcore_theme_before_header' ); ?>

	<header id="masthead" class="listingcore-header" role="banner">
		<div class="listingcore-container">

			<div class="listingcore-header__inner">

				<!-- Site Branding -->
				<div class="listingcore-header__branding">
					<?php if ( has_custom_logo() ) : ?>
						<div class="listingcore-header__logo">
							<?php the_custom_logo(); ?>
						</div>
					<?php else : ?>
						<div class="listingcore-header__site-info">
							<?php if ( is_front_page() && is_home() ) : ?>
								<h1 class="listingcore-site-title">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
										<?php bloginfo( 'name' ); ?>
									</a>
								</h1>
							<?php else : ?>
								<p class="listingcore-site-title">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
										<?php bloginfo( 'name' ); ?>
									</a>
								</p>
							<?php endif; ?>

							<?php
							$description = get_bloginfo( 'description', 'display' );
							if ( $description ) :
								?>
								<p class="listingcore-site-description"><?php echo esc_html( $description ); ?></p>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>

				<!-- Primary Navigation -->
				<nav id="site-navigation" class="listingcore-header__nav" aria-label="<?php esc_attr_e( 'Primary Menu', 'listingcore-theme' ); ?>">
					<?php
					if ( has_nav_menu( 'primary' ) ) {
						wp_nav_menu( [
							'theme_location' => 'primary',
							'container'      => false,
							'menu_class'     => 'listingcore-menu listingcore-menu--primary',
							'depth'          => 3,
							'fallback_cb'    => false,
							'walker'         => new ListingCore_Theme_Walker_Nav_Menu(),
						] );
					}
					?>
				</nav>

				<!-- Header Actions -->
				<div class="listingcore-header__actions">
					<?php if ( listingcore_theme_has_plugin() ) : ?>

						<!-- Search toggle -->
						<button
							type="button"
							class="listingcore-header__search-toggle"
							aria-label="<?php esc_attr_e( 'Toggle search', 'listingcore-theme' ); ?>"
							aria-expanded="false"
							aria-controls="listingcore-header-search"
						>
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
								<circle cx="11" cy="11" r="8"></circle>
								<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
							</svg>
						</button>

						<!-- Wishlist link -->
						<a href="<?php echo esc_url( home_url( '/wishlist/' ) ); ?>" class="listingcore-header__wishlist" aria-label="<?php esc_attr_e( 'View wishlist', 'listingcore-theme' ); ?>">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
								<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
							</svg>
						</a>

						<!-- Post listing button -->
						<a href="<?php echo esc_url( home_url( '/submit-listing/' ) ); ?>" class="listingcore-button listingcore-button--primary listingcore-button--sm">
							<?php esc_html_e( 'Post a Listing', 'listingcore-theme' ); ?>
						</a>

					<?php endif; ?>

					<!-- Mobile menu toggle -->
					<?php if ( has_nav_menu( 'mobile' ) || has_nav_menu( 'primary' ) ) : ?>
						<button
							type="button"
							class="listingcore-header__menu-toggle"
							aria-label="<?php esc_attr_e( 'Toggle menu', 'listingcore-theme' ); ?>"
							aria-expanded="false"
							aria-controls="site-navigation"
						>
							<span class="listingcore-header__menu-icon" aria-hidden="true"></span>
						</button>
					<?php endif; ?>
				</div>

			</div>

			<!-- Expandable search -->
			<?php if ( listingcore_theme_has_plugin() ) : ?>
				<div id="listingcore-header-search" class="listingcore-header__search" hidden>
					<?php echo do_shortcode( '[listingcore_search_form]' ); ?>
				</div>
			<?php endif; ?>

		</div>
	</header>

	<?php do_action( 'listingcore_theme_after_header' ); ?>

	<div id="content" class="listingcore-content">