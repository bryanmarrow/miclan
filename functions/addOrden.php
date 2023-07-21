<?php
    
    require('../api/Config/DBconfig.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../phpmailer/src/Exception.php';
    require '../phpmailer/src/PHPMailer.php';
    require '../phpmailer/src/SMTP.php';


    date_default_timezone_set('America/Mexico_City');
    $rangonumerico=rand(10000000, 90000000);
    $dateregistro=date("Y-m-d H:i:s");

    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    $randalf=generate_string($permitted_chars, 8);
    $tokenOrden=$randalf.$rangonumerico;
    $paymenth_method=3; //Paypal
    
    $statusApartado=$_POST['status_apartado'] == 1 ? 0 : 1;
    $statusPago=$_POST['status_apartado'] == 1 ? 3 : 5; // 
    
    $skuForm=$_POST['sku'];
    $datosPase=dataPase($skuForm)['resultados'];
    $tagEvento='#'.$datosPase['tag'];

    $tipoPase=$datosPase['tipo_pase'];

    
    $integrantes=json_decode($_POST['integrantes']);

    // var_dump($integrantes);
    
    $status_apartado=$_POST['status_apartado'];
    $montoPagado=$status_apartado==0 ? $datosPase['precio_apartado']*$datosPase['maxPases'] : $datosPase['precio']*$datosPase['maxPases'];


    if(count($integrantes)>0){

        $invoiceid=$_POST['invoiceid'];
        

        $divisaPase=$datosPase['divisa'];
        $eEvento=$datosPase['email'];
        $passwordEvento=base64_decode($datosPase['password_mail']);
        $nombreEvento=$datosPase['nombre'];
        $imagenEvento=$datosPase['imageMail'];
        $nombrePase=$status_apartado==0 ? 'Apartado de '.$datosPase['descripcion_pase'] : $datosPase['descripcion_pase'];
        $asuntoCorreo='Confirmación de pedido - '.$tagEvento;



        $tableIntegrantes='';

        $nombreCompleto=$integrantes[0][0].' '.$integrantes[0][1];
        $emailTitular=$integrantes[0][2];
        $paisTitular=$integrantes[0][3];
        $nombrePaisTitular=$integrantes[0][4];

    
        foreach($integrantes as $key => $integrante){

            $tokenOrden=generate_string($permitted_chars, 8).rand(10000000, 90000000);

            $tableIntegrantes.='<tr>';
                $tableIntegrantes.='<td class="purchase_item">
                        <span class="f-fallback">Nombre: '.$integrante[0].' '.$integrante[1].'</span><br>
                    </td>';
            $tableIntegrantes.='<td class="purchase_item"><span class="f-fallback">'.$tokenOrden.'</span></td>';
            $tableIntegrantes.='</tr>';


            $dataintegrante = [
                'invoiceid' => $_POST['invoiceid'],
                'statusPago' =>  $statusPago
            ];

            try{
    
                $basededatos->connect()->prepare("UPDATE `tbl_ordenes` SET `status`=:statusPago WHERE `invoiceid`=:invoiceid")->execute($dataintegrante);

                $respuesta = array(
                    'respuesta' => 'success'
                );
    
            }catch( PDOException $e){
                $respuesta = array(
                    'respuesta' => 'error',
                    'mensaje' => $e->getMessage()
                );
            }
        }


       

        $mail = new PHPMailer(true);
        $mail->CharSet='UTF-8';
        $mail->Encoding = 'base64';
            
        $mail->isSMTP();                                        
        $mail->Host       = 'smtp.gmail.com';          
        $mail->SMTPAuth   = true;                               
        $mail->Username   = $eEvento;     
        $mail->Password   = $passwordEvento;                      
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
        $mail->Port       = 587;                                    
        // $mail->SMTPDebug = 4;
        $mail->setFrom($eEvento, $nombreEvento);
        $body = file_get_contents('../correos/notificacion_pase_promo.html');
        
        
        $body = str_replace('$tableIntegrantes', $tableIntegrantes, $body);

        $body = str_replace('$nombrePase', $nombrePase, $body);
        $body = str_replace('$invoiceid', $invoiceid, $body);
        $body = str_replace('$montoPagado', $montoPagado, $body);
        $body = str_replace('$divisaPase', $divisaPase, $body);

        $body = str_replace('$emailTitular', $emailTitular, $body);
        $body = str_replace('$nombrePaisTitular',  $nombrePaisTitular, $body);
        

        $body = str_replace('$eEvento', $eEvento, $body);
        $body = str_replace('$nombreEvento', $nombreEvento, $body);
        $body = str_replace('$imagenEvento', $imagenEvento, $body);
        $body = str_replace('$tagEvento', $tagEvento, $body);
        


        $body = preg_replace('/\\\\/','', $body);
        $mail->MsgHTML($body);
        $mail->AddAddress($emailTitular, $nombreCompleto);
        $mail->addBCC('bryan.martinez.romero@gmail.com');
        $mail->isHTML(true);

        $mail->Subject = $asuntoCorreo;
        $mail->send();

    }
    
    header('Content-Type: application/json');
    echo json_encode($respuesta);



