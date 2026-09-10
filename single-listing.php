<?php
/**
 * The template for displaying all single listings
 *
 * @package ListingCoreTheme
 */

get_header(); ?>

<div class="listingcore-breadcrumbs-wrapper">
    <?php if ( function_exists( 'listingcore_theme_breadcrumbs' ) ) {
        listingcore_theme_breadcrumbs();
    } ?>
</div>

<main id="primary" class="site-main listingcore-container" style="max-width: 1200px; margin: 40px auto; padding: 0 20px; display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
    
    <!-- ── MAIN CONTENT AREA ──────────────────────────────── -->
    <section class="listing-main-content">
        <?php while ( have_posts() ) : the_post(); ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class('listingcore-single-view'); ?> style="background: #ffffff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0;">
                
                <header class="listing-header" style="margin-bottom: 24px;">
                    <div class="listing-categories" style="margin-bottom: 10px;">
                        <?php
                        $terms = get_the_terms( get_the_ID(), 'listing_category' );
                        if ( $terms && ! is_wp_error( $terms ) ) :
                            foreach ( $terms as $term ) : ?>
                                <span class="badge-category" style="background: #eff6ff; color: #2563eb; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-right: 8px;">
                                    <?php echo esc_html( $term->name ); ?>
                                </span>
                            <?php endforeach;
                        endif;
                        ?>
                    </div>

                    <h1 class="entry-title" style="font-size: 32px; font-weight: 700; color: #0f172a; margin: 0 0 15px 0;">
                        <?php the_title(); ?>
                    </h1>

                    <?php 
                    // Fetch dynamic metadata matching your approved plugin engine keys
                    $price      = get_post_meta( get_the_ID(), '_listing_price', true );
                    $price_type = get_post_meta( get_the_ID(), '_listing_price_type', true ) ?: 'fixed';
                    $currency   = get_post_meta( get_the_ID(), '_listing_currency', true ) ?: 'INR';
                    
                    if ( $price && function_exists( 'listingcore_theme_format_price' ) ) : ?>
                        <div class="listing-detail-price" style="font-size: 28px; font-weight: 800; color: #10b981; margin-bottom: 15px;">
                            <?php echo listingcore_theme_format_price( $price, $currency, $price_type ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                        </div>
                    <?php endif; ?>
                </header>

                <!-- Featured Image Showcase -->
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="listing-featured-image" style="margin-bottom: 30px; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
                        <?php the_post_thumbnail( 'large', array( 'style' => 'width: 100%; height: auto; display: block;' ) ); ?>
                    </div>
                <?php endif; ?>

                <!-- Core Description Text -->
                <div class="listing-entry-content" style="line-height: 1.8; color: #334155; font-size: 16px;">
                    <h3 style="font-size: 20px; font-weight: 600; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; margin-bottom: 15px;">
                        <?php esc_html_e( 'Description', 'listingcore-theme' ); ?>
                    </h3>
                    <?php the_content(); ?>
                </div>

            </article>

        <?php endwhile; ?>
    </section>

    <!-- ── SIDEBAR CONTEXT AREA ───────────────────────────── -->
    <aside class="listing-sidebar-area">
        <?php 
        $city    = get_post_meta( get_the_ID(), '_listing_city', true );
        $country = get_post_meta( get_the_ID(), '_listing_country', true );
        $location = implode( ', ', array_filter( [ $city, $country ] ) );
        
        if ( $location ) : ?>
            <div class="sidebar-location-block" style="background: #ffffff; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 24px;">
                <h4 style="margin-top: 0; font-size: 16px; color: #0f172a;">📍 <?php esc_html_e( 'Location Details', 'listingcore-theme' ); ?></h4>
                <p style="margin: 5px 0 0 0; color: #475569; font-weight: 500;"><?php echo esc_html( $location ); ?></p>
            </div>
        <?php endif; ?>

        <!-- Contact/Lead Form Integration Section -->
        <div class="sidebar-contact-block" style="background: #ffffff; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 24px;">
            <h4 style="margin-top: 0; font-size: 16px; color: #0f172a; margin-bottom: 15px;">✉️ <?php esc_html_e( 'Contact Owner', 'listingcore-theme' ); ?></h4>
            
            <?php 
            // Natively executes your custom plugin contact form shortcode safely
            echo do_shortcode( '[listingcore_contact_form]' ); 
            ?>
        </div>

        <?php 
        // Falls back onto your multi-segment listing filter sidebar configurations
        if ( is_active_sidebar( 'sidebar-listings' ) ) {
            dynamic_sidebar( 'sidebar-listings' );
        } 
        ?>
    </aside>

</main>

<?php get_footer(); ?>
