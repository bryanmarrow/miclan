<?php

    // session_start();
    
    // var_dump($_POST);

    require('../api/Config/DBconfig.php');
    

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../phpmailer/src/Exception.php';
    require '../phpmailer/src/PHPMailer.php';
    require '../phpmailer/src/SMTP.php';
    
    
    date_default_timezone_set('America/Mexico_City');
    $fechapago = date("Y-m-d H:i:s");

    $paymenthMethod=$_POST['metodoPago'];

    
    
    
    $user_id=$_SESSION['idUserSession'];
    $cupon=isset($_SESSION['cupon']) ? $_SESSION['cupon'] : '';


    $queryUser=$basededatos->connect()->prepare("SELECT * FROM tbl_users where id='".$user_id."'");
    $queryUser->execute();
    $col=$queryUser->fetch(PDO::FETCH_ASSOC);   

    $invoice_id=isset($_POST['invoice_id']) ? $_POST['invoice_id'] : '';
 
    $email_p=$col['email'];
    $nombre_p=isset($col['fname']) ? $col['fname'] : '';
    $apellidos_p=isset($col['lname']) ? $col['lname'] : '';
    $nombreCompleto=$nombre_p.' '.$apellidos_p;
    $pases=isset($_POST['pases']) ? $_POST['pases'] : '';

    

    $infoOrdenPases=calcularPrecio($pases, $paymenthMethod);

    // var_dump($infoOrdenPases);

    $totalCarrito=isset($infoOrdenPases['total_amount']) ? number_format($infoOrdenPases['total_amount'], 2, '.', '') : '';
    $subtotalCarrito=isset($infoOrdenPases['subTotalCarrito']) ? number_format($infoOrdenPases['subTotalCarrito'], 2, '.', '') : '';
    $taxCarrito=isset($infoOrdenPases['tax']) ? number_format($infoOrdenPases['tax'], 2, '.', '') : '';    


    $infoOrdenPases['fechapago'] = $fechapago;
    $infoOrdenPases['invoice_id'] = $invoice_id;
    $infoOrdenPases['cupon']=$cupon;

    $itemsCompra='';
    $carrito=[];
    foreach ($pases as $item) {

        $datosPase=getPrecioPase($item['sku']);

        // var_dump($datosPase);

        $precioPase=$datosPase['precio'];
        $divisaPase=$datosPase['divisaPase'];
        $nombreEvento=$datosPase['nombreEvento'];

        $datosPase['quantity']=$item['quantity'];
        $datosPase['subTotalPase']=$precioPase*$item['quantity'];

        array_push($carrito, $datosPase);

        // $itemsCompra.='<tr>
        // <td style="padding: 5px 15px 5px 0;">
        //     <p style="padding:0px; margin:0px;">'.$item['nomPase'].'</p>
        // </td>
        // <td style="padding: 0 15px;">'.$item['quantity'].'</td>
        // <td style="padding: 0 0 0 15px;" align="right">$ '.$precioPase.' '.$divisaPase.'</td>
        // </tr>';

        $itemsCompra.='<tr>
        <td style="padding: 12px 5px; vertical-align: top;border: 1px solid #ddd;border-collapse: collapse;">
            <h6
                style="font-size: 15px; margin: 0px;font-weight: 500; font-family: `Poppins`, sans-serif;">
                '.$item['nomPase'].'</h6>
            <p
                style="color: #878a99 !important; margin-bottom: 10px; font-size: 13px;font-weight: 500;margin-top: 6px;">
                '.$nombreEvento.'</p>            
        </td>
        <td style="padding: 12px; vertical-align: top;border: 1px solid #ddd;border-collapse: collapse;text-align:center">
            <h6
                style="font-size: 15px; margin: 0px;font-weight: 400; font-family: `Poppins`, sans-serif;">
                '.$item['quantity'].'</h6>
        </td>
        <td style="padding: 12px; vertical-align: top;text-align: end;border: 1px solid #ddd;border-collapse: collapse;">
            <h6
                style="font-size: 15px; margin: 0px;font-weight: 600; font-family: `Poppins`, sans-serif;">
                $ '.$precioPase.' '.$divisaPase.'</h6>
        </td>
        </tr>';
    }


    $divcupon='';
    if(isset($_SESSION['cupon'])){
        // $divcupon='<tr style="border-bottom:1px solid #ecedee;text-align:left;">
        //     <th style="padding: 0 15px 2px 0;">
        //         Cupón: '.$cupon['cupon'].'
        //     </th>
        // </tr>';
        $divcupon='<tr>
        <td colspan="3" style="padding: 12px 8px; font-size: 15px;">
            Cupón
        </td>
        <td style="padding: 12px 8px; font-size: 15px;text-align: end; ">
            <h6
                style="font-size: 15px; margin: 0px;font-weight: 600; font-family: "Poppins", sans-serif;">
                '.$cupon['cupon'].'</h6>
            </th>
        </tr>';        
    }



   
    // Datos Correo
    
    $mailCopia='bryan.martinez.romero@gmail.com';
    $dataPase=infoEvento($tokenEvento);
        
    $imagenEvento=$dataPase['imageMail'];
    $tagPase=$dataPase['tag'];
    $correoContactoEvento=$dataPase['email'];
    $nombreEvento=$dataPase['nombre'];
    $yearEvento=$dataPase['year'];
    $subjectMailPase='Confirmación de pedido ('.$invoice_id.') - #'.$tagPase;
   


    $infoOrden=isset($_POST['infoOrdenPases']) ? $_POST['infoOrdenPases'] : [];
   
    switch($paymenthMethod){
        case 'transfer':
            $statusOrden='<span class="badge badge-danger">Pendiente</span>';            
            $metodoPago='Transferencia bancaria/Depósito';
        break;
        case 'credit-card':
            foreach ($infoOrden as $row) {

                $dataLog = [
                    'tokenTicket' => $row['idPase'],
                    'status_ticket' => 1,
                    'invoiceid' => $row['invoiceid'],
                    'comprobante_pago' => '',
                    'payment_method' => 7,
                    'admin_user' => 1800,
                    'fechaLog' => $fechapago
                ];
        
                try{
        
                    $basededatos->connect()->prepare("INSERT INTO `tbl_log_status_ordenes`(`tokenOrden`, 
                    `id_status`, `invoiceid`, `comprobante_pago`, `paymenth_method`, `admin_user`, `fecharegistro`)
                    VALUES (:tokenTicket, :status_ticket, :invoiceid, :comprobante_pago, :payment_method, :admin_user, :fechaLog)")->execute($dataLog);
        
                    $basededatos->connect()->prepare("UPDATE `tbl_ordenes` SET `status`=1 WHERE `token`='".$row['idPase']."'")->execute();
        
                    $basededatos->connect()->prepare("UPDATE `tbl_orders` SET `statusOrder`=1 WHERE `invoiceid`='".$row['invoiceid']."'")->execute();
            
                    $respuesta_actualizacionOrdenes = array(
                        'respuesta' => 'success',
                    );
            
                }catch(PDOException $e){
            
                    $respuesta_actualizacionOrdenes = array(
                        'respuesta' => 'error',
                        'mensaje' => $e->getMessage()
                    );
                }
                
            }        
            foreach($pases as $pase){
                // var_dump($pase);
        
                switch ($pase['tipoPase']) {
                    case 'competencia':
                        try{
                            $query="UPDATE `tbl_competencias` SET `statusPase`=3 WHERE registrocompetencia_id='".$pase['invoiceid']."'";
                            $basededatos->connect()->prepare($query)->execute();
        
                            $respuesta_actualizacionOrdenes = array(
                                'respuesta' => 'success',
                            );
                        }catch(PDOException $e){
                            
                            $respuesta_actualizacionOrdenes = array(
                                'respuesta' => 'error',
                                'mensaje' => $e->getMessage()
                            );
                        }
                        
                        break;                        
                }
            }
            $statusOrden='<span class="badge badge-success">Liquidado</span>';
            $metodoPago='Tarjeta bancaria';
        break;
    }


    // var_dump($infoCompetidores);

    // var_dump($respuesta_actualizacionOrdenes)
    
    
    try{
        $mail = new PHPMailer(true);
        $mail->CharSet='UTF-8';
        $mail->Encoding = 'base64';
        $mail->isSMTP();                                        
        $mail->Host       = 'smtp.gmail.com';          
        $mail->SMTPAuth   = true;                               
        $mail->Username   = 'info@eurosonlatino.com.mx';     
        $mail->Password   = 'pyramid2021*';                      
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
        $mail->Port       = 587;                                    
        // $mail->SMTPDebug = 4;
        $mail->setFrom(emailadmin, 'Euroson Latino');
        $body = file_get_contents('../correos/invoice_v2.html');
        $body = str_replace('$email', $email_p, $body);
        $body = str_replace('$invoiceid', $invoice_id, $body);
        $body = str_replace('$itemsCompra', $itemsCompra, $body);
        $body = str_replace('$subtotalCarrito', $subtotalCarrito, $body);
        $body = str_replace('$taxCarrito', $taxCarrito, $body);
        $body = str_replace('$fechacompra', $fechapago, $body);
        $body = str_replace('$totalCarrito', $totalCarrito, $body);
        $body = str_replace('$cupon', $divcupon, $body);
        $body = str_replace('$statusOrden', $statusOrden, $body);
        $body = str_replace('$metodoPago', $metodoPago, $body);
        
        

        $body = str_replace('$imagenEvento', $imagenEvento, $body);
        $body = str_replace('$tagPase', $tagPase, $body);
        $body = str_replace('$correoContactoEvento', $correoContactoEvento, $body);
        $body = str_replace('$nombreEvento', $nombreEvento, $body);
        $body = str_replace('$nombreCompleto', $nombreCompleto, $body);


        $body = preg_replace('/\\\\/','', $body);
        $mail->MsgHTML($body);
        //$mail->AddAddress($invoice['email']);
        $mail->AddAddress($email_p, $nombreCompleto);
        $mail->addBCC($mailCopia);
        $mail->isHTML(true);

        $mail->Subject = $subjectMailPase;
        $mail->send();

        $data = array(
            'respuesta' => 'success',
            'infoOrdenPases' => $infoOrdenPases,
            'pases' => $carrito,
            'ordenPago' => $col,
            'statusOrdenCompra' => $statusOrden,
            'metodoPago' => $metodoPago
        );

        unset($_SESSION['cupon']);

    }catch(phpmailerException $e){

        $data = array(
            'respuesta' => 'error',
            'mensaje' => $e,
            'texto' => 'Error al enviar correo electrónico'
        );

    }

    header('Content-Type: application/json');
    echo json_encode($data);
   

?>