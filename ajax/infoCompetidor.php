<?php 



    // var_dump($_POST);

    require '../api/Config/DBconfig.php';
    $competidores=$_POST['competidores'];
    $infoRegistro=$_POST['infoRegistro'];
    $idCategoria=$infoRegistro['categoriaPase'];


    $infoCompetidores=[];
    foreach ($competidores as $key => $value) {
        $idCompetidor=$value['idCompetidor'];
        $query="SELECT * FROM tbl_competidores where id=$idCompetidor";
        $queryinfoCompetidor=$basededatos->connect()->prepare($query);
        $queryinfoCompetidor->execute();
        $infoCompetidor=$queryinfoCompetidor->fetch(PDO::FETCH_ASSOC);
        // var_dump($infoCompetidor);
        array_push($infoCompetidores, $infoCompetidor);
    }

    $queryCategoria="SELECT * FROM tbl_categorias where id=$idCategoria";
    $queryinfoCategoria=$basededatos->connect()->prepare($queryCategoria);
    $queryinfoCategoria->execute();
    $infoCategoria=$queryinfoCategoria->fetch(PDO::FETCH_ASSOC);

  
    $respuesta= [
        'categoria' => $infoCategoria,
        'infocompetidores' => $infoCompetidores
    ];

    header('Content-Type: application/json');
    echo json_encode($respuesta);
    // var_dump($infoCategoria);


   