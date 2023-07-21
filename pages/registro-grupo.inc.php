<!-- Slanted background-->
<div class="position-relative bg-gradient" style="height: 380px;">
    <div class="cs-shape cs-shape-bottom cs-shape-slant bg-secondary d-none d-lg-block">
        <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 3000 260">
        <polygon fill="#FFF" points="0,257 0,260 3000,260 3000,0"></polygon>
        </svg>
    </div>
</div>
<div class="container-fluid bg-overlay-content pb-4 mb-md-3 pb-5" style="margin-top: -350px;">
    <div class="row">
      <!-- Content-->
      <div class="col-lg-12">
        <div class="d-flex flex-column h-100 bg-light rounded-lg box-shadow-lg p-4">
          <div class="py-2 p-md-3">
            <div class="d-sm-flex align-items-center justify-content-between pb-4 text-center text-sm-left">
                <h1 class="h3 mb-2 text-nowrap"><?= index_registro ?> | <?= index_grupos ?></h1>
            </div>                          
            <form class="needs-validation"  id="formTickets" data-form='<?= $form ?>' data-tipoForm='competition'>
                <div class="row" >
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