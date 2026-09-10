<?php
/**
 * The front page template file
 *
 * @package ListingCoreTheme
 */

get_header(); ?>

<!-- ── HERO SEARCH AREA BLOCK ─────────────────────────── -->
<?php
$hero_title    = get_theme_mod( 'listingcore_hero_title', __( 'Find What You Need, Sell What You Have', 'listingcore-theme' ) );
$hero_subtitle = get_theme_mod( 'listingcore_hero_subtitle', __( 'Browse thousands of local classified ads. Post your own for free.', 'listingcore-theme' ) );
$hero_bg       = get_theme_mod( 'listingcore_hero_bg_image', '' );
$bg_style      = ! empty( $hero_bg ) ? 'background-image: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.7)), url(' . esc_url( $hero_bg ) . ');' : 'background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);';
?>

<section class="listingcore-hero-section" style="<?php echo $bg_style; ?> padding: 100px 20px; text-align: center; color: #ffffff; background-position: center; background-size: cover;">
    <div style="max-width: 800px; margin: 0 auto;">
        <h1 style="font-size: 42px; font-weight: 800; margin-top: 0; margin-bottom: 20px; line-height: 1.2;">
            <?php echo esc_html( $hero_title ); ?>
        </h1>
        <p style="font-size: 18px; color: #94a3b8; margin-top: 0; margin-bottom: 40px; line-height: 1.6;">
            <?php echo esc_html( $hero_subtitle ); ?>
        </p>

        <!-- Dynamic Multi-Segment Form Search Bar Engine -->
        <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="background: #ffffff; padding: 8px; border-radius: 50px; display: flex; align-items: center; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2); max-width: 650px; margin: 0 auto;">
            <input type="hidden" name="post_type" value="listingcore">
            <div style="flex-grow: 1; display: flex; align-items: center; padding-left: 15px;">
                <span style="color: #64748b; margin-right: 10px;">🔍</span>
                <input type="search" name="s" placeholder="<?php esc_attr_e( 'What are you searching for today?...', 'listingcore-theme' ); ?>" style="border: 0; width: 100%; outline: none; font-size: 16px; color: #0f172a;">
            </div>
            <button type="submit" style="background: var(--listingcore-primary, #1a56db); color: #ffffff; border: 0; padding: 12px 28px; border-radius: 50px; font-weight: 600; font-size: 16px; cursor: pointer; transition: background 0.2s;">
                <?php esc_html_e( 'Search', 'listingcore-theme' ); ?>
            </button>
        </form>
    </div>
</section>

<!-- ── MAIN LANDING RESULTS BODY GRID ──────────────────── -->
<main id="primary" class="site-main listingcore-container" style="max-width: 1200px; margin: 60px auto; padding: 0 20px;">
    
    <!-- Dynamic Taxonomies/Segments Showcase -->
    <?php if ( get_theme_mod( 'listingcore_show_featured_cats', true ) ) : ?>
        <section class="featured-segments-section" style="margin-bottom: 60px;">
            <h2 style="font-size: 24px; font-weight: 700; color: #0f172a; margin-top: 0; margin-bottom: 24px; text-align: center;">
                <?php esc_html_e( 'Browse by Marketplace Segments', 'listingcore-theme' ); ?>
            </h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
                <?php
                $segments = get_terms( array(
                    'taxonomy'   => 'listing_category',
                    'number'     => 6,
                    'orderby'    => 'count',
                    'order'      => 'DESC',
                    'hide_empty' => false,
                ) );

                if ( ! is_wp_error( $segments ) && ! empty( $segments ) ) :
                    foreach ( $segments as $segment ) : ?>
                        <a href="<?php echo esc_url( get_term_link( $segment ) ); ?>" style="background: #ffffff; padding: 24px; border-radius: 12px; border: 1px solid #e2e8f0; text-align: center; text-decoration: none; color: #0f172a; font-weight: 600; transition: all 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.02);" onmouseover="this.style.borderColor='var(--listingcore-primary, #1a56db)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.transform='none';">
                            <div style="font-size: 28px; margin-bottom: 10px;">📁</div>
                            <div><?php echo esc_html( $segment->name ); ?></div>
                            <div style="font-size: 12px; color: #64748b; font-weight: 400; margin-top: 4px;"><?php printf( _n( '%s Listing', '%s Listings', $segment->count, 'listingcore-theme' ), number_format_i18n( $segment->count ) ); ?></div>
                        </a>
                    <?php endforeach;
                else : ?>
                    <div style="grid-column: 1 / -1; text-align: center; color: #64748b; font-style: italic;">
                        <?php esc_html_e( 'No marketplace categories populated yet.', 'listingcore-theme' ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Recent Listings Showcase Grid Block -->
    <section class="recent-listings-section">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
            <h2 style="font-size: 24px; font-weight: 700; color: #0f172a; margin: 0;">
                <?php esc_html_e( 'Recently Added Listings', 'listingcore-theme' ); ?>
            </h2>
            <?php 
            $archive_link = get_post_type_archive_link( 'listingcore' );
            if ( $archive_link ) : ?>
                <a href="<?php echo esc_url( $archive_link ); ?>" style="color: var(--listingcore-primary, #1a56db); font-weight: 600; text-decoration: none; font-size: 15px;">
                    <?php esc_html_e( 'View All Listings →', 'listingcore-theme' ); ?>
                </a>
            <?php endif; ?>
        </div>

        <?php
        $per_page = get_theme_mod( 'listingcore_listings_per_page', 12 );
        $recent_query = new WP_Query( array(
            'post_type'      => 'listingcore',
            'posts_per_page' => absint( $per_page ),
            'post_status'    => 'publish',
        ) );

        if ( $recent_query->have_posts() ) : ?>
            <div class="listingcore-grid-view" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                <?php
                while ( $recent_query->have_posts() ) : $recent_query->the_post();
                    
                    if ( function_exists( 'listingcore_theme_listing_card' ) ) {
                        listingcore_theme_listing_card( get_the_ID() );
                    } else {
                        ?>
                        <article style="background:#fff; padding:20px; border-radius:8px; border:1px solid #e2e8f0;">
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <?php the_excerpt(); ?>
                        </article>
                        <?php
                    }

                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        <?php else : ?>
            <div style="background: #ffffff; padding: 40px; border-radius: 12px; border: 1px solid #e2e8f0; text-align: center; color: #64748b;">
                <p style="margin: 0 0 20px 0; font-size: 16px;"><?php esc_html_e( 'No classified listings have been published yet.', 'listingcore-theme' ); ?></p>
                <a href="<?php echo esc_url( home_url( '/submit-listing/' ) ); ?>" style="background: var(--listingcore-accent, #f59e0b); color: #ffffff; padding: 10px 20px; border-radius: 6px; font-weight: 600; text-decoration: none; display: inline-block;">
                    <?php esc_html_e( 'Be the First to Post!', 'listingcore-theme' ); ?>
                </a>
            </div>
        <?php endif; ?>
    </section>

</main>

<?php get_footer(); ?>
