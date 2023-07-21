<?php 


    // var_dump($_POST);
    // // session_start();
    require '../vendor/autoload.php';
    require('../api/Config/DBconfig.php');
    
    // var_dump($_SESSION);

    $itemsOrden = $_POST['itemsOrden'];


    \Stripe\Stripe::setApiKey('sk_test_r747hWZh0AjBDSgtLUmQd0vD');

    $stripe = new \Stripe\StripeClient('sk_test_51LVia2B4srLF6gvb7ndYe400JESBqXBxwug741KSDB2Vtz1Nl8kpEUuicJGxMRTmEA0uECa1V8F0NZWHtJG1K4OU00lgierdEC');


    $idtienda='acct_1LVia2B4srLF6gvb';

    $formOrden=isset($_POST['pases']) ? $_POST['pases'] : [];
    $infoOrdenPases=$_POST['infoOrdenPases'];
    $paymenth_method=isset($_POST['paymentMethod']) ? $_POST['paymentMethod'] : '';
    $user_id=$_SESSION['idUserSession'];
    // date_default_timezone_set('America/Mexico_City');
    $fechapago = date("Y-m-d H:i:s");    
    $couponcode=isset($_POST['couponecode']) ? $_POST['couponecode'] : '';
    

    $carritoArray=isset($_POST['cartArray']) ? $_POST['cartArray'] : [];


    // // var_dump($carritoArray);

    $fechaExpiracion=DateTime::createFromFormat('m/y', $infoOrdenPases['cc-datexmp']);
    $year=$fechaExpiracion->format('y');
    $month=$fechaExpiracion->format('m');

    // $saveCard=$infoOrdenPases['saveCard'];

    $invoiceid=$infoOrdenPases['invoiceid'];

    $comisionstripe=3.00;
    $carrito=array();

    $calcularPrecio=calculateOrderAmount($carritoArray);
    $totalCarrito= number_format(($calcularPrecio['totalmxn'] /1), 2, '', '');

    
    $infoEvento=getInfoEvento($tokenEvento);
    $idEvento=$infoEvento['id'];

    $montosCarrito=calcularPrecio($carritoArray, $paymenth_method);

   
        
    // Inserción de Orden

    $dataorder=[
        'invoiceid' => $infoOrdenPases['invoiceid'],
        'user_id' => $user_id,
        'dateorder' => $fechapago,
        'idEvento' => $idEvento,
        'subtotal' => $montosCarrito['subTotalCarrito'],
        'tax' => $montosCarrito['tax'],
        'total' => $montosCarrito['total_amount'],
        'descuentos' => $montosCarrito['descuentos']
    ];

    try{
        $queryExe=$basededatos->connect()->prepare("INSERT INTO `tbl_orders` (`invoiceid`, `user_id`, `dateorder`, `idEvento`, `subtotal`, `tax`, `total`, `descuentos`) 
        VALUES (:invoiceid, :user_id, :dateorder, :idEvento, :subtotal, :tax, :total, :descuentos)");
        
        $basededatos->connect()->prepare("INSERT INTO `tbl_data_compra`(`ipaddress`, `browser`, `dispositivo`, `invoiceid`) 
        VALUES ('".$ipAddress."', '".$navegador."', '".$dispositivo."', '".$invoiceid."')")->execute();

        $queryExe->execute($dataorder);

        $respuesta_insertandoOrden=array(
            'respuesta' => 'success',            
        );

    }catch(PDOException $e){

        $respuesta_insertandoOrden=array(
            'respuesta' => 'error',            
            'mensaje' => $e->getMessage()
        );
    }

    if($respuesta_insertandoOrden['respuesta']=='success'){

        
        
        // Inserción de Pases de competencia y detalle del carrito
        foreach($carritoArray as $item){
            
            switch($item['tipoPase']){
                case 'competencia':                                                        
                    $infoCompetidores=$item['competidores'];
                    $infoCategoria=$infoCompetidores['categoria'];
                    
                    switch ($item['sku']) {
                        case 'ELWSC2023INSCSOL':
                            // var_dump($item);
                            $competidorSolista=$infoCompetidores['infocompetidores'][0];
                            $categoriaSolista=$infoCompetidores['categoria'];
                            $data = [
                                'idCompetidor' => $competidorSolista['id'],
                                'idCategoria' => $categoriaSolista['id'],
                                'fechaRegistro' => $fechapago,
                                'registro_token' => $item['invoiceid'],
                                'statusPago' => 0,
                                'userId' => $user_id,
                                'invoiceid' => $invoiceid
                            ];    
                            try{
                                $query="INSERT INTO `tbl_solistas`(`idCompetidor`, `idCategoria`, `fecharegistro`, `registro_token`, `statusPago`, `userId`, `invoiceid`) 
                                VALUES (:idCompetidor, :idCategoria, :fechaRegistro, :registro_token, :statusPago, :userId, :invoiceid)";

                                $basededatos->connect()->prepare($query)->execute($data);
        
                                $respuesta = array(
                                    'respuesta' => 'success',
                                    'infoticket' => $data
                                );  
                            }catch(PDOException $e){
                                $respuesta = array(
                                    'respuesta' => 'error',                                
                                    'mensaje' => $e->getMessage()
                                );  
                            }
                            // var_dump($respuesta);

                            break;
                        case 'ELWSC2023INSCPAR':
                            $competidor_p1=$infoCompetidores['infocompetidores'][0];
                            $competidor_p2=$infoCompetidores['infocompetidores'][1];
                            
                            $data = [
                                'idCompetidor_p1' => $competidor_p1['id'],
                                'idCompetidor_p2' => $competidor_p2['id'],
                                'idCategoria' => $infoCategoria['id'],
                                'fechaRegistro' => $fechapago,
                                'registro_token' => $item['invoiceid'],
                                'alias' => '',                            
                                'userId' => $user_id,
                                'invoiceid' => $invoiceid
                            ];    

                            try{
                                $query="INSERT INTO `tbl_parejas`(`idCompetidor_p1`, `idCompetidor_p2`, `idCategoria`, `fecharegistro`, `registro_token`, `alias`, `userId`, `invoiceid`) 
                                VALUES (:idCompetidor_p1, :idCompetidor_p2, :idCategoria, :fechaRegistro, :registro_token, :alias, :userId, :invoiceid)";

                                $basededatos->connect()->prepare($query)->execute($data);
        
                                $respuesta = array(
                                    'respuesta' => 'success',
                                    'infoticket' => $data
                                );  
                            }catch(PDOException $e){
                                $respuesta = array(
                                    'respuesta' => 'error',                                
                                    'mensaje' => $e->getMessage()
                                );   
                            }                        
                            // var_dump($respuesta);
                            break;
                        case 'ELWSC2023INSCGRU':

                            // var_dump($infoCompetidores);
                            // var_dump($item);
                            // var_dump($infoCompetidores['infocompetidores']);
                            $nombreGrupo=$infoCompetidores['nombreGrupo'];
                            $paisGrupo=$infoCompetidores['paisGrupo'];
                        
                            $data = [
                                'nombre_grupo' => $nombreGrupo,
                                'pais_grupo' => $paisGrupo,
                                'categoria_id' => $infoCategoria['id'],
                                'fecha_registro' => $fechapago,
                                'registro_token' => $item['invoiceid'],                            
                                'userId' => $user_id,
                                'invoiceid' => $invoiceid
                            ];

                            try{
                                $query="INSERT INTO `tbl_grupos`(`nombreGrupo`, `paisGrupo`, `idCategoria`, `fecharegistro`, `registro_token`, `userId`, `invoiceid`) 
                                VALUES (:nombre_grupo, :pais_grupo, :categoria_id, :fecha_registro, :registro_token, :userId, :invoiceid)";                                
                                $basededatos->connect()->prepare($query)->execute($data);


                                $respuesta = array(
                                    'respuesta' => 'success',
                                    'infoticket' => $data
                                );  
                            }catch(PDOException $e){
                                $respuesta = array(
                                    'respuesta' => 'error',                                
                                    'mensaje' => $e->getMessage()
                                );  
                            }

                            foreach($infoCompetidores['infocompetidores'] as $competidor){

                                $data = [
                                    'tiporegistro' => $item['sku'],
                                    'fecharegistro' => $fechapago,
                                    'categoria' => $infoCategoria['id'],
                                    'orden_id' => $invoiceid,
                                    'registro_id' => $item['invoiceid'],
                                    'competidor_id' => $competidor['idcompetidor'],
                                    'user_id' => $user_id,
                                    'statusPase' => 2
                                ];

                                try{
                                    $query="INSERT INTO `tbl_competencias`
                                    (`competidor_id`, `categoria_id`, `user_id`, `fecharegistro`, `tiporegistro`, `orden_id`, `statusPase`, `registrocompetencia_id`) 
                                    VALUES (:competidor_id,:categoria,:user_id,:fecharegistro,:tiporegistro,:orden_id,:statusPase, :registro_id)";
                                    $basededatos->connect()->prepare($query)->execute($data);

                                    $respuesta = array(
                                        'respuesta' => 'success',
                                        'infoticket' => $data
                                    );                    
                                    
                                }catch(PDOException $e){

                                    $respuesta = array(
                                        'respuesta' => 'error',
                                        'infoticket' => $data
                                    );     
                                }                                                                
                            }

                            // var_dump($respuesta);

                            // array_push($carrito, $respuesta);
                        break;                       
                    }                            
                break;
            
            }

             // Inserción de detalle del carrito
            $dataItemCart=[
                'sku_product' => $item['sku'],
                'price_product' => $item['precioPase'],
                'cantidad_producto' => $item['quantity'],
                'fechaItem' => $fechapago,
                'invoiceid' => $infoOrdenPases['invoiceid'],
                'subtotalItem' => $item['subTotalCarrito'],
                'descuento' => 0
            ];

            try{
                $itemCartQuery="INSERT INTO `tbl_order_details`(`sku_product`, `price`, `cantidad`, `subtotalItem`, `descuento`, `fechaCreacion`, `invoiceid`) 
                VALUES (:sku_product, :price_product, :cantidad_producto, :subtotalItem, :descuento, :fechaItem, :invoiceid)";
                $insertarItemCart=$basededatos->connect()->prepare($itemCartQuery);
                $insertarItemCart->execute($dataItemCart);

                $respuesta=array(
                    'respuesta' => 'success'
                );
            }catch(PDOException $e){
                $respuesta=array(
                    'respuesta' => 'error',
                    'mensaje' => $e->getMessage()
                );
            }

        }

        // Inserción de tickets
        foreach($formOrden as $orden){
            
            

            try{
                $data = [
                    'nombre_p' => $orden['fname'],
                    'apellidos_p' => $orden['lname'],
                    'email_p' => '',                    
                    'idform' => $orden['idform'],
                    'idPase' => $orden['idPase'],
                    'invoiceid' => $orden['invoiceid'],
                    'statusPase' => 0,
                    'statusApartado' => 0                    
                ];

                // $dataLog = [
                //     'tokenTicket' => $orden['idPase'],
                //     'status_ticket' => 0,
                //     'invoiceid' => $orden['invoiceid'],
                //     'comprobante_pago' => '',
                //     'payment_method' => $paymenth_method,
                //     'admin_user' => 1800,
                //     'fechaLog' => $fechapago
                // ];

                $basededatos->connect()->prepare("INSERT INTO `tbl_ordenes`(
                    `fname`, 
                    `lname`, 
                    `email`,                    
                    `idform`, 
                    `token`,
                    `status`,
                    `invoiceid`,
                    `status_apartado`
                    ) VALUES (
                    :nombre_p, 
                    :apellidos_p, 
                    :email_p,                     
                    :idform, 
                    :idPase,
                    :statusPase,
                    :invoiceid,
                    :statusApartado
                )")->execute($data);

                // $basededatos->connect()->prepare("INSERT INTO `tbl_log_status_ordenes`(`tokenOrden`, 
                // `id_status`, `invoiceid`, `comprobante_pago`, `paymenth_method`, `admin_user`, `fecharegistro`)
                // VALUES (:tokenTicket, :status_ticket, :invoiceid, :comprobante_pago, :payment_method, :admin_user, :fechaLog)")->execute($dataLog);
                
                $respuesta = array(
                    'respuesta' => 'success',
                    'infoticket' => $data
                );              
                
                
                
            }catch(PDOException $e){

                $respuesta = array(
                    'respuesta' => 'error',
                    'infoticket' => $data,
                    'mensaje' => $e->getMessage()
                );     
            }
            array_push($carrito, $respuesta);
        }

       
        
        // Inserción de comentarios de la orden
        if(strlen($infoOrdenPases['notasOrden'])>0){            
            try{
                $dataComentario=[
                    'user_id' => $user_id,
                    'comentarios_orden' => $infoOrdenPases['notasOrden'],
                    'invoiceid' => $infoOrdenPases['invoiceid'],
                    'fechaComentario' => $fechapago                                                            
                ];

                $queryComentario="INSERT INTO `tbl_comentarios_orders`(`user_id`, `comentarios_orden`, `invoiceid_orden`, `fecha_comentario`) VALUES (:user_id, :comentarios_orden, :invoiceid, :fechaComentario)";
                $insertarComentario=$basededatos->connect()->prepare($queryComentario);
                $insertarComentario->execute($dataComentario);

                $respuesta=array(
                    'respuesta' => 'success'
                );

            }catch(PDOException $e){
                $respuesta=array(
                    'respuesta' => 'error',
                    'mensaje' => $e->getMessage()
                );
            }
        }
        
        // Inserción del detalle metodo de pago
        switch($paymenth_method){
            case 'transfer':
                $rangonumerico=rand(10000000, 90000000);
                $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $randalf=generate_string($permitted_chars, 8);
                $tokenPago=$randalf.$rangonumerico;
                $idPaymentMethod=2;
                $status_pago=0;
                                                
                $data = [
                    'invoiceid' => $invoiceid,
                    'email' => '',
                    'fname' => '',
                    'lname' => '',
                    'reciboid' => $tokenPago,
                    'fechapago' => $fechapago,
                    'couponcode' => $couponcode,
                    'country' => '',
                    'formapago' => $idPaymentMethod,
                    'status_pago' => $status_pago
                ];

                try{

                    $basededatos->connect()->prepare("INSERT INTO `tbl_pays`(`invoiceid`, `email`, 
                    `fname`, `lname`, `reciboid`, `fechapago`, `couponcode`, `country`, `forma_pago`, `status`) 
                    VALUES ( :invoiceid, :email, :fname, :lname, :reciboid, :fechapago, :couponcode, :country, :formapago, :status_pago)")->execute($data);

                    $resPago = array(
                        'respuesta' => 'success',
                        'tokenPago' => $tokenPago,
                        'idMetodoPago' =>  $idPaymentMethod,                        
                        'metodoPago' => $paymenth_method,
                        'carrito' => $carritoArray
                    );

                }catch(PDOException $e){
                    $resPago = array(
                        'respuesta' => 'error',
                        'idPayment' => $idPayment,
                        'idMetodoPago' =>  $idMetodoPago,
                        'clientSecret' => $clienteSecret,
                        'carrito' => $carritoArray
                    );
                }
                

            break;
            case 'credit-card':
                // Crear Intento de Pago   
                try {
                    $crearPaymentIntent = \Stripe\PaymentIntent::create([
                        'amount' => $totalCarrito,
                        'currency' => 'mxn',
                        'description' => $infoOrdenPases['invoiceid'],
                        'application_fee_amount' => number_format(($comisionstripe /1), 2, '', ''),
                    ], ['stripe_account' => $idtienda]);

                    
                    $idPayment=$crearPaymentIntent->id;
                    $clienteSecret=$crearPaymentIntent->client_secret;

                    try{

                        $crearMetododePago = $stripe->paymentMethods->create([
                            'type' => 'card',
                            'card' => [
                                'number' => $infoOrdenPases['cc-number'],
                                'exp_month' => $month,
                                'exp_year' => $year,
                                'cvc' => $infoOrdenPases['cc-cvc'],
                            ],
                        ]);
                
                        $idMetodoPago=$crearMetododePago->id;

                        // if($saveCard==true){
                            
                        //     $dataSaveCard = array(
                        //         'user_id' => $user_id,
                        //         'idPaymentMethod' => $idMetodoPago,
                        //         'fechaIngresoPaymentMethod' => $fechapago
                        //     );

                        //     $querySaveCard=$basededatos->connect()->prepare('INSERT INTO `tbl_metodospagoclientes`(`user_id`, `idPaymentMethod`, `fechaIngreso`) 
                        //     VALUES (:user_id, :idPaymentMethod, :fechaIngresoPaymentMethod)');

                        //     $querySaveCard->execute($dataSaveCard);

                        // }

                        
                        $resPago = array(
                            'idPayment' => $idPayment,
                            'idMetodoPago' =>  $idMetodoPago,
                            'clientSecret' => $clienteSecret,
                            'carrito' => $carritoArray,
                            'metodoPago' => $paymenth_method
                        );

                
                    }catch(\Stripe\Exception\StripeClient $e){
                        http_response_code(500);
                        echo json_encode(['error' => $e->getMessage()]);
                    }

                } catch (\Stripe\Exception\StripeClient $e) {
                    http_response_code(500);
                    echo json_encode(['error' => $e->getMessage()]);
                }
            break;
        }

    }if($respuesta_insertandoOrden['respuesta']=='error'){
        $resPago = array(
            'respuesta' => 'error',
            'mensaje' => $respuesta_insertandoOrden['mensaje']
        );
    }
    header('Content-Type: application/json');
    echo json_encode($resPago);
       
    

    


?>