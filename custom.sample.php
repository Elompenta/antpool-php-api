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
 <div class="container"> 
	<div class="row justify-content-md-center border border-dark rounded">
    <div class="col-12 col-lg-12"><center>Account info</center></div>
</div>
<div class="row justify-content-md-center border border-dark rounded">
      <div class="col">Balance</div>
      <div class="col">24 hour earnings</div>
      <div class="col">Est. Weekly Earnings</div>
      <div class="col">Est. Monthly Earnings</div>
</div>
<div class="row justify-content-md-center border border-dark rounded">
      <div class="col"><?php print $balance . " " . $cryptoAbr; ?></div>
      <div class="col"><?php print $daily . " " . $cryptoAbr; ?></div>
      <div class="col"><?php print $daily*7 . " " .  $cryptoAbr; ?></div>
      <div class="col"><?php print $daily*30  . " " .  $cryptoAbr; ?></div>
</div>   
<div class="row justify-content-md-center border border-dark rounded">
      <div class="col"><?php print $fiatSymbol; print round($balanceFiat,2); ?></div>
      <div class="col"><?php print $fiatSymbol; print round($daily*$fiatCurrency,2); ?></div>
      <div class="col"><?php print $fiatSymbol; print round(($daily*7)*$fiatCurrency,2); ?></div>
      <div class="col"><?php print $fiatSymbol; print round(($daily*30)*$fiatCurrency,2); ?></div>
</div>
</div>
<br><hr><br>
<div class="container"> 
	<div class="row justify-content-md-center border border-dark rounded">
    <div class="col-12 col-lg-12"><center><?php print $cryptoAbr." "; ?>Hashrate</center></div>
</div>
<div class="row align-items-start justify-content-md-center border border-dark rounded">
      <div class="col">Hashrate 10 mins</div>
      <div class="col">Hashrate 30 mins</div>
	  <div class="col">Hashrate 1 hour</div>
      <div class="col">Hashrate 1 day</div>
</div>
<div class="row justify-content-md-center border border-dark rounded">
      <div class="col"><?php print round(($last10m/1000),3); print " GH/s"; ?></div>
      <div class="col"><?php print round(($last30m/1000),3); print " GH/s"; ?></div>
      <div class="col"><?php print round(($last1h/1000),3); print " GH/s"; ?></div>
      <div class="col"><?php print round(($last1d/1000),3); print " GH/s"; ?></div>
</div>
</div>
    <br><hr><br>
<div class="container"> 
  	<div class="row justify-content-md-center border border-dark rounded">
    <div class="col-md-auto"><center>Last 10 <?php print " " .$cryptoAbr." "; ?> Payments</center></div>
</div>
<div class="row border border-dark rounded">
      <div class="col">Time &amp; Date</div>
      <div class="col" >Transaction ID</div>
     <div class="col">amount</div>
</div>
<div class="row justify-content-md-center border border-dark rounded">
      <div class="col-md-auto"><?php print $payments->rows[0]->timestamp; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[0]->txId; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[0]->amount . " " . $cryptoAbr; ?></div>
</div>
<div class="row justify-content-md-center border border-dark rounded">
      <div class="col-md-auto"><?php print $payments->rows[1]->timestamp; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[1]->txId; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[1]->amount . " " . $cryptoAbr; ?></div>
</div>
<div class="row justify-content-md-center border border-dark rounded">
      <div class="col-md-auto"><?php print $payments->rows[2]->timestamp; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[2]->txId; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[2]->amount . " " .  $cryptoAbr; ?></div>
</div>
<div class="row justify-content-md-center border border-dark rounded">
      <div class="col-md-auto"><?php print $payments->rows[3]->timestamp; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[3]->txId; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[3]->amount . " " . $cryptoAbr; ?></div>
</div>
<div class="row justify-content-md-center border border-dark rounded">
      <div class="col-md-auto"><?php print $payments->rows[4]->timestamp; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[4]->txId; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[4]->amount . " " . $cryptoAbr; ?></div>
</div>
<div class="row justify-content-md-center border border-dark rounded">
      <div class="col-md-auto"><?php print $payments->rows[5]->timestamp; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[5]->txId; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[5]->amount . " " . $cryptoAbr; ?></div>
</div>
<div class="row justify-content-md-center border border-dark rounded">
      <div class="col-md-auto"><?php print $payments->rows[6]->timestamp; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[6]->txId; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[6]->amount . " " . $cryptoAbr; ?></div>
</div>
<div class="row justify-content-md-center border border-dark rounded">
      <div class="col-md-auto"><?php print $payments->rows[7]->timestamp; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[7]->txId; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[7]->amount . " " . $cryptoAbr; ?></div>
</div>
<div class="row justify-content-md-center border border-dark rounded">
      <div class="col-md-auto"><?php print $payments->rows[8]->timestamp; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[8]->txId; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[8]->amount . " " . $cryptoAbr; ?></div>
</div>
<div class="row justify-content-md-center border border-dark rounded">
      <div class="col-md-auto"><?php print $payments->rows[9]->timestamp; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[9]->txId; ?></div>
      <div class="col-md-auto"><?php print $payments->rows[9]->amount . " " . $cryptoAbr; ?></div>
</div>
</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Bootstrap JS -->
    <link href="./js/jquery.min.js">
    <link href="js/bootstrap.min.js">
  </body>
</html>
