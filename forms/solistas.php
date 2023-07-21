
    <div class="col-lg-12">
        <div class="alert alert-warning alert-dismissible fade show text-center text-dark" role="alert">
            <?= index_mensaje_asistentes_2 ?>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="select_competidores">Competidor:</label> <span class="text-muted">*</span>
                    <select class="custom-select select_competidores" name="select_competidores" id="select_competidores" required>
                        <option value="">Seleccione el competidor</option>
                        <?php  
                            $competidores=$basededatos->connect()->prepare("SELECT b.id, b.fname, b.lname, b.fechanac, b.genero, b.fecharegistro, b.idcompetidor, c.pais
                            FROM tbl_competidores_users_id a
                            INNER JOIN tbl_competidores b ON a.idcompetidor = b.idcompetidor
                            INNER JOIN tbl_paises c ON b.country = c.id
                            where a.user_id = $idUserSession");
                            $competidores->execute();
                            $Allcompetidores=$competidores->fetchAll();
                            foreach($Allcompetidores as $competidor){
                                
                                // var_dump($competidor);
                                $infoCompetidor=$competidor['fname'].' '.$competidor['lname'].' - #'.$competidor['idcompetidor'];
                        ?>
                            <option value="<?= $competidor['id'] ?>"><?= $infoCompetidor ?></option>
                        <?php } ?>
                    </select>                    
                </div>
            </div>
            <div class="col-md-12">
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
        </div>
        <button class="btn-primary btn" type="submit">Agregar al carrito</button>
    </div>
    <div class="col-lg-4 mt-3">
                
        <div class="card collapse" id="collapseInfoCompetidor">
            <div class="card-header">
                <h5 class="text-dark">
                    <?= index_informacion_competidor ?>
                </h5>
                <!-- <hr class="mt-2 mb-4"> -->
            </div>
            <div class="card-body pt-4 border-top bg-secondary">
                <div class="d-sm-flex justify-content-between pb-1">
                    <div class="media media-ie-fix d-block d-sm-flex mr-sm-3">
                        <div class="media-body font-size-sm text-center text-sm-left">
                            <div class="m-0"><span class="text-muted mr-1" ><?= index_nombrecompleto ?>:</span> <span class="h6" id="nombre_p"></span> </div>
                            <div class="m-0"><span class="text-muted mr-1" ><?= index_fecha_de_nacimiento ?>:</span> <span class="h6" id="fecha_nac"></span> </div>
                            <div class="m-0" ><span class="text-muted mr-1"><?= index_pais ?>:</span> <span class="h6" id="pais_p"></span> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>