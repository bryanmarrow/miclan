<?php 

    // var_dump($_POST);

    require('../api/Config/DBconfig.php');
    
    $items=$_POST['infoPases'];


    $cupon=isset($_SESSION['cupon']) ? $_SESSION['cupon'] : '';

    $montosubtotal=[];
    $montotax=[];
    $montosubtotalmxn=[];
    $montotaxmxn=[];
    $montoDescuento=[];
    foreach($items as $item){

        $queryinfoPase="
        SELECT * FROM tbl_pases a
        RIGHT JOIN tbl_eventos b ON a.evento = b.id
        WHERE a.codigo_pase = '".$item['sku']."'";
        $infoPase=$basededatos->connect()->prepare($queryinfoPase);
        $infoPase->execute();
        $dataPase=$infoPase->fetch(PDO::FETCH_ASSOC);

        $precio=$dataPase['precio'];
        $cantidad=$item['quantity'];
        $descuento=0;
        
        if(isset($_SESSION['cupon'])){            
            if($dataPase['tipo_pase']===$cupon['tipocupon']){
                $descuento=number_format($cupon['descuento'], 2);
            }else if($dataPase['tipo_pase']==='general'){
                $descuento=number_format($cupon['descuento'], 2);
            }
        }

        $montoDescontar=($precio*$cantidad)*$descuento;        
        $subTotalPase=$precio*$cantidad;
        $montosubtotal[]=$subTotalPase;
        $montoDescuento[]=$montoDescontar;
        
    }
        
    $subtotal=array_sum($montosubtotal);
    $descuentos=array_sum($montoDescuento);
    
    
    // $comisionplataformausd=3.00;    

    
    // $comisionstripe=($subtotal-$descuentos)*0.07;
    // // echo $comisionstripe.'<br>';
    // $iva=$comisionstripe*0.16;    
    // // echo $iva.'<br>';
    // $comision=isset($_POST['paymenthMethod']) ? 0 : $comisionstripe+$iva+$comisionplataformausd;
    // // echo $comision.'<br>';

    // $comisionUSD=isset($_POST['paymenthMethod']) ? 0 : $comision;
    // // echo $comisionUSD;
    
    
    $total=$subtotal;

    $totalCarrito= [
        'tax' => 0,
        'subTotalCarrito' => $subtotal,
        'descuento' => $descuentos,
        'total_amount' => $total,               
        'tax_mxn' => $comision,        
        'cupon' => $cupon
    ];

    // var_dump($totalCarrito);
    header('Content-Type: application/json');
    echo json_encode($totalCarrito);

?>