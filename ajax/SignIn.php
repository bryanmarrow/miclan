<?php


    // var_dump($_POST);
    require('../api/Config/DBconfig.php');

    // session_start();
    // use PHPMailer\PHPMailer\PHPMailer;
    // use PHPMailer\PHPMailer\Exception;

    // require '../phpmailer/src/Exception.php';
    // require '../phpmailer/src/PHPMailer.php';
    // require '../phpmailer/src/SMTP.php';

    
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    

    try{
        $querygetUsuario="SELECT id, email, password, status from tbl_users where email='$email' and password='$password'";
        $getUsuario=$basededatos->connect()->prepare($querygetUsuario);
        $getUsuario->execute();
        $numRows=$getUsuario->rowCount();
        $col=$getUsuario->fetch(PDO::FETCH_ASSOC);

        
        if($numRows>0){


            $querygetUsuario="SELECT tbl_users.id, tbl_users.email, tbl_users.status, tbl_users.password, tbl_savecarrito.dataCarrito from tbl_users 
            LEFT JOIN tbl_savecarrito ON tbl_users.id = tbl_savecarrito.user_id
            where tbl_users.email='$email' and tbl_users.password='$password'";
            $getUsuario=$basededatos->connect()->prepare($querygetUsuario);
            $getUsuario->execute();
            $numRows=$getUsuario->rowCount();
            
            $dataUsuario=$getUsuario->fetch(PDO::FETCH_ASSOC);
          
            if($col['status']==0){
                $response = [
                    'respuesta' => 'error',
                    'mensaje' => 'Usuario no ha confirmado su registro'
                ];
            }if($col['status']==1){
                $urlback = isset($_SESSION['urlback']) ? $_SESSION['urlback'] : NULL ;

                $response = [
                    'respuesta' => 'success',
                    'urlback' => $urlback,
                    'dataCarrito' => $dataUsuario['dataCarrito']
                ];

                $_SESSION['idUserSession'] = $col['id'];
                $_SESSION['status'] = 1;

            }
            if($col['status']==2){
                $response = [
                    'respuesta' => 'error',
                    'mensaje' => 'Usuario inactivo, favor de contactar al administrador <a href="mailto:info@eurosonlatino.com.mx">info@eurosonlatino.com.mx</a>'
                ];
            }
            
        }if($numRows==0){
            $querygetUsuario="SELECT email, password from tbl_users where email='$email'";
            $getUsuario=$basededatos->connect()->prepare($querygetUsuario);
            $getUsuario->execute();
            $numRows=$getUsuario->rowCount();

            // var_dump($numRows);
            if($numRows==1){
                $response = [
                    'respuesta' => 'password',
                    'mensaje' => 'Contraseña incorrecta'
                ];
            }if($numRows==0){
                $response = [
                    'respuesta' => 'error',
                    'mensaje' => 'Usuario no existe'
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
    
    header('Content-Type: application/json');
    echo json_encode($response);





?>