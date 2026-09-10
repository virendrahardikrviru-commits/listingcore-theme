<?php
/**
 * 404 Not Found Template
 *
 * @package ClassiPressPro
 */

get_header();
?>

<main id="main" class="site-main" role="main">
    <div class="cp-container" style="text-align:center;padding:6rem 0;">

        <div style="font-size:6rem;line-height:1;margin-bottom:1.5rem;font-weight:900;color:var(--cp-gray-200);">404</div>
        <h1 style="font-size:2rem;font-weight:800;margin-bottom:1rem;"><?php esc_html_e( 'Page Not Found', 'classipress-pro' ); ?></h1>
        <p style="font-size:1.125rem;color:var(--cp-gray-500);max-width:500px;margin:0 auto 2rem;">
            <?php esc_html_e( 'The page you\'re looking for doesn\'t exist. Try searching for what you need.', 'classipress-pro' ); ?>
        </p>

        <?php get_search_form(); ?>

        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
            <a href="<?php echo esc_url( home_url() ); ?>" class="cp-btn cp-btn-primary"><?php esc_html_e( 'Go Home', 'classipress-pro' ); ?></a>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'listing' ) ); ?>" class="cp-btn cp-btn-ghost"><?php esc_html_e( 'Browse Listings', 'classipress-pro' ); ?></a>
        </div>

    </div>
</main>

<?php get_footer(); ?>
