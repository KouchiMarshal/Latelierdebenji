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
	wp_enqueue_style( 'atelier-benji-style', get_stylesheet_uri(), array(), '1.0.0' );
	wp_enqueue_style( 'atelier-benji-main', get_template_directory_uri() . '/assets/css/main.css', array( 'atelier-benji-style' ), '1.0.0' );
	wp_enqueue_script( 'atelier-benji-main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true );
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
