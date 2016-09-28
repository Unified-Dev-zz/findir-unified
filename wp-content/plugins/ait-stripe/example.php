<?php

/**
 * EXAMPLE OF USAGE
 */

if (isset($_GET['test-stripe'])) {
	$stripe = AitStripe::getInstance();
	$stripe->requestPayment(array('membership' => 'business'), 'Shop name', 'Payment description', 0.5, 'EUR');
}

add_action('ait-stripe-payment-success', function($payment) {
	AitStripe::log($payment, 'PAYMENT COMPLETED');
});

add_action('ait-stripe-payment-error', function($message) {
	AitStripe::error($message, 'PAYMENT FAILED');
});