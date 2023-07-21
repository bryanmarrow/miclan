<div class="col-lg-4 cs-sidebar bg-secondary pt-2 pl-lg-4 b-md-2">    
    <div class="alert alert-warning alert-dismissible fade show text-center text-dark" role="alert">
        <?= index_mensaje_asistentes_2 ?>
    </div>
    <h2 class="h3 pb-3"><?= index_informacion_adicional ?></h2>
    <div class="form-group pb-3 pb-lg-5">
        <label class="form-label" for="ch-order-notes"><?= index_notas_de_orden ?></label>
        <textarea class="form-control" id="ch-order-notes" rows="3" placeholder="<?= index_placeholder_notas_orden ?>" name="notas_orden"></textarea>
    </div>
    <div class=" mb-3 pb-5">        
        <div class="d-flex justify-content-between mb-3">
            <span class="h6 mb-0"><?= index_subtotal?>:</span>
            <span class="text-nav">$
                <span class="subtotal">0.00</span>
            </span>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <span class="h6 mb-0"><?= index_descuento ?>:</span>
            <span class="text-nav">$ 
                <span class="discount">0.00</span>
            </span>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <span class="h6 mb-0"><?= index_impuestos ?>:</span>
            <span class="text-nav">$ 
                <span class="tax">0.00</span>
            </span>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <span class="h6 mb-0"><?= index_total ?>:</span>
            <span class="h6 mb-0">$
                <span class="total">0.00</span>
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
            <button class="btn btn-primary btn-block btnLiquidarOrden" 
            type="button"
            <?php if($form=='liquidar-pase'){ ?>
                data-tipoform="liquidar-pase" 
            <?php } ?>
            disabled><?= index_realizar_pago ?>
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
        
    </div>
</div>