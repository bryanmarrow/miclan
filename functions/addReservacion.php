<?php 

    // var_dump($_POST);

    require('../api/Config/DBconfig.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../phpmailer/src/Exception.php';
    require '../phpmailer/src/PHPMailer.php';
    require '../phpmailer/src/SMTP.php';


    date_default_timezone_set('America/Mexico_City');
    $dateregistro=date("Y-m-d H:i:s");
     $rand=rand(1000, 9000);
    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    function generate_string($input, $strength = 16) {
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];  
            $random_string .= $random_character;
        }
    
        return $random_string;
    }
    $randalf=generate_string($permitted_chars, 4);
    $token=$randalf.$rand;


    $allintegrantes=array_slice($_POST, 13, count($_POST));


    $integrantes=array_chunk($allintegrantes, 2, true);

   

    $carpetaReservacion = "../uploads/comprobantes_2022/".$token;
    if (!file_exists($carpetaReservacion)) {
        mkdir($carpetaReservacion, 0777, true);
    }

    $comprobante_reservacion=$_FILES['imagen_p']['name'];
    $extension = pathinfo($comprobante_reservacion, PATHINFO_EXTENSION);
    $nombrefile=$token.'_elwsc2022_comprobantepago.' .$extension;
    $sourcePath = $_FILES['imagen_p']['tmp_name'];
    $targetPath = $carpetaReservacion.'/'.$nombrefile;

    $infoTitular=array_slice($_POST, 0, 13);
    $infoTitular['token']=$token;
    $infoTitular['comprobantep_reservacion']=$nombrefile;
    $infoTitular['fecha_registro']=$dateregistro;



    $nom_resp = $infoTitular['nombre_p'].' '.$infoTitular['apellidos_p'];
    $email_resp = $infoTitular['email_p'];
    $pais_grupo = $infoTitular['pais_p'];
    $num_huespedes = $infoTitular['huespedes_hotel'];
    $num_habitaciones = $infoTitular['num_habitaciones'];
    $fecha_entrada = $infoTitular['fecha_entrada'];
    $fecha_salida = $infoTitular['fecha_salida'];
    $fecha_registro = $dateregistro;
    $hotel_num=$infoTitular['hotel_num'];
    $template = '../correos/correoreservacion.html';


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

        $mail->Subject = 'Confirmación de registro de reservación - #ELWSC2023';
        $mail->send();
    }
    

    try{

        $query="INSERT INTO `tbl_reservaciones`(`nombre_p`, `apellidos_p`, `email_p`, `pnumber_p`, `pais_p`, `agencia`, `hotel_num`, `fecha_entrada`, `fecha_salida`, `num_habitaciones`, `huespedes_hotel`, `token`, `comprobantep_reservacion`, `fecha_registro`, `aerolinea`, `fecha_vuelo`) 
        VALUES (:nombre_p, :apellidos_p, :email_p, :pnumber_p, :pais_p, :agencia, :hotel_num, :fecha_entrada, :fecha_salida, :num_habitaciones, :huespedes_hotel, :token, :comprobantep_reservacion, :fecha_registro, :aerolinea, :fecha_vuelo)";
        $result=$basededatos->connect()->prepare($query);
        $result->execute($infoTitular);

        move_uploaded_file($sourcePath, $targetPath);    

        $respuesta=true;

    }catch(PDOException $e){
        echo $e->getMessage();

        $respuesta=false;
    }

    if($respuesta){
        $log=[];
        $logErrores=[];
        foreach($integrantes as $numintegrante => $int){

        
            
            $pasaporte='pasaporteIntegrante'.$numintegrante;
            $filename=$_FILES[$pasaporte]['name'];
            $int[$pasaporte]=$filename;

            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $nombrefile=$token.'_'.$pasaporte.'_elwsc2022.' .$ext;
            $sourcePath = $_FILES[$pasaporte]['tmp_name'];
            $targetPath = $carpetaReservacion.'/'.$nombrefile;

            

            $data=[
                'nom_integrante' => $int['nombreshuespedes'.$numintegrante],
                'apellidos_integrante' => $int['apellidoshuespedes'.$numintegrante],
                'pasaporte_integrante' => $nombrefile,
                'token_huesped' => $token
            ];

            try{
                $query='INSERT INTO `tbl_huespedes`(`nom_integrante`, `apellidos_integrante`, `pasaporte_integrante`, `token_huesped`) 
                VALUES (:nom_integrante, :apellidos_integrante, :pasaporte_integrante, :token_huesped)';
                $result=$basededatos->connect()->prepare($query);
                $result->execute($data);

                move_uploaded_file($sourcePath, $targetPath);    

                $response = 'success';

                array_push($log, $response);
            }catch(PDOException $e){

                $respuestaError=$e->getMessage();

                $response = array(
                    'respuesta' => 'error',
                    'mensaje' => $respuestaError
                );

                
                
                array_push($logErrores, $response);
            }

           

            

        }

        if(count($integrantes)==count($log)){
            $respuestaServer = array(
                'respuesta' => 'success',
            );

            correoreservacion($nom_resp, $email_resp, $pais_grupo, $num_huespedes, $num_habitaciones, $fecha_entrada, $fecha_salida, $fecha_registro, $hotel_num, $template);

        }else{
            $respuestaServer = array(
                'respuesta' => 'error',
                'logs' => $logErrores
            );
        }
        
        header('Content-Type: application/json');
        echo json_encode($respuestaServer);
    }
    

   