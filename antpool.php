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

// load classes
error_reporting(E_ALL);
require_once(__DIR__.'/classes/antpool.php');

// check if custom config file exist
if (file_exists(__DIR__.'/config.php')) {
	require_once(__DIR__.'/config.php');
} else {
	exit('please create your own config.php based on config.sample.php');
}

// init antpool class
$ant_config = new ant_config();
$ant 	= new antpool($ant_config->username, $ant_config->api_key, $ant_config->api_secret);

// check if custom.php exist and execute
if (file_exists(__DIR__.'/custom.php')) {
	require_once(__DIR__.'/custom.php');
} else {
	require_once(__DIR__.'/custom.sample.php');
}

unset($ant);