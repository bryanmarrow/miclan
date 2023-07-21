<?php


// Set Language variable
if(isset($_GET['lang']) && !empty($_GET['lang'])){
  $_SESSION['lang'] = $_GET['lang'];
 
  if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
   echo "<script type='text/javascript'> location.reload(); </script>";
  }
}
// Include Language file
if(isset($_SESSION['lang'])){
  $url=$rootPath."lang_".$_SESSION['lang'].".php";
  include $url;
}else{
  $url=$rootPath."lang_es.php";
  include $url;
}

require $rootPath.'/api/sesionWeb.php';



?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title><?php echo htmlspecialchars($title); ?>
  </title>
  <!-- SEO Meta Tags-->
  <meta name="description" content="<?php echo htmlspecialchars($description); ?>">
  <meta name="keywords" content="<?php echo htmlspecialchars($keywords); ?>">
  <meta name="author" content="<?php echo htmlspecialchars($author); ?>">
  <!-- Viewport-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Favicon and Touch Icons-->
  <!-- <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.bin"> -->
  <!-- <link rel="mask-icon" color="#5bbad5" href="safari-pinned-tab.svg"> -->
  <!-- <meta name="msapplication-TileColor" content="#766df4"> -->
  <!-- <meta name="theme-color" content="#ffffff"> -->
  <!-- Facebook tags -->
  <meta property="og:title" content="<?php echo htmlspecialchars($ogtitle); ?>" />
  <meta property="og:description" content="<?php echo htmlspecialchars($ogdescription); ?>">
  <meta property="og:image" content="<?php echo htmlspecialchars($ogimagen); ?>">
  <?php require 'headers_cache.php'; ?>
 
  <link rel="stylesheet" media="screen" href="<?= $rootPath ?>assets\vendor\simplebar\dist\simplebar.min.css">
  <!-- Main Theme Styles + Bootstrap-->
  <link rel="stylesheet" media="screen" href="<?= $rootPath ?>assets\css\app.min.css">
  <link rel="stylesheet" media="screen" href="<?= $rootPath ?>assets\css\theme.min.css">  
  <link rel="stylesheet" media="screen" href="<?= $rootPath ?>assets\css\elvdc.min.css">
  <link rel="stylesheet" media="screen" href="<?= $rootPath ?>assets\css\icons.min.css">
  <link rel="stylesheet" media="screen" href="<?= $rootPath ?>assets\css\loginModule.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

  
  
  <?php require 'links-scripts.header.php'; ?>

</head>
<!-- Body-->

<body>
  <div class="container-fluid px-3">
    <?php var_dump($_SESSION) ?>
  </div>
  <?php 
    include $rootPath.'/modals/canvasCarrito.php';
  ?>
  <!-- Page loading spinner-->
  <div class="cs-page-loading ">
    <div class="cs-page-loading-inner">
      <div class="cs-page-spinner">

        <span class="spinner-grow spinner-grow-sm mr-2 mb-4" style="width: 3rem; height: 3rem;" role="status"
          aria-hidden="true"></span>
        <span id="textoload"> </span>
      </div>
    </div>

  </div>


  <div class="modal fade" id="modal-coupon" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><?= index_cuponpromocional ?></h4>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
        </div>
        <form class="modal-body" id="formcupon" data-form='<?= $form ?>' novalidate="">
          <div class="input-group">
            <input class="form-control codigo_cupon" type="text" name="codigo_cupon" placeholder="<?= index_ingresa_tu_codigo ?>" required>
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit"><?= index_aplicarcodigo ?></button>
            </div>
          </div>
          <div class="alertacupon text-danger"></div>
        </form>

      </div>
    </div>
  </div>


  <!-- Modal markup -->
  <div class="modal fade sucessregistro" id="sucessregistro" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detalles de registro</h4>
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button> -->
        </div>
        <div class="modal-body">
          <!-- <div class="card">
              <div class="card-body">
                <h4 class="card-title">#ELVDC2020</h4>
                <p class="card-text font-size-sm text-muted">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Cras justo odio</li>
                <li class="list-group-item">Dapibus ac facilisis in</li>
                <li class="list-group-item">Vestibulum at eros</li>
              </ul>
              <div class="card-body">
                <a href="#" class="btn btn-sm btn-primary">Go somewhere</a>
              </div>
            </div> -->

          <div class="card mb-4">
            <img src="" class="card-img-top" alt="Card image">
            <div class="card-body">
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span class="font-weight-medium alertaexitoso"> </span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <?= index_alert_success_registro ?>
              <?= index_redireccion ?>
            </div>
          </div>
        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary btn-sm">Save changes</button>
          </div> -->
      </div>
    </div>
  </div>
  <div class="modal fade envioimageexitoso" id="envioimageexitoso" tabindex="-1" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content bg-success">
        <div class="modal-header">
          <!-- <h4 class="modal-title"></h4> -->
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button> -->
        </div>
        <div class="modal-body">
          <div class="text-center">
            <i class="dripicons-checkmark h1"></i>
            <h4 class="mt-2 text-light"><?= index_alert_success_imagenenviada ?></h4>
            <p class="card-text font-size-sm text-light mt-3">

              <?= index_todas_las_fotografias_enviadas ?>
            </p>

          </div>



        </div>
      </div>
    </div>
  </div>
  <div class="modal fade codinscnovalido" id="codinscnovalido">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content bg-warning">

        <div class="modal-body">
          <div class="text-center">
            <i class="dripicons-checkmark h1"></i>
            <h4 class="mt-2 text-light"><?= index_codigoincorrecto ?></h4>
            <p class="card-text font-size-sm text-light mt-3">
              <?= index_problemas_contactanos ?>
            </p>

          </div>



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-light my-2" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <main class="cs-page-wrapper">
    
    <header class="cs-header">
      <div class="topbar topbar-dark bg-dark">
        <div class="container d-md-flex align-items-center px-0 px-xl-3">
          <div class="d-none d-md-block text-nowrap mr-3"><i class="fe-phone font-size-base text-muted mr-1"></i>
              <span class="text-muted mr-2 ">
              <a class="topbar-link" target="_blank" href="<?= $contactoWhatsapp['value'] ?>">
                <?= index_contactoviawhatsapp ?>
              </a>
              
          </div>
          <div class="d-flex text-md-right ml-md-auto">
            <!-- <a class="topbar-link pr-2 mr-4" href="order-tracking.html"><i class="fe-map-pin font-size-base opacity-60 mr-1"></i>Track <span class='d-none d-sm-inline'>your order</span></a> -->
            
            <span class="mx-2 text-light"><?= index_dollar_hoy?>: $<?= $tipoCambioDollar['value'] ?> MXN</span>        
            <form method='get' action='' id='form_lang'>
              Language : <select name='lang' onchange='changeLang();'>
                <option value='es'
                  <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'es'){ echo "selected"; } ?>>Español
                </option>
                <option value='en'
                  <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en'){ echo "selected"; } ?>>English
                </option>
              </select>
            </form>
            <!-- <div class="dropdown"><a class="topbar-link dropdown-toggle" href="#" data-toggle="dropdown">$ Dollar (US)</a>
                <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">€ Euro (EU)</a><a class="dropdown-item" href="#">£ Pound (UK)</a><a class="dropdown-item" href="#">¥ Yen (JP)</a></div>
              </div> -->
            
          </div>          
        </div>        
      </div>
      <div class="navbar navbar-expand-lg navbar-light bg-light navbar-box-shadow navbar-sticky" data-scroll-header="">
        <!-- <div class="navbar-search bg-light">
            <div class="container d-flex flex-nowrap align-items-center"><i class="fe-search font-size-xl"></i>
              <input class="form-control form-control-xl navbar-search-field" type="text" placeholder="Search site">
              <div class="d-none d-sm-block flex-shrink-0 pl-2 mr-4 border-left border-right" style="width: 10rem;">
                <select class="form-control custom-select pl-2 pr-0">
                  <option value="all">All categories</option>
                  <option value="clothing">Clothing</option>
                  <option value="shoes">Shoes</option>
                  <option value="electronics">Electronics</option>
                  <option value="accessoriies">Accessories</option>
                  <option value="software">Software</option>
                  <option value="automotive">Automotive</option>
                </select>
              </div>
              <div class="d-flex align-items-center"><span class="text-muted font-size-xs mt-1 d-none d-sm-inline">Close</span>
                <button class="close p-2" type="button" data-toggle="search">&times;</button>
              </div>
            </div>
          </div> -->
        <div class="container px-0 px-xl-3">
          <button class="navbar-toggler ml-n2 mr-2" type="button" data-toggle="offcanvas"
            data-offcanvas-id="primaryMenu"><span class="navbar-toggler-icon"></span></button><a
            class="navbar-brand order-lg-1 mx-auto ml-lg-0 pr-lg-2 mr-lg-4" href="<?= $rootPath ?>"><img
              class="navbar-floating-logo d-none d-lg-block" width="50"
              src="<?= $rootPath ?>assets\img\logo\logo-icon.png" alt="Around"><img class="navbar-stuck-logo"
              width="153" src="<?= $rootPath ?>assets\img\logo\logo-dark.png" alt="Around"><img class="d-lg-none"
              width="150" src="<?= $rootPath ?>assets\img\logo\logo-dark.png" alt="Around"></a>
              <div class="d-flex align-items-center order-lg-3 ml-lg-auto">
                <div class="navbar-tool mr-1 mx-3">
                  <a class="navbar-tool-icon-box" href="#" data-toggle="offcanvas" data-offcanvas-id="shoppingCart">
                    <i class="fe-shopping-cart"></i>
                    <span class="navbar-tool-badge total-count"></span>
                  </a>
                </div>
                <?php if(!isset($_SESSION['status'])){ ?>
                  <a class="nav-link-style font-size-sm text-nowrap" href="login" >
                      <i class="fe-user font-size-xl mr-2"></i>Iniciar sesión
                  </a>
                <?php }else{ 
                      $idUserSession=$_SESSION['idUserSession'];
                      $query="SELECT * FROM tbl_users where id='$idUserSession'";
                      $querySessionUser=$basededatos->connect()->prepare($query);
                      $querySessionUser->execute();
                      $colUser=$querySessionUser->fetch(PDO::FETCH_ASSOC);
                  
                ?>

                  
                  <div class="navbar-tool dropdown">
                      <a class="navbar-tool-icon-box" href="my-account">
                        
                      <img class="navbar-tool-icon-box-img" src="<?= $imgUser ?>" 
                        alt="<?= $colUser['fname'] ?>">
                      </a>
                      <a class="navbar-tool-label dropdown-toggle" href="my-account">
                        <small>Hola,</small><?= $colUser['fname'] ?>
                      </a>
                    <ul class="dropdown-menu dropdown-menu-right" style="width: 15rem;">                    
                      <li>
                        <a class="dropdown-item d-flex align-items-center" href="edit-account">
                          <i class="fe-user font-size-base opacity-60 mr-2"></i>
                          Editar cuenta
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item d-flex align-items-center logout" href="#">
                          <i class="fe-log-out font-size-base opacity-60 mr-2"></i>
                          Cerrar sesión
                        </a>
                      </li>
                    </ul>
                  </div>
                <?php }?>
              <a class="btn btn-primary btn-sm ml-grid-gutter d-none d-lg-inline-block" href="javascript:history.go(-1)" rel="noopener">
                <i class="fe-skip-back mr-2"></i>
                <span class='d-none d-lg-inline'>Regresar a website</span>
              </a>
          </div>
          <div class="cs-offcanvas-collapse order-lg-2" id="primaryMenu">
            <div class="cs-offcanvas-cap navbar-box-shadow">
              <h5 class="mt-1 mb-0">Menu</h5>
              <button class="close lead" type="button" data-toggle="offcanvas" data-offcanvas-id="primaryMenu"><span
                  aria-hidden="true">&times;</span></button>
            </div>
            <div class="cs-offcanvas-body">
              <!-- Menu-->
              <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link font-size-lg" href="<?= $rootPath ?>"><?=  index_inicio ?></a>
                </li>

                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#"
                    data-toggle="dropdown">Registro <?=  index_campeonato ?></a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item font-size-base"
                        href="<?= $rootPath ?>registro-competencia?form=ELWSC2023INSCSOL"><?= index_solistas ?></a></li>
                    <li><a class="dropdown-item font-size-base"
                        href="<?= $rootPath ?>registro-competencia?form=ELWSC2023INSCPAR"><?= index_parejas ?></a></li>
                    <li><a class="dropdown-item font-size-base"
                        href="<?= $rootPath ?>registro-competencia?form=ELWSC2023INSCGRU"><?= index_grupos ?></a></li>
                  </ul>
                </li>
                <li class="nav-item"><a class="nav-link font-size-base"
                    href="<?= $rootPath ?>liquidar-pase"><?=  index_liquida_pase ?></a>
                </li>
                <li class="nav-item dropdown d-none"><a class="nav-link dropdown-toggle" href="#"
                    data-toggle="dropdown"><?=  index_tickets ?></a></a>
                  <ul class="dropdown-menu">

                    <li><a class="dropdown-item font-size-base"
                        href="<?= $rootPath ?>full-pass"><?= index_fullpass ?></a></li>
                    <li><a class="dropdown-item font-size-base"
                        href="<?= $rootPath ?>night-pass"><?= index_nightpass ?></a></li>
                    <li><a class="dropdown-item font-size-base"
                        href="<?= $rootPath ?>aparta-tu-full-pass"><?= index_apartado_fullpass ?></a></li>
                    <li><a class="dropdown-item font-size-base"
                        href="<?= $rootPath ?>aparta-tu-night-pass"><?= index_apartado_nightpass ?></a></li>
                    <li><a class="dropdown-item font-size-base"
                        href="<?= $rootPath ?>liquidar-pase"><?= index_liquida_pase ?></a></li>
                  </ul>
                </li>
                <li class="nav-item dropdown d-none"><a class="nav-link dropdown-toggle"
                    data-toggle="dropdown">Congreso</a></a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item font-size-base" href="<?= $rootPath ?>artistas"><?= index_lineup ?></a>
                    </li>
                    <li><a class="dropdown-item font-size-base"
                        href="<?= $rootPath ?>conciertos"><?= index_conciertos ?></a></li>
                    <li><a class="dropdown-item font-size-base"
                        href="<?= $rootPath ?>expositores"><?= index_expositores ?></a></li>
                  </ul>
                </li>
                <li class="nav-item dropdown d-none"><a class="nav-link dropdown-toggle font-size-lg">Hotel</a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item font-size-base" href="<?= $rootPath ?>registro-reservacion">Pre
                        Check-In</a></li>
                    <li><a class="dropdown-item font-size-base" href="<?= $rootPath ?>hotel">Grand Oasis Cancún</a></li>
                  </ul>
                </li>
                <!-- <li class="nav-item">
                  <a class="nav-link btn bg-warning btn-sm fw-bold font-size-base"  style="font-weight: bold; font-size: .9em;" href="<?= $rootPath ?>aparta-tu-full-pass"><?= index_apartado_fullpass ?></a> -->
              </ul>
            </div>
            <!-- <div class="cs-offcanvas-cap border-top">
                <a class="btn btn-translucent-primary btn-block" href="#modal-signin" data-toggle="modal" data-view="#modal-signin-view">
                  <i class="fe-user font-size-lg mr-2"></i>Sign in
                </a>
              </div> -->
          </div>
          
        </div>
        
      </div>
      
    </header>
    <?php 
        include($rootPath.'modals/modalLogin.php');
    ?>
    <!-- Page content-->