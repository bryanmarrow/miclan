<?php


    require('../api/Config/DBconfig.php');


    if(isset($_POST['token']) && isset($_POST['email'])){

        $token=base64_decode($_POST['token']);
        $email=base64_decode($_POST['email']);

        // var_dump($token);
        // var_dump($email);

        $query="SELECT * FROM tbl_users where email='$email'";
        $queryValidacionUsuario=$basededatos->connect()->prepare($query);
        $queryValidacionUsuario->execute();

        $numRows=$queryValidacionUsuario->rowCount();

        // var_dump($numRows);

        if($numRows>0){

            $query="SELECT * FROM tbl_users where email='$email' and status=0";
            $queryValidacionUsuario=$basededatos->connect()->prepare($query);
            $queryValidacionUsuario->execute();

            $numRows=$queryValidacionUsuario->rowCount();

            if($numRows>0){
                try{
                
                    $query="UPDATE `tbl_users` SET `status`=1 WHERE token='$token' and email='$email'";
                    $queryConfirmacion=$basededatos->connect()->prepare($query);
                    $queryConfirmacion->execute();
    
                    $response = [
                        'respuesta' => 'success',
                        'mensaje' => 'Registro confirmado con exito'
                    ];
    
                }catch(PDOException $e){
                    $response = [
                        'respuesta' => 'error',
                        'mensaje' => $e->getMessage()
                    ];
                }
            }else{
                $response = [
                    'respuesta' => 'error',
                    'mensaje' => 'Su registro ya fue confirmado anteriormente'
                ];
            }
        }else{
            $response = [
                'respuesta' => 'error',
                'mensaje' => 'Error'
            ];
        }
    }else{
        $response = [
            'respuesta' => 'error',
            'mensaje' => 'Usuario no existe'
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);