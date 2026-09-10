<?php
// Copyright (C) 2024 Your Name - ClassiPress Pro. Licensed under GPLv2 or later.
/**
 * Single Post Template
 *
 * @package ClassiPressPro
 */

get_header();
cp_breadcrumbs();
?>

<main id="main" class="site-main" role="main">
    <div class="cp-container cp-section-sm">
        <div class="cp-layout-sidebar" style="grid-template-columns:1fr 300px;">

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'cp-single-post' ); ?> itemscope itemtype="https://schema.org/BlogPosting">

                <?php while ( have_posts() ) : the_post(); ?>

                <?php if ( has_post_thumbnail() ) : ?>
                <div class="cp-post-hero" style="border-radius:var(--cp-border-radius-lg);overflow:hidden;margin-bottom:1.5rem;">
                    <?php the_post_thumbnail( 'cp-blog-thumb', [ 'loading' => 'eager' ] ); ?>
                </div>
                <?php endif; ?>

                <header class="entry-header" style="margin-bottom:1.5rem;">

                    <div style="display:flex;gap:.5rem;align-items:center;flex-wrap:wrap;margin-bottom:.75rem;">
                        <?php
                        $cats = get_the_category();
                        foreach ( $cats as $cat ) {
                            echo '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '" style="font-size:.75rem;font-weight:700;color:var(--cp-primary);text-transform:uppercase;letter-spacing:.06em;">' . esc_html( $cat->name ) . '</a>';
                        }
                        ?>
                    </div>

                    <?php the_title( '<h1 class="entry-title" style="font-size:2rem;font-weight:800;line-height:1.25;margin-bottom:1rem;" itemprop="name headline">', '</h1>' ); ?>

                    <div class="entry-meta" style="display:flex;align-items:center;gap:1rem;font-size:.875rem;color:var(--cp-gray-500);">
                        <span itemprop="author" itemscope itemtype="https://schema.org/Person">
                            <?php echo get_avatar( get_the_author_meta( 'ID' ), 28, '', '', [ 'style' => 'border-radius:50%;vertical-align:middle;margin-right:.25rem;' ] ); ?>
                            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" itemprop="name"><?php the_author(); ?></a>
                        </span>
                        <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" itemprop="datePublished">
                            <?php echo esc_html( get_the_date() ); ?>
                        </time>
                        <?php if ( get_comments_number() ) : ?>
                        <a href="<?php comments_link(); ?>">
                            💬 <?php echo esc_html( get_comments_number() ); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </header>

                <div class="entry-content" itemprop="articleBody" style="font-size:1.0625rem;line-height:1.8;color:var(--cp-gray-700);">
                    <?php
                    the_content( sprintf(
                        wp_kses( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'classipress-pro' ), [ 'span' => [ 'class' => [] ] ] ),
                        wp_kses_post( get_the_title() )
                    ) );
                    wp_link_pages( [
                        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'classipress-pro' ),
                        'after'  => '</div>',
                    ] );
                    ?>
                </div>

                <footer class="entry-footer" style="margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--cp-gray-100);">
                    <?php the_tags( '<div style="margin-bottom:1rem;">' . esc_html__( 'Tags: ', 'classipress-pro' ), ', ', '</div>' ); ?>
                </footer>

                <?php endwhile; ?>

                <!-- Post Navigation -->
                <nav class="post-navigation" style="margin-top:2rem;display:grid;grid-template-columns:1fr 1fr;gap:1rem;" aria-label="<?php esc_attr_e( 'Post navigation', 'classipress-pro' ); ?>">
                    <?php
                    $prev = get_previous_post();
                    $next = get_next_post();
                    if ( $prev ) {
                        echo '<a href="' . esc_url( get_permalink( $prev ) ) . '" style="background:var(--cp-white);border:1px solid var(--cp-gray-200);border-radius:var(--cp-border-radius-lg);padding:1rem;display:block;">
                            <span style="font-size:.75rem;color:var(--cp-gray-500);">← ' . esc_html__( 'Previous', 'classipress-pro' ) . '</span>
                            <strong style="display:block;font-size:.9375rem;color:var(--cp-dark);margin-top:.25rem;">' . esc_html( get_the_title( $prev ) ) . '</strong>
                        </a>';
                    }
                    if ( $next ) {
                        echo '<a href="' . esc_url( get_permalink( $next ) ) . '" style="background:var(--cp-white);border:1px solid var(--cp-gray-200);border-radius:var(--cp-border-radius-lg);padding:1rem;display:block;text-align:right;' . ( $prev ? '' : 'grid-column:2;' ) . '">
                            <span style="font-size:.75rem;color:var(--cp-gray-500);">' . esc_html__( 'Next', 'classipress-pro' ) . ' →</span>
                            <strong style="display:block;font-size:.9375rem;color:var(--cp-dark);margin-top:.25rem;">' . esc_html( get_the_title( $next ) ) . '</strong>
                        </a>';
                    }
                    ?>
                </nav>

                <!-- Comments -->
                <?php
                if ( comments_open() || get_comments_number() ) {
                    comments_template();
                }
                ?>

            </article>

            <!-- Sidebar -->
            <?php get_sidebar(); ?>

        </div>
    </div>
</main>

<?php get_footer(); ?>
