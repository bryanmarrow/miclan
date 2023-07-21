<?php

    
    require('../api/Config/DBconfig.php');

    try{
        $query="SELECT * FROM tbl_eventos where token='$tokenEvento'";
        $queryExe=$basededatos->connect()->prepare($query);
        $queryExe->execute();


        $respuesta = array(
            'respuesta' => 'success',
            'data' => $queryExe->fetch(PDO::FETCH_ASSOC)
        );
    }catch(PDOException $e){
        $respuesta = array(
            'respuesta' => 'error',
            'mensaje' => $e->getMessage()
        );
    }

    header('Content-Type: application/json');
    echo json_encode($respuesta);
