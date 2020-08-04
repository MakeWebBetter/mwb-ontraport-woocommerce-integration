<?php
/**
 * Doc comment
 *
 * @package mwb-ontraport-woocommerce-integration
 */

global $ontrawoo;

$message = __( 'Settings saved', ONTRAWOO_INTEGRATION );

/*
********************************
*****Contact Record Setting*****
********************************
*/
if ( isset( $_POST['ontrawoo_save_contact_record_setting'] ) && check_admin_referer( 'ontrawoo-settings' ) ) {

	unset( $_POST['ontrawoo_save_contact_record_setting'] );

	if ( ! isset( $_POST['ontrawoo_contact_record_enable'] ) ) {

		update_option( 'ontrawoo_contact_record_enable', '' );
		update_option( 'ontrawoo_contact_setup_completed', false );

	} else {

		update_option( 'ontrawoo_contact_record_enable', 'on' );
		update_option( 'ontrawoo_contact_setup_completed', true );

	}

	$ontrawoo->ontrawoo_notice( $message, 'success' );
}
$contact_record_enable = get_option( 'ontrawoo_contact_record_enable', '' );

$success_msg_contact = __( 'Your Contact Record will automatically be saved to your ONTRAPORT account.', ONTRAWOO_INTEGRATION );

$fail_msg_contact = __( 'Enable the feature to automatically save your Contact Record to your ONTRAPORT account.', ONTRAWOO_INTEGRATION );

/*
********************************
*******Tag Record Setting*******
********************************
*/

if ( isset( $_POST['ontrawoo_save_tab_setting'] ) && check_admin_referer( 'ontrawoo-settings' ) ) {

	unset( $_POST['ontrawoo_save_tab_setting'] );

	if ( ! isset( $_POST['ontrawoo-free-select-product'] ) ) {

		update_option( 'ontrawoo-free-select-product', '' );

	}
	if ( ! isset( $_POST['ontrawoo_free_tag_enable'] ) ) {

		update_option( 'ontrawoo_free_tag_enable', '' );

	}
	foreach ( $_POST as $key => $value ) {

		if ( 'ontrawoo_free_tag_enable' == $key ) {

			$value = sanitize_text_field( $value );
		}

		if ( 'ontrawoo-free-select-product' == $key ) {

			$value = array_map( 'esc_attr', $value );
		}
		update_option( $key, $value );
	}

	$ontrawoo->ontrawoo_notice( $message, 'success' );
}
$selected_product_id = get_option( 'ontrawoo-free-select-product', '' );

$tag_enable = get_option( 'ontrawoo_free_tag_enable', '' );

$success_msg_tag = __( 'Tags will be added to your Contacts on your Ontraport account.', ONTRAWOO_INTEGRATION );

$fail_msg_tag = __( 'Enable this feature to add tags to your contacts.', ONTRAWOO_INTEGRATION );

?>

<div class="ontrawoo-settings-container"> 

	<!-- ---------------------------- -->
	<!-- Contact Record Section Start -->
	<!-- ---------------------------- -->
	<div class="ontrawoo-general-settings">
		<h3><?php esc_attr_e( 'Sync Contact Record', ONTRAWOO_INTEGRATION ); ?></h3>
		<form method="post" action="" id="otrawoo-contact-record">
			<div class="ontrawoo-order-status">
				<label for="ontrawoo_contact_record_enable"><?php esc_attr_e( 'Enable/Disable Contact Sync ', ONTRAWOO_INTEGRATION ); ?></label>
				<?php
				if ( 'on' == $contact_record_enable ) {
					echo wp_kses_post( wc_help_tip( $success_msg_contact ) );/*phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped*/
				} else {
					echo wp_kses_post( wc_help_tip( $fail_msg_contact ) );/* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */
				}
				if ( $ontrawoo->is_keys_validated() ) {
					?>
				  <input type="checkbox" <?php echo ( 'on' == $contact_record_enable ) ? "checked='checked'" : ''; ?>name="ontrawoo_contact_record_enable" class="ontrawoo_contact_record_enable" >
					<?php
				} else {
					?>
				  <input type="checkbox" name="ontrawoo_contact_record_enable" class="ontrawoo_contact_record_enable" onclick="return false;">
					<?php
				}
				?>
		  </div>
		  <p class="submit">
			<input type="submit" class="ontrawoo-button ontrawoo-small-button" name="ontrawoo_save_contact_record_setting" value="<?php esc_attr_e( 'Save settings', ONTRAWOO_INTEGRATION ); ?>">
		</p>
		<?php wp_nonce_field( 'ontrawoo-settings' ); ?>
	</form>
</div>
<!-- ---------------------------- -->
<!--  Contact Record Section End  -->
<!-- ---------------------------- -->

<!-- ---------------------------- -->
<!--   Tag Record Section Start   -->
<!-- ---------------------------- -->
<div class="ontrawoo-general-settings">
	<h3><?php esc_html_e( 'Add Tag on Purchase', ONTRAWOO_INTEGRATION ); ?></h3>
	<form method="post" action="" id="otrawoo-tag-record">
		<div class="ontrawoo-order-status">
			<label for="ontrawoo_free_tag_enable"><?php esc_html_e( 'Add tag for item purchase ? ', ONTRAWOO_INTEGRATION ); ?></label>
			<?php
			if ( 'on' == $tag_enable ) {
				echo wp_kses_post( wc_help_tip( $success_msg_tag ) );/* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */
			} else {
				echo wp_kses_post( wc_help_tip( $fail_msg_tag ) );/* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */
			}
			if ( $ontrawoo->is_keys_validated() ) {
				?>
			<input type="checkbox" <?php echo ( 'on' == $tag_enable ) ? "checked='checked'" : ''; ?>name="ontrawoo_free_tag_enable" class="ontrawoo_free_tag_enable" >
				<?php
			} else {
				?>
			<input type="checkbox" name="ontrawoo_free_tag_enable" class="ontrawoo_free_tag_enable" onclick="return false;">
				<?php
			}
			?>
	</div>
	<div class="ontrawoo-order-status">
		<label for="ontrawoo-free-select-product"><?php esc_html_e( 'Select Product', ONTRAWOO_INTEGRATION ); ?></label>
		<?php
		$desc = __( 'Tags will be added for the selected Products.Default will be ALL Products.', ONTRAWOO_INTEGRATION );
		echo wp_kses_post( wc_help_tip( $desc ) );/* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */
		?>
		<select class="ontrawoo-select-product" multiple="multiple" name="ontrawoo-free-select-product[]" id="ontrawoo-free-select-product" data-placeholder="<?php esc_html_e( 'Search for a product&hellip;', ONTRAWOO_INTEGRATION ); ?>">
			<?php
			if ( ! empty( $selected_product_id ) ) {
				foreach ( $selected_product_id as $key => $value ) {

					$product = wc_get_product( $value );
					if ( $product ) {
						$product_name = $product->get_name();
						$output = $product_name . '( #' . $value . ')';
						echo '<option value="' . esc_attr( $value ) . '" selected="selected">' . esc_html( $output ) . '</option>';
					}
				}
			}

			?>

		</select>
	</div>            
	<p class="submit">
		<input type="submit" class="ontrawoo-button ontrawoo-small-button" name="ontrawoo_save_tab_setting" value="<?php esc_attr_e( 'Save settings', ONTRAWOO_INTEGRATION ); ?>">
	</p>
	<?php wp_nonce_field( 'ontrawoo-settings' ); ?>
</form>
</div>
<!-- ---------------------------- -->
<!--    Tag Record Section End    -->
<!-- ---------------------------- -->
</div>
