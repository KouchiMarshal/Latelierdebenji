<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" class="site-main">
	<div class="wrap">
		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class( 'content-block' ); ?>>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</article>
				<?php
			endwhile;
			the_posts_navigation();
			?>
		<?php else : ?>
			<p><?php esc_html_e( 'Aucun contenu trouvé.', 'atelier-benji' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
