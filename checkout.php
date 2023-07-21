<?php




$title = isset($_GET['title'])? $_GET['title'] : "Checkout - #ELWSC2022";
$description = isset($_GET['description'])? $_GET['description'] : "Diciembre 5-10, 2022 Cancún, México | ¡El Campeonato Mundial más grande del planeta!";
$keywords = isset($_GET['keywords'])? $_GET['keywords'] : "salsa, bachata, euroson latino, mexico";
$author = isset($_GET['author'])? $_GET['author'] : "MRB";
$ogtitle = isset($_GET['ogtitle'])? $_GET['ogtitle'] : "¡Adquiere tu Full Pass! - Euroson Latino World Salsa Championship";
$ogdescription = isset($_GET['ogdescription'])? $_GET['ogdescription'] : "Diciembre 5-10, 2022 Cancún, México | ¡El Campeonato Mundial más grande del planeta!";
$ogimagen = isset($_GET['ogimagen'])? $_GET['ogimagen'] : "https://eurosonlatino.com.mx/mail/og-image-elwsc2021.jpg";

$rootPath = "./";
// $evento='elwsc2022';
// $form = "fullpass";




// require($rootPath."api/Config/Config.php");
require($rootPath."api/Config/DBconfig.php");
require($rootPath."templates/header.php");
require($rootPath."pages/checkout.inc.php");
require($rootPath."templates/footer.php");



?>