<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package ListingCoreTheme
 */

defined( 'ABSPATH' ) || exit;
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" style="background: #0f172a; color: #94a3b8; padding: 60px 0 30px 0; margin-top: auto; border-top: 1px solid #1e293b;">
		
		<!-- ── FOOTER WIDGET AREAS ───────────────────────────── -->
		<div class="footer-widgets-grid listingcore-container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; padding-bottom: 40px; border-bottom: 1px solid #1e293b;">
			
			<!-- Column 1 -->
			<div class="footer-column">
				<?php if ( is_active_sidebar( 'footer-sidebar-1' ) ) : ?>
					<?php dynamic_sidebar( 'footer-sidebar-1' ); ?>
				<?php else : ?>
					<h3 style="color: #ffffff; font-size: 16px; margin-bottom: 15px;"><?php bloginfo( 'name' ); ?></h3>
					<p style="font-size: 14px; line-height: 1.6; margin: 0; color: #64748b;">
						<?php echo esc_html( get_bloginfo( 'description' ) ); ?>
					</p>
				<?php endif; ?>
			</div>

			<!-- Column 2 -->
			<div class="footer-column">
				<?php if ( is_active_sidebar( 'footer-sidebar-2' ) ) : ?>
					<?php dynamic_sidebar( 'footer-sidebar-2' ); ?>
				<?php else : ?>
					<h3 style="color: #ffffff; font-size: 16px; margin-bottom: 15px;"><?php esc_html_e( 'Quick Links', 'listingcore-theme' ); ?></h3>
					<p style="font-size: 13px; color: #64748b; margin: 0;">
						<?php esc_html_e( 'Go to Appearance > Widgets to place your customized menu structures here.', 'listingcore-theme' ); ?>
					</p>
				<?php endif; ?>
			</div>

		</div>

		<!-- ── FOOTER BOTTOM BAR ────────────────────────────── -->
		<div class="footer-bottom listingcore-container" style="max-width: 1200px; margin: 0 auto; padding: 30px 20px 0 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
			
			<!-- Copyright Text Block Parser -->
			<div class="site-info" style="font-size: 14px; color: #64748b;">
				<?php
				$copyright_template = get_theme_mod( 'listingcore_footer_copyright', '© {year} ListingCore. All rights reserved.' );
				// Natively handles swapping the year parameter dynamically
				$copyright_output   = str_replace( '{year}', date( 'Y' ), $copyright_template );
				echo wp_kses_post( $copyright_output );
				?>
			</div>

			<!-- Social Links Vector Layer -->
			<div class="footer-social-links" style="display: flex; gap: 15px;">
				<?php
				$networks = array(
					'facebook'  => array( 'icon' => 'Facebook',  'mod' => 'listingcore_footer_facebook' ),
					'twitter'   => array( 'icon' => 'Twitter/X', 'mod' => 'listingcore_footer_twitter' ),
					'instagram' => array( 'icon' => 'Instagram','mod' => 'listingcore_footer_instagram' ),
					'linkedin'  => array( 'icon' => 'LinkedIn',  'mod' => 'listingcore_footer_linkedin' ),
					'youtube'   => array( 'icon' => 'YouTube',   'mod' => 'listingcore_footer_youtube' ),
				);

				foreach ( $networks as $key => $data ) :
					$url = get_theme_mod( $data['mod'], '' );
					if ( ! empty( $url ) ) : ?>
						<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" style="color: #64748b; font-size: 14px; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#64748b'">
							<?php echo esc_html( $data['icon'] ); ?>
						</a>
					<?php endif;
				endforeach;
				?>
			</div>

		</div>
	</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
