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
    function generate_string($input, $strength = 16) {
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];  
            $random_string .= $random_character;
        }

        return $random_string;
    }

    // echo generate_string($permitted_chars, 4);
    $randalf=generate_string($permitted_chars, 5);
    $sesion=$randalf.$rand;
    $payment_method = 'transferencia';
    $status = 1;



    if($_POST['idform']==='solistas'){

        $data = [
            'nombre_p' => $_POST['nombre_p'],
            'apellidos_p' => $_POST['apellidos_p'],
            'fecha_nac' => $_POST['fecha_nac'],
            'email_p' => $_POST['email_p'],            
            'genero_p' => $_POST['genero_p'],
            'pais_p' => $_POST['pais_p'],
            // 'num_telefono' => $_POST['num_telefono'],
            'categoria_p' => $_POST['categoria_p'],
            'idparticipante' => $idparticipante,
            'dateregistro' => $dateregistro,
            'invoiceid' => $_POST['invoiceid'],
            'cupon' => $_POST['hotel_num'],
            'payment_method' => $payment_method,
            'status' => $status
        ];

        // var_dump($data);

        try{


            $basededatos->connect()->prepare("INSERT INTO `tbl_solistas`( `nombre_p`, `apellidos_p`, `fecha_nac`, `categoria_insc`, `genero_p`, `estado_p`, `fecharegistro_p`, `cod_insc`, `invoiceid`, `email_p`, `num_auto`, `paymenthmethod`, `status`) VALUES ( :nombre_p, :apellidos_p, :fecha_nac, :categoria_p, :genero_p, :pais_p, :dateregistro, :idparticipante, :invoiceid, :email_p, :cupon, :payment_method, :status)")->execute($data);

            $datoscodigo = array(
                'respuesta' => 'success'
            );
    
            
            header('Content-Type: application/json');
            echo json_encode($datoscodigo);

        }catch(PDOException $e){

            // echo $e;

            $datoscodigo = array(
                'respuesta' => 'error',
                'error' => $e
            );

            header('Content-Type: application/json');
            echo json_encode($datoscodigo);

        }

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
            'idparticipante' => $idparticipante,
            'dateregistro' => $dateregistro,
            'invoiceid' => $_POST['invoiceid'],
            'cupon' => $_POST['hotel_num'],
            'payment_method' => $payment_method,
            'status' => $status
        ];

        try{

            $basededatos->connect()->prepare("INSERT INTO `tbl_parejas` (`nombre_p1`, `apellidos_p1`, `fecha_nacp1`, `email_p1`, `genero_p1`, `estado_p1`, `nombre_p2`, `apellidos_p2`, `fecha_nacp2`, `email_p2`, `genero_p2`, `estado_p2`,`cod_insc`, `fecharegistro_p`, `invoiceid`, `categoria_insc`, `num_auto`, `paymenthmethod`, `status`) 
            VALUES (:nombre_p1,:apellidos_p1,:date_birthday_p1,:email_p1,:genero_p1,:pais_p1,:nombre_p2,:apellidos_p2,:date_birthday_p2,:email_p2,:genero_p2,:pais_p2, :idparticipante, :dateregistro, :invoiceid, :categoria, :cupon, :payment_method, :status)")->execute($data);

            
            $datoscodigo = array(
                'respuesta' => 'success'
            );
            header('Content-Type: application/json');
            echo json_encode($datoscodigo);

        }catch(PDOException $e){

            // echo $e;

            $datoscodigo = array(
                'respuesta' => 'error',
                'error' => $e
            );

            header('Content-Type: application/json');
            echo json_encode($datoscodigo);

        }


       

       


    }
    if($_POST['idform']==='grupos'){


        $numintegrantes = $_POST['numintegrantes'];

        // echo $numintegrantes;
        $data = $_POST;

        $salida = array_slice($data, 0, 7);
        
        $data = array();

        for ($i=0; $i < $numintegrantes ; $i++) { 
            
            $data["idnumintegrantes".$i] = $_POST['idnumintegrantes'.$i];
            $data["date_birthday".$i] = $_POST['date_birthday'.$i];
            $data["generoint".$i] = $_POST['generoint'.$i];
        }
            
           

        $salida['integrantes'] = json_encode($data);
        $salida['fecharegistro'] = $dateregistro;
        $salida['cod_insc'] = $idparticipante;
        $salida['invoiceid'] = $_POST['invoiceid'];
        $salida['cupon'] = $_POST['hotel_num'];
        $salida['paymenth_method'] = $payment_method;
        $salida['status'] = $status;

        // var_dump($salida);
           
        

        try{


            $basededatos->connect()->prepare("INSERT INTO `tbl_grupos`(`categoria_insc`, `nom_repre`, `celular_repre`, `pais_grupo`, `email_repre`, `nom_grupo`, `integrantes`, `fecharegistro_p`, `cod_insc`, `numintegrantes`, `invoiceid`, `num_auto`, `paymenthmethod`, `status`) VALUES (:categoria_p, :nomrepresentante_p, :numtelrep, :pais, :emailrepresentante_p, :nombregrupo_p, :integrantes, :fecharegistro, :cod_insc, :numintegrantes, :invoiceid, :cupon, :paymenth_method, :status)")->execute($salida);
            
        //     // $nom_repre=$_POST['nomrepresentante_p'];
        //     // $email_repre=$_POST['emailrepresentante_p'];
        //     // $nom_grupo=$_POST['nombregrupo_p'];
        //     // $pais_grupo=$_POST['pais'];
        //     // $fecha_registro=$dateregistro;
        //     // $cod_insc=$idparticipante;
        //     // $categoria_insc=$_POST['categoria_p'];

            
            $datoscodigo = array(
                'respuesta' => 'success'
            );
    
            
            header('Content-Type: application/json');
            echo json_encode($datoscodigo);
        

        }catch(PDOException $e){


            $datoscodigo = array(
                'respuesta' => 'error',
                'error' => $e
            );

            header('Content-Type: application/json');
            echo json_encode($datoscodigo);
            // echo $e;
        }

        
        
    }

?>