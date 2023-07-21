<?php


$rootPath = "./";
require($rootPath."api/Config/DBconfig.php");

$title = isset($_GET['title'])? $_GET['title'] : 'Registro Competencia - '.$nombreEvento.' - '.$descripcionEvento.' #'.$tagEvento.'';
$description = isset($_GET['description'])? $_GET['description'] : $descripcionEvento;
$keywords = isset($_GET['keywords'])? $_GET['keywords'] : "salsa, bachata, euroson latino, mexico";
$author = isset($_GET['author'])? $_GET['author'] : "BMARROW";
$ogtitle = isset($_GET['ogtitle'])? $_GET['ogtitle'] : $nombreEvento.' - '.$descripcionEvento.' #'.$tagEvento.'';
$ogdescription = isset($_GET['ogdescription'])? $_GET['ogdescription'] : $descripcionEvento;
$ogimagen = isset($_GET['ogimagen'])? $_GET['ogimagen'] : $imagenEvento;

$rootPath = "./";

if(isset($_GET['form'])){
    $form=$_GET['form'];
}else{
    header("Location: ".$rootPath);
    exit();
}

$global=getActionOption('global', $dataEvento['id']) == 0 ?  1 : getActionOption('global', $dataEvento['id'])['value'];

if($global==1){ require($rootPath.'pages/offline.inc.php');}

if($global==0){
    require($rootPath."templates/header.php");
   
    $page=empty($_SESSION) ? 'pages/login.inc.php' : 'pages/registro-competencia.inc.php';
    require($rootPath.$page);
    require("templates/footer.php");
}

?>