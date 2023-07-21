<div class="col-12">
        <div class="alert alert-warning alert-dismissible fade show text-center text-dark" role="alert">
        <?= index_mensaje_asistentes_2 ?>
        </div>
    </div>
    <div class="col-sm-6 col-lg-6">
        <div class="row">
            
            <div class="col-12">
                <h5 class="text-dark">
                    <?= index_informacion_general ?>
                </h5>
                <hr class="mt-2 mb-4">
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label for="nombregrupo_p"><?= index_nombre_del_grupo ?>:</label> <span class="text-muted">*</span>
                    <input id="nombregrupo_p" name="nombregrupo_p" type="text" class="form-control" placeholder=""  required>
                    <div class="invalid-feedback"><?= index_campo_requerido ?></div>
                </div>
            </div>    
            <div class="col-md-12">
                <div class="form-group">
                    <label for="pais"><?= index_pais ?>:</label> <span class="text-muted">*</span>
                    <select class="custom-select" name="pais" id="selectpaisGrupo" required>
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
            <div class="col-md-12">
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
        </div> 
        <button class="btn-primary btn" type="submit">Agregar al carrito</button>
    </div>
    <div class="col-lg-6">
            
        <div class="row" id="integrantesgrupo">
            <div class="col-lg-12">
                <h5 class="text-dark">
                    <?= index_informacion_de_integrantes ?>
                </h5>
                <hr class="mt-2 mb-4">
            </div>
            <div class="col-lg-12">
                <div class="font-size-sm mb-4">Competidores seleccionados: <span class="numCompetidoresGrupoSelect font-size-md">0</span></div>
                <div class="form-group">
                    <label for="select_competidores">Seleccione el competidor:</label> <span class="text-muted">*</span>
                    <!-- <select class="custom-select select_competidores" name="select_competidores"  required size="10" multiple> -->
                        <?php  
                            $competidores=$basededatos->connect()->prepare("SELECT b.id, b.fname, b.lname, b.fechanac, b.genero, b.fecharegistro, b.idcompetidor, c.pais
                            FROM tbl_competidores_users_id a
                            INNER JOIN tbl_competidores b ON a.idcompetidor = b.idcompetidor
                            INNER JOIN tbl_paises c ON b.country = c.id
                            where a.user_id = $idUserSession");
                            $competidores->execute();
                            $Allcompetidores=$competidores->fetchAll();
                            $i=0;
                            foreach($Allcompetidores as $competidor){
                                
                                // var_dump($competidor);
                                $infoCompetidor=$competidor['fname'].' '.$competidor['lname'].' - #'.$competidor['idcompetidor'];
                        ?>
                            <!-- <option value="<?= $competidor['id'] ?>"><?= $infoCompetidor ?></option> -->

                            <div class="custom-control custom-checkbox border-bottom border-primary mb-2">
                                <input class="custom-control-input checkboxGrupo" data-idcompetidor="<?= $infoCompetidor ?>" value="<?= $competidor['id'] ?>" type="checkbox" id="ex-check-<?= $i ?>">
                                <label class="custom-control-label font-size-md" for="ex-check-<?= $i ?>"><?= $infoCompetidor ?></label>
                            </div>
                            
                        <?php $i++; } ?>
                    <!-- </select>                     -->
                </div> 
            </div>        
        </div>
    </div>
    