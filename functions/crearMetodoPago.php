<?php

    // session_start();
    require '../vendor/autoload.php';
    require('../api/Config/DBconfig.php');

    $stripe = new \Stripe\StripeClient('sk_test_51LVia2B4srLF6gvb7ndYe400JESBqXBxwug741KSDB2Vtz1Nl8kpEUuicJGxMRTmEA0uECa1V8F0NZWHtJG1K4OU00lgierdEC');

    $infoOrdenPases=$_POST['infoOrdenPases'];

    $fechaExpiracion=DateTime::createFromFormat('m/y', $infoOrdenPases['cc-datexmp']);
    $year=$fechaExpiracion->format('y');
    $month=$fechaExpiracion->format('m');
    $user_id=$_SESSION['idUserSession'];
    date_default_timezone_set('America/Mexico_City');
    $fechapago = date("Y-m-d H:i:s");
    $saveCard=$infoOrdenPases['saveCard'];


    try{

        $crearMetododePago = $stripe->paymentMethods->create([
            'type' => 'card',
            'card' => [
                'number' => $infoOrdenPases['cc-number'],
                'exp_month' => $month,
                'exp_year' => $year,
                'cvc' => $infoOrdenPases['cc-cvc'],
            ],
        ]);

        $idMetodoPago=$crearMetododePago->id;

        if($saveCard==true){
                
            $dataSaveCard = array(
                'user_id' => $user_id,
                'idPaymentMethod' => $idMetodoPago,
                'fechaIngresoPaymentMethod' => $fechapago
            );

            $querySaveCard=$basededatos->connect()->prepare('INSERT INTO `tbl_metodospagoclientes`(`user_id`, `idPaymentMethod`, `fechaIngreso`) 
            VALUES (:user_id, :idPaymentMethod, :fechaIngresoPaymentMethod)');

            $querySaveCard->execute($dataSaveCard);

        }

        
        $infoPaymentIntent = array(
            'idMetodoPago' =>  $idMetodoPago,
        );


    }catch(\Stripe\Exception\StripeClient $e){
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }

    header('Content-Type: application/json');
    echo json_encode($infoPaymentIntent);