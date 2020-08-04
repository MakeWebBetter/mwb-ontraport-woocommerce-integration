<?php
/**
 * Doc comment
 *
 * @package mwb-ontraport-woocommerce-integration
 */

?> 
 <div class="mauwoo-fields-header mauwoo-common-header">
	<h2><?php esc_html_e( 'Get Started', ONTRAWOO_INTEGRATION ); ?></h2>
</div> 
<p class="mauwoo_go_pro"><?php esc_html_e( 'Bring the power of Marketing Automation and Reporting to your eCommerce platform by connecting your WooCommerce store to Ontraport in just one click.', ONTRAWOO_INTEGRATION ); ?>
</p>

<div class="ontrawoowoo_get_started">
<table id="ontrawoowoo_get_started">
  <tr>
	<th><?php esc_html_e( 'Feature', ONTRAWOO_INTEGRATION ); ?></th>
	<th><?php esc_html_e( 'Free ', ONTRAWOO_INTEGRATION ); ?></th>
	<th><?php esc_html_e( 'Pro', ONTRAWOO_INTEGRATION ); ?></th>
  </tr>
  <tr>
	<td><?php esc_html_e( 'Sync Contact Record ', ONTRAWOO_INTEGRATION ); ?></td>
	<td><?php esc_html_e( 'Registered Users', ONTRAWOO_INTEGRATION ); ?></td>
	<td><?php esc_html_e( 'Registered as well as Guest Users', ONTRAWOO_INTEGRATION ); ?></td>
  </tr>
  <tr>
	<td><?php esc_html_e( 'Sync Sales Record', ONTRAWOO_INTEGRATION ); ?></td>
	<td><div class="mauwoo-field-checked">
			<img src="<?php echo esc_attr( ONTRAWOO_URL . 'admin/images/del.png' ); ?>">

		</div>
	</td>
	<td><div class="mauwoo-field-checked">
			<img src="<?php echo esc_attr( ONTRAWOO_URL . 'admin/images/checked.png' ); ?>">
		</div></td>
  </tr>
  <tr>
	<td><?php esc_html_e( 'Add Tag of Purchase Products', ONTRAWOO_INTEGRATION ); ?></td>
	<td><div class="mauwoo-field-checked">
			<img src="<?php echo esc_attr( ONTRAWOO_URL . 'admin/images/checked.png' ); ?>">
		</div></td>
	<td><div class="mauwoo-field-checked">
			<img src="<?php echo esc_attr( ONTRAWOO_URL . 'admin/images/checked.png' ); ?>">
		</div>
		
	</td>
  </tr>
  <tr>
	<td><?php esc_html_e( 'Add Accept Marketing ', ONTRAWOO_INTEGRATION ); ?></td>
	<td><div class="mauwoo-field-checked">
			<img src="<?php echo esc_attr( ONTRAWOO_URL . 'admin/images/del.png' ); ?>">

		</div>
	</td>
	<td><div class="mauwoo-field-checked">
			<img src="<?php echo esc_attr( ONTRAWOO_URL . 'admin/images/checked.png' ); ?>">
		</div></td>
  </tr>
  <tr>
	<td><?php esc_html_e( 'Abandoned Cart', ONTRAWOO_INTEGRATION ); ?></td>
	<td><div class="mauwoo-field-checked">
			<img src="<?php echo esc_attr( ONTRAWOO_URL . 'admin/images/del.png' ); ?>">

		</div>
	</td>
	<td><div class="mauwoo-field-checked">
			<img src="<?php echo esc_attr( ONTRAWOO_URL . 'admin/images/checked.png' ); ?>">
		</div></td>
  </tr>
  <tr>
	<td><?php esc_html_e( 'Compaigns Subscription', ONTRAWOO_INTEGRATION ); ?></td>
	<td><div class="mauwoo-field-checked">
			<img src="<?php echo esc_attr( ONTRAWOO_URL . 'admin/images/del.png' ); ?>" >
		</div></td>
	<td>
		<div class="mauwoo-field-checked">
			<img src="<?php echo esc_attr( ONTRAWOO_URL . 'admin/images/checked.png' ); ?>">
		</div>
	</td>
  </tr>
  <tr>
	<td><?php esc_html_e( 'Sequences Subscription', ONTRAWOO_INTEGRATION ); ?></td>
	 <td><div class="mauwoo-field-checked">
			<img src="<?php echo esc_attr( ONTRAWOO_URL . 'admin/images/del.png' ); ?>" >
		</div></td>
	<td>
		<div class="mauwoo-field-checked">
			<img src="<?php echo esc_attr( ONTRAWOO_URL . 'admin/images/checked.png' ); ?>">
		</div>
	</td>
  </tr>
  <tr>
	<td><?php esc_html_e( 'Add Order Activity Tag Assignment', ONTRAWOO_INTEGRATION ); ?></td>
	<td><div class="mauwoo-field-checked">
			<img src="<?php echo esc_attr( ONTRAWOO_URL . 'admin/images/del.png' ); ?>">

		</div>
	</td>
	<td><div class="mauwoo-field-checked">
			<img src="<?php echo esc_attr( ONTRAWOO_URL . 'admin/images/checked.png' ); ?>">
		</div></td>
  </tr>
   <tr>
	<td><?php esc_html_e( 'One Click Sync for Historical Data', ONTRAWOO_INTEGRATION ); ?></td>
	<td><div class="mauwoo-field-checked">
			<img src="<?php echo esc_attr( ONTRAWOO_URL . 'admin/images/del.png' ); ?>" >
		</div></td>
	<td><div class="mauwoo-field-checked">
			<img src="<?php echo esc_attr( ONTRAWOO_URL . 'admin/images/checked.png' ); ?>">
		</div></td>
  </tr>
  
</table>
<div>
	
			<p >
				<a id="mauwoo-go-pro-link" href="https://makewebbetter.com/product/ontraport-woocommerce-integration-pro/" class="" title="" target="_blank">
				<input type="Button" class="ontrawoo-button" name="ontrawoo_save_gensttings" value="<?php esc_attr_e( 'BUY PREMIUM NOW ', ONTRAWOO_INTEGRATION ); ?>">
			</p>
			<?php wp_nonce_field( 'ontrawoo-settings' ); ?>
</div>
</div>
