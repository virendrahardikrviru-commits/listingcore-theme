<?php
/**
 * Search form template.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$listingcore_theme_search_id = wp_unique_id( 'search-form-' );

$listingcore_theme_aria_label = ! empty( $args['aria_label'] )
	? $args['aria_label']
	: __( 'Search', 'listingcore-theme' );
?>

<form
	role="search"
	method="get"
	class="lct-searchform"
	action="<?php echo esc_url( home_url( '/' ) ); ?>"
	aria-label="<?php echo esc_attr( $listingcore_theme_aria_label ); ?>"
>
	<label for="<?php echo esc_attr( $listingcore_theme_search_id ); ?>" class="screen-reader-text">
		<?php esc_html_e( 'Search for:', 'listingcore-theme' ); ?>
	</label>

	<div class="lct-searchform__field">
		<input
			type="search"
			id="<?php echo esc_attr( $listingcore_theme_search_id ); ?>"
			class="lct-searchform__input"
			name="s"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="<?php esc_attr_e( 'Search…', 'listingcore-theme' ); ?>"
			required
		/>

		<button
			type="submit"
			class="lct-searchform__submit"
			aria-label="<?php esc_attr_e( 'Submit search', 'listingcore-theme' ); ?>"
		>
			<svg
				width="20"
				height="20"
				viewBox="0 0 24 24"
				fill="none"
				stroke="currentColor"
				stroke-width="2"
				stroke-linecap="round"
				stroke-linejoin="round"
				aria-hidden="true"
			>
				<circle cx="11" cy="11" r="8"></circle>
				<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
			</svg>
		</button>
	</div>
</form>