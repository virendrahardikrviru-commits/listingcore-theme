<?php
/**
 * Template part for displaying text search results
 *
 * @package ListingCoreTheme
 */

defined( 'ABSPATH' ) || exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('listingcore-search-excerpt-card'); ?> style="background: #ffffff; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 16px;">
	<header class="entry-header">
		<span class="search-result-post-type" style="display: inline-block; padding: 2px 6px; font-size: 11px; font-weight: 600; text-transform: uppercase; background: #f1f5f9; color: #475569; border-radius: 4px; margin-bottom: 8px;">
			<?php 
			$post_type_obj = get_post_type_object( get_post_type() );
			echo esc_html( $post_type_obj->labels->singular_name );
			?>
		</span>
		
		<?php the_title( sprintf( '<h3 class="entry-title" style="font-size: 18px; font-weight: 600; margin: 0 0 10px 0;"><a href="%s" style="color: #0f172a; text-decoration: none;">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
	</header>

	<div class="entry-summary" style="font-size: 14px; line-height: 1.5; color: #475569;">
		<?php the_excerpt(); ?>
	</div>
</article>
