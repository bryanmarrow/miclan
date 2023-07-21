<div class="row">
        <?php for ($i=1; $i < 3; $i++) { ?>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="select_competidores">Competidor <?= $i ?>:</label> <span class="text-muted">*</span>
                    <select class="custom-select select_competidores" name="select_competidores" required>
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
        <?php  } ?>
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
        
        
    </div>
    <button class="btn-primary btn" type="submit">Agregar al carrito</button>