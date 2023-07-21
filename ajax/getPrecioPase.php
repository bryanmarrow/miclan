<?php 


    require('../api/Config/DBconfig.php');
    

    $sku=$_POST['idform'];
    $descuento=0;
    $cupon=isset($_SESSION['cupon']) ? $_SESSION['cupon'] : '';
    

    $query="SELECT * FROM tbl_pases a
    INNER JOIN tbl_eventos b ON a.evento = b.id
    where a.codigo_pase='$sku' and b.token='$tokenEvento'";
    $queryPase=$basededatos->connect()->prepare($query);
    $queryPase->execute();


    $fetchPase=$queryPase->fetch(PDO::FETCH_ASSOC);
    
    if(isset($_SESSION['cupon'])){
        if($fetchPase['tipo_pase']===$cupon['tipocupon']){
            $descuento=isset($_SESSION['cupon']) ? $cupon['descuento'] : 0;
        }if($fetchPase['tipo_pase']==='general'){
            $descuento=$cupon['descuento'];
        }
    }

    $montoDescontar=$fetchPase['precio']*$descuento;
    $precioPase=$fetchPase['precio']-$montoDescontar;

    $datosPase= [
        'codigo_pase' => $fetchPase['codigo_pase'],
        'precio' => $precioPase,
        'descripcion_pase' => $fetchPase['descripcion_pase'],
        'divisaPase' => $fetchPase['divisa']
    ];
    
    // var_dump($datosPase);

    header('Content-Type: application/json');
    echo json_encode($datosPase);