<?php

    // var_dump($_POST);
    require('../api/Config/DBconfig.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../phpmailer/src/Exception.php';
    require '../phpmailer/src/PHPMailer.php';
    require '../phpmailer/src/SMTP.php';


    date_default_timezone_set('America/Mexico_City');
    $idparticipante=rand(200000, 900000);
    $dateregistro=date("Y-m-d H:i:s");
    
    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $tokenCompetidor=generate_string($permitted_chars, 4).rand(1000, 9000);


    function correoreservacion($nom_resp, $email_resp, $pais_grupo, $num_huespedes, $num_habitaciones, $fecha_entrada, $fecha_salida, $fecha_registro, $hotel_num, $template){

        $mail = new PHPMailer(true);
        $mail->CharSet='UTF-8';
        $mail->Encoding = 'base64';
        $mail->isSMTP();                                        
        $mail->Host       = 'smtp.gmail.com';          
        $mail->SMTPAuth   = true;                               
        $mail->Username   = emailadmin;     
        $mail->Password   = passwordadmin;                      
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
        $mail->Port       = 587;                                    
        // $mail->SMTPDebug = 4;
        $mail->setFrom(emailadmin, 'Euroson Latino');
        $body = file_get_contents($template);
        $body = str_replace('$nom_resp', $nom_resp, $body);
        $body = str_replace('$email_resp', $email_resp, $body);
        $body = str_replace('$pais_grupo', $pais_grupo, $body);
        $body = str_replace('$num_huespedes', $num_huespedes, $body);
        $body = str_replace('$num_habitaciones', $num_habitaciones, $body);
        $body = str_replace('$fecha_entrada', $fecha_entrada, $body);
        $body = str_replace('$fecha_salida', $fecha_salida, $body);
        $body = str_replace('$fecha_registro', $fecha_registro, $body);
        $body = str_replace('$hotel_num', $hotel_num, $body);


        $body = preg_replace('/\\\\/','', $body);
        $mail->MsgHTML($body);
        //$mail->AddAddress($invoice['email']);
        $mail->AddAddress($email_resp, $nom_resp);
        $mail->addBCC(emailsuperadmin);
        $mail->isHTML(true);

        $mail->Subject = 'Confirmación de registro - #ELWSC2023';
        $mail->send();
    }
    function correoframepic($codinsc, $nom_resp, $email, $dateregistro, $pais, $categoria_insc, $template, $tipocategoria){


        $mail = new PHPMailer(true);
        $mail->CharSet='UTF-8';
        $mail->Encoding = 'base64';
        $mail->isSMTP();                                        
        $mail->Host       = 'smtp.gmail.com';          
        $mail->SMTPAuth   = true;                               
        $mail->Username   = emailadmin;     
        $mail->Password   = passwordadmin;                      
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
        $mail->Port       = 587;                                    
        // $mail->SMTPDebug = 4;
        $mail->setFrom(emailadmin, 'Euroson Latino');
        $body = file_get_contents($template);
        $body = str_replace('$codinsc', $codinsc, $body);
        $body = str_replace('$dateregistro', $dateregistro, $body);
        $body = str_replace('$pais', $pais, $body);
        $body = str_replace('$categoria_insc', $categoria_insc, $body);
        $body = str_replace('$nombre', $nom_resp, $body);
       


        $body = preg_replace('/\\\\/','', $body);
        $mail->MsgHTML($body);
        //$mail->AddAddress($invoice['email']);
        if($tipocategoria=='solistas' or $tipocategoria=='grupos'){
            $mail->AddAddress($email, $nom_resp);
        }else{
            $emails = explode(",", $email);
            $mail->AddAddress($emails[0], $nom_resp);
            $mail->AddAddress($emails[1], $nom_resp);
        }
        $mail->addBCC(emailsuperadmin);
        $mail->isHTML(true);

        $mail->Subject = 'Imagen enviada correctamente ✅ - #ELWSC2023';
        $mail->send();
    }
    function correoerror($mensaje, $formulario, $fecha){
            $mail = new PHPMailer();
            $mail->CharSet='UTF-8';
            $mail->Encoding = 'base64';
                
            $mail->isSMTP();                                        
            $mail->Host       = 'smtp.gmail.com';          
            $mail->SMTPAuth   = true;                               
            $mail->Username   = emailadmin;     
            $mail->Password   = passwordadmin;                      
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
            $mail->Port       = 587;                                    
            // $mail->SMTPDebug = 4;
            $mail->setFrom(emailadmin, 'Euroson Latino');
            $body = file_get_contents('../correos/notificacion_error.html');
           
            $body = str_replace('$mensaje', $mensaje, $body);
            $body = str_replace('$formulario', $formulario, $body);
            $body = str_replace('$fecha', $fecha, $body);

            $body = preg_replace('/\\\\/','', $body);
            // echo $bodyy;
            $mail->MsgHTML($body);
            $mail->AddAddress(emailsuperadmin);
            $mail->isHTML(true);
            
            $mail->Subject = 'Notificación de Error - #ELVDC2020';
            $mail->send();
    }

    $sesion=generate_string($permitted_chars, 4).rand(1000, 9000);
    $paymenth_method=3;


    if($_POST['idform']==='solistas'){

        var_dump($_POST);

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

        
        // $mail = new PHPMailer();
        // $mail->CharSet='UTF-8';
        // $mail->Encoding = 'base64';
        // $mail->isSMTP();                                        
        // $mail->Host       = 'smtp.gmail.com';          
        // $mail->SMTPAuth   = true;                               
        // $mail->Username   = emailadmin;     
        // $mail->Password   = passwordadmin;                     
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
        // $mail->Port       = 587;                                    
        // // $mail->SMTPDebug = 4;
        // $mail->setFrom(emailadmin, NAME_EVENT);
        // $body = file_get_contents('../correos/contentsolista.html');
        // $body = str_replace('$nombre_p', $_POST['nombre_p'], $body);            
        // $body = str_replace('$apellidos_p', $_POST['apellidos_p'], $body);
        // $body = str_replace('$email_p', $_POST['email_p'], $body);
        // $body = str_replace('$fecha_nac', $_POST['fecha_nac'], $body);
        // $body = str_replace('$pais_p', $_POST['pais_p'], $body);
        // $body = str_replace('$cod_insc', $tokenCompetidor, $body);
        // $body = str_replace('$fecha_registro', $dateregistro, $body);
        // $body = str_replace('$categoria_insc', $_POST['categoria_p'], $body);
        // $body = preg_replace('/\\\\/','', $body);

        // $body = str_replace('$year_event', YEAR_EVENT, $body);
        // $body = str_replace('$name_event', NAME_EVENT, $body);
        // $body = str_replace('$contact_event', EMAIL_EVENT_CONTACTO, $body);

        // $bodyy=$body;

        
        // // echo $bodyy;
        // $mail->MsgHTML($bodyy);
        // $mail->AddAddress($_POST['email_p'], $_POST['nombre_p'].' '.$_POST['apellidos_p']);
        // $mail->addBCC('bryan.martinez.romero@gmail.com');
        // $mail->isHTML(true);
        
        // $mail->Subject = 'Registro exitoso - '.TAG_EVENT;
        // $mail->send();

    }
    if($_POST['idform']==='parejas'){
        
        

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
            // 'num_telefono' => $_POST['num_telefono'],
            'categoria' => $_POST['categoria'],
            'idparticipante' => $tokenCompetidor,
            'dateregistro' => $dateregistro,
            'invoiceid' => $_POST['invoiceid'],
            'cupon' => $_POST['hotel_num'],
            'paymenth_method' => $paymenth_method,
            'codFullPassp1' => $_POST['codFullPassp1'],
            'codFullPassp2' => $_POST['codFullPassp2']
        ];

        

        $basededatos->connect()->prepare("INSERT INTO `tbl_parejas` (`nombre_p1`, `apellidos_p1`, `fecha_nacp1`, `email_p1`, `genero_p1`, `estado_p1`, `nombre_p2`, `apellidos_p2`, `fecha_nacp2`, `email_p2`, `genero_p2`, `estado_p2`,`cod_insc`, `fecharegistro_p`, `invoiceid`, `categoria_insc`, `num_auto`, `paymenthmethod`, `codfullpass_p1`, `codfullpass_p2`) 
        VALUES (:nombre_p1,:apellidos_p1,:date_birthday_p1,:email_p1,:genero_p1,:pais_p1,:nombre_p2,:apellidos_p2,:date_birthday_p2,:email_p2,:genero_p2,:pais_p2, :idparticipante, :dateregistro, :invoiceid, :categoria, :cupon, :paymenth_method, :codFullPassp1, :codFullPassp2)")->execute($data);

        $mail = new PHPMailer();
        $mail->CharSet='UTF-8';
        $mail->Encoding = 'base64';
            
        $mail->isSMTP();                                        
        $mail->Host       = 'smtp.gmail.com';          
        $mail->SMTPAuth   = true;                               
        $mail->Username   = emailadmin;     
        $mail->Password   = passwordadmin;                   
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
        $mail->Port       = 587;                                    
        // $mail->SMTPDebug = 4;
        $mail->setFrom(emailadmin, NAME_EVENT);
        $body = file_get_contents('../correos/contentparejas.html');
        $body = str_replace('$nombre_p1', $_POST['nombre_p1'], $body);            
        $body = str_replace('$apellidos_p1', $_POST['apellidos_p1'], $body);

        $body = str_replace('$nombre_p2', $_POST['nombre_p2'], $body);            
        $body = str_replace('$apellidos_p2', $_POST['apellidos_p2'], $body);

        $body = str_replace('$email_p1', $_POST['email_p1'], $body);
        $body = str_replace('$email_p2', $_POST['email_p2'], $body);

        $body = str_replace('$fecha_nacp1', $_POST['date_birthday_p1'], $body);
        $body = str_replace('$fecha_nacp2', $_POST['date_birthday_p2'], $body);

        $body = str_replace('$pais_p1', $_POST['pais_p1'], $body);
        $body = str_replace('$pais_p2', $_POST['pais_p2'], $body);

        $body = str_replace('$cod_insc', $tokenCompetidor, $body);
        $body = str_replace('$fecha_registro', $dateregistro, $body);
        $body = str_replace('$categoria_insc', $_POST['categoria'], $body);
        $body = str_replace('$year_event', YEAR_EVENT, $body);
        $body = str_replace('$name_event', NAME_EVENT, $body);
        $body = str_replace('$contact_event', EMAIL_EVENT_CONTACTO, $body);

        $body = preg_replace('/\\\\/','', $body);
        $bodyy=$body;
        // echo $bodyy;
        $mail->MsgHTML($bodyy);
        $mail->AddAddress($_POST['email_p1'], $_POST['nombre_p1'].' '.$_POST['apellidos_p1']);
        $mail->AddAddress($_POST['email_p2'], $_POST['nombre_p2'].' '.$_POST['apellidos_p2']);
        $mail->addBCC('bryan.martinez.romero@gmail.com');
        $mail->isHTML(true);

        $mail->Subject = 'Registro exitoso - '.TAG_EVENT;
        $mail->send();


    }
    if($_POST['idform']==='grupos'){


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
        
            
    
        try{
    
            $basededatos->connect()->prepare("INSERT INTO `tbl_grupos` (`categoria_insc`, `nom_repre`, `celular_repre`, `pais_grupo`, `email_repre`, `nom_grupo`, `integrantes`, `fecharegistro_p`, `cod_insc`, `status`, `numintegrantes`, `invoiceid`, `num_auto`, `paymenthmethod`) VALUES (:categoria_p, :nomrepresentante_p, :numtelrep, :pais, :emailrepresentante_p, :nombregrupo_p, :integrantes, :fecharegistro, :cod_insc, :stat, :numintegrantes, :invoiceid, :cupon, :paymenth_method)")->execute($salida);
            
            
            $nom_repre=$_POST['nomrepresentante_p'];
            $email_repre=$_POST['emailrepresentante_p'];
            $nom_grupo=$_POST['nombregrupo_p'];
            $pais_grupo=$_POST['pais'];
            $fecha_registro=$dateregistro;
            $cod_insc=$tokenCompetidor;
            $categoria_insc=$_POST['categoria_p'];

            $mail = new PHPMailer();
            $mail->CharSet='UTF-8';
            $mail->Encoding = 'base64';
                
            $mail->isSMTP();                                        
            $mail->Host       = 'smtp.gmail.com';          
            $mail->SMTPAuth   = true;                               
            $mail->Username   = emailadmin;     
            $mail->Password   = passwordadmin;                  
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
            $mail->Port       = 587;                                    
            // $mail->SMTPDebug = 4;
            $mail->setFrom(emailadmin, NAME_EVENT);
            $body = file_get_contents('../correos/contentgrupos.html');

            $body = str_replace('$nom_repre', $nom_repre, $body);            
            $body = str_replace('$email_repre', $email_repre, $body);

            $body = str_replace('$nom_grupo', $nom_grupo, $body);
            $body = str_replace('$pais_grupo', $pais_grupo, $body);
            $body = str_replace('$cod_insc', $cod_insc, $body);
            $body = str_replace('$fecha_registro', $fecha_registro, $body);
            $body = str_replace('$categoria_insc', $categoria_insc, $body);

            $body = str_replace('$year_event', YEAR_EVENT, $body);
            $body = str_replace('$name_event', NAME_EVENT, $body);
            $body = str_replace('$contact_event', EMAIL_EVENT_CONTACTO, $body);

            $body = preg_replace('/\\\\/','', $body);
            // $bodyy=utf8_encode($body);
            // echo $bodyy;
            $mail->MsgHTML($body);
            $mail->AddAddress($email_repre, $nom_repre);
            $mail->addBCC('bryan.martinez.romero@gmail.com');
            $mail->isHTML(true);
            
            $mail->Subject = 'Registro exitoso - '.TAG_EVENT;
            $mail->send();

        
    
        }catch( PDOException $e){
            echo $e;
        }

        
        
    }
    if($_POST['idform']==='workshops'){

        $data = [
            'nombre_p' => $_POST['nombre_p'],
            'apellidos_p' => $_POST['apellidos_p'],
            'fecha_nac' => $_POST['fecha_nac'],
            'email_p' => $_POST['email_p'],
            'pnumber_p' => $_POST['pnumber_p'],
            'genero_p' => $_POST['genero_p'],
            'pais_p' => $_POST['pais_p'],
            'notas_orden' => $_POST['notas_orden'],
            'payment_method' => 'paypal',
            'couponcode' => $_POST['couponcode'],
            'invoiceid' => $_POST['invoiceid'],
            'idform' => $_POST['idform'],
            'sesion' => $sesion
        ];
    
    
        // var_dump($data);
        try{
    
            $basededatos->connect()->prepare("INSERT INTO `tbl_ticket`(`fname`, `lname`, `datebirth`, `email`, `phonenumber`, `genero`, `pais`, `notas_orden`, `couponcode`, `invoiceid`, `paymentmethod`, `idform`, `password`) VALUES (:nombre_p, :apellidos_p, :fecha_nac, :email_p, :pnumber_p, :genero_p, :pais_p, :notas_orden, :couponcode, :invoiceid, :payment_method, :idform, :sesion)")->execute($data);

            $mail = new PHPMailer(true);
            $mail->CharSet='UTF-8';
            $mail->Encoding = 'base64';
                
            $mail->isSMTP();                                        
            $mail->Host       = 'smtp.gmail.com';          
            $mail->SMTPAuth   = true;                               
            $mail->Username   = emailadmin;     
            $mail->Password   = passwordadmin;                       
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
            $mail->Port       = 587;                                    
            // $mail->SMTPDebug = 4;
            $mail->setFrom(emailadmin, 'Euroson Latino');
            $body = file_get_contents('../correos/accessoworkshop.html');
            $body = str_replace('$email', $_POST['email_p'], $body);
            $body = str_replace('$pass', $sesion, $body);
            $body = str_replace('$link', "https://live.eurosonlatino.com.mx/log", $body);

            $body = preg_replace('/\\\\/','', $body);
            $mail->MsgHTML($body);
            //$mail->AddAddress($invoice['email']);
            $mail->AddAddress($_POST['email_p'], $_POST['nombre_p'].' '.$_POST['apellidos_p']);
            $mail->addBCC('bryan.martinez.romero@gmail.com');
            $mail->isHTML(true);

            $mail->Subject = 'Confirmación de pedido - #ELWSC2023';
            $mail->send();
    
        }catch( PDOException $e){
            echo $e;
        }
        
    }if($_POST['idform']==='tickets'){

        $data = [
            'nombre_p' => $_POST['nombre_p'],
            'apellidos_p' => $_POST['apellidos_p'],
            'fecha_nac' => $_POST['fecha_nac'],
            'email_p' => $_POST['email_p'],
            'pnumber_p' => $_POST['pnumber_p'],
            'genero_p' => $_POST['genero_p'],
            'pais_p' => $_POST['pais_p'],
            'notas_orden' => $_POST['notas_orden'],
            'payment_method' => 'paypal',
            'couponcode' => $_POST['couponcode'],
            'invoiceid' => $_POST['invoiceid'],
            'idform' => $_POST['idform'],
            'sesion' => $sesion
        ];
    
    
        // var_dump($data);
        try{
    
            $basededatos->connect()->prepare("INSERT INTO `tbl_ticket`(`fname`, `lname`, `datebirth`, `email`, `phonenumber`, `genero`, `pais`, `notas_orden`, `couponcode`, `invoiceid`, `paymentmethod`, `idform`, `password`) VALUES (:nombre_p, :apellidos_p, :fecha_nac, :email_p, :pnumber_p, :genero_p, :pais_p, :notas_orden, :couponcode, :invoiceid, :payment_method, :idform, :sesion)")->execute($data);

            $mail = new PHPMailer(true);
            $mail->CharSet='UTF-8';
            $mail->Encoding = 'base64';
                
            $mail->isSMTP();                                        
            $mail->Host       = 'smtp.gmail.com';          
            $mail->SMTPAuth   = true;                               
            $mail->Username   = emailadmin;     
            $mail->Password   = passwordadmin;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
            $mail->Port       = 587;                                    
            // $mail->SMTPDebug = 4;
            $mail->setFrom(emailadmin, 'Euroson Latino');
            $body = file_get_contents('../correos/accessostreaming.html');
            $body = str_replace('$email', $_POST['email_p'], $body);
            $body = str_replace('$link', "https://live.eurosonlatino.com.mx/log", $body);
            $body = str_replace('$pass', $sesion, $body);

            $body = preg_replace('/\\\\/','', $body);
            $mail->MsgHTML($body);
            //$mail->AddAddress($invoice['email']);
            $mail->AddAddress($_POST['email_p'], $_POST['nombre_p'].' '.$_POST['apellidos_p']);
            $mail->addBCC('bryan.martinez.romero@gmail.com');
            $mail->isHTML(true);

            $mail->Subject = 'Confirmación de pedido - #ELWSC2023';
            $mail->send();
    
        }catch( PDOException $e){
            echo $e;
        }
        
    }if($_POST['idform']==='framepic'){


        $formato = $_FILES['imagen_p']['type'];
        if($formato=='image/png'){
            $type = '.png';
        }if($formato=='image/jpeg'){
            $type = '.jpg';
        }

        $cod_insc = $_POST['cod_insc'];
        $tipocategoria = $_POST['tipocategoria'];

        $fileName = $_FILES['imagen_p']['name'];

       
        
        $nombrefile=$cod_insc.'elwsc2020_' . $fileName;
        $sourcePath = $_FILES['imagen_p']['tmp_name'];
        
        $targetPath = "../uploads/$tipocategoria/".$cod_insc.'elwsc2021_'. $fileName;
        $template = '../correos/notificacion_framepic.html';

        

        $data = [
            'cod_insc' => $cod_insc
        ];

        try{
            $codinsc=$basededatos->connect()->prepare("SELECT * FROM tbl_$tipocategoria WHERE cod_insc=:cod_insc");
            $codinsc->execute($data);
            $col=$codinsc->fetch(PDO::FETCH_ASSOC);

            
            $numfilas=$codinsc->rowCount();
            
            

            $data = array(
                'respuesta' => $numfilas,
                'filename' =>  $fileName,
                'nombrefile' => $nombrefile,
                'sourcepath' => $sourcePath
            );

            header('Content-Type: application/json');
            echo json_encode($data);
            

            if($numfilas>0){
            
                
                if($tipocategoria=='solistas'){
                    $email=$col['email_p'];
                    $nombre=$col['nombre_p'].' '.$col['apellidos_p'];
                    $pais=$col['estado_p'];
                }if($tipocategoria=='parejas'){
                    $email=$col['email_p1'].','.$col['email_p2'];
                    $nombre=$col['nombre_p1'].' y '.$col['nombre_p2'];
                    $pais=$col['estado_p1'].' | '.$col['estado_p2'];
                }if($tipocategoria=='grupos'){
                    $email=$col['email_repre'];
                    $nombre=$col['nom_grupo'];
                    $pais=$col['pais_grupo'];
                }
                $categoria_insc=$col['categoria_insc'];
                

                // var_dump($email.' | '.$nombre.' | '.$pais);

                try{

                    $carga=$basededatos->connect()->prepare("INSERT INTO `tbl_banners`(`cod_insc`, `tipocategoria`, `imagen_url`, `fecharegistro`) VALUES ('$cod_insc','$tipocategoria','$nombrefile', '$dateregistro')");
                    $carga->execute();

                    correoframepic($cod_insc, $nombre, $email, $dateregistro, $pais, $categoria_insc, $template, $tipocategoria);
                    
                    move_uploaded_file($sourcePath, $targetPath);

                    
                }catch(PDOException $e){
                    $data = array(
                        'respuesta' => 'error',
                        'mensaje' => $e
                    );
                    // header('Content-Type: application/json');
                    echo json_encode($data);
                }
                
            }

        }catch(PDOException $e){
            $data = array(
                'respuesta' => 'error',
                'mensaje' => $e
            );
            // header('Content-Type: application/json');
            echo json_encode($data);
        }

    }if($_POST['idform']==='cupon' || $_POST['idform']==='cuponcompetidores'){

        $cupon = $_POST['cupon'];
        $form = $_POST['form'];

        $data = [
            'cupon' => $cupon,
            'form' => $form
        ];

        try{
            $cupon=$basededatos->connect()->prepare("SELECT * FROM tbl_cupones WHERE cupon=:cupon and form=:form");
            $cupon->execute($data);
            $col=$cupon->fetch(PDO::FETCH_ASSOC);
            $numfilas=$cupon->rowCount();

            if($numfilas>0){
                $cupon = array(
                    'respuesta' => $numfilas,
                    'descuento' => $col['descuento'],
                    'cupon' => $_POST['cupon']
                );
            }else{
                $cupon = array(
                    'respuesta' => $numfilas
                );
            }

           

        }catch(PDOException $e){
            $cupon = array(
                'respuesta' => 'error',
                'mensaje' => $e->getMessage()
            );
        }
        header('Content-Type: application/json');
        echo json_encode($cupon);

    }if($_POST['idform']==='liquidar-pase'){


        // var_dump($_POST);
        $codigoconf = $_POST['codigoconf'];
        $form = $_POST['form'];

        try{
            $queryLiquidarPase="SELECT *, a.id id, a.status status
            FROM tbl_ticket a
            INNER JOIN tbl_pases b ON a.idform = b.codigo_pase
            WHERE password='$codigoconf'";

            $datos=$basededatosresp->connect()->prepare($queryLiquidarPase);   
            $datos->execute();
            $col=$datos->fetch(PDO::FETCH_ASSOC);
            $numfilas=$datos->rowCount();

            // var_dump($numfilas);
            

           

            if($numfilas>0){
                if($col['status']!==3){

                    $datoscodigo = array(
                        'respuesta' => $numfilas,
                        'idform' => $col['idform'],
                        'fname' => $col['fname'],
                        'lname' => $col['lname'],
                        'email' => $col['email'],
                        'invoiceid' => $col['invoiceid'],
                        'pais' => $col['pais'],
                        'password' => $col['password'],
                        'costo' => $col['session'],
                        'id' => $col['id'],
                        'idform' => $col['idform'],
                        'status' => $col['status'],
                        'descripcion_pase' => $col['descripcion_pase'],
                        'datePago' => $col['lastdate'],
                        'precio' => $col['precio'],
                        'precio_apartado' => $col['precio_apartado'],
                        'integrantes' => $col['notas_orden']
                    );
                }else{
                    $datoscodigo = array(
                        'respuesta' => 0,
                        'mensaje' => 'Ticket liquidado'
                    );
                }
            }else{
                $datoscodigo = array(
                    'respuesta' => 0,
                    'mensaje' => 'No. de confirmación incorrecto'
                );
            }
            
            // var_dump($datoscodigo);
            
            header('Content-Type: application/json; charset=utf-8');            
            echo json_encode($datoscodigo);           

        }catch(PDOException $e){
            echo $e;
        }


    }if($_POST['idform']==='liquidar'){
        
        $iduser = $_POST['iduser'];
        $idpase = $_POST['idpase'];
        $invoiceid = $_POST['invoiceid'];
        $codigoconf=$_POST['codigoconf'];

        // var_dump($_POST);

        $queryLiquidarPase="SELECT a.*, b.descripcion_pase, b.precio, b.divisa, b.precio_apartado
        FROM tbl_ticket a
        INNER JOIN tbl_pases b ON a.idform = b.codigo_pase
        WHERE password='$codigoconf'";
        $datos=$basededatosresp->connect()->prepare($queryLiquidarPase);   
        $datos->execute();
        $col=$datos->fetch(PDO::FETCH_ASSOC);

        try{

            $datos=$basededatosresp->connect()->prepare("UPDATE `tbl_ticket` SET `status`=3, `session`='liquidado', `browser`='$invoiceid' where id='$iduser'");
            $datos->execute();
           
        
            $mail = new PHPMailer(true);
            $mail->CharSet='UTF-8';
            $mail->Encoding = 'base64'; 
                
            $mail->isSMTP();                                        
            $mail->Host       = 'smtp.gmail.com';          
            $mail->SMTPAuth   = true;                               
            $mail->Username   = emailadmin;     
            $mail->Password   = passwordadmin;                      
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
            $mail->Port       = 587;                                    
            // $mail->SMTPDebug = 4;
            $mail->setFrom(emailadmin, 'Euroson Latino');

            
            $body = file_get_contents('../correos/plantillaliquidacion.html');

            $body = str_replace('$email', $col['email'], $body);
            $body = str_replace('$nombre_p', $col['fname'], $body);
            $body = str_replace('$apellidos_p', $col['lname'], $body);
            $body = str_replace('$invoiceid', $_POST['invoiceid'], $body);
            $body = str_replace('$sesion', $col['password'], $body);
            $body = str_replace('$monto', $col['precio_apartado'], $body);
            $body = str_replace('$descPase', $col['descripcion_pase'], $body);
            $body = str_replace('$datepago', $dateregistro, $body);


            $body = preg_replace('/\\\\/','', $body);
            $mail->MsgHTML($body);
            //$mail->AddAddress($invoice['email']);
            $mail->AddAddress($col['email'], $col['fname'].' '.$col['lname']);
            $mail->addBCC('bryan.martinez.romero@gmail.com');
            $mail->isHTML(true);

            $mail->Subject = 'Confirmación de pedido - #ELWSC2023';
            $mail->send();

            $datoscodigo = array(
                'respuesta' => 'success'
            );
        }catch(PDOException $e){

            $datoscodigo = array(
                'respuesta' => 'error',
                'mensaje' => $e
            );
        }

        header('Content-Type: application/json');
        echo json_encode($datoscodigo);

    }if($_POST['idform']==='registro-reservacion'){


        $numintegrantes = $_POST['huespedes_hotel'];
        $fileName = $_FILES['imagen_p']['name'];

        $hotel_num=$_POST['hotel_num'];
        $nombrefile=$hotel_num.'_elwsc2021_' . $fileName;
        $sourcePath = $_FILES['imagen_p']['tmp_name'];

        
        
        $targetPath = "../uploads/comprobantes/".$hotel_num.'_elwsc2021_'. $fileName;

        // echo $numintegrantes;
        $data = $_POST;

        $salida = array_slice($data, 0, 10);
        

        
        
        $data = array();

        for ($i=0; $i < $numintegrantes ; $i++) { 
            
            $data["nombreshuespedes".$i] = $_POST['nombreshuespedes'.$i];
            $data["apellidoshuespedes".$i] = $_POST['apellidoshuespedes'.$i];
        }

        // var_dump($data);
            
        $salida['integrantes'] = json_encode($data);
        $salida['fecharegistro'] = $dateregistro;
        $salida['num_habitaciones'] = $_POST['num_habitaciones'];
        $salida['nombre_p'] = $_POST['nombre_p'];
        $salida['apellidos_p'] = $_POST['apellidos_p'];
        $salida['pais_p'] = $_POST['pais_p'];
        $salida['fecha_entrada'] = $_POST['fecha_entrada'];
        $salida['fecha_salida'] = $_POST['fecha_salida'];
        $salida['hotel_num'] = $_POST['hotel_num'];
        $salida['email_p'] = $_POST['email_p'];
        $salida['pnumber_p'] = $_POST['pnumber_p'];
        $salida['comprobante']=$nombrefile;

        // var_dump($salida);

        $nom_resp = $_POST['nombre_p'].' '.$_POST['apellidos_p'];
        $email_resp = $_POST['email_p'];
        $pais_grupo = $_POST['pais_p'];
        $num_huespedes = $_POST['huespedes_hotel'];
        $num_habitaciones = $_POST['num_habitaciones'];
        $fecha_entrada = $_POST['fecha_entrada'];
        $fecha_salida = $_POST['fecha_salida'];
        $fecha_registro = $dateregistro;
        $template = '../correos/correoreservacion.html';

        try{
            
            $basededatos->connect()->prepare("INSERT INTO `tbl_numreservaciones`(`nombre_p`, `apellidos_p`, `email_p`, `pnumber_p`, `hotel_num`, `fecha_entrada`, `fecha_salida`, `pais_p`, `num_habitaciones`, `huespedes_hotel`, `integrantes`, `fecharegistro`, `comprobante`) VALUES (:nombre_p, :apellidos_p, :email_p, :pnumber_p, :hotel_num, :fecha_entrada, :fecha_salida, :pais_p, :num_habitaciones, :huespedes_hotel, :integrantes, :fecharegistro, :comprobante)")->execute($salida);


            correoreservacion($nom_resp, $email_resp, $pais_grupo, $num_huespedes, $num_habitaciones, $fecha_entrada, $fecha_salida, $fecha_registro, $hotel_num, $template);
            
            
            move_uploaded_file($sourcePath, $targetPath);
            $respuesta = array(
                'respuesta' => 'success'
            );

            header('Content-Type: application/json');
            echo json_encode($respuesta);
        
    
        }catch( PDOException $e){

            $respuesta = array(
                'respuesta' => $e
            );

            correoerror($e, $_POST['idform'], $fecha_registro);

            header('Content-Type: application/json');
            echo json_encode($respuesta);
        }

        
        
    }


    