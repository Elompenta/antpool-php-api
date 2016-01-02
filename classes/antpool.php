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
 * @version		$Revision: 2178 $
 * @date		$Date: 2015-12-05 12:35:40 +0100 (Sa, 05 Dez 2015) $
 * @license		GNU GENERAL PUBLIC LICENSE Version 2
 **/

class antpool {

	// private methods
	function __construct($username, $api_key, $api_secret) {
		$this->username = $username;
		$this->api_key = $api_key;
		$this->api_secret = $api_secret;

		// todo: check if given data is correct

		// todo: check if curl exists
	}

	function __destruct() {
		unset($this->username, $this->api_key, $this->api_secret);
	}

	function get($type) {
		// generate api parameters
		$nonce = time();
		$hmac_message = $this->username.$this->api_key.$nonce;
		$hmac = strtoupper(hash_hmac('sha256', $hmac_message, $this->api_secret, false));

		// create curl request
		$post_fields = array(
			'key' => $this->api_key,
			'nonce' => $nonce,
			'signature' => $hmac
		);

		$post_data = '';
		foreach($post_fields as $key => $value) {
			$post_data.= $key.'='.$value.'&';
		}
		rtrim($post_data, '&');


		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://maaapi.mooo.com/api/'.$type.'.htm');
		// todo: switch to public cert
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		#curl_setopt($ch, CURLOPT_URL, 'https://antpool.com/api/'.$type.'.htm');
		curl_setopt($ch, CURLOPT_POST, count($post_fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = json_decode(curl_exec($ch));
		curl_close($ch);

		if ($result->message == 'ok') {
			return $result->data;
		} else {
			return 'error';
		}

	}
}