<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    mwb-ontraport-woocommerce-integration
 * @subpackage mwb-ontraport-woocommerce-integration/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    mwb-ontraport-woocommerce-integration
 * @subpackage mwb-ontraport-woocommerce-integration/public
 * @author     MakeWebBetter <webmaster@makewebbetter.com>
 */
class Mwb_Ontraport_Woocommerce_Integration_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Update key as soon as guest order is done
	 *
	 * @since    1.0.0
	 * @param    string $order_id       Order Id.
	 */
	public function ontrawoo_woocommerce_new_orders( $order_id ) {

		if ( ! empty( $order_id ) ) {

			Ontrawoo_Integration_Sales_Manager::get_instance()->ontrawoo_process_order_as_sales( $order_id );
		}
	}

}
