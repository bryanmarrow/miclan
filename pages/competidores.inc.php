
<section class="container d-flex align-items-center pt-3 pb-3 pb-md-4" style="flex: 1 0 auto;">
    <div class="w-100 pt-3">
        <div class="row">
            <?php
                require './templates/sidebarAccount.php';
            ?>
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="d-flex flex-column h-100 bg-light rounded-lg box-shadow-lg p-4">
                        <div class="py-2 p-md-3">
                            <div class="d-sm-flex align-items-center justify-content-between pb-2 text-center text-sm-left">
                                <h1 class="h3 mb-3 text-nowrap">Competidores
                                    <span class="d-inline-block align-middle bg-faded-success text-success font-size-ms font-weight-medium rounded-sm py-1 px-2 ml-2">
                                        <?php  ?>
                                    </span></h1>
                                <div class="mb-3">
                                    <a class="btn btn-primary btn-sm" href="#nuevoCompetidor" data-toggle="collapse">
                                        <i class="fe-plus mr-2"></i>
                                        Agregar competidor
                                    </a>
                                </div>
                            </div>
                            <div class="collapse" id="nuevoCompetidor">
                                <form class="needs-validation box-shadow rounded mb-4" id="formAgregarCompetidor" novalidate="">
                                    <div class="d-flex align-items-center justify-content-between bg-dark rounded-top py-3 px-4">
                                        <h3 class="font-size-base text-light mb-0">Nuevo competidor</h3>                                        
                                        <a class="close text-light" href="#message-compose" data-toggle="collapse">&times;</a>
                                    </div>
                                    <div class="p-4">
                                    
                                    <div class="row">
                                        <!-- <div class="col-12">
                                            <div class="alert alert-warning alert-dismissible fade show text-center text-dark" role="alert">
                                            <?= index_mensaje_asistentes_2 ?>
                                            </div>
                                        </div> -->
                                        <div class="col-12">
                                            <h5 class="text-dark">
                                                <?= index_informacion_competidor ?>
                                            </h5>
                                            <hr class="mt-2 mb-4">
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="nombre"><?= index_nombre ?>:</label> <span class="text-muted">*</span>
                                                <input id="nombre_p" name="nombre_p" type="text" class="form-control" placeholder="<?= index_ingresa_tu_nombre ?>" required>
                                                <div class="invalid-feedback">Ingrese el nombre del competidor</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="apellidos_p"><?= index_apellidos ?>:</label> <span class="text-muted">*</span>
                                                <input id="apellidos_p" name="apellidos_p" type="text" class="form-control" placeholder="<?= index_ingresa_tus_apellidos ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                            <label><?= index_fecha_de_nacimiento ?>:</label> <span class="text-muted">*</span>
                                            <input class="form-control fecha_nac"  type="date" name="fecha_nac" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label><?= index_genero ?></label>
                                                <div class="pt-3 form-check">
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input class="custom-control-input" type="radio" id="Masculino" name="genero_p" value="Masculino" required>
                                                        <label class="custom-control-label" for="Masculino" ><?= index_masculino  ?></label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input class="custom-control-input" type="radio" id="Femenino" name="genero_p" value="Femenino" required>
                                                        <label class="custom-control-label" for="Femenino"><?= index_femenino ?></label>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="pais_p"><?= index_pais ?>:</label> <span class="text-muted">*</span>
                                                <select class="custom-select" name="pais_p" required>
                                                    <option value=""><?= index_seleccione_su_pais ?></option>
                                                    <?php  
                                                        $paises=$basededatos->connect()->prepare("SELECT * FROM tbl_paises WHERE status=0 order by pais ASC");
                                                        $paises->execute();
                                                        $Allpaises=$paises->fetchAll();
                                                        foreach($Allpaises as $pais){

                                                    ?>
                                                        <option value="<?= $pais['id'] ?>" ><?= $pais['pais'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                        <button class="btn btn-primary" type="submit"><i class="fe-user-plus font-size-lg mr-2"></i>Agregar competidor</button>
                                    </div>
                                </form>
                            </div>

                            <table class="table table-hover mb-0" id="tablaCompetidores">
                                    
                            </table>
                        </div>
                    </div>
            </div>             
        </div>
    </div>
</section>