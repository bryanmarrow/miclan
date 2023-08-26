<?php

    require('../api/Config/DBconfig.php');
    // session_start();


    date_default_timezone_set('America/Mexico_City');
    $fechapago = date("Y-m-d H:i:s");

    $infoCarrito=$_POST['carrito'];
    $cupon=isset($_SESSION['cupon']) ? $_SESSION['cupon']['cupon'] : '';
    $metodo_pago=isset($_SESSION['metodopago']) ? $_SESSION['metodopago'] : 0;
    
    $infoOrdenPases=calcularPrecio($infoCarrito, $metodo_pago);
    
    $subtotalcarrito= number_format(($infoOrdenPases['subTotalCarrito']), 2, '.', '');
    $taxcarrito= number_format(($infoOrdenPases['tax']), 2, '.', '');
    $totalCarrito= number_format(($infoOrdenPases['total_amount']), 2, '.', '');

    $data = [
        'invoiceid' => $_POST['invoiceid'],
        'idPagoStripe' => $_POST['idPagoStripe'],
        'payment_method_types' => $_POST['payment_method_types'],
        'status' => $_POST['status'],
        'cupon' => $cupon,
        'fechapago' => $fechapago,
        'currency' => $_POST['currency'],
        'subtotal_carrito' => $subtotalcarrito,
        'tax_carrito' => $taxcarrito,
        'total_carrito' => $totalCarrito,
    ];

    try{

        $basededatos->connect()->prepare("INSERT INTO `tbl_pagos`(`invoiceid`, `idPagoStripe`, `payment_method_types`, `status`, `cupon`, `fechapago`, `currency`,`subtotal_order`, `tax_order`, `total_order`) 
        VALUES ( :invoiceid, :idPagoStripe, :payment_method_types, :status, :cupon, :fechapago, :currency, :subtotal_carrito, :tax_carrito, :total_carrito)")->execute($data);

        $data = array(
            'respuesta' => 'success',
        );

    }catch( PDOException $e){
        // echo $e;

        $data = array(
            'respuesta' => 'error',
            'mensaje' => $e->getMessage()
        );
    }
    header('Content-Type: application/json');
    echo json_encode($data);


?>