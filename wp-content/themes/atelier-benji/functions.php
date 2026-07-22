<?php
/**
 * Atelier Benji theme setup.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function atelier_benji_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 220,
			'width'       => 220,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus(
		array(
			'primary' => __( 'Menu principal', 'atelier-benji' ),
			'footer'  => __( 'Menu pied de page', 'atelier-benji' ),
		)
	);
}
add_action( 'after_setup_theme', 'atelier_benji_setup' );

function atelier_benji_scripts() {
	wp_enqueue_style(
		'atelier-benji-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,500&family=Dancing+Script:wght@600&family=Jost:wght@400;500&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'atelier-benji-style', get_stylesheet_uri(), array(), '1.3.0' );
	wp_enqueue_style( 'atelier-benji-main', get_template_directory_uri() . '/assets/css/main.css', array( 'atelier-benji-style', 'atelier-benji-fonts' ), '1.3.0' );
	wp_enqueue_script( 'atelier-benji-main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.3.0', true );
}
add_action( 'wp_enqueue_scripts', 'atelier_benji_scripts' );

function atelier_benji_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Pied de page', 'atelier-benji' ),
			'id'            => 'footer-1',
			'before_widget' => '<div class="footer-widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="footer-widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'atelier_benji_widgets_init' );

/**
 * Replace WooCommerce's default content wrapper with the theme's own
 * so shop/product/cart/checkout pages sit inside the site's <main>.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_before_main_content', 'atelier_benji_wc_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'atelier_benji_wc_wrapper_end', 10 );

function atelier_benji_wc_wrapper_start() {
	echo '<main id="main" class="site-main woocommerce-content">';
}

function atelier_benji_wc_wrapper_end() {
	echo '</main>';
}

/**
 * Number of products per row/page on the shop archive.
 */
add_filter(
	'loop_shop_columns',
	function () {
		return 4;
	}
);

/**
 * Handle the front-end contact form (template-contact.php) without a plugin.
 */
function atelier_benji_handle_contact_form() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/' );

	if (
		! isset( $_POST['atelier_benji_contact_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['atelier_benji_contact_nonce'] ) ), 'atelier_benji_contact' )
	) {
		wp_safe_redirect( add_query_arg( 'sent', 'error', $redirect ) );
		exit;
	}

	// Honeypot: bots fill hidden fields, humans don't.
	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'sent', '1', $redirect ) );
		exit;
	}

	$name    = isset( $_POST['contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ) : '';
	$email   = isset( $_POST['contact_email'] ) ? sanitize_email( wp_unslash( $_POST['contact_email'] ) ) : '';
	$subject = isset( $_POST['contact_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_subject'] ) ) : '';
	$message = isset( $_POST['contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ) ) : '';

	if ( ! $name || ! is_email( $email ) || ! $message ) {
		wp_safe_redirect( add_query_arg( 'sent', 'error', $redirect ) );
		exit;
	}

	$to      = get_bloginfo( 'admin_email' );
	$title   = $subject ? $subject : __( 'Nouveau message depuis le site', 'atelier-benji' );
	$body    = sprintf(
		"Nom : %s\nEmail : %s\n\nMessage :\n%s",
		$name,
		$email,
		$message
	);
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	$sent = wp_mail( $to, $title, $body, $headers );

	wp_safe_redirect( add_query_arg( 'sent', $sent ? '1' : 'error', $redirect ) );
	exit;
}
add_action( 'admin_post_nopriv_atelier_benji_contact', 'atelier_benji_handle_contact_form' );
add_action( 'admin_post_atelier_benji_contact', 'atelier_benji_handle_contact_form' );
