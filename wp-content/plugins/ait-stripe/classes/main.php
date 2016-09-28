<?php

class AitStripe
{

	private static $instance = null;

	public $options;
	public $payment;


	protected function __construct() {}

	public static function getInstance()
	{
		if (null == self::$instance) {
			self::$instance = new self;
			// construct
			self::$instance->setOptions();
			// handle actions
			add_action('wp_ajax_ait_stripe_checkout', array(__CLASS__, 'handleAjaxCheckout'));
			add_action('wp_ajax_nopriv_ait_stripe_checkout', array(__CLASS__, 'handleAjaxCheckout'));
		}
		return self::$instance;
	}

	private function setOptions()
	{
		if (!function_exists('aitOptions')) {
			throw new AitStripeException("Plugin is compatible only with AIT framework 2.0");
		}
		$options = aitOptions()->get('theme');
		if (isset($options->stripe)) {
			$this->options = $options->stripe;
		}
	}

	private function setSecretKey()
	{
		if (empty($this->options)) {
			throw new AitStripeException("Missing theme options");
		}
		if (empty($this->options->live)) {
			Stripe\Stripe::setApiKey($this->options->testSecretKey);
		} else {
			Stripe\Stripe::setApiKey($this->options->liveSecretKey);
		}
	}

	private function getPublishableKey()
	{
		if (empty($this->options)) {
			throw new AitStripeException("Missing theme options");
		}
		if (empty($this->options->live)) {
			return $this->options->testPublishableKey;
		} else {
			return $this->options->livePublishableKey;
		}
	}

	public function requestPayment($data, $name, $description, $amount, $currency = 'USD')
	{
		$this->payment = array(
			'name' => $name,
			'description' => $description,
			'amount' => $amount,
			'currency' => $currency,
			'data' => $data
		);
		add_action('wp_footer', array(__CLASS__, 'generateCheckout'));
		add_action('admin_footer', array(__CLASS__, 'generateCheckout'));
	}

	public function generateCheckout()
	{
		$obj = self::getInstance();
		$paymentJson = json_encode($obj->payment);
		$publishableKey = $obj->getPublishableKey();
		$ajaxUrl = admin_url('admin-ajax.php');
		$ajaxNonce = wp_create_nonce('ait-stripe-ajax-checkout');
		echo <<<BUTTON
			<
			<script src="https://checkout.stripe.com/checkout.js"></script>
			<script>
				var aitStripe = {
					api: StripeCheckout.configure({
						key: '{$publishableKey}',
						token: function(token) {
							var data = {
								action: 'ait_stripe_checkout',
								nonce: '{$ajaxNonce}',
								token: token.id,
								payment: aitStripe.payment
							};
							jQuery.post('{$ajaxUrl}', data, function(data) {
								if(data.redirect) {
									window.location = data.redirect;
								}
							});
						},
						closed: function(){
							setTimeout(function(){
								if(jQuery('body').find('iframe.stripe_checkout_app').length == 0){
									if(typeof ait.home.url !== "undefined"){
										window.location.href = ait.home.url + "?ait-notification=user-registration-success";
									}									
								}	
							}, 500);							
						}
					}),
					payment: null,
					requestPayment: function(params) {
						this.payment = params;
						// Zero-decimal currencies
						// https://support.stripe.com/questions/which-zero-decimal-currencies-does-stripe-support
						if (params.currency == 'BIF' || params.currency == 'CLP' || params.currency == 'DJF' || params.currency == 'GNF' || params.currency == 'JPY' || params.currency == 'KMF' || params.currency == 'KRW' || params.currency == 'MGA' || params.currency == 'PYG' || params.currency == 'RWF' || params.currency == 'VND' || params.currency == 'VUV' || params.currency == 'XAF' || params.currency == 'XOF' || params.currency == 'XPF') {
							this.payment.amount = params.amount;
						} else {
							// in cents
							this.payment.amount = params.amount * 100;
						}
						this.api.open(params);
					}
				};
				jQuery(window).on('popstate', function() {
					aitStripe.api.close();
				});
				aitStripe.requestPayment({$paymentJson});
			</script>
BUTTON;
	}

	public function handleAjaxCheckout()
	{
		check_ajax_referer('ait-stripe-ajax-checkout', 'nonce');
		$result = array(
			'success' => false
		);
		try {
			$obj = AitStripe::getInstance();
			$obj->setSecretKey();
			$params = array('currency' => 'usd');
			// filter
			foreach ($_POST['payment'] as $key => $value) {
				if (in_array($key, array('description', 'amount', 'currency'))) {
					$params[$key] = $value;
				}
			}
			$params['source'] = $_POST['token'];
			$charge = Stripe\Charge::create($params);
			if ($charge->status == 'succeeded') {
				$payment = (object) $_POST['payment'];
				do_action('ait-stripe-payment-success', $payment, $charge);
				$result['success'] = true;
				if (!empty($obj->options->successPage)) {
					$result['redirect'] = get_permalink($obj->options->successPage);
				}
			} else {
				if (!empty($obj->options->errorPage)) {
					$result['redirect'] = get_permalink($obj->options->errorPage);
				}
			}
		} catch (Exception $e) {
			AitStripe::error($e);
			do_action('ait-stripe-payment-error', $e->getMessage());
			if (!empty($obj->options->errorPage)) {
				$result['redirect'] = get_permalink($obj->options->errorPage);
			}
		}
		wp_send_json($result);
	}

	public static function log($message, $title = '', $fileName = 'info.log')
	{
		if ($message instanceof Exception) {
			$message = $message->getMessage();
			$title = get_class($message);
		} else {
			$message = print_r($message, true);
			$title = (!empty($title)) ? " - " . $title : "";
		}
		$message = date("Y-m-d H:i:s") . $title . "\n\n" . $message . "\n\n";
		// save to uploads
		$path = wp_upload_dir();
		if (is_writable($path['basedir'])) {
			$file = $path['basedir']."/ait/stripe/";
			if (wp_mkdir_p($file)) {
				$file .= $fileName;
				error_log($message, 3, $file);
			}
		}
	}

	public static function error($message)
	{
		self::log($message, '', 'error.log');
	}

}

class AitStripeException extends Exception {}