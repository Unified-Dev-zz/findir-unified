<?php //netteCache[01]000595a:2:{s:4:"time";s:21:"0.54875800 1474646616";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:108:"/home/zaerodes/public_html/findir/wp-content/themes/directory2/ait-theme/elements/search-form/javascript.php";i:2;i:1474646218;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/zaerodes/public_html/findir/wp-content/themes/directory2/ait-theme/elements/search-form/javascript.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '1t5c1r5fnv')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
?>
<script id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>-script">
//jQuery(window).load(function(){
jQuery(document).ready(function(){
<?php if ($options->theme->general->progressivePageLoading) { ?>
		if(!isResponsive(1024)){
			jQuery("#<?php echo $htmlId ?>-main").waypoint(function(){
				jQuery("#<?php echo $htmlId ?>-main").addClass('load-finished');
			}, { triggerOnce: true, offset: "95%" });
		} else {
			jQuery("#<?php echo $htmlId ?>-main").addClass('load-finished');
		}
<?php } else { ?>
		jQuery("#<?php echo $htmlId ?>-main").addClass('load-finished');
<?php } ?>

	/*jQuery('#<?php echo $htmlId ?>').find('.radius-search').keyup(function(){
		var min = jQuery(this).data('min');
		var max = jQuery(this).data('max');
		var current = jQuery(this).val().replace(/[^0-9\.]/g,'');

		if (current > max){
			jQuery(this).val(max);
		} else {
			jQuery(this).val(current);
		}
	});*/

	var select2Settings = {
		dropdownAutoWidth : true
	};

	jQuery('#<?php echo $htmlId ?>').find('select').select2(select2Settings).on("select2-close", function() {
		// fired to the original element when the dropdown closes
		jQuery('.select2-drop').removeClass('select2-drop-active');

		// replace all &nbsp;
		var regPattern = "&nbsp;";
		jQuery('#<?php echo $htmlId ?> .category-search .select2-chosen').html(jQuery('#<?php echo $htmlId ?> .category-search .select2-chosen').html().replace(new RegExp(regPattern, "g"), ''));
		jQuery('#<?php echo $htmlId ?> .location-search .select2-chosen').html(jQuery('#<?php echo $htmlId ?> .location-search .select2-chosen').html().replace(new RegExp(regPattern, "g"), ''));

		jQuery('.select2-drop').removeClass('select-position-first').removeClass('select-position-last');
	});

	jQuery('#<?php echo $htmlId ?>').find('select').select2(select2Settings).on("select2-loaded", function() {
		// fired to the original element when the dropdown closes
		jQuery('#<?php echo $htmlId ?>').find('.select2-container').removeAttr('style');
	});

	jQuery('#<?php echo $htmlId ?>').find('select').select2(select2Settings).on("select2-open", function() {
		var selectPosition = jQuery('#<?php echo $htmlId ?>').find('.select2-dropdown-open').parent().attr('data-position');
		jQuery('.select2-drop').addClass('select-position-'+selectPosition);
	});

	if(isMobile()){
		jQuery('#<?php echo $htmlId ?> .category-search-wrap').find('select').select2(select2Settings).on("select2-selecting", function(val, choice) {
			if(val != ""){
				jQuery('#<?php echo $htmlId ?>').find('.category-clear').addClass('clear-visible');
			}
		});
		jQuery('#<?php echo $htmlId ?> .location-search-wrap').find('select').select2(select2Settings).on("select2-selecting", function(val, choice) {
			if(val != ""){
				jQuery('#<?php echo $htmlId ?>').find('.location-clear').addClass('clear-visible');
			}
		});

		jQuery('#<?php echo $htmlId ?> .category-search-wrap').find('select').select2(select2Settings).on("select2-selecting", function(val, choice) {
			if(val != ""){
				// add class
				jQuery('#<?php echo $htmlId ?> .category-search-wrap').addClass('option-selected');
			}
		});
		jQuery('#<?php echo $htmlId ?> .location-search-wrap').find('select').select2(select2Settings).on("select2-selecting", function(val, choice) {
			if(val != ""){
				jQuery('#<?php echo $htmlId ?> .location-search-wrap').addClass('option-selected');
			}
		});
	} else {
		jQuery('#<?php echo $htmlId ?> .category-search-wrap').find('select').select2(select2Settings).on("select2-selecting", function(val, choice) {
			if(val != ""){
				// add class
				jQuery('#<?php echo $htmlId ?> .category-search-wrap').addClass('option-selected');
			}
		});
		jQuery('#<?php echo $htmlId ?> .location-search-wrap').find('select').select2(select2Settings).on("select2-selecting", function(val, choice) {
			if(val != ""){
				jQuery('#<?php echo $htmlId ?> .location-search-wrap').addClass('option-selected');
			}
		});

		jQuery('#<?php echo $htmlId ?>').find('.category-search-wrap').hover(function(){
			if(jQuery(this).find('select').select2("val") != ""){
				jQuery(this).find('.category-clear').addClass('clear-visible');
			}
		},function(){
			if(jQuery(this).find('select').select2("val") != ""){
				jQuery(this).find('.category-clear').removeClass('clear-visible');
			}
		});

		jQuery('#<?php echo $htmlId ?>').find('.location-search-wrap').hover(function(){
			if(jQuery(this).find('select').select2("val") != ""){
				jQuery(this).find('.location-clear').addClass('clear-visible');
			}
		},function(){
			if(jQuery(this).find('select').select2("val") != ""){
				jQuery(this).find('.location-clear').removeClass('clear-visible');
			}
		});
	}

	jQuery('#<?php echo $htmlId ?>').find('.select2-chosen').each(function(){
		jQuery(this).html(jQuery(this).html().replace(new RegExp("&nbsp;", "g"), ''));
	});

	/*jQuery('#<?php echo $htmlId ?>').find('form').submit(function(){
		var $radiusInput = jQuery(this).find('.radius-search');
		$radiusInput.attr('value', $radiusInput.val().length == 0 ? $radiusInput.attr('placeholder') : $radiusInput.val());
	});*/

	if(isMobile()){
		jQuery('#<?php echo $htmlId ?>').find('.radius').on('click', function(){
			jQuery(this).find('.radius-clear').addClass('clear-visible');
		});
	} else {
		jQuery('#<?php echo $htmlId ?>').find('.radius').hover(function(){
			jQuery(this).find('.radius-clear').addClass('clear-visible');
		},function(){
			jQuery(this).find('.radius-clear').removeClass('clear-visible');
		});
	}

	jQuery('#<?php echo $htmlId ?>').find('.category-clear').click(function(){
		jQuery('#<?php echo $htmlId ?>').find('.category-search-wrap select').select2("val", "");
		jQuery(this).removeClass('clear-visible');
		// remove class selected
		jQuery('#<?php echo $htmlId ?> .category-search-wrap').removeClass('option-selected');
	});
	jQuery('#<?php echo $htmlId ?>').find('.location-clear').click(function(){
		jQuery('#<?php echo $htmlId ?>').find('.location-search-wrap select').select2("val", "");
		jQuery(this).removeClass('clear-visible');
		// remove class selected
		jQuery('#<?php echo $htmlId ?> .location-search-wrap').removeClass('option-selected');
	});
	/*jQuery('#<?php echo $htmlId ?>').find('.radius-clear').click(function(){
		jQuery(this).removeClass('clear-visible');
	});*/


	/* RADIUS SCRIPT */

	var $headerMap = jQuery("#<?php echo $elements->unsortable['header-map']->getHtmlId() ?>-container");

	var $radiusContainer = jQuery('#<?php echo $htmlId ?> .radius');
	var $radiusToggle = $radiusContainer.find('.radius-toggle');
	var $radiusDisplay = $radiusContainer.find('.radius-display');
	var $radiusPopup = $radiusContainer.find('.radius-popup-container');

	$radiusToggle.click(function(){
		jQuery(this).removeClass('radius-input-visible').addClass('radius-input-hidden');
		$radiusContainer.find('input').each(function(){
			jQuery(this).removeAttr('disabled');
		});
		$radiusDisplay.removeClass('radius-input-hidden').addClass('radius-input-visible');
		$radiusDisplay.trigger('click');

		$radiusDisplay.find('.radius-value').html($radiusPopup.find('input').val());
		$radiusPopup.find('.radius-value').html($radiusPopup.find('input').val());
	});

	$radiusDisplay.click(function(){
		$radiusPopup.removeClass('radius-input-hidden').addClass('radius-input-visible');

		if($headerMap.length != 0){
			$headerMap.gmap3({
				getgeoloc: {
					callback: function(latLng){
						if(latLng){
							jQuery("#latitude-search").attr('value', latLng.lat());
							jQuery("#longitude-search").attr('value', latLng.lng());
							jQuery(".elm-header-map ").removeClass('deactivated');
						}
					}
				}
			});
		} else {
			navigator.geolocation.getCurrentPosition(function(position){
				jQuery("#latitude-search").attr('value', position.coords.latitude);
				jQuery("#longitude-search").attr('value', position.coords.longitude);
				jQuery(".elm-header-map ").removeClass('deactivated');
			}, function(){
				// error callback
			});
		}
	});
	$radiusDisplay.find('.radius-clear').click(function(e){
		e.stopPropagation();
		$radiusDisplay.removeClass('radius-input-visible').addClass('radius-input-hidden');
		$radiusContainer.find('input').each(function(){
			jQuery(this).attr('disabled', true);
		});
		$radiusPopup.find('.radius-popup-close').trigger('click');
		$radiusToggle.removeClass('radius-input-hidden').addClass('radius-input-visible');
		$radiusContainer.removeClass('radius-set');
	});
	$radiusPopup.find('.radius-popup-close').click(function(e){
		e.stopPropagation();
		$radiusPopup.removeClass('radius-input-visible').addClass('radius-input-hidden');
	});
	$radiusPopup.find('input').change(function(){
		$radiusDisplay.find('.radius-value').html(jQuery(this).val());
		$radiusPopup.find('.radius-value').html(jQuery(this).val());
	});

<?php if ($selectedRad) { ?>
	$radiusToggle.trigger('click');
<?php } ?>
	/* RADIUS SCRIPT */

<?php if ($type == 2) { ?>
	/* KEYWORD INPUT HACK */
	var $keywordContaier = jQuery('#<?php echo $htmlId ?> #searchinput-text');
	var $keywordWidthHack = jQuery('#<?php echo $htmlId ?> .search-input-width-hack');

	if($keywordContaier.val() != ""){
		$keywordWidthHack.html($keywordContaier.val());
	} else {
		$keywordWidthHack.html($keywordWidthHack.attr('data-defaulttext'));
	}
	$keywordContaier.width($keywordWidthHack.width());

	$keywordContaier.on('keyup', function(){
		if(jQuery(this).val() != ""){
			$keywordWidthHack.html(jQuery(this).val());
		} else {
			$keywordWidthHack.html($keywordWidthHack.attr('data-defaulttext'));
		}

		if($keywordWidthHack.width() <= 150){
			if(jQuery(this).val() != ""){
				$keywordContaier.width($keywordWidthHack.outerWidth(true));
			} else {
				$keywordContaier.width($keywordWidthHack.width());
			}
		}
	});
	/* KEYWORD INPUT HACK */
<?php } ?>

<?php if ($type == 3) { ?>
	jQuery('#<?php echo $htmlId ?> .category-search-wrap .category-icon').on('click', function(){
	//jQuery('#<?php echo $htmlId ?> .category-search-wrap').on('click', function(){
		jQuery(this).parent().find('select').select2('open');
	});
	jQuery('#<?php echo $htmlId ?> .location-search-wrap .location-icon').on('click', function(){
	//jQuery('#<?php echo $htmlId ?> .category-search-wrap').on('click', function(){
		jQuery(this).parent().find('select').select2('open');
	});
<?php } ?>
});

/*jQuery(window).load(function(){
	jQuery('#<?php echo $htmlId ?>').find('.select2-chosen').each(function(){
		jQuery(this).html(jQuery(this).html().replace(new RegExp("&nbsp;", "g"), ''));
	});
});*/
</script>
