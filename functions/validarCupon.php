<?php


    require('../api/Config/DBconfig.php');
    $cupon = $_POST['codigo_cupon'];
    $form = $_POST['idform'];

    $data = [
        'cupon' => $cupon,
        'form' => $form
    ];

    try{
        $querycupon=$basededatos->connect()->prepare("SELECT * FROM tbl_cupones WHERE cupon=:cupon and form=:form");
        $querycupon->execute($data);
        $col=$querycupon->fetch(PDO::FETCH_ASSOC);
        $numfilas=$querycupon->rowCount();

        if($numfilas>0){
            $cupon = array(
                'respuesta' => 1,
                'descuento' => floatval($col['descuento']),
                'cupon' =>  $cupon
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