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
			<span class="hero-eyebrow"><?php esc_html_e( 'Fait main, en Normandie', 'atelier-benji' ); ?></span>
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
			<div class="about-visual">
				<img
					src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/benjamin.jpg' ); ?>"
					alt="<?php esc_attr_e( 'Benjamin, fondateur de L\'Atelier de Benji, avec un bouquet', 'atelier-benji' ); ?>"
				>
			</div>
			<div class="about-text">
				<h2 class="section-title"><?php esc_html_e( 'Notre histoire', 'atelier-benji' ); ?></h2>
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
						<p class="about-intro"><?php esc_html_e( "Bienvenue dans l'univers de L'Atelier de Benji. 🌾✨", 'atelier-benji' ); ?></p>
						<p><?php esc_html_e( "Je m'appelle Benjamin, j'ai 21 ans et je suis un jeune artisan fleuriste passionné, installé en Normandie. Depuis maintenant 5 ans que j'exerce dans la fleuristerie, je vis au rythme des fleurs et de la création florale, avec une affection toute particulière pour les fleurs séchées.", 'atelier-benji' ); ?></p>
						<p><?php esc_html_e( "À travers L'Atelier de Benji, j'ai souhaité créer un univers qui me ressemble : chaleureux, naturel et authentique. Chaque création est imaginée et réalisée à la main avec soin, afin de vous proposer des compositions uniques qui traversent le temps tout en conservant toute leur beauté.", 'atelier-benji' ); ?></p>
						<p><?php esc_html_e( 'Bouquets, couronnes, décorations murales, créations personnalisées… Chaque pièce est pensée pour sublimer votre intérieur ou accompagner les moments importants de votre vie.', 'atelier-benji' ); ?></p>
						<p><?php esc_html_e( "Mon ambition est de partager ma passion, mon savoir-faire et ma créativité en proposant des créations artisanales qui racontent une histoire et apportent une touche de douceur à votre quotidien.", 'atelier-benji' ); ?></p>
						<p class="about-thanks"><?php esc_html_e( "Merci de faire partie de cette belle aventure et de soutenir le projet d'un jeune entrepreneur passionné.", 'atelier-benji' ); ?></p>
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
