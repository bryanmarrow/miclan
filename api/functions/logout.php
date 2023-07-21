<?php

    session_start();
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    // require_once 'config/dbconfig.php';
    // $login_session=$_SESSION['login_user'];
    
    // $log=$basededatos->connect()->prepare("UPDATE tbl_suscriptores SET log='0' WHERE user='$login_session' and log='1'");
    // $log->execute();

    // echo "http://$host$uri";

    // session_destroy();
    // header("Location: http://$host$uri");
    // exit;
   
?>