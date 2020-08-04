<?php
/**
 * All ontraport needed general settings.
 *
 * Template for showing/managing all the ontraport one-click-sync settings.
 *
 * @since 1.0.0
 * @package  mwb-ontraport-woocommerce-integration
 */

?>
<div class="mauwoo-fields-header mauwoo-common-header text-center">
	<h2><?php esc_html_e( 'Order Activity Tag Assignment', ONTRAWOO_INTEGRATION ); ?></h2>
	<a id="mauwoo-go-pro-link" href="https://makewebbetter.com/product/ontraport-woocommerce-integration-pro/" class="" title="" target="_blank">
				<input type="Button" class="ontrawoo-button" name="ontrawoo_save_gensttings" value="<?php esc_attr_e( 'Get this Feature Now', ONTRAWOO_INTEGRATION ); ?>"></a>
</div>
<p class="mauwoo_go_pro text-center"><?php esc_html_e( 'With Order Activity Tag Assignment feature, you can add rule and assign tags, once the order activity status changes to "pending", contacts assigned with the tag.', ONTRAWOO_INTEGRATION ); ?>

<div class= "ontrawoo-activity-rule" >
  <a href="https://makewebbetter.com/product/ontraport-woocommerce-integration-pro/" target="_blank"><br>
  <img src="<?php echo esc_url( ONTRAWOO_URL . 'admin/images/activity_rule.png' ); ?>" >
  </a>
</div>


