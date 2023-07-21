<?php 

    require('../api/Config/DBconfig.php');

    date_default_timezone_set('America/Mexico_City');
    $dateregistro=date("Y-m-d H:i:s");
    $paymenth_method=3; //Paypal
    $status_pago=3; // Liquidado
    

    $data = [
        'invoiceid' => $_POST['invoiceid'],
        'email' => $_POST['email'],
        'fname' => $_POST['fname'],
        'lname' => $_POST['lname'],
        'reciboid' => $_POST['reciboid'],
        'fechapago' => $dateregistro,
        'couponcode' => $_POST['couponcode'],
        'country' => $_POST['country'],
        'formapago' => $paymenth_method,
        'status_pago' => $status_pago        
    ];

    $dataLog = [
        'tokenTicket' => $_POST['invoiceid'],
        'status_ticket' => $status_pago,
        'fechaLog' => $dateregistro
    ];

    try{
        
        $basededatos->connect()->prepare("INSERT INTO `tbl_pays`(`invoiceid`, `email`, 
        `fname`, `lname`, `reciboid`, `fechapago`, `couponcode`, `country`, `forma_pago`, `status`) 
        VALUES ( :invoiceid, :email, :fname, :lname, :reciboid, :fechapago, :couponcode, :country, :formapago, :status_pago)")->execute($data);

        // $basededatos->connect()->prepare("UPDATE `tbl_compras` 
        // SET `status`='".$status_pago."' WHERE invoiceid='".$_POST['invoiceid']."'")->execute();

        $basededatos->connect()->prepare("INSERT INTO `tbl_log_status_tickets`(`token_ticket`, `status_ticket`, `fechalog`) 
        VALUES (:tokenTicket, :status_ticket, :fechaLog)")->execute($dataLog);

        $respuesta = array(
            'respuesta' => 'success'
        );
        

    }catch( PDOException $e){
        
        $respuesta = array(
            'respuesta' => 'error',
            'mensaje' => $e->getMessage()
        );
    }
    
    header('Content-Type: application/json');
    echo json_encode($respuesta);
