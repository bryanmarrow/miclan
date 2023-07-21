<?php

    require('../api/Config/DBconfig.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../phpmailer/src/Exception.php';
    require '../phpmailer/src/PHPMailer.php';
    require '../phpmailer/src/SMTP.php';


    date_default_timezone_set('America/Mazatlan');
    $idparticipante=rand(200000, 900000);
    $dateregistro=date("Y-m-d H:i:s");

    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $tokenCompetidor=generate_string($permitted_chars, 8).rand(1000, 9000);

    $tipocategoria_p=getTipoCategoria($_POST['categoria_p'])['tipo'];

    $sesion=generate_string($permitted_chars, 4).rand(1000, 9000);
    $paymenth_method=3;

    


    $dataEvento=getInfoEvento($tokenEvento);
    $emailEvento=$dataEvento['email'];
    $passEvento=base64_decode($dataEvento['password_mail']);
    $name_event=$dataEvento['nombre'];
    $contact_event=$dataEvento['email'];
    $tagEvento='#'.$dataEvento['tag'];
    $imageMail=$dataEvento['imageMail'];
    $year_event=$dataEvento['year'];

    $userId=$_SESSION['idUserSession'];    

    switch ($tipocategoria_p) {
        case 'solistas':
            
            $categoria_insc=getCategoria($_POST['categoria_p'])['categoria_es'];
            $pais_p=getPais($_POST['pais_p'])['pais'];

            $data = [
                'nombre_p' => $_POST['nombre_p'],
                'apellidos_p' => $_POST['apellidos_p'],
                'fecha_nac' => $_POST['fecha_nac'],
                'email_p' => $_POST['email_p'],            
                'genero_p' => $_POST['genero_p'],
                'pais_p' => $_POST['pais_p'],
                'categoria_p' => $_POST['categoria_p'],
                'idparticipante' => $tokenCompetidor,
                'dateregistro' => $dateregistro,
                'invoiceid' => $_POST['invoiceid'],
                'cupon' => $_POST['hotel_num'],
                'paymenth_method' => $paymenth_method,
                'codFullPass' => $_POST['codFullPass'],
                'userId' => $userId
            ];
        
            // var_dump($data);
        
            try {
                
                $basededatos->connect()->prepare("INSERT INTO `tbl_solistas`( `nombre_p`, `apellidos_p`, `fecha_nac`, `categoria_insc`, `genero_p`, `estado_p`, `fecharegistro_p`, `cod_insc`, `invoiceid`, `email_p`, `num_auto`, `paymenthmethod`, `codfullpass`, `userId`) 
                VALUES ( :nombre_p, :apellidos_p, :fecha_nac, :categoria_p, :genero_p, :pais_p, :dateregistro, :idparticipante, :invoiceid, :email_p, :cupon, :paymenth_method, :codFullPass, :userId)")->execute($data);

                $mail = new PHPMailer();
                $mail->CharSet='UTF-8';
                $mail->Encoding = 'base64';
                $mail->isSMTP();                                        
                $mail->Host       = 'smtp.gmail.com';          
                $mail->SMTPAuth   = true;                               
                $mail->Username   = $emailEvento;     
                $mail->Password   = $passEvento;                     
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
                $mail->Port       = 587;                                    
                // $mail->SMTPDebug = 4;
                $mail->setFrom($emailEvento, $name_event);

                $body = file_get_contents('../correos/contentsolista.html');
                $body = str_replace('$nombre_p', $_POST['nombre_p'], $body);            
                $body = str_replace('$apellidos_p', $_POST['apellidos_p'], $body);
                $body = str_replace('$email_p', $_POST['email_p'], $body);
                $body = str_replace('$fecha_nac', $_POST['fecha_nac'], $body);
                $body = str_replace('$pais_p', $pais_p, $body);
                $body = str_replace('$cod_insc', $tokenCompetidor, $body);
                $body = str_replace('$fecha_registro', $dateregistro, $body);
                $body = str_replace('$categoria_insc', $categoria_insc, $body);
                $body = preg_replace('/\\\\/','', $body);

                $body = str_replace('$year_event', $year_event, $body);
                $body = str_replace('$name_event', $name_event, $body);
                $body = str_replace('$contact_event', $contact_event, $body);
                $body = str_replace('$imageMail', $imageMail, $body);

                $bodyy=$body;
                $mail->MsgHTML($bodyy);
                $mail->AddAddress($_POST['email_p'], $_POST['nombre_p'].' '.$_POST['apellidos_p']);
                $mail->addBCC('bryan.martinez.romero@gmail.com');
                $mail->isHTML(true);
                
                $mail->Subject = 'Registro exitoso - '.$tagEvento;
                $mail->send();

                $respuesta = array(
                    'respuesta' => 'success'
                );

            } catch (PDOException $e) {

                $respuesta = array(
                    'respuesta' => 'error',
                    'mensaje' => $e->getMessage()
                );

            }catch (phpmailerException $e) {
                
                $respuesta = array(
                    'respuesta' => 'error',
                    'mensaje' => $e->errorMessage()
                );
            } 
            break;        
        case 'parejas':

            
            $categoria_insc=getCategoria($_POST['categoria_p'])['categoria_es'];
            $pais_p1=getPais($_POST['pais_p1'])['pais'];
            $pais_p2=getPais($_POST['pais_p2'])['pais'];

            $data = [
                'nombre_p1' => $_POST['nombre_p1'],
                'apellidos_p1' => $_POST['apellidos_p1'],
                'date_birthday_p1' => $_POST['date_birthday_p1'],
                'email_p1' => $_POST['email_p1'],            
                'genero_p1' => $_POST['genero_p1'],
                'pais_p1' => $_POST['pais_p1'],
                'nombre_p2' => $_POST['nombre_p2'],
                'apellidos_p2' => $_POST['apellidos_p2'],
                'date_birthday_p2' => $_POST['date_birthday_p2'],
                'email_p2' => $_POST['email_p2'],
                'genero_p2' => $_POST['genero_p2'],
                'pais_p2' => $_POST['pais_p2'],
                'categoria' => $_POST['categoria_p'],
                'idparticipante' => $tokenCompetidor,
                'dateregistro' => $dateregistro,
                'invoiceid' => $_POST['invoiceid'],
                'cupon' => $_POST['hotel_num'],
                'paymenth_method' => $paymenth_method,
                'codFullPassp1' => $_POST['codFullPassp1'],
                'codFullPassp2' => $_POST['codFullPassp2'],
                'userId' => $userId
            ];
    
            
            try{

                $basededatos->connect()->prepare("INSERT INTO `tbl_parejas` (`nombre_p1`, `apellidos_p1`, `fecha_nacp1`, `email_p1`, `genero_p1`, `estado_p1`, `nombre_p2`, `apellidos_p2`, 
                `fecha_nacp2`, `email_p2`, `genero_p2`, `estado_p2`,`cod_insc`, `fecharegistro_p`, `invoiceid`, `categoria_insc`, `num_auto`, `paymenthmethod`, `codfullpass_p1`, `codfullpass_p2`, `userId`) 
                VALUES (:nombre_p1,:apellidos_p1,:date_birthday_p1,:email_p1,:genero_p1,:pais_p1,:nombre_p2,:apellidos_p2,:date_birthday_p2,:email_p2,
                :genero_p2,:pais_p2, :idparticipante, :dateregistro, :invoiceid, :categoria, :cupon, :paymenth_method, :codFullPassp1, :codFullPassp2, :userId)")->execute($data);

                $mail = new PHPMailer();
                $mail->CharSet='UTF-8';
                $mail->Encoding = 'base64';
                    
                $mail->isSMTP();                                        
                $mail->Host       = 'smtp.gmail.com';          
                $mail->SMTPAuth   = true;                               
                $mail->Username   = $emailEvento;     
                $mail->Password   = $passEvento;                          
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
                $mail->Port       = 587;                                    
                // $mail->SMTPDebug = 4;
                $mail->setFrom($emailEvento, $name_event);
                $body = file_get_contents('../correos/contentparejas.html');
                $body = str_replace('$nombre_p1', $_POST['nombre_p1'], $body);            
                $body = str_replace('$apellidos_p1', $_POST['apellidos_p1'], $body);

                $body = str_replace('$nombre_p2', $_POST['nombre_p2'], $body);            
                $body = str_replace('$apellidos_p2', $_POST['apellidos_p2'], $body);

                $body = str_replace('$email_p1', $_POST['email_p1'], $body);
                $body = str_replace('$email_p2', $_POST['email_p2'], $body);

                $body = str_replace('$fecha_nacp1', $_POST['date_birthday_p1'], $body);
                $body = str_replace('$fecha_nacp2', $_POST['date_birthday_p2'], $body);

                $body = str_replace('$pais_p1', $pais_p1, $body);
                $body = str_replace('$pais_p2', $pais_p2, $body);

                $body = str_replace('$cod_insc', $tokenCompetidor, $body);
                $body = str_replace('$fecha_registro', $dateregistro, $body);
                $body = str_replace('$categoria_insc', $categoria_insc, $body);

                $body = str_replace('$year_event', $year_event, $body);
                $body = str_replace('$name_event', $name_event, $body);
                $body = str_replace('$contact_event', $contact_event, $body);
                $body = str_replace('$imageMail', $imageMail, $body);

                $body = preg_replace('/\\\\/','', $body);
                $bodyy=$body;
                // echo $bodyy;
                $mail->MsgHTML($bodyy);
                $mail->AddAddress($_POST['email_p1'], $_POST['nombre_p1'].' '.$_POST['apellidos_p1']);
                $mail->AddAddress($_POST['email_p2'], $_POST['nombre_p2'].' '.$_POST['apellidos_p2']);
                $mail->addBCC('bryan.martinez.romero@gmail.com');
                $mail->isHTML(true);

                $mail->Subject = 'Registro exitoso - '.$tagEvento;
                $mail->send();

                $respuesta = array(
                    'respuesta' => 'success'
                );
            } catch (PDOException $e) {

                $respuesta = array(
                    'respuesta' => 'error',
                    'mensaje' => $e->getMessage()
                );

            }catch (phpmailerException $e) {
                
                $respuesta = array(
                    'respuesta' => 'error',
                    'mensaje' => $e->errorMessage()
                );
            } 
            
    
           
            break;
        case 'grupos':
            // var_dump($_POST);

            $numintegrantes = $_POST['numintegrantes'];

            // echo $numintegrantes;
            $data = $_POST;

            $salida = array_slice($data, 0, 7);
            
            $data = array();

            for ($i=0; $i < $numintegrantes ; $i++) { 
                
                $data["idnumintegrantes".$i] = $_POST['idnumintegrantes'.$i];
                $data["date_birthday".$i] = $_POST['date_birthday'.$i];
                $data["generoint".$i] = $_POST['generoint'.$i];
                $data["codFullPass".$i] = $_POST['codfullpass'.$i];
            }
                
            $salida['integrantes'] = json_encode($data);
            $salida['fecharegistro'] = $dateregistro;
            $salida['cod_insc'] = $tokenCompetidor;
            $salida['stat'] = 0;
            $salida['invoiceid'] = $_POST['invoiceid'];
            $salida['cupon'] = $_POST['hotel_num'];
            $salida['paymenth_method'] = $paymenth_method;
            $salida['userId'] = $userId;
                
        
            try{
        
                $basededatos->connect()->prepare("INSERT INTO `tbl_grupos` (`categoria_insc`, `nom_repre`, `celular_repre`, `pais_grupo`, `email_repre`, `nom_grupo`, `integrantes`, `fecharegistro_p`, `cod_insc`, `status`, `numintegrantes`, `invoiceid`, `num_auto`, `paymenthmethod`, `userId`) 
                VALUES (:categoria_p, :nomrepresentante_p, :numtelrep, :pais, :emailrepresentante_p, :nombregrupo_p, :integrantes, :fecharegistro, :cod_insc, :stat, :numintegrantes, :invoiceid, :cupon, :paymenth_method, :userId)")->execute($salida);
                
                
                $nom_repre=$_POST['nomrepresentante_p'];
                $email_repre=$_POST['emailrepresentante_p'];
                $nom_grupo=$_POST['nombregrupo_p'];
                $pais_grupo=getPais($_POST['pais'])['pais'];
                $fecha_registro=$dateregistro;
                $cod_insc=$tokenCompetidor;
                $categoria_insc=getCategoria($_POST['categoria_p'])['categoria_es'];

                
                $mail = new PHPMailer();
                $mail->CharSet='UTF-8';
                $mail->Encoding = 'base64';
                    
                $mail->isSMTP();                                        
                $mail->Host       = 'smtp.gmail.com';          
                $mail->SMTPAuth   = true;                               
                $mail->Username   = $emailEvento;     
                $mail->Password   = $passEvento;                          
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
                $mail->Port       = 587;                                    
                // $mail->SMTPDebug = 4;
                $mail->setFrom($emailEvento, $name_event);
                $body = file_get_contents('../correos/contentgrupos.html');

                $body = str_replace('$nom_repre', $nom_repre, $body);            
                $body = str_replace('$email_repre', $email_repre, $body);

                $body = str_replace('$nom_grupo', $nom_grupo, $body);
                $body = str_replace('$pais_grupo', $pais_grupo, $body);
                $body = str_replace('$cod_insc', $cod_insc, $body);
                $body = str_replace('$fecha_registro', $fecha_registro, $body);
                $body = str_replace('$categoria_insc', $categoria_insc, $body);

                $body = str_replace('$year_event', $year_event, $body);
                $body = str_replace('$name_event', $name_event, $body);
                $body = str_replace('$contact_event', $contact_event, $body);
                $body = str_replace('$imageMail', $imageMail, $body);

                $body = preg_replace('/\\\\/','', $body);
                // $bodyy=utf8_encode($body);
                // echo $bodyy;
                $mail->MsgHTML($body);
                $mail->AddAddress($email_repre, $nom_repre);
                $mail->addBCC('bryan.martinez.romero@gmail.com');
                $mail->isHTML(true);
                
                $mail->Subject = 'Registro exitoso - '.$tagEvento;

                $mail->send();

                $respuesta = array(
                    'respuesta' => 'success'
                );

            
        
            }catch (PDOException $e) {

                $respuesta = array(
                    'respuesta' => 'error',
                    'mensaje' => $e->getMessage()
                );

            }catch (phpmailerException $e) {
                
                $respuesta = array(
                    'respuesta' => 'error',
                    'mensaje' => $e->errorMessage()
                );
            } 

            break;
        default:
            # code...
            break;
    }
    

    header('Content-Type: application/json');
    echo json_encode($respuesta);
    
