<?php
/**
 * Page Template
 *
 * @package ClassiPressPro
 */

get_header();
cp_breadcrumbs();
?>

<main id="main" class="site-main" role="main">
    <div class="cp-container cp-section-sm">

        <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header" style="margin-bottom:2rem;">
                <?php the_title( '<h1 class="entry-title" style="font-size:2.25rem;font-weight:800;">', '</h1>' ); ?>
            </header>
            <div class="entry-content" style="font-size:1.0625rem;line-height:1.8;">
                <?php
                the_content();
                wp_link_pages( [
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'classipress-pro' ),
                    'after'  => '</div>',
                ] );
                ?>
            </div>
        </article>

        <?php
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }
        endwhile;
        ?>

    </div>
</main>

<?php get_footer(); ?>
