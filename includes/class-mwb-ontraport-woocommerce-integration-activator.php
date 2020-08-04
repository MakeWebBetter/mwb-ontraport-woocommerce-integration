<?php
/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    mwb-ontraport-woocommerce-integration
 * @subpackage mwb-ontraport-woocommerce-integration/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    mwb-ontraport-woocommerce-integration
 * @subpackage mwb-ontraport-woocommerce-integration/includes
 * @author     MakeWebBetter <webmaster@makewebbetter.com>
 */
class Mwb_Ontraport_Woocommerce_Integration_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		@fopen( WC_LOG_DIR . 'ontrawoo-logs.log', 'a' );
	}

}
