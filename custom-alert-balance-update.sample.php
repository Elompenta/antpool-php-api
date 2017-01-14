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

// Example: alert if balance changed
$account = $ant->get('account');

if (!is_dir(__DIR__.'/tmp')) {
	if (!mkdir(__DIR__.'/tmp')) exit('Error: cant create tmp dir: '.__DIR__.'/tmp');
}

if (file_exists(__DIR__.'/tmp/balance.txt')) {
	$old_balance = file_get_contents(__DIR__.'/tmp/balance.txt');

	if ($account->balance != $old_balance) {
		if (!file_put_contents(__DIR__.'/tmp/balance.txt', $account->balance)) exit('Error: cant update file: '.__DIR__.'/tmp/balance.txt');

		// todo: send balance diff instead new balance

		// Send Email
		mail($ant_config->email, 'Balance updated: '.$account->balance, '');

		// Send SMS
		// we use gammu cli GSM binary in this example
		// if you need a cheap PHP-SMS-API to send SMS write us a email
		exec("echo \"Balance updated: ".$account->balance."\" | sudo gammu-smsd-inject TEXT \"".$ant_config->mobile."\"");
	}
} else {
	if (!file_put_contents(__DIR__.'/tmp/balance.txt', $account->balance)) exit('Error: cant create file: '.__DIR__.'/tmp/balance.txt');
	// Send Email
	mail($ant_config->email, 'Balance stored: '.$account->balance, '');

	// Send SMS
	// we use gammu cli GSM binary in this example
	// if you need a cheap PHP-SMS-API to send SMS write us a email
	exec("echo \"Balance stored: ".$account->balance."\" | sudo gammu-smsd-inject TEXT \"".$config->mobile."\"");
}