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

// Example: alert down worker
$workers = $ant->get('workers');
foreach($workers->rows as $worker) {
	if ($worker->last10m == 0) {

		// Send Email
		mail($ant_config->email, 'antpool worker down: '.$worker->worker, '');

		// Send SMS
		// we use gammu cli GSM binary in this example
		// if you need a cheap PHP-SMS-API to send SMS write us a email
		exec("echo \"antpool worker down: ".$worker->worker."\" | sudo gammu-smsd-inject TEXT \"".$ant_config->mobile."\"");

	}
}