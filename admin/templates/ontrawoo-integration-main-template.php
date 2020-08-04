<?php
/**
 * Doc comment
 *
 * @package mwb-ontraport-woocommerce-integration
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit(); // Exit if accessed directly.
}
?>

<?php
global $ontrawoo;
$active_tab = isset( $_GET['ontrawoo_tab'] ) ? sanitize_text_field( filter_var( wp_unslash( $_GET['ontrawoo_tab'] ) ), FILTER_SANITIZE_URL ) : 'ontrawoo_overview';
$default_tabs = $ontrawoo->ontrawoo_default_tabs();
?>

<div class="ontrawoo-main-template">
	<div class="ontrawoo-header-template">
		<div class="ontrawoo-ontraport-icon">
			
			<h2><?php esc_html_e( 'Integration with Ontraport for WooCommerce', 'ONTRAWOO_INTEGRATION' ); ?></h2>
		</div>
		<div class="ontrawoo-header-text">
			<ul>
				<li><a href=<?php echo esc_url( 'https://makewebbetter.com/contact-us/' ); ?> target="_blank"><i class="fas fa-phone-volume"></i></a></li>
				<li><a href=<?php echo esc_url( 'https://docs.makewebbetter.com/ontraport-woocommerce-integration/?utm_source=MWB-ontraport-org&utm_medium=MWB-ORG&utm_campaign=ORG' ); ?>><i class="far fa-file-alt"></i></a></li>
				<li class="mauwoo-main-menu-button"><a id="mauwoo-go-pro-link" href=<?php echo esc_url( 'https://makewebbetter.com/product/ontraport-woocommerce-integration-pro/' ); ?> class="" title="" target="_blank"><?php esc_html_e( 'Go pro now', 'ONTRAWOO_INTEGRATION' ); ?></a></li>
				
				<li><a href=<?php echo esc_url( 'https://join.skype.com/invite/IKVeNkLHebpC' ); ?>><i class="fab fa-skype"></i></a></li>
			</ul>
		</div>
	</div>
	<div class="ontrawoo-body-template">
		<div class="ontrawoo-navigator-template">
			<div class="ontrawoo-navigations">
				<?php
				if ( is_array( $default_tabs ) && count( $default_tabs ) ) {

					foreach ( $default_tabs as $tab_key => $single_tab ) {


						$dependency = $single_tab['dependency'];

						$tab_classes = 'ontrawoo-nav-tab ';

						if ( ! empty( $active_tab ) && $tab_key == $active_tab ) {

							$tab_classes .= 'nav-tab-active';
						}

						if ( ! empty( $dependency ) && ! $ontrawoo->$dependency() ) {

							$tab_classes .= 'ontrawoo-disabled';
						}
						if ( 'ontrawoo_abandoned_cart' == $tab_key || 'ontrawoo_one_click_sync' == $tab_key || 'ontrawoo_activity_rule' == $tab_key || 'ontrawoo_campaign_sequence' == $tab_key ) {

							$tab_classes .= ' ontrawoo-lock';
						}
						?>
								<div class="ontrawoo-tabs"><a class="<?php echo esc_attr( $tab_classes ); ?>" id="<?php echo esc_attr( $tab_key ); ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=ontrawoo' ) . '&ontrawoo_tab=' . $tab_key ); ?>"><i class="<?php echo esc_attr( $single_tab['icon'] ); ?>"></i> <span><?php echo esc_attr( $single_tab['name'] ); ?></span></a></div>
							<?php
					}
				}
				?>
			</div>
		</div>
		<div class="ontrawoo-content-template">
			<div class="ontrawoo-content-container">
				<?php
					// if submenu is directly clicked on woocommerce.
				if ( empty( $active_tab ) ) {

					$active_tab = ' ontrawoo_overview';
				}

					// look for the path based on the tab id in the admin templates.
				$tab_content_path = 'admin/templates/' . $active_tab . '.php';

				$ontrawoo->load_template_view( $tab_content_path );
				?>
			</div>
		</div>
	</div>
	<div class="loading-style-bg ontrawoo_integration_loader" id="ontrawoo_loader">
		<img src="<?php echo esc_url( ONTRAWOO_URL . 'admin/images/loader.gif' ); ?>">
	</div>
	
</div>
