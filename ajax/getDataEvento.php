<?php

    // var_dump($_POST);
    
    require('../api/Config/DBconfig.php');

    $tokenEvento=isset($_POST['tokenevento']) ? $_POST['tokenevento'] : '';

    try{
        $query="SELECT * FROM tbl_eventos where tag='$tokenEvento'";
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
