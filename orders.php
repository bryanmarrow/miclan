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

require './vendor/autoload.php';
require("templates/header.php");
require("pages/orders.inc.php");
require("templates/footer.php");



?>