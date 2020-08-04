<?php
/**
 * Ontraport Sales Manager woocommerce integration.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    mwb-ontraport-woocommerce-integration
 * @subpackage mwb-ontraport-woocommerce-integration/includes
 */
class Ontrawoo_Integration_Sales_Manager {
	/**
	 * The single instance of the class.
	 *
	 * @since   1.0.0
	 * @access  protected
	 * @var $_instance
	 */
	protected static $_instance = null;

	/**
	 * Main Ontrawoo_Integration_Sales_Manager Instance.
	 *
	 * Ensures only one instance of Ontrawoo_Integration_Sales_Manager is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 */
	public static function get_instance() {

		if ( is_null( self::$_instance ) ) {

			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Process store order to update details on Ontraport
	 *
	 * @param string $order_id Order Id.
	 * @since 1.0.0
	 */
	public function ontrawoo_process_order_as_sales( $order_id = '' ) {

		global $ontrawoo;

		$product_id = '';

		if ( ! empty( $order_id ) ) {

			$order = new WC_Order( $order_id );

			$i_d = $order->get_customer_id();

			$customer_data = get_userdata( $i_d );

			if ( ! empty( $customer_data ) ) {
				$email = $customer_data->user_email;
			}

			if ( ! empty( $order ) && ! is_wp_error( $order_id ) ) {

				$order_items    = $order->get_items();

				if ( is_array( $order_items ) && count( $order_items ) ) {

					foreach ( $order_items as $item_id_1 => $w_c_order_item_product ) {

						if ( ! empty( $w_c_order_item_product ) && is_object( $w_c_order_item_product ) ) {

							$products_count = $w_c_order_item_product->get_quantity();
							$product = $w_c_order_item_product->get_product();
							$product_name = $product->get_title();
							$product_price = $product->get_price();
							$product_total = $w_c_order_item_product->get_total();
						}

						$purchase_data = array(
							'quantity'  => $products_count,
							'product'   => $product_name,
							'price'     => $product_price,
							'total'     => $product_total,
						);

						$product_data = array(
							'name' => $product_name,
							'price' => $product_price,
						);

						$keys = $ontrawoo->get_ontraport_keys();
						$app_id = ! empty( $keys['appID'] ) ? $keys['appID'] : '';
						$api_key = ! empty( $keys['apiKey'] ) ? $keys['apiKey'] : '';

						$ontrawoo_connection_mananager = new Ontrawoo_Integration_Connection_Manager( $app_id, $api_key );

						if ( ! empty( $order_id ) ) {
							$customer_data = $this->ontrawoo_get_customer_details( $order_id );
						}
						if ( ! empty( $customer_data ) ) {
							$contact_id = $ontrawoo_connection_mananager->start_processing_contact( $customer_data );
						}

						if ( ! empty( $contact_id ) ) {

							if ( $ontrawoo->is_tag_record_enable() ) {

								$selected_product_id = get_option( 'ontrawoo-free-select-product', array() );

								if ( ! empty( $selected_product_id ) ) {
									foreach ( $selected_product_id as $key => $id ) {
										$selected_product_name[] = wc_get_product( $id )->get_name();
									}

									foreach ( $selected_product_name as $key => $name ) {

										if ( $name == $purchase_data['product'] ) {

											$tag_id = $ontrawoo_connection_mananager->start_processing_tags( $purchase_data['product'] );

											if ( ! empty( $tag_id ) ) {

												$ontrawoo_connection_mananager->assign_tag_to_contact( $tag_id, $contact_id );
											}
										}
									}
								} else {
									$tag_id = $ontrawoo_connection_mananager->start_processing_tags( $purchase_data['product'] );

									if ( ! empty( $tag_id ) ) {

										$ontrawoo_connection_mananager->assign_tag_to_contact( $tag_id, $contact_id );
									}
								}
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Get cutomer personal details
	 *
	 * @param string $order_id order_id.
	 * @since 1.0.0
	 */
	public function ontrawoo_get_customer_details( $order_id ) {

		$customer = array(

			'firstname'     => get_post_meta( $order_id, '_billing_first_name', true ),
			'lastname'      => get_post_meta( $order_id, '_billing_last_name', true ),
			'email'         => get_post_meta( $order_id, '_billing_email', true ),
			'office_phone'  => get_post_meta( $order_id, '_billing_phone', true ),
			'address'       => get_post_meta( $order_id, '_billing_address_1', true ),
			'address2'      => get_post_meta( $order_id, '_billing_address_2', true ),
			'city'          => get_post_meta( $order_id, '_billing_city', true ),
			'state'         => get_post_meta( $order_id, '_billing_state', true ),
			'zip'           => get_post_meta( $order_id, '_billing_postcode', true ),
			'country'       => get_post_meta( $order_id, '_billing_country', true ),
			'company'       => get_post_meta( $order_id, '_billing_company', true ),
		);

		return $customer;
	}
}
