<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    mwb-ontraport-woocommerce-integration.
 * @subpackage mwb-ontraport-woocommerce-integration/admin.
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to.
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    mwb-ontraport-woocommerce-integration.
 * @subpackage mwb-ontraport-woocommerce-integration/admin.
 * @author     MakeWebBetter <webmaster@makewebbetter.com>.
 */
class Mwb_Ontraport_Woocommerce_Integration_Admin {

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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->admin_actions();

	}

	/**
	 * All admin actions.
	 *
	 * @since 1.0.0
	 */
	public function admin_actions() {

		// add submenu ontraport in woocommerce top menu.
		add_action( 'admin_menu', array( &$this, 'add_ontrawoo_submenu' ) );
	}

	/**
	 * Add ontraport submenu in woocommerce menu..
	 *
	 * @since 1.0.0
	 */
	public function add_ontrawoo_submenu() {

		add_submenu_page( 'woocommerce', __( 'Ontraport', ONTRAWOO_INTEGRATION ), __( 'Ontraport', ONTRAWOO_INTEGRATION ), 'manage_woocommerce', 'ontrawoo', array( &$this, 'ontrawoo_configurations' ) );
	}

	/**
	 * All the configuration related fields and settings.
	 *
	 * @since 1.0.0
	 */
	public function ontrawoo_configurations() {

		include_once ONTRAWOO_ABSPATH . 'admin/templates/ontrawoo-integration-main-template.php';
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		$screen = get_current_screen();

		if ( isset( $screen->id ) && 'woocommerce_page_ontrawoo' == $screen->id ) {

			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mwb-ontraport-woocommerce-integration-admin.css', array(), $this->version, 'all' );

			wp_register_style( 'woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css', array(), WC_VERSION );

			wp_enqueue_style( 'woocommerce_admin_styles' );

			wp_enqueue_style( 'woocommerce_admin_menu_styles' );

			wp_enqueue_style( 'ontrawoo_jquery_ui', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css', array(), $this->version );

			wp_enqueue_style( 'thickbox' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		$screen = get_current_screen();

		if ( isset( $screen->id ) && 'woocommerce_page_ontrawoo' == $screen->id ) {

			wp_register_script( 'woocommerce_admin', WC()->plugin_url() . '/assets/js/admin/woocommerce_admin.js', array( 'jquery', 'jquery-blockui', 'jquery-ui-sortable', 'jquery-ui-widget', 'jquery-ui-core', 'jquery-tiptip', 'wc-enhanced-select' ), WC_VERSION );

			$locale  = localeconv();
			$decimal = isset( $locale['decimal_point'] ) ? $locale['decimal_point'] : '.';
			$params = array(
				/* translators: %s: search term */
				'i18n_decimal_error'                => sprintf( __( 'Please enter in decimal (%s) format without thousand separators.', ONTRAWOO_INTEGRATION ), $decimal ),
				/* translators: %s: search term */
				'i18n_mon_decimal_error'            => sprintf( __( 'Please enter in monetary decimal (%s) format without thousand separators and currency symbols.', ONTRAWOO_INTEGRATION ), wc_get_price_decimal_separator() ),
				'i18n_country_iso_error'            => __( 'Please enter in country code with two capital letters.', ONTRAWOO_INTEGRATION ),
				'i18_sale_less_than_regular_error'  => __( 'Please enter in a value less than the regular price.', ONTRAWOO_INTEGRATION ),
				'decimal_point'                     => $decimal,
				'mon_decimal_point'                 => wc_get_price_decimal_separator(),
				'strings' => array(
					'import_products' => __( 'Import', ONTRAWOO_INTEGRATION ),
					'export_products' => __( 'Export', ONTRAWOO_INTEGRATION ),
				),
				'urls' => array(
					'import_products' => esc_url_raw( admin_url( 'edit.php?post_type=product&page=product_importer' ) ),
					'export_products' => esc_url_raw( admin_url( 'edit.php?post_type=product&page=product_exporter' ) ),
				),
			);

			wp_enqueue_script( 'jquery-ui-datepicker' );

			wp_localize_script( 'woocommerce_admin', 'woocommerce_admin', $params );
			wp_enqueue_script( 'woocommerce_admin' );

			wp_register_script( 'ontrawoo_admin_script', plugin_dir_url( __FILE__ ) . 'js/mwb-ontraport-woocommerce-integration-admin.js', array( 'jquery' ), $this->version, true );
			wp_localize_script(
				'ontrawoo_admin_script',
				'ontrawooi18n',
				array(
					'ajaxUrl'                   => admin_url( 'admin-ajax.php' ),
					'ontrawooSecurity'          => wp_create_nonce( 'ontrawoo_security' ),
					'ontrawooConnectTab'        => admin_url() . 'admin.php?page=ontrawoo&ontrawoo_tab=ontrawoo_connect',
					'ontrawooFieldsTab'         => admin_url() . 'admin.php?page=ontrawoo&ontrawoo_tab=ontrawoo_setup',
					'ontrawooAccountSwitch'     => __( 'Want to continue to switch to new Ontraport Account? This cannot be reverted and will require running the whole setup again.', ONTRAWOO_INTEGRATION ),
				)
			);

			wp_enqueue_script( 'ontrawoo_admin_script' );

		}
	}

	/**
	 * Connect tab fields.
	 *
	 * @return array  woocommerce_admin_fields acceptable fields in array.
	 * @since 1.0.0
	 */
	public static function ontrawoo_settings() {

		$basic_settings = array();

		$basic_settings[] = array(
			'title' => __( 'Connect With Ontraport', ONTRAWOO_INTEGRATION ),
			'id'    => 'ontrawoo_settings_title',
			'type'  => 'title',
		);

		$basic_settings[] = array(
			'title' => __( 'Ontraport App ID', ONTRAWOO_INTEGRATION ),
			'id'    => 'ontrawoo_app_id',
			'type'  => 'text',
		);

		$basic_settings[] = array(
			'title' => __( 'Ontraport API Key', ONTRAWOO_INTEGRATION ),
			'id'    => 'ontrawoo_app_key',
			'type'  => 'text',
		);

		$basic_settings[] = array(
			'title' => __( 'Enable/Disable', ONTRAWOO_INTEGRATION ),
			'id'    => 'ontrawoo_log_enable',
			/* translators: %s: search term */
			'desc'  => sprintf( __( 'Enable logging of the requests. You can view ontraport log file from %s', ONTRAWOO_INTEGRATION ), '<a href="' . admin_url( 'admin.php?page=wc-status&tab=logs' ) . '">' . __( 'Here', ONTRAWOO_INTEGRATION ) . '</a>' ),
			'type'  => 'checkbox',
		);
		$basic_settings[] = array(

			'type' => 'sectionend',
			'id' => 'ontrawoo_settings_end',
		);

		return $basic_settings;
	}

	/**
	 * Connect tab fields for display.
	 *
	 * @return array  woocommerce_admin_fields acceptable fields in array.
	 * @since 1.0.0
	 */
	public static function ontrawoo_settings_to_display() {

		$basic_settings = array();

		$basic_settings[] = array(
			'title' => __( 'Connected With Ontraport', ONTRAWOO_INTEGRATION ),
			'id'    => 'ontrawoo_settings_title',
			'type'  => 'title',
		);

		$basic_settings[] = array(
			'title' => __( 'Ontraport App ID', ONTRAWOO_INTEGRATION ),
			'id'    => 'ontrawoo_app_id',
			'type'      => 'text',
			'custom_attributes' => array( 'disabled' => 1 ),
		);

		$basic_settings[] = array(
			'title' => __( 'Ontraport API Key', ONTRAWOO_INTEGRATION ),
			'id'    => 'ontrawoo_app_key',
			'type'      => 'text',
			'custom_attributes' => array( 'disabled' => 1 ),
		);

		$basic_settings[] = array(
			'title' => __( 'Enable/Disable', ONTRAWOO_INTEGRATION ),
			'id'    => 'ontrawoo_log_enable',
			/* translators: %s: search term */
			'desc'  => sprintf( __( 'Enable logging of the requests. You can view ontraport log file from %s', ONTRAWOO_INTEGRATION ), '<a href="' . admin_url( 'admin.php?page=wc-status&tab=logs' ) . '">' . __( 'Here', ONTRAWOO_INTEGRATION ) . '</a>' ),
			'type'  => 'checkbox',
		);

		$basic_settings[] = array(
			'type' => 'sectionend',
			'id' => 'ontrawoo_settings_end',
		);

		return $basic_settings;
	}

	/**
	 * Woocommerce privacy policy
	 *
	 * @since 1.0.0
	 */
	public function ontrawoo_add_privacy_message() {

		if ( function_exists( 'wp_add_privacy_policy_content' ) ) {

			$content = '<p>' . __( 'We use your email to send your Orders related data over Ontraport.', ONTRAWOO_INTEGRATION ) . '</p>';

			$content .= '<p>' . __( 'ONTRAPORT is the most powerful visual marketing automation and reporting platform in the world that helps companies attract visitors, convert leads, and close customers.', ONTRAWOO_INTEGRATION ) . '</p>';

			$content .= '<p>' . __( 'Please see the ', ONTRAWOO_INTEGRATION ) . '<a href="https://ontraport.com/legal#op-container--33" target="_blank" >' . __( 'ontraport Data Privacy', ONTRAWOO_INTEGRATION ) . '</a>' . __( ' for more details.', ONTRAWOO_INTEGRATION ) . '</p>';

			if ( $content ) {

				wp_add_privacy_policy_content( __( 'Ontraport WooCommerce Integration', ONTRAWOO_INTEGRATION ), $content );
			}
		}

		if(isset($_GET['action']) && $_GET['action'] == "download_logs"){

			$filename = WC_LOG_DIR . 'ontrawoo-logs.log';

			if(is_readable($filename) &&  file_exists($filename) ){
				header('Content-type: text/plain');
				header('Content-Disposition: attachment; filename="'.basename($filename).'"');
				readfile($filename);
				exit;
			}
			else{

				wp_redirect( admin_url("admin.php?page=ontrawoo&ontrawoo_tab=error_management") );
				exit;
			}
		}

		if(isset($_GET['action']) && $_GET['action'] == "fuck"){

			$filename = WC_LOG_DIR . 'ontrawoo-logs.log';

			if(file_exists($filename)){

				file_put_contents($filename, "");

			}
				wp_redirect( admin_url("admin.php?page=ontrawoo&ontrawoo_tab=error_management") );
				exit;		
		}
	}


	/**
	 * Get started on admin call
	 *
	 * @since 1.0.0
	 */
	public static function ontrawoo_get_started_call() {

		check_ajax_referer( 'ontrawoo_security', 'ontrawooSecurity' );
		update_option( 'ontrawoo_get_started', true );
		return true;
	}

	/**
	 * Save user choice after authorization
	 *
	 * @since 1.0.0
	 */
	public static function ontrawoo_save_user_choice() {

		$choice = isset( $_POST['choice'] ) ? sanitize_text_field( wp_unslash( $_POST['choice'] ) ) : ' ';
		check_ajax_referer( 'ontrawoo_security', 'ontrawooSecurity' );
		update_option( 'ontrawoo_user_choice', $choice );
		return true;
	}

	/**
	 * Ajax search for products
	 *
	 * @since 1.0.0
	 */
	public static function ontrawoo_search_for_order_products() {

		$return = array();

		$product_search = new WP_Query(
			array(
				's' => ! empty( $_GET['product_name'] ) ? sanitize_text_field( wp_unslash( $_GET['product_name'] ) ) : '',
				'post_type' => array( 'product', 'product_varitaion' ),
				'post_status' => array( 'publish' ),
				'posts_per_page' => -1,
			)
		);

		if ( $product_search->have_posts() ) {

			while ( $product_search->have_posts() ) {

				$product_search->the_post();

				$title = ( mb_strlen( $product_search->post->post_title ) > 50 ) ? mb_substr( $product_search->post->post_tile, 0, 49 ) . '..' : $product_search->post->post_title;

				$product = wc_get_product( $product_search->post->ID );

				$return[] = array( $product_search->post->ID, $title );
			}
		}

		echo json_encode( $return );

		wp_die();
	}

}
