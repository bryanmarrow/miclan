
<section class="container-fluid d-flex align-items-center pt-3 pb-3 pb-md-4" style="flex: 1 0 auto;">
    <div class="w-100 pt-3">
        <div class="row">
            <?php


                require './templates/sidebarAccount.php';
            ?>
            <div class="col-lg-8">
                <div class="d-flex flex-column h-100 bg-light rounded-lg box-shadow-lg p-4">
                    <div class="py-2 p-md-3">
                        <h1 class="h3 mb-3 pb-2 text-center text-sm-left">Ordenes de compra</h1>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th># Orden</th> 
                                        <th>Status</th>                                       
                                        <th>Acciones</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                        $dataoders=$basededatos->connect()->prepare("SELECT tbl_orders.invoiceid, tbl_orders.dateorder, tbl_status_pases.nombre nombreStatus FROM tbl_orders 
                                        INNER JOIN tbl_status_pases ON tbl_orders.statusOrder = tbl_status_pases.id
                                        WHERE tbl_orders.user_id='".$_SESSION['idUserSession']."' order by tbl_orders.dateorder desc");
                                        $dataoders->execute();
                                    
                                        $infoorders=$dataoders->fetchAll();
                                        // var_dump($infoorders);

                                        
                                        
                                        foreach($infoorders as $item){
                                            
                                    ?>
                                        <tr>
                                            <td>
                                                <?= $item['invoiceid'] ?><br>
                                                <?= $item['dateorder'] ?>
                                            </td>
                                            <td>
                                                <span><?= $item['nombreStatus'] ?></span>
                                            </td>
                                            <td>
                                                <a class="nav-link-style mr-2 btn btn-primary btn-sm font-size-xs" href="vieworder?orderid=<?= $item['invoiceid'] ?>">
                                                    <i class="fe-eye"></i>
                                                    Ver detalles
                                                </a>
                                            </td>
                                        </tr>
                                    
                                    <?php


                                            
                                        }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            
          
        </div>
        </div>
    </div>
</section>