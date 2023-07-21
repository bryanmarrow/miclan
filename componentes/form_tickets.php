<?php if($form=='framepic'){ ?>
    <div class="col-lg-8">     
        <div class="row">

            <div class="col-12">
                <h5 class="text-dark">
                    <?= index_envianostufoto ?>
                </h5>
                <small class="font-weight-normal"><?= index_todas_las_fotografias_enviadas ?> <a href="https://facebook.com/eurosonlatino" target="_blank">Facebook  Euroson Latino World Salsa Championship </a> </small>
                <hr class="mt-2 mb-4">
            </div>
            
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label for="cod_insc"><?= index_codigo_de_inscripcion ?>:</label> <span class="text-muted">*</span>
                    <input id="cod_insc" name="cod_insc" type="text" class="form-control mb-3" placeholder="<?= index_placeholder_ingresa_codinsc ?>" required>
                    <div class="invalid-feedback"><?= index_campo_requerido ?></div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label for="select-input"><?= index_tipo_de_categoria ?></label>
                    <select class="form-control custom-select" name="tipocategoria" id="select-input" required>
                        <option value=""><?= index_seleccione_su_categoria ?></option>
                        <option value="solistas"><?= index_solistas ?></option>
                        <option value="parejas"><?= index_parejas ?></option>
                        <option value="grupos"><?= index_grupos ?></option>
                    </select>
                    <div class="invalid-feedback"><?= index_seleccione_una_opcion ?></div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 pb-4">
                
                <div class="cs-file-drop-area">
                <div class="cs-file-drop-icon czi-cloud-upload"></div>
                <span class="cs-file-drop-message"><?= index_arrastra_y_suleta_aqui_tu_archivo_para_subir ?></span>
                <input type="file" class="cs-file-drop-input" name="imagen_p" id="imagen_p" accept="image/jpg, image/png" required>
                <button type="button" class="cs-file-drop-btn btn btn-primary btn-sm"><?= index_o_selecciona_tu_archivo?></button>
                <div class="invalid-feedback"><?= index_mensaje_input_archivo ?></div>
                </div>
                
            </div>
            <input type="text" name="idform" class="form-control tipoform" value="<?= $form ?>" hidden>
            <div class="col-md-12">
            <small class="text-danger"><?= index_notaimportante ?>:</small>
            <small class="font-weight-normal pt-3"><?= index_texto_formenviarfoto ?></small>
            </div>
            <div class="col-md-12 col-sm-12 pt-3">
                <button type="submit" class="btn btn-primary btn-block"><?= index_enviar_imagen ?></button>
            </div>
           
        </div>
        
    </div>



<?php } ?>
<?php if($form=='liquidar-pase') { ?>
   

<?php } ?>
<?php if($form=='registro-reservacion') { ?>
    <div class="col-lg-12">     
        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning alert-dismissible fade show text-center text-dark" role="alert">
                <?= index_mensaje_asistentes_2 ?>
                </div>
            </div>
            <div class="col-12">
                <h5 class="text-dark">
                        <?= index_details ?>
                </h5>
                <hr class="mt-2 mb-4">
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="nombre"><?= index_nombre ?>:</label> <span class="text-muted">*</span>
                    <input id="nombre_p" name="nombre_p" type="text" class="form-control" placeholder="<?= index_ingresa_tu_nombre ?>" required>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="apellidos_p"><?= index_apellidos ?>:</label> <span class="text-muted">*</span>
                    <input id="apellidos_p" name="apellidos_p" type="text" class="form-control" placeholder="<?= index_ingresa_tus_apellidos ?>" required>
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
                    <label for="pnumber_p"><?= index_no_telefonico ?>:</label> <span class="text-muted">*</span>
                    <input id="pnumber_p" name="pnumber_p" type="tel" class="form-control" placeholder="<?= index_no_telefonico ?>" required>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="hotel_num"><?= index_hotelnum ?>:</label> <span class="text-muted">*</span>
                    <input id="hotel_num" name="hotel_num" type="text" class="form-control hotel_num" placeholder="<?= index_ingresa_hotelnum ?>" required>
                </div>
            </div>
            <div class="col-md-4">
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
                            <option value="<?= $pais['pais'] ?>" ><?= $pais['pais'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="form-group">
                <label><?= index_fecha_entrada ?>:</label> <span class="text-muted">*</span>
                <input class="form-control fecha_entrada"  type="date" name="fecha_entrada" required>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="form-group">
                <label><?= index_fecha_salida ?>:</label> <span class="text-muted">*</span>
                <input class="form-control fecha_salida"  type="date" name="fecha_salida" required>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label for="num_habitaciones"><?= index_num_habitaciones ?>:</label> <span class="text-muted">*</span>
                    <select class="custom-select" name="num_habitaciones" required>
                        <option value="">0</option>
                        <?php for ($i=1; $i < 21 ; $i++) {  ?>
                            <option value="<?php print($i); ?>"><?php print($i); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label for="num_habitaciones"><?= index_num_huespedes ?>:</label> <span class="text-muted">*</span>
                    <select class="custom-select" id="huespedes_hotel" name="huespedes_hotel" onchange="huespedeshotel(this.value)"; required>
                        <option value="">0</option>
                        <?php for ($i=1; $i < 20 ; $i++) {  ?>
                            <option value="<?php print($i); ?>"><?php print($i); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="idform" class="form-control tipoform" value="<?= $form ?>" hidden>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 pb-4">
            <label for="comprobante_p"><?= index_adjuntar_comprobante ?>:</label> <span class="text-muted">*</span>
                <div class="cs-file-drop-area">
                <div class="cs-file-drop-icon czi-cloud-upload"></div>
                <span class="cs-file-drop-message"><?= index_arrastra_y_suleta_aqui_tu_archivo_para_subir ?></span>
                <input type="file" class="cs-file-drop-input" name="imagen_p" id="comprobante_p" accept="application/pdf, image/jpg, image/png" required>
                <button type="button" class="cs-file-drop-btn btn btn-primary btn-sm"><?= index_o_selecciona_tu_archivo?></button>
                <div class="invalid-feedback"><?= index_mensaje_input_comprobante ?></div>
                </div>
                
            </div>
        </div>
        <div class="row" id="huespedes">    
        </div>
        <button class="btn btn-primary" type="submit"><?= index_enviar_registro ?></button>
    </div>

<?php } if($form=='elwsc2023promo5x4') { ?>
    <div class="col-lg-8">     
        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning alert-dismissible fade show text-center text-dark" role="alert">
                <?= index_mensaje_asistentes_2 ?>
                </div>
            </div>
            <!-- <div class="col-12">
                <h5 class="text-dark">
                    <?= index_details ?>
                </h5>
                <hr class="mt-2 mb-4">
            </div> -->
            <div class="col-lg-12 pb-2">
                
                <div class="row integrante ">
                    <div class="col-lg-12 m-0 p-0">
                        <h2 class="h3 pb-3">Información del titular</h2>
                    </div>
                    <div class="col-md-3 col-sm-12 m-0 p-1">
                        <div class="form-group m-0">
                            <label for="nombre"><?= index_nombre ?>:</label> <span class="text-muted">*</span>
                            <input id="nombre_p" name="nombre_p" type="text" class="form-control form-control-sm" placeholder="<?= index_ingresa_tu_nombre ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 m-0 p-1">
                        <div class="form-group m-0">
                            <label for="apellidos_p"><?= index_apellidos ?>:</label> <span class="text-muted">*</span>
                            <input id="apellidos_p" name="apellidos_p" type="text" class="form-control form-control-sm" placeholder="<?= index_ingresa_tus_apellidos ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 m-0 p-1">
                        <div class="form-group m-0">
                            <label for="email_p"><?= index_correo_electronico ?>:</label> <span class="text-muted">*</span>
                            <input id="email_p" name="email_p" type="email" value="" class="form-control form-control-sm" placeholder="<?= index_ingresa_tu_correo_electronico ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 m-0 p-1">
                        <div class="form-group">
                            <label for="pais_p"><?= index_pais ?>:</label> <span class="text-muted">*</span>
                            <select class="custom-select custom-select-sm" name="pais_p" required>
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
                        <?php if( $form=='tickets'){ ?>
                            <div class="alert alert-danger font-size-lg mb-5 cupondiv" role="alert">
                                <i class="fe-alert-circle font-size-xl mt-n1 mr-3"></i>
                                <?= index_tiene_cupon ?> 
                                <a href='#modal-coupon' data-toggle='modal' class='alert-link'><?= index_agregar_cupon ?></a>
                            </div>
                        <?php } ?>
                    </div>
                    
                </div>

                <h2 class="h3 pb-3">Información asistentes</h2>

                <?php for ($i=0; $i < 4; $i++) {  ?>
                    <div class="row integrante ">
                        <div class="col-lg-12 m-0 p-0">
                            <h5 class="h5 m-0 p-0 border-bottom border-primary">Información asistente <?= $i+1 ?></h5>
                        </div>
                        <div class="col-md-6 col-sm-12 m-0 p-1">
                            <div class="form-group m-0">
                                <label for="nombre"><?= index_nombre ?>:</label> <span class="text-muted">*</span>
                                <input id="nombre_p" name="nombre_p" type="text" class="form-control form-control-sm" placeholder="<?= index_ingresa_tu_nombre ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 m-0 p-1">
                            <div class="form-group m-0">
                                <label for="apellidos_p"><?= index_apellidos ?>:</label> <span class="text-muted">*</span>
                                <input id="apellidos_p" name="apellidos_p" type="text" class="form-control form-control-sm" placeholder="<?= index_ingresa_tus_apellidos ?>" required>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>        
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="idform" class="form-control tipoform" value="<?= $form ?>" hidden>
                    <input type="text" name="costo" class="form-control costo"  value="<?= $precioPase ?>" hidden>
                </div>
            </div>
            
            <div class="col-md-12 col-sm-12 m-0 p-1">
                <h2 class="h3 pb-3"><?= index_informacion_adicional ?></h2>
                <div class="form-group pb-3 pb-lg-5">
                    <label class="form-label" for="ch-order-notes"><?= index_notas_de_orden ?></label>
                    <textarea class="form-control" id="ch-order-notes" rows="3" placeholder="<?= index_placeholder_notas_orden ?>" name="notas_orden"></textarea>
                </div>
            </div>
            
        </div>
        
    </div>
<?php  } ?>
