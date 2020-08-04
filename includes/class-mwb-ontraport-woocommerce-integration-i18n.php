<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    mwb-ontraport-woocommerce-integration
 * @subpackage mwb-ontraport-woocommerce-integration/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    mwb-ontraport-woocommerce-integration
 * @subpackage mwb-ontraport-woocommerce-integration/includes
 * @author     MakeWebBetter <webmaster@makewebbetter.com>
 */
class Mwb_Ontraport_Woocommerce_Integration_I18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			ONTRAWOO_INTEGRATION,
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
