<?php



$rootPath = "./";
require($rootPath."api/Config/DBconfig.php");



$title = isset($_GET['title'])? $_GET['title'] : 'Inicio - '.$nombreEvento.' - '.$descripcionEvento.' #'.$tagEvento.'';
$description = isset($_GET['description'])? $_GET['description'] : $descripcionEvento;
$keywords = isset($_GET['keywords'])? $_GET['keywords'] : "salsa, bachata, euroson latino, mexico";
$author = isset($_GET['author'])? $_GET['author'] : "BMARROW";
$ogtitle = isset($_GET['ogtitle'])? $_GET['ogtitle'] : $nombreEvento.' - '.$descripcionEvento.' #'.$tagEvento.'';
$ogdescription = isset($_GET['ogdescription'])? $_GET['ogdescription'] : $descripcionEvento;
$ogimagen = isset($_GET['ogimagen'])? $_GET['ogimagen'] : $imagenEvento;

// $queryClaveStreaming='SELECT * FROM tbl_links_streaming where status_clave=0 LIMIT 1';
// $ClaveStreaming=$basededatos->connect()->prepare($queryClaveStreaming);
// $ClaveStreaming->execute();
// $fetchClaveStreaming=$ClaveStreaming->fetch(PDO::FETCH_ASSOC);
// $clavesActivas=$ClaveStreaming->rowCount();
// if($clavesActivas>0){
//     $ClaveStreamingActiva=$fetchClaveStreaming['clave_streaming'];
// }


$global=getActionOption('global', $dataEvento['id']) == 0 ?  1 : getActionOption('global', $dataEvento['id'])['value'];

if($global==1){ require($rootPath.'pages/offline.inc.php');}

if($global==0){
    require($rootPath."templates/header.php");
   
    $page='pages/login.inc.php';

   
    require($rootPath.$page);

    require("templates/footer.php");
}
?>