<?php
/**
 * All ontraport needed general settings.
 *
 * Template for showing/managing all the ontraport error-management settings.
 *
 * @since 1.0.0
 * @package  mwb-ontraport-woocommerce-integration
 */

global $ontrawoo;

$success_calls = sanitize_text_field( get_option( 'ontrawoo-success-api-calls', 0 ) );
$failed_calls = sanitize_text_field( get_option( 'ontrawoo-error-api-calls', 0 ) );

?>

<div class="ontrawoo-connect-form-header">
	<h2><?php esc_html_e( 'Error Tracking', ONTRAWOO_INTEGRATION ); ?></h2>
</div>

<div class="ontrawoo-extn-status">
	<p><?php esc_html_e( 'Extension Current Status', ONTRAWOO_INTEGRATION ); ?></p>

	<?php
	if ( get_option( 'ontrawoo_alert_param_set' ) ) {
		?>
		<img height="70px" width="70px" src="<?php echo esc_attr( ONTRAWOO_URL . 'admin/images/error.png' ); ?>">
		<?php
	} else {
		?>
	<img src="<?php echo esc_attr( ONTRAWOO_URL . 'admin/images/connected.png' ); ?>">
		<?php
	}
	?>
</div>

<div class="ontrawoo-error-info">
	<div class="ontrawoo-error">
		<p class="ontrawoo-total-calls">
			<?php esc_html_e( 'Total API Calls', ONTRAWOO_INTEGRATION ); ?>
		</p>
		<p class="ontrawoo-error-text">
			<?php $total_val = $success_calls + $failed_calls; ?>
			<?php
			/* translators: %s: user count */
			$txt1 = sprintf( __( 'Count:  %s  ', ONTRAWOO_INTEGRATION ), $total_val );
			echo esc_html( $txt1 );
			?>
			
		</p>
	</div>
	<div class="ontrawoo-error">
		<p class="ontrawoo-success-calls">
			<?php esc_html_e( 'Success API Calls', ONTRAWOO_INTEGRATION ); ?>
		</p>
		<p class="ontrawoo-error-text">
			<?php
			/* translators: %s: user count */
			$txt2 = sprintf( __( 'Count:  %s  ', ONTRAWOO_INTEGRATION ), $success_calls );
			echo esc_html( $txt2 );
			?>
		</p>
		</p>
	</div>
	<div class="ontrawoo-error">
		<p class="ontrawoo-failed-calls">
			<?php esc_html_e( 'Failed API Calls', ONTRAWOO_INTEGRATION ); ?>
		</p>
		<p class="ontrawoo-error-text">
			<?php
			/* translators: %s: user count */
			$txt3 = sprintf( __( 'Count:  %s  ', ONTRAWOO_INTEGRATION ), $failed_calls );
			echo esc_html( $txt3 );
			?>
		</p>
	</div>
</div>

<div class="ontrawoo-error-log-wrap">
		<?php if ( file_exists( WC_LOG_DIR . 'ontrawoo-logs.log' )  ) { ?>
				<div class="ontrawoo-error-log-head">
					<a class="ontrawoo-button" href="<?php echo admin_url('admin.php?page=ontrawoo&ontrawoo_tab=error-management&action=download_logs') ;?>"><?php _e("Download Log File" , "ontrawoo") ; ?>
					</a>
					<a class="ontrawoo-button ontrawoo-button-secondary" href="<?php echo admin_url('admin.php?page=ontrawoo&ontrawoo_tab=error-management&action=fuck') ;?>"><?php _e("Clear Log File" , "ontrawoo") ; ?>
					</a>
				</div>
		<?php } ?>
	<div id="log-viewer" >
		<?php if ( file_exists( WC_LOG_DIR . 'ontrawoo-logs.log' )) { ?>
			<pre><?php echo esc_html( file_get_contents( WC_LOG_DIR . 'ontrawoo-logs.log' ) ); ?></pre>
		<?php } else { ?>
			<pre><strong><?php echo esc_html( "Log file:ontrawoo-logs.log not found or you have disabled the log creation. Please enable the option in general settings.", "ontrawoo" ); ?></strong></pre>
		<?php } ?>
	</div>

</div>

