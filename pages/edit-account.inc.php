
<section class="container-fluid d-flex align-items-center pt-3 pb-3 pb-md-4" style="flex: 1 0 auto;">
    <div class="w-100 pt-3">
        <div class="row">
            <?php
                require './templates/sidebarAccount.php';
            ?>
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="d-flex flex-column h-100 bg-light rounded-lg box-shadow-lg p-4">
                    <div class="py-2 p-md-3">
                        <!-- Title + Delete link-->
                        <div class="d-sm-flex align-items-center justify-content-between pb-4 text-center text-sm-left">
                            <h1 class="h3 mb-2 text-nowrap">Editar cuenta</h1>
                        </div>
                        
                        <form action="" id="formEditAccount">
                            <div class="bg-secondary rounded-lg p-4 mb-4">
                                <div class="media d-block d-sm-flex align-items-center">
                                        <img
                                        class="d-block rounded-circle mx-auto mb-3 mb-sm-0" style="height: 112px;width: 112px;object-fit: cover;" id="cambiarAvatarPreview"
                                        src="<?= $imgUser ?>" alt="<?= $colUser['fname'] ?> <?= $colUser['lname'] ?>">
                                    <div class="media-body pl-sm-3 text-center text-sm-left">            
                                        <input type="file" id="imgupload" name="img_new_avatar" class="d-none" />                         
                                        <button class="btn btn-light box-shadow btn-sm mb-2" type="button" id="OpenImgUpload">
                                            <i class="fe-refresh-cw mr-2"></i>Cambiar avatar
                                        </button>
                                        <img src="" height="200" />
                                        <div class="p mb-0 font-size-ms text-muted">Upload JPG, GIF or PNG image. 300 x 300
                                            required.</div>
                                    </div>
                                </div>
                            </div>                                             
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="account-fn">First Name</label>
                                        <input class="form-control" type="text" name="fname" value="<?= $colUser['fname'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="account-ln">Last Name</label>
                                        <input class="form-control" type="text"  name="lname" value="<?= $colUser['lname'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="account-email">Email address</label>
                                        <input class="form-control" type="email" name="email"
                                            value="<?= $colUser['email'] ?>">
                                    </div>
                                </div>                            
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="account-country">Country</label>
                                        <select class="custom-select setCountries" name="country" data-idcountry="<?= $colUser['country'] ?>">    
                                                                                                                
                                        </select>
                                    </div>
                                </div>                           
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="account-city">City</label>
                                        <input class="form-control" type="text" name="city" value="<?= $colUser['city'] ?>">
                                    </div>
                                </div>                            
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="account-zip">No. de teléfono</label>
                                        <input class="form-control" type="number" name="phonenumber" value="<?= $colUser['phonenumber'] ?>">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <hr class="mt-2 mb-4">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">                                    
                                        <button class="btn btn-primary mt-3 mt-sm-0" type="submit">
                                            <i class="fe-save font-size-lg mr-2"></i>Guardar cambios
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>             
        </div>
    </div>
</section>