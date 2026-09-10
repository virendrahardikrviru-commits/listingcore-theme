<?php
// Copyright (C) 2024 Your Name - ClassiPress Pro. Licensed under GPLv2 or later.
/**
 * The main template file.
 * Fallback for all templates not matched by the template hierarchy.
 *
 * @package ClassiPressPro
 */

get_header();
?>

<main id="main" class="site-main" role="main">
    <div class="cp-container cp-section">

        <?php if ( have_posts() ) : ?>

            <?php if ( is_home() && ! is_front_page() ) : ?>
                <header class="page-header">
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                </header>
            <?php endif; ?>

            <div class="cp-blog-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/content', get_post_type() ); ?>
                <?php endwhile; ?>
            </div>

            <?php cp_pagination(); ?>

        <?php else : ?>

            <?php get_template_part( 'template-parts/content', 'none' ); ?>

        <?php endif; ?>

    </div>
</main>

<?php
// Copyright (C) 2024 Your Name - ClassiPress Pro. Licensed under GPLv2 or later.
get_sidebar();
get_footer();
