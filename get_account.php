<?php
require_once 'libs/UFJRequest.php';

//UFJ sample account id
// 001001110001
// 002001110002
// 325001110003
// 135011110005
// 118011110008
// 329011110009
// 002021110013
// 002022220003
// 325022220004
// 909022220013
// 002022220014
// 002023330003
// 325023330004
// 480023330005
// 777023330008
// 118023330009
// 427383330012
// 909383330013
// 002383330014
// 002283330016

if (!$argv[1]) exit('Not found account_id');

$ufj_request = new UFJRequest();
$ufj_request->loadClientSecret('client_secret');
$ufj_request->setAccountId($argv[1]);
$account = $ufj_request->getAccount();

echo $account;
echo PHP_EOL;