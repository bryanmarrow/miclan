<?php
   

    // var_dump($_POST);
    require('../api/Config/DBconfig.php');
    
    $fechaRegistro=date("Y-m-d H:i:s");
    $infoEvento=getInfoEvento($tokenEvento);
    $status_orden=0; // Status Pendiente
    $cuponcode=isset($_POST['couponcode']) ? $_POST['couponcode'] : '';

    
    $invoiceid=$infoEvento['tag'].'-'.generateRandomString();
    $datosPase=json_decode($_POST['datosPase']);

    $idform=$datosPase->idform;
    
    
    $dataCostos=getCostosTotales($idform, $datosPase->status_apartado, $cuponcode, 'acceso', 1);

    $integrantes=json_decode($datosPase->integrantes);

    
    $statusApartado=$datosPase->status_apartado==0 ? 1 : 0;

    
    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
    foreach($integrantes as $key => $row){
        
        $tokenOrden=generate_string($permitted_chars, 8).rand(10000000, 90000000);

        if($key==0){

            $titularNombre=$row[0];
            $titularApellidos=$row[1];
            $titularEmail=$row[2];
            $titularTelefono=$row[5];
            $titularPais=$row[3];
            $notasOrden=$_POST['notas_orden'];

            $dataOrder=array(
                'invoiceid' => $invoiceid,
                'fechaRegistro' => $fechaRegistro,
                'titularNombre' => $titularNombre,
                'titularApellidos' => $titularApellidos,
                'titularEmail' => $titularEmail,
                'titularTelefono' => $titularTelefono,
                'titularPais' => $titularPais,
                'notas_orden' => $notasOrden,
                'status_orden' => $status_orden,
                'idEvento' => $infoEvento['id']
            );

            $dataLog = [
                'tokenTicket' => $invoiceid,
                'status_ticket' => $status_orden,
                'fechaLog' => $fechaRegistro
            ];
           

            try{
                $queryAddOrden="INSERT INTO `tbl_compras`(
                `invoiceid`, `fechaRegistro`, `nombre`, `apellidos`, `email`, `telefono`, `pais`, `notas_orden`, `status`, `idEvento`) 
                VALUES (:invoiceid, :fechaRegistro, :titularNombre, :titularApellidos, :titularEmail, :titularTelefono, :titularPais, :notas_orden, :status_orden, :idEvento)";
                $queryAddOrdenExe=$basededatos->connect()->prepare($queryAddOrden);
                $queryAddOrdenExe->execute($dataOrder);

                $basededatos->connect()->prepare("INSERT INTO `tbl_data_compra`(`ipaddress`, `browser`, `dispositivo`, `invoiceid`) 
                VALUES ('".$ipAddress."', '".$navegador."', '".$dispositivo."', '".$invoiceid."')")->execute();

                $basededatos->connect()->prepare("INSERT INTO `tbl_log_status_tickets`(`token_ticket`, `status_ticket`, `fechalog`) 
                VALUES (:tokenTicket, :status_ticket, :fechaLog)")->execute($dataLog);

                $resultados=array(
                    'respuesta' => 'success',
                    'invoiceid' => $invoiceid,
                    'datosPase' => $dataCostos
                );

            }catch(PDOException $e){
                $resultados=array(
                    'respuesta' => 'error',
                    'mensaje' => $e->getMessage()
                );
            }
        }

        $dataintegrante = [
            'nombre_p' => $row[0],
            'apellidos_p' =>$row[1],
            'email_p' => $titularEmail,
            'pais_p' => $titularPais,
            'invoiceid' => $invoiceid,
            'idform' => $idform,
            'tokenOrden' => $tokenOrden,
            'phone_number' => $_POST['pnumber_p'],
            'statusPago' =>  $status_orden,
            'status_apartado' => $statusApartado
        ];

        

        try{

            $basededatos->connect()->prepare("INSERT INTO `tbl_ordenes`(`fname`, `lname`, `email`,`pais`, `invoiceid`, `idform`, `token`, `phonenumber`, `status`, `status_apartado`) 
            VALUES (:nombre_p, :apellidos_p, :email_p, :pais_p, :invoiceid, :idform, :tokenOrden, :phone_number, :statusPago, :status_apartado)")->execute($dataintegrante);

            $respuesta = array(
                'respuesta' => 'success'
            );

        }catch( PDOException $e){
            $respuesta = array(
                'respuesta' => 'error',
                'mensaje' => $e->getMessage()
            );
        }
        
    }

    // var_dump($resultados);

    header('Content-Type: application/json');
    echo json_encode($resultados);
