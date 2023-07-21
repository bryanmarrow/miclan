<?php




$title = isset($_GET['title'])? $_GET['title'] : "Envíanos tu foto - #ELVDC2020";
$description = isset($_GET['description'])? $_GET['description'] : "#ELVDC2020";
$keywords = isset($_GET['keywords'])? $_GET['keywords'] : "No keywords.";
$author = isset($_GET['author'])? $_GET['author'] : "No author.";
$ogtitle = isset($_GET['ogtitle'])? $_GET['ogtitle'] : "Envíanos tu foto - Euroson Latino Virtual Dance Competition";
$ogdescription = isset($_GET['ogdescription'])? $_GET['ogdescription'] : "¡Se parte de la historia!";
$ogimagen = isset($_GET['ogimagen'])? $_GET['ogimagen'] : "https://eurosonlatino.com.mx/mail/og-image-elvdc2020.jpg";

$rootPath = "./";
$form = "framepic";
require($rootPath."api/Config/DBconfig.php");
require($rootPath."templates/header.php");
require($rootPath."api/Config/Sample.php");
require($rootPath."pages/framepic.inc.php");


require($rootPath."templates/footer.php");



?>