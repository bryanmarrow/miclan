
<section class="container-fluid d-flex align-items-center pt-3 pb-3 pb-md-4" >
    <div class="w-100 pt-3">
        <div class="row">
                <?php


                    require './templates/sidebarAccount.php';

                    $orderid=$_GET['orderid'];
                ?>
                <div class="col-lg-6">
                    <div class="d-flex flex-column h-100 bg-light rounded-lg box-shadow-lg p-4">
                        <div class="py-2 p-md-3">
                            <div class="d-sm-flex align-items-center justify-content-between pb-2">
                                <h1 class="h5 mb-3 text-center text-sm-left">Detalle de orden #(<?= $orderid ?>)</h1>
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
                                    LEFT JOIN tbl_pays ON tbl_orders.invoiceid = tbl_pays.invoiceid
                                    LEFT JOIN tbl_users ON tbl_users.id = tbl_orders.user_id
                                    LEFT JOIN tbl_metodospago ON tbl_pays.forma_pago = tbl_metodospago.id
                                    LEFT JOIN tbl_status_pases ON tbl_orders.statusOrder = tbl_status_pases.id
                                    WHERE tbl_orders.invoiceid='".$orderid."'
                                    ORDER BY tbl_orders.dateorder desc");
                                    $dataoders->execute();
                                
                                    $infoorders=$dataoders->fetch(PDO::FETCH_ASSOC);
                                    
                                    
                                    $queryDetalleGeneralOrden="SELECT
                                    tbl_order_details.invoiceid,
                                    tbl_order_details.sku_product,
                                    tbl_order_details.cantidad,
                                    tbl_order_details.price,
                                    tbl_order_details.subtotalItem,
                                    tbl_pases.descripcion_pase nombreItem
                                    from tbl_order_details 
                                    LEFT JOIN tbl_pases ON tbl_order_details.sku_product = tbl_pases.codigo_pase
                                    where tbl_order_details.invoiceid='".$infoorders['invoiceid']."'";
                                    $detalleGeneralOrden=$basededatos->connect()->prepare($queryDetalleGeneralOrden);
                                    $detalleGeneralOrden->execute();
                                    $fetchGeneralOrden=$detalleGeneralOrden->fetchAll(PDO::FETCH_ASSOC);
                        
                                        
                                    
                                ?>

                                <div class="card">                            
                                    <div class="card-header">
                                        <div class="accordion-heading">
                                            <a class="collapsed d-flex flex-wrap align-items-center justify-content-between pr-4">
                                                <div class="font-size-sm font-weight-medium text-nowrap my-1 mr-2">
                                                    <i class="fe-hash font-size-base mr-1"></i>
                                                    <span class="d-inline-block align-middle"><?= $infoorders['invoiceid'] ?></span>                                            
                                                </div>
                                                <div class="bg-faded-info text-info font-size-xs font-weight-medium py-1 px-3 rounded-sm my-1 mr-2">
                                                    <?= $infoorders['statusOrder'] ?>
                                                </div>
                                                <div class="text-nowrap text-body font-size-sm font-weight-normal my-1 mr-2">
                                                    <i class="fe-clock text-muted mr-1"></i><?= $infoorders['dateorder'] ?>
                                                </div>                                                                                        
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body pt-4 border-top bg-secondary">                                    
                                        <?php                                 
                                            foreach($fetchGeneralOrden as $itemOrden){                                         
                                                
                                        ?>                                                                                
                                            <div class="d-sm-flex justify-content-between mb-3 pb-1">
                                                <div class="order-item media media-ie-fix d-block d-sm-flex mr-sm-3">
                                                    <div
                                                        class="media-body font-size-sm pt-2 pl-sm-3 text-center text-sm-left">
                                                        <h5 class="nav-heading font-size-sm mb-2">
                                                            <?= $itemOrden['nombreItem'] ?>    
                                                        </h5>
                                                        <div><?= $itemOrden['sku_product'] ?></div>                                                        
                                                    </div>
                                                </div>
                                                <div class="font-size-sm text-center pt-2 mr-sm-3">
                                                    <div class="text-muted">Cant:</div>
                                                    <div class="font-weight-sm"><?= $itemOrden['cantidad'] ?>x<?= $itemOrden['price'] ?></div>
                                                </div>
                                                <div class="font-size-sm text-center pt-2">
                                                    <div class="text-muted">Subtotal:</div>
                                                    <div class="font-weight-medium">$ <?= $itemOrden['subtotalItem'] ?></div>
                                                </div>
                                            </div>
                                        <?php 
                                            }
                                        
                                        ?>
                                                                                                        
                                        <div class="d-flex flex-wrap align-items-center justify-content-between pt-1 mt-1 border-top">                                  
                                            <div class="font-size-sm my-1 mr-1">
                                                <span class="text-muted mr-1">Subtotal:</span>
                                                <span class="font-weight-medium">$ <?= $infoorders['subtotal'] ?></span>
                                            </div>                                    
                                            <div class="font-size-sm my-1 mr-1">
                                                <span class="text-muted mr-1">Tax:</span>
                                                <span class="font-weight-medium">$ <?= $infoorders['tax'] ?></span>
                                            </div>
                                            <div class="font-size-sm my-1 mr-1">
                                                <span class="text-muted mr-1">Descuentos:</span>
                                                <span class="font-weight-medium">$ <?= $infoorders['descuentos'] ?></span>
                                            </div>
                                            <div class="font-size-sm my-1">
                                                <span class="text-muted mr-1">Total:</span>
                                                <span class="font-weight-medium">$ <?= $infoorders['total'] ?></span>
                                            </div>
                                    </div>                                        
                                </div>                            
                            </div>                        
                        </div>

                                                              
                    </div>            
                    </div>
                
                </div>  
                <div class="col-lg-4">
                    <div class="row">
                    
                    <div class="col-lg-12 mb-2">
                        <div class="d-flex flex-column h-100 bg-light rounded-lg box-shadow-lg p-4">
                            <div class="d-sm-flex align-items-center justify-content-between pb-2 text-center text-sm-left">
                                <h1 class="h5 text-nowrap">Transacciones                                    
                                </h1>                            
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
                            
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                                        <div class="font-size-sm font-weight-medium text-nowrap my-1 mr-2">
                                            <i class="fe-hash font-size-base mr-1"></i>
                                            <span class="d-inline-block align-middle">
                                                Folio de transacción: <?= $transaccion['reciboid'] ?>
                                            </span>                                            
                                        </div>
                                        
                                        <div class="text-nowrap text-body font-weight-normal my-1 mr-2">
                                            <span class="badge badge-danger"><?= $transaccion['nombre'] ?></span>
                                        </div>                                                                        
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
                                            <a class="badge badge-primary p-1" href="#collapse_<?= $transaccion['reciboid'] ?>" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse_<?= $transaccion['reciboid'] ?>">Ver comprobantes</a>  
                                            <div class="collapse mt-3" id="collapse_<?= $transaccion['reciboid'] ?>" >
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
                                                <?php foreach($infoComprobantes as $row ){ ?>                                                     
                                                    <div class="card bg-secondary">                                                        
                                                        <div class="card-body p-3">
                                                            <div class="d-flex flex-wrap w-100 justify-content-between">
                                                                <div class="font-size-sm">
                                                                    <small><strong>No. de referencia:</strong> <?= $row['numreferencia_comprobante']; ?></small>
                                                                    <p class="card-text font-size-sm m-1">
                                                                        <small>#<?= $row['tokenFile'] ?></small>                                                                        
                                                                    </p>
                                                                    <?= $row['statusComprobante']; ?>
                                                                </div>                                            
                                                                <small class="font-size-sm text-dark mb-2">
                                                                    <a class="btn btn-primary btn-sm mt-3"                                                                                                                             
                                                                        data-fancybox 
                                                                        data-src="../uploads/comprobantes/<?= $row['nombreFile']; ?>?image=251"
                                                                        data-caption="<?= $row['numreferencia_comprobante']; ?>"
                                                                        href="../uploads/comprobantes/<?= $row['nombreFile']; ?>?image=251"    
                                                                        data-toggle="tooltip"
                                                                        title="Ver comprobante de pago"                                                            
                                                                    >                                                         
                                                                        <i class="fe-eye"></i>                                                                        
                                                                    </a>
                                                                </small>
                                                            </div>                                                            
                                                        </div>
                                                    </div>                                                
                                                <?php } ?>                                                                                                
                                            </div>                                     
                                        <?php } ?>
                                        
                                    </div>                                    
                                </div>
                            
                            <?php } ?>    
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="d-flex flex-column h-100 bg-light rounded-lg box-shadow-lg p-4">
                            <div class="py-2 p-md-3">                        
                                <?php 
                                    $queryComentariosOrden="SELECT
                                    tbl_comentarios_orders.comentarios_orden,
                                    tbl_comentarios_orders.fecha_comentario,
                                    CONCAT(tbl_users.fname,' ', tbl_users.lname) nombreUser,
                                    tbl_users.img imagenPerfil
                                    FROM `tbl_comentarios_orders` 
                                    INNER JOIN tbl_users ON tbl_comentarios_orders.user_id = tbl_users.id
                                    where invoiceid_orden='".$orderid."'";
                                    $getComentariosOrden=$basededatos->connect()->prepare($queryComentariosOrden);
                                    $getComentariosOrden->execute();
                                ?>
                                <div class="d-sm-flex align-items-center justify-content-between pb-2 text-center text-sm-left border-bottom">
                                    <h1 class="h5 text-nowrap">Comentarios
                                        <span class="d-inline-block align-middle bg-faded-success text-success font-size-ms font-weight-medium rounded-sm py-1 px-2 ml-2"><?= $getComentariosOrden->rowCount() ?></span>
                                    </h1>                            
                                </div>  

                                <?php                                
                                    foreach($getComentariosOrden->fetchAll(PDO::FETCH_ASSOC) as $comentario){
                                ?>
                                <div class="cs-product-review pb-grid-gutter border-bottom pt-4">                                
                                    <p class="font-size-sm"><?= $comentario['comentarios_orden'] ?></p>
                                    <div class="media media-ie-fix align-items-center mr-3">
                                        <?php 
                                            // $imagenPerfil=is_null($comentario['imagenPerfil']) ? 'assets/img/dashboard/avatar/'.$imageProfileDefault : $comentario['imagenPerfil'];
                                        ?>
                                        <img class="rounded-circle" width="42" src="<?= $imgUser ?>" alt="<?= $comentario['nombreUser'] ?>">
                                        <div class="media-body pl-2 ml-1">
                                            <h6 class="font-size-sm mb-n1"><?= $comentario['nombreUser'] ?></h6>
                                            <span class="font-size-xs text-muted"><?= $comentario['fecha_comentario'] ?></span>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>                        
                                
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
        </div>
            
    </div>
</section>