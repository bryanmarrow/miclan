<?php
    
   
    require '../api/Config/DBconfig.php';

    $POST_FORMULARIOS = json_decode(file_get_contents('php://input'),true);
    
   
    $idCompetidor=$POST_FORMULARIOS['idCompetidor'];

    $query="SELECT a.id, a.fname, a.lname, a.fechanac, a.genero, b.pais
    FROM tbl_competidores a
    INNER JOIN tbl_paises b ON a.country = b.id
    where a.id=$idCompetidor";
    $queryCompetidor=$basededatos->connect()->prepare($query);
    $queryCompetidor->execute();

    header('Content-Type: application/json');
    echo json_encode($queryCompetidor->fetch(PDO::FETCH_ASSOC));

   
    