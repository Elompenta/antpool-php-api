<?php
/*!
 * @author		Sebastian Lutz
 * @copyright 	Baebeca Solutions - Lutz
 * @email		lutz@baebeca.de
 * @pgp			0x5AD0240C
 * @link		https://www.baebeca.de
 * @link-github	https://github.com/Elompenta/antpool-php-api
 * @customer 	-
 * @project		antpool-php-api
 * @license		GNU GENERAL PUBLIC LICENSE Version 2
 **/

// rename this file to custom.php and
// do you own stuff in this file
// we will never overrite this file

// Example: alert down worker
$workers = $ant->get('workers');
foreach($workers->rows as $worker) {
	if ($worker->last10m == 0) {
		mail('email@domain.tld', 'antpool worker down: '.$worker->worker, '');
	}
}