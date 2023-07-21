<?php

session_start();

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
  <?php require $rootPath.'templates/headers_cache.php'; ?>
 
  <link rel="stylesheet" media="screen" href="<?= $rootPath ?>assets\vendor\simplebar\dist\simplebar.min.css">
  <!-- Main Theme Styles + Bootstrap-->
  <link rel="stylesheet" media="screen" href="<?= $rootPath ?>assets\css\theme.min.css">
  <link rel="stylesheet" media="screen" href="<?= $rootPath ?>assets\css\elvdc.min.css">

  <?php require $rootPath.'templates/links-scripts.header.php'; ?>

</head>
<!-- Body-->

<body>
<div class="container d-flex flex-column justify-content-center pt-5 mt-n6" style="flex: 1 0 auto;">
    <div class="pt-7 pb-5">
        <div class="text-center mb-2 pb-4">
        <h1 class="mb-grid-gutter">
            <img class="d-inline-block" src="assets\img\pages\404\404-illustration.svg" alt="Error 404">
            <span class="sr-only">Error 404</span>
            <span class="d-block pt-3 font-size-sm font-weight-semibold text-danger">Error code: 404</span>
        </h1>
        <h2>Pagina no existe</h2>
        <!-- <p class="pb-2">It seems we can’t find the page you are looking for.</p> -->
        <a class="btn btn-translucent-primary mr-3" href="<?= $rootPath ?>">Regresar al inicio</a>
        </div>
        
        </div>
    </div>
</div>

 <!-- Vendor scrits: js libraries and plugins-->
    
 <script src="<?= $rootPath ?>assets\js\jquery-1.9.1.min.js"></script>
    <script src="<?= $rootPath ?>assets\js\jquery.cookie-1.3.1.js"></script>
    <script src="<?= $rootPath ?>assets\js\modernizr-2.6.2.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
    <script src="<?= $rootPath ?>assets\vendor\bootstrap\dist\js\bootstrap.bundle.min.js"></script>
    <script src="<?= $rootPath ?>assets\vendor\bs-custom-file-input\dist\bs-custom-file-input.min.js"></script>
    <script src="<?= $rootPath ?>assets\vendor\simplebar\dist\simplebar.min.js"></script>
    <script src="<?= $rootPath ?>assets\vendor\smooth-scroll\dist\smooth-scroll.polyfills.min.js"></script>
    <script src="<?= $rootPath ?>assets\vendor\lightgallery.js\dist\js\lightgallery.min.js"></script>
    <script src="<?= $rootPath ?>assets\vendor\lg-fullscreen.js\dist\lg-fullscreen.min.js"></script>
    <script src="<?= $rootPath ?>assets\vendor\lg-zoom.js\dist\lg-zoom.min.js"></script>
    <script src="<?= $rootPath ?>assets\vendor\lg-video.js\dist\lg-video.min.js"></script>
    <script src="<?= $rootPath ?>assets\vendor\parallax-js\dist\parallax.min.js"></script>
    <script src="<?= $rootPath ?>assets\vendor\jarallax\dist\jarallax.min.js"></script>
    <script src="<?= $rootPath ?>assets\vendor\jarallax\dist\jarallax-element.min.js"></script>
    <script src="<?= $rootPath ?>assets\vendor\lg-fullscreen.js\dist\lg-fullscreen.min.js"></script>
    
    <!-- <script src="https://www.paypal.com/sdk/js?client-id=sb&currency=USD" data-sdk-integration-source="button-factory"></script> -->
    
    <!-- Main theme script-->
    <script src="<?= $rootPath ?>assets\js\theme.min.js"></script>
    
    <script src="<?= $rootPath ?>assets\js\jquery.steps.min.js"></script>
    <script src="<?= $rootPath ?>assets/js/actions.js" ></script>
    <script src="<?= $rootPath ?>js/precheckin.js" ></script>

    <script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
    <script src="<?= $rootPath ?>assets/js/dist/js/lightgallery-all.min.js"></script>
    <script src="<?= $rootPath ?>assets/js/lib/jquery.mousewheel.min.js"></script>
    <script
    src='//fw-cdn.com/7104283/3248583.js'
    chat='true'>
    </script>

    <?php 
      require($rootPath."templates/linkspay.php");
    ?>
    
  </body>
</html>