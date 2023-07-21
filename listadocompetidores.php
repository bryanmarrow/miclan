<?php
    
    $rootPath = "./";
    require($rootPath."api/Config/DBconfig.php");


    $dataoders=$basededatos->connect()->prepare("SELECT * FROM tbl_competencias     
    INNER JOIN tbl_categorias ON tbl_competencias.categoria_id = tbl_categorias.id
    INNER JOIN tbl_pases ON tbl_pases.codigo_pase = tbl_competencias.tiporegistro
    WHERE tbl_competencias.tiporegistro='ELWSC2023INSCPAR'
    GROUP BY tbl_competencias.registrocompetencia_id ASC");
    $dataoders->execute();

    $infoorders=$dataoders->fetchAll(PDO::FETCH_ASSOC);

    // var_dump($infoorders);


   
    foreach($infoorders as $order){
        $registroCompetencia=[];
        $idregistrocompetencia=$order['registrocompetencia_id'];
        $query="SELECT a.*, b.fname, b.lname, b.genero, c.pais
        FROM tbl_competencias a
        INNER JOIN tbl_competidores b ON a.competidor_id = b.idcompetidor
        INNER JOIN tbl_paises c ON b.country = c.id
        where a.registrocompetencia_id='$idregistrocompetencia'";
        $queryRegistroCompetencia=$basededatos->connect()->prepare($query);
        $queryRegistroCompetencia->execute();
        $infoCompetidores=$queryRegistroCompetencia->fetchAll(PDO::FETCH_ASSOC);
        

        $registroCompetencia[]=$order['categoria_es'];

        foreach($infoCompetidores as $key => $competidor){
            $pareja=[];
            $pareja[]=$competidor['fname'].' '.$competidor['lname'];
            $registroCompetencia[]=$competidor['competidor_id'];
        }
        
        var_dump($registroCompetencia);
        // var_dump($infoCompetidores);
    }
    // header('Content-Type: application/json');
    // echo json_encode($infoorders);