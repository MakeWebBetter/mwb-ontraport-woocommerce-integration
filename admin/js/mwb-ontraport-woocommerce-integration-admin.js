(function( $ ) {
	'use strict';

	// i18n variables
	var ajaxUrl 						= ontrawooi18n.ajaxUrl;
	var ontrawooSecurity 				= ontrawooi18n.ontrawooSecurity;
	var ontrawooConnectTab 				= ontrawooi18n.ontrawooConnectTab;
	var ontrawooAccountSwitch 			= ontrawooi18n.ontrawooAccountSwitch;
	var ontrawooFieldsTab				= ontrawooi18n.ontrawooFieldsTab;
	
	jQuery(document).ready(function(){

		//Search for product
		product_search();

		//When clicked on disabled tab
		jQuery('a.ontrawoo-disabled').on("click", function(e) {

			return false;
		});

		//Click on get started button
		jQuery('a#ontrawoo-get-started').on("click",function(e){

			jQuery('#ontrawoo_loader').show();
			jQuery.post( ajaxUrl, { 'action' : 'ontrawoo_get_started_call', 'ontrawooSecurity' : ontrawooSecurity }, function( status ) {
				window.location.href = ontrawooConnectTab;
			});
		});

		//Click on next step button
		jQuery('a.ontrawoo_next_step').on("click", function(e) {

			jQuery('#ontrawoo_loader').show();
			jQuery.post( ajaxUrl, { 'action' : 'ontrawoo_save_user_choice', 'ontrawooSecurity' : ontrawooSecurity, 'choice' : 'next_step' }, function( status ) {
				window.location.href = ontrawooFieldsTab;
			});
		});
		//Change Ontraport Account 
		jQuery('a.ontrawoo-change-account').on( 'click', function(e) {

			if( confirm( ontrawooAccountSwitch ) ) {

				
				location.reload();
			}
			else {

				e.preventDefault();
				return false;
			}
		});

		//Search for products in the store
		function product_search(){
			//product search
			jQuery('.ontrawoo-select-product').select2({
				ajax: {
					url: ajaxUrl,
					dataType: 'json',
					delay: 200,
					data: function(params){
						return{
							product_name: params.term,
							action: 'ontrawoo_search_for_order_products'
						};
					},
					processResults: function(data){
						var product_options = [];
	
						if(data)
						{
							jQuery.each(data, function(index,text){
								text[1] += '( #' + text[0] + ')';
								product_options.push({id:text[0], text:text[1]});
							});
						}
						return{
							results: product_options
						};
					},
					cache:true
				},
				minimumInputLength: 3
			});
		}		
	});
})( jQuery );