<?php
/**
 * Coalition Theme Settings.
 *
 * Adds a top-level "Theme Settings" admin page (no plugin required) that lets
 * the site owner manage the logo, contact details and social links. Values are
 * stored in a single option array `coalition_theme_settings` and read on the
 * front-end via coalition_get_setting().
 *
 * @package Coalition
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'COALITION_SETTINGS_OPTION', 'coalition_theme_settings' );

/**
 * Helper to read a single theme setting.
 *
 * @param string $key     Setting key.
 * @param string $default Fallback value.
 * @return string
 */
function coalition_get_setting( $key, $default = '' ) {
	$settings = get_option( COALITION_SETTINGS_OPTION, array() );
	return isset( $settings[ $key ] ) && '' !== $settings[ $key ] ? $settings[ $key ] : $default;
}

/**
 * Register the admin menu page.
 */
function coalition_settings_menu() {
	add_menu_page(
		__( 'Theme Settings', 'coalition' ),
		__( 'Theme Settings', 'coalition' ),
		'manage_options',
		'coalition-theme-settings',
		'coalition_settings_page_html',
		'dashicons-admin-generic',
		61
	);
}
add_action( 'admin_menu', 'coalition_settings_menu' );

/**
 * Register settings, sections and fields via the Settings API.
 */
function coalition_settings_init() {
	register_setting(
		'coalition_settings_group',
		COALITION_SETTINGS_OPTION,
		array( 'sanitize_callback' => 'coalition_sanitize_settings' )
	);

	add_settings_section(
		'coalition_branding_section',
		__( 'Branding', 'coalition' ),
		'__return_false',
		'coalition-theme-settings'
	);
	add_settings_field( 'logo', __( 'Logo', 'coalition' ), 'coalition_field_logo', 'coalition-theme-settings', 'coalition_branding_section' );

	add_settings_section(
		'coalition_contact_section',
		__( 'Contact Information', 'coalition' ),
		'__return_false',
		'coalition-theme-settings'
	);
	add_settings_field( 'phone', __( 'Phone Number', 'coalition' ), 'coalition_field_text', 'coalition-theme-settings', 'coalition_contact_section', array( 'key' => 'phone' ) );
	add_settings_field( 'fax', __( 'Fax Number', 'coalition' ), 'coalition_field_text', 'coalition-theme-settings', 'coalition_contact_section', array( 'key' => 'fax' ) );
	add_settings_field( 'address', __( 'Address', 'coalition' ), 'coalition_field_textarea', 'coalition-theme-settings', 'coalition_contact_section', array( 'key' => 'address' ) );

	add_settings_section(
		'coalition_social_section',
		__( 'Social Media Links', 'coalition' ),
		'__return_false',
		'coalition-theme-settings'
	);
	foreach ( coalition_social_networks() as $key => $label ) {
		add_settings_field( 'social_' . $key, $label, 'coalition_field_text', 'coalition-theme-settings', 'coalition_social_section', array( 'key' => 'social_' . $key, 'placeholder' => 'https://' ) );
	}
}
add_action( 'admin_init', 'coalition_settings_init' );

/**
 * Supported social networks.
 *
 * @return array
 */
function coalition_social_networks() {
	return array(
		'facebook'  => __( 'Facebook', 'coalition' ),
		'twitter'   => __( 'Twitter / X', 'coalition' ),
		'linkedin'  => __( 'LinkedIn', 'coalition' ),
		'instagram' => __( 'Instagram', 'coalition' ),
		'youtube'   => __( 'YouTube', 'coalition' ),
	);
}

/**
 * Sanitize all settings on save.
 *
 * @param array $input Raw input.
 * @return array
 */
function coalition_sanitize_settings( $input ) {
	$output = array();
	$output['logo']    = isset( $input['logo'] ) ? absint( $input['logo'] ) : 0;
	$output['phone']   = isset( $input['phone'] ) ? sanitize_text_field( $input['phone'] ) : '';
	$output['fax']     = isset( $input['fax'] ) ? sanitize_text_field( $input['fax'] ) : '';
	$output['address'] = isset( $input['address'] ) ? sanitize_textarea_field( $input['address'] ) : '';
	foreach ( array_keys( coalition_social_networks() ) as $key ) {
		$field                     = 'social_' . $key;
		$output[ $field ]          = isset( $input[ $field ] ) ? esc_url_raw( $input[ $field ] ) : '';
	}
	return $output;
}

/**
 * Text field renderer.
 *
 * @param array $args Field args.
 */
function coalition_field_text( $args ) {
	$key         = $args['key'];
	$placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
	$value       = coalition_get_setting( $key );
	printf(
		'<input type="text" name="%1$s[%2$s]" value="%3$s" class="regular-text" placeholder="%4$s" />',
		esc_attr( COALITION_SETTINGS_OPTION ),
		esc_attr( $key ),
		esc_attr( $value ),
		esc_attr( $placeholder )
	);
}

/**
 * Textarea field renderer.
 *
 * @param array $args Field args.
 */
function coalition_field_textarea( $args ) {
	$key   = $args['key'];
	$value = coalition_get_setting( $key );
	printf(
		'<textarea name="%1$s[%2$s]" rows="4" class="large-text">%3$s</textarea>',
		esc_attr( COALITION_SETTINGS_OPTION ),
		esc_attr( $key ),
		esc_textarea( $value )
	);
}

/**
 * Logo media-uploader field renderer.
 */
function coalition_field_logo() {
	$logo_id  = absint( coalition_get_setting( 'logo', 0 ) );
	$logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'medium' ) : '';
	?>
	<div class="coalition-logo-field">
		<img src="<?php echo esc_url( $logo_url ); ?>" class="coalition-logo-preview" style="max-width:200px;height:auto;display:<?php echo $logo_url ? 'block' : 'none'; ?>;margin-bottom:8px;" />
		<input type="hidden" name="<?php echo esc_attr( COALITION_SETTINGS_OPTION ); ?>[logo]" value="<?php echo esc_attr( $logo_id ); ?>" class="coalition-logo-id" />
		<button type="button" class="button coalition-logo-upload"><?php esc_html_e( 'Select Logo', 'coalition' ); ?></button>
		<button type="button" class="button coalition-logo-remove" style="display:<?php echo $logo_url ? 'inline-block' : 'none'; ?>;"><?php esc_html_e( 'Remove', 'coalition' ); ?></button>
	</div>
	<?php
}

/**
 * Enqueue the media uploader + inline JS on the settings screen.
 *
 * @param string $hook Current admin page.
 */
function coalition_settings_admin_assets( $hook ) {
	if ( 'toplevel_page_coalition-theme-settings' !== $hook ) {
		return;
	}
	wp_enqueue_media();
	$js = <<<'JS'
jQuery(function($){
	var frame;
	$('.coalition-logo-upload').on('click', function(e){
		e.preventDefault();
		if (frame) { frame.open(); return; }
		frame = wp.media({ title: 'Select Logo', button: { text: 'Use this logo' }, multiple: false });
		frame.on('select', function(){
			var att = frame.state().get('selection').first().toJSON();
			$('.coalition-logo-id').val(att.id);
			$('.coalition-logo-preview').attr('src', att.url).show();
			$('.coalition-logo-remove').show();
		});
		frame.open();
	});
	$('.coalition-logo-remove').on('click', function(e){
		e.preventDefault();
		$('.coalition-logo-id').val('');
		$('.coalition-logo-preview').attr('src', '').hide();
		$(this).hide();
	});
});
JS;
	wp_add_inline_script( 'jquery-core', $js );
}
add_action( 'admin_enqueue_scripts', 'coalition_settings_admin_assets' );

/**
 * Render the settings page.
 */
function coalition_settings_page_html() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'coalition_settings_group' );
			do_settings_sections( 'coalition-theme-settings' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}
