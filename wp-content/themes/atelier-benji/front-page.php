<?php
/**
 * Front page: hero, points forts, produits en avant, atelier, citation, contact.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" class="site-main front-page">
	<section class="hero">
		<div class="wrap hero-inner">
			<span class="hero-eyebrow"><?php esc_html_e( 'Fait main, à Lyon', 'atelier-benji' ); ?></span>
			<h1 class="hero-title"><?php bloginfo( 'name' ); ?></h1>
			<p class="hero-subtitle">
				<?php
				$tagline = get_bloginfo( 'description' );
				echo esc_html( $tagline ? $tagline : __( 'Compositions florales séchées, cueillies et assemblées à la main pour habiller votre intérieur toute l\'année.', 'atelier-benji' ) );
				?>
			</p>
			<div class="hero-actions">
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<a class="button button-primary" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">
						<?php esc_html_e( 'Découvrir la boutique', 'atelier-benji' ); ?>
					</a>
				<?php endif; ?>
				<a class="button button-outline" href="#atelier">
					<?php esc_html_e( "Notre histoire", 'atelier-benji' ); ?>
				</a>
			</div>
		</div>
	</section>

	<section class="usp-strip">
		<div class="wrap usp-grid">
			<div class="usp-item">
				<span class="usp-icon">🌿</span>
				<h3><?php esc_html_e( 'Fait main', 'atelier-benji' ); ?></h3>
				<p><?php esc_html_e( 'Chaque bouquet est composé à la pièce, dans notre atelier.', 'atelier-benji' ); ?></p>
			</div>
			<div class="usp-item">
				<span class="usp-icon">🕰️</span>
				<h3><?php esc_html_e( 'Longue conservation', 'atelier-benji' ); ?></h3>
				<p><?php esc_html_e( "Des fleurs séchées qui gardent leur beauté plusieurs années.", 'atelier-benji' ); ?></p>
			</div>
			<div class="usp-item">
				<span class="usp-icon">📦</span>
				<h3><?php esc_html_e( 'Livraison soignée', 'atelier-benji' ); ?></h3>
				<p><?php esc_html_e( 'Emballage protégé, expédié partout en France.', 'atelier-benji' ); ?></p>
			</div>
		</div>
	</section>

	<?php if ( class_exists( 'WooCommerce' ) ) : ?>
		<section class="featured-products wrap">
			<h2 class="section-title"><?php esc_html_e( 'Nos compositions', 'atelier-benji' ); ?></h2>
			<p class="section-intro"><?php esc_html_e( 'Une sélection de nos créations du moment, en édition limitée.', 'atelier-benji' ); ?></p>
			<?php echo do_shortcode( '[products limit="8" columns="4" orderby="date" order="DESC"]' ); ?>
			<p class="cta-more">
				<a class="button button-outline" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">
					<?php esc_html_e( 'Voir toute la boutique', 'atelier-benji' ); ?>
				</a>
			</p>
		</section>
	<?php endif; ?>

	<section class="about wrap" id="atelier">
		<div class="about-grid">
			<div class="about-visual" role="presentation"></div>
			<div class="about-text">
				<h2 class="section-title"><?php esc_html_e( "L'atelier", 'atelier-benji' ); ?></h2>
				<hr class="divider">
				<div class="about-content">
					<?php
					if ( have_posts() ) {
						while ( have_posts() ) {
							the_post();
							the_content();
						}
					} else {
						?>
						<p><?php esc_html_e( "L'Atelier de Benji est né d'une passion pour les fleurs séchées et le savoir-faire artisanal. Chaque composition est pensée et assemblée à la main, brin par brin, pour capturer la douceur d'un bouquet champêtre — sans jamais se faner.", 'atelier-benji' ); ?></p>
						<p><?php esc_html_e( "Installé au cœur de l'atelier, chaque bouquet est unique : les variations naturelles des fleurs séchées font que deux compositions ne sont jamais tout à fait identiques.", 'atelier-benji' ); ?></p>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</section>

	<section class="quote-section">
		<div class="wrap">
			<p class="quote-text">&laquo; Des fleurs qui ne se fanent pas, pour des souvenirs qui durent. &raquo;</p>
			<p class="quote-author">— L'Atelier de Benji</p>
		</div>
	</section>

	<section class="cta-band">
		<div class="wrap">
			<h2 class="section-title"><?php esc_html_e( 'Une envie particulière ?', 'atelier-benji' ); ?></h2>
			<p><?php esc_html_e( 'Composition sur-mesure, événement, cadeau — parlons-en et créons ensemble le bouquet parfait.', 'atelier-benji' ); ?></p>
			<?php
			$contact_page = get_page_by_path( 'contact' );
			$contact_url  = $contact_page ? get_permalink( $contact_page ) : 'mailto:' . get_bloginfo( 'admin_email' );
			?>
			<a class="button button-outline" href="<?php echo esc_url( $contact_url ); ?>">
				<?php esc_html_e( 'Nous contacter', 'atelier-benji' ); ?>
			</a>
		</div>
	</section>
</main>

<?php
get_footer();
