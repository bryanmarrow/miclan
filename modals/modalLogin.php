<div class="modal fade" id="newPassword" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
        
        </div>
        <div class="modal-body tab-content py-4">
          <form id="formNewPassword" class="needs-validation" novalidate>
            <div class="form-group">
              <label for="pass1" class="form-label">Nueva contraseña</label>
              <div class="cs-password-toggle">
                <input class="form-control" type="password" id="newpass" name="newpass" required>
                <span id='messagenewPassword' class="messageForm"></span>
                <label class="cs-password-toggle-btn">
                  <input class="custom-control-input" type="checkbox">
                  <i class="fe-eye cs-password-toggle-indicator"></i>
                  <span class="sr-only">Show password</span>
                </label>
              </div>
            </div>
            <div class="form-group">
              <label for="pass1" class="form-label">Confirme su nueva contraseña</label>
              <div class="cs-password-toggle">
                <input class="form-control" type="password" id="newpass1" name="newpass1" required>
                <label class="cs-password-toggle-btn">
                  <input class="custom-control-input" type="checkbox">
                  <i class="fe-eye cs-password-toggle-indicator"></i>
                  <span class="sr-only">Show password</span>
                </label>
              </div>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Cambiar contraseña</button>
          </form>
        </div>
      </div>
    </div>
  </div>