<?php

return array(
	'raw' => array(
		'claimListing' => array(
			'title' => __('Claim Listing', 'ait-claim-listing'),
			'options' => array(
				'enable' => array(
					'label' => __('Enable Claim Listing', 'ait-claim-listing'),
					'type' => 'on-off',
					'default' => false,
					'help' => __('Enable or disable claim listing for items', 'ait-claim-listing'),
				),

				'defaultPackage'=> array(
					'label' => __('Default Package', 'ait-claim-listing'),
					'type' => 'select-dynamic',
					'dataFunction' => 'AitClaimListing::userPackagesSelect',
					'default' => '',
					'help' => __('Assign new user to selected package', 'ait-claim-listing'),
				),

				'emailSubject' => array(
					'label' => __('Email Subject', 'ait-claim-listing'),
					'type' => 'text',
					'default' => __('Claim Listing Request', 'ait-claim-listing'),
					'help' => __('Subject for the email notification', 'ait-claim-listing'),
				),
				'emailMessage' => array(
					'label' => __('Email Message', 'ait-claim-listing'),
					'type' => 'textarea',
					'default' => __('User: {user} <br> Item: {item} <br><br> {actions}', 'ait-claim-listing'),
					'help' => __('Message for the email notification', 'ait-claim-listing'),
				),

				'sectionTitle' => array(
					'label' => __('Section Title', 'ait-claim-listing'),
					'type' => 'text',
					'default' => __('Claim Listing', 'ait-claim-listing'),
					'help' => __('Title for the section shown on item detail', 'ait-claim-listing'),
				),
				'sectionDescription' => array(
					'label' => __('Section Description', 'ait-claim-listing'),
					'type' => 'textarea',
					'default' => __('Lorem ipsum dolor sit amet', 'ait-claim-listing'),
					'help' => __('Description for the section shown on item detail', 'ait-claim-listing'),
				),

				'formLabelUsername' => array(
					'label' => __('Form Username Label', 'ait-claim-listing'),
					'type' => 'text',
					'default' => __('Username', 'ait-claim-listing'),
					'help' => __('Label for username field', 'ait-claim-listing'),
				),
				'formLabelEmail' => array(
					'label' => __('Form Email Label', 'ait-claim-listing'),
					'type' => 'text',
					'default' => __('Email', 'ait-claim-listing'),
					'help' => __('Label for email field', 'ait-claim-listing'),
				),
				'formLabelPayment' => array(
					'label' => __('Form Payment Label', 'ait-claim-listing'),
					'type' => 'text',
					'default' => __('Payment', 'ait-claim-listing'),
					'help' => __('Label for payment field', 'ait-claim-listing'),
				),
				'formLabelCaptcha' => array(
					'label' => __('Form Captcha Label', 'ait-claim-listing'),
					'type' => 'text',
					'default' => __('Captcha', 'ait-claim-listing'),
					'help' => __('Label for captcha field', 'ait-claim-listing'),
				),
				'formLabelSubmit' => array(
					'label' => __('Form Submit Label', 'ait-claim-listing'),
					'type' => 'text',
					'default' => __('Claim Listing', 'ait-claim-listing'),
					'help' => __('Label for submit button', 'ait-claim-listing'),
				),

				'loggedInFormText' => array(
					'label' => __('Logged in form text', 'ait-claim-listing'),
					'type' => 'textarea',
					'default' => __('Are you sure you want to claim the current item?', 'ait-claim-listing'),
					'help' => __('Text displayed in the form when user is logged in', 'ait-claim-listing'),
				),

				'frontendNotification1Enable' => array(
					'label' => __('Frontend notification 1', 'ait-claim-listing'),
					'type' => 'on-off',
					'default' => true,
					'help' => __('Display notification: Item already claimed', 'ait-claim-listing'),
				),
				'frontendNotification2Enable' => array(
					'label' => __('Frontend notification 2', 'ait-claim-listing'),
					'type' => 'on-off',
					'default' => true,
					'help' => __('Display notification: Item pending moderation from admin', 'ait-claim-listing'),
				),
				'frontendNotification3Enable' => array(
					'label' => __('Frontend notification 3', 'ait-claim-listing'),
					'type' => 'on-off',
					'default' => true,
					'help' => __('Display notification: Claim listing disabled for current role', 'ait-claim-listing'),
				),
				'frontendNotification4Enable' => array(
					'label' => __('Frontend notification 4', 'ait-claim-listing'),
					'type' => 'on-off',
					'default' => true,
					'help' => __('Display notification: Maximum package items exceeded, cannot claim item', 'ait-claim-listing'),
				),

				'termsAndConditionsEnable' => array(
					'label' => __('Enable Terms & Conditions', 'ait-claim-listing'),
					'type' => 'on-off',
					'default' => false,
					'help' => __('Display Terms & Conditions input on registration form', 'ait-claim-listing'),
				),
				'termsAndConditionsLabel' => array(
					'label' => __('Terms & Conditions label', 'ait-claim-listing'),
					'type' => 'textarea',
					'default' => __('Accepts Terms & Conditions', 'ait-claim-listing'),
					'help' => __('Text for Terms & Conditions form input', 'ait-claim-listing'),
				),
			),
		),
	),
	'defaults' => array(
		'claimListing' => array(
			'enable' => false,
			'newUserPackage' => '',
			'emailSubject' => __('Claim Listing Request', 'ait-claim-listing'),
			'emailMessage' => __('User: {user} <br> Item: {item} <br><br> {actions}', 'ait-claim-listing'),
			'sectionTitle' => __('Claim Listing', 'ait-claim-listing'),
			'sectionDescription' => __('Lorem ipsum dolor sit amet', 'ait-claim-listing'),
			'formLabelUsername' => __('Username', 'ait-claim-listing'),
			'formLabelEmail' => __('Email', 'ait-claim-listing'),
			'formLabelPayment'  => __('Payment', 'ait-claim-listing'),
			'formLabelCaptcha' => __('Captcha', 'ait-claim-listing'),
			'formLabelSubmit' => __('Claim Listing', 'ait-claim-listing'),
			'loggedInFormText' => __('Are you sure you want to claim the current item?', 'ait-claim-listing'),
			'frontendNotification1Enable' => true,
			'frontendNotification2Enable' => true,
			'frontendNotification3Enable' => true,
			'frontendNotification4Enable' => true,
			'termsAndConditionsEnable' => false,
			'termsAndConditionsLabel' => __('Accepts Terms & Conditions', 'ait-claim-listing'),
		)
	)
);

