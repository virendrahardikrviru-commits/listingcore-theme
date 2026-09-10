<?php
/**
 * Search Results Template
 *
 * @package ClassiPressPro
 */

get_header();
cp_breadcrumbs();
?>

<main id="main" class="site-main" role="main">
    <div class="cp-container cp-section-sm">

        <header class="page-header" style="margin-bottom:2rem;">
            <h1 class="page-title">
                <?php printf( esc_html__( 'Search results for: %s', 'classipress-pro' ), '<span style="color:var(--cp-primary);">' . esc_html( get_search_query() ) . '</span>' ); ?>
            </h1>
            <?php if ( $wp_query->found_posts ) : ?>
            <p style="color:var(--cp-gray-500);margin-top:.5rem;">
                <?php printf( esc_html( _n( '%s result found', '%s results found', $wp_query->found_posts, 'classipress-pro' ) ), number_format_i18n( $wp_query->found_posts ) ); ?>
            </p>
            <?php endif; ?>
        </header>

        <?php if ( have_posts() ) : ?>

            <div class="cp-listings-grid" id="cp-search-results">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php if ( get_post_type() === 'listing' ) : ?>
                        <?php cp_listing_card( get_the_ID() ); ?>
                    <?php else : ?>
                        <?php get_template_part( 'template-parts/content', 'search' ); ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>

            <?php cp_pagination(); ?>

        <?php else : ?>

            <div style="text-align:center;padding:4rem 0;">
                <div style="font-size:4rem;margin-bottom:1rem;">🔍</div>
                <h2><?php esc_html_e( 'No results found', 'classipress-pro' ); ?></h2>
                <p style="color:var(--cp-gray-500);margin-bottom:2rem;">
                    <?php esc_html_e( 'Sorry, no listings match your search. Try different keywords or browse all listings.', 'classipress-pro' ); ?>
                </p>
                <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'listing' ) ); ?>" class="cp-btn cp-btn-primary">
                        <?php esc_html_e( 'Browse All Listings', 'classipress-pro' ); ?>
                    </a>
                    <a href="<?php echo esc_url( home_url() ); ?>" class="cp-btn cp-btn-ghost">
                        <?php esc_html_e( 'Go Home', 'classipress-pro' ); ?>
                    </a>
                </div>
            </div>

        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>
