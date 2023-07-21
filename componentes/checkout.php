
<div class="col-lg-4 cs-sidebar bg-secondary pt-2 pl-lg-4 b-md-2">    
    <div class="alert alert-warning alert-dismissible fade show text-center text-dark" role="alert">
        <?= index_mensaje_asistentes_2 ?>
    </div>
    <h2 class="h3 pb-3"><?= index_informacion_adicional ?></h2>
    <div class="form-group ">
        <label class="form-label" for="ch-order-notes"><?= index_notas_de_orden ?></label>
        <textarea class="form-control" id="ch-order-notes" rows="3" placeholder="<?= index_placeholder_notas_orden ?>" name="notas_orden"></textarea>
    </div>
    <div class="alert alert-danger font-size-lg mb-5 cupondiv" role="alert">
        <i class="fe-alert-circle font-size-xl mt-n1 mr-3"></i>
        <?= index_tiene_cupon ?> 
        <a href='#modal-coupon' data-toggle='modal' class='alert-link'><?= index_agregar_cupon ?></a>
    </div>
    <div class=" mb-3 pb-5">        
        <div class="d-flex justify-content-between mb-3">
            <span class="h6 mb-0"><?= index_subtotal?>:</span>
            <span class="text-nav">$
                <span class="subtotal"></span>
            </span>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <span class="h6 mb-0"><?= index_descuento ?>:</span>
            <span class="text-nav">$ 
                <span class="discount">
                </span>
            </span>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <span class="h6 mb-0"><?= index_impuestos ?>:</span>
            <span class="text-nav">$ 
                <span class="tax">
                </span>
            </span>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <span class="h6 mb-0"><?= index_total ?>:</span>
            <span class="h6 mb-0">$
                <span class="total"></span>
            </span>
        </div>
        <div class="justify-content-between mb-3 coupontab d-none">
            <span class="h6 mb-0"><?= index_codigocupon ?>:</span>
            <span class="h6 mb-0">
                <span class="couponcode"></span>
            </span>
            
        </div>
        <input type="text" class="couponcode" name="couponcode" value="" hidden>
        <div class="justify-content-between mb-3 coupontab ">
            <input type="checkbox" class="h6 mb-0" id="terminos_condiciones" required>
            <label class="form-check-label" for="terminos_condiciones"><?= index_terminos_condiciones?></label>
            <div class="invalid-feedback">
               <?= index_aceptar_terminos_y_condiciones ?>
            </div>
        </div>
        

        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-primary btn-block btnpago" 
            data-idPase="<?= $idPase ?>"
            data-sku="<?= $form ?>" 
            data-tagEvento="<?= $tagApartado ?>" 
            data-nombreTicket="<?= $nombreTicket ?>" 
            data-divisaPase="<?= $divisaPase ?>"
            data-status_apartado="<?= $status_apartado ?>"
            data-tipoForm="<?= $tipoform ?>"
            ><?= index_realizar_pago ?>
            </button>
        </div>
        
        <hr class="mb-4">
        <h6 class="h6"><?= index_metodo_de_pago
 ?></h6>
       
        <div class="accordion accordion-alt mb-grid-gutter" id="payment-methods">
        <div class="card border-0 box-shadow paypal-radio">
            <div class="card-header p-3">
                <div class="p-1">
                    <div class="custom-control custom-radio collapsed"  data-target="#paypalinfo">
                        <img class="ml-3" width="20" src="<?php echo $rootPath ?>assets/img/shop/paypal.png" alt="PayPal">
                        <img class="ml-3" width="130" src="<?php echo $rootPath ?>assets/img/shop/cards.png" alt="Accepted cards">
                    <!-- </label> -->
                    </div>
                </div>
            </div>
            <div class="collapse" id="paypalinfo" data-parent="#payment-methods">
                <div class="card-body">
                    <!-- <p class="font-size-ms">
                    Al hace click en Pagar ahora está de acuerdo con los <a target="_blank" href="https://elvdaonline.com/dashboard/terminos-y-condiciones"> Términos y condiciones </a>
                    </p> -->
                    <div id="paypalCheckoutContainer" class="text-center"></div>
                </div>
            </div>
        </div>
        
        <!-- <?php 
            if($form=='solistas' || $form=='parejas' || $form=='grupos'){ 
        ?>
            <div class="card border-0 box-shadow cash-radio">
                <div class="card-header p-3">
                <div class="p-1">
                    <div class="custom-control custom-radio collapsed" data-toggle="collapse" data-target="#cash">
                    <input class="custom-control-input" type="radio" id="cash-radio" name="payment_method">
                        <label class="custom-control-label d-flex h6 mb-0" for="cash-radio">
                            
                            <?= index_ya_realizaste_tu_pago ?>
                            
                        </label>
                        
                        <span>¿Ya realizaste tu pago?</span>
                        <img class="ml-3" width="20" src="<?php echo $rootPath ?>assets/img/shop/paypal.png" alt="PayPal">
                        <img class="ml-3" width="130" src="<?php echo $rootPath ?>assets/img/shop/cards.png" alt="Accepted cards">
                    </div>
                </div>
                </div>
                <div class="collapse" id="cash" data-parent="#payment-methods">
                <div class="card-body">
                    <p class="font-size-ms"><?= index_ingrese_su_id_de_transaccion
 ?>:</p>
                    <div class="d-flex justify-content-between mt-3 mb-4">
                        <label for="referencia"></label>
                        <input class="form-control cash" type="text" name="invoiceid" placeholder="00000-0000-000" >
                    </div>
                    <button class="btn btn-primary btn-block submit" type="submit"><?= index_enviar_registro
 ?></button>
                </div>
                </div>
            </div>
        <?php 
            }
        ?>
        </div> -->
       
        
    </div>
</div>