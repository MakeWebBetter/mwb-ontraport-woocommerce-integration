<?php
/**
 * All ontrawoo needed general settings.
 *
 * Template for showing/managing all the ontrawoo general settings
 *
 * @since 1.0.0
 * @package    mwb-ontraport-woocommerce-integration
 */

global $ontrawoo;

$GLOBALS['hide_save_button']  = true;

?>
	<div class="ontrawoo-overview-wrapper">
		<div class="ontrawoo-overview-header ontrawoo-common-header">
			<h2><?php esc_html_e( 'How our Integration works?', ONTRAWOO_INTEGRATION ); ?></h2>
		</div>
		<div class="ontrawoo-overview-body">
			<div class="ontrawoo-what-we-do ontrawoo-overview-container">
				<h4><?php esc_html_e( 'What we do?', ONTRAWOO_INTEGRATION ); ?></h4>
				<div class="ontrawoo-custom-fields">
					<p class="ontrawoo-anchors" href="#"><?php esc_html_e( 'Create Contact Record', ONTRAWOO_INTEGRATION ); ?></p>
				</div>
				<div class="ontrawoo-custom-fields">
					<p class="ontrawoo-anchors" href="#"><?php esc_html_e( 'Add Tag to Contacts', ONTRAWOO_INTEGRATION ); ?></p>
				</div>
				<p class="ontrawoo-desc-num">1</p>
			</div>
			<div class="ontrawoo-how-easy-to-setup ontrawoo-overview-container">
				<h4><?php esc_html_e( 'How easy is it?', ONTRAWOO_INTEGRATION ); ?></h4>
				<div class="ontrawoo-setup">
					<p class="ontrawoo-anchors" href="#"><?php esc_html_e( 'Just 3 steps to Go!', ONTRAWOO_INTEGRATION ); ?></p>
				</div>
				<p class="ontrawoo-desc-num">2</p>
			</div>
			<div class="ontrawoo-what-you-achieve ontrawoo-overview-container">
				<h4><?php esc_html_e( 'What at the End?', ONTRAWOO_INTEGRATION ); ?></h4>
				<div class="ontrawoo-automation">
					<p class="ontrawoo-anchors" href="#"><?php esc_html_e( 'Automated Marketing', ONTRAWOO_INTEGRATION ); ?></p>
				</div>
				<p class="ontrawoo-desc-num">3</p>
			</div>
		</div>
		<div class="ontrawoo-overview-footer">
			<div class="ontrawoo-overview-footer-content-2 ontrawoo-footer-container">
				
				<?php
				if ( $ontrawoo->ontrawoo_get_started() ) {
					?>
							<a href="?page=ontrawoo&ontrawoo_tab=ontrawoo_connect" class="ontrawoo-button"><?php echo esc_html_e( 'Next', ONTRAWOO_INTEGRATION ); ?></a>
						<?php
				} else {
					?>
							<img width="40px" height="40px" src="<?php echo esc_attr( ONTRAWOO_URL . 'admin/images/right-direction-icon.png' ); ?>"/>
							<a id="ontrawoo-get-started" href="javascript:void(0)" class="ontrawoo-button"><?php echo esc_html_e( 'Get Started', ONTRAWOO_INTEGRATION ); ?></a>
						<?php
				}
				?>
			</div>
		</div>
	</div>
