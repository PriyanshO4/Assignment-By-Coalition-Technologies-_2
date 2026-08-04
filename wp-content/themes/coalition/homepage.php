<?php
/**
 * Template Name: Homepage
 *
 * Custom front-page template for the Coalition theme. Branding and contact
 * details come from Theme Settings; the body content is managed from the
 * page editor in WordPress; the contact form uses a Contact Form 7 shortcode
 * stored in the "Contact Form" page-content or hard-wired below.
 *
 * @package Coalition
 */

get_header();

$logo_id  = absint( coalition_get_setting( 'logo', 0 ) );
$phone    = coalition_get_setting( 'phone' );
$fax      = coalition_get_setting( 'fax' );
$address  = coalition_get_setting( 'address' );
?>

<main id="primary" class="site-main homepage">

	<section class="homepage-hero">
		<div class="homepage-inner">
			<?php if ( $logo_id ) : ?>
				<div class="homepage-logo">
					<?php echo wp_get_attachment_image( $logo_id, 'medium', false, array( 'alt' => get_bloginfo( 'name' ) ) ); ?>
				</div>
			<?php endif; ?>

			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class( 'homepage-content' ); ?>>
					<?php the_content(); ?>
				</article>
				<?php
			endwhile;
			?>
		</div>
	</section>

	<section class="homepage-contact">
		<div class="homepage-inner">
			<div class="contact-details">
				<h2><?php esc_html_e( 'Get in touch', 'coalition' ); ?></h2>
				<?php if ( $address ) : ?>
					<p class="contact-address"><strong><?php esc_html_e( 'Address:', 'coalition' ); ?></strong><br /><?php echo nl2br( esc_html( $address ) ); ?></p>
				<?php endif; ?>
				<?php if ( $phone ) : ?>
					<p class="contact-phone"><strong><?php esc_html_e( 'Phone:', 'coalition' ); ?></strong> <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p>
				<?php endif; ?>
				<?php if ( $fax ) : ?>
					<p class="contact-fax"><strong><?php esc_html_e( 'Fax:', 'coalition' ); ?></strong> <?php echo esc_html( $fax ); ?></p>
				<?php endif; ?>
				<?php coalition_social_links(); ?>
			</div>

			<div class="contact-form">
				<?php
				// Renders the first Contact Form 7 form if the plugin is active.
				if ( shortcode_exists( 'contact-form-7' ) ) {
					$cf7 = get_posts(
						array(
							'post_type'      => 'wpcf7_contact_form',
							'posts_per_page' => 1,
							'fields'         => 'ids',
						)
					);
					if ( ! empty( $cf7 ) ) {
						echo do_shortcode( '[contact-form-7 id="' . absint( $cf7[0] ) . '"]' );
					}
				} else {
					echo '<p>' . esc_html__( 'Activate Contact Form 7 to display the contact form here.', 'coalition' ) . '</p>';
				}
				?>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
