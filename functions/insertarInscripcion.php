<?php

    require('../api/Config/DBconfig.php');

    $idform=isset($_POST['idform']) ? $_POST['idform'] : '';
    

    $dateregistro=date("Y-m-d H:i:s");
    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $tokenCompetidor=generate_string($permitted_chars, 8).rand(1000, 9000);
    $paymenth_method=3; //Paypal
    $infoEvento=getInfoEvento($tokenEvento);

    $datosPase=dataPase($idform)['resultados'];
    $tagEvento='#'.$datosPase['tag'];


    $divisaPase=$datosPase['divisa'];
    $eEvento=$datosPase['email'];
    $passwordEvento=base64_decode($datosPase['password_mail']);
    $nombreEvento=$datosPase['nombre'];
    $imagenEvento=$datosPase['imageMail'];
    $nombrePase=$datosPase['descripcion_pase'];
    $asuntoCorreo='Confirmación de pedido - '.$tagEvento;

    if($idform==='ELWSC2023INSCSOL'){

        $data = [
            'nombre_p' => $_POST['nombre_p'],
            'apellidos_p' => $_POST['apellidos_p'],
            'fecha_nac' => $_POST['fecha_nac'],
            'email_p' => $_POST['email_p'],            
            'genero_p' => $_POST['genero_p'],
            'pais_p' => $_POST['pais_p'],
            // 'num_telefono' => $_POST['num_telefono'],
            'categoria_p' => $_POST['categoria_p'],
            'idparticipante' => $tokenCompetidor,
            'dateregistro' => $dateregistro,
            'invoiceid' => $_POST['invoiceid'],
            'cupon' => $_POST['hotel_num'],
            'paymenth_method' => $paymenth_method,
            'codFullPass' => $_POST['codFullPass']
        ];

        // var_dump($data);

        $basededatos->connect()->prepare("INSERT INTO `tbl_solistas`( `nombre_p`, `apellidos_p`, `fecha_nac`, `categoria_insc`, `genero_p`, `estado_p`, `fecharegistro_p`, `cod_insc`, `invoiceid`, `email_p`, `num_auto`, `paymenthmethod`, `codfullpass`) VALUES ( :nombre_p, :apellidos_p, :fecha_nac, :categoria_p, :genero_p, :pais_p, :dateregistro, :idparticipante, :invoiceid, :email_p, :cupon, :paymenth_method, :codFullPass)")->execute($data);

        
        $mail = new PHPMailer();
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
        $mail->setFrom($eEvento, NAME_EVENT);
        $body = file_get_contents('../correos/contentsolista.html');
        $body = str_replace('$nombre_p', $_POST['nombre_p'], $body);            
        $body = str_replace('$apellidos_p', $_POST['apellidos_p'], $body);
        $body = str_replace('$email_p', $_POST['email_p'], $body);
        $body = str_replace('$fecha_nac', $_POST['fecha_nac'], $body);
        $body = str_replace('$pais_p', $_POST['pais_p'], $body);
        $body = str_replace('$cod_insc', $tokenCompetidor, $body);
        $body = str_replace('$fecha_registro', $dateregistro, $body);
        $body = str_replace('$categoria_insc', $_POST['categoria_p'], $body);
        $body = preg_replace('/\\\\/','', $body);

        $body = str_replace('$name_event', $nombreEvento, $body);
        $body = str_replace('$contact_event', $eEvento, $body);

        $bodyy=$body;

        
        // echo $bodyy;
        $mail->MsgHTML($bodyy);
        $mail->AddAddress($_POST['email_p'], $_POST['nombre_p'].' '.$_POST['apellidos_p']);
        $mail->addBCC('bryan.martinez.romero@gmail.com');
        $mail->isHTML(true);
        
        $mail->Subject = 'Registro exitoso - '.TAG_EVENT;
        $mail->send();

    }
    // if($_POST['idform']==='parejas'){
        
        

    //     $data = [
    //         'nombre_p1' => $_POST['nombre_p1'],
    //         'apellidos_p1' => $_POST['apellidos_p1'],
    //         'date_birthday_p1' => $_POST['date_birthday_p1'],
    //         'email_p1' => $_POST['email_p1'],            
    //         'genero_p1' => $_POST['genero_p1'],
    //         'pais_p1' => $_POST['pais_p1'],
    //         'nombre_p2' => $_POST['nombre_p2'],
    //         'apellidos_p2' => $_POST['apellidos_p2'],
    //         'date_birthday_p2' => $_POST['date_birthday_p2'],
    //         'email_p2' => $_POST['email_p2'],
    //         'genero_p2' => $_POST['genero_p2'],
    //         'pais_p2' => $_POST['pais_p2'],
    //         // 'num_telefono' => $_POST['num_telefono'],
    //         'categoria' => $_POST['categoria'],
    //         'idparticipante' => $tokenCompetidor,
    //         'dateregistro' => $dateregistro,
    //         'invoiceid' => $_POST['invoiceid'],
    //         'cupon' => $_POST['hotel_num'],
    //         'paymenth_method' => $paymenth_method,
    //         'codFullPassp1' => $_POST['codFullPassp1'],
    //         'codFullPassp2' => $_POST['codFullPassp2']
    //     ];

        

    //     $basededatos->connect()->prepare("INSERT INTO `tbl_parejas` (`nombre_p1`, `apellidos_p1`, `fecha_nacp1`, `email_p1`, `genero_p1`, `estado_p1`, `nombre_p2`, `apellidos_p2`, `fecha_nacp2`, `email_p2`, `genero_p2`, `estado_p2`,`cod_insc`, `fecharegistro_p`, `invoiceid`, `categoria_insc`, `num_auto`, `paymenthmethod`, `codfullpass_p1`, `codfullpass_p2`) 
    //     VALUES (:nombre_p1,:apellidos_p1,:date_birthday_p1,:email_p1,:genero_p1,:pais_p1,:nombre_p2,:apellidos_p2,:date_birthday_p2,:email_p2,:genero_p2,:pais_p2, :idparticipante, :dateregistro, :invoiceid, :categoria, :cupon, :paymenth_method, :codFullPassp1, :codFullPassp2)")->execute($data);

    //     $mail = new PHPMailer();
    //     $mail->CharSet='UTF-8';
    //     $mail->Encoding = 'base64';
            
    //     $mail->isSMTP();                                        
    //     $mail->Host       = 'smtp.gmail.com';          
    //     $mail->SMTPAuth   = true;                               
    //     $mail->Username   = emailadmin;     
    //     $mail->Password   = passwordadmin;                   
    //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
    //     $mail->Port       = 587;                                    
    //     // $mail->SMTPDebug = 4;
    //     $mail->setFrom(emailadmin, NAME_EVENT);
    //     $body = file_get_contents('../correos/contentparejas.html');
    //     $body = str_replace('$nombre_p1', $_POST['nombre_p1'], $body);            
    //     $body = str_replace('$apellidos_p1', $_POST['apellidos_p1'], $body);

    //     $body = str_replace('$nombre_p2', $_POST['nombre_p2'], $body);            
    //     $body = str_replace('$apellidos_p2', $_POST['apellidos_p2'], $body);

    //     $body = str_replace('$email_p1', $_POST['email_p1'], $body);
    //     $body = str_replace('$email_p2', $_POST['email_p2'], $body);

    //     $body = str_replace('$fecha_nacp1', $_POST['date_birthday_p1'], $body);
    //     $body = str_replace('$fecha_nacp2', $_POST['date_birthday_p2'], $body);

    //     $body = str_replace('$pais_p1', $_POST['pais_p1'], $body);
    //     $body = str_replace('$pais_p2', $_POST['pais_p2'], $body);

    //     $body = str_replace('$cod_insc', $tokenCompetidor, $body);
    //     $body = str_replace('$fecha_registro', $dateregistro, $body);
    //     $body = str_replace('$categoria_insc', $_POST['categoria'], $body);
    //     $body = str_replace('$year_event', YEAR_EVENT, $body);
    //     $body = str_replace('$name_event', NAME_EVENT, $body);
    //     $body = str_replace('$contact_event', EMAIL_EVENT_CONTACTO, $body);

    //     $body = preg_replace('/\\\\/','', $body);
    //     $bodyy=$body;
    //     // echo $bodyy;
    //     $mail->MsgHTML($bodyy);
    //     $mail->AddAddress($_POST['email_p1'], $_POST['nombre_p1'].' '.$_POST['apellidos_p1']);
    //     $mail->AddAddress($_POST['email_p2'], $_POST['nombre_p2'].' '.$_POST['apellidos_p2']);
    //     $mail->addBCC('bryan.martinez.romero@gmail.com');
    //     $mail->isHTML(true);

    //     $mail->Subject = 'Registro exitoso - '.TAG_EVENT;
    //     $mail->send();


    // }
    // if($_POST['idform']==='grupos'){


    //     // var_dump($_POST);

    //     $numintegrantes = $_POST['numintegrantes'];

    //     // echo $numintegrantes;
    //     $data = $_POST;

    //     $salida = array_slice($data, 0, 7);
        
    //     $data = array();

    //     for ($i=0; $i < $numintegrantes ; $i++) { 
            
    //         $data["idnumintegrantes".$i] = $_POST['idnumintegrantes'.$i];
    //         $data["date_birthday".$i] = $_POST['date_birthday'.$i];
    //         $data["generoint".$i] = $_POST['generoint'.$i];
    //         $data["codFullPass".$i] = $_POST['codfullpass'.$i];
    //     }
            
    //         $salida['integrantes'] = json_encode($data);
    //         $salida['fecharegistro'] = $dateregistro;
    //         $salida['cod_insc'] = $tokenCompetidor;
    //         $salida['stat'] = 0;
    //         $salida['invoiceid'] = $_POST['invoiceid'];
    //         $salida['cupon'] = $_POST['hotel_num'];
    //         $salida['paymenth_method'] = $paymenth_method;
        
            
    
    //     try{
    
    //         $basededatos->connect()->prepare("INSERT INTO `tbl_grupos` (`categoria_insc`, `nom_repre`, `celular_repre`, `pais_grupo`, `email_repre`, `nom_grupo`, `integrantes`, `fecharegistro_p`, `cod_insc`, `status`, `numintegrantes`, `invoiceid`, `num_auto`, `paymenthmethod`) VALUES (:categoria_p, :nomrepresentante_p, :numtelrep, :pais, :emailrepresentante_p, :nombregrupo_p, :integrantes, :fecharegistro, :cod_insc, :stat, :numintegrantes, :invoiceid, :cupon, :paymenth_method)")->execute($salida);
            
            
    //         $nom_repre=$_POST['nomrepresentante_p'];
    //         $email_repre=$_POST['emailrepresentante_p'];
    //         $nom_grupo=$_POST['nombregrupo_p'];
    //         $pais_grupo=$_POST['pais'];
    //         $fecha_registro=$dateregistro;
    //         $cod_insc=$tokenCompetidor;
    //         $categoria_insc=$_POST['categoria_p'];

    //         $mail = new PHPMailer();
    //         $mail->CharSet='UTF-8';
    //         $mail->Encoding = 'base64';
                
    //         $mail->isSMTP();                                        
    //         $mail->Host       = 'smtp.gmail.com';          
    //         $mail->SMTPAuth   = true;                               
    //         $mail->Username   = emailadmin;     
    //         $mail->Password   = passwordadmin;                  
    //         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
    //         $mail->Port       = 587;                                    
    //         // $mail->SMTPDebug = 4;
    //         $mail->setFrom(emailadmin, NAME_EVENT);
    //         $body = file_get_contents('../correos/contentgrupos.html');

    //         $body = str_replace('$nom_repre', $nom_repre, $body);            
    //         $body = str_replace('$email_repre', $email_repre, $body);

    //         $body = str_replace('$nom_grupo', $nom_grupo, $body);
    //         $body = str_replace('$pais_grupo', $pais_grupo, $body);
    //         $body = str_replace('$cod_insc', $cod_insc, $body);
    //         $body = str_replace('$fecha_registro', $fecha_registro, $body);
    //         $body = str_replace('$categoria_insc', $categoria_insc, $body);

    //         $body = str_replace('$year_event', YEAR_EVENT, $body);
    //         $body = str_replace('$name_event', NAME_EVENT, $body);
    //         $body = str_replace('$contact_event', EMAIL_EVENT_CONTACTO, $body);

    //         $body = preg_replace('/\\\\/','', $body);
    //         // $bodyy=utf8_encode($body);
    //         // echo $bodyy;
    //         $mail->MsgHTML($body);
    //         $mail->AddAddress($email_repre, $nom_repre);
    //         $mail->addBCC('bryan.martinez.romero@gmail.com');
    //         $mail->isHTML(true);
            
    //         $mail->Subject = 'Registro exitoso - '.TAG_EVENT;
    //         $mail->send();

        
    
    //     }catch( PDOException $e){
    //         echo $e;
    //     }

        
        
    // }