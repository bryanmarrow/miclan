
<section class="container d-flex align-items-center pt-3 pb-3 pb-md-4" style="flex: 1 0 auto;">
    <div class="w-100 pt-3">
        <div class="row">
            <?php


                require './templates/sidebarAccount.php';

                $orderid=$_GET['orderid'];
            ?>
            <div class="col-lg-8">
                <div class="d-flex flex-column h-100 bg-light rounded-lg box-shadow-lg p-4">
                    <div class="py-2 p-md-3">
                        <div class="d-sm-flex align-items-center justify-content-between pb-2">
                            <h1 class="h3 mb-3 text-center text-sm-left">Ordenes de compra</h1>
                        </div>
                        <div class="accordion pb-4" id="orders-accordion">
                            <?php 
                                $dataoders=$basededatos->connect()->prepare("SELECT
                                tbl_orders.invoiceid,
                                tbl_orders.dateorder,
                                tbl_orders.subtotal,
                                tbl_orders.tax,
                                tbl_orders.total,
                                tbl_orders.descuentos,
                                tbl_pays.reciboid tokentransaccion,
                                tbl_pays.fechapago fechapago,
                                tbl_users.fname,
                                tbl_users.lname,
                                tbl_metodospago.descripcion metodoPago,
                                tbl_status_pases.nombre statusOrder,
                                tbl_orders.statusOrder idStatus
                                FROM tbl_orders
                                INNER JOIN tbl_pays ON tbl_orders.invoiceid = tbl_pays.invoiceid
                                INNER JOIN tbl_users ON tbl_users.id = tbl_orders.user_id
                                INNER JOIN tbl_metodospago ON tbl_pays.forma_pago = tbl_metodospago.id
                                INNER JOIN tbl_status_pases ON tbl_orders.statusOrder = tbl_status_pases.id
                                WHERE tbl_orders.invoiceid='".$orderid."'
                                ORDER BY tbl_orders.dateorder desc");
                                $dataoders->execute();
                            
                                $infoorders=$dataoders->fetch(PDO::FETCH_ASSOC);

                                
                                $anumber=0;
                                // foreach($infoorders as $item){
                                    

                                    

                                    $infoPases=$basededatos->connect()->prepare("
                                    SELECT 
                                    a.invoiceid,
                                    a.fname,
                                    a.lname,
                                    a.token,
                                    a.idform,
                                    a.status,
                                    b.codigo_pase,
                                    b.descripcion_pase,
                                    b.precio,
                                    b.divisa                                
                                    FROM tbl_ordenes a
                                    INNER JOIN tbl_pases b ON a.idform = b.codigo_pase                                
                                    where a.invoiceid='".$infoorders['invoiceid']."'");
                                    $infoPases->execute();
                                    $fetchInfoPases=$infoPases->fetchAll(PDO::FETCH_ASSOC);

                                    $infoCompetidores=$basededatos->connect()->prepare("SELECT a.registrocompetencia_id, 
                                    a.fecharegistro, a.tiporegistro, a.orden_id, b.categoria_es, b.categoria_en, c.descripcion_pase
                                    FROM tbl_competencias a
                                    INNER JOIN tbl_categorias b ON a.categoria_id = b.id
                                    INNER JOIN tbl_pases c ON a.tiporegistro = c.codigo_pase
                                    where a.orden_id='".$infoorders['invoiceid']."'
                                    GROUP BY a.registrocompetencia_id
                                    ");
                                    $infoCompetidores->execute();
                                    $fetchinfoCompetidores=$infoCompetidores->fetchAll(PDO::FETCH_ASSOC);
                                    

                                    // var_dump($fetchInfoPases);
                                    // var_dump($fetchinfoCompetidores);
                                    
                                
                            ?>

                            <div class="card">
                            
                                <div class="card-header">
                                    <div class="accordion-heading">
                                        <a class="collapsed d-flex flex-wrap align-items-center justify-content-between pr-4">
                                            <div class="font-size-sm font-weight-medium text-nowrap my-1 mr-2">
                                                <i class="fe-hash font-size-base mr-1"></i>
                                                <span class="d-inline-block align-middle"><?= $infoorders['invoiceid'] ?></span>                                            
                                            </div>
                                            <div
                                            class="bg-faded-info text-info font-size-xs font-weight-medium py-1 px-3 rounded-sm my-1 mr-2">
                                            <?= $infoorders['statusOrder'] ?></div>
                                            <div class="text-nowrap text-body font-size-sm font-weight-normal my-1 mr-2"><i
                                                class="fe-clock text-muted mr-1"></i><?= $infoorders['dateorder'] ?></div>
                                            

                                            
                                            <!-- <div class="text-body font-size-sm font-weight-medium my-1"></div> -->
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse <?php if($anumber==0){ echo 'show'; }  ?>" id="<?= $infoorders['invoiceid'] ?>" data-parent="#orders-accordion">
                                    <div class="card-body pt-4 border-top bg-secondary">
                                    
                                    <?php 
                                        $order=[];
                                        
                                        

                                        foreach($fetchInfoPases as $datosPase){
                                            // var_dump($datosPase);
                                            
                                            $paseSeparado=[];
                                            $paseSeparado['sku'] = $datosPase['idform'];
                                            $paseSeparado['quantity'] = 1;

                                            array_push($order, $paseSeparado);

                                            // $order[]=$datosPase['precio'];

                                    ?>
                                    <!-- Item-->
                                
                                    <div class="d-sm-flex justify-content-between mb-3 pb-1">
                                        <div class="order-item media media-ie-fix d-block d-sm-flex mr-sm-3">
                                            
                                        <div class="media-body font-size-sm pt-2 pl-sm-3 text-center text-sm-left">
                                            <h5 class="nav-heading font-size-sm mb-2"><a href="#"><?= $datosPase['descripcion_pase'] ?></a></h5>
                                            <div><span class="text-muted mr-1">Nombre:</span><?= $datosPase['fname'] ?> <?= $datosPase['lname'] ?></div>
                                            
                                        </div>
                                        </div>
                                        <div class="font-size-sm text-center pt-2 mr-sm-3">
                                        <div class="text-muted"><?= $datosPase['token'] ?></div>
                                        <div class="font-weight-medium"></div>
                                        </div>
                                        <!-- <div class="font-size-sm text-center pt-2">
                                        <div class="text-muted">Precio:</div>
                                        <div class="font-weight-medium">$ <?= $datosPase['precio'] ?></div>
                                        </div> -->
                                    </div>
                                    <?php 


                                        }

                                        // $infoOrdenPases=calcularPrecio($order);


                                        // $stripe = new \Stripe\StripeClient(
                                        //     'sk_test_51LVia2B4srLF6gvb7ndYe400JESBqXBxwug741KSDB2Vtz1Nl8kpEUuicJGxMRTmEA0uECa1V8F0NZWHtJG1K4OU00lgierdEC'
                                        // );
                                    
                                    
                                        
                                        // $cargoStripe = $stripe->paymentIntents->retrieve(
                                        //     $datosPase['idPagoStripe'],
                                        //     []
                                        // );

                                        // $metodoPago = $stripe->paymentMethods->retrieve(
                                        //     $cargoStripe['payment_method'],
                                        //     []
                                        // );

                                        // // var_dump($metodoPago['card']);

                                        // $marca=$metodoPago['card']['brand'];
                                        // $number=$metodoPago['card']['last4'];

                                        $querySolistas="SELECT a.*, b.fname, b.lname, b.genero, c.pais, d.categoria_es
                                        FROM tbl_solistas a
                                        INNER JOIN tbl_competidores b ON a.idCompetidor = b.id
                                        INNER JOIN tbl_paises c ON b.country = c.id
                                        INNER JOIN tbl_categorias d ON a.idCategoria = d.id                                    
                                        where a.invoiceid='".$infoorders['invoiceid']."'";
                                        $queryRegistroCompetenciaSolistas=$basededatos->connect()->prepare($querySolistas);
                                        $queryRegistroCompetenciaSolistas->execute();
                                        $infoCompetidoresSolistas=$queryRegistroCompetenciaSolistas->fetchAll(PDO::FETCH_ASSOC);

                                        if($queryRegistroCompetenciaSolistas->rowCount()>0){
                                            foreach($infoCompetidoresSolistas as $infoSolista){
                                    ?>
                                            <div class="d-sm-flex justify-content-between mb-3 pb-1">
                                                <div class="order-item media media-ie-fix d-block d-sm-flex mr-sm-3">    
                                                    <div class="media-body font-size-sm pt-2 pl-sm-3 text-center text-sm-left">
                                                        <h5 class="nav-heading font-size-sm mb-2"><?= $infoSolista['categoria_es'] ?></h5>


                                                        
                                                            <div><span class="text-muted mr-1">-</span><?= $infoSolista['fname'] ?> <?= $infoSolista['lname'] ?></div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="font-size-sm text-center pt-2 mr-sm-3">
                                                    <div class="text-muted"><?= $infoSolista['registro_token'] ?></div>
                                                </div>
                                            </div>   
                                    <?php                                                   
                                            }
                                        }
                                        $queryParejas="SELECT a.*, b.fname, b.lname, c.fname, c.lname, CONCAT(b.fname,' y ',c.fname) nombrePareja, b.genero, d.categoria_es
                                        FROM tbl_parejas a
                                        INNER JOIN tbl_competidores b ON a.idCompetidor_p1 = b.id
                                        INNER JOIN tbl_competidores c ON a.idCompetidor_p2 = c.id                                    
                                        INNER JOIN tbl_categorias d ON a.idCategoria = d.id                                    
                                        where a.invoiceid='".$infoorders['invoiceid']."'";
                                        $queryRegistroCompetenciaParejas=$basededatos->connect()->prepare($queryParejas);
                                        $queryRegistroCompetenciaParejas->execute();
                                        $infoCompetidoresParejas=$queryRegistroCompetenciaParejas->fetchAll(PDO::FETCH_ASSOC);
                                        
                                        // var_dump($infoorders['invoiceid']);
                                        
                                        if($queryRegistroCompetenciaParejas->rowCount()>0){
                                            foreach($infoCompetidoresParejas as $infoPareja){
                                    ?>
                                    
                                                <div class="d-sm-flex justify-content-between mb-3 pb-1">
                                                    <div class="order-item media media-ie-fix d-block d-sm-flex mr-sm-3">    
                                                        <div class="media-body font-size-sm pt-2 pl-sm-3 text-center text-sm-left">
                                                            <h5 class="nav-heading font-size-sm mb-2"><?= $infoPareja['categoria_es'] ?></h5>


                                                            
                                                                <div><span class="text-muted mr-1">-</span><?= $infoPareja['nombrePareja'] ?></div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="font-size-sm text-center pt-2 mr-sm-3">
                                                        <div class="text-muted"><?= $infoPareja['registro_token'] ?></div>
                                                    </div>
                                                </div>  
                                    <?php 
                                        }
                                        }
                                        $queryGrupos="SELECT tbl_grupos.*, tbl_categorias.categoria_es
                                        FROM tbl_grupos                                   
                                        INNER JOIN tbl_categorias ON tbl_grupos.idCategoria = tbl_categorias.id
                                        where tbl_grupos.invoiceid='".$infoorders['invoiceid']."'";
                                        $queryRegistroCompetenciaGrupos=$basededatos->connect()->prepare($queryGrupos);
                                        $queryRegistroCompetenciaGrupos->execute();
                                        $infoCompetidoresGrupos=$queryRegistroCompetenciaGrupos->fetchAll(PDO::FETCH_ASSOC);
                                        
                                        // var_dump($infoorders['invoiceid']);
                                        
                                        if($queryRegistroCompetenciaGrupos->rowCount()>0){
                                            foreach($infoCompetidoresGrupos as $infoGrupos){                                            
                                    ?>

                                        <div class="d-sm-flex justify-content-between mb-3 pb-1">
                                            <div class="order-item media media-ie-fix d-block d-sm-flex mr-sm-3">    
                                                <div class="media-body font-size-sm pt-2 pl-sm-3 text-center text-sm-left">
                                                    <h5 class="nav-heading font-size-sm mb-2"><?= $infoGrupos['categoria_es'] ?></h5>                                                
                                                    <div><span class="text-muted mr-1">-</span><?= $infoGrupos['nombreGrupo'] ?> </div>
                                                </div>
                                            </div>
                                            <div class="font-size-sm text-center pt-2 mr-sm-3">
                                                <div class="text-muted"><?= $infoGrupos['registro_token'] ?></div>
                                            </div>
                                        </div>    
                                        
                                    <?php
                                        }
                                        }                                                                        
                                    ?>                                                                        
                                    <div class="d-flex flex-wrap align-items-center justify-content-between pt-1 mt-1 border-top">                                  
                                        <div class="font-size-sm my-1 mr-1"><span class="text-muted mr-1">Subtotal:</span><span
                                            class="font-weight-medium">$ <?= $infoorders['subtotal'] ?></span></div>                                    
                                        <div class="font-size-sm my-1 mr-1"><span class="text-muted mr-1">Tax:</span><span
                                            class="font-weight-medium">$ <?= $infoorders['tax'] ?></span></div>
                                        <div class="font-size-sm my-1 mr-1"><span class="text-muted mr-1">Descuentos:</span><span
                                            class="font-weight-medium">$ <?= $infoorders['descuentos'] ?></span></div>
                                        <div class="font-size-sm my-1"><span class="text-muted mr-1">Total:</span><span
                                            class="font-weight-medium">$ <?= $infoorders['total'] ?></span></div>
                                    </div>
                                        
                                    </div>
                                    

                                        
                                </div>
                                
                            </div>
                            <?php


                                    $anumber++;
                                // }
                            ?>
                        
                            
                        </div>
                        <div class="d-sm-flex align-items-center justify-content-between pb-2">
                            <h1 class="h6 mb-3 text-center text-sm-left">Transacciones</h1>
                        </div>
                        <?php
                                $dataTransacciones=$basededatos->connect()->prepare("SELECT
                                tbl_metodospago.descripcion,
                                tbl_pays.reciboid,
                                tbl_pays.fechapago,
                                tbl_status_pases.nombre,
                                tbl_pays.forma_pago
                                FROM tbl_pays
                                INNER JOIN tbl_metodospago ON tbl_pays.forma_pago = tbl_metodospago.id
                                INNER JOIN tbl_status_pases ON tbl_pays.status = tbl_status_pases.id
                                WHERE invoiceid='".$infoorders['invoiceid']."'");
                                $dataTransacciones->execute();

                                $infoTransacciones=$dataTransacciones->fetchAll(PDO::FETCH_ASSOC);
                                
                                foreach($infoTransacciones as $transaccion){
                                
                        ?>                            
                            <div>
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex flex-wrap w-100 justify-content-between">
                                            <small class="font-size-sm font-weight-medium my-1 mr-1 text-dark mr-2">
                                                Folio: <?= $transaccion['reciboid'] ?>
                                            </small>  
                                            <small class="text-dark opacity">
                                                <h6><span class="badge badge-danger"><?= $transaccion['nombre'] ?></span></h6>
                                            </small>  
                                        </div>
                                    </div>
                                    <div class="card-body py-2">                                                                                
                                        <div class="d-flex flex-wrap w-100 justify-content-between">
                                            <div class="font-size-sm">
                                                <span class="text-muted mr-1">Metodo de pago:</span>
                                                <span class="font-weight-medium"><?= $transaccion['descripcion'] ?></span>
                                            </div>                                            
                                            <small class="font-size-sm text-dark mb-2"><?= $transaccion['fechapago'] ?></small>
                                        </div>    
                                        <?php if($transaccion['forma_pago']==2){ ?>
                                            <a class="badge badge-primary p-1" href="#collapseExample" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseExample">Ver comprobantes</a>  
                                            <div class="collapse mt-3" id="collapseExample" >
                                                <?php
                                                        $dataComprobantes=$basededatos->connect()->prepare("SELECT
                                                        tbl_comprobantes_pago.nombreFile,
                                                        tbl_comprobantes_pago.tokenFile,
                                                        tbl_comprobantes_pago.monto_comprobante,
                                                        tbl_comprobantes_pago.numreferencia_comprobante,
                                                        tbl_status_comprobantes.tagHtml statusComprobante
                                                        FROM tbl_comprobantes_pago
                                                        INNER JOIN tbl_status_comprobantes ON tbl_comprobantes_pago.status_comprobante = tbl_status_comprobantes.id
                                                        WHERE tbl_comprobantes_pago.tokenPago='".$transaccion['reciboid']."'");
                                                        $dataComprobantes->execute();

                                                        $infoComprobantes=$dataComprobantes->fetchAll(PDO::FETCH_ASSOC);
                                                        
                                                ?>
                                                <div class="table-responsive font-size-sm">
                                                    <table class="table table-hover mb-0 table-sm">
                                                        <thead>
                                                        <tr>
                                                            <th>Folio de comprobante</th>
                                                            <th>No. de referencia</th>                                                    
                                                            <th>Status comprobante</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php foreach($infoComprobantes as $row ){ ?>
                                                        <tr>         
                                                            <td class="py-3 align-middle"><?= $row['tokenFile']; ?></td>                                           
                                                            <td class="py-3 align-middle">
                                                                <a class="nav-link-style" 
                                                                    data-toggle="tooltip" title="Ver comprobante de pago"
                                                                    title="Ver comprobante de pago" 
                                                                    data-fancybox 
                                                                    data-src="../uploads/comprobantes/<?= $row['nombreFile']; ?>?image=251"
                                                                    data-caption="<?= $row['numreferencia_comprobante']; ?>"
                                                                    href="../uploads/comprobantes/<?= $row['nombreFile']; ?>?image=251" 
                                                                >
                                                                    <?= $row['numreferencia_comprobante']; ?>
                                                                    <i class="fe-eye mr-2"></i>
                                                                </a>    
                                                            </td>
                                                            
                                                            <td class="py-3 align-middle">
                                                                <?= $row['statusComprobante']; ?>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>   
                                            </div>                                     
                                        <?php } ?>
                                        
                                    </div>                                    
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                                
          
        </div>
        </div>
    </div>
</section>