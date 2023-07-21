<?php

    require('../api/Config/DBconfig.php');

    $tipo=isset($_POST['tipo']) ? $_POST['tipo'] : '';
    
    function getFetchAllData($proc_stored){
        
        global $basededatos;

        try{
            $queryProcedimiento="CALL $proc_stored()";
            $getDataProc=$basededatos->connect()->prepare($queryProcedimiento);
            $getDataProc->execute();

            $dataresponse=array(
                'respuesta' => 'success',
                'data' => $getDataProc->fetchAll(PDO::FETCH_ASSOC),
                'num_results' => $getDataProc->rowCount()
            );
        }catch(PDOException $e){
            $dataresponse=array(
                'respuesta' => 'error',
                'mensaje' => $e->getMessage()
            );
        }     

        return $dataresponse;
    }


    switch ($tipo) {
        case 'getCountries':            
            $dataresponse=getFetchAllData('proc_get_countries');
            header('Content-Type: application/json');  
            break;
        
        default:
            # code...
            break;
    }

    print json_encode($dataresponse, JSON_UNESCAPED_UNICODE); 