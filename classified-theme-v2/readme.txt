=== ClassiPress Pro ===

Theme Name:   ClassiPress Pro
Version:      1.0.0
Requires:     WordPress 6.0+
Tested up to: WordPress 6.7
PHP Required: 8.0+
License:      GPLv2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  classipress-pro

== DESCRIPTION ==

ClassiPress Pro is a full-featured classified ads WordPress theme, similar to Classima and CL Classified. It is built to the highest WordPress coding standards and supports all major WordPress plugins.

== FEATURES ==

CLASSIFIED ADS
- Custom Post Type: "listing" with rich meta fields
- Custom Taxonomies: category, tag, location, condition
- Advanced search and filter sidebar (price, category, location, condition, ad type)
- Grid / list toggle view
- Featured, urgent, and verified listing badges
- Listing expiry system
- View counter
- Gallery with thumbnails
- Related listings
- Contact seller form (AJAX)
- WhatsApp integration
- Wishlist / save listings (AJAX)
- Live search autocomplete (AJAX)

MONETIZATION
- Paid listing support via WooCommerce
- Package / pricing plan post type
- Free listing limits per user

USER MANAGEMENT
- Custom roles: listing_poster, listing_moderator
- User dashboard shortcode
- Seller profile pages
- Wishlist management

DESIGN
- Responsive, mobile-first layout
- Sticky header
- Hero section with search form and statistics
- Category grid with icons
- Customizer-powered color, font, layout controls
- Dark footer with social links and widget columns

DEVELOPER FRIENDLY
- Fully hooked with classipress_* action/filter hooks
- WordPress Coding Standards compliant
- Composer-ready
- REST API support for all listing fields
- Schema.org markup (Product, BlogPosting)
- Proper escaping on all output
- Nonce verification on all forms and AJAX
- Custom capabilities and meta cap mapping

PLUGIN COMPATIBILITY
- WooCommerce: custom wrappers, gallery support, paid listings
- Elementor: registered header/footer/single/archive locations
- Yoast SEO / RankMath: OpenGraph ready, breadcrumb support
- WPML / Polylang: translation-ready with .pot file
- Contact Form 7: style integration
- ACF (Advanced Custom Fields): JSON sync folder included
- Gravity Forms: styled form elements
- WP Super Cache / W3TC: static page cache friendly
- LearnDash / TutorLMS: general support via archive/single fallbacks
- BuddyPress / BuddyBoss: body class and template hooks
- WP Job Manager: coexistence (separate CPTs)

STANDARDS
- WCAG 2.1 Level AA accessibility
- skip link, ARIA landmarks, aria-label on all controls
- Schema.org structured data
- Core Web Vitals optimized (lazy images, deferred JS)
- RTL stylesheet ready

== INSTALLATION ==

1. Upload the "classipress-pro" folder to wp-content/themes/
2. Activate the theme from Appearance > Themes
3. Go to Appearance > Customize to configure colors, logo, and settings
4. Add your listing categories under Listings > Categories
5. Create pages for: Submit Listing, User Dashboard
6. Assign pages in Appearance > Customize > Classified Ads Settings
7. Use the shortcodes [cp_listings], [cp_categories], [cp_search_form] in pages

== SHORTCODES ==

[cp_listings]             — Display listings grid
[cp_categories]           — Display category grid
[cp_search_form]          — Display search form
[cp_post_listing_button]  — Display "Post Ad" button
[cp_user_dashboard]       — Display user dashboard

== THEME OPTIONS (Customizer) ==

Panel: Classified Ads Settings
- General: Primary color, accent color, listings per page
- Homepage: Hero title/subtitle/image, stats toggle
- Header: Search visibility, post button text, sticky header
- Listings: Default view, sidebar, maps API key
- Footer: Copyright, social links
- Monetization: Paid listings, free limit per user

== CHANGELOG ==

= 1.0.0 =
* Initial release
