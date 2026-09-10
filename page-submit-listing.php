<?php
/**
 * Template Name: Submit Listing
 * Template Post Type: page
 *
 * @package ClassiPressPro
 */

get_header();
cp_breadcrumbs();

// Handle form submission
$errors  = [];
$success = false;

if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['cp_submit_listing_nonce'] ) ) {

    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cp_submit_listing_nonce'] ) ), 'cp_submit_listing' ) ) {
        $errors[] = __( 'Security check failed. Please try again.', 'classipress-pro' );
    }

    if ( ! is_user_logged_in() ) {
        $errors[] = __( 'You must be logged in to submit a listing.', 'classipress-pro' );
    }

    $title       = sanitize_text_field( wp_unslash( $_POST['listing_title']   ?? '' ) );
    $description = wp_kses_post( wp_unslash( $_POST['listing_description']    ?? '' ) );
    $price       = sanitize_text_field( wp_unslash( $_POST['cp_price']         ?? '' ) );
    $price_type  = sanitize_text_field( wp_unslash( $_POST['cp_price_type']    ?? 'fixed' ) );
    $currency    = sanitize_text_field( wp_unslash( $_POST['cp_currency']       ?? 'USD' ) );
    $ad_type     = sanitize_text_field( wp_unslash( $_POST['cp_ad_type']        ?? 'sell' ) );
    $condition   = sanitize_text_field( wp_unslash( $_POST['cp_condition']      ?? '' ) );
    $category    = absint( $_POST['listing_category'] ?? 0 );
    $location_t  = absint( $_POST['listing_location'] ?? 0 );
    $city        = sanitize_text_field( wp_unslash( $_POST['cp_city']           ?? '' ) );
    $state       = sanitize_text_field( wp_unslash( $_POST['cp_state']          ?? '' ) );
    $country     = sanitize_text_field( wp_unslash( $_POST['cp_country']        ?? '' ) );
    $phone       = sanitize_text_field( wp_unslash( $_POST['cp_phone']          ?? '' ) );
    $brand       = sanitize_text_field( wp_unslash( $_POST['cp_brand']          ?? '' ) );
    $model       = sanitize_text_field( wp_unslash( $_POST['cp_model']          ?? '' ) );
    $year        = absint( $_POST['cp_year'] ?? 0 );
    $website     = esc_url_raw( wp_unslash( $_POST['cp_website']                ?? '' ) );
    $video_url   = esc_url_raw( wp_unslash( $_POST['cp_video_url']              ?? '' ) );

    if ( ! $title ) $errors[] = __( 'Please enter a listing title.', 'classipress-pro' );
    if ( ! $description ) $errors[] = __( 'Please enter a description.', 'classipress-pro' );
    if ( ! $category ) $errors[] = __( 'Please select a category.', 'classipress-pro' );

    if ( empty( $errors ) ) {
        $paid    = get_theme_mod( 'cp_paid_listings', false );
        $status  = $paid ? 'pending' : ( current_user_can( 'publish_listings' ) ? 'publish' : 'pending' );

        $post_id = wp_insert_post( [
            'post_title'   => $title,
            'post_content' => $description,
            'post_status'  => $status,
            'post_type'    => 'listing',
            'post_author'  => get_current_user_id(),
        ] );

        if ( ! is_wp_error( $post_id ) ) {
            // Taxonomies
            if ( $category ) wp_set_object_terms( $post_id, $category, 'listing_category' );
            if ( $location_t ) wp_set_object_terms( $post_id, $location_t, 'listing_location' );

            // Meta
            $meta_fields = [
                '_cp_price'      => floatval( $price ),
                '_cp_price_type' => $price_type,
                '_cp_currency'   => $currency,
                '_cp_ad_type'    => $ad_type,
                '_cp_condition'  => $condition,
                '_cp_city'       => $city,
                '_cp_state'      => $state,
                '_cp_country'    => $country,
                '_cp_phone'      => $phone,
                '_cp_brand'      => $brand,
                '_cp_model'      => $model,
                '_cp_year'       => $year ?: '',
                '_cp_website'    => $website,
                '_cp_video_url'  => $video_url,
            ];
            foreach ( $meta_fields as $key => $val ) {
                update_post_meta( $post_id, $key, $val );
            }

            // Handle thumbnail upload
            if ( ! empty( $_FILES['listing_image']['tmp_name'] ) ) {
                require_once ABSPATH . 'wp-admin/includes/image.php';
                require_once ABSPATH . 'wp-admin/includes/file.php';
                require_once ABSPATH . 'wp-admin/includes/media.php';
                $attach_id = media_handle_upload( 'listing_image', $post_id );
                if ( ! is_wp_error( $attach_id ) ) {
                    set_post_thumbnail( $post_id, $attach_id );
                }
            }

            $success = true;
            $success_url = get_permalink( $post_id );
        } else {
            $errors[] = $post_id->get_error_message();
        }
    }
}
?>

<main id="main" class="site-main" role="main">
    <div class="cp-container cp-section-sm">
        <div style="max-width:760px;margin:0 auto;">

            <h1 style="font-size:1.75rem;font-weight:800;margin-bottom:.5rem;">
                <?php esc_html_e( 'Post a Free Listing', 'classipress-pro' ); ?>
            </h1>
            <p style="color:var(--cp-gray-500);margin-bottom:2rem;">
                <?php esc_html_e( 'Fill in the details below to list your item. Fields marked with * are required.', 'classipress-pro' ); ?>
            </p>

            <?php if ( ! is_user_logged_in() ) : ?>
            <div class="cp-alert cp-alert-warning">
                <?php printf(
                    wp_kses( __( '<strong>Login required.</strong> Please <a href="%s">log in</a> or <a href="%s">create an account</a> to post a listing.', 'classipress-pro' ), [ 'strong' => [], 'a' => [ 'href' => [] ] ] ),
                    esc_url( wp_login_url( get_permalink() ) ),
                    esc_url( wp_registration_url() )
                ); ?>
            </div>
            <?php elseif ( $success ) : ?>
            <div class="cp-alert cp-alert-success">
                ✅ <?php esc_html_e( 'Your listing has been submitted successfully!', 'classipress-pro' ); ?>
                <a href="<?php echo esc_url( $success_url ); ?>" style="font-weight:700;margin-left:.5rem;"><?php esc_html_e( 'View Listing →', 'classipress-pro' ); ?></a>
            </div>
            <?php else : ?>

            <?php foreach ( $errors as $error ) : ?>
            <div class="cp-alert cp-alert-error"><?php echo esc_html( $error ); ?></div>
            <?php endforeach; ?>

            <form method="post" enctype="multipart/form-data" novalidate id="cp-submit-listing-form">
                <?php wp_nonce_field( 'cp_submit_listing', 'cp_submit_listing_nonce' ); ?>

                <!-- BASIC INFO -->
                <div style="background:var(--cp-white);border-radius:var(--cp-border-radius-lg);padding:1.5rem;border:1px solid var(--cp-gray-100);margin-bottom:1.5rem;">
                    <h2 style="font-size:1.0625rem;font-weight:700;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--cp-gray-100);">
                        📝 <?php esc_html_e( 'Basic Information', 'classipress-pro' ); ?>
                    </h2>

                    <div class="cp-form-group">
                        <label for="listing-title"><?php esc_html_e( 'Listing Title', 'classipress-pro' ); ?> <span class="required" aria-hidden="true">*</span></label>
                        <input type="text" id="listing-title" name="listing_title" class="cp-input" required maxlength="200" value="<?php echo esc_attr( $title ?? '' ); ?>" placeholder="<?php esc_attr_e( 'e.g. iPhone 15 Pro Max – 256GB', 'classipress-pro' ); ?>">
                    </div>

                    <div class="cp-form-row">
                        <div class="cp-form-group">
                            <label for="listing-category"><?php esc_html_e( 'Category', 'classipress-pro' ); ?> <span class="required" aria-hidden="true">*</span></label>
                            <select id="listing-category" name="listing_category" class="cp-select" required>
                                <option value=""><?php esc_html_e( 'Select a category', 'classipress-pro' ); ?></option>
                                <?php
                                $cats = get_terms( [ 'taxonomy' => 'listing_category', 'parent' => 0, 'hide_empty' => false ] );
                                if ( $cats && ! is_wp_error( $cats ) ) :
                                    foreach ( $cats as $cat ) :
                                        echo '<option value="' . esc_attr( $cat->term_id ) . '" ' . selected( $category ?? 0, $cat->term_id, false ) . '>' . esc_html( $cat->name ) . '</option>';
                                        $subcats = get_terms( [ 'taxonomy' => 'listing_category', 'parent' => $cat->term_id, 'hide_empty' => false ] );
                                        if ( $subcats && ! is_wp_error( $subcats ) ) {
                                            foreach ( $subcats as $subcat ) {
                                                echo '<option value="' . esc_attr( $subcat->term_id ) . '" ' . selected( $category ?? 0, $subcat->term_id, false ) . '>— ' . esc_html( $subcat->name ) . '</option>';
                                            }
                                        }
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>

                        <div class="cp-form-group">
                            <label for="listing-ad-type"><?php esc_html_e( 'Ad Type', 'classipress-pro' ); ?></label>
                            <select id="listing-ad-type" name="cp_ad_type" class="cp-select">
                                <?php
                                $types = [ 'sell' => __( 'For Sale', 'classipress-pro' ), 'buy' => __( 'Wanted', 'classipress-pro' ), 'rent' => __( 'For Rent', 'classipress-pro' ), 'service' => __( 'Service', 'classipress-pro' ), 'free' => __( 'Free', 'classipress-pro' ) ];
                                foreach ( $types as $v => $l ) echo '<option value="' . esc_attr( $v ) . '" ' . selected( $ad_type ?? 'sell', $v, false ) . '>' . esc_html( $l ) . '</option>';
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="cp-form-group">
                        <label for="listing-description"><?php esc_html_e( 'Description', 'classipress-pro' ); ?> <span class="required" aria-hidden="true">*</span></label>
                        <textarea id="listing-description" name="listing_description" class="cp-textarea" rows="7" required placeholder="<?php esc_attr_e( 'Describe your item in detail — condition, features, reason for selling...', 'classipress-pro' ); ?>"><?php echo esc_textarea( $description ?? '' ); ?></textarea>
                    </div>
                </div>

                <!-- PRICING -->
                <div style="background:var(--cp-white);border-radius:var(--cp-border-radius-lg);padding:1.5rem;border:1px solid var(--cp-gray-100);margin-bottom:1.5rem;">
                    <h2 style="font-size:1.0625rem;font-weight:700;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--cp-gray-100);">
                        💰 <?php esc_html_e( 'Pricing', 'classipress-pro' ); ?>
                    </h2>

                    <div class="cp-form-row">
                        <div class="cp-form-group">
                            <label for="cp-price"><?php esc_html_e( 'Price', 'classipress-pro' ); ?></label>
                            <input type="number" id="cp-price" name="cp_price" class="cp-input" min="0" step="0.01" value="<?php echo esc_attr( $price ?? '' ); ?>" placeholder="0.00">
                        </div>
                        <div class="cp-form-group">
                            <label for="cp-currency"><?php esc_html_e( 'Currency', 'classipress-pro' ); ?></label>
                            <select id="cp-currency" name="cp_currency" class="cp-select">
                                <?php
                                $currencies = [ 'USD' => 'USD ($)', 'EUR' => 'EUR (€)', 'GBP' => 'GBP (£)', 'INR' => 'INR (₹)', 'AUD' => 'AUD (A$)', 'CAD' => 'CAD (C$)', 'JPY' => 'JPY (¥)' ];
                                foreach ( $currencies as $code => $label ) {
                                    echo '<option value="' . esc_attr( $code ) . '" ' . selected( $currency ?? 'USD', $code, false ) . '>' . esc_html( $label ) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="cp-form-group">
                        <label><?php esc_html_e( 'Price Type', 'classipress-pro' ); ?></label>
                        <div style="display:flex;gap:1rem;flex-wrap:wrap;">
                            <?php
                            $ptypes = [ 'fixed' => __( 'Fixed', 'classipress-pro' ), 'negotiable' => __( 'Negotiable', 'classipress-pro' ), 'on_call' => __( 'Contact for Price', 'classipress-pro' ), 'free' => __( 'Free', 'classipress-pro' ) ];
                            foreach ( $ptypes as $v => $l ) :
                            ?>
                            <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;">
                                <input type="radio" name="cp_price_type" value="<?php echo esc_attr( $v ); ?>" <?php checked( $price_type ?? 'fixed', $v ); ?> style="accent-color:var(--cp-primary);">
                                <?php echo esc_html( $l ); ?>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- DETAILS -->
                <div style="background:var(--cp-white);border-radius:var(--cp-border-radius-lg);padding:1.5rem;border:1px solid var(--cp-gray-100);margin-bottom:1.5rem;">
                    <h2 style="font-size:1.0625rem;font-weight:700;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--cp-gray-100);">
                        🏷️ <?php esc_html_e( 'Item Details', 'classipress-pro' ); ?>
                    </h2>

                    <div class="cp-form-row">
                        <div class="cp-form-group">
                            <label for="cp-condition"><?php esc_html_e( 'Condition', 'classipress-pro' ); ?></label>
                            <select id="cp-condition" name="cp_condition" class="cp-select">
                                <option value=""><?php esc_html_e( 'Select condition', 'classipress-pro' ); ?></option>
                                <option value="new"    <?php selected( $condition ?? '', 'new' ); ?>><?php esc_html_e( 'New',         'classipress-pro' ); ?></option>
                                <option value="used"   <?php selected( $condition ?? '', 'used' ); ?>><?php esc_html_e( 'Used',        'classipress-pro' ); ?></option>
                                <option value="refurb" <?php selected( $condition ?? '', 'refurb' ); ?>><?php esc_html_e( 'Refurbished', 'classipress-pro' ); ?></option>
                            </select>
                        </div>
                        <div class="cp-form-group">
                            <label for="cp-brand"><?php esc_html_e( 'Brand / Make', 'classipress-pro' ); ?></label>
                            <input type="text" id="cp-brand" name="cp_brand" class="cp-input" value="<?php echo esc_attr( $brand ?? '' ); ?>">
                        </div>
                    </div>

                    <div class="cp-form-row">
                        <div class="cp-form-group">
                            <label for="cp-model"><?php esc_html_e( 'Model', 'classipress-pro' ); ?></label>
                            <input type="text" id="cp-model" name="cp_model" class="cp-input" value="<?php echo esc_attr( $model ?? '' ); ?>">
                        </div>
                        <div class="cp-form-group">
                            <label for="cp-year"><?php esc_html_e( 'Year', 'classipress-pro' ); ?></label>
                            <input type="number" id="cp-year" name="cp_year" class="cp-input" min="1900" max="<?php echo esc_attr( date( 'Y' ) + 1 ); ?>" value="<?php echo esc_attr( $year ?? '' ); ?>">
                        </div>
                    </div>
                </div>

                <!-- LOCATION -->
                <div style="background:var(--cp-white);border-radius:var(--cp-border-radius-lg);padding:1.5rem;border:1px solid var(--cp-gray-100);margin-bottom:1.5rem;">
                    <h2 style="font-size:1.0625rem;font-weight:700;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--cp-gray-100);">
                        📍 <?php esc_html_e( 'Location', 'classipress-pro' ); ?>
                    </h2>

                    <div class="cp-form-row">
                        <div class="cp-form-group">
                            <label for="cp-city"><?php esc_html_e( 'City', 'classipress-pro' ); ?></label>
                            <input type="text" id="cp-city" name="cp_city" class="cp-input" value="<?php echo esc_attr( $city ?? '' ); ?>">
                        </div>
                        <div class="cp-form-group">
                            <label for="cp-state"><?php esc_html_e( 'State / Province', 'classipress-pro' ); ?></label>
                            <input type="text" id="cp-state" name="cp_state" class="cp-input" value="<?php echo esc_attr( $state ?? '' ); ?>">
                        </div>
                    </div>

                    <div class="cp-form-group">
                        <label for="cp-country"><?php esc_html_e( 'Country', 'classipress-pro' ); ?></label>
                        <input type="text" id="cp-country" name="cp_country" class="cp-input" value="<?php echo esc_attr( $country ?? '' ); ?>">
                    </div>
                </div>

                <!-- CONTACT -->
                <div style="background:var(--cp-white);border-radius:var(--cp-border-radius-lg);padding:1.5rem;border:1px solid var(--cp-gray-100);margin-bottom:1.5rem;">
                    <h2 style="font-size:1.0625rem;font-weight:700;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--cp-gray-100);">
                        📞 <?php esc_html_e( 'Contact', 'classipress-pro' ); ?>
                    </h2>

                    <div class="cp-form-group">
                        <label for="cp-phone"><?php esc_html_e( 'Phone Number', 'classipress-pro' ); ?></label>
                        <input type="tel" id="cp-phone" name="cp_phone" class="cp-input" value="<?php echo esc_attr( $phone ?? '' ); ?>" placeholder="+1 555 000 0000">
                    </div>

                    <div class="cp-form-group">
                        <label for="cp-website"><?php esc_html_e( 'Website / Product URL', 'classipress-pro' ); ?></label>
                        <input type="url" id="cp-website" name="cp_website" class="cp-input" value="<?php echo esc_attr( $website ?? '' ); ?>" placeholder="https://...">
                    </div>
                </div>

                <!-- MEDIA -->
                <div style="background:var(--cp-white);border-radius:var(--cp-border-radius-lg);padding:1.5rem;border:1px solid var(--cp-gray-100);margin-bottom:1.5rem;">
                    <h2 style="font-size:1.0625rem;font-weight:700;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--cp-gray-100);">
                        🖼️ <?php esc_html_e( 'Photos', 'classipress-pro' ); ?>
                    </h2>

                    <div class="cp-upload-area" id="cp-upload-area" onclick="document.getElementById('listing-image').click();" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Upload photo', 'classipress-pro' ); ?>">
                        <div style="font-size:2.5rem;margin-bottom:.5rem;" aria-hidden="true">📷</div>
                        <p style="font-weight:700;margin-bottom:.25rem;"><?php esc_html_e( 'Click or drag to upload a photo', 'classipress-pro' ); ?></p>
                        <p style="font-size:.8125rem;color:var(--cp-gray-500);"><?php esc_html_e( 'JPEG, PNG, WebP — max 5MB', 'classipress-pro' ); ?></p>
                    </div>
                    <input type="file" id="listing-image" name="listing_image" accept="image/jpeg,image/png,image/webp" style="display:none;" aria-label="<?php esc_attr_e( 'Upload listing image', 'classipress-pro' ); ?>">

                    <div class="cp-form-group" style="margin-top:1rem;">
                        <label for="cp-video-url"><?php esc_html_e( 'Video URL (YouTube or Vimeo)', 'classipress-pro' ); ?></label>
                        <input type="url" id="cp-video-url" name="cp_video_url" class="cp-input" value="<?php echo esc_attr( $video_url ?? '' ); ?>" placeholder="https://youtube.com/...">
                    </div>
                </div>

                <!-- SUBMIT -->
                <div style="display:flex;gap:1rem;align-items:center;flex-wrap:wrap;">
                    <button type="submit" class="cp-btn cp-btn-primary cp-btn-lg">
                        🚀 <?php esc_html_e( 'Submit Listing', 'classipress-pro' ); ?>
                    </button>
                    <a href="<?php echo esc_url( home_url() ); ?>" class="cp-btn cp-btn-ghost">
                        <?php esc_html_e( 'Cancel', 'classipress-pro' ); ?>
                    </a>
                    <p style="font-size:.8125rem;color:var(--cp-gray-500);">
                        <?php
                        if ( get_theme_mod( 'cp_paid_listings', false ) ) {
                            esc_html_e( 'Your listing will be reviewed before going live.', 'classipress-pro' );
                        } else {
                            esc_html_e( 'Your listing will go live immediately after submission.', 'classipress-pro' );
                        }
                        ?>
                    </p>
                </div>

            </form>

            <?php endif; ?>

        </div>
    </div>
</main>

<?php get_footer(); ?>
