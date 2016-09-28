<?php //netteCache[01]000580a:2:{s:4:"time";s:21:"0.53948800 1474980963";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:94:"/var/www/html/findir/wp-content/themes/directory2/ait-theme/elements/header-map/javascript.php";i:2;i:1474608418;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /var/www/html/findir/wp-content/themes/directory2/ait-theme/elements/header-map/javascript.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'dkkx9gj3fe')
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
<script id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>-container-script">

(function($, $window, $document, globals){
"use strict";

$window.load(function(){

	addHeaderMapControls();

	if (Modernizr.touchevents || Modernizr.pointerevents) {
		// disable the panorama on mobile
		if(globals.globalMaps.headerMap.panorama != null){
			// superhack waiting for content
			var headerMapPanoEvent = setInterval(function(){
				// we need second div because the first is the google map itself
				// if(jQuery("#<?php echo $htmlId ?> .google-map-container").children('div').length > 1){ // old condition
				// this is better condition to check for button on streetview
				if(jQuery("#<?php echo $htmlId ?> .draggable-toggle-button").length > 1){ 
					jQuery("#<?php echo $htmlId ?> .google-map-container div:last-child").find('.draggable-toggle-button').parent().parent().find('div:first').css({'pointer-events': 'none'});
					clearInterval(headerMapPanoEvent);
				}
			}, 100);
		}
	}

	function addHeaderMapControls() {
		var map = globals.globalMaps.headerMap.map;
		var panorama = globals.globalMaps.headerMap.panorama;
		if (Modernizr.touchevents || Modernizr.pointerevents) {
			var disableControlDiv = document.createElement('div');
			var disableControl = new DisableHeaderControl(disableControlDiv, map);
			map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(disableControlDiv);
			
			if(panorama != null){
				var disableStreetViewDiv = document.createElement('div');
				var disableStreetViewControl = new DisableHeaderStreetViewControl(disableStreetViewDiv);
				panorama.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(disableStreetViewDiv);
			}
		}
	}

	function isAdvancedSearch() {
		var sPageURL = decodeURIComponent(window.location.search.substring(1)),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;

		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');

			if (sParameterName[0] === "a") {
				return true;
			}
		}
		return false;
	}

	/**
	 * The DisableControl adds a control to the map.
	 * This constructor takes the control DIV as an argument.
	 * @constructor
	 */
	function DisableHeaderControl(controlDiv, map) {
		var containerID = jQuery("#<?php echo $htmlId ?> .google-map-container").attr('id');
		var disableButton = document.createElement('div');
		disableButton.className = "draggable-toggle-button";
		jQuery(disableButton).html('<i class="fa fa-lock"></i>');

		controlDiv.appendChild(disableButton);

		jQuery(this).removeClass('active').html('<i class="fa fa-lock"></i>');
		map.setOptions({ draggable : false });		

		google.maps.event.addDomListener(disableButton, 'click', function(e) {
			if(jQuery(this).hasClass('active')){
				jQuery(this).removeClass('active').html('<i class="fa fa-lock"></i>');
				map.setOptions({ draggable : false });
			} else {
				jQuery(this).addClass('active').html('<i class="fa fa-unlock"></i>');
				map.setOptions({ draggable : true });
			}
		});
	}

	function DisableHeaderStreetViewControl(controlDiv){
		var containerID = jQuery("#<?php echo $htmlId ?> .google-map-container").attr('id');
		var disableButton = document.createElement('div');
		disableButton.className = "draggable-toggle-button";
		jQuery(disableButton).html('<i class="fa fa-lock"></i>');

		controlDiv.appendChild(disableButton);

		jQuery(this).removeClass('active').html('<i class="fa fa-lock"></i>');
		
		google.maps.event.addDomListener(disableButton, 'click', function(e) {
			if(jQuery(this).hasClass('active')){
				jQuery(this).removeClass('active').html('<i class="fa fa-lock"></i>');
				if(globals.globalMaps.headerMap.panorama != null){
					// pano hack
					jQuery(this).parent().parent().find('div:first').css({'pointer-events': 'none'});
				}
			} else {
				jQuery(this).addClass('active').html('<i class="fa fa-unlock"></i>');
				if(globals.globalMaps.headerMap.panorama != null){
					// pano hack
					jQuery(this).parent().parent().find('div:first').css({'pointer-events': ''});
				}
			}
		});
	}
	
});

})(jQuery, jQuery(window), jQuery(document), this);

</script>