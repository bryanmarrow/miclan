<?php


    require('../api/Config/DBconfig.php');

    $action=$_POST['action'];

    switch ($action) {
        case 'insert':

            
            
            if(!empty($_FILES)){
                
                $numFiles=count($_FILES['imgvalues']['name']);
                $infoComprobantes=json_decode($_POST['infoComprobantes']);
                $resComprobantes=array();

                // var_dump($infoComprobantes);
                for ($i=0; $i < $numFiles; $i++) { 

                    $baseFolder = "../../uploads/comprobantes/";
                    $fileName = $_FILES['imgvalues']['name'][$i];
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    $tokenFile=generateRandomString();
                
                    $nombrefile='comprobantedepago_' .$tokenFile.date("m_d_y_H_i_s").'.'.$extension;
                    $sourcePath = (isset($_FILES['imgvalues']['tmp_name'][$i])) ? $_FILES['imgvalues']['tmp_name'][$i] : '';
                    $targetPath = $nombrefile;
                
                    $targetFilePath = $baseFolder.$nombrefile;
                    $tokenPago=$_POST['tokenPago'];
                    
                    $numReferencia=$infoComprobantes[$i]->num_referencia_comprobante;
                    $montoComprobante=$infoComprobantes[$i]->monto_comprobante;
                    
                    if(move_uploaded_file($_FILES['imgvalues']['tmp_name'][$i], $targetFilePath)){
                
                        try {
                            $queryInserComprobante="INSERT INTO `tbl_comprobantes_pago`(`nombreFile`, `tokenPago`, `tokenFile`,`numreferencia_comprobante`,`monto_comprobante`) 
                            VALUES ('".$nombrefile."', '".$tokenPago."','".$tokenFile."','".$numReferencia."','".$montoComprobante."')";
                            $insertarComprobante=$basededatos->connect()->prepare($queryInserComprobante);            
                            $insertarComprobante->execute();            
                
                            $respuesta = array(
                                'respuesta' => 'success',
                                'nombreFile' => $nombrefile,
                                'tokenPago' => $tokenPago,
                                'tokenFile' => $tokenFile,
                                // 'idRol' => $_POST['idRol']
                            );
                        } catch (PDOException $e) {
                            $respuesta = array(
                                'respuesta' => 'error',
                                'nombreFile' => $nombrefile,
                                'tokenPago' => $tokenPago,
                                'tokenFile' => $tokenFile,
                                'mensaje' => $e->getMessage()
                            );
                        }
                
                        array_push($resComprobantes, $respuesta);
                    }
                }

                header('Content-Type: application/json');
                echo json_encode($resComprobantes);
                
    
            }
            break;
        case 'update':
            var_dump($_POST);
            break;
    }
    
  