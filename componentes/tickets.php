<div class="col-lg-8">     
    <div class="row">    
        <div class="col-lg-12">        
            <h2 class="h3 pb-3">Información asistentes</h2>

                <?php for ($i=0; $i < $maxPases; $i++) {  ?>
                    <?php if($i==0){ ?>
                        <div class="row integrante ">
                            <div class="col-lg-12 ">
                                <h5 class="h5 border-bottom border-primary">Información del titular</h5>
                            </div>
                            <div class="col-md-4 col-sm-12 ">
                                <div class="form-group m-0">
                                    <label for="nombre"><?= index_nombre ?>:</label> <span class="text-muted">*</span>
                                    <input id="nombre_p" name="nombre_p" type="text" class="form-control form-control-sm" placeholder="<?= index_ingresa_tu_nombre ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 ">
                                <div class="form-group">
                                    <label for="apellidos_p"><?= index_apellidos ?>:</label> <span class="text-muted">*</span>
                                    <input id="apellidos_p" name="apellidos_p" type="text" class="form-control form-control-sm" placeholder="<?= index_ingresa_tus_apellidos ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="email_p"><?= index_correo_electronico ?>:</label> <span class="text-muted">*</span>
                                    <input id="email_p" name="email_p" type="email" class="form-control" placeholder="<?= index_ingresa_tu_correo_electronico ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
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
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="pnumber_p"><?= index_no_telefonico ?>:</label> <span class="text-muted">*</span>
                                    <input  id="pnumber_p" name="pnumber_p" type="number" class="form-control" placeholder="<?= index_no_telefonico ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
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
                        </div>
                    <?php }else{ ?>
                        <div class="row integrante ">
                            <div class="col-lg-12 ">
                                <h5 class="h5 border-bottom border-primary">Información asistente <?= $i+1 ?></h5>
                            </div>
                            <div class="col-md-6 col-sm-12 ">
                                <div class="form-group m-0">
                                    <label for="nombre"><?= index_nombre ?>:</label> <span class="text-muted">*</span>
                                    <input id="nombre_p" name="nombre_p" type="text" class="form-control form-control-sm" placeholder="<?= index_ingresa_tu_nombre ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 ">
                                <div class="form-group">
                                    <label for="apellidos_p"><?= index_apellidos ?>:</label> <span class="text-muted">*</span>
                                    <input id="apellidos_p" name="apellidos_p" type="text" class="form-control form-control-sm" placeholder="<?= index_ingresa_tus_apellidos ?>" required>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
        </div>
        
        <div class="col-md-4">
            
            <div class="form-group">
                <input type="text" name="idform" class="form-control tipoform" value="<?= $form ?>" hidden>
                <input type="text" name="costo" class="form-control costo"  value="<?= $precioPase ?>" hidden>
            </div>
        </div>        
    </div>
</div>