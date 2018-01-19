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
// we will never overrite this config.php


$fiat_name = 'USD'; // USD,EUR
$fiat_symbol = "$"; // set your local currency symbol IE: $, €

$coin = 'BTC'; // Set your Crypto abbreviation here IE: BTC, LTC, ETH
$coin_longname = 'bitcoin'; // bitcoin,litecoin,ethereum,zcash

/**
 * API Request Caching
 *
 *  Use server-side caching to store API request's as JSON at a set
 *  interval, rather than each pageload.
 *
 * @arg Argument description and usage info
 */


// get crypto prices from coinmarketcap.com
$link='https://api.coinmarketcap.com/v1/ticker/'.$coin_longname.'?convert='.$fiat_name;
$data=file_get_contents($link);
$json=json_decode($data);
// todo: switch to better solution to use custom user currency from aboce config
$fiat_currency=$json[0]->price_usd; //change according to your needs IE price_eur

//Pool Stats
$poolstats = $ant->get('poolStats', $coin);

$poolHash = $poolstats->poolHashrate;

//print_r('Pool Hashrate ');
//print_r(round($poolHash/1000000,2));
//print_r(' PH/s');
//print_r('<br>');


//Payment information
$account = $ant->get('account', $coin);

$daily = $account->earn24Hours;
$totalEarnings = $account->earnTotal;
$paid = $account->paidOut;
$balance = $account->balance;
$balanceFiat = $fiat_currency*$balance;


//Hashrate info
$hashrate = $ant->get('hashrate', $coin);

$last10m = $hashrate->last10m;
$last30m = $hashrate->last30m;
$last1h = $hashrate->last1h;
$last1d = $hashrate->last1d;


//Worker info
//$workers = $ant->get('workers');

//Payment information
$payments = $ant->get('paymentHistory', $coin);

?>
<!-- API Examples -->
<html lang="en">
  <head>
    <title>Mining Stats</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
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
		<li class="nav-item">
			<a class="nav-link" target="_blank" href="https://github.com/Elompenta/antpool-php-api">antpool-php-api documentation</a>
		</li>
  </ul>
   </div>
  </nav>
  <div class="table-responsive">

  <?php // todo: switch to divs instead html tables :-} ?>
  <table class="table table-dark table-striped">
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
      <td><?php print $balance . " " . $coin; ?></td>
      <td><?php print $daily . " " . $coin; ?></td>
      <td><?php print $daily*7 . " " .  $coin; ?></td>
      <td><?php print $daily*30  . " " .  $coin; ?></td>
    </tr>
    <tr>
      <td><?php print $fiat_symbol; print round($balanceFiat,2); ?></td>
      <td><?php print $fiat_symbol; print round($daily*$fiat_currency,2); ?></td>
      <td><?php print $fiat_symbol; print round(($daily*7)*$fiat_currency,2); ?></td>
      <td><?php print $fiat_symbol; print round(($daily*30)*$fiat_currency,2); ?></td>
    </tr>
  </tbody>
</table>
  </div>
  <br><hr><br>
  <div class="table-responsive"> 
    <table class="table table-dark table-striped table-condensed">
  <thead>
  	<tr>
    <th colspan="4"><center><?php print $coin." "; ?>Hashrate</center></th>
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
  </div>
    <br><hr><br>
  <div class="table-responsive"> 
    <table class="table table-dark table-striped">
  <thead>
  	<tr>
    <th colspan="4"><center>Last 10 <?php print " " .$coin." "; ?> Payments</center></th>
    </tr>
    <tr>
      <th scope="col">Time &amp; Date</th>
      <th scope="col" colspan="2">Transaction ID</th>
     <th scope="col">amount</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php print $payments->rows[0]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[0]->txId; ?></td>
      <td><?php print $payments->rows[0]->amount . " " . $coin; ?></td>
    </tr>
        <tr>
      <td><?php print $payments->rows[1]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[1]->txId; ?></td>
      <td><?php print $payments->rows[1]->amount . " " . $coin; ?></td>
    </tr>
      <tr>
      <td><?php print $payments->rows[2]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[2]->txId; ?></td>
      <td><?php print $payments->rows[2]->amount . " " .  $coin; ?></td>
    </tr>
      <tr>
      <td><?php print $payments->rows[3]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[3]->txId; ?></td>
      <td><?php print $payments->rows[3]->amount . " " . $coin; ?></td>
    </tr>
      <tr>
      <td><?php print $payments->rows[4]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[4]->txId; ?></td>
      <td><?php print $payments->rows[4]->amount . " " . $coin; ?></td>
    </tr>
      <tr>
      <td><?php print $payments->rows[5]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[5]->txId; ?></td>
      <td><?php print $payments->rows[5]->amount . " " . $coin; ?></td>
    </tr>
      <tr>
      <td><?php print $payments->rows[6]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[6]->txId; ?></td>
      <td><?php print $payments->rows[6]->amount . " " . $coin; ?></td>
    </tr>
      <tr>
      <td><?php print $payments->rows[7]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[7]->txId; ?></td>
      <td><?php print $payments->rows[7]->amount . " " . $coin; ?></td>
    </tr>
      <tr>
      <td><?php print $payments->rows[8]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[8]->txId; ?></td>
      <td><?php print $payments->rows[8]->amount . " " . $coin; ?></td>
    </tr>
      <tr>
      <td><?php print $payments->rows[9]->timestamp; ?></td>
      <td colspan="2"><?php print $payments->rows[9]->txId; ?></td>
      <td><?php print $payments->rows[9]->amount . " " . $coin; ?></td>
    </tr>
  </tbody>
</table>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <link href="./js/jquery.min.js">

	<?php // todo: for which feature do you need popper.js? ?>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script> -->

    <link href="js/bootstrap.min.js">
  </body>
</html>
