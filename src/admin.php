<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function yogo_settings_init() {

	register_setting(
		'yogo',
		'yogo_client_domain',
		'yogo_sanitize_domain'
	);

	add_settings_section(
		'yogo_section',
		__('YOGO settings', 'yogo-booking'),
		'yogo_section_cb',
		'yogo_options'
	);

	add_settings_field(
		'yogo_client_domain', // as of WP 4.6 this value is used only internally
		// use $args' label_for to populate the id inside the callback
		__( 'YOGO Client Domain', 'yogo-booking' ),
		'yogo_field_client_domain_cb',
		'yogo_options',
		'yogo_section'
	);
}

add_action( 'admin_init', 'yogo_settings_init' );

function yogo_sanitize_domain( $domain ) {
	return preg_replace( '/[^.a-z0-9æøå-]+/', '', $domain );
}

function yogo_section_cb( $args ) {
	?>
  <p><?php esc_html_e( 'Please fill out the fields below.', 'yogo-booking' ); ?></p>
	<?php
}

function yogo_field_client_domain_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
	$client_domain = get_option( 'yogo_client_domain' );

	// output the field
	?>
    <label>
      <input type="text"
             size="40"
             id="yogo_client_domain"
             name="yogo_client_domain"
             value="<?php echo $client_domain ?  esc_attr( $client_domain ) : '' ?>"
      />
    </label>
  <p class="description">
	  <?php esc_html_e( 'You get this from YOGO when you sign up.', 'yogo-booking' ); ?>
  </p>
	<?php
}




function yogo_options_page() {
	add_menu_page(
		'YOGO',
		'YOGO',
		'manage_options',
		'yogo_options',
		'yogo_options_page_html',
		plugin_dir_url( __FILE__ ) . 'images/logo.png',
		20
	);
}

add_action( 'admin_menu', 'yogo_options_page' );


function yogo_options_page_html() {
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// add error/update messages

	// check if the user have submitted the settings
	// wordpress will add the "settings-updated" $_GET parameter to the url
	if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		add_settings_error( 'yogo_messages', 'yogo_message', __( 'YOGO settings has been saved', 'yogo-booking' ), 'updated' );
	}

	// show error/update messages
	settings_errors( 'yogo_messages' );
	?>
  <div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form action="options.php" method="post">
		<?php
		// output security fields for the registered setting "wporg"
		settings_fields( 'yogo' );
		// output setting sections and their fields
		// (sections are registered for "wporg", each field is registered to a specific section)
		do_settings_sections( 'yogo_options' );
    ?>
    <p><b><?php echo esc_html(__('Valid shortcodes', 'yogo-booking')) ?>:</b> [yogo-prices], [yogo-events], [yogo-calendar], [yogo-products], [yogo-appointment-button] </p>
    <?php
		// output save settings button
		submit_button( __('Save Settings', 'yogo-booking') );
		?>
    </form>
  </div>
	<?php
}
