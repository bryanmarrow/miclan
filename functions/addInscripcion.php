<?php
    
    // var_dump($_POST);
    require('../api/Config/DBconfig.php');


    $tipoform=isset($_POST['form']) ? $_POST['form'] : '';
    $idform=isset($_POST['idform']) ? $_POST['idform'] : '';
    $codFullPass=isset($_POST['codFullPass']) ? $_POST['codFullPass'] : '';
    $hotel_num=isset($_POST['hotel_num']) ? $_POST['hotel_num'] : '';
    $notas_orden=isset($_POST['notas_orden']) ? $_POST['notas_orden'] : '';
    
    $cupon=isset($_POST['cupon']) ? $_POST['cupon'] : '';
    
    $datosPase=json_decode($_POST['datosPase']);
    $status=$datosPase->status_apartado;
    $form=$datosPase->idform;
   
    $dataCostos=getCostosInscripcion($form, $status, $hotel_num);
    $fechaRegistro=date("Y-m-d H:i:s");
    $infoEvento=getInfoEvento($tokenEvento);
    $status_orden=0; // Status Pendiente
    $invoiceid=$infoEvento['tag'].'-'.generateRandomString();

    $resultados=array(
        'respuesta' => 'success',
        'invoiceid' => $invoiceid,
        'datosPase' => $dataCostos
    );
    
    // var_dump($resultados);

    header('Content-Type: application/json');
    echo json_encode($resultados);
