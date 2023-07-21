<?php 
    
    
 
    
    require('../api/Config/DBconfig.php');
    
    $skuPase=isset($_POST['skuPase']) ? $_POST['skuPase'] : '';    
    $idApartado=$_POST['idApartado']=='' ? 1 : 0;    
    $valor_cupon=isset($_POST['valor_cupon']) ? $_POST['valor_cupon'] : '';    
    $tipoForm=isset($_POST['tipoForm']) ? $_POST['tipoForm'] : '';    
    $numIntegrantes=isset($_POST['numIntegrantes']) ? $_POST['numIntegrantes'] : '';    

    $dataPase=dataPase($skuPase)>0 ? dataPase($skuPase)['resultados'] : 0;

    $idform=$dataPase['id'];

    $dataCostos=getCostosPublico($idform, $idApartado, $valor_cupon, $tipoForm, $numIntegrantes);

    header('Content-Type: application/json');
    echo json_encode($dataCostos);
?>