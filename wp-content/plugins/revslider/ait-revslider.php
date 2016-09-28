<?php


define('AIT_REVSLIDER_ENABLED', true);
define('AIT_REVSLIDER_PACKAGE', 'developer');



add_action('plugins_loaded', 'aitRevsliderOverrides');

function aitRevsliderOverrides()
{

	if(get_option('revslider-valid') === 'false'){
		update_option('revslider-valid', 'true');
	}
}



add_action('plugins_loaded', 'aitRemoveRevsliderNotices');

function aitRemoveRevsliderNotices()
{
	remove_action('admin_notices', array('RevSliderAdmin', 'add_plugins_page_notices'));

	global $productAdmin;
	if($productAdmin and $productAdmin instanceof RevSliderAdmin){
		remove_action('admin_notices', array($productAdmin, 'addActivateNotification'));
	}
}

