<div class="col-lg-8">     
        <div class="row">
            <div class="col-12">
                <h5 class="text-dark">
                    <?= index_details ?>
                </h5>
                <hr class="mt-2 mb-4">
            </div>
            
            <div class="col-12 mb-4">
                <div class="input-group">
                <input class="form-control codigoconf" name="codigoconf" type="text" placeholder="<?= index_ingresa_codconfirmacion ?>" >
                <div class="input-group-append">
                    <button class="btn btn-primary" id="btncodigo" ><?= index_validar_codigo ?></button>
                </div>
                </div>
            </div>
            <div class="col-12">
                <h5 class="text-dark">
                    <?= index_infoapartado ?>
                </h5>
                <hr class="mt-2 mb-4">
            </div>
            <div class="col-lg-12">
                <div class="accordion" id="orders-accordion">
                    <div class="card">
                    <div class="card-header">
                        <div class="accordion-heading"><a
                            class="d-flex flex-wrap align-items-center justify-content-between pr-4" href="#order-1"
                            role="button" data-toggle="collapse" aria-expanded="true" aria-controls="order-1">
                            <div class="font-size-sm font-weight-medium text-nowrap my-1 mr-2">
                                <i class="fe-hash font-size-base"></i> Invoice Id:
                                <span class="d-inline-block align-middle" id="invoiceid"></span>
                            </div>
                            <div class="text-nowrap text-body font-size-sm font-weight-normal my-1 mr-2"><i
                                class="fe-clock text-muted mr-1"></i> <span id="datePago"></span> </div>
                        </a></div>
                    </div>
                    <div class="collapse d-none" id="order-1" data-parent="#orders-accordion">
                        <div class="card-body pt-4 border-top bg-secondary">
                            <!-- Item-->
                            <div class="">
                                <div class="media media-ie-fix d-block d-sm-flex mr-sm-3">
                                    <div class="media-body font-size-sm text-center text-sm-left">
                                        <h6>Datos del titular</h6>
                                        <div class="m-0"><span class="text-muted mr-1" >
                                            <?= index_nombrecompleto ?>:</span> 
                                            <span class="h6" id="nombreTitular"></span> 
                                        </div>
                                        <div class="m-0" >
                                            <span class="text-muted mr-1"><?= index_correo_electronico ?>: <span class="h6" id="email_p"></span></span>                                            
                                        </div>
                                        <div class="mb-4" >
                                            <span class="text-muted mr-1">Status de pago:</span>
                                            <span class="h6" id="statusOrdenCompra"></span>
                                        </div>
                                        <h6>Datos de los integrantes</h6>
                                        <div class="table-responsive">
                                            <div class="m-0" id="integrantes_apartado"  >
                                                
                                            </div>
                                        </div>      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="tform" class="form-control tform" value="liquidar" hidden>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="idform" class="form-control tipoform" value="<?= $form ?>" hidden>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="iduser" class="form-control" id="iduser" value="" hidden>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="idpase" class="form-control" id="idpase" value="" hidden>
                </div>
            </div>
        </div>
        
    </div>