<?php
/**
 * Front page: hero, produits en avant, présentation de l'atelier.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" class="site-main front-page">
	<section class="hero">
		<div class="wrap hero-inner">
			<h1 class="hero-title"><?php bloginfo( 'name' ); ?></h1>
			<p class="hero-subtitle"><?php bloginfo( 'description' ); ?></p>
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<a class="button button-primary" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">
					<?php esc_html_e( 'Découvrir la boutique', 'atelier-benji' ); ?>
				</a>
			<?php endif; ?>
		</div>
	</section>

	<?php if ( class_exists( 'WooCommerce' ) ) : ?>
		<section class="featured-products wrap">
			<h2 class="section-title"><?php esc_html_e( 'Nos créations', 'atelier-benji' ); ?></h2>
			<?php echo do_shortcode( '[products limit="8" columns="4" orderby="date" order="DESC"]' ); ?>
		</section>
	<?php endif; ?>

	<section class="about wrap">
		<h2 class="section-title"><?php esc_html_e( "L'atelier", 'atelier-benji' ); ?></h2>
		<div class="about-content">
			<?php
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					the_content();
				}
			} else {
				esc_html_e( 'Présentez ici votre atelier, votre savoir-faire et votre histoire.', 'atelier-benji' );
			}
			?>
		</div>
	</section>
</main>

<?php
get_footer();
