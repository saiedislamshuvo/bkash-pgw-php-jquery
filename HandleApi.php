<?php

include('BkashApi.php');

$bkash_api = new BkashApi();
$action = $_GET['action'];
echo $bkash_api->$action();
