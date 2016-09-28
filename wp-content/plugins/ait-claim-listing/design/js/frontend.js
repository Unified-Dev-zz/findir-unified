jQuery(document).ready(function($){
	$('#claim-listing-button').colorbox({
		inline: true,
		href: "#claim-listing-form",
		className: 	'ait-claim-listing',
	});
});

function claimListingRenewCaptcha(){
	jQuery.get(
		jQuery('#colorbox.ait-claim-listing form').attr('action'),
		{
			'action': 'captchaRenew',
			'data': null
		}
	).done(function(xhr){
		var data = JSON.parse(xhr);
		var $container = jQuery('#colorbox.ait-claim-listing form');
		var oldRand = $container.find('input[name="rand"]').val();
		$container.find('input[name="rand"]').val(data.rand);
		var oldHref = $container.find('.input-captcha img').attr('src');
		if(oldHref){
			$container.find('.input-captcha img').attr('src', oldHref.replace(oldRand, data.rand));
		}
	});
}

function submitAjaxClaimListing(e){
	e.preventDefault();

	var $container = jQuery('#colorbox.ait-claim-listing');
	var $form = $container.find('form');
	var $inputs = $form.find('input, select');

	var ajax_post = {};
	var url = $form.attr('action');

	$inputs.each(function(){
		ajax_post[jQuery(this).attr('name')] = jQuery(this).val();
	});

	jQuery.post(url, {
		'action': 'claimItemListing',
		'data': ajax_post,
		'dataType': 'json',
		beforeSend: function(){
			$container.find('.claim-notices-container .claim-notice').hide();

			$form.hide();
			$container.find('.claim-notices-container').show();
			$container.find('.claim-notices-container .notice-loader').show();
		},
	}).done(function(xhr){
		$container.find('.claim-notices-container .notice-loader').hide();
		if(xhr.result === true){
			// submit the form
			$container.find('.claim-notices-container .'+xhr.notification).fadeIn('fast');
		} else {
			$container.find('.claim-notices-container .'+xhr.notification).fadeIn('fast');
		}

		setTimeout(function(){
			location.reload();
		}, 2000);

	}).fail(function(xhr){
		$container.find('.claim-notices-container .notice-loader').hide();
		$container.find('.claim-notices-container .form-error-general').fadeIn('fast');

		setTimeout(function(){
			location.reload();
		}, 2000);
	});
		
}

function submitClaimListing(e){
	var $container = jQuery('#colorbox.ait-claim-listing');
	var $form = $container.find('form');
	var $inputs = $form.find('input, select');
	var $iInputs = $form.find('input[type=hidden], input[type=submit]');

	var validity_counter = 0;
	var ajax_post = {};

	if($form.hasClass('form-can-submit') === false){
		e.preventDefault();

		$inputs.removeClass('input-invalid');

		$inputs.each(function(){
			var ignored = ['hidden', 'submit'];
			if(ignored.indexOf(jQuery(this).attr('type')) == -1){
				if(jQuery(this).attr('type') == 'checkbox'){
					if(jQuery(this).is(':checked')){
						validity_counter = validity_counter + 1;
					} else {
						jQuery(this).parent().addClass('input-invalid');
					}
				} else {
					var value = jQuery(this).val();
					if(value !== ""){
						// passes validation
						validity_counter = validity_counter + 1;
					} else {
						jQuery(this).parent().addClass('input-invalid');
					}
				}
			}
		});

		if(validity_counter === parseInt($inputs.length - $iInputs.length)){
			var ajax_post = {};
			var url = ait.ajax.url;

			$inputs.each(function(){
				ajax_post[jQuery(this).attr('name')] = jQuery(this).val();
			});

			jQuery.post(url, {
				'action': 'captchaCheck',
				'data': ajax_post,
				'dataType': 'json',
				beforeSend: function(){
					$container.find('.claim-notices-container .claim-notice').hide();
				},
			}).done(function(xhr){
				if(xhr.result === true){
					// submit the form
					$form.addClass('form-can-submit');
					$form.trigger('submit');
				} else {
					$container.find('.claim-notices-container .'+xhr.notification).fadeIn('fast');
				}
			}).fail(function(xhr){
				$container.find('.claim-notices-container .form-error-general').fadeIn('fast');
			});
		}

	}

}