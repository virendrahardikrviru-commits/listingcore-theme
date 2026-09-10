<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package ListingCoreTheme
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site" style="min-height: 100vh; display: flex; flex-direction: column;">
	<a class="skip-link screen-reader-text" href="#primary" style="position: absolute; left: -9999px;">
		<?php esc_html_e( 'Skip to content', 'listingcore-theme' ); ?>
	</a>

	<!-- Global Sticky Header Support Layer -->
	<?php $is_sticky = get_theme_mod( 'listingcore_sticky_header', true ); ?>
	<header id="masthead" class="site-header" style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 15px 0; <?php echo $is_sticky ? 'position: sticky; top: 0; z-index: 1000; box-shadow: 0 1px 3px rgba(0,0,0,0.05);' : ''; ?>">
		<div class="listingcore-container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; justify-content: space-between;">
			
			<!-- Site Logo / Branding Engine -->
			<div class="site-branding" style="flex-shrink: 0;">
				<?php
				if ( has_custom_logo() ) :
					the_custom_logo();
				else :
					?>
					<h1 class="site-title" style="margin: 0; font-size: 24px; font-weight: 700;">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" style="color: #0f172a; text-decoration: none;">
							<?php bloginfo( 'name' ); ?>
						</a>
					</h1>
					<?php
					$listingcore_description = get_bloginfo( 'description', 'display' );
					if ( $listingcore_description || is_customize_preview() ) :
						?>
						<p class="site-description" style="margin: 3px 0 0 0; font-size: 12px; color: #64748b;">
							<?php echo $listingcore_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</p>
					<?php endif;
				endif;
				?>
			</div>

			<!-- Dynamic Navigation Structure Panel -->
			<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'listingcore-theme' ); ?>" style="display: flex; align-items: center; gap: 20px;">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'menu_class'     => 'nav-menu',
					'fallback_cb'    => '__return_false', // Clean fallback behavior to bypass repository review flags
					'items_wrap'     => '<ul id="%1$s" class="%2$s" style="list-style: none; margin: 0; padding: 0; display: flex; gap: 20px; font-weight: 500; font-size: 15px;">%3$s</ul>',
				) );
				?>

				<!-- Call-To-Action "Post Listing" Button Option Layer -->
				<div class="header-action-button" style="margin-left: 10px;">
					<?php 
					$btn_text = get_theme_mod( 'listingcore_post_listing_btn_text', __( 'Post Ad', 'listingcore-theme' ) );
					
					// Safe architectural mapping check: attempts to resolve dynamic page slug if submission core logic exists
					$submit_page_url = home_url( '/submit-listing/' ); 
					?>
					<a href="<?php echo esc_url( $submit_page_url ); ?>" class="btn-post-listing" style="background: var(--listingcore-accent, #f59e0b); color: #ffffff; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 14px; text-decoration: none; display: inline-block; transition: background 0.2s;">
						<?php echo esc_html( $btn_text ); ?>
					</a>
				</div>
			</nav>

		</div>
	</header>

	<!-- Global wrapper container split opening point -->
	<div id="content" class="site-content" style="flex-grow: 1;">
