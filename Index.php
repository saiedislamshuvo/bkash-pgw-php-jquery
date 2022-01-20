<?php
if(!isset($_SESSION)) { 
    session_start(); 
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>bKash Payment Gateway</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/sweetalert2@11.js"></script>
    <script src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js"></script>
</head>
<body>
    <div class="t-center">
        <div id="full_page_loading" class="hidden"></div>
        <button id="bKash_button" class="btn btn-primary mt-primary" >Pay With bKash</button>
    </div>
<?php
    include('BkashScript.php')
?>
</body>
</html>