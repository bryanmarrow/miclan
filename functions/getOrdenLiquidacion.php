<?php

    require('../api/Config/DBconfig.php');    

    $codigoconf=$_POST['codigoconf'];

    // $query="SELECT * FROM tbl_pases where codigo_pase='$idPase'";
    $query="SELECT * FROM tbl_compras
    INNER JOIN tbl_ordenes ON tbl_compras.invoiceid = tbl_ordenes.invoiceid
    INNER JOIN tbl_pases ON tbl_ordenes.idform = tbl_pases.id
    WHERE tbl_compras.invoiceid='$codigoconf'";
    $queryExe=$basededatos->connect()->prepare($query);
    $queryExe->execute();

    $dataPase=$queryExe->fetch();
    $infoEvento=getInfoEvento($tokenEvento);
    $invoiceid=$infoEvento['tag'].'-'.generateRandomString();

    $tax=$comisionPaypal['value'];
    $tipoCambio=$tipoCambioDollar['value'];
    $divisaPase='MXN';

    if($queryExe->rowCount()>0){
        
        $precioPase=$dataPase['precio']*$dataPase['maxPases']*$tipoCambio;
        $precioPaseApartado=$dataPase['precio_apartado']*$dataPase['maxPases']*$tipoCambio;


        $subtotal=$precioPase-$precioPaseApartado;
        $comisionPase=$subtotal*$tax;
        $precioTotal=$subtotal+$comisionPase;
        

       

        $costosTotales=array(
            'precioPase' => $subtotal,
            'comisionPase' => $comisionPase,
            'precioTotal' => $precioTotal,
            'nombreticket' => $dataPase['descripcion_pase'],
            'divisaPase' => $divisaPase,
            'sku' => $dataPase['codigo_pase'],
            'resultados' => $queryExe->rowCount(),
            'invoiceid' => $invoiceid
        );
    }if($queryExe->rowCount()==0){
        $costosTotales=array(
            'resultados' => $queryExe->rowCount(),
        );
    }


    // var_dump($costosTotales);
    header('Content-Type: application/json');
    echo json_encode($costosTotales);
