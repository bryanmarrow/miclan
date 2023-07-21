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
    <main class="cs-page-wrapper d-flex flex-column">
      <!-- Page content-->
      <div class="row no-gutters d-lg-flex" style="flex: 1 0 auto;">
        <!-- Left half: Background image + Counter + Footer-->
        <div class="col-lg-6 d-flex flex-column pt-4 pb-3 px-4 position-relative bg-size-cover" style="flex: 1 0 auto; background-image: url(<?= $rootPath ?>assets/img/pages/coming-soon/background-paises.jpg);">
          <span class="bg-overlay bg-gradient" style="opacity: .9;"></span>
          <div class="bg-overlay-content text-center mb-4 mb-lg-0"><a class="d-inline-block" href="index.html"><img width="300" src="<?= $rootPath ?>assets\img\logo\logo-light.png" alt="Around"></a></div>
          <div class="bg-overlay-content mx-auto my-auto text-center" style="max-width: 500px;">
            <h1 class="mb-3 text-light">Website en mantenimiento. </h1>
            <p class="mb-grid-gutter text-light">Favor de intentarlo más tarde.</u></p>
            <div class="pt-4 pb-3">
                <a class="social-btn sb-light sb-facebook mx-2 mb-2" href="<?= $socialFacebook['value'] ?>"><i class="fe-facebook"></i></a>
                <a class="social-btn sb-light sb-instagram mx-2 mb-2" href="<?= $socialInstagram['value'] ?>"><i class="fe-instagram"></i></a>
                <a class="social-btn sb-light sb-google mx-2 mb-2" href="<?= $socialYoutube['value'] ?>"><i class="fe-youtube"></i></a>
            </div>
          </div>
          
          <div class="cs-shape cs-shape-right bg-body d-none d-lg-block">
            <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 228.4 2500">
              <path fill="currentColor" d="M228.4,0v2500H0c134.9-413.7,202.4-830.4,202.4-1250S134.9,413.7,0,0H228.4z"></path>
            </svg>
          </div>
          <div class="cs-shape cs-shape-bottom cs-shape-curve bg-body d-lg-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 3000 185.4">
              <path fill="currentColor" d="M3000,0v185.4H0V0c496.4,115.6,996.4,173.4,1500,173.4S2503.6,115.6,3000,0z"></path>
            </svg>
          </div>
        </div>
        <!-- Right half: Notification form-->
        <div class="col-lg-6 py-5 pb-lg-6 px-4 align-self-center">
          
        </div>
      </div>
    </main>
    
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