# antpool-php-api
Free Antpool PHP-API-Client ready to use. (https://www.antpool.com/)

# Initial Setup

Get files from Github repository

    $ git clone https://github.com/Elompenta/antpool-php-api.git
    $ cd antpool-php-api

Create you own config file and add antpool API access credentials

    $ cp config.sample.php config.php
    $ vim config.php

Register your Public-API-Key on the current Proxy API. (see limitation - we work on a solution to solve this issue)\
http://maaapi.mooo.com/info/

# Update
    $ cd antpool-php-api
    $ git pull

# How to use
Execute the file "antpool.php".

    php antpool.php

antpool.php will load all libaries and execute a file wich is named "custom.php" if it is available.\
Feel free to create your own Codes in a filed called "custom.php". We does not overwrite them in the future.

We deliver some example files, like default API lookups or email alerting if any worker does not has a hashrate and seems to be offline.\
Delivered Example Files:
- custom.example.php
    - Will show the output of all API methods
- custom-alert-worker-down.sample.php
    - Alert via Email / SMS if one worker has zero hashrate ans seems to be down

# Create custom checks
You are able to use all official antpool statements. Just call the API-Client with the statement that you want.\
Official API Documentation: https://www.antpool.com/user/apiGuild.htm\

Examples:
- Pool Stats
    - $ant->get('poolStats');
- Account balance
    - $ant->get('account'));
- Hashrate
    - $ant->get('hashrate')); 
- Workers Hashrate
    - $ant->get('workers'));
- Paymanet History
    - $ant->get('paymentHistory'));

$ant->get() return with a JSON decoded PHP array.  

# Crontab
Feel free to setup a sheduled check via Crontab
    vim /etc/crontab
    */10 *  * * *   root    php /<your-dir>/antpool-php-api/antpool.php

# Pricacy
- We will NEVER store your API-Secret or send it away within any API call
- All API request are encrypted by TLS

# Current Limitations (we work on it)
At the moment antpool has some trouble with DDOS prevention and kill API requests.
We proxy every API request over a other API at this moment.
- API requests are limited to 20 Request per 10 Minute slots at the moment
- Because Proxy-API you cannot use IP-Filter at the moment
