# Repo is no longer maintained
This software is no longer maintained. You are welcome to have a look at the current Forks. There you will find nice colleagues who develop this software further.
https://github.com/Elompenta/antpool-php-api/network/members


# antpool-php-api
Free Antpool PHP-API-Client ready to use. (https://www.antpool.com/)

# Initial Setup

Get files from Github repository

    $ git clone https://github.com/Elompenta/antpool-php-api.git
    $ cd antpool-php-api

Create you own config file and add antpool API access credentials

    $ cp config.sample.php config.php
    $ vim config.php

# Update
    $ cd antpool-php-api
    $ git pull

# Setup config.php
Create config.php
	
	cp config.sample.php config.php

Enter your API Access Details

	// antpool user settings
   	public $username 	= '';
   	public $api_key 	= '';
   	public $api_secret 	= '';
	
_Username must be your Username, NOT your Account Email_   	   	

# How to use
Execute the file "antpool.php".

    php antpool.php

antpool.php will load configuration and needed libaries and execute a file wich is named "custom.php" if it is available.  
Feel free to create your own Codes in your "custom.php".

We does not overwrite the file "custom.php" in the future releases.

We deliver some example files, like default API lookups or email alerting if any worker does not has a hashrate and seems to be offline.

## Configure
You can set the following configurations in your "custom.php"  

    $ant->config('print_error_if_api_down', boolean); // default true

## Delivered example scripts:
- custom.example.php
    - Will show the output of all API methods
- custom-alert-worker-down.sample.php
    - Alert via Email / SMS if a worker has zero hashrate ans seems to be down
- custom-alert-balance-update.sample.php
    - Alert via Email / SMS if your balance changed

# Create custom checks
You are able to use all official antpool statements. Just call the API-Client with the statement that you want.  
Official API Documentation: https://www.antpool.com/user/apiGuild.htm

Variable $currency can be: "BTC, LTC, ETH, ZEC" (default ist BTC)

Examples:
- Pool Stats
    - $ant->get('poolStats', $currency = 'BTC');
- Account balance
    - $ant->get('account', $currency = 'BTC');
- Hashrate
    - $ant->get('hashrate'); 
- Workers Hashrate
    - $ant->get('workers', $currency = 'BTC');
- Paymanet History
    - $ant->get('paymentHistory', $currency = 'BTC');

$ant->get() return a JSON decoded PHP array.  

# Crontab
Feel free to setup a sheduled check via Crontab

    vim /etc/crontab
    */10 *  * * *   root    php /<dir>/antpool-php-api/antpool.php

# Pricacy
- We will NEVER store your API-Secret or send it away within any communication
- All API request are encrypted by TLS

# Current Limitations
none

# Contributors 
Ryan Oliver (https://github.com/xslugx)

# Forks
- Laravel PHP Facade/Antpool for the Antpool API (https://github.com/aburakovskiy/laravel-antpool-api)
