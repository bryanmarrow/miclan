<?php

    require('../api/Config/DBconfig.php');


    $usercliente_id=$_SESSION['idUserSession'];
    

    $consulta = "SELECT b.fname, b.lname, b.fechanac, b.genero, b.fecharegistro, b.idcompetidor, c.pais
    FROM tbl_competidores_users_id a
    INNER JOIN tbl_competidores b ON a.idcompetidor = b.idcompetidor
    INNER JOIN tbl_paises c ON b.country = c.id
    where a.user_id = $usercliente_id
    ";
    $resultado = $basededatos->connect()->prepare($consulta);
    $resultado->execute();        
    $data=$resultado->fetchAll(PDO::FETCH_ASSOC);        
    print json_encode($data, JSON_UNESCAPED_UNICODE);