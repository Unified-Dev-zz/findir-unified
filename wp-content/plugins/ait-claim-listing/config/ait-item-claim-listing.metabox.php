<?php

return array(
	'status' => array(
		'label' => __('Claim Status', 'ait-claim-listing'),
		'type' => 'info',
		'dataFunction' => 'AitClaimListing::getClaimStatus',
		'default' => "unclaimed"
	),

	'owner' => array(
		'label' => __('Claim Owner', 'ait-claim-listing'),
		'type' => 'info',
		'dataFunction' => 'AitClaimListing::getClaimOwner',
		'default' => "-"
	),

	'date' => array(
		'label' => __('Claim Date', 'ait-claim-listing'),
		'type' => 'info',
		'dataFunction' => 'AitClaimListing::getClaimDate',
		'default' => "-"
	),
);