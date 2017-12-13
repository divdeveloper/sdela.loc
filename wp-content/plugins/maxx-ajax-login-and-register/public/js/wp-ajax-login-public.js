function pt_open_login_dialog(href){

	jQuery('#pt-user-modal .modal-dialog').removeClass('registration-complete');

	var modal_dialog = jQuery('#pt-user-modal .modal-dialog');
	modal_dialog.attr('data-active-tab', '');

	switch(href){

		case '#pt-register':
			modal_dialog.attr('data-active-tab', '#pt-register');
			break;

		case '#pt-info':
			modal_dialog.attr('data-active-tab', '#pt-info');
			break;


		case '#pt-login':
		default:
			modal_dialog.attr('data-active-tab', '#pt-login');
			break;
	}

	jQuery('#pt-user-modal').modal('show');
}	

function pt_close_login_dialog(){

	jQuery('#pt-user-modal').modal('hide');
}	

jQuery(function($){

	"use strict";
	/***************************
	**  LOGIN / REGISTER DIALOG
	***************************/

	// Open login/register modal
	$('[href="#pt-login"], [href="#pt-register"], [href="#pt-info"]').click(function(e){

		e.preventDefault();

		pt_open_login_dialog( $(this).attr('href') );

	});

	// Switch forms login/register
	$('.modal-footer a, a[href="#pt-reset-password"]').click(function(e){
		e.preventDefault();
		$('#pt-user-modal .modal-dialog').attr('data-active-tab', $(this).attr('href'));
	});
        
//        $('a[href="#pt-info"]').click(function(e){
//		e.preventDefault();
//		$('#pt-user-modal .modal-dialog').attr('data-active-tab', $(this).attr('href'));
//	});


	// Post login form
	$('#pt_login_form').on('submit', function(e){

		e.preventDefault();

		var button = $(this).find('button');
			button.button('loading');

		$.post(ptajax.ajaxurl, $('#pt_login_form').serialize(), function(data){

			var obj = $.parseJSON(data);

			$('.pt-login .pt-errors').html(obj.message);
			
			if(obj.error == false){
				$('#pt-user-modal .modal-dialog').addClass('loading');
				window.location.reload(true);
				button.hide();
			}

			button.button('reset');
		});

	});


	// Post register form
	$('#pt_registration_form').on('submit', function(e){

		e.preventDefault();

		var button = $(this).find('button');
			button.button('loading');

		$.post(ptajax.ajaxurl, $('#pt_registration_form').serialize(), function(data){
			
			var obj = $.parseJSON(data);

			$('.pt-register .pt-errors').html(obj.message);
			
			if(obj.error == false){
				$('#pt-user-modal .modal-dialog').addClass('registration-complete');
				// window.location.reload(true);
				button.hide();
			}

			button.button('reset');
			
		});

	});

	// Logout
	$('[href="#logout"]').click(function(e){

		e.preventDefault();

		$.ajax({
			url: ptajax.ajaxurl,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'pt_logout',
			},
			success: function(data) {

				if(data.error == false){
                                    
					$('.pt-logout .pt-errors').html(data.message);
					window.location.reload(true);
				}
			}
		});

	});


	// Reset Password
	$('#pt_reset_password_form').on('submit', function(e){

		e.preventDefault();

		var button = $(this).find('button');
			button.button('loading');

		$.post(ptajax.ajaxurl, $('#pt_reset_password_form').serialize(), function(data){

			var obj = $.parseJSON(data);

			$('.pt-reset-password .pt-errors').html(obj.message);
			
			// if(obj.error == false){
				// $('#pt-user-modal .modal-dialog').addClass('loading');
				// $('#pt-user-modal').modal('hide');
			// }

			button.button('reset');
		});

	});

	if(window.location.hash == '#login'){
		pt_open_login_dialog('#pt-login');
	}		

});
jQuery(document).ready(function(){
jQuery("#pt_user_phone").mask('(00) 000-00-00').intlTelInput({
  initialCountry: "auto",
  geoIpLookup: function(callback) {
    jQuery.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
      var countryCode = (resp && resp.country) ? resp.country : "";
      callback(countryCode);
    });
  },
  utilsScript: "utils.js" // just for formatting/placeholders etc
});



	//jQuery('#pt_user_phone').mask('(000) 00-00-000');
});