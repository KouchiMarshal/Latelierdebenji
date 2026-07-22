<?php
/**
 * Page boutique (archive produits WooCommerce), avec l'identité visuelle du site.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" class="site-main shop-page">
	<section class="page-hero wrap">
		<span class="hero-eyebrow"><?php esc_html_e( 'Nos créations', 'atelier-benji' ); ?></span>
		<h1 class="section-title"><?php woocommerce_page_title(); ?></h1>
		<hr class="divider">
		<p class="page-hero-content">
			<?php esc_html_e( 'Chaque composition est réalisée à la main, pièce par pièce, avec des fleurs séchées et de la verdure stabilisée.', 'atelier-benji' ); ?>
		</p>
	</section>

	<section class="shop-section wrap">
		<?php
		/**
		 * Reprend les hooks WooCommerce standards (tri, résultats, pagination)
		 * pour garder toutes les fonctionnalités, dans notre propre mise en page.
		 */
		if ( woocommerce_product_loop() ) {

			do_action( 'woocommerce_before_shop_loop' );

			woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				while ( have_posts() ) {
					the_post();
					do_action( 'woocommerce_shop_loop' );
					wc_get_template_part( 'content', 'product' );
				}
			}

			woocommerce_product_loop_end();

			do_action( 'woocommerce_after_shop_loop' );
		} else {
			do_action( 'woocommerce_no_products_found' );
		}
		?>
	</section>
</main>

<?php
get_footer();
