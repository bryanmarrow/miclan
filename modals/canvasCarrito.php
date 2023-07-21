<div class="cs-offcanvas cs-offcanvas-collapse-always cs-offcanvas-right show-carrito" id="shoppingCart">
    <div class="cs-offcanvas-cap navbar-box-shadow px-4 mb-2">
        <h5 class="mt-1 mb-0">Carrito de compras</h5>
        <button class="close lead" type="button" data-toggle="offcanvas" data-offcanvas-id="shoppingCart"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="cs-offcanvas-body p-4 carritoItems" data-simplebar="">
        
    </div>
    <div class="cs-offcanvas-cap d-block border-top px-4 mb-2">
        <a class="btn btn-dark btn-sm btn-block mb-4 clear-cart" >
            <i class="fe-trash font-size-base mr-2"></i>Borrar carrito
        </a>
        <div class="d-flex justify-content-between mb-4">
            <span>Total:</span>
            <span class="h6 mb-0 total-cart">$ 0.00</span>
        </div>
        <a class="btn btn-primary btn-sm btn-block" href="checkout">
            <i class="fe-credit-card font-size-base mr-2"></i>Checkout
        </a>
    </div>
</div>

<div class="modal fade" id="modal-coupon" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title"><?= index_cuponpromocional ?></h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form class="modal-body" id="formcupon" novalidate="">
                <div class="input-group">
                    <input class="form-control inputCuponAgregar" type="text" placeholder="<?= index_ingresa_tu_codigo ?>" required>
                    <div class="input-group-append">
                    <button class="btn btn-primary btncupon" type="submit"><?= index_aplicarcodigo ?></button>
                    </div>
                </div>
                <div class="alertacupon text-danger"></div>
            </form>
            
        </div>
    </div>
</div>