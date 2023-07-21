<?php 

    include '../api/Config/DBconfig.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../phpmailer/src/Exception.php';
    require '../phpmailer/src/PHPMailer.php';
    require '../phpmailer/src/SMTP.php';
   
   

    if(isset($_POST['tokenrecovery'])){

        $tokenRecovery=$_POST['tokenrecovery'];

        $token=base64_decode($tokenRecovery['tokenrecovery']);
        $emailusuario=base64_decode($tokenRecovery['email']);

        // var_dump($token);
        // var_dump($emailusuario);

        try{
            $query="SELECT * FROM tbl_users where email='$emailusuario' and recovery='$token'";
            $queryRecoveryPassword=$basededatos->connect()->prepare($query);
            $queryRecoveryPassword->execute();
            $numRows=$queryRecoveryPassword->rowCount();

            if($numRows>0){

                $query="UPDATE `tbl_users` SET `recovery`=null WHERE email='$emailusuario'";
                $queryUpdateRecovery=$basededatos->connect()->prepare($query);
                $queryUpdateRecovery->execute();

                $response = [
                    'respuesta' => 'success'
                ];

            }else{
                $response = [
                    'respuesta' => 'error',
                    'mensaje' => 'Código de link incorrecto'
                ];
            }


        }catch(PDOException $e){
            $response = [
                'respuesta' => 'error',
                'mensaje' => 'Favor de intentarlo más tarde'
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);

    }if(isset($_POST['recovery-email'])){
        
        $emailusuario=$_POST['recovery-email'];
        try{
            $query="SELECT * FROM tbl_users where email='$emailusuario'";
            $queryRecoveryPassword=$basededatos->connect()->prepare($query);
            $queryRecoveryPassword->execute();
            

            $numRows=$queryRecoveryPassword->rowCount();

            if($numRows>0){
                
                $col=$queryRecoveryPassword->fetch(PDO::FETCH_ASSOC);
                $nombrecompleto=$col['fname'].' '.$col['lname'];

                $tokenRecovery=rand(5000000, 9000000);

                $query="UPDATE `tbl_users` SET `recovery`='$tokenRecovery' WHERE email='$emailusuario'";
                $queryUpdateRecovery=$basededatos->connect()->prepare($query);
                $queryUpdateRecovery->execute();


                $linkrecovery='https://localhost/elwsc2021?tokenrecovery='.base64_encode($tokenRecovery).'&email='.base64_encode($emailusuario);
                    

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
                $body = file_get_contents('../correos/recoverypassword.html');

            
                $body = str_replace('$correoelectronico', $emailusuario, $body);
                $body = str_replace('$linkrecovery', $linkrecovery, $body);
                
                $body = str_replace('$year_event', YEAR_EVENT, $body);
                $body = str_replace('$name_event', NAME_EVENT, $body);

                $body = preg_replace('/\\\\/','', $body);
                // $bodyy=utf8_encode($body);
                // echo $bodyy;
                $mail->MsgHTML($body);
                $mail->AddAddress($emailusuario, $nombrecompleto);
                $mail->addBCC('bryan.martinez.romero@gmail.com');
                $mail->isHTML(true);
                
                $mail->Subject = 'Restablecer contraseña - '.TAG_EVENT;
                $mail->send();

                $response = [
                    'respuesta' => 'success'
                ];


            }else{
                $response = [
                    'respuesta' => 'error',
                    'mensaje' => ''
                ];
            }


        }catch(PDOException $e){
            $e->getMessage();
        }


        header('Content-Type: application/json');
        echo json_encode($response);
    }if(isset($_POST['newpass']) && isset($_POST['newpass1'])){
        

        if(isset($_POST['email'])){
            
            $newpassword=md5($_POST['newpass']);
            $emailusuario=base64_decode($_POST['email']);

            try{

                $query="UPDATE `tbl_users` SET `password`='$newpassword' WHERE email='$emailusuario'";
                $querynewPassword=$basededatos->connect()->prepare($query);
                $querynewPassword->execute();

                $response = [
                    'respuesta' => 'success'
                ];

            }catch(PDOException $e){
                $response = [
                    'respuesta' => 'error',
                    'mensaje' => 'Error, intente mas tarde'
                ];
            }
            
            
            
        }else{
            $response = [
                'respuesta' => 'error',
                'mensaje' => 'Error'
            ];
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
        // var_dump($response);
        
    }

