<?php
/**
 * Custom widgets.
 *
 * Registers ListingCore Theme custom widgets.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register custom widgets.
 */
function listingcore_theme_register_widgets() {
	register_widget( 'ListingCore_Theme_Recent_Listings_Widget' );
	register_widget( 'ListingCore_Theme_CTA_Widget' );
	register_widget( 'ListingCore_Theme_Stats_Widget' );
}
add_action( 'widgets_init', 'listingcore_theme_register_widgets' );

/**
 * Recent Listings widget.
 *
 * Displays the most recent listings.
 */
class ListingCore_Theme_Recent_Listings_Widget extends WP_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct(
			'listingcore_theme_recent_listings',
			__( 'ListingCore: Recent Listings', 'listingcore-theme' ),
			[
				'description' => __( 'Displays the most recent listings.', 'listingcore-theme' ),
				'classname'   => 'lct-widget lct-widget--recent-listings',
			]
		);
	}

	/**
	 * Front-end display.
	 *
	 * @param array $args     Widget args.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Recent Listings', 'listingcore-theme' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$count = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 5;

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		// Only run if ListingCore plugin is active.
		if ( ! listingcore_theme_has_plugin() ) {
			echo '<p>' . esc_html__( 'Install the ListingCore plugin to display listings.', 'listingcore-theme' ) . '</p>';
			echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return;
		}

		$listings = new WP_Query( [
			'post_type'      => 'listing',
			'posts_per_page' => $count,
			'post_status'    => 'publish',
			'no_found_rows'  => true,
		] );

		if ( $listings->have_posts() ) {
			echo '<ul class="lct-widget__list">';
			while ( $listings->have_posts() ) {
				$listings->the_post();
				printf(
					'<li class="lct-widget__item"><a href="%1$s">%2$s</a></li>',
					esc_url( get_permalink() ),
					esc_html( get_the_title() )
				);
			}
			echo '</ul>';
			wp_reset_postdata();
		} else {
			echo '<p>' . esc_html__( 'No listings found.', 'listingcore-theme' ) . '</p>';
		}

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Admin form.
	 *
	 * @param array $instance Widget instance.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Recent Listings', 'listingcore-theme' );
		$count = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 5;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'listingcore-theme' ); ?>
			</label>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
				type="text"
				value="<?php echo esc_attr( $title ); ?>"
			/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>">
				<?php esc_html_e( 'Number of listings:', 'listingcore-theme' ); ?>
			</label>
			<input
				class="tiny-text"
				id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>"
				type="number"
				min="1"
				max="20"
				value="<?php echo esc_attr( $count ); ?>"
			/>
		</p>
		<?php
	}

	/**
	 * Save instance.
	 *
	 * @param array $new_instance New values.
	 * @param array $old_instance Old values.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] ?? '' );
		$instance['count'] = absint( $new_instance['count'] ?? 5 );

		return $instance;
	}
}

/**
 * Call-to-action widget.
 *
 * Displays a CTA button (e.g. "Post a listing").
 */
class ListingCore_Theme_CTA_Widget extends WP_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct(
			'listingcore_theme_cta',
			__( 'ListingCore: Call to Action', 'listingcore-theme' ),
			[
				'description' => __( 'Displays a call-to-action box with a button.', 'listingcore-theme' ),
				'classname'   => 'lct-widget lct-widget--cta',
			]
		);
	}

	/**
	 * Front-end display.
	 *
	 * @param array $args     Widget args.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$text  = ! empty( $instance['text'] ) ? $instance['text'] : '';
		$label = ! empty( $instance['button_label'] ) ? $instance['button_label'] : __( 'Post a Listing', 'listingcore-theme' );
		$url   = ! empty( $instance['button_url'] ) ? $instance['button_url'] : '#';

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		echo '<div class="lct-cta">';

		if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		if ( $text ) {
			echo '<p class="lct-cta__text">' . esc_html( $text ) . '</p>';
		}

		printf(
			'<a href="%1$s" class="lct-button lct-button--primary">%2$s</a>',
			esc_url( $url ),
			esc_html( $label )
		);

		echo '</div>';

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Admin form.
	 *
	 * @param array $instance Widget instance.
	 */
	public function form( $instance ) {
		$title  = $instance['title'] ?? '';
		$text   = $instance['text'] ?? '';
		$label  = $instance['button_label'] ?? __( 'Post a Listing', 'listingcore-theme' );
		$url    = $instance['button_url'] ?? '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'listingcore-theme' ); ?>
			</label>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
				type="text"
				value="<?php echo esc_attr( $title ); ?>"
			/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>">
				<?php esc_html_e( 'Text:', 'listingcore-theme' ); ?>
			</label>
			<textarea
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"
				rows="3"
			><?php echo esc_textarea( $text ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'button_label' ) ); ?>">
				<?php esc_html_e( 'Button label:', 'listingcore-theme' ); ?>
			</label>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'button_label' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'button_label' ) ); ?>"
				type="text"
				value="<?php echo esc_attr( $label ); ?>"
			/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>">
				<?php esc_html_e( 'Button URL:', 'listingcore-theme' ); ?>
			</label>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'button_url' ) ); ?>"
				type="url"
				value="<?php echo esc_attr( $url ); ?>"
			/>
		</p>
		<?php
	}

	/**
	 * Save instance.
	 *
	 * @param array $new_instance New values.
	 * @param array $old_instance Old values.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                 = $old_instance;
		$instance['title']        = sanitize_text_field( $new_instance['title'] ?? '' );
		$instance['text']         = sanitize_textarea_field( $new_instance['text'] ?? '' );
		$instance['button_label'] = sanitize_text_field( $new_instance['button_label'] ?? '' );
		$instance['button_url']   = esc_url_raw( $new_instance['button_url'] ?? '' );

		return $instance;
	}
}

/**
 * Stats widget.
 *
 * Displays simple listing counts.
 */
class ListingCore_Theme_Stats_Widget extends WP_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct(
			'listingcore_theme_stats',
			__( 'ListingCore: Stats', 'listingcore-theme' ),
			[
				'description' => __( 'Displays listing counts by status.', 'listingcore-theme' ),
				'classname'   => 'lct-widget lct-widget--stats',
			]
		);
	}

	/**
	 * Front-end display.
	 *
	 * @param array $args     Widget args.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Listing Stats', 'listingcore-theme' );

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		if ( ! listingcore_theme_has_plugin() ) {
			echo '<p>' . esc_html__( 'Install the ListingCore plugin to display stats.', 'listingcore-theme' ) . '</p>';
			echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return;
		}

		$counts = wp_count_posts( 'listing' );
		$total  = isset( $counts->publish ) ? absint( $counts->publish ) : 0;

		printf(
			'<div class="lct-stats"><div class="lct-stat"><span class="lct-stat__number">%1$s</span><span class="lct-stat__label">%2$s</span></div></div>',
			esc_html( number_format_i18n( $total ) ),
			esc_html__( 'Active Listings', 'listingcore-theme' )
		);

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Admin form.
	 *
	 * @param array $instance Widget instance.
	 */
	public function form( $instance ) {
		$title = $instance['title'] ?? __( 'Listing Stats', 'listingcore-theme' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'listingcore-theme' ); ?>
			</label>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
				type="text"
				value="<?php echo esc_attr( $title ); ?>"
			/>
		</p>
		<?php
	}

	/**
	 * Save instance.
	 *
	 * @param array $new_instance New values.
	 * @param array $old_instance Old values.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] ?? '' );

		return $instance;
	}
}