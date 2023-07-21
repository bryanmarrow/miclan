<?php

if(!isset($_SESSION['idUserSession'])){
    
    // $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    // $_SESSION['urlback']=$actual_link;

    // header("Location: ".$rootPath."signin");
    // exit();
}else{
  $idUserSession=$_SESSION['idUserSession'];
  $query="SELECT * FROM tbl_users where id='$idUserSession'";
  $querySessionUser=$basededatos->connect()->prepare($query);
  $querySessionUser->execute();
  if($querySessionUser->rowCount()==0){
    
    header("Location: ".$rootPath."signin");
    session_destroy();
    exit();
    
  }else{

    $colUser=$querySessionUser->fetch(PDO::FETCH_ASSOC);

    $imgUser=$colUser['img']==NULL || $colUser['img']=='' ? 'assets/img/avatar/avatar-default.jpg' : 'data:image/png;base64, '.$colUser['img'];

    if($colUser['status']==2){
      header("Location: ".$rootPath."signin");
      session_destroy();
      exit();
    }
  }
}
