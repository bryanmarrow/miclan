<?php
    
    $invoiceid = $_POST['codigoConf'];
    // $form = $_POST['form'];

    require('../api/Config/DBconfig.php');

    try{


        $queryCompra="SELECT 
        tbl_compras.nombre,
        tbl_compras.apellidos,
        tbl_compras.email,
        tbl_compras.invoiceid,
        tbl_status_pases.tagHtml,
        tbl_compras.fechaRegistro,
        tbl_compras.status
        FROM tbl_compras 
        INNER JOIN tbl_status_pases ON tbl_compras.status = tbl_status_pases.id
        WHERE tbl_compras.invoiceid='$invoiceid'";
        $queryCompraExe=$basededatos->connect()->prepare($queryCompra);
        $queryCompraExe->execute();

        $queryLiquidarPase="SELECT *
        FROM tbl_compras
        INNER JOIN tbl_ordenes ON tbl_compras.invoiceid = tbl_ordenes.invoiceid
        INNER JOIN tbl_pases ON tbl_ordenes.idform = tbl_pases.id
        WHERE tbl_compras.invoiceid='$invoiceid'";

        $datos=$basededatos->connect()->prepare($queryLiquidarPase);   
        $datos->execute();
        
        $integrantes=$datos->fetchAll(PDO::FETCH_ASSOC);

        $numfilas=$datos->rowCount();

        $dataCompra=$queryCompraExe->fetch(PDO::FETCH_ASSOC);

        if($numfilas>0){
            if($dataCompra['status']==0 || 5){
                $datoscodigo = array(
                    'respuesta' => $numfilas,
                    'dataCompra' => $dataCompra,
                    'integrantes' => $integrantes
                );
            }else{
                $datoscodigo = array(
                    'respuesta' => 0,
                    'mensaje' => 'Ticket liquidado'
                );
            }                  
        }else{
            $datoscodigo = array(
                'respuesta' => 0,
                'mensaje' => 'No. de confirmación incorrecto'
            );
        }   

                      

    }catch(PDOException $e){
        echo $e;
    }

    header('Content-Type: application/json');
    echo json_encode($datoscodigo);