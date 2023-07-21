<?php
    require('../api/Config/DBconfig.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../phpmailer/src/Exception.php';
    require '../phpmailer/src/PHPMailer.php';
    require '../phpmailer/src/SMTP.php';

    
    $invoiceid=isset($_POST['codigoconf']) ? $_POST['codigoconf'] : '';
    $infoEvento=getInfoEvento($tokenEvento);

    $queryCompra="SELECT 
    tbl_compras.nombre,
    tbl_compras.apellidos,
    tbl_compras.email,
    tbl_compras.invoiceid,
    tbl_status_pases.tagHtml,
    tbl_compras.fechaRegistro
    FROM tbl_compras 
    INNER JOIN tbl_status_pases ON tbl_compras.status = tbl_status_pases.id
    WHERE tbl_compras.invoiceid='$invoiceid'";
    $queryCompraExe=$basededatos->connect()->prepare($queryCompra);
    $queryCompraExe->execute();

    $queryLiquidarPase="SELECT *
    FROM tbl_compras
    INNER JOIN tbl_ordenes ON tbl_compras.invoiceid = tbl_ordenes.invoiceid
    INNER JOIN tbl_pases ON tbl_ordenes.idform = tbl_pases.id
    WHERE tbl_compras.invoiceid='$invoiceid'";

    $datos=$basededatos->connect()->prepare($queryLiquidarPase);   
    $datos->execute();
    
    $integrantes=$datos->fetchAll(PDO::FETCH_ASSOC);

    $numfilas=$datos->rowCount();


    $dataCompra=$queryCompraExe->fetch(PDO::FETCH_ASSOC);

    $tableIntegrantes='';
    foreach($integrantes as $key => $integrante){

        $tokenOrden=$integrante['token'];

        if($key==0){
            $skuForm=$integrante['codigo_pase'];
            $nombrePase=$integrante['descripcion_pase'];
        }
        $tableIntegrantes.='<tr>';
        $tableIntegrantes.='<td class="purchase_item">
                    <span class="f-fallback">Nombre: '.$integrante['fname'].' '.$integrante['lname'].'</span><br>
                </td>';
        $tableIntegrantes.='<td class="purchase_item"><span class="f-fallback">'.$tokenOrden.'</span></td>';
        $tableIntegrantes.='</tr>';

    }

    $datosPase=dataPase($skuForm)['resultados'];


    $nombreCompleto=$dataCompra['nombre'].' '.$dataCompra['apellidos'];
    $emailTitular=$dataCompra['email'];


    $tagEvento='#'.$infoEvento['tag'];

    $divisaPase=$datosPase['divisa'];
    $eEvento=$infoEvento['email'];
    $passwordEvento=base64_decode($infoEvento['password_mail']);
    $nombreEvento=$infoEvento['nombre'];
    $imagenEvento=$infoEvento['imageMail'];    
    $asuntoCorreo='Confirmación de pedido - '.$tagEvento;

    try{

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
        $body = file_get_contents('../correos/notificacion_pase_liquidacion.html');


        $body = str_replace('$tableIntegrantes', $tableIntegrantes, $body);

        $body = str_replace('$nombrePase', $nombrePase, $body);
        $body = str_replace('$invoiceid', $invoiceid, $body);
        // $body = str_replace('$montoPagado', $montoPagado, $body);
        // $body = str_replace('$divisaPase', $divisaPase, $body);

        $body = str_replace('$emailTitular', $emailTitular, $body);
        // $body = str_replace('$nombrePaisTitular',  $nombrePaisTitular, $body);


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

        $respuesta=array(
            'respuesta' => 'success'
        );

    }catch(phpmailerException $e){
        $respuesta=array(
            'respuesta' => 'error',
            'mensaje' => $e->errorMessage()
        );

    }

    header('Content-Type: application/json; charset=utf-8');
    printf(json_encode($respuesta));