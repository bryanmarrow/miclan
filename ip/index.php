<?php

date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d H:i:s");

$user_agent = $_SERVER['HTTP_USER_AGENT'];
$ip_address = $_SERVER['REMOTE_ADDR'];

function getBrowser($user_agent){

    if(strpos($user_agent, 'MSIE') !== FALSE)
    return 'Internet explorer';
    elseif(strpos($user_agent, 'Edge') !== FALSE) //Microsoft Edge
    return 'Microsoft Edge';
    elseif(strpos($user_agent, 'Trident') !== FALSE) //IE 11
        return 'Internet explorer';
    elseif(strpos($user_agent, 'Opera Mini') !== FALSE)
    return "Opera Mini";
    elseif(strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE)
    return "Opera";
    elseif(strpos($user_agent, 'Firefox') !== FALSE)
    return 'Mozilla Firefox';
    elseif(strpos($user_agent, 'Chrome') !== FALSE)
    return 'Google Chrome';
    elseif(strpos($user_agent, 'Safari') !== FALSE)
    return "Safari";
    else
    return 'No hemos podido detectar su navegador';

}

$navegador = getBrowser($user_agent);

$dip = $_SERVER['REMOTE_ADDR'];
$json = file_get_contents("https://ipinfo.io/".$dip);
$details = json_decode($json,true);
if(array_key_exists("city",$details)) $city.=$details["city"];
if(array_key_exists("region",$details)) $region.=$details["region"];
if(array_key_exists("country",$details)) $country.=$details["country"];
if(array_key_exists("loc",$details)) $loc.=$details["loc"];
if(array_key_exists("org",$details)) $org.=$details["org"];

echo $navegador.'<br>';
echo "Direcci&#243;n IP: " .$ip_address."<br>";
echo "Ciudad: " .$city."<br>";
echo "Regi&#243;n: " .$region."<br>";
echo "Pa&#237;s: " .$country."<br>";
echo "Localizaci&#243;n: ".$loc."<br>";
echo "Proveedor de internet: ".$org."<br>";


?>

