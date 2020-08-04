<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    mwb-ontraport-woocommerce-integration
 * @subpackage mwb-ontraport-woocommerce-integration/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    mwb-ontraport-woocommerce-integration
 * @subpackage mwb-ontraport-woocommerce-integration/includes
 * @author     MakeWebBetter <webmaster@makewebbetter.com>
 */
class Mwb_Ontraport_Woocommerce_Integration_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		unlink( WC_LOG_DIR . 'ontrawoo-logs.log' );
	}

}
