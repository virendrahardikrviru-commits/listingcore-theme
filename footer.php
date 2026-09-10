<?php
/**
 * Site footer.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>

	</div><!-- #content -->

	<?php do_action( 'listingcore_theme_before_footer' ); ?>

	<footer id="colophon" class="lct-footer" role="contentinfo">

		<?php do_action( 'listingcore_theme_footer' ); ?>

	</footer>

	<?php do_action( 'listingcore_theme_after_footer' ); ?>

</div><!-- #page -->

<?php
// Back to top button.
if ( ! is_admin() ) :
	?>
	<button
		type="button"
		class="lct-back-to-top"
		aria-label="<?php esc_attr_e( 'Back to top', 'listingcore-theme' ); ?>"
		hidden
	>
		<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
			<line x1="12" y1="19" x2="12" y2="5"></line>
			<polyline points="5 12 12 5 19 12"></polyline>
		</svg>
	</button>
	<?php
endif;

wp_footer();
?>
</body>
</html>