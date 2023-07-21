

<?php 
    $AllPases=getAllPasesActivos($tokenEvento);

    

?>


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
          <section class="pt-lg-3">
              <h2 class="d-block text-light text-center py-5 px-3">Tickets</h2>
              <div class="container">
                <!-- <div class="d-sm-flex align-items-center justify-content-center text-center text-sm-left">
                  <h3 class="mb-4 mb-sm-2 mr-sm-4 pr-sm-2">Work efficiently with your team</h3><a class="btn btn-success mb-sm-2" href="#">Sign up for free</a>
                </div> -->
                <div class="row justify-content-center">
                  <?php

                    foreach($AllPases as $row){
                      // var_dump($row);
                      $descPase=$row['descripcion_pase'];
                      $precioPase=number_format($row['precio'], 0);
                      $divisaPase=$row['divisa'];
                      $tagEvento=$row['tag'];
                      $codigoPase=$row['codigo_pase'];
                      $tipoPase=$row['tipo_pase'];
                      $minPases=$row['minPases'];
                      $maxPases=$row['maxPases'];
                  ?>
                  <div class="col-lg-12 pb-4">
                    <div class="bg-light box-shadow-lg rounded-lg pt-3 px-4">
                      <div class="pt-3 px-3 itemCart">
                        <div class="d-md-flex align-items-start border-bottom py-4 py-sm-5">
                          <div class="ml-4 ml-sm-0 py-2 w-100" style="max-width: 25rem;">
                            <h3 class="mb-2"><?= $descPase ?></h3>
                            <div class="font-size-xs" style="max-width: 10rem;"><?= $tagEvento ?></div>
                          </div>
                          <div class="d-flex w-100 align-items-end py-3 py-sm-2 px-4" style="max-width: 15rem;">
                            <span class="h2 font-weight-normal text-muted mb-1 mr-2">$</span>
                            <span class="cs-price display-4 font-weight-normal text-primary px-1 mr-2" data-current-price="0" data-new-price="0"><?= $precioPase ?></span>
                            <span class="h3 font-size-lg font-weight-medium text-muted mb-2"><?= $divisaPase ?></span>
                          </div>
                          <!-- <ul class="list-unstyled py-2 mb-0">
                            <li class="d-flex align-items-center mb-3" style="max-width: 30rem;">
                              <i class="fe-check font-size-xl text-primary mr-2"></i>
                              <span>Up to 3 projects for each member</span>
                            </li>
                            <li class="d-flex align-items-center mb-3"><i class="fe-check font-size-xl text-primary mr-2"></i><span>2 team members allowed</span></li>
                          </ul>
                           -->
                          <div class="d-flex w-100 align-items-end py-3 py-sm-2 px-4" style="max-width: 15rem;">                              
                              <input class="form-control text-center product-qty mb-2" type="number" value="<?= $minPases ?>" min="<?= $minPases ?>" max="<?= $maxPases ?>" <?php if($tipoPase=='promo'){ echo 'readonly'; } ?>>
                          </div>
                          <div class="d-flex w-100 align-items-end py-1 py-sm-2 px-3" style="max-width: 13rem;">
                            
                            <button class="btn btn-primary btn-block btnaddPase" type="button" 
                                data-codigopase="<?= $codigoPase ?>" 
                                data-nompase="<?= $descPase ?>"
                                data-precioPase="<?= $precioPase ?>"
                                data-divisapase="<?= $divisaPase ?>"
                                data-tipopase="<?= $tipoPase ?>"
                            >
                                Agregar al carrito
                            </button>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php 
                    }
                  ?>
                </div>
              </div>
            </section>
        </div>
      </div>
    </div>
  </div>