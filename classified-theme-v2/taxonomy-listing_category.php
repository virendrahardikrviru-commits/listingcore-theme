<?php
/**
 * Template for Listing Category taxonomy archive
 *
 * @package ClassiPressPro
 */

get_header();

$term         = get_queried_object();
$show_sidebar = get_theme_mod( 'cp_show_sidebar_listings', true );

cp_breadcrumbs();
?>

<main id="main" class="site-main" role="main">

    <!-- Category Header -->
    <div class="cp-archive-header">
        <div class="cp-container">
            <div style="display:flex;align-items:center;gap:1rem;margin-bottom:.5rem;">
                <?php
                $icon = get_term_meta( $term->term_id, 'cp_category_icon', true ) ?: '📦';
                echo '<div style="width:48px;height:48px;border-radius:var(--cp-border-radius-lg);background:var(--cp-primary-light);display:flex;align-items:center;justify-content:center;font-size:1.5rem;" aria-hidden="true">' . esc_html( $icon ) . '</div>';
                ?>
                <div>
                    <h1 class="page-title"><?php single_term_title(); ?></h1>
                    <?php if ( $term->description ) : ?>
                    <p style="color:var(--cp-gray-500);font-size:.9375rem;margin:0;"><?php echo esc_html( $term->description ); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="cp-archive-toolbar">
                <p class="cp-results-count" aria-live="polite">
                    <?php
                    global $wp_query;
                    printf(
                        esc_html( _n( '%s listing found', '%s listings found', $wp_query->found_posts, 'classipress-pro' ) ),
                        '<strong>' . esc_html( number_format_i18n( $wp_query->found_posts ) ) . '</strong>'
                    );
                    ?>
                </p>

                <div style="display:flex;gap:1rem;align-items:center;">
                    <!-- Sub-categories -->
                    <?php
                    $subcats = get_terms( [ 'taxonomy' => 'listing_category', 'parent' => $term->term_id, 'hide_empty' => true ] );
                    if ( $subcats && ! is_wp_error( $subcats ) ) :
                    ?>
                    <div style="display:flex;gap:.5rem;flex-wrap:wrap;" role="group" aria-label="<?php esc_attr_e( 'Subcategories', 'classipress-pro' ); ?>">
                        <?php foreach ( $subcats as $subcat ) : ?>
                        <a href="<?php echo esc_url( get_term_link( $subcat ) ); ?>" class="cp-btn cp-btn-ghost cp-btn-sm">
                            <?php echo esc_html( $subcat->name ); ?>
                            <span style="color:var(--cp-gray-400);">(<?php echo esc_html( number_format_i18n( $subcat->count ) ); ?>)</span>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <div class="cp-view-toggle" role="group" aria-label="<?php esc_attr_e( 'Toggle view', 'classipress-pro' ); ?>">
                        <button class="cp-view-btn active" data-view="grid" aria-pressed="true">⊞</button>
                        <button class="cp-view-btn" data-view="list" aria-pressed="false">☰</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cp-container cp-section-sm">
        <div class="<?php echo esc_attr( $show_sidebar ? 'cp-layout-sidebar' : '' ); ?>">

            <?php if ( $show_sidebar ) : ?>
            <aside class="cp-filters-sidebar" aria-label="<?php esc_attr_e( 'Filters', 'classipress-pro' ); ?>">
                <?php if ( is_active_sidebar( 'sidebar-1' ) ) dynamic_sidebar( 'sidebar-1' ); ?>
            </aside>
            <?php endif; ?>

            <div>
                <?php if ( have_posts() ) : ?>
                <div class="cp-listings-grid" id="cp-listings-grid">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php cp_listing_card( get_the_ID() ); ?>
                    <?php endwhile; ?>
                </div>
                <?php cp_pagination(); ?>
                <?php else : ?>
                <div style="text-align:center;padding:4rem 2rem;">
                    <div style="font-size:3rem;margin-bottom:1rem;">📭</div>
                    <h2><?php esc_html_e( 'No listings in this category yet.', 'classipress-pro' ); ?></h2>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'listing' ) ); ?>" class="cp-btn cp-btn-primary" style="margin-top:1rem;"><?php esc_html_e( 'Browse All Listings', 'classipress-pro' ); ?></a>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

</main>

<?php get_footer(); ?>
