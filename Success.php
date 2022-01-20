<?php
if(!isset($_SESSION)) { 
    session_start(); 
}
$api_response = json_decode($_GET['response'], true);
$trxID = $api_response['trxID'];
$paymentID = $api_response['paymentID'];
$merchantInvoiceNumber = $api_response['merchantInvoiceNumber'];
$amount = $api_response['amount'];
$url = $_SERVER['HTTP_REFERER'] . '?trxID=' . $trxID;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Success - bKash Payment Gateway</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="b-center">
<div>
    <div class="card t-center">
        <img class="img-fluid" src="assets/success.gif" alt="">
        <h2 class="text-heading">Success</h2>
        <div class="card-body mb-3">
            <p class="text-primary"><span class="fw-bold">Invoice:</span><?php echo $merchantInvoiceNumber ?></p>
            <p class="text-primary"><span class="fw-bold">Transaction Id:</span><?php echo $trxID ?></p>
            <p class="text-primary"><span class="fw-bold">Payment Id:</span><?php echo $paymentID ?></p>
            <p class="text-primary"><span class="fw-bold">Amount:</span><?php echo $amount ?></p>
        </div>
        <button class="btn btn-primary" onclick="gotoApp();">Continue</button>
    </div>
</div>

<script>
    function gotoApp() {
        window.onPaymentSuccess.postMessage(`<?php echo $url ?>`);
    }
</script>
</body>
</html>