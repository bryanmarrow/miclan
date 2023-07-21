<?php

    require '../vendor/autoload.php';
    require('../api/Config/DBconfig.php');


    $uri = $rootUrlPaypal.'/v1/oauth2/token';
    
    
    $orderid=$_POST['orderID'];
    $client = new GuzzleHttp\Client([
        'base_uri' => $uri,
    ]);


    $clientid=$clientidPaypal['value'];
    $secret=$secretTokenPaypal;
    

    $response=$client->request('POST', $uri, [
        'headers' => [
            'Accept'     => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded'
        ],
        'body' => 'grant_type=client_credentials',
        'auth' => [$clientid, $secret, 'basic']
    ]);

    $data = json_decode($response->getBody(), true);
    $access_token=$data['access_token'];


    // var_dump($access_token);


    $getOrder=$client->request('GET', '/v2/checkout/orders/'.$orderid,[
        'headers' => [
            'Accept'     => 'application/json',
            'Authorization' => "Bearer $access_token"
        ],
    ]);

    
    header('Content-Type: application/json');
    echo $getOrder->getBody();
    

