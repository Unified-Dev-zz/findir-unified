<?php

add_filter('ait-theme-config', function ($config) {

	// titles
	$titles = array();
	for ($i=1; $i <= 4; $i++) {
		$titles[$i] = new NNeonEntity;
		$titles[$i]->value = 'section';
	}
	$titles[1]->attributes = array('title' => __('Environment','ait-stripe'));
	$titles[2]->attributes = array('title' => __('Test credentials','ait-stripe'));
	$titles[3]->attributes = array('title' => __('Live credentials','ait-stripe'));
	$titles[4]->attributes = array('title' => __('Redirections','ait-stripe'));

	$config['stripe'] = array(
		'title' => 'Stripe',
		'options' => array(

			1 => $titles[1],

			'live' => array(
				'label' => __('Live environment','ait-stripe'),
				'type' => 'on-off',
				'default' => ''
			),

			2 => $titles[2],

			'testSecretKey' => array(
				'label' => __('Secret key','ait-stripe'),
				'type' => 'code',
				'default' => ''
			),
			'testPublishableKey' => array(
				'label' => __('Publishable key','ait-stripe'),
				'type' => 'code',
				'default' => ''
			),

			3 => $titles[3],

			'liveSecretKey' => array(
				'label' => __('Secret key','ait-stripe'),
				'type' => 'code',
				'default' => ''
			),
			'livePublishableKey' => array(
				'label' => __('Publishable key','ait-stripe'),
				'type' => 'code',
				'default' => ''
			),

			4 => $titles[4],

			'successPage' => array(
				'label' => __('After successful payment', 'ait-stripe'),
				'type' => 'posts',
				'cpt' => 'page',
				'default' => '',
				'help' => __('Visitor is redirected to selected page after successful payment', 'ait-stripe')
			),
			'errorPage' => array(
				'label' => __('After failed payment', 'ait-stripe'),
				'type' => 'posts',
				'cpt' => 'page',
				'default' => '',
				'help' => __('Visitor is redirected to selected page after failed payment', 'ait-stripe')
			)

		)
	);

	return $config;

});