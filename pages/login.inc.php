<section class="container d-flex justify-content-center align-items-center pt-7 pb-4" style="flex: 1 0 auto;">
    <div class="cs-signin-form mt-3">
        <div class="cs-signin-form-inner">       
            <div class="cs-view show" id="signin-view">
                <h1 class="h2 mb-4">Iniciar sesión</h1>
                <!-- <p class="font-size-ms text-muted mb-4">Sign in to your account using email and password provided during registration.</p> -->
                <form class="needs-validation" id="SignIn" novalidate="">
                  <div class="input-group-overlay form-group">
                    <div class="input-group-prepend-overlay"><span class="input-group-text"><i class="fe-mail"></i></span></div>
                    <input class="form-control prepended-form-control" name="email" type="email" placeholder="Email" required="">
                  </div>
                  <div class="input-group-overlay cs-password-toggle form-group">
                    <div class="input-group-prepend-overlay"><span class="input-group-text"><i class="fe-lock"></i></span></div>
                    <input class="form-control prepended-form-control" name="password" type="password" placeholder="Password" required="">
                    <label class="cs-password-toggle-btn">
                      <input class="custom-control-input" type="checkbox"><i class="fe-eye cs-password-toggle-indicator"></i><span class="sr-only">Show password</span>
                    </label>
                  </div>
                  <div class="d-flex justify-content-between align-items-center form-group">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" type="checkbox" id="keep-signed-2">
                      <label class="custom-control-label" for="keep-signed-2">Keep me signed in</label>
                    </div><a class="nav-link-style font-size-ms" href="forgot-password">Forgot password?</a>
                  </div>
                  <button class="btn btn-primary btn-block" type="submit">Sign in</button>
                  <p class="font-size-sm pt-3 mb-0">Don't have an account? <a href='<?= $rootPath ?>sign-up' class='font-weight-medium' >Sign up</a></p>
                </form>
            </div>
            
        
        </div>
    </div>
</section>