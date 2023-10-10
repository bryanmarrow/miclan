<div class="col-lg-4 mb-4 mb-lg-0">
    <div class="bg-light rounded-lg box-shadow-lg">
        <div class="px-4 py-4 mb-1 text-center">            
            <img class="d-block rounded-circle mx-auto my-2" width="110"  src="<?= $imgUser ?>" alt="<?= $colUser['fname'].' '.$colUser['lname'] ?>">            
            <h6 class="mb-0 pt-1"><?= $colUser['fname'].' '.$colUser['lname'] ?></h6>
            <!-- <span class="text-muted font-size-sm">@amanda_w</span> -->
        </div>
        <div class="d-lg-none px-4 pb-4 text-center">
            <a class="btn btn-primary px-5 mb-2" href="#account-menu" data-toggle="collapse">
                <i class="fe-menu mr-2"></i>Menu de cuenta
            </a>
        </div>
        <div class="d-lg-block collapse pb-2" id="account-menu">
            <h3 class="d-block bg-secondary font-size-sm font-weight-semibold text-muted mb-0 px-4 py-3">Dashboard
            </h3>
            
            
            <a class="d-flex align-items-center nav-link-style px-4 py-3" href="orders">Ordenes de compra</a>
            
            <a class="d-flex align-items-center nav-link-style px-4 py-3 border-top" href="competidores">Competidores</a>
            <a class="d-flex align-items-center nav-link-style px-4 py-3 border-top" href="inscripciones">Inscripciones</a>
            
            <a class="d-flex align-items-center nav-link-style px-4 py-3 border-top logout" href="#"><i class="fe-log-out font-size-lg opacity-60 mr-2"></i>Cerrar sesión</a>
        </div>
    </div>
</div>