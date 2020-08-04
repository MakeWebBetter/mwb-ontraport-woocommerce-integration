<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    mwb-ontraport-woocommerce-integration
 * @subpackage mwb-ontraport-woocommerce-integration/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    mwb-ontraport-woocommerce-integration
 * @subpackage mwb-ontraport-woocommerce-integration/includes
 * @author     MakeWebBetter <webmaster@makewebbetter.com>
 */
class Mwb_Ontraport_Woocommerce_Integration {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Mwb_Ontraport_Woocommerce_Integration_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'ONTRAWOO_VERSION' ) ) {
			$this->version = ONTRAWOO_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'mwb-ontraport-woocommerce-integration';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Mwb_Ontraport_Woocommerce_Integration_Loader. Orchestrates the hooks of the plugin.
	 * - Mwb_Ontraport_Woocommerce_Integration_I18n. Defines internationalization functionality.
	 * - Mwb_Ontraport_Woocommerce_Integration_Admin. Defines all hooks for the admin area.
	 * - Mwb_Ontraport_Woocommerce_Integration_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mwb-ontraport-woocommerce-integration-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mwb-ontraport-woocommerce-integration-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-mwb-ontraport-woocommerce-integration-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-mwb-ontraport-woocommerce-integration-public.php';

		$this->loader = new Mwb_Ontraport_Woocommerce_Integration_Loader();

		/**
		 * The class responsible for manging sales related api and task.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mwb-ontraport-woocommerce-integration-sales-manager.php';
		/**
		 * The class responsible for all api actions with ontraport.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mwb-ontraport-woocommerce-integration-connection-manager.php';

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Mwb_Ontraport_Woocommerce_Integration_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Mwb_Ontraport_Woocommerce_Integration_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Mwb_Ontraport_Woocommerce_Integration_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'ontrawoo_add_privacy_message' );

		// AJAX.
		// Get started on admin call.
		$this->loader->add_action( 'wp_ajax_ontrawoo_get_started_call', $plugin_admin, 'ontrawoo_get_started_call' );

		// Save user choice after authorization.
		$this->loader->add_action( 'wp_ajax_ontrawoo_save_user_choice', $plugin_admin, 'ontrawoo_save_user_choice' );

		// Search products in the store.
		$this->loader->add_action( 'wp_ajax_ontrawoo_search_for_order_products', $plugin_admin, 'ontrawoo_search_for_order_products' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality.
	 * Of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Mwb_Ontraport_Woocommerce_Integration_Public( $this->get_plugin_name(), $this->get_version() );

		// checking if contact record sunc is enabled.
		if ( $this->is_contact_record_enable() ) {

			$this->loader->add_action( 'woocommerce_order_status_changed', $plugin_public, 'ontrawoo_woocommerce_new_orders', 10, 3 );

		}

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Mwb_Ontraport_Woocommerce_Integration_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Predefined default ontrawoo tabs.
	 *
	 * @since     1.0.0
	 * @return  Array       An key=>value pair of ontraport tabs.
	 */
	public function ontrawoo_default_tabs() {

		$default_tabs = array();

		$default_tabs['ontrawoo-getstarted'] = array(
			'name' => __( 'Get Started', ONTRAWOO_INTEGRATION ),
			'dependency' => '',
			'icon' => 'fa fa-th-large',
		);

		$default_tabs['ontrawoo_overview'] = array(
			'name' => __( 'Overview', ONTRAWOO_INTEGRATION ),
			'dependency' => '',
			'icon' => 'fa fa-life-ring',
		);

		$default_tabs['ontrawoo_connect'] = array(
			'name' => __( 'Connect', ONTRAWOO_INTEGRATION ),
			'dependency' => 'ontrawoo_get_started',
			'icon' => 'fas fa-plug',
		);

		$default_tabs['ontrawoo_setup'] = array(
			'name' => __( 'Setup', ONTRAWOO_INTEGRATION ),
			'dependency' => 'is_keys_validated',
			'icon' => 'fa fa-cogs',
		);

		$default_tabs['ontrawoo_abandoned_cart'] = array(
			'name' => __( 'Abandoned Carts', ONTRAWOO_INTEGRATION ),
			'dependency' => 'is_keys_validated',
			'icon' => 'fa fa-shopping-cart',
		);

		$default_tabs['ontrawoo_campaign_sequence'] = array(
			'name' => __( 'Campaigns & Sequence', ONTRAWOO_INTEGRATION ),
			'dependency' => 'is_keys_validated',
			'icon' => 'far fa-clock',
		);

		$default_tabs['ontrawoo_activity_rule'] = array(
			'name' => __( 'Activity Rules', ONTRAWOO_INTEGRATION ),
			'dependency' => 'is_keys_validated',
			'icon' => 'fa fa-tasks',
		);

		$default_tabs['ontrawoo_one_click_sync'] = array(
			'name' => __( 'One-Click Sync', ONTRAWOO_INTEGRATION ),
			'dependency' => 'is_keys_validated',
			'icon' => 'fas fa-sync',
		);

		$default_tabs['error_management'] = array(
			'name' => __( 'Error Tracking', ONTRAWOO_INTEGRATION ),
			'dependency' => 'is_keys_validated',
			'icon' => 'fas fas fa-chart-line',
		);

		return $default_tabs;
	}

	/**
	 * Locate and load appropriate tempate.
	 *
	 * @param string $path path.
	 * @param array  $params params.
	 * @since   1.0.0
	 */
	public function load_template_view( $path, $params = array() ) {

		$file_path = ONTRAWOO_ABSPATH . $path;

		if ( file_exists( $file_path ) ) {

			include $file_path;
		} else {
			/* translators: %s: search term */
			$notice = sprintf( __( 'Unable to locate file path at location "%s" some features may not work properly in Ontraport WooCommerce Integration, please contact us!', ONTRAWOO_INTEGRATION ), $file_path );

			$this->ontrawoo_notice( $notice, 'error' );
		}
	}

	/**
	 * Show admin notices.
	 *
	 * @param  string $message    Message to display.
	 * @param  string $type       notice type, accepted values - error/update/update-nag.
	 * @since  1.0.0.
	 */
	public static function ontrawoo_notice( $message, $type = 'error' ) {

		$classes = 'notice ';

		switch ( $type ) {

			case 'update':
				$classes .= 'updated';
				break;

			case 'update-nag':
				$classes .= 'update-nag';
				break;

			case 'success':
				$classes .= 'notice-success is-dismissible';
				break;

			default:
				$classes .= 'error';
		}

		$notice = '<div id="ontrawoo_integration_display_notice " class="' . $classes . '">';
		$notice .= '<p>' . $message . '</p>';
		$notice .= '</div>';

		echo wp_kses_post( $notice );
	}


	/**
	 * Validate the api details.
	 *
	 * @param  string $data    data.
	 * @since  1.0.0.
	 */
	public function ontrawoo_validate_api_details( $data ) {

		$flag = false;

		if ( ! empty( $data['ontrawoo_app_id'] ) && ! empty( $data['ontrawoo_app_key'] ) ) {

			$ontrawoo_connection_mananager = new Ontrawoo_Integration_Connection_Manager( $data['ontrawoo_app_id'], $data['ontrawoo_app_key'] );
			$response = $ontrawoo_connection_mananager->ontrawoo_validate_keys();

			if ( ! is_wp_error( $response ) && isset( $response['status_code'] ) && ! empty( $response['status_code'] ) && 200 == $response['status_code'] ) {

				$flag = true;
				update_option( 'ontrawoo_apiKeys_validated', $flag );
			} else {

				$flag = false;
				update_option( 'ontrawoo_apiKeys_validated', $flag );
			}
		}

		return $flag;
	}

	/**
	 * Check if valid ontraport client Ids is stored.
	 *
	 * @since  1.0.0
	 * @return boolean true/false
	 */
	public static function is_valid_client_ids_stored() {

		$ontra_api_key = get_option( 'ontrawoo_app_key', '' );
		$ontra_api_id = get_option( 'ontrawoo_app_id', '' );

		if ( ! empty( $ontra_api_key ) && ! empty( $ontra_api_id ) ) {

			return true;
		}

		return false;
	}

	/**
	 * Ontrawoo get started.
	 *
	 * @since  1.0.0
	 * @return boolean true/false
	 */
	public static function ontrawoo_get_started() {

		return get_option( 'ontrawoo_get_started', false );
	}

	/**
	 * Check if ontraport keys validation has been successful
	 *
	 * @since  1.0.0
	 * @return boolean true/false
	 */
	public function is_keys_validated() {

		return get_option( 'ontrawoo_apiKeys_validated', false );
	}

	/**
	 * Check if contact record sync is enabled
	 *
	 * @since  1.0.0
	 * @return boolean true/false
	 */
	public function is_contact_record_enable() {

		return get_option( 'ontrawoo_contact_setup_completed', false );

	}
	/**
	 * Check if tag record sync is enabled
	 *
	 * @since  1.0.0
	 * @return boolean true/false
	 */
	public function is_tag_record_enable() {

		if ( get_option( 'ontrawoo_free_tag_enable', '' ) == 'on' ) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * Get ontraport keys for connection
	 *
	 * @since  1.0.0
	 * @return boolean true/false
	 */
	public function get_ontraport_keys() {

		$keys = array(
			'appID' => get_option( 'ontrawoo_app_id', '' ),
			'apiKey' => get_option( 'ontrawoo_app_key' ),
		);

		return $keys;
	}

	/**
	 * Ontraport kconfirm user choise
	 *
	 * @since  1.0.0
	 * @return boolean true/false
	 */
	public function ontrawoo_confirm_user_choice() {

		return get_option( 'ontrawoo_user_choice', '' );
	}

		/**
		 * Verify if the ontraport setup is completed.
		 *
		 * @since 1.0.0
		 * @return boolean true/false
		 */
	public static function is_setup_completed() {

		return get_option( 'ontrawoo_setup_completed', false );
	}

		/**
		 * Clear all data related to previous setup
		 *
		 * @since 1.0.0
		 */
	public function ontrawoo_switch_account() {

		delete_option( 'ontrawoo_pro_get_started' );
		delete_option( 'ontrawoo-order-ocs-upto-date' );
		delete_option( 'ontrawoo_save_campaign_setting' );
		delete_option( 'ontrawoo_save_sequence_setting' );
		delete_option( 'ontrawoo_get_started' );
		delete_option( 'ontrawoo-success-api-calls' );
		delete_option( 'ontrawoo_apiKeys_validated' );
		delete_option( 'ontrawoo_app_id' );
		delete_option( 'ontrawoo_app_key' );
		delete_option( 'ontrawoo_log_enable' );
		delete_option( 'ontrawoo_user_choice' );
		delete_option( 'ontrawoo-free-select-product' );
		delete_option( 'ontrawoo_free_tag_enable' );

		wp_redirect( admin_url( 'admin.php' ) . '?page=ontrawoo&ontrawoo_tab=ontrawoo_connect' );
		exit();
	}


}
