<?php
/**
 * The template for displaying listing archives
 *
 * @package ListingCoreTheme
 */

get_header(); ?>

<div class="listingcore-breadcrumbs-wrapper">
    <?php if ( function_exists( 'listingcore_theme_breadcrumbs' ) ) {
        listingcore_theme_breadcrumbs();
    } ?>
</div>

<main id="primary" class="site-main listingcore-container" style="max-width: 1200px; margin: 40px auto; padding: 0 20px; display: grid; grid-template-columns: 1fr 3fr; gap: 30px;">
    
    <!-- ── FILTER SIDEBAR AREA ──────────────────────────────── -->
    <aside class="listing-archive-sidebar">
        <?php 
        // Loads your dedicated filtering widget section for dynamic segment sorting
        if ( is_active_sidebar( 'sidebar-listings' ) ) {
            dynamic_sidebar( 'sidebar-listings' );
        } else {
            ?>
            <div class="sidebar-fallback-widget" style="background: #ffffff; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0;">
                <h4 style="margin-top: 0; font-size: 16px; color: #0f172a; margin-bottom: 10px;">
                    <?php esc_html_e( 'Filter Listings', 'listingcore-theme' ); ?>
                </h4>
                <p style="font-size: 13px; color: #64748b; margin: 0;">
                    <?php esc_html_e( 'Go to Appearance > Widgets to place your taxonomy filter bars here.', 'listingcore-theme' ); ?>
                </p>
            </div>
            <?php
        }
        ?>
    </aside>

    <!-- ── GRID ENGINE SEARCH RESULTS ──────────────────────── -->
    <section class="listing-archive-results">
        
        <header class="archive-header" style="margin-bottom: 30px;">
            <h1 class="archive-title" style="font-size: 28px; font-weight: 700; color: #0f172a; margin: 0 0 10px 0;">
                <?php the_archive_title(); ?>
            </h1>
            <?php the_archive_description( '<div class="archive-description" style="color: #64748b; font-size: 15px;">', '</div>' ); ?>
        </header>

        <?php if ( have_posts() ) : ?>
            
            <!-- Standard dynamic grid initialization -->
            <div class="listingcore-grid-view" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                <?php
                while ( have_posts() ) : the_post();
                    
                    // Natively calls our cleaned template function loop card
                    if ( function_exists( 'listingcore_theme_listing_card' ) ) {
                        listingcore_theme_listing_card( get_the_ID() );
                    } else {
                        // Safe architectural fallback layout block
                        ?>
                        <article class="fallback-card" style="background:#fff; padding:20px; border-radius:8px; border:1px solid #e2e8f0;">
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <?php the_excerpt(); ?>
                        </article>
                        <?php
                    }

                endwhile;
                ?>
            </div>

            <!-- Renders structured theme pagination strings -->
            <div class="listingcore-pagination-wrapper" style="margin-top: 40px; text-align: center;">
                <?php 
                if ( function_exists( 'listingcore_theme_pagination' ) ) {
                    listingcore_theme_pagination();
                } else {
                    the_posts_navigation();
                }
                ?>
            </div>

        <?php else : ?>
            
            <!-- Injects the standard empty template part fallback layout -->
            <?php get_template_part( 'template-parts/content', 'none' ); ?>

        <?php endif; ?>

    </section>

</main>

<?php get_footer(); ?>
