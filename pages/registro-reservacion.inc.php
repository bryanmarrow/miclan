<!-- Slanted background-->
<div class="position-relative bg-gradient" style="height: 380px;">
    <div class="cs-shape cs-shape-bottom cs-shape-slant bg-secondary d-none d-lg-block">
        <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 3000 260">
        <polygon fill="#FFF" points="0,257 0,260 3000,260 3000,0"></polygon>
        </svg>
    </div>
</div>
<div class="container bg-overlay-content pb-4 mb-md-3" style="margin-top: -350px;">
    <div class="row">
        <!-- Content-->
        <div class="col-lg-12">
            <div class="d-flex flex-column h-100 bg-light rounded-lg box-shadow-lg p-4">
                <div class="py-2 p-md-3">
                    <div class="d-sm-flex align-items-center justify-content-between pb-4 text-center text-sm-left">
                        <h1 class="h3 mb-2 text-nowrap">Pre Check-In - Hotel</h1>
                    </div>            
                    <form class="registro-reservacion" enctype="multipart/form-data" novalidate>
                        <div class="row infoPrimariaReservacion">
                            <div class="col-12">
                                <div class="alert alert-warning alert-dismissible fade show text-center text-dark" role="alert">
                                <?= index_mensaje_asistentes_2 ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <h5 class="text-dark">
                                    Información del titular
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
                                            <option value="<?= $pais['id'] ?>" ><?= $pais['pais'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <h5 class="text-dark">
                                    Información de la reservación
                                </h5>
                                <hr class="mt-2 mb-4">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="agencia" class="form-label">Agencia/Website</label>
                                <input class="form-control" type="text" id="agencia" name="agencia" placeholder="" value="" required>
                                <small>Nombre de la agencia en donde realizó su reservación.</small>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="hotel_num"><?= index_hotelnum ?>:</label> <span class="text-muted">*</span>
                                    <input id="hotel_num" name="hotel_num" type="text" class="form-control hotel_num" placeholder="<?= index_ingresa_hotelnum ?>" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 pb-4">
                                <label for="comprobante_p"><?= index_adjuntar_comprobante ?>:</label> <span class="text-muted">*</span>
                                <div class="cs-file-drop-area">
                                <div class="cs-file-drop-icon czi-cloud-upload"></div>
                                <span class="cs-file-drop-message"><?= index_arrastra_y_suleta_aqui_tu_archivo_para_subir ?></span>
                                <input type="file" class="cs-file-drop-input comprobante_pago" name="imagen_p" id="comprobante_p" accept="application/pdf, image/jpg, image/png" required>
                                <button type="button" class="cs-file-drop-btn btn btn-primary btn-sm"><?= index_o_selecciona_tu_archivo?></button>
                                <div class="invalid-feedback"><?= index_mensaje_input_comprobante ?></div>
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
                                        <?php for ($i=1; $i < 8 ; $i++) {  ?>
                                            <option value="<?php print($i); ?>"><?php print($i); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <h5 class="text-dark">
                                    Información de su llegada
                                </h5>
                                <hr class="mt-2 mb-4">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="aerolinea" class="form-label">Aerolínea</label>
                                <input class="form-control" type="text" id="aerolinea" name="aerolinea" placeholder="" value="" required>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                
                                <div class="form-group">
                                    <label for="date-input">Fecha/Horario de llegada</label>
                                    <input class="form-control" type="datetime-local" id="fecha_vuelo" name="fecha_vuelo" required>
                                </div>

                            </div>


                            <div class="col-12">
                                <h5 class="text-dark">
                                    Información de los huéspedes
                                </h5>
                                <hr class="mt-2 mb-4">
                            </div>
                        </div>
                        <div  id="huespedes">    
                            
                        </div>
                        <button class="btn btn-primary" type="submit"><?= index_enviar_registro ?></button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>