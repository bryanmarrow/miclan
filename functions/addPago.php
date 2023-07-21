<?php 

    require('../api/Config/DBconfig.php');
    

    $fechapago = date_create($_POST['fechaPago']);


    $data = [
        'invoiceid' => $_POST['invoiceid'],
        'email' => $_POST['emailPago'],
        'fname' => $_POST['fnamePago'],
        'lname' => $_POST['lnamePago'],
        'fechapago' => date_format($fechapago, 'Y-m-d H:i:s'),
        'couponcode' => $_POST['couponcode'],
        'country' => $_POST['country'],
        'city' => $_POST['city'],
        'idTransactionPago' => $_POST['idTransactionPago'],
        'statusPago' => $_POST['statusPago'],
        'ticketPassword' => $_POST['codigoconf'],
        'comisionPago' => $_POST['comisionPago'],
        'subTotalPago' => $_POST['subTotalPago'],
        'totalPago' => $_POST['totalPago'],
        'idPase' => $_POST['idpase']
    ];


    // var_dump($data);
    try{

        $basededatos->connect()->prepare("INSERT INTO `tbl_ticketpays`
        (`invoiceId`, `emailPago`, `fnamePago`, `lnamePago`, `fechapago`, `couponcode`, `pais`, `ciudad`,`transactionId`, `passwordTicket`, `status`, `comisionPago`, `subtotalPago`, `totalPago`, `idPase`)
        VALUES 
        ( :invoiceid, :email, :fname, :lname, :fechapago, :couponcode, :country, :city, :idTransactionPago, :ticketPassword, :statusPago, :comisionPago, :subTotalPago, :totalPago, :idPase)")->execute($data);

        $data = [
            'mensaje' => 'success'
        ];
        

    }catch( PDOException $e){
        // echo $e;
        $data = [
            'mensaje' => 'error',
            'error' => $e
        ];
    }
    
    header('Content-Type: application/json');
    echo json_encode($data);   
