<?php 

    require('../api/Config/DBconfig.php');


    $query="SELECT * FROM tbl_weboptions where idform='global'";
    $queryExe=$basededatos->connect()->prepare($query);
    $queryExe->execute();

    header('Content-Type: application/json');
    echo json_encode($queryExe->fetch(PDO::FETCH_ASSOC));


?>