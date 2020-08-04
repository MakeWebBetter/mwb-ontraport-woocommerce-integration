<?php
/**
 * All ontraport needed general settings.
 *
 * Template for showing/managing all the ontraport general settings
 *
 * @since 1.0.0
 * @package  mwb-ontraport-woocommerce-integration
 */

// check if the connect is entered and have valid connect..

global $ontrawoo;

$choice = $ontrawoo->ontrawoo_confirm_user_choice();

if ( isset( $_POST['ontrawoo_activate_connect'] ) && check_admin_referer( 'ontrawoo-settings' ) ) {

	unset( $_POST['ontrawoo_activate_connect'] );

	if ( $ontrawoo->ontrawoo_validate_api_details( $_POST ) == 202 ) {

		woocommerce_update_options( Mwb_Ontraport_Woocommerce_Integration_Admin::ontrawoo_settings() );
		$message = __( 'Ontraport Keys Validated and Settings saved successfully.', ONTRAWOO_INTEGRATION );
		$ontrawoo->ontrawoo_notice( $message, 'success' );
	} else {

		$message = __( 'Your Ontraport Keys cannot be validated. Please check and try again.', ONTRAWOO_INTEGRATION );
		$ontrawoo->ontrawoo_notice( $message, 'error' );
	}
} elseif ( isset( $_POST['ontrawoo_settings'] ) && check_admin_referer( 'ontrawoo-settings' ) ) {

	unset( $_POST['ontrawoo_settings'] );

	if ( ! isset( $_POST['ontrawoo_log_enable'] ) ) {

		$_POST['ontrawoo_log_enable'] = 'no';
	} else {

		$_POST['ontrawoo_log_enable'] = 'yes';
	}

	update_option( 'ontrawoo_log_enable', sanitize_text_field( wp_unslash( $_POST['ontrawoo_log_enable'] ) ) );
	$message = __( 'Settings saved successfully.', ONTRAWOO_INTEGRATION );
	$ontrawoo->ontrawoo_notice( $message, 'success' );
}
if ( isset( $_GET['action'] ) && 'switchAccount' == $_GET['action'] ) {

	$ontrawoo->ontrawoo_switch_account();

}
?>

	
<?php if ( $ontrawoo->is_keys_validated() ) { ?> 
	
	<div class="ontrawoo-connection-container">
		<a href="?page=ontrawoo&ontrawoo_tab=ontrawoo_connect&action=switchAccount" class="ontrawoo-button ontrawoo-button-secondary"><?php esc_html_e( 'Change Ontraport Account', ONTRAWOO_INTEGRATION ); ?></a>
		<form class="ontrawoo-connect-form" action="" method="post">
			<?php woocommerce_admin_fields( Mwb_Ontraport_Woocommerce_Integration_Admin::ontrawoo_settings_to_display() ); ?>
			<div class="ontrawoo-connect-form-submit">
				<p class="submit">
					<input type="submit" name="ontrawoo_settings" value="<?php esc_attr_e( 'Save', ONTRAWOO_INTEGRATION ); ?>" class="ontrawoo-button" />
				</p>
				<?php wp_nonce_field( 'ontrawoo-settings' ); ?>
			</div>
		</form>
	</div>
	<?php
} else {
	?>
	<div class="ontrawoo-connection-container">
		<form class="ontrawoo-connect-form" action="" method="post">
			<?php woocommerce_admin_fields( Mwb_Ontraport_Woocommerce_Integration_Admin::ontrawoo_settings() ); ?>
			<div class="ontrawoo-connect-form-submit">
				<p class="submit">
					<input type="submit" name="ontrawoo_activate_connect" value="<?php esc_attr_e( 'Save', ONTRAWOO_INTEGRATION ); ?>" class="ontrawoo-button" />
				</p>
				<?php wp_nonce_field( 'ontrawoo-settings' ); ?>
			</div>
		</form>
	</div>
	<?php
}
?>

<?php
$display = 'none';

if ( $ontrawoo->is_keys_validated() && empty( $choice ) ) {

	$display = 'block';
}

?>
<div class="ontrawoo_pop_up_wrap" style="display: <?php echo esc_attr( $display ); ?>">
	<div class="pop_up_sub_wrap">
		<p>
			<?php esc_html_e( 'Congratulations! Your Ontraport keys have been validated.', ONTRAWOO_INTEGRATION ); ?>
		</p>
		<div class="button_wrap">
			<a href="javascript:void(0);" class="ontrawoo_next_step"><?php esc_html_e( 'Proceed to Next Step', ONTRAWOO_INTEGRATION ); ?></a>
		</div>
	</div> 
</div>
