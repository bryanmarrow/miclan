<?php

    require('../api/Config/DBconfig.php');

    $action=isset($_POST['action']) ? $_POST['action'] : '';

    function updateData($proc_stored, $arrayparams){           
        global $basededatos;

        try{                   
            $queryProcedimiento="CALL $proc_stored('".implode("','",$arrayparams)."')";                       
            $getDataProc=$basededatos->connect()->prepare($queryProcedimiento);                        
            $getDataProc->execute();

            $dataresponse=array(
                'respuesta' => 'success'                
            );
        }catch(PDOException $e){
            $dataresponse=array(
                'respuesta' => 'error',
                'mensaje' => $e->getMessage()
            );
        }     

        return $dataresponse;
    }


    switch ($action) {
        case 'editAccount':
            $img_base64=NULL;
            if($_FILES['img_new_avatar']['size']>0){
                $path=$_FILES['img_new_avatar']['tmp_name'];
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $img_base64 =  base64_encode($data);                
            }                              
            $dataParams=array(
                'id_user' => $_SESSION['idUserSession'],
                'fname'   => $_POST['fname'],
                'lname' => $_POST['lname'],
                'email' => $_POST['email'],
                'country' => intval($_POST['country']),
                'city' => $_POST['city'],
                'phonenumber' => $_POST['phonenumber'],
                'avatar' => $img_base64
            );
            $dataresponse=updateData('proc_edit_account', $dataParams);
            header('Content-Type: application/json');  
            break;        
        default:
            # code...
            break;
    }

    print json_encode($dataresponse, JSON_UNESCAPED_UNICODE); 