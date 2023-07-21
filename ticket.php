<?php

$rootPath = "./";
require($rootPath."api/Config/DBconfig.php");


$nombrePase=isset($_GET['sku']) && strlen($_GET['sku'])>0 ? dataPase($_GET['sku'])['resultados']['descripcion_pase'] : '';
$title = isset($_GET['title'])? $_GET['title'] : $nombrePase.' - '.$nombreEvento.' - '.$descripcionEvento.' #'.$tagEvento.'';
$description = isset($_GET['description'])? $_GET['description'] : $descripcionEvento;
$keywords = isset($_GET['keywords'])? $_GET['keywords'] : "salsa, bachata, euroson latino, mexico";
$author = isset($_GET['author'])? $_GET['author'] : "BMARROW";
$ogtitle = isset($_GET['ogtitle'])? $_GET['ogtitle'] : $nombrePase.' - '.$nombreEvento.' - '.$descripcionEvento.' #'.$tagEvento.'';
$ogdescription = isset($_GET['ogdescription'])? $_GET['ogdescription'] : $descripcionEvento;
$ogimagen = isset($_GET['ogimagen'])? $_GET['ogimagen'] : $imagenEvento;


$global=getActionOption('global', $dataEvento['id']) == 0 ?  1 : getActionOption('global', $dataEvento['id'])['value'];

if($global==1){ require($rootPath.'pages/offline.inc.php');}

if($global==0){

    $tipoform=1;
    
    $page=OFFLINE_PAGE;
    if(isset($_GET['sku']) && strlen($_GET['sku'])>0){

        $rPases=dataPase($_GET['sku'])['num_resultado'];
        $dataPase=dataPase($_GET['sku'])['resultados'];
        $form=$rPases>0 ? $_GET['sku'] : 0;

        
        
        $status_apartado=isset($_GET['apartado']) && $_GET['apartado']==0 ? 0 : 1;

        $precioPase=$rPases==0 ? '' : $dataPase['precio']*$dataPase['maxPases'];
        
        if($status_apartado==0 && $dataPase['status_apartado']==0){
            $precioPase=$dataPase['precio_apartado']*$dataPase['maxPases'];
        }
        
        $codigoPase=$rPases==0 ? '' : $dataPase['codigo_pase'];
        $idPase=$rPases==0 ? '' : $dataPase['id'];
        $tagApartado=$rPases==0 ? '' : $dataPase['tag'];
        $nombreTicket=$rPases==0 ? '' : $dataPase['descripcion_pase'];
        $divisaPase=$rPases==0 ? '' : $dataPase['divisa'];
        $minPases=$dataPase['minPases'];
        $maxPases=$dataPase['maxPases'];
        $tipoPase=$dataPase['tipo_pase'];

        $page=$dataPase['statusPase']==0 ? OFFLINE_PAGE : 'pages/ticket.inc.php'; 
    }

    require($rootPath."templates/header.php");
    require($rootPath.$page);

    require($rootPath."templates/footer.php");

}


?>