<?php

    require('../api/Config/DBconfig.php');

    $dateRegistro=date("Y-m-d H:i:s");

    

    if(isset($_SESSION['idUserSession'])){
        $user_id=$_SESSION['idUserSession'];

        if(isset($_POST['infoPases'])){
    
            $queryExisteCarrito="SELECT * FROM tbl_savecarrito where user_id='".$user_id."'";
            $CarritoExiste=$basededatos->connect()->prepare($queryExisteCarrito);
            $CarritoExiste->execute();

            if($CarritoExiste->rowCount()==0){
                $dataQuery=array(
                    'userId' => $user_id,
                    'dataCarrito' => json_encode($_POST['infoPases']),
                    'fechaUpdate' => $dateRegistro
                );

                try{
                    $querySaveCarrito="INSERT INTO `tbl_savecarrito`(`user_id`, `dataCarrito`, `fechaUpdate`) VALUES (:userId, :dataCarrito, :fechaUpdate)";
                    $insertCarrito=$basededatos->connect()->prepare($querySaveCarrito);
                    $insertCarrito->execute($dataQuery);

                    $response = array(
                        'respuesta' => 'success',
                        'infoCarrito' => $_POST['infoPases']
                    );

                }catch(PDOException $e){
                    $response = array(
                        'respuesta' => 'error',
                        'mensaje' => $e->getMessage()
                    );
                }
            
            }if($CarritoExiste->rowCount()==1){
                $dataQueryUpdateCarrito=array(
                    'userId' => $user_id,
                    'dataCarrito' => json_encode($_POST['infoPases']),
                    'fechaUpdate' => $dateRegistro
                );

                try{
                    $queryUpdateCarrito="UPDATE `tbl_savecarrito` SET `dataCarrito`=:dataCarrito,`fechaUpdate`=:fechaUpdate WHERE `user_id`=:userId";
                    $updateCarrito=$basededatos->connect()->prepare($queryUpdateCarrito);
                    $updateCarrito->execute($dataQueryUpdateCarrito);

                    $response = array(
                        'respuesta' => 'success',
                        'infoCarrito' => $_POST['infoPases']
                    );

                }catch(PDOException $e){
                    $response = array(
                        'respuesta' => 'error',
                        'mensaje' => $e->getMessage()
                    );
                } 
            }
            
            header('Content-Type: application/json');
            echo json_encode($response);
        }else{
            $dataQueryDeleteCarrito=array(
                'userId' => $user_id                                
            );

            try{
                $queryDeleteCarrito="DELETE FROM `tbl_savecarrito` WHERE `user_id`=:userId";
                $deleteCarrito=$basededatos->connect()->prepare($queryDeleteCarrito);
                $deleteCarrito->execute($dataQueryDeleteCarrito);

                $response = array(
                    'respuesta' => 'success',
                    'infoCarrito' => []
                );

            }catch(PDOException $e){
                $response = array(
                    'respuesta' => 'error',
                    'mensaje' => $e->getMessage()
                );
            }             
            
            header('Content-Type: application/json');
            echo json_encode($response);
        }        
    }
    
    if(empty($_SESSION)){
        $response=array(
            'respuesta' => 'no_log',
            'carrito'   => []
        );
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    
    
    