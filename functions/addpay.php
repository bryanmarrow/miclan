<?php 
    // // var_dump($_POST);
    require('../api/Config/DBconfig.php');
    

    date_default_timezone_set('America/Mexico_City');
    $dateregistro=date("Y-m-d H:i:s");
    $paymenth_method=3; //Paypal
    

    $couponcode=isset($_POST['couponcode']) ? $_POST['couponcode'] : '';
    $tipoForm=isset($_POST['tipoform']) ? $_POST['tipoform'] : '';

    switch($tipoForm){
        case 'liquidar':
            $status_pago=3; //Liquidado
            $invoiceid=isset($_POST['codigoconf']) ? $_POST['codigoconf'] : '';
            $data = [
                'invoiceid' => $invoiceid,
                'email' => $_POST['email'],
                'fname' => $_POST['fname'],
                'lname' => $_POST['lname'],
                'reciboid' => $_POST['reciboid'],
                'fechapago' => $dateregistro,
                'couponcode' => $couponcode,
                'country' => $_POST['country'],
                'formapago' => $paymenth_method,
                'status_pago' => $status_pago
            ];
        
            $dataLog = [
                'tokenTicket' => $invoiceid,
                'status_ticket' => $status_pago,
                'fechaLog' => $dateregistro
            ];
        
            try{
                
                $basededatos->connect()->prepare("INSERT INTO `tbl_pays`(`invoiceid`, `email`, 
                `fname`, `lname`, `reciboid`, `fechapago`, `couponcode`, `country`, `forma_pago`, `status`) 
                VALUES ( :invoiceid, :email, :fname, :lname, :reciboid, :fechapago, :couponcode, :country, :formapago, :status_pago)")->execute($data);
        
                $basededatos->connect()->prepare("UPDATE `tbl_compras` 
                SET `status`='".$status_pago."' WHERE invoiceid='".$invoiceid."'")->execute();
        
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
        break;
        default:
            $status_pago=$_POST['status_apartado'] == 0 ? 5 : 3;
            $data = [
                'invoiceid' => $_POST['invoiceid'],
                'email' => $_POST['email'],
                'fname' => $_POST['fname'],
                'lname' => $_POST['lname'],
                'reciboid' => $_POST['reciboid'],
                'fechapago' => $dateregistro,
                'couponcode' => $couponcode,
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
        
                $basededatos->connect()->prepare("UPDATE `tbl_compras` 
                SET `status`='".$status_pago."' WHERE invoiceid='".$_POST['invoiceid']."'")->execute();
        
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
        break;
    }


    // var_dump($respuesta);
    
    header('Content-Type: application/json');
    echo json_encode($respuesta);
