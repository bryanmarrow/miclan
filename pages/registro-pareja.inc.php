<!-- Slanted background-->
<div class="position-relative bg-gradient" style="height: 380px;">
    <div class="cs-shape cs-shape-bottom cs-shape-slant bg-secondary d-none d-lg-block">
        <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 3000 260">
        <polygon fill="#FFF" points="0,257 0,260 3000,260 3000,0"></polygon>
        </svg>
    </div>
</div>
    <div class="container-fluid bg-overlay-content pb-4 mb-md-3" style="margin-top: -350px;">
        <div class="row">
          <!-- Content-->
          <div class="col-lg-12">
            <div class="d-flex flex-column h-100 bg-light rounded-lg box-shadow-lg p-4">
              <div class="py-2 p-md-3">
                <!-- Title + Delete link-->
                <div class="d-sm-flex align-items-center justify-content-between pb-4 text-center text-sm-left">
                    <h1 class="h3 mb-2 text-nowrap"><?= index_registro ?> | <?= index_parejas ?></h1>
                    <!-- <a class="btn btn-link text-danger font-weight-medium btn-sm mb-2" href="#">
                        <i class="fe-trash-2 font-size-base mr-2"></i>Delete account
                    </a> -->
                </div>
                <!-- Content-->
                <!-- <div class="bg-secondary rounded-lg p-4 mb-4">
                  <div class="media d-block d-sm-flex align-items-center"><img class="d-block rounded-circle mx-auto mb-3 mb-sm-0" width="110" src="assets\img\dashboard\avatar\main.jpg" alt="Amanda Wilson">
                    <div class="media-body pl-sm-3 text-center text-sm-left">
                      <button class="btn btn-light box-shadow btn-sm mb-2" type="button"><i class="fe-refresh-cw mr-2"></i>Change avatar</button>
                      <div class="p mb-0 font-size-ms text-muted">Upload JPG, GIF or PNG image. 300 x 300 required.</div>
                    </div>
                  </div>
                </div> -->                
                <form class="needs-validation" id="formTickets" data-form='<?= $form ?>' data-tipoForm='competition' novalidate> 
                    <?php require($rootPath.'componentes/formpago.php') ?>
                    <?php require($rootPath.'componentes/checkout.php') ?>
                    </div>                   
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>