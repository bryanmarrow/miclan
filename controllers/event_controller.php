<?php


    include '../api/Config/DBconfig.php';

   
    $params_controller=isset($_POST['params_controller']) ? $_POST['params_controller'] : [];
    $name_procedure_stored=$_POST['name_stored_procedure'];
    $action=isset($_POST['params_controller']) ? $params_controller['action'] : '';


    switch ($action) {
        case 'get_tickets_evento':
            $variables=$params_controller['variables'];
            $params=array(
                'tag_evento' => $variables['tag_evento']
            );

            $data_response=get_fetchalldata_procedure_store($name_procedure_stored, $params);
            header('Content-Type: application/json');  
            print json_encode($data_response, JSON_UNESCAPED_UNICODE); 
            break;             
    }

    
