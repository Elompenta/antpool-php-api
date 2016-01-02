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

// load classes
require_once('classes/antpool.php');

// check if custom config file exist
if (file_exists('config.php')) {
	require_once('config.php');
} else {
	exit('please create your own config.php based on config.sample.php');
}

// init antpool class
$ant = new antpool($username, $api_key, $api_secret);

// check if custom.php exist and execute
if (file_exists('custom.php')) {
	require_once('custom.php');
} else {
	require_once('custom.sample.php');
}