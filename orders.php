<?php

$title = isset($_GET['title'])? $_GET['title'] : "Euroson Latino World Salsa Championship 2022 - #ELWSC2022";
$description = isset($_GET['description'])? $_GET['description'] : "Diciembre 5-10, 2022 Cancún, México | ¡El Campeonato Mundial más grande del planeta!";
$keywords = isset($_GET['keywords'])? $_GET['keywords'] : "salsa, bachata, euroson latino, mexico";
$author = isset($_GET['author'])? $_GET['author'] : "BMARROW";
$ogtitle = isset($_GET['ogtitle'])? $_GET['ogtitle'] : "Euroson Latino World Salsa Championship 2022 - ELWSC2022";
$ogdescription = isset($_GET['ogdescription'])? $_GET['ogdescription'] : "Diciembre 5-10, 2022 Cancún, México | ¡El Campeonato Mundial más grande del planeta!";
$ogimagen = isset($_GET['ogimagen'])? $_GET['ogimagen'] : "https://eurosonlatino.com.mx/mail/og-image-elwsc2021.jpg";


$rootPath = "./";
require($rootPath."api/Config/DBconfig.php");
require './vendor/autoload.php';
require("templates/header.php");
require("pages/orders.inc.php");
require("templates/footer.php");



?>