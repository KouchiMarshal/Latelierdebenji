<?php
/**
 * Template Name: Contact
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" class="site-main contact-page">
	<section class="page-hero wrap">
		<h1 class="section-title"><?php the_title(); ?></h1>
		<hr class="divider">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="page-hero-content"><?php the_content(); ?></div>
		<?php endwhile; endif; ?>
	</section>

	<section class="contact-section wrap">
		<?php if ( isset( $_GET['sent'] ) && '1' === $_GET['sent'] ) : ?>
			<p class="form-message form-success">
				<?php esc_html_e( 'Merci, votre message a bien été envoyé ! Nous vous répondrons rapidement.', 'atelier-benji' ); ?>
			</p>
		<?php elseif ( isset( $_GET['sent'] ) && 'error' === $_GET['sent'] ) : ?>
			<p class="form-message form-error">
				<?php esc_html_e( "Une erreur est survenue, merci de réessayer ou de nous écrire directement par email.", 'atelier-benji' ); ?>
			</p>
		<?php endif; ?>

		<form class="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="atelier_benji_contact">
			<?php wp_nonce_field( 'atelier_benji_contact', 'atelier_benji_contact_nonce' ); ?>

			<p class="form-field form-field-hidden" aria-hidden="true">
				<label for="contact-website"><?php esc_html_e( 'Laissez ce champ vide', 'atelier-benji' ); ?></label>
				<input type="text" id="contact-website" name="website" tabindex="-1" autocomplete="off">
			</p>

			<p class="form-field">
				<label for="contact-name"><?php esc_html_e( 'Nom', 'atelier-benji' ); ?></label>
				<input type="text" id="contact-name" name="contact_name" required>
			</p>

			<p class="form-field">
				<label for="contact-email"><?php esc_html_e( 'Email', 'atelier-benji' ); ?></label>
				<input type="email" id="contact-email" name="contact_email" required>
			</p>

			<p class="form-field">
				<label for="contact-subject"><?php esc_html_e( 'Sujet', 'atelier-benji' ); ?></label>
				<input type="text" id="contact-subject" name="contact_subject">
			</p>

			<p class="form-field">
				<label for="contact-message"><?php esc_html_e( 'Message', 'atelier-benji' ); ?></label>
				<textarea id="contact-message" name="contact_message" rows="6" required></textarea>
			</p>

			<p>
				<button type="submit" class="button button-primary"><?php esc_html_e( 'Envoyer', 'atelier-benji' ); ?></button>
			</p>
		</form>
	</section>
</main>

<?php
get_footer();
