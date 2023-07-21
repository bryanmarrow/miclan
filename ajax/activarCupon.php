
<?php 

    // var_dump($_POST);
    require('../api/Config/DBconfig.php');
    $action=$_POST['action'];
    

    switch($action){
        case 'activate':
        $cupon=$_POST['cupon'];
        $query="SELECT * FROM tbl_cupones where cupon='$cupon' and status=0";
        $queryCupon=$basededatos->connect()->prepare($query);
        $queryCupon->execute();

        
        $fetchCupon=$queryCupon->fetch(PDO::FETCH_ASSOC);
        $rowCount=$queryCupon->rowCount();
        
        

        if($rowCount>0){
            $datacupon=[
                'cupon' => $fetchCupon['cupon'],
                'descuento' => $fetchCupon['descuento'],
                'tipocupon' => $fetchCupon['form']
            ];

            $_SESSION['cupon']=$datacupon;

            $respuesta=[
                'respuesta' => 'success',
                'infocupon' => $datacupon
            ];
        }else{
            $respuesta=[
                'respuesta' => 'error',
            ];
        }
        break;
        case 'delete':
            $respuesta=[
                'respuesta' => 'success',
            ];
            unset($_SESSION['cupon']);
        break;
    }
    
    header('Content-Type: application/json');
    echo json_encode($respuesta);

    



    

    

    




?>