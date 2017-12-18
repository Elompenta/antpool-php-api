<?php
/*!
 * @author		Sebastian Lutz
 * @Contributor Ryan Oliver
 * @copyright	Baebeca Solutions - Lutz
 * @email		lutz@baebeca.de
 * @pgp			0x5AD0240C
 * @link		https://www.baebeca.de
 * @link-github	https://github.com/Elompenta/antpool-php-api
 * @customer	-
 * @project		antpool-php-api
 * @license		GNU GENERAL PUBLIC LICENSE Version 2
 **/

// rename this file to custom.php and
// do you own stuff in this file
// we will never overrite this file

/**
 * API Request Caching
 *
 *  Use server-side caching to store API request's as JSON at a set 
 *  interval, rather than each pageload.
 * 
 * @arg Argument description and usage info
 */

//Crypto prices, change variable according to your needs
$coin='litecoin'; // bitcoin,litecoin,ethereum,zcash
$price='USD'; //BTC,USD,EUR
$link='https://api.coinmarketcap.com/v1/ticker/'.$coin.'?convert='.$price;
$data=file_get_contents($link);
$json=json_decode($data);
$usd=$json[0]->price_usd;

//Pool Stats
$poolstats = $ant->get('poolStats');

$poolHash = $poolstats->poolHashrate;

//print_r('Pool Hashrate ');
//print_r(round($poolHash/1000000,2));
//print_r(' PH/s');
//print_r('<br>');

//Payment information
$account = $ant->get('account');

$daily = $account->earn24Hours;
$totalEarnings = $account->earnTotal;
$paid = $account->paidOut;
$balance = $account->balance;
$balanceUSD = $usd*$balance;

//Hashrate info
$hashrate = $ant->get('hashrate');

$last10m = $hashrate->last10m;
$last30m = $hashrate->last30m;
$last1h = $hashrate->last1h;
$last1d = $hashrate->last1d;

//Worker info
//$workers = $ant->get('workers');

//Payment information
$payments = $ant->get('paymentHistory');

?>
<!-- API Examples -->
<html lang="en">
  <head>
    <title>Our Mining Stats</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
  </ul>
   </div>
  </nav>
  
  <table class="table table-dark">
  <thead>
  	<tr>
    <th colspan="4"><center>Account info</center></th>
    </tr>
    <tr>
      <th scope="col">Balance</th>
      <th scope="col">24 hour earnings</th>
      <th scope="col">Est. Weekly Earnings</th>
     <th scope="col">Est. Monthly Earnings</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php print "$balance LTC"; ?></td>
      <td><?php print "$daily LTC"; ?></td>
      <td><?php print $daily*7; print "LTC"; ?></td>
      <td><?php print $daily*30; print "LTC"; ?></td>
    </tr>
    <tr>
      <td><?php print "$";print round($balanceUSD,2); ?></td>
      <td><?php print "$"; print round($daily*$usd,2); ?></td>
      <td><?php print "$"; print round(($daily*7)*$usd,2); ?></td>
      <td><?php print "$"; print round(($daily*30)*$usd,2); ?></td>
    </tr>
  </tbody>
</table>
  
  <br><hr><br>
  
    <table class="table table-dark">
  <thead>
  	<tr>
    <th colspan="4"><center>Hashrate</center></th>
    </tr>
    <tr>
      <th scope="col">Hashrate 10 mins</th>
      <th scope="col">Hashrate 30 mins</th>
      <th scope="col">Hashrate 1 hour</th>
     <th scope="col">Hashrate 1 day</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php print round(($last10m/1000),3); print " GH/s"; ?></td>
      <td><?php print round(($last30m/1000),3); print " GH/s"; ?></td>
      <td><?php print round(($last1h/1000),3); print " GH/s"; ?></td>
      <td><?php print round(($last1d/1000),3); print " GH/s"; ?></td>
    </tr>
  </tbody>
</table>
  
    <br><hr><br>
  
    <table class="table table-dark">
  <thead>
  	<tr>
    <th colspan="4"><center>Last 10 Payments</center></th>
    </tr>
    <tr>
      <th scope="col">Time & Date</th>
      <th scope="col" colspan="2">Transaction ID</th>
     <th scope="col">amount</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php print $payments->rows[0]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[0]->txId; ?></td>
      <td><?php print $payments->rows[0]->amount; print " LTC"; ?></td>
    </tr>
        <tr>
      <td><?php print $payments->rows[1]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[1]->txId; ?></td>
      <td><?php print $payments->rows[1]->amount; print " LTC"; ?></td>
    </tr>
      <tr>
      <td><?php print $payments->rows[2]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[2]->txId; ?></td>
      <td><?php print $payments->rows[2]->amount; print " LTC"; ?></td>
    </tr>
      <tr>
      <td><?php print $payments->rows[3]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[3]->txId; ?></td>
      <td><?php print $payments->rows[3]->amount; print " LTC"; ?></td>
    </tr>
      <tr>
      <td><?php print $payments->rows[4]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[4]->txId; ?></td>
      <td><?php print $payments->rows[4]->amount; print " LTC"; ?></td>
    </tr>
      <tr>
      <td><?php print $payments->rows[5]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[5]->txId; ?></td>
      <td><?php print $payments->rows[5]->amount; print " LTC"; ?></td>
    </tr>
      <tr>
      <td><?php print $payments->rows[6]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[6]->txId; ?></td>
      <td><?php print $payments->rows[6]->amount; print " LTC"; ?></td>
    </tr>
      <tr>
      <td><?php print $payments->rows[7]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[7]->txId; ?></td>
      <td><?php print $payments->rows[7]->amount; print " LTC"; ?></td>
    </tr>
      <tr>
      <td><?php print $payments->rows[8]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[8]->txId; ?></td>
      <td><?php print $payments->rows[8]->amount; print " LTC"; ?></td>
    </tr>
      <tr>
      <td><?php print $payments->rows[9]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[9]->txId; ?></td>
      <td><?php print $payments->rows[9]->amount; print " LTC"; ?></td>
    </tr>
  </tbody>
</table>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>
