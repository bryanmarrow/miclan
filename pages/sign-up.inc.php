<div class="d-none d-md-block position-absolute w-50 h-100 bg-size-cover" style="top: 0; right: 0; background-image: url(<?= $rootPath ?>assets/img/pages/coming-soon/background-paises.jpg);">
    <span class="bg-overlay bg-gradient" style="opacity: .4;"></span>
</div>
<section class="container d-flex align-items-center pt-7 pb-3 pb-md-4" style="flex: 1 0 auto;">
    <div class="w-100 pt-3">
        <div class="row">
            <div class="col-lg-4 col-md-6 offset-lg-1">
                <div class="cs-view-show" id="signup-view">
                <h1 class="h2">Registro</h1>
                <p class="font-size-ms text-muted mb-4">El registro le tomará menos de 1 minuto, pero le dará el control de todos sus pases o inscripciones</p>
                <form class="needs-validation" id="SignUp" novalidate="">                
                  <div class="form-group">
                    <input class="form-control" name="fname" type="text" placeholder="Nombre" required="">
                  </div>
                  <div class="form-group">
                    <input class="form-control" name="lname" type="text" placeholder="Apellidos" required="">
                  </div>
                  <div class="form-group">
                    <input class="form-control" id="emailSignUp" name="email" type="text" placeholder="Email" required="">
                    <span id='messageEmail' class="messageForm"></span>
                  </div>
                  <div class="form-group">
                    <input class="form-control" id="confemailSignUp" name="confemail" type="text" placeholder="Confirmar Email" required="">
                  </div>
                  <div class="form-group">
                    <label class="form-label" >País<sup class="text-danger ml-1">*</sup></label>
                    <select class="form-control custom-select" name="country" required="">
                      <option value="" >Seleccionar una opción</option>
                      <?php 


                        foreach(getAllCountries() as $item){

                        
                      ?>

                          <option value="<?= $item['id'] ?>" ><?= $item['pais'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="input-group-overlay form-group">
                    <label for="normal-input" class="form-label mr-4">Género: </label> 
                    <div class="custom-control custom-radio custom-control-inline">
                      <input class="custom-control-input" type="radio" id="ex-radio-4" value="M" name="genre" required>
                      <label class="custom-control-label" for="ex-radio-4">Masculino</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input class="custom-control-input" type="radio" id="ex-radio-5" value="F" name="genre" required>
                      <label class="custom-control-label" for="ex-radio-5">Femenino</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="date-input" class="form-label">Fecha de Nacimiento</label>
                    <input class="form-control" type="date" name="birthday" id="date-input" required>
                  </div>
                  <div class="cs-password-toggle form-group">
                    <input class="form-control" name="password" id="SignUpPassword" type="password" placeholder="Password" required="">
                    <label class="cs-password-toggle-btn">
                      <input class="custom-control-input" type="checkbox"><i
                        class="fe-eye cs-password-toggle-indicator"></i><span class="sr-only">Show password</span>
                    </label>
                  </div>
                  <div class="cs-password-toggle form-group">
                    <input class="form-control" name="confpassword" id="SignUpconfirm_password" type="password" placeholder="Confirm password" required="">
                    <span id='message' class="messageForm"></span>
                    <label class="cs-password-toggle-btn">
                      <input class="custom-control-input" type="checkbox"><i
                        class="fe-eye cs-password-toggle-indicator"></i><span class="sr-only">Show password</span>
                    </label>
                  </div>
                  <button class="btn btn-primary btn-block" type="submit">Registrarse</button>              
                </form>
                </div>
            </div>
        </div>
    </div>
</section>