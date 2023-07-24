<?php 

    $queryEventos="CALL proc_get_eventos_online()";
    $queryEventosExe=$basededatos->connect()->prepare($queryEventos);
    $queryEventosExe->execute();


?>

<section class="container py-5 my-4 my-sm-0 py-sm-6 py-md-7">
    <h2 class="text-center mb-4">Eventos</h2>
    <div class="row pt-5">
        <?php foreach($queryEventosExe->fetchAll(PDO::FETCH_ASSOC) as $row){ ?>
        <div class="col-lg-6">
            <div class="pb-2">
                <a class="card border-0 box-shadow card-hover mx-1" href="event-details?tag_evento=<?= $row['tag'] ?>">                    
                    <div class="card-img-top card-img-gradient">
                        <img src="data:image/png;base64, <?= $row['imageMail'] ?>" alt="<?= $row['nombre'] ?>" style="height:15rem; object-fit:cover;">
                        <span class="card-floating-text text-light font-weight-medium">Comprar pases<i class="fe-chevron-right font-size-lg ml-1"></i></span>
                    </div>
                    <div class="card-body">                                                
                        <ul class="list-unstyled font-size-sm text-muted">
                            <li><h3 class="h5"><?= $row['nombre'] ?></h3></li>
                            <li><span class="text-danger font-weight-medium mr-2"><?= $row['set_fechainicio'] ?></span></li>
                            <li><span class="text-heading font-weight-medium mr-2"><?= $row['sede'] ?> - <?= $row['lugar_evento'] ?></li>                                                        
                        </ul>
                    </div>
                </a>
            </div>
        </div>
        <?php } ?>
    </div>     
</section>