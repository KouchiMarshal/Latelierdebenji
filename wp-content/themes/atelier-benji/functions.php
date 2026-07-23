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
	wp_enqueue_style( 'atelier-benji-style', get_stylesheet_uri(), array(), '1.13.0' );
	wp_enqueue_style( 'atelier-benji-main', get_template_directory_uri() . '/assets/css/main.css', array( 'atelier-benji-style', 'atelier-benji-fonts' ), '1.13.0' );
	wp_enqueue_script( 'atelier-benji-main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.13.0', true );
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
	echo '<main id="main" class="site-main woocommerce-content"><div class="wrap woocommerce-wrap">';
}

function atelier_benji_wc_wrapper_end() {
	echo '</div></main>';
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

/**
 * Champs de personnalisation (texte + couleur) sur les couronnes personnalisables.
 * IDs des produits concernés : Couronne de naissance personnalisée (35),
 * Couronne photo personnalisée - Souvenirs (39).
 */
function atelier_benji_personalizable_product_ids() {
	return array( 35, 39 );
}

/**
 * Couleurs disponibles pour les fleurs séchées (fournisseur).
 */
function atelier_benji_color_options() {
	return array(
		'Argent',
		'Blanc',
		'Blanchi',
		'Bleu',
		'Bordeaux',
		'Bronze',
		'Brun',
		'Crème',
		'Gris',
		'Jaune',
		'Lavande',
		'Métallique',
		'Mix',
		'Naturel',
		'Noir',
		'Or',
		'Orange',
		'Rose',
		'Rouge',
		'Saumon',
		'Terre cuite',
		'Vert',
		'Violet',
	);
}

add_action( 'woocommerce_before_add_to_cart_button', 'atelier_benji_personalization_fields' );
function atelier_benji_personalization_fields() {
	global $product;

	if ( ! $product || ! in_array( $product->get_id(), atelier_benji_personalizable_product_ids(), true ) ) {
		return;
	}
	?>
	<div class="atelier-benji-personalization">
		<p class="form-field">
			<label for="atelier_benji_text">
				<?php esc_html_e( 'Texte à personnaliser (prénom, dédicace…)', 'atelier-benji' ); ?>
				<span class="required">*</span>
			</label>
			<input type="text" id="atelier_benji_text" name="atelier_benji_text">
		</p>
		<fieldset class="atelier-benji-color-choices">
			<legend>
				<?php esc_html_e( 'Couleurs souhaitées (jusqu’à 4)', 'atelier-benji' ); ?>
				<span class="required">*</span>
			</legend>
			<div class="atelier-benji-color-grid">
				<?php foreach ( atelier_benji_color_options() as $color ) : ?>
					<label class="atelier-benji-color-chip">
						<input type="checkbox" class="atelier-benji-color-checkbox" name="atelier_benji_color[]" value="<?php echo esc_attr( $color ); ?>">
						<span><?php echo esc_html( $color ); ?></span>
					</label>
				<?php endforeach; ?>
			</div>
		</fieldset>
	</div>
	<?php
}

/**
 * Options payantes propres a la couronne de naissance (35) :
 * peluche, taille du prenom, couleur et matiere du noeud.
 */
function atelier_benji_wreath_addon_product_ids() {
	return array( 35 );
}

function atelier_benji_peluche_options() {
	return array(
		''       => __( 'Aucune', 'atelier-benji' ),
		'ourson' => __( 'Ourson (+12€)', 'atelier-benji' ),
		'lapin'  => __( 'Lapin (+15€)', 'atelier-benji' ),
	);
}

function atelier_benji_peluche_price( $key ) {
	$prices = array(
		'ourson' => 12,
		'lapin'  => 15,
	);
	return isset( $prices[ $key ] ) ? $prices[ $key ] : 0;
}

function atelier_benji_prenom_taille_options() {
	return array(
		''      => __( 'Aucun', 'atelier-benji' ),
		'petit' => __( 'Petit - 1 ligne (+6€)', 'atelier-benji' ),
		'grand' => __( 'Grand - 2 lignes (+10€)', 'atelier-benji' ),
	);
}

function atelier_benji_prenom_taille_price( $key ) {
	$prices = array(
		'petit' => 6,
		'grand' => 10,
	);
	return isset( $prices[ $key ] ) ? $prices[ $key ] : 0;
}

function atelier_benji_noeud_couleur_options() {
	return array( 'Blanc', 'Ivoire', 'Beige', 'Marron', 'Noir', 'Rouge', 'Rose', 'Bleu', 'Vert', 'Doré', 'Argenté', 'Bordeaux' );
}

function atelier_benji_noeud_matiere_options() {
	return array( 'Jute', 'Satin' );
}

add_action( 'woocommerce_before_add_to_cart_button', 'atelier_benji_wreath_prenom_field', 5 );
function atelier_benji_wreath_prenom_field() {
	global $product;

	if ( ! $product || ! in_array( $product->get_id(), atelier_benji_wreath_addon_product_ids(), true ) ) {
		return;
	}
	?>
	<div class="atelier-benji-personalization atelier-benji-wreath-addons">
		<p class="form-field">
			<label for="atelier_benji_prenom_taille">
				<?php esc_html_e( 'Prénom en fil de fer', 'atelier-benji' ); ?>
			</label>
			<select id="atelier_benji_prenom_taille" name="atelier_benji_prenom_taille">
				<?php foreach ( atelier_benji_prenom_taille_options() as $key => $label ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
	</div>
	<?php
}

add_action( 'woocommerce_before_add_to_cart_button', 'atelier_benji_wreath_addon_fields', 20 );
function atelier_benji_wreath_addon_fields() {
	global $product;

	if ( ! $product || ! in_array( $product->get_id(), atelier_benji_wreath_addon_product_ids(), true ) ) {
		return;
	}
	?>
	<div class="atelier-benji-personalization atelier-benji-wreath-addons">
		<p class="form-field">
			<label for="atelier_benji_peluche">
				<?php esc_html_e( 'Peluche', 'atelier-benji' ); ?>
			</label>
			<select id="atelier_benji_peluche" name="atelier_benji_peluche">
				<?php foreach ( atelier_benji_peluche_options() as $key => $label ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p class="form-field">
			<label for="atelier_benji_noeud_couleur">
				<?php esc_html_e( 'Couleur du nœud', 'atelier-benji' ); ?>
			</label>
			<select id="atelier_benji_noeud_couleur" name="atelier_benji_noeud_couleur">
				<?php foreach ( atelier_benji_noeud_couleur_options() as $color ) : ?>
					<option value="<?php echo esc_attr( $color ); ?>"><?php echo esc_html( $color ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p class="form-field">
			<label for="atelier_benji_noeud_matiere">
				<?php esc_html_e( 'Matière du nœud', 'atelier-benji' ); ?>
			</label>
			<select id="atelier_benji_noeud_matiere" name="atelier_benji_noeud_matiere">
				<?php foreach ( atelier_benji_noeud_matiere_options() as $matiere ) : ?>
					<option value="<?php echo esc_attr( $matiere ); ?>"><?php echo esc_html( $matiere ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p class="atelier-benji-addon-note">
			<?php esc_html_e( 'Les options avec supplément sont ajoutées au prix affiché dans votre panier.', 'atelier-benji' ); ?>
		</p>
	</div>
	<?php
}

/**
 * Couleurs cochées par le client (max 4), filtrées sur la liste autorisée.
 */
function atelier_benji_get_selected_colors() {
	$selected = isset( $_POST['atelier_benji_color'] ) ? (array) wp_unslash( $_POST['atelier_benji_color'] ) : array();
	$selected = array_map( 'sanitize_text_field', $selected );
	$allowed  = atelier_benji_color_options();

	return array_values( array_intersect( $selected, $allowed ) );
}

add_filter( 'woocommerce_add_to_cart_validation', 'atelier_benji_validate_personalization', 10, 3 );
function atelier_benji_validate_personalization( $passed, $product_id, $quantity ) {
	if ( ! in_array( $product_id, atelier_benji_personalizable_product_ids(), true ) ) {
		return $passed;
	}

	$text_required = true;

	if ( in_array( $product_id, atelier_benji_wreath_addon_product_ids(), true ) ) {
		$prenom_taille = isset( $_POST['atelier_benji_prenom_taille'] ) ? sanitize_text_field( wp_unslash( $_POST['atelier_benji_prenom_taille'] ) ) : '';
		$text_required = ( '' !== $prenom_taille );
	}

	if ( $text_required && empty( $_POST['atelier_benji_text'] ) ) {
		wc_add_notice( __( "Merci d'indiquer le texte à personnaliser.", 'atelier-benji' ), 'error' );
		$passed = false;
	}

	$colors = atelier_benji_get_selected_colors();

	if ( empty( $colors ) ) {
		wc_add_notice( __( 'Merci de choisir au moins une couleur.', 'atelier-benji' ), 'error' );
		$passed = false;
	} elseif ( count( $colors ) > 4 ) {
		wc_add_notice( __( 'Merci de choisir au maximum 4 couleurs.', 'atelier-benji' ), 'error' );
		$passed = false;
	}

	return $passed;
}

add_filter( 'woocommerce_add_cart_item_data', 'atelier_benji_add_cart_item_data', 10, 3 );
function atelier_benji_add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
	$is_personalizable = in_array( $product_id, atelier_benji_personalizable_product_ids(), true );
	$is_wreath_addon    = in_array( $product_id, atelier_benji_wreath_addon_product_ids(), true );

	if ( ! $is_personalizable && ! $is_wreath_addon ) {
		return $cart_item_data;
	}

	if ( $is_personalizable ) {
		if ( ! empty( $_POST['atelier_benji_text'] ) ) {
			$cart_item_data['atelier_benji_text'] = sanitize_text_field( wp_unslash( $_POST['atelier_benji_text'] ) );
		}
		$colors = atelier_benji_get_selected_colors();
		if ( ! empty( $colors ) ) {
			$cart_item_data['atelier_benji_color'] = implode( ', ', $colors );
		}
	}

	if ( $is_wreath_addon ) {
		if ( ! empty( $_POST['atelier_benji_prenom_taille'] ) ) {
			$cart_item_data['atelier_benji_prenom_taille'] = sanitize_text_field( wp_unslash( $_POST['atelier_benji_prenom_taille'] ) );
		}
		if ( ! empty( $_POST['atelier_benji_peluche'] ) ) {
			$cart_item_data['atelier_benji_peluche'] = sanitize_text_field( wp_unslash( $_POST['atelier_benji_peluche'] ) );
		}
		if ( ! empty( $_POST['atelier_benji_noeud_couleur'] ) ) {
			$cart_item_data['atelier_benji_noeud_couleur'] = sanitize_text_field( wp_unslash( $_POST['atelier_benji_noeud_couleur'] ) );
		}
		if ( ! empty( $_POST['atelier_benji_noeud_matiere'] ) ) {
			$cart_item_data['atelier_benji_noeud_matiere'] = sanitize_text_field( wp_unslash( $_POST['atelier_benji_noeud_matiere'] ) );
		}

		$price_product = $variation_id ? wc_get_product( $variation_id ) : wc_get_product( $product_id );
		if ( $price_product ) {
			$cart_item_data['atelier_benji_base_price'] = (float) $price_product->get_price();
		}
	}

	// Chaque personnalisation est unique : évite la fusion de lignes différentes dans le panier.
	$cart_item_data['unique_key'] = md5( microtime() . wp_rand() );

	return $cart_item_data;
}

add_action( 'woocommerce_before_calculate_totals', 'atelier_benji_apply_wreath_addon_prices' );
function atelier_benji_apply_wreath_addon_prices( $cart ) {
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
		return;
	}

	foreach ( $cart->get_cart() as $cart_item ) {
		if ( ! isset( $cart_item['atelier_benji_base_price'] ) ) {
			continue;
		}

		$surcharge  = atelier_benji_peluche_price( $cart_item['atelier_benji_peluche'] ?? '' );
		$surcharge += atelier_benji_prenom_taille_price( $cart_item['atelier_benji_prenom_taille'] ?? '' );

		$cart_item['data']->set_price( $cart_item['atelier_benji_base_price'] + $surcharge );
	}
}

add_filter( 'woocommerce_get_item_data', 'atelier_benji_display_cart_item_data', 10, 2 );
function atelier_benji_display_cart_item_data( $item_data, $cart_item ) {
	if ( ! empty( $cart_item['atelier_benji_text'] ) ) {
		$item_data[] = array(
			'key'   => __( 'Personnalisation', 'atelier-benji' ),
			'value' => wc_clean( $cart_item['atelier_benji_text'] ),
		);
	}

	if ( ! empty( $cart_item['atelier_benji_color'] ) ) {
		$item_data[] = array(
			'key'   => __( 'Couleur', 'atelier-benji' ),
			'value' => wc_clean( $cart_item['atelier_benji_color'] ),
		);
	}

	if ( ! empty( $cart_item['atelier_benji_prenom_taille'] ) ) {
		$labels      = atelier_benji_prenom_taille_options();
		$item_data[] = array(
			'key'   => __( 'Taille du prénom', 'atelier-benji' ),
			'value' => isset( $labels[ $cart_item['atelier_benji_prenom_taille'] ] ) ? $labels[ $cart_item['atelier_benji_prenom_taille'] ] : wc_clean( $cart_item['atelier_benji_prenom_taille'] ),
		);
	}

	if ( ! empty( $cart_item['atelier_benji_peluche'] ) ) {
		$labels      = atelier_benji_peluche_options();
		$item_data[] = array(
			'key'   => __( 'Peluche', 'atelier-benji' ),
			'value' => isset( $labels[ $cart_item['atelier_benji_peluche'] ] ) ? $labels[ $cart_item['atelier_benji_peluche'] ] : wc_clean( $cart_item['atelier_benji_peluche'] ),
		);
	}

	if ( ! empty( $cart_item['atelier_benji_noeud_couleur'] ) ) {
		$item_data[] = array(
			'key'   => __( 'Couleur du nœud', 'atelier-benji' ),
			'value' => wc_clean( $cart_item['atelier_benji_noeud_couleur'] ),
		);
	}

	if ( ! empty( $cart_item['atelier_benji_noeud_matiere'] ) ) {
		$item_data[] = array(
			'key'   => __( 'Matière du nœud', 'atelier-benji' ),
			'value' => wc_clean( $cart_item['atelier_benji_noeud_matiere'] ),
		);
	}

	return $item_data;
}

add_action( 'woocommerce_checkout_create_order_line_item', 'atelier_benji_add_order_item_meta', 10, 4 );
function atelier_benji_add_order_item_meta( $item, $cart_item_key, $values, $order ) {
	if ( ! empty( $values['atelier_benji_text'] ) ) {
		$item->add_meta_data( __( 'Personnalisation', 'atelier-benji' ), $values['atelier_benji_text'] );
	}

	if ( ! empty( $values['atelier_benji_color'] ) ) {
		$item->add_meta_data( __( 'Couleur', 'atelier-benji' ), $values['atelier_benji_color'] );
	}

	if ( ! empty( $values['atelier_benji_prenom_taille'] ) ) {
		$labels = atelier_benji_prenom_taille_options();
		$item->add_meta_data( __( 'Taille du prénom', 'atelier-benji' ), isset( $labels[ $values['atelier_benji_prenom_taille'] ] ) ? $labels[ $values['atelier_benji_prenom_taille'] ] : $values['atelier_benji_prenom_taille'] );
	}

	if ( ! empty( $values['atelier_benji_peluche'] ) ) {
		$labels = atelier_benji_peluche_options();
		$item->add_meta_data( __( 'Peluche', 'atelier-benji' ), isset( $labels[ $values['atelier_benji_peluche'] ] ) ? $labels[ $values['atelier_benji_peluche'] ] : $values['atelier_benji_peluche'] );
	}

	if ( ! empty( $values['atelier_benji_noeud_couleur'] ) ) {
		$item->add_meta_data( __( 'Couleur du nœud', 'atelier-benji' ), $values['atelier_benji_noeud_couleur'] );
	}

	if ( ! empty( $values['atelier_benji_noeud_matiere'] ) ) {
		$item->add_meta_data( __( 'Matière du nœud', 'atelier-benji' ), $values['atelier_benji_noeud_matiere'] );
	}
}
