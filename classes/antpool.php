<?php
/*!
 * @author		Sebastian Lutz
 * @copyright	Baebeca Solutions - Lutz
 * @email		lutz@baebeca.de
 * @pgp			0x5AD0240C
 * @link		https://www.baebeca.de
 * @link-github	https://github.com/Elompenta/antpool-php-api
 * @customer	-
 * @project		antpool-php-api
 * @license		GNU GENERAL PUBLIC LICENSE Version 2
 **/

class antpool {

	// configurations
	private $print_error_if_api_down = true;

	// private methods
	function __construct($username, $api_key, $api_secret) {
		$this->username = $username;
		$this->api_key = $api_key;
		$this->api_secret = $api_secret;

		// todo: check if given data is correct

		if (!function_exists('curl_exec')) {
			exit("Error: Please install PHP curl extension to use this Software.\r\n $ apt-get install php5-curl\r\n");
		}
	}

	function __destruct() {
		unset($this->username, $this->api_key, $this->api_secret);
	}

    function hasPageSizeParameter($type) {
        return $type === 'workers' || $type === 'paymentHistory';
    }

	function get($type, $currency = 'BTC', $page_size = 10) {
		// generate api parameters
		$nonce = time();
		$hmac_message = $this->username.$this->api_key.$nonce;
		$hmac = strtoupper(hash_hmac('sha256', $hmac_message, $this->api_secret, false));

		// create curl request
		$post_fields = array(
			'key' => $this->api_key,
			'nonce' => $nonce,
			'signature' => $hmac,
			'coin' => $currency
		);

        if($this->hasPageSizeParameter($type))
            $post_fields = array_merge( $post_fields, array('pageSize' => $page_size));

		$post_data = '';
		foreach($post_fields as $key => $value) {
			$post_data.= $key.'='.$value.'&';
		}
		rtrim($post_data, '&');


		$ch = curl_init();
		#curl_setopt($ch, CURLOPT_URL, 'https://maaapi.mooo.com/api/'.$type.'.htm');
		curl_setopt($ch, CURLOPT_URL, 'https://antpool.com/api/'.$type.'.htm');
		// todo: switch to public cert
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
		curl_setopt($ch, CURLOPT_POST, count($post_fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// set large timeout because API lak sometimes
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$result = curl_exec($ch);
		curl_close($ch);

		// check if curl was timed out
		if ($result === false) {
			if ($this->print_error_if_api_down) {
				exit('Error: No API connect');
			} else {
				exit();
			}
		}

		// validate JSON
		$result_json = json_decode($result);
		if (json_last_error() != JSON_ERROR_NONE) exit('Error: read broken JSON from API - JSON Error: '.json_last_error().' ('.$result.')');

		if ($result_json->message == 'ok') {
			return $result_json->data;
		} else {
			exit('API Error: '.print_r($result_json, true));
		}

	}

	function config($config, $value) {
		if (isset($this->$config)) {
			$this->$config = $value;
		}
	}
}
