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
  <?php require 'templates/headers_cache.php'; ?>
 
  <link rel="stylesheet" media="screen" href="<?= $rootPath ?>assets\vendor\simplebar\dist\simplebar.min.css">
  <!-- Main Theme Styles + Bootstrap-->
  <link rel="stylesheet" media="screen" href="<?= $rootPath ?>assets\css\app.min.css">
  <link rel="stylesheet" media="screen" href="<?= $rootPath ?>assets\css\theme.min.css">  
  <link rel="stylesheet" media="screen" href="<?= $rootPath ?>assets\css\elvdc.min.css">
  <link rel="stylesheet" media="screen" href="<?= $rootPath ?>assets\css\icons.min.css">
  <link rel="stylesheet" media="screen" href="<?= $rootPath ?>assets\css\loginModule.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

  
  
  <?php require 'templates/links-scripts.header.php'; ?>

</head>
<!-- Body-->

<body>
    <div class="cs-page-loading ">
        <div class="cs-page-loading-inner">
        <div class="cs-page-spinner">

            <span class="spinner-grow spinner-grow-sm mr-2 mb-4" style="width: 3rem; height: 3rem;" role="status"
            aria-hidden="true"></span>
            <span id="textoload"> </span>
        </div>
        </div>

    </div>
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
        <div class="container px-0 px-xl-3">
          <button class="navbar-toggler ml-n2 mr-2" type="button" data-toggle="offcanvas"
            data-offcanvas-id="primaryMenu"><span class="navbar-toggler-icon"></span></button><a
            class="navbar-brand order-lg-1 mx-auto ml-lg-0 pr-lg-2 mr-lg-4" href="<?= $rootPath ?>"><img
              class="navbar-floating-logo d-none d-lg-block" width="50"
              src="<?= $rootPath ?>assets\img\logo\logo-icon.png" alt="Around"><img class="navbar-stuck-logo"
              width="50" src="<?= $rootPath ?>assets\img\logo\logo-icon.png" alt="Around"><img class="d-lg-none"
              width="50" src="<?= $rootPath ?>assets\img\logo\logo-icon.png" alt="Around"></a>
              <div class="d-flex align-items-center order-lg-3 ml-lg-auto">
                <div class="navbar-tool mr-1 mx-3">
                  <a class="navbar-tool-icon-box" href="#" data-toggle="offcanvas" data-offcanvas-id="shoppingCart">
                    <i class="fe-shopping-cart"></i>
                    <span class="navbar-tool-badge total-count"></span>
                  </a>
                </div>
                <?php if(!isset($_SESSION['status'])){ ?>
                  <a class="nav-link-style font-size-sm text-nowrap" href="login" >
                      <i class="fe-user font-size-xl mr-2"></i>
                      
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
         
          
        </div>
        
      </div>
      
    </header>
    <div class="container-fluid divCarrito">
        <form class="cs-sidebar-enabled cs-sidebar-right formOrdenPases"
        action="/" method="post" id="my-awesome-dropzone" data-plugin="dropzone" data-previews-container="#file-previews"
            data-upload-preview-template="#uploadPreviewTemplate" 
             novalidate>
            <div class="row">
            <!-- Content-->
                <div class="col-lg-8 cs-content py-4 ">
                    <h1 class="mb-3 pb-4">Checkout</h1>       
                    <div class="divTickets">
                        <div class="accordion divPromocion mt-4 d-none" >
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                <h3 class="accordion-heading">
                                    <a href="#collapseOne" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                                        Promociones
                                    <span class="accordion-indicator"></span>
                                    </a>
                                </h3>
                                </div>
                                <div class="collapse show" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="mb-4 inputsPromocion">
                                    
                                    </div>
                                    
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion mt-4" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headTickets">
                                    <h3 class="accordion-heading">
                                        <a href="#collapseOne" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                                        Asignación de Tickets
                                            <span class="accordion-indicator"></span>
                                        </a>
                                    </h3>
                                </div>
                                <div class="collapse show" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="mb-4 inputsForm">
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion divCompetencia mt-4" >
                            <div class="card">
                                <div class="card-header" id="headCompetencia">
                                    <h3 class="accordion-heading">
                                        <a href="#collapseTwo" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="collapseTwo">
                                        Registro de Competencia
                                        <span class="accordion-indicator"></span>
                                        </a>
                                    </h3>
                                </div>
                                <div class="collapse" id="collapseTwo" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="mb-4 inputsCompetencia">
                                        
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>    
                </div>
                <!-- Sidebar-->
                <div class="col-lg-4 cs-sidebar bg-secondary pt-5 pl-lg-4 pb-md-2 show-carrito">
                    <div class="pl-lg-4 mb-3 pb-5">
                    <h2 class="h4 pb-3">Your cart</h2>
                    <div class="carritoItems">

                    </div>
                    
                    
                    <div class="d-flex justify-content-between mb-3"><span class="h6 mb-0">Invoice id: </span><span class="h6 mb-0 invoiceid">&mdash;</span></div>
                    <hr class="mb-4">
                    <div class="d-flex justify-content-between mb-3 divCupon">
                                                
                    </div>
                    <div class="d-flex justify-content-between mb-3"><span class="h6 mb-0">Subtotal:</span><span class="text-nav subtotalCarrito">&mdash;</span></div>
                    <div class="d-flex justify-content-between mb-3"><span class="h6 mb-0">Descuento:</span><span class="text-nav descuentoCarrito">&mdash;</span></div>
                    <div class="d-flex justify-content-between mb-3"><span class="h6 mb-0">Tax:</span><span class="text-nav tax">&mdash;</span></div>
                    <div class="d-flex justify-content-between mb-3"><span class="h6 mb-0">Total:</span><span class="h6 mb-0 total-cart">&mdash;</span></div>
                    <h4 class="h4 py-3"><?= index_informacion_adicional ?></h4>
                    <div class="form-group pb-3 pb-lg-2">
                        <label class="form-label" for="ch-order-notes"><?= index_notas_de_orden ?></label>
                        <textarea class="form-control notas_orden" rows="4" placeholder="<?= index_placeholder_notas_orden ?>" name="notas_orden"></textarea>
                    </div>
                    
                    
<!-- 
                    <div class="accordion accordion-alt pt-4 mb-grid-gutter" id="payment-methods">
                        <a class="btn btn-warning btn-sm btn-block mb-4 botonDescuento" >
                           Agregar cupón
                        </a>
                        <a class="btn btn-dark btn-sm btn-block mb-4 clear-cart" >
                            <i class="fe-trash font-size-base mr-2"></i>Borrar carrito
                        </a>                        
                        <div class="card border-0 box-shadow">
                            <div class="card-header p-3">
                                <div class="p-1">
                                    <div class="custom-control custom-radio collapsed"  data-target="#divTarjeta">
                                        <input class="custom-control-input messageCheckbox" type="radio" id="paypal-radio" name="payment_method" value='stripe'>
                                        <label class="d-flex align-items-center h6 mb-0" for="divTarjeta">
                                            <span>Credit Card</span>
                                            <img class="ml-3" width="130" src="<?php echo $rootPath ?>assets/img/shop/cards.png" alt="Accepted cards">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse show" id="credit-card" data-parent="#payment-methods">
                                <div class="card-body">
                                    <div class="alert alert-danger d-none messagecc" role="alert">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="cc-number">Card number</label>
                                        <input class="form-control bg-image-0" type="text" id="cc-number" name="cc-number" data-format="card"
                                        placeholder="0000 0000 0000 0000" value="4242424242424242" required>
                                    </div>
                                    <div class="row no-gutters">
                                        <div class="col-7 px-2 form-group mb-1">
                                        <label class="form-label" for="cc-expiry">Expiry date</label>
                                        <input class="form-control bg-image-0" type="text" value="0225" id="cc-expiry" name="cc-expiry" data-format="date"
                                            placeholder="mm/yy" required>
                                        </div>
                                        <div class="col-5 px-2 form-group mb-1">
                                        <label class="form-label" for="cc-cvc">CVC</label>
                                        <input class="form-control bg-image-0" type="text" value="341" id="cc-cvc" name="cc-cvc" data-format="cvc"
                                            placeholder="000" required>
                                        </div>
                                    </div>
                                    <div class="d-sm-flex flex-wrap justify-content-between align-items-center text-center pt-4">
                                        <div class="custom-control custom-checkbox mt-2 mr-3">
                                            <input class="custom-control-input" type="checkbox" id="saveCard" >
                                            <label class="custom-control-label" for="saveCard">Guardar tarjeta para próximos pagos</label>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">
                            <span id="button-text">Finalizar compra</span>
                        </button>
                    </div> -->
                    
                    <div class="accordion accordion-alt pt-4 mb-grid-gutter" id="payment-methods">
                        <a class="btn btn-warning btn-sm btn-block mb-4 botonDescuento" >
                           Agregar cupón
                        </a>
                        <a class="btn btn-dark btn-sm btn-block mb-4 clear-cart" >
                            <i class="fe-trash font-size-base mr-2"></i>Borrar carrito
                        </a>   
                        <div class="card border-0 box-shadow">
                            <div class="card-header p-3">
                                <div class="p-1">
                                    <div class="custom-control custom-radio" data-toggle="collapse" data-target="#credit-card">
                                        <input class="custom-control-input" type="radio" id="credit-card-radio" value="credit-card" name="payment_method">
                                        <label class="custom-control-label d-flex align-items-center h6 mb-0"
                                        for="credit-card-radio"><span>Credit Card</span><img class="ml-3" width="130"
                                            src="assets\img\shop\cards.png" alt="Accepted cards">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse" id="credit-card" data-parent="#payment-methods">
                                <div class="card-body">
                                    <div class="alert alert-danger d-none messagecc" role="alert"></div>
                                    <div class="form-group">
                                        <label class="form-label" for="cc-number">Card number</label>
                                        <input class="form-control bg-image-0" type="text" id="cc-number" name="cc-number" data-format="card"
                                        placeholder="0000 0000 0000 0000" value="4242424242424242" required>
                                    </div>
                                    <div class="row no-gutters">
                                        <div class="col-7 px-2 form-group mb-1">
                                        <label class="form-label" for="cc-expiry">Expiry date</label>
                                        <input class="form-control bg-image-0" type="text" value="0225" id="cc-expiry" name="cc-expiry" data-format="date"
                                            placeholder="mm/yy" required>
                                        </div>
                                        <div class="col-5 px-2 form-group mb-1">
                                        <label class="form-label" for="cc-cvc">CVC</label>
                                        <input class="form-control bg-image-0" type="text" value="341" id="cc-cvc" name="cc-cvc" data-format="cvc"
                                            placeholder="000" required>
                                        </div>
                                    </div>
                                    <!-- <div class="d-sm-flex flex-wrap justify-content-between align-items-center text-center pt-4">
                                        <div class="custom-control custom-checkbox mt-2 mr-3">
                                            <input class="custom-control-input" type="checkbox" id="saveCard" >
                                            <label class="custom-control-label" for="saveCard">Guardar tarjeta para próximos pagos</label>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>                        
                        <div class="card border-0 box-shadow">
                            <div class="card-header p-3">
                                <div class="p-1">
                                    <div class="custom-control custom-radio collapsed" data-toggle="collapse" data-target="#cash">
                                        <input class="custom-control-input" type="radio" id="cash-radio" value="transfer" name="payment_method">
                                        <label class="custom-control-label d-flex h6 mb-0" for="cash-radio">Comprobante de pago</label>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse" id="cash" data-parent="#payment-methods">
                                <div class="card-body">
                                
                                    <div class="dropzone">
                                        <div class="fallback">
                                            <!-- <input name="fileComprobantesCheckout" type="file" id="selectfile" multiple /> -->
                                        </div>

                                        <div class="dz-message needsclick">
                                            <i class="h1 text-muted dripicons-cloud-upload"></i>
                                            <h3>Drop files here or click to upload.</h3>
                                            <span class="text-muted font-13">(This is just a demo dropzone. Selected files are
                                                <strong>not</strong> actually uploaded.)</span>
                                        </div>
                                    </div>
                                    
                                    <div class="dropzone-previews mt-3" id="file-previews"></div>                                    
                                                                     
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">
                            <span id="button-text">Finalizar compra</span>
                        </button>
                    </div>
                    
                    </div>
                </div>
            </div>
        </form>
        <div class="d-none" id="uploadPreviewTemplate">
            <div class="card mt-1 mb-0 shadow-none border">
                <div class="p-2">
                    <div class="row align-items-center mb-1">
                        <div class="col-auto">
                            <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" style="max-width:70px;" alt="">
                        </div>
                        <div class="col pl-0">
                            <a href="javascript:void(0);" class="text-muted font-weight-bold" data-dz-name></a>
                            <p class="mb-0" data-dz-size></p>
                        </div>
                        <div class="col-auto">
                            <a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
                                <i class="dripicons-cross"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="num_referencia_comprobante">No. de referencia</label>
                                <input class="form-control bg-image-0" type="text" name="num_referencia_comprobante" 
                                placeholder="Ingrese el no. de referencia de su comprobante" value="" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="monto_comprobante">Monto</label>
                                <input class="form-control bg-image-0" type="number" name="monto_comprobante" placeholder="Ingrese el monto de su comprobante" value="" step=".01" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
        <!-- <form action="/" method="post" class="dropzone" id="myAwesomeDropzone" data-plugin="dropzone" data-previews-container="#file-previews"
            data-upload-preview-template="#uploadPreviewTemplate">
            
        </form> -->

        

    </div>