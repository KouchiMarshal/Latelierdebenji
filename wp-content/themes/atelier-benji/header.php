<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
	<div class="wrap site-header-inner">
		<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<img
					class="site-logo-img"
					src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo.jpg' ); ?>"
					alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
				>
			<?php endif; ?>
		</a>

		<nav class="site-nav" id="site-nav" aria-label="<?php esc_attr_e( 'Menu principal', 'atelier-benji' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'nav-menu',
					'fallback_cb'    => false,
				)
			);
			?>
		</nav>

		<div class="site-header-actions">
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<div class="site-cart">
					<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-link">
						<?php esc_html_e( 'Panier', 'atelier-benji' ); ?>
						(<?php echo esc_html( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?>)
					</a>
				</div>
			<?php endif; ?>

			<button
				type="button"
				class="nav-toggle"
				aria-expanded="false"
				aria-controls="site-nav"
				aria-label="<?php esc_attr_e( 'Ouvrir le menu', 'atelier-benji' ); ?>"
			>
				<span class="nav-toggle-bar"></span>
				<span class="nav-toggle-bar"></span>
				<span class="nav-toggle-bar"></span>
			</button>
		</div>
	</div>
</header>
