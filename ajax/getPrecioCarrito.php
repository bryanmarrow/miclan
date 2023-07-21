<?php 

    require('../api/Config/DBconfig.php');
    
    $items=$_POST['infoPases'];

    // $tipocambio=20;
    // $ivatax=0.16;
    // $stripetax=0.038;
    // $comisionpesos=3.00;
    // $comisionplataforma=3.00;

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
        // $precioPase=$precio-$montoDescontar;
        $subTotalPase=$precio*$cantidad;

        // $descuentoSubtotal=
        
        

        

        $montosubtotal[]=$subTotalPase;
        $montoDescuento[]=$montoDescontar;
        
    }
        
    $subtotal=array_sum($montosubtotal);
    $descuentos=array_sum($montoDescuento);
    

    $subtotalmxn=$subtotal*$tipoCambioDollar['value'];
    $subtotaldescuentomx=$descuentos*$tipoCambioDollar['value'];

    // echo $subtotalmxn.'<br>';
    // echo $subtotaldescuentomx.'<br>';
    
    
    $comisionplataformausd=$comisionPlataforma['value']/$tipoCambioDollar['value'];
    // echo $comisionplataformausd.'<br>';

    
    $comisionstripe=($subtotalmxn-$subtotaldescuentomx)*$comisionStripe['value'];
    // echo $comisionstripe.'<br>';
    $iva=$comisionstripe*$ivaTax['value'];    
    // echo $iva.'<br>';
    $comision=isset($_POST['paymenthMethod']) ? 0 : $comisionstripe+$iva+$comisionPlataforma['value'];
    // echo $comision.'<br>';

    $comisionUSD=isset($_POST['paymenthMethod']) ? 0 : $comision/$tipoCambioDollar['value'];
    // echo $comisionUSD;

    $total_mxn=$subtotalmxn+$comision-$subtotaldescuentomx;    
    
    $total=$subtotal+$comisionUSD-$descuentos;

    $totalCarrito= [
        'tax' => $comisionUSD,
        'subTotalCarrito' => $subtotal,
        'descuento' => $descuentos,
        'total_amount' => $total,       
        'subtotalmxn' => $subtotalmxn,
        'tax_mxn' => $comision,
        'totalmxn' => $total_mxn,
        'cupon' => $cupon
    ];

    // var_dump($totalCarrito);
    header('Content-Type: application/json');
    echo json_encode($totalCarrito);

?>