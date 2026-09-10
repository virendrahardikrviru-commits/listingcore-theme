<?php
/**
 * User Dashboard Template Part
 *
 * @package ClassiPressPro
 */

if ( ! is_user_logged_in() ) return;

$user_id     = get_current_user_id();
$user        = wp_get_current_user();
$current_tab = sanitize_key( $_GET['tab'] ?? 'overview' );

// Counts
$my_listings = new WP_Query( [
    'post_type'      => 'listing',
    'author'         => $user_id,
    'post_status'    => [ 'publish', 'pending', 'draft' ],
    'posts_per_page' => -1,
    'fields'         => 'ids',
] );
$total_listings = $my_listings->found_posts;

$wishlist       = get_user_meta( $user_id, '_cp_wishlist', true ) ?: [];
$total_wishlist = count( $wishlist );

$total_views = 0;
if ( $my_listings->posts ) {
    foreach ( $my_listings->posts as $lid ) {
        $total_views += (int) get_post_meta( $lid, '_cp_views', true );
    }
}

$dashboard_url = get_permalink();
$tabs = [
    'overview'    => [ 'label' => __( 'Overview',     'classipress-pro' ), 'icon' => '📊' ],
    'my-listings' => [ 'label' => __( 'My Listings',  'classipress-pro' ), 'icon' => '📋' ],
    'wishlist'    => [ 'label' => __( 'Wishlist',     'classipress-pro' ), 'icon' => '♥' ],
    'messages'    => [ 'label' => __( 'Messages',     'classipress-pro' ), 'icon' => '✉️' ],
    'profile'     => [ 'label' => __( 'Profile',      'classipress-pro' ), 'icon' => '👤' ],
    'settings'    => [ 'label' => __( 'Settings',     'classipress-pro' ), 'icon' => '⚙️' ],
];
?>

<div class="cp-dashboard-layout">

    <!-- ── SIDEBAR NAV ───────────────────────────────── -->
    <aside class="cp-dashboard-nav" aria-label="<?php esc_attr_e( 'Dashboard navigation', 'classipress-pro' ); ?>">

        <div class="cp-dash-user">
            <?php echo get_avatar( $user_id, 48, '', '', [ 'style' => 'border-radius:50%;flex-shrink:0;' ] ); ?>
            <div>
                <div class="cp-dash-user-name"><?php echo esc_html( $user->display_name ); ?></div>
                <div class="cp-dash-user-role"><?php echo esc_html( $user->user_email ); ?></div>
            </div>
        </div>

        <ul class="cp-dash-menu" role="list">
            <?php foreach ( $tabs as $slug => $tab ) : ?>
            <li class="<?php echo esc_attr( $current_tab === $slug ? 'active' : '' ) ?>">
                <a href="<?php echo esc_url( add_query_arg( 'tab', $slug, $dashboard_url ) ); ?>">
                    <span aria-hidden="true"><?php echo esc_html( $tab['icon'] ); ?></span>
                    <?php echo esc_html( $tab['label'] ); ?>
                </a>
            </li>
            <?php endforeach; ?>
            <li>
                <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" style="color:var(--cp-danger)!important;">
                    <span aria-hidden="true">🚪</span>
                    <?php esc_html_e( 'Logout', 'classipress-pro' ); ?>
                </a>
            </li>
        </ul>

    </aside>

    <!-- ── MAIN CONTENT ──────────────────────────────── -->
    <main class="cp-dashboard-main">

        <?php
        // ── OVERVIEW ──────────────────────────────────
        if ( $current_tab === 'overview' ) : ?>

        <h1 style="font-size:1.5rem;font-weight:800;margin-bottom:1.5rem;">
            <?php printf( esc_html__( 'Welcome back, %s! 👋', 'classipress-pro' ), esc_html( $user->first_name ?: $user->display_name ) ); ?>
        </h1>

        <!-- Stats -->
        <div class="cp-dashboard-stats">
            <div class="cp-stat-card">
                <div class="value"><?php echo esc_html( number_format_i18n( $total_listings ) ); ?></div>
                <div class="label"><?php esc_html_e( 'My Listings', 'classipress-pro' ); ?></div>
            </div>
            <div class="cp-stat-card">
                <div class="value"><?php echo esc_html( number_format_i18n( $total_views ) ); ?></div>
                <div class="label"><?php esc_html_e( 'Total Views', 'classipress-pro' ); ?></div>
            </div>
            <div class="cp-stat-card">
                <div class="value"><?php echo esc_html( number_format_i18n( $total_wishlist ) ); ?></div>
                <div class="label"><?php esc_html_e( 'Saved Listings', 'classipress-pro' ); ?></div>
            </div>
        </div>

        <!-- Quick actions -->
        <div style="display:flex;gap:1rem;flex-wrap:wrap;margin-bottom:2rem;">
            <?php
            $submit_page = get_option( 'cp_submit_page' );
            $post_url    = $submit_page ? get_permalink( $submit_page ) : admin_url( 'post-new.php?post_type=listing' );
            ?>
            <a href="<?php echo esc_url( $post_url ); ?>" class="cp-btn cp-btn-primary">
                ➕ <?php esc_html_e( 'Post New Listing', 'classipress-pro' ); ?>
            </a>
            <a href="<?php echo esc_url( add_query_arg( 'tab', 'my-listings', $dashboard_url ) ); ?>" class="cp-btn cp-btn-ghost">
                📋 <?php esc_html_e( 'Manage Listings', 'classipress-pro' ); ?>
            </a>
        </div>

        <!-- Recent listings -->
        <?php
        $recent_q = new WP_Query( [
            'post_type'      => 'listing',
            'author'         => $user_id,
            'post_status'    => [ 'publish', 'pending', 'draft' ],
            'posts_per_page' => 5,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ] );

        if ( $recent_q->have_posts() ) : ?>
        <div style="background:var(--cp-white);border-radius:var(--cp-border-radius-lg);border:1px solid var(--cp-gray-100);overflow:hidden;">
            <div style="padding:1rem 1.25rem;border-bottom:1px solid var(--cp-gray-100);display:flex;align-items:center;justify-content:space-between;">
                <h2 style="font-size:1rem;font-weight:700;"><?php esc_html_e( 'Recent Listings', 'classipress-pro' ); ?></h2>
                <a href="<?php echo esc_url( add_query_arg( 'tab', 'my-listings', $dashboard_url ) ); ?>" style="font-size:.8125rem;color:var(--cp-primary);"><?php esc_html_e( 'View All', 'classipress-pro' ); ?></a>
            </div>
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:var(--cp-gray-50);">
                        <th style="padding:.75rem 1.25rem;text-align:left;font-size:.8125rem;color:var(--cp-gray-500);font-weight:600;"><?php esc_html_e( 'Title', 'classipress-pro' ); ?></th>
                        <th style="padding:.75rem 1.25rem;text-align:left;font-size:.8125rem;color:var(--cp-gray-500);font-weight:600;"><?php esc_html_e( 'Price', 'classipress-pro' ); ?></th>
                        <th style="padding:.75rem 1.25rem;text-align:left;font-size:.8125rem;color:var(--cp-gray-500);font-weight:600;"><?php esc_html_e( 'Status', 'classipress-pro' ); ?></th>
                        <th style="padding:.75rem 1.25rem;text-align:left;font-size:.8125rem;color:var(--cp-gray-500);font-weight:600;"><?php esc_html_e( 'Views', 'classipress-pro' ); ?></th>
                        <th style="padding:.75rem 1.25rem;text-align:left;font-size:.8125rem;color:var(--cp-gray-500);font-weight:600;"><?php esc_html_e( 'Actions', 'classipress-pro' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ( $recent_q->have_posts() ) : $recent_q->the_post(); ?>
                    <?php
                    $lid   = get_the_ID();
                    $price = get_post_meta( $lid, '_cp_price', true );
                    $curr  = get_post_meta( $lid, '_cp_currency', true ) ?: 'USD';
                    $ptype = get_post_meta( $lid, '_cp_price_type', true ) ?: 'fixed';
                    $views = get_post_meta( $lid, '_cp_views', true ) ?: 0;
                    $status_map = [
                        'publish' => [ 'label' => __( 'Published', 'classipress-pro' ), 'color' => 'var(--cp-success)' ],
                        'pending' => [ 'label' => __( 'Pending',   'classipress-pro' ), 'color' => 'var(--cp-warning)' ],
                        'draft'   => [ 'label' => __( 'Draft',     'classipress-pro' ), 'color' => 'var(--cp-gray-500)' ],
                    ];
                    $status = $status_map[ get_post_status() ] ?? $status_map['draft'];
                    ?>
                    <tr style="border-bottom:1px solid var(--cp-gray-100);">
                        <td style="padding:.75rem 1.25rem;">
                            <a href="<?php the_permalink(); ?>" style="font-size:.875rem;font-weight:600;color:var(--cp-dark);"><?php the_title(); ?></a>
                        </td>
                        <td style="padding:.75rem 1.25rem;font-size:.875rem;font-weight:700;color:var(--cp-primary);">
                            <?php echo cp_format_price( $price, $curr, $ptype ); // phpcs:ignore ?>
                        </td>
                        <td style="padding:.75rem 1.25rem;">
                            <span style="font-size:.75rem;font-weight:600;color:<?php echo esc_attr( $status['color'] ); ?>">● <?php echo esc_html( $status['label'] ); ?></span>
                        </td>
                        <td style="padding:.75rem 1.25rem;font-size:.875rem;color:var(--cp-gray-600);">
                            <?php echo esc_html( number_format_i18n( (int) $views ) ); ?>
                        </td>
                        <td style="padding:.75rem 1.25rem;">
                            <div style="display:flex;gap:.5rem;">
                                <a href="<?php the_permalink(); ?>" class="cp-btn cp-btn-ghost cp-btn-sm"><?php esc_html_e( 'View', 'classipress-pro' ); ?></a>
                                <a href="<?php echo esc_url( get_edit_post_link( $lid ) ); ?>" class="cp-btn cp-btn-ghost cp-btn-sm"><?php esc_html_e( 'Edit', 'classipress-pro' ); ?></a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; wp_reset_postdata(); ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <?php
        // ── MY LISTINGS ───────────────────────────────
        elseif ( $current_tab === 'my-listings' ) : ?>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
            <h1 style="font-size:1.5rem;font-weight:800;"><?php esc_html_e( 'My Listings', 'classipress-pro' ); ?></h1>
            <?php
            $submit_page = get_option( 'cp_submit_page' );
            $post_url    = $submit_page ? get_permalink( $submit_page ) : admin_url( 'post-new.php?post_type=listing' );
            ?>
            <a href="<?php echo esc_url( $post_url ); ?>" class="cp-btn cp-btn-primary">
                ➕ <?php esc_html_e( 'Add New', 'classipress-pro' ); ?>
            </a>
        </div>

        <?php
        $paged    = absint( $_GET['listing_page'] ?? 1 );
        $all_q    = new WP_Query( [
            'post_type'      => 'listing',
            'author'         => $user_id,
            'post_status'    => [ 'publish', 'pending', 'draft', 'expired' ],
            'posts_per_page' => 10,
            'paged'          => $paged,
        ] );

        if ( $all_q->have_posts() ) :
        ?>
        <div class="cp-listings-grid cp-list-view">
            <?php while ( $all_q->have_posts() ) : $all_q->the_post(); ?>
                <?php cp_listing_card( get_the_ID() ); ?>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <?php cp_pagination( $all_q ); ?>
        <?php else : ?>
        <div style="text-align:center;padding:3rem;background:var(--cp-white);border-radius:var(--cp-border-radius-lg);border:1px solid var(--cp-gray-100);">
            <div style="font-size:3rem;margin-bottom:1rem;">📭</div>
            <p style="color:var(--cp-gray-500);"><?php esc_html_e( 'You have no listings yet.', 'classipress-pro' ); ?></p>
            <a href="<?php echo esc_url( $post_url ); ?>" class="cp-btn cp-btn-primary" style="margin-top:1rem;"><?php esc_html_e( 'Post Your First Listing', 'classipress-pro' ); ?></a>
        </div>
        <?php endif; ?>

        <?php
        // ── WISHLIST ──────────────────────────────────
        elseif ( $current_tab === 'wishlist' ) : ?>

        <h1 style="font-size:1.5rem;font-weight:800;margin-bottom:1.5rem;">♥ <?php esc_html_e( 'Saved Listings', 'classipress-pro' ); ?></h1>

        <?php if ( ! empty( $wishlist ) ) : ?>
        <div class="cp-listings-grid">
            <?php foreach ( $wishlist as $wid ) : ?>
                <?php if ( get_post_status( $wid ) === 'publish' ) : ?>
                    <?php cp_listing_card( $wid ); ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php else : ?>
        <div style="text-align:center;padding:3rem;background:var(--cp-white);border-radius:var(--cp-border-radius-lg);border:1px solid var(--cp-gray-100);">
            <div style="font-size:3rem;margin-bottom:1rem;">💔</div>
            <p style="color:var(--cp-gray-500);"><?php esc_html_e( 'You haven\'t saved any listings yet.', 'classipress-pro' ); ?></p>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'listing' ) ); ?>" class="cp-btn cp-btn-primary" style="margin-top:1rem;"><?php esc_html_e( 'Browse Listings', 'classipress-pro' ); ?></a>
        </div>
        <?php endif; ?>

        <?php
        // ── PROFILE ───────────────────────────────────
        elseif ( $current_tab === 'profile' ) : ?>

        <h1 style="font-size:1.5rem;font-weight:800;margin-bottom:1.5rem;">👤 <?php esc_html_e( 'My Profile', 'classipress-pro' ); ?></h1>

        <?php if ( isset( $_POST['cp_save_profile'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cp_profile_nonce'] ?? '' ) ), 'cp_save_profile' ) ) :
            $display_name = sanitize_text_field( wp_unslash( $_POST['display_name'] ?? '' ) );
            $first_name   = sanitize_text_field( wp_unslash( $_POST['first_name']   ?? '' ) );
            $last_name    = sanitize_text_field( wp_unslash( $_POST['last_name']    ?? '' ) );
            $description  = sanitize_textarea_field( wp_unslash( $_POST['description'] ?? '' ) );
            $phone        = sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) );
            $website      = esc_url_raw( wp_unslash( $_POST['website'] ?? '' ) );

            wp_update_user( [ 'ID' => $user_id, 'display_name' => $display_name, 'first_name' => $first_name, 'last_name' => $last_name, 'user_url' => $website ] );
            update_user_meta( $user_id, 'description', $description );
            update_user_meta( $user_id, 'cp_phone', $phone );

            echo '<div class="cp-alert cp-alert-success">' . esc_html__( 'Profile updated successfully!', 'classipress-pro' ) . '</div>';
            $user = wp_get_current_user();
        endif; ?>

        <form method="post" style="background:var(--cp-white);border-radius:var(--cp-border-radius-lg);padding:1.5rem;border:1px solid var(--cp-gray-100);" novalidate>
            <?php wp_nonce_field( 'cp_save_profile', 'cp_profile_nonce' ); ?>

            <div class="cp-form-row">
                <div class="cp-form-group">
                    <label for="cp-first-name"><?php esc_html_e( 'First Name', 'classipress-pro' ); ?></label>
                    <input type="text" id="cp-first-name" name="first_name" class="cp-input" value="<?php echo esc_attr( $user->first_name ); ?>">
                </div>
                <div class="cp-form-group">
                    <label for="cp-last-name"><?php esc_html_e( 'Last Name', 'classipress-pro' ); ?></label>
                    <input type="text" id="cp-last-name" name="last_name" class="cp-input" value="<?php echo esc_attr( $user->last_name ); ?>">
                </div>
            </div>

            <div class="cp-form-group">
                <label for="cp-display-name"><?php esc_html_e( 'Display Name', 'classipress-pro' ); ?></label>
                <input type="text" id="cp-display-name" name="display_name" class="cp-input" value="<?php echo esc_attr( $user->display_name ); ?>">
            </div>

            <div class="cp-form-group">
                <label for="cp-email"><?php esc_html_e( 'Email Address', 'classipress-pro' ); ?></label>
                <input type="email" id="cp-email" class="cp-input" value="<?php echo esc_attr( $user->user_email ); ?>" disabled>
                <small style="font-size:.8125rem;color:var(--cp-gray-500);"><?php esc_html_e( 'Email cannot be changed here.', 'classipress-pro' ); ?></small>
            </div>

            <div class="cp-form-group">
                <label for="cp-phone"><?php esc_html_e( 'Phone Number', 'classipress-pro' ); ?></label>
                <input type="tel" id="cp-phone" name="phone" class="cp-input" value="<?php echo esc_attr( get_user_meta( $user_id, 'cp_phone', true ) ); ?>">
            </div>

            <div class="cp-form-group">
                <label for="cp-website"><?php esc_html_e( 'Website', 'classipress-pro' ); ?></label>
                <input type="url" id="cp-website" name="website" class="cp-input" value="<?php echo esc_attr( $user->user_url ); ?>">
            </div>

            <div class="cp-form-group">
                <label for="cp-bio"><?php esc_html_e( 'About Me', 'classipress-pro' ); ?></label>
                <textarea id="cp-bio" name="description" class="cp-textarea" rows="4"><?php echo esc_textarea( get_user_meta( $user_id, 'description', true ) ); ?></textarea>
            </div>

            <button type="submit" name="cp_save_profile" value="1" class="cp-btn cp-btn-primary">
                <?php esc_html_e( 'Save Changes', 'classipress-pro' ); ?>
            </button>
        </form>

        <?php
        // ── SETTINGS ──────────────────────────────────
        elseif ( $current_tab === 'settings' ) :

            if ( isset( $_POST['cp_save_settings'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cp_settings_nonce'] ?? '' ) ), 'cp_save_settings' ) ) {
                update_user_meta( $user_id, 'cp_notify_messages',   ! empty( $_POST['notify_messages'] ) ? '1' : '' );
                update_user_meta( $user_id, 'cp_notify_expiry',     ! empty( $_POST['notify_expiry'] ) ? '1' : '' );
                update_user_meta( $user_id, 'cp_profile_private',   ! empty( $_POST['profile_private'] ) ? '1' : '' );
                echo '<div class="cp-alert cp-alert-success">' . esc_html__( 'Settings saved!', 'classipress-pro' ) . '</div>';
            }
        ?>

        <h1 style="font-size:1.5rem;font-weight:800;margin-bottom:1.5rem;">⚙️ <?php esc_html_e( 'Notification Settings', 'classipress-pro' ); ?></h1>

        <form method="post" style="background:var(--cp-white);border-radius:var(--cp-border-radius-lg);padding:1.5rem;border:1px solid var(--cp-gray-100);">
            <?php wp_nonce_field( 'cp_save_settings', 'cp_settings_nonce' ); ?>

            <div class="cp-form-group">
                <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;">
                    <input type="checkbox" name="notify_messages" value="1" <?php checked( get_user_meta( $user_id, 'cp_notify_messages', true ), '1' ); ?> style="accent-color:var(--cp-primary);width:16px;height:16px;">
                    <span><?php esc_html_e( 'Email me when someone contacts me about a listing', 'classipress-pro' ); ?></span>
                </label>
            </div>

            <div class="cp-form-group">
                <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;">
                    <input type="checkbox" name="notify_expiry" value="1" <?php checked( get_user_meta( $user_id, 'cp_notify_expiry', true ), '1' ); ?> style="accent-color:var(--cp-primary);width:16px;height:16px;">
                    <span><?php esc_html_e( 'Email me when my listing is about to expire', 'classipress-pro' ); ?></span>
                </label>
            </div>

            <div class="cp-form-group">
                <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;">
                    <input type="checkbox" name="profile_private" value="1" <?php checked( get_user_meta( $user_id, 'cp_profile_private', true ), '1' ); ?> style="accent-color:var(--cp-primary);width:16px;height:16px;">
                    <span><?php esc_html_e( 'Keep my profile private (hide from public)', 'classipress-pro' ); ?></span>
                </label>
            </div>

            <button type="submit" name="cp_save_settings" value="1" class="cp-btn cp-btn-primary">
                <?php esc_html_e( 'Save Settings', 'classipress-pro' ); ?>
            </button>
        </form>

        <?php endif; ?>

    </main>

</div>
