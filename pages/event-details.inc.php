<?php 
    if(isset($_GET['tag_evento'])){
        $dataevento=getDataEvento($_GET['tag_evento']);
        

    }

?>
<!-- Modal markup -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_tickets_event" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Modal title</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row justify-content-center" id="tickets_view_event">
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm">Save changes</button>
      </div>
    </div>
  </div>
</div>
<div class="container">
        
    <div class="row bg-secondary">                        
        <div class="col-lg-12 pt-3">
            <div class="cs-gallery">
                <a class="cs-gallery-item rounded-lg" href="data:image/png;base64, <?= $dataevento['imageMail'] ?>">
                    <img src="data:image/png;base64, <?= $dataevento['imageMail'] ?>" alt="Gallery thumbnail" style="max-height:400px; object-fit:cover">
                </a>
            </div>
        </div>     
        <div class="col-lg-12 d-none">
            <div class="jarallax bg-dark py-7" data-jarallax data-speed="0.3">
                <span class="bg-overlay" style="opacity: .6;"></span>
                <div class="jarallax-img " style="background-image: url('data:image/png;base64, <?= $dataevento['imageMail'] ?>'); max-height:550px;"></div>
                <div class="container bg-overlay-content py-5 py-sm-7 text-center">
                    
                </div>
            </div>     
        </div>     
    </div>
    <div class="row bg-secondary">
        <div class="col-lg-8">              
            <div class="px-sm-4 pt-4 py-lg-4">            
                <h2 class="h3 mb-2"><?= $dataevento['nombre'] ?></h2>
                <h5 class="text-muted"><?= $dataevento['descripcion'] ?></h5>                    
                <div class="d-sm-flex alitgn-itams-center pt-3 pb-2 mb-2 border-bottom font-size-sm">
                    <div class="d-flex align-items-center mb-3">
                        <div class="text-nowrap text-danger mr-3 h5"><i class="fe-calendar mr-1"></i><span><?= $dataevento['set_fechainicio'] ?></span></div>                    
                    </div>                
                </div>                
                <ul class="list-unstyled font-size-md mb-2 pb-2">
                    <li class="mb-2"><div class="text-nowrap text-muted"><i class="fe-map mr-1"></i><span><?= $dataevento['sede'] ?></span></div></li>                  
                    <li class="mb-2"><i class="fe-map-pin mr-1"></i>Ubicación: <span><?= $dataevento['lugar_evento'] ?></span></li>                  
                </ul>                                              
                <div class="d-flex align-items-center justify-content-start pt-lg-2">
                    <a class="social-btn sb-outline sb-facebook ml-2 my-2" href="#"><i class="fe-facebook"></i></a>
                    <a class="social-btn sb-outline sb-instagram ml-2 my-2" href="#"><i class="fe-instagram"></i></a>                    
                </div>
            </div>              
        </div>
        <div class="col-lg-4">            
            <div class="px-sm-4 pt-4 py-lg-4">
                <button class="btn btn-primary btn-block" id="addtickets_event" type="button">Conseguir boletos</button>
                <button class="btn btn-outline-secondary btn-block mb-grid-gutter" type="button"><i class="fe-heart font-size-lg mr-2"></i>Agregar a mis favoritos</button>  
            </div>            
        </div>
    </div>
    <section class="mt-5 border-bottom" id="more-info">
        <div class="container">
          <div class="row align-items-center pb-3 mb-2">
            <div class="col-lg-6 text-center">
              <h2 class="h3 mb-4"> <i class="fe-calendar mr-1"></i>Cuando será?</h2>
              <p class="h3 text-danger"><?= strtoupper($dataevento['fecha_completa']) ?></p>                            
            </div>              
            <div class="col-lg-6">
                <div class="cs-countdown justify-content-center pt-3 h2" data-countdown="<?= $dataevento['set_countdown'] ?> 00:00:00 AM">
                    <div class="cs-countdown-days">
                        <span class="cs-countdown-value">0</span>
                        <span class="cs-countdown-label text-body">Días</span>
                    </div>
                    <div class="cs-countdown-hours">
                        <span class="cs-countdown-value">0</span>
                        <span class="cs-countdown-label text-body">Horas</span>
                    </div>
                    <div class="cs-countdown-minutes">
                        <span class="cs-countdown-value">0</span>
                        <span class="cs-countdown-label text-body">Mins</span>
                    </div>
                    <div class="cs-countdown-seconds">
                        <span class="cs-countdown-value">0</span>
                        <span class="cs-countdown-label text-body">Segs</span>
                    </div>
                </div>
            </div>                
          </div>          
        </div>
      </section>
      <section class="mt-4 pt-3 pt-md-0 pb-5 pb-md-6 mb-5 mb-md-6" id="more-info">
        <div class="container">                   
          <div class="row align-items-center">             
            <div class="col-lg-6">
                 <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4516.265353439318!2d-98.19419427131554!3d19.042684483196037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85cfc1580b2b0cd9%3A0x6e8cbe35c02540a0!2sCentro%20de%20Convenciones!5e0!3m2!1ses!2smx!4v1689978614248!5m2!1ses!2smx" width="800" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>            
            </div>
            <div class="col-lg-6">
              <h2 class="h3 mb-4">Donde será?</h2>
              <h6 class="mb-3"><?= $dataevento['sede'] ?></h6>
              <p class="font-size-sm pb-2"><?= $dataevento['lugar_evento'] ?></p>              
            </div>  
        </div>
      </section>      
</div>