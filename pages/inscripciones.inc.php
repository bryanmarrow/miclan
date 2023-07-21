
<section class="container d-flex align-items-center pt-3 pb-3 pb-md-4" style="flex: 1 0 auto;">
    <div class="w-100 pt-3">
        <div class="row">
            <?php


                require './templates/sidebarAccount.php';
            ?>
            <div class="col-lg-8">
                <div class="d-flex flex-column h-100 bg-light rounded-lg box-shadow-lg p-4">
                    <div class="py-2 p-md-3">
                        <h1 class="h3 mb-3 pb-2 text-center text-sm-left">Inscripciones</h1>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th># Orden</th>
                                        
                                        <th></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                        $dataoders=$basededatos->connect()->prepare("SELECT * FROM tbl_competencias 
                                        INNER JOIN tbl_categorias ON tbl_competencias.categoria_id = tbl_categorias.id
                                        INNER JOIN tbl_pases ON tbl_pases.codigo_pase = tbl_competencias.tiporegistro
                                        WHERE `user_id`='".$_SESSION['idUserSession']."' GROUP BY registrocompetencia_id");
                                        $dataoders->execute();
                                    
                                        $infoorders=$dataoders->fetchAll();
                                        // var_dump($infoorders);
                                       
                                        foreach($infoorders as $item){

                                            $idregistrocompetencia=$item['registrocompetencia_id'];
                                            $query="SELECT a.*, b.fname, b.lname, b.genero, c.pais
                                            FROM tbl_competencias a
                                            INNER JOIN tbl_competidores b ON a.competidor_id = b.idcompetidor
                                            INNER JOIN tbl_paises c ON b.country = c.id
                                            where a.registrocompetencia_id='$idregistrocompetencia'";
                                            $queryRegistroCompetencia=$basededatos->connect()->prepare($query);
                                            $queryRegistroCompetencia->execute();
                                            $infoCompetidores=$queryRegistroCompetencia->fetchAll(PDO::FETCH_ASSOC);
                                       
                                            
                                    ?>
                                        <tr>
                                            <td>                                                
                                                <?= $item['categoria_es'] ?><br>
                                                <?= $item['registrocompetencia_id'] ?><br>
                                                <?= $item['fecharegistro'] ?>
                                                <div class="d-sm-flex justify-content-between mb-3 pb-1">
                                                    <div class="order-item media media-ie-fix d-block d-sm-flex mr-sm-3">    
                                                        <div class="media-body font-size-sm pt-2 pl-sm-3 text-center text-sm-left">
                                                            <h5 class="nav-heading font-size-sm mb-2"><?= $item['descripcion_pase'] ?></h5>
                                                            <span class="text-muted nav-heading font-size-xs"><?= $item['categoria_es'] ?></span>

                                                            <?php foreach($infoCompetidores as $infocompetidor){ ?>
                                                                <div><span class="text-muted mr-1">-</span><?= $infocompetidor['fname'] ?> <?= $infocompetidor['lname'] ?></div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="font-size-sm text-center pt-2 mr-sm-3">
                                                        <div class="text-muted"><?= $item['registrocompetencia_id'] ?></div>
                                                    </div>
                                                </div>    
                                            </td>
                                            <td>
                                                <a class="nav-link-style mr-2 btn btn-primary btn-sm font-size-xs" href="vieworder?orderid=<?= $item['orden_id'] ?>">
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