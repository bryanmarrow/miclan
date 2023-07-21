<?php


    // var_dump($_POST);
    require('../api/Config/DBconfig.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../phpmailer/src/Exception.php';
    require '../phpmailer/src/PHPMailer.php';
    require '../phpmailer/src/SMTP.php';

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $emailusuario = $_POST['email'];
    $birthday = $_POST['birthday'];
    $genre= $_POST['genre'];
    $password = md5($_POST['password']);
    date_default_timezone_set('America/Mexico_City');
    $dateregistro=date("Y-m-d H:i:s");

    $token=strtoupper(generar_token_seguro(15));
    $country=$_POST['country'];

    try{
        $querygetUsuario="SELECT email from tbl_users where email='$emailusuario'";
        $getUsuario=$basededatos->connect()->prepare($querygetUsuario);
        $getUsuario->execute();
        $numRows=$getUsuario->rowCount();

        // var_dump($numRows);
        
        if($numRows>=1){
            $response = [
                'respuesta' => 'errorEmail',
                'mensaje' => 'Email existente'
            ];
        }if($numRows==0){

            $data = [
                'fname' => $fname,
                'lname' => $lname,
                'email' => $emailusuario,
                'pass' => $password,
                'genre' => $genre,
                'birthday' => $birthday,
                'token' => $token,
                'country' => $country,
                'fecharegistro' => $dateregistro
            ];
        
            try{

                $queryinsertUsuario="INSERT INTO tbl_users 
                (`fname`, `lname`, `email`, `password`, `genre`, `birthday`, `token`, `country`, `fecharegistro`) 
                VALUES (:fname, :lname, :email, :pass, :genre, :birthday, :token, :country, :fecharegistro)";
                $insertUsuario=$basededatos->connect()->prepare($queryinsertUsuario);
                $insertUsuario->execute($data);

                $nombrecompleto=$fname.' '.$lname;
                
                $linkconfirmacion='https://localhost/elwsc2021/confirmarregistro?token='.base64_encode($token).'&email='.base64_encode($emailusuario);
                

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
                $body = file_get_contents('../correos/confirmacionemail.html');

                $body = str_replace('$nombrecompleto', $nombrecompleto, $body);            
                $body = str_replace('$emailusuario', $emailusuario, $body);
                $body = str_replace('$fechaderegistro', $dateregistro, $body);
                $body = str_replace('$linkconfirmacion', $linkconfirmacion, $body);
                
                $body = str_replace('$year_event', YEAR_EVENT, $body);
                $body = str_replace('$name_event', NAME_EVENT, $body);

                $body = preg_replace('/\\\\/','', $body);
                // $bodyy=utf8_encode($body);
                // echo $bodyy;
                $mail->MsgHTML($body);
                $mail->AddAddress($emailusuario, $nombrecompleto);
                $mail->addBCC('bryan.martinez.romero@gmail.com');
                $mail->isHTML(true);
                
                $mail->Subject = 'Confirmación de Registro - '.TAG_EVENT;
                $mail->send();
        
                $response = [
                    'respuesta' => 'success'
                ];
        
            }catch(PDOException $e){
                $response = [
                    'respuesta' => 'error',
                    'mensaje' => $e->getMessage()
                ];
            }
        }

    }catch(PDOException $e){
        $response = [
            'respuesta' => 'errorsql',
            'mensaje' => $e->getMessage()
        ];
        // var_dump($e->getMessage());
    }

    // var_dump($response);
    
    header('Content-Type: application/json');
    echo json_encode($response);





?>