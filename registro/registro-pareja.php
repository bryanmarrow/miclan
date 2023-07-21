<?php

$rootPath = "./../";
require($rootPath."api/Config/DBconfig.php");

$title = isset($_GET['title'])? $_GET['title'] : 'Registro Parejas - '.$nombreEvento.' - '.$descripcionEvento.' #'.$tagEvento.'';
$description = isset($_GET['description'])? $_GET['description'] : $descripcionEvento;
$keywords = isset($_GET['keywords'])? $_GET['keywords'] : "salsa, bachata, euroson latino, mexico";
$author = isset($_GET['author'])? $_GET['author'] : "BMARROW";
$ogtitle = isset($_GET['ogtitle'])? $_GET['ogtitle'] : 'Registro Parejas - '.$nombreEvento.' - '.$descripcionEvento.' #'.$tagEvento.'';
$ogdescription = isset($_GET['ogdescription'])? $_GET['ogdescription'] : $descripcionEvento;
$ogimagen = isset($_GET['ogimagen'])? $_GET['ogimagen'] : $imagenEvento;

$global=globalStatusWeb();
if($global==1){ require($rootPath.'pages/offline.inc.php');}
if($global==0){
    $form = "ELWSC2023INSCPAR";
    $tipoform=0;
    
    if(!isset($_SESSION['idUserSession'])){
        $url=$rootPath.'login';
        header("Location: ".$url);
        exit();
    }
    require($rootPath."templates/header.php");


    $rPases=dataPase($form)['num_resultado'];
    $dataPase=dataPase($form)['resultados'];
    $form=$rPases>0 ? $form : 0;




    $status_apartado=isset($_GET['apartado']) && $_GET['apartado']==0 ? 0 : 1;

    $precioPase=$rPases==0 ? '' : $dataPase['precio'];



    if($status_apartado==0 && $dataPase['status_apartado']==0){
        $precioPase=$dataPase['precio_apartado'];
    }

    $codigoPase=$rPases==0 ? '' : $dataPase['codigo_pase'];
    $idPase=$rPases==0 ? '' : $dataPase['id'];
    $tagApartado=$rPases==0 ? '' : $dataPase['tag'];
    $nombreTicket=$rPases==0 ? '' : $dataPase['descripcion_pase'];
    $divisaPase=$rPases==0 ? '' : $dataPase['divisa'];

    $statusForm=getActionOption($form, $dataEvento['id']) == 0 ?  1 : getActionOption($form, $dataEvento['id'])['value'];
    $page=$statusForm==0 ? 'pages/registro-pareja.inc.php' : OFFLINE_PAGE;   
    require($rootPath.$page);


    require($rootPath."templates/footer.php");
}



?>