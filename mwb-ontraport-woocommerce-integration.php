<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewebbetter.com
 * @since             1.0.0
 * @package           mwb-ontraport-woocommerce-integration
 *
 * @wordpress-plugin
 * Plugin Name:       Integration with Ontraport for WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/mwb-ontraport-woocommerce-integration/
 * Description:       A very powerful plugin to integrate your WooCommerce store with Ontraport seamlessly.
 * Tested up to:        5.4
 * Version:           2.0.2
 * Requires at least:       4.4
 * WC requires at least:    3.0.0
 * WC tested up to:         4.0.1
 * Author:            MakeWebBetter
 * Author URI:        https://makewebbetter.com
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       mwb-ontraport-woocommerce-integration
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


$ontrawoo_activated = true;
$ontrawoo_flag = 1;

/**
 * Checking if WooCommerce is active
 */

if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	$ontrawoo_activated = false;
	$ontrawoo_flag = 0;
} elseif ( in_array( 'ontraport-woocommerce-integration-pro/ontraport-woocommerce-integration-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	$ontrawoo_activated = false;
	$ontrawoo_flag = -1;
}


if ( $ontrawoo_activated && $ontrawoo_flag ) {

	/**
	 * The code that runs during plugin activation.
	 */
	if ( ! function_exists( 'activate_mwb_ontraport_woocommerce_integration' ) ) {
		/**
		 * The code that runs during plugin activation.
		 */
		function activate_mwb_ontraport_woocommerce_integration() {
			require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwb-ontraport-woocommerce-integration-activator.php';
			Mwb_Ontraport_Woocommerce_Integration_Activator::activate();
		}
	}

	/**
	 * The code that runs during plugin deactivation.
	 */
	if ( ! function_exists( 'deactivate_mwb_ontraport_woocommerce_integration' ) ) {
		/**
		 * The code that runs during plugin activation.
		 */
		function deactivate_mwb_ontraport_woocommerce_integration() {
			require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwb-ontraport-woocommerce-integration-deactivator.php';
			Mwb_Ontraport_Woocommerce_Integration_Deactivator::deactivate();
		}
	}

	register_activation_hook( __FILE__, 'activate_mwb_ontraport_woocommerce_integration' );
	register_deactivation_hook( __FILE__, 'deactivate_mwb_ontraport_woocommerce_integration' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * Admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-mwb-ontraport-woocommerce-integration.php';

	/**
	 * Define ontraWoo constants.
	 *
	 * @since 1.0.0
	 */
	function ontrawoo_define_constants() {

		ontrawoo_define( 'ONTRAWOO_ABSPATH', dirname( __FILE__ ) . '/' );
		ontrawoo_define( 'ONTRAWOO_URL', plugin_dir_url( __FILE__ ) . '/' );
		ontrawoo_define( 'ONTRAWOO_VERSION', '2.0.2' );
		ontrawoo_define( 'ONTRAWOO_CONTACT_ITEMID', '0' );
		ontrawoo_define( 'ONTRAWOO_PRODUCT_ITEMID', '16' );
		ontrawoo_define( 'ONTRAWOO_TAG_ITEMID', '14' );
		ontrawoo_define( 'ONTRAWOO_INTEGRATION' , 'mwb-ontraport-woocommerce-integration' );

	}

	/**
	 * Define constant if not already set.
	 *
	 * @param  string      $name name.
	 * @param  string|bool $value value.
	 * @since 1.0.0
	 */
	function ontrawoo_define( $name, $value ) {

		if ( ! defined( $name ) ) {

			define( $name, $value );
		}
	}

	/**
	 * Setting Page Link
	 *
	 * @since    1.0.0
	 * @author  MakeWebBetter
	 * @link  https://makewebbetter.com/
	 * @param string $actions Action perform on admin setting action.
	 * @param string $plugin_file plugin_file.
	 */
	function ontrawoo_admin_settings( $actions, $plugin_file ) {

		static $plugin;

		if ( ! isset( $plugin ) ) {

			$plugin = plugin_basename( __FILE__ );
		}

		if ( $plugin == $plugin_file ) {

			$settings = array(
				'settings' => '<a href="' . admin_url( 'admin.php?page=ontrawoo' ) . '">' . __( 'Settings', ONTRAWOO_INTEGRATION ) . '</a>',
			);

			$actions = array_merge( $settings, $actions );
		}

		return $actions;
	}

	// add link for settings.
	add_filter( 'plugin_action_links', 'ontrawoo_admin_settings', 10, 5 );

	/**
	 * Auto Redirection to settings page after plugin activation
	 *
	 * @since    1.0.0
	 * @author  MakeWebBetter
	 * @link  https://makewebbetter.com/
	 * @param string $plugin   plugin.
	 */
	function ontrawoo_activation_redirect( $plugin ) {

		if ( plugin_basename( __FILE__ ) == $plugin ) {

			wp_safe_redirect( admin_url( 'admin.php?page=ontrawoo' ) );
			exit();
		}
	}
	// redirect to settings page as soon as plugin is activated.
	add_action( 'activated_plugin', 'ontrawoo_activation_redirect' );

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does.
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function run_mwb_ontraport_woocommerce_integration() {

		// define contants if not defined..
		ontrawoo_define_constants();

		$ontrawoo = new Mwb_Ontraport_Woocommerce_Integration();
		$ontrawoo->run();

		$GLOBALS['ontrawoo'] = $ontrawoo;

	}
	run_mwb_ontraport_woocommerce_integration();

} elseif ( ! $ontrawoo_activated && 0 === $ontrawoo_flag ) {

	add_action( 'admin_init', 'ontrawoo_plugin_deactivate' );

	/**
	 * Call Admin notices
	 *
	 * @name ontrawoo_plugin_deactivate()
	 * @author MakeWebBetter<webmaster@makewebbetter.com>
	 * @link https://www.makewebbetter.com/
	 */
	function ontrawoo_plugin_deactivate() {

		deactivate_plugins( plugin_basename( __FILE__ ) );
		add_action( 'admin_notices', 'ontrawoo_plugin_error_notice' );
	}

	/**
	 * Show warning message if woocommerce is not install
	 *
	 * @since 1.0.0
	 * @author MakeWebBetter<webmaster@makewebbetter.com>
	 * @link https://www.makewebbetter.com/
	 */
	function ontrawoo_plugin_error_notice() {

		?>
		  <div class="error notice is-dismissible">
			 <p><?php esc_html_e( 'WooCommerce is not activated, Please activate WooCommerce first to install Ontraport WooCommerce Integration .', ONTRAWOO_INTEGRATION ); ?></p>
		   </div>
		   <style>
		   #message{display:none;}
		   </style>
		<?php
	}
} elseif ( ! $ontrawoo_activated && -1 === $ontrawoo_flag ) {

	/**
	 * Show warning message if any other Ontraport WooCommerce Integration version is activated
	 *
	 * @since 1.0.0
	 * @author MakeWebBetter<webmaster@makewebbetter.com>
	 * @link https://www.makewebbetter.com/
	 */
	function ontrawoo_plugin_basic_error_notice() {

		?>
		 <div class="error notice is-dismissible">
			<p><?php esc_html_e( 'Oops! You tried activating the Ontraport WooCommerce Integration without deactivating the another version of the integration. Kindly deactivate the other version of Ontraport WooCommerce Integration Pro and then try again.', ONTRAWOO_INTEGRATION ); ?></p>
		  </div>
		  <style>
		  #message{display:none;}
		  </style>
		  <?php
	}

	add_action( 'admin_init', 'ontrawoo_plugin_deactivate_dueto_basicversion' );


	/**
	 * Call Admin notices
	 *
	 * @author MakeWebBetter<webmaster@makewebbetter.com>
	 * @link https://www.makewebbetter.com/
	 */
	function ontrawoo_plugin_deactivate_dueto_basicversion() {

		deactivate_plugins( plugin_basename( __FILE__ ) );
		add_action( 'admin_notices', 'ontrawoo_plugin_basic_error_notice' );
	}
}
