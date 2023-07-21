<?php

/*
	* Config for PayPal specific values
*/

// Urls
if(isset($_SERVER['SERVER_NAME'])) {
    $url = @($_SERVER["HTTPS"] != 'on') ? 'http://' . $_SERVER["SERVER_NAME"] : 'https://' . $_SERVER["SERVER_NAME"];
    $url .= ($_SERVER["SERVER_PORT"] !== 80) ? ":" . $_SERVER["SERVER_PORT"] : "";
    $url .= $_SERVER["REQUEST_URI"];
}
else {
    $url = "";
}

define("URL", array(

    "current" => $url,

    "services" => array(
        "orderCreate" => 'api/createOrder.php',
        "orderGet" => 'api/getOrderDetails.php',
		"orderPatch" => 'api/patchOrder.php',
		"orderCapture" => 'api/captureOrder.php'
    ),

	"redirectUrls" => array(
        "returnUrl" => 'pages/success.php',
		"cancelUrl" => 'pages/cancel.php',
    )
));

// PayPal Environment 
define("PAYPAL_ENVIRONMENT", "sandbox");

// PayPal REST API endpoints
define("PAYPAL_ENDPOINTS", array(
	"sandbox" => "https://api.sandbox.paypal.com",
	"production" => "https://api.paypal.com"
));

// PayPal REST App credentials
define("PAYPAL_CREDENTIALS", array(
	"sandbox" => [
		"client_id" => "Af3OwvZ48X4F18LqCbWWDFYeAyPrjdtQhgRi4IZMAgGz3i4nf-b5VB1BGwpDOMSAlzBRa8xDg11IlSt4",
		"client_secret" => "ECe7qpJD0eibBCLO56LD14HgejdJ3jwuy6F7u0MxLA6QsX2sTdXeg9JjiZHDdeABbesdZC41jvSL3W0a"
	],
	"production" => [
		"client_id" => "",
		"client_secret" => ""
	]
));

// PayPal REST API version
define("PAYPAL_REST_VERSION", "v2");

// ButtonSource Tracker Code
define("SBN_CODE", "PP-DemoPortal-EC-Psdk-ORDv2-php");