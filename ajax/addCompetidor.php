<?php

    require('../api/Config/DBconfig.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../phpmailer/src/Exception.php';
    require '../phpmailer/src/PHPMailer.php';
    require '../phpmailer/src/SMTP.php';


    date_default_timezone_set('America/Mexico_City');
    $idparticipante=rand(200000, 900000);
    $dateregistro=date("Y-m-d H:i:s");

    $rand=rand(1000, 9000);
    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';    
    $randalf=generate_string($permitted_chars, 4);
    $tokenCompetidor=$randalf.$rand;


    $userclient_id=$_SESSION['idUserSession'];
    
    $tokenCompetidorv2=generate_string($permitted_chars, 10);
    $registroCompetidor=$_POST;
    $registroCompetidor['dateregistro']=$dateregistro;
    $registroCompetidor['idcompetidor']=$tokenCompetidorv2;
    unset($registroCompetidor['idform']);

    try{
        $query="INSERT INTO `tbl_competidores`(`fname`, `lname`, `fechanac`, `genero`, `country`, `fecharegistro`, `idcompetidor`) 
        VALUES (:nombre_p, :apellidos_p, :fecha_nac, :genero_p, :pais_p, :dateregistro, :idcompetidor)";
        $queryAddCompetidor=$basededatos->connect()->prepare($query);
        $queryAddCompetidor->execute($registroCompetidor);

        $queryLog="INSERT INTO `tbl_competidores_users_id`(`idcompetidor`, `user_id`, `fecharegistro`) VALUES ('$tokenCompetidorv2', '$userclient_id', '$dateregistro')";
        $queryLogCompetidor=$basededatos->connect()->prepare($queryLog);
        $queryLogCompetidor->execute();


        $response = [
            'respuesta' => 'success',
            'mensaje' => 'Registro exitoso'
        ];
    }catch(PDOException $e){
        
        $response = [
            'respuesta' => 'error',
            'mensaje' => 'Error en el registro, por favor intente mas tarde',
            'mensajesql' => $e->getMessage()
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);