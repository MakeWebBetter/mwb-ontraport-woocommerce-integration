<?php
/**
 * Ontraport Sales Manager woocommerce integration.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package   mwb-ontraport-woocommerce-integration
 * @subpackage mwb-ontraport-woocommerce-integration/includes
 */
class Ontrawoo_Integration_Connection_Manager {
	/**
	 * The single instance of the class.
	 *
	 * @since   1.0.0
	 * @access  protected
	 * @var string $instance.
	 */
	protected static $_instance = null;

	/**
	 * Base url of ontraport api.
	 *
	 * @since 1.0.0.
	 * @var int $base_url
	 */
	private $base_url  = 'https://api.ontraport.com/';

	/**
	 * Api Id of ontraport api.
	 *
	 * @since 1.0.0.
	 * @var string $_api_id .
	 */
	private $_api_id = '';

	/**
	 * Api key of ontraport api.
	 *
	 * @since 1.0.0.
	 * @var string $_api_id .
	 */
	private $_api_key = '';

	/**
	 * API version of ontaport api.
	 *
	 * @since 1.0.0.
	 * @var string $_api_id .
	 */
	private $_api_version = '1';


	/**
	 * Main Ontrawoo_Integration_Connection_Manager Instance.
	 *
	 * Ensures only one instance of Ontrawoo_Integration_Connection_Manager is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @return Ontrawoo_Integration_Connection_Manager - Main instance.
	 */
	public static function get_instance() {

		if ( is_null( self::$_instance ) ) {

			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor ...................
	 *
	 * @param int $app_id    App Id For Ontraport.
	 * @param int $app_key   App Key For Ontraport.
	 */
	public function __construct( $app_id, $app_key ) {

		$this->_api_id = $app_id;
		$this->_api_key = $app_key;
	}

	/**
	 * Keys validation by making get call first time
	 *
	 * @since 1.0.0
	 */
	public function ontrawoo_validate_keys() {

		$headers  = array(
			'Api-Appid' => $this->_api_id,
			'Api-Key' => $this->_api_key,
		);
		$endpoint = '/objects';
		$resource_params = array(
			'objectID' => ONTRAWOO_CONTACT_ITEMID,
			'range' => 1,
		);
		$url = $this->base_url . $this->_api_version . $endpoint . '?' . http_build_query( $resource_params );
		$response  = wp_remote_request(
			$url,
			array(
				'headers'     => $headers,
				'method'      => 'GET',

			)
		);

		$body_response = array(
			'status_code' => 400,
			'res_message' => "__('Failed in validating' , 'ONTRAWOO_INTEGRATION')",
		);

		if ( ! is_wp_error( $response ) ) {

			$status_code = wp_remote_retrieve_response_code( $response );
			$res_message = wp_remote_retrieve_response_message( $response );
			$body_response['status_code'] = $status_code;
			$body_response['res_message'] = $res_message;

		}
		$message = __( 'Validating API Keys', 'ONTRAWOO_INTEGRATION' );
		$this->create_log( $message, $endpoint, $body_response );
		return $body_response;
	}

	/**
	 * Get ontraport object according to condition
	 *
	 * @param string $condition condition.
	 * @param string $item_id item_id.
	 * @since 1.0.0
	 */
	public function ontrawoo_get_object_by_condition( $condition = '', $item_id ) {

		$headers  = array(
			'Api-Appid' => $this->_api_id,
			'Api-Key' => $this->_api_key,
		);

		$condition          = json_encode( $condition );
		$endpoint           = '/objects';
		$resource_params    = array(
			'objectID' => $item_id,
			'condition' => $condition,
		);

		$url = $this->base_url . $this->_api_version . $endpoint . '?' . http_build_query( $resource_params );
		$response  = wp_remote_request(
			$url,
			array(
				'headers'     => $headers,
				'method'      => 'GET',

			)
		);

		$body_response = array(
			'status_code' => 400,
			'res_message' => "__('Failed in getting object' , 'ONTRAWOO_INTEGRATION')",
			'response' => '',
		);

		if ( ! is_wp_error( $response ) ) {

			$status_code = wp_remote_retrieve_response_code( $response );
			$res_message = wp_remote_retrieve_response_message( $response );
			$body_response['status_code'] = $status_code;
			$body_response['res_message'] = $res_message;
			$body_response['response'] = wp_remote_retrieve_body( $response );

		}

		$message            = __( "Getting Object ID $item_id by Condition", 'ONTRAWOO_INTEGRATION' );
		$this->create_log( $message, $endpoint, $body_response );
		return $body_response;
	}

	   /**
		* Update contact on Ontraport
		*
		* @param string $contact contact.
		* @param string $contact_id contact_id.
		* @since 1.0.0
		*/
	public function ontrawoo_update_contact( $contact, $contact_id ) {

		if ( ! empty( $contact ) ) {

			$contact_data = array();
			$contact_details['objectID'] = ONTRAWOO_CONTACT_ITEMID;
			$contact_details['id'] = $contact_id;
			$contact_details = json_encode( $contact_details );
			$endpoint = '/objects';
			$url = $this->base_url . $this->_api_version . $endpoint;

			$headers  = array(
				'Api-Appid' => $this->_api_id,
				'Api-Key' => $this->_api_key,
			);

			$response  = wp_remote_request(
				$url,
				array(
					'headers'     => $headers,
					'method'      => 'PUT',
					'body'       => $contact_details,

				)
			);

			$body_response = array(
				'status_code' => 400,
				'res_message' => "__('Failed in creating or updating' , 'ONTRAWOO_INTEGRATION')",
				'response' => '',
			);

			if ( ! is_wp_error( $response ) ) {

				$status_code = wp_remote_retrieve_response_code( $response );
				$res_message = wp_remote_retrieve_response_message( $response );
				$body_response['status_code'] = $status_code;
				$body_response['res_message'] = $res_message;
				$body_response['response'] = wp_remote_retrieve_body( $response );

			}
			$message = __( 'Updating Contact', 'ONTRAWOO_INTEGRATION' );
			$this->create_log( $message, $endpoint, $body_response );
			return $body_response;
		}
	}


	/**
	 * Create contact on Ontraport.
	 *
	 * @param string $contact contact.
	 * @param string $email email.
	 * @since 1.0.0
	 */
	public function ontrawoo_create_contact( $contact, $email ) {

		if ( ! empty( $contact ) ) {

			$contact['objectID'] = ONTRAWOO_CONTACT_ITEMID;
			$contact['email'] = $email;

			if ( ! empty( $contact['fields'] ) ) {

				$contact['fields'] = $contact['fields'];
			}

			$contact_details = json_encode( $contact );
			$endpoint = '/objects';

			$url = $this->base_url . $this->_api_version . $endpoint;

			$headers  = array(
				'Api-Appid' => $this->_api_id,
				'Api-Key' => $this->_api_key,
			);

			$response  = wp_remote_request(
				$url,
				array(
					'headers'     => $headers,
					'method'      => 'POST',
					'body'       => $contact_details,

				)
			);

			$body_response = array(
				'status_code' => 400,
				'res_message' => "__('Failed in creating or updating' , 'ONTRAWOO_INTEGRATION')",
				'response' => '',
			);

			if ( ! is_wp_error( $response ) ) {

				$status_code = wp_remote_retrieve_response_code( $response );
				$res_message = wp_remote_retrieve_response_message( $response );
				$body_response['status_code'] = $status_code;
				$body_response['res_message'] = $res_message;
				$body_response['response'] = wp_remote_retrieve_body( $response );

			}
			$message = __( 'Creating New Contact', 'ONTRAWOO_INTEGRATION' );
			$this->create_log( $message, $endpoint, $body_response );
			return $body_response;
		}
	}


	 /**
	  * Create Tag on Ontraport
	  *
	  * @param string $tagname tagname.
	  * @since 1.0.0
	  */
	public function ontrawoo_create_tag( $tagname ) {

		if ( ! empty( $tagname ) ) {

			$tag_params = array(
				'object_type_id'    => ONTRAWOO_CONTACT_ITEMID,
				'tag_name'          => $tagname,
			);

			$tag_params['objectID'] = ONTRAWOO_TAG_ITEMID;
			$tag_details = json_encode( $tag_params );
			$endpoint = '/objects';

			$url = $this->base_url . $this->_api_version . $endpoint;

			$headers  = array(
				'Api-Appid' => $this->_api_id,
				'Api-Key' => $this->_api_key,
			);

			$response  = wp_remote_request(
				$url,
				array(
					'headers'     => $headers,
					'method'      => 'POST',
					'body'       => $tag_details,

				)
			);

			$body_response = array(
				'status_code' => 400,
				'res_message' => "__('Failed in creating or updating' , 'ONTRAWOO_INTEGRATION')",
				'response' => '',
			);

			if ( ! is_wp_error( $response ) ) {

				$status_code = wp_remote_retrieve_response_code( $response );
				$res_message = wp_remote_retrieve_response_message( $response );
				$body_response['status_code'] = $status_code;
				$body_response['res_message'] = $res_message;
				$body_response['response'] = wp_remote_retrieve_body( $response );

			}

			$message = __( 'Creating New Tag', 'ONTRAWOO_INTEGRATION' );
			$this->create_log( $message, $endpoint, $body_response );
			return $body_response;
		}
	}

	/**
	 * Process the contacts for Ontraport
	 *
	 * @param array  $contact contact.
	 * @param string $action action.
	 * @param string $email email.
	 * @since 1.0.0
	 */
	public function start_processing_contact( $contact = array(), $action = 'sales', $email = '' ) {

		$contact_id = '';
		$contactid = '';

		if ( ! empty( $contact ) ) {
			$email = $contact['email'];
		}

		if ( ! empty( $email ) ) {

			$condition = array(
				array(
					'field' => array( 'field' => 'email' ),
					'op' => '=',
					'value' => array( 'value' => $email ),
				),
			);

			$return_response = $this->ontrawoo_get_object_by_condition( $condition, ONTRAWOO_CONTACT_ITEMID );

			if ( ! empty( $return_response ) && is_array( $return_response ) ) {

				$contact_id = $this->ontrawoo_parse_object_id( $return_response );
			}

			if ( ! empty( $contact_id ) ) {

				$return_response = $this->ontrawoo_update_contact( $contact, $contact_id );

				if ( ! empty( $return_response ) ) {

					if ( ! empty( $return_response['response'] ) ) {

						$return_response = json_decode( $return_response['response'] );
						$contactid = ! empty( $return_response->data->attrs->id ) ? $return_response->data->attrs->id : '';

					}
				}
			} elseif ( empty( $contact_id ) ) {

				$return_response = $this->ontrawoo_create_contact( $contact, $email );

				if ( ! empty( $return_response ) ) {

					if ( ! empty( $return_response['response'] ) ) {

						$return_response = json_decode( $return_response['response'] );
						$contactid = ! empty( $return_response->data->id ) ? $return_response->data->id : '';
					}
				}
			}
		}

		return $contactid;
	}



	/**
	 * Parse Ontaport object according to ID
	 *
	 * @param string $response response.
	 * @since 1.0.0
	 */
	public function ontrawoo_parse_object_id( $response ) {

		$object_id = '';

		if ( ! empty( $response['response'] ) ) {

			$response = json_decode( $response['response'] );

			if ( isset( $response->data ) ) {

				if ( is_array( $response->data ) && count( $response->data ) ) {

					foreach ( $response->data as $single_data ) {

						if ( ! empty( $single_data->id ) ) {

							$object_id = $single_data->id;
						}
					}
				}
			}
		}

		return $object_id;
	}





	/**
	 * Process tags for Ontraport
	 *
	 * @param string $product_name product name.
	 * @since 1.0.0
	 */
	public function start_processing_tags( $product_name ) {

		$tag_id = '';

		if ( ! empty( $product_name ) ) {

			$condition = array(
				array(
					'field' => array( 'field' => 'tag_name' ),
					'op' => '=',
					'value' => array( 'value' => $product_name ),
				),
			);

			$return_response = $this->ontrawoo_get_object_by_condition( $condition, ONTRAWOO_TAG_ITEMID );

			if ( ! empty( $return_response ) ) {

				$tag_id = $this->ontrawoo_parse_tag_id( $return_response );
			}

			if ( empty( $tag_id ) ) {

				$return_response = $this->ontrawoo_create_tag( $product_name );

				if ( ! empty( $return_response ) ) {

					if ( ! empty( $return_response['response'] ) ) {

						$return_response = json_decode( $return_response['response'] );
						$tag_id = ! empty( $return_response->data->tag_id ) ? $return_response->data->tag_id : '';
					}
				}
			}
		}

		return $tag_id;
	}



	/**
	 * Process tags for Ontraport
	 *
	 * @param string $response response.
	 * @since 1.0.0
	 */
	public function ontrawoo_parse_tag_id( $response ) {

		$object_id = '';

		if ( ! empty( $response['response'] ) ) {

			$response = json_decode( $response['response'] );

			if ( isset( $response->data ) ) {

				if ( is_array( $response->data ) && count( $response->data ) ) {

					foreach ( $response->data as $single_data ) {

						if ( ! empty( $single_data->tag_id ) ) {

							$object_id = $single_data->tag_id;
						}
					}
				}
			}
		}

		return $object_id;
	}

	/**
	 * Assign tags to contacts on Ontraport
	 *
	 * @param string $tag_id tag id.
	 * @param string $contact_id contact id.
	 * @since 1.0.0
	 */
	public function assign_tag_to_contact( $tag_id, $contact_id ) {

		$request_params = array(
			'objectID'  => ONTRAWOO_CONTACT_ITEMID,
			'add_list'  => $tag_id,
			'ids'       => $contact_id,
		);

		$headers  = array(
			'Api-Appid' => $this->_api_id,
			'Api-Key' => $this->_api_key,
		);

		$request_params = json_encode( $request_params );
		$endpoint = '/objects/tag';
		$url = $this->base_url . $this->_api_version . $endpoint;

		$headers  = array(
			'Api-Appid' => $this->_api_id,
			'Api-Key' => $this->_api_key,
		);

		$response  = wp_remote_request(
			$url,
			array(
				'headers'     => $headers,
				'method'      => 'PUT',
				'body'       => $request_params,

			)
		);

		$body_response = array(
			'status_code' => 400,
			'res_message' => "__('Failed in creating or updating' , 'ONTRAWOO_INTEGRATION')",
			'response' => '',
		);

		if ( ! is_wp_error( $response ) ) {

			$status_code = wp_remote_retrieve_response_code( $response );
			$res_message = wp_remote_retrieve_response_message( $response );
			$body_response['status_code'] = $status_code;
			$body_response['res_message'] = $res_message;
			$body_response['response'] = wp_remote_retrieve_body( $response );

		}

		$message = __( 'Tagging contact', 'ONTRAWOO_INTEGRATION' );
		$this->create_log( $message, $endpoint, $body_response );
		return $body_response;
	}

	/**
	 * Create log of requests.
	 *
	 * @param  string $message     ontraport log message.
	 * @param  string $url         ontraport acceptable url.
	 * @param  array  $response    ontraport response array.
	 * @access public
	 * @since 1.0.0
	 */
	public function create_log( $message, $url, $response ) {

		if ( isset( $response['status_code'] ) && ( 400 == $response['status_code'] || 404 == $response['status_code'] || 401 == $response['status_code'] ) ) {

			update_option( 'ontrawoo_alert_param_set', true );
			$error_apis = get_option( 'ontrawoo-error-api-calls', 0 );
			$error_apis ++;
			update_option( 'ontrawoo-error-api-calls', $error_apis );
		} elseif ( isset( $response['status_code'] ) && ( 200 == $response['status_code'] || 202 == $response['status_code'] || 201 == $response['status_code'] || 204 == $response['status_code'] ) ) {

			$success_apis = get_option( 'ontrawoo-success-api-calls', 0 );
			$success_apis ++;
			update_option( 'ontrawoo-success-api-calls', $success_apis );
			update_option( 'ontrawoo_alert_param_set', false );
		} else {

			update_option( 'ontrawoo_alert_param_set', false );
		}

		$final_response = $response;

		$log_enable = get_option( 'ontrawoo_log_enable', 'no' );

		if ( 'yes' == $log_enable ) {

			$log_dir = WC_LOG_DIR . 'ontrawoo-logs.log';

			if ( ! is_dir( $log_dir ) ) {
				// phpcs:disable .
				@fopen( WC_LOG_DIR . 'ontrawoo-logs.log', 'a' );
				//phpcs:enable .
			}

			 $log = 'Time: ' . current_time( 'F j, Y  g:i a' ) . PHP_EOL .
					'Process: ' . $message . PHP_EOL .
					'URL: ' . $url . PHP_EOL .
					'Response: ' . json_encode( $final_response ) . PHP_EOL .
					'-----------------------------------' . PHP_EOL;
			// phpcs:disabl .
			file_put_contents( $log_dir, $log, FILE_APPEND );
			//phpcs:enable .
		}
	}
}
