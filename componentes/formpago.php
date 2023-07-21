<?php if($tipoform==0 && $form=='ELWSC2023INSCSOL') {?>
    <div class="col-lg-8">
        <div class="row">            
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
                    <label for="email_p"><?= index_correo_electronico ?>:</label> <span class="text-muted">*</span>
                    <input id="email_p" name="email_p" type="email" class="form-control" placeholder="<?= index_ingresa_tu_correo_electronico ?>" required>
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
            <div class="col-md-6">
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
            <div class="col-md-6 ">
                <div class="form-group">
                    <label for="categoria_p"><?= index_categoria ?>:</label> <span class="text-muted">*</span>
                    <select class="custom-select" name="categoria_p" required>
                        <option value=""><?= index_seleccione_su_categoria ?></option>
                        <?php
                            $tabla='solistas';
                            $lang=isset($_SESSION['lang']) ? $_SESSION['lang'] : 'es';
                            $querycategorias="SELECT a.idCategoria, b.categoria_es, b.categoria_en
                            FROM tbl_categorias_eventos a
                            INNER JOIN tbl_categorias b ON a.idCategoria = b.id
                            INNER JOIN tbl_eventos c ON a.idEvento = c.id
                            WHERE c.token ='$tokenEvento' and b.tipo='$tabla'
                            ORDER BY b.categoria_$lang ASC";
                            $categorias=$basededatos->connect()->prepare($querycategorias);
                            $categorias->execute();     
                            $Allcategorias=$categorias->fetchAll(PDO::FETCH_ASSOC);

                            

                            foreach($Allcategorias as $categoria){    
                        ?>
                            <option value="<?= $categoria['idCategoria'] ?>" ><?= $categoria['categoria_'.$lang] ?></option>
                        <?php } ?>
                        
                    </select>
                    <label for="categoria_p" class="error"></label>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="hotel_num"><?= index_hotelnum ?>:</label> <span class="text-muted">*</span>
                    <input id="hotel_num" name="hotel_num" type="text" class="form-control hotel_num" placeholder="<?= index_ingresa_hotelnum ?>" required>
                    <small id="alertahotelnum" class="text-danger font-weight-bold" style="display:none">Cupón no existente.</small>
                    <!-- <h4 id="alertahotelnum" class="" >Cupón no existente.</h4> -->
                    <!-- <label id="alertahotelnum" class="form-check-label text-danger font-weight-bold" >Cupón no existente.</label> -->
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="codFullPass"><?= index_codconfirmfullpass ?>:</label> <span class="text-muted">*</span>
                    <input id="codFullPass" name="codFullPass" type="text" class="form-control codFullPass" placeholder="<?= index_ingresacodconfirmfullpass ?>" required>
                    <small id="alertacodconfirmFullPass" class="text-danger font-weight-bold" style="display:none">Cupón no existente.</small>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="alert alert-danger font-size-lg mb-5 cupondiv" role="alert">
                    <i class="fe-alert-circle font-size-xl mt-n1 mr-3"></i>
                    <?= index_tiene_cupon ?> 
                    <a href='#modal-coupon' data-toggle='modal' class='alert-link'><?= index_agregar_cupon ?></a>
                </div>
            </div> 
            <input type="text" name="idform" class="form-control tipoform" value="<?= $form ?>" hidden>
            <input type="text" name="costo" class="form-control costo"  value="<?= $precioPase ?>" hidden>
        </div>
    </div>
<?php  } ?>
<?php if($tipoform==0 && $form=='ELWSC2023INSCPAR'){ ?>

    <div class="row">
        <div class="col-lg-8">
            <?php for ($i=1; $i < 3; $i++) { ?>
                <div class="row">
                    <div class="col-12">
                        <h5 class="text-dark">
                        <?=  index_informacion_competidor ?> <?php print($i) ?>
                        </h5>
                        <hr class="mt-2 mb-4">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="nombre_p<?php print($i) ?>"><?= index_nombre ?>:</label> <span class="text-muted">*</span>
                            <input id="nombre_p<?php print($i) ?>" name="nombre_p<?php print($i) ?>" type="text" class="form-control" placeholder="<?= index_ingresa_tu_nombre ?>" required>
                            <div class="invalid-feedback"><?= index_campo_requerido ?></div>
                        </div>
                    </div>
                
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="apellidos_p<?php print($i) ?>"><?= index_apellidos ?>:</label> <span class="text-muted">*</span>
                            <input id="apellidos_p<?php print($i) ?>" name="apellidos_p<?php print($i) ?>" type="text" class="form-control" placeholder="<?= index_ingresa_tus_apellidos ?>" required>
                            <div class="invalid-feedback"><?= index_campo_requerido ?></div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                        <label><?= index_fecha_de_nacimiento ?>:</label> <span class="text-muted">*</span>
                        <input class="form-control"  type="date" name="date_birthday_p<?php print($i) ?>" required>
                        <div class="invalid-feedback"><?= index_campo_requerido ?></div>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="email_p<?php print($i) ?>"><?= index_correo_electronico ?>:</label> <span class="text-muted">*</span>
                            <input id="email_p<?php print($i) ?>" name="email_p<?php print($i) ?>" type="email" class="form-control" placeholder="<?= index_ingresa_tu_correo_electronico ?>" required>
                            <div class="invalid-feedback"><?= index_campo_requerido ?></div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <fieldset class="form-group">
                            <label><?= index_genero ?></label>
                            <div class="pt-3 form-check">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="Masculino<?php print($i) ?>" value="Masculino" name="genero_p<?php print($i) ?>" required>
                                    <label class="custom-control-label" for="Masculino<?php print($i) ?>"><?= index_masculino ?></label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="Femenino<?php print($i) ?>" value="Femenino" name="genero_p<?php print($i) ?>" required>
                                    <label class="custom-control-label" for="Femenino<?php print($i) ?>"><?= index_femenino ?></label>
                                      
                                </div>
                                
                            </div>
                            
                        </fieldset>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="pais_p<?php print($i) ?>"><?= index_pais ?>:</label> <span class="text-muted">*</span>
                            <select class="custom-select" name="pais_p<?php print($i) ?>" required> 
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
                            <div class="invalid-feedback"><?= index_campo_requerido ?></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="codFullPass<?php print($i) ?>"><?= index_codconfirmfullpass ?>:</label> <span class="text-muted">*</span>
                            <input id="codFullPass<?php print($i) ?>" name="codFullPassp<?php print($i) ?>" type="text" class="form-control" placeholder="<?= index_ingresacodconfirmfullpass ?>" required>
                        </div>
                    </div>
                </div>
            <?php  } ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="categoria"><?= index_categoria ?>:</label> <span class="text-muted">*</span>
                    <select class="custom-select" name="categoria_p" required>
                        <option value=""><?= index_seleccione_su_categoria ?></option>
                        <?php
                            $tabla='parejas';
                            $lang=isset($_SESSION['lang']) ? $_SESSION['lang'] : 'es';
                            $querycategorias="SELECT a.idCategoria, b.categoria_es, b.categoria_en
                            FROM tbl_categorias_eventos a
                            INNER JOIN tbl_categorias b ON a.idCategoria = b.id
                            INNER JOIN tbl_eventos c ON a.idEvento = c.id
                            WHERE c.token ='$tokenEvento' and b.tipo='$tabla'
                            ORDER BY b.categoria_$lang ASC";
                            $categorias=$basededatos->connect()->prepare($querycategorias);
                            $categorias->execute();     
                            $Allcategorias=$categorias->fetchAll(PDO::FETCH_ASSOC);

                            

                            foreach($Allcategorias as $categoria){    
                        ?>
                            <option value="<?= $categoria['idCategoria'] ?>" ><?= $categoria['categoria_'.$lang] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="hotel_num"><?= index_hotelnum ?>:</label> <span class="text-muted">*</span>
                    <input id="hotel_num" name="hotel_num" type="text" class="form-control hotel_num" placeholder="<?= index_ingresa_hotelnum ?>" required>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="alert alert-danger font-size-lg mb-5 cupondiv" role="alert">
                    <i class="fe-alert-circle font-size-xl mt-n1 mr-3"></i>
                    <?= index_tiene_cupon ?> 
                    <a href='#modal-coupon' data-toggle='modal' class='alert-link'><?= index_agregar_cupon ?></a>
                </div>
            </div> 
        </div>
        
        <input type="text" name="idform" class="form-control tipoform" value="<?= $form ?>" hidden>
        <input type="text" name="costo" class="form-control costo"  value="<?= $precioPase ?>" hidden>
    </div>

<?php } ?>
<?php if($tipoform==0 && $form=='ELWSC2023INSCGRU'){ ?>
        <div class="col-sm-12 col-lg-8 pb-5" >
            <div class="row">
                <div class="col-12">
                    <h5 class="text-dark">
                        <?= index_informacion_general ?>
                    </h5>
                    <hr class="mt-2 mb-4">
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="nombregrupo_p"><?= index_nombre_del_grupo ?>:</label> <span class="text-muted">*</span>
                        <input id="nombregrupo_p" name="nombregrupo_p" type="text" class="form-control" placeholder=""  required>
                        <div class="invalid-feedback"><?= index_campo_requerido ?></div>
                    </div>
                </div>    
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="nomrepresentante_p"><?= index_nombre_del_representante ?>:</label> <span class="text-muted">*</span>
                        <input id="nomrepresentante_p" name="nomrepresentante_p" type="text" class="form-control" placeholder="Ingresa tu nombre" required>
                        <div class="invalid-feedback"><?= index_campo_requerido ?></div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="emailrepresentante_p"><?= index_correo_electronico ?>:</label> <span class="text-muted">*</span>
                        <input id="emailrepresentante_p" name="emailrepresentante_p" type="text" class="form-control" placeholder="<?= index_ingresa_tu_correo_electronico ?>" required>
                        <div class="invalid-feedback"><?= index_campo_requerido ?></div>
                    </div>
                </div>   
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="numtelrep"><?= index_no_telefonico ?>:</label> <span class="text-muted">*</span>
                        <input id="numtelrep" name="numtelrep" type="text" class="form-control" placeholder="" required>
                        <div class="invalid-feedback"><?= index_campo_requerido ?></div>
                    </div>
                </div>                 
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pais"><?= index_pais ?>:</label> <span class="text-muted">*</span>
                        <select class="custom-select" name="pais" required>
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
                        <div class="invalid-feedback"><?= index_campo_requerido ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="categoria_p"><?= index_categoria ?>:</label> <span class="text-muted">*</span>
                        <select class="custom-select " name="categoria_p" required>
                            <option value=""><?= index_seleccione_su_categoria ?></option>
                            <?php
                                $tabla='grupos';
                                $lang=isset($_SESSION['lang']) ? $_SESSION['lang'] : 'es';
                                $querycategorias="SELECT a.idCategoria, b.categoria_es, b.categoria_en
                                FROM tbl_categorias_eventos a
                                INNER JOIN tbl_categorias b ON a.idCategoria = b.id
                                INNER JOIN tbl_eventos c ON a.idEvento = c.id
                                WHERE c.token ='$tokenEvento' and b.tipo='$tabla'
                                ORDER BY b.categoria_$lang ASC";
                                $categorias=$basededatos->connect()->prepare($querycategorias);
                                $categorias->execute();     
                                $Allcategorias=$categorias->fetchAll(PDO::FETCH_ASSOC);

                                

                                foreach($Allcategorias as $categoria){    
                            ?>
                            <option value="<?= $categoria['idCategoria'] ?>" ><?= $categoria['categoria_'.$lang] ?></option>
                        <?php } ?>
                        </select>
                        <div class="invalid-feedback"><?= index_campo_requerido ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="numintegrantes"><?= index_no_de_integrantes ?>:</label> <span class="text-muted">*</span>
                        <select class="custom-select" name="numintegrantes" id="numintegrantes"  required>
                            <option value="">0</option>                         
                            <?php for ($i=3; $i < 30 ; $i++) {  ?>
                            <option value="<?php print($i); ?>"><?php print($i); ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback"><?= index_campo_requerido ?></div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="hotel_num"><?= index_hotelnum ?>:</label> <span class="text-muted">*</span>
                    <input id="hotel_num" name="hotel_num" type="text" class="form-control hotel_num" placeholder="<?= index_ingresa_hotelnum ?>" required>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="alert alert-danger font-size-lg mb-5 cupondiv" role="alert">
                    <i class="fe-alert-circle font-size-xl mt-n1 mr-3"></i>
                    <?= index_tiene_cupon ?> 
                    <a href='#modal-coupon' data-toggle='modal' class='alert-link'><?= index_agregar_cupon ?></a>
                </div>
            </div> 
                <div class="col-md-4">
                    <div class="form-group">
                    <input type="text" name="idform" class="form-control tipoform" value="<?= $form ?>" hidden>
                    <input type="text" name="costo" class="form-control costo"  value="<?= $precioPase ?>" hidden>
                    </div>
                </div>
                <div class="col-12">
                    <h5 class="text-dark">
                        <?= index_informacion_de_integrantes ?>
                    </h5>
                    <hr class="mt-2 mb-4">
                </div>
            </div>
            <div class="row" id="integrantesgrupo" style="margin-bottom: 500px;">
            
            </div>
        </div>
<?php } ?>
