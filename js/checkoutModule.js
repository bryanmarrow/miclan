chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

function randomString(length, chars) {
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;
}


var shoppingCart = (function () {

    var cart = [];

    function Item(idform, nomPase, precioPase, divisaPase, prdqty, subTotalCarrito, tipoPase, invoiceid) {
        this.sku = idform;
        this.nomPase = nomPase;
        this.precioPase = precioPase;
        this.quantity = prdqty;
        this.subTotalCarrito = subTotalCarrito
        this.divisaPase = divisaPase
        this.tipoPase = tipoPase
        this.invoiceid = invoiceid
    }

    function ItemCompetidor(idform, nomPase, precioPase, divisaPase, prdqty, subTotalCarrito, tipoPase, competidores, invoiceid) {
        this.sku = idform;
        this.nomPase = nomPase;
        this.precioPase = precioPase;
        this.quantity = prdqty;
        this.subTotalCarrito = subTotalCarrito
        this.divisaPase = divisaPase
        this.tipoPase = tipoPase
        this.competidores = competidores
        this.invoiceid = invoiceid
    }

    function saveCart() {
        localStorage.setItem('carritoelwsc', JSON.stringify(cart));

        saveCarritoCloud(JSON.parse(localStorage.getItem('carritoelwsc')))
    }

    function loadCart() {
        cart = JSON.parse(localStorage.getItem('carritoelwsc'));
    }

    if (localStorage.getItem("carritoelwsc") != null) {
        loadCart();
    }



    var obj = {};

    obj.addItemToCart = async function (idform, nomPase, precioPase, divisaPase, prdqty, tipoPase) {

        await $.ajax({
            url: './ajax/getPrecioPase.php',
            type: 'POST',
            data: {
                idform: idform
            }
        }).done(data => {

            precioPase = data.precio;
            nomPase = data.descripcion_pase;
            divisaPase = data.divisaPase
        })



        subTotalCarrito = precioPase * prdqty;
        invoiceid = randomString(12, chars);

        for (var item in cart) {
            if (cart[item].sku == idform) {

                cart[item].quantity = parseInt(prdqty) + parseInt(cart[item].quantity);
                cart[item].subTotalCarrito = parseInt(cart[item].precioPase) * parseInt(cart[item].quantity);
                // console.log(cart[item])
                // cart.push(cartItem)
                // console.log(cart)
                saveCart();
                return;

            }

        }
        var item = new Item(idform, nomPase, precioPase, divisaPase, prdqty, subTotalCarrito, tipoPase, invoiceid);
        cart.push(item);
        saveCart();


    }

    obj.addItemToCartCompetidor = async function (idform, tipoPase, objcompetidores) {

        // console.log(objcompetidores)

        invoiceid = randomString(12, chars);

        idCompetidores = objcompetidores.competidores;
        infoRegistro = objcompetidores.infoRegistro;

        await $.ajax({
            url: './ajax/infoCompetidor.php',
            type: 'POST',
            data: objcompetidores
        }).done(data => {
            competidores = data
        })

        await $.ajax({
            url: './ajax/getPrecioPase.php',
            type: 'POST',
            data: {
                idform: infoRegistro.idform
            }
        }).done(data => {
            precioPase = data.precio;
            nomPase = data.descripcion_pase;
            divisaPase = data.divisaPase
        })


        prdqty = 1;
        subTotalCarrito = prdqty * precioPase;

        if (idform == 'ELWSC2023INSCGRU') {
            prdqty = idCompetidores.length
            subTotalCarrito = precioPase * idCompetidores.length
            competidores['nombreGrupo'] = infoRegistro.nombreGrupo
            competidores['paisGrupo'] = infoRegistro.paisGrupo
        }



        var item = new ItemCompetidor(idform, nomPase, precioPase, divisaPase, prdqty, subTotalCarrito.toFixed(2), tipoPase, competidores, invoiceid);

        cart.push(item);
        saveCart();

    }

    obj.listCart = function () {
        var cartCopy = [];
        for (i in cart) {
            item = cart[i];
            itemCopy = {};
            for (p in item) {
                itemCopy[p] = item[p];

            }
            itemCopy.total = Number(item.precioPase * item.quantity).toFixed(2);
            cartCopy.push(itemCopy)
        }



        return cartCopy;
    }

    obj.clearCart = function () {
        cart = [];
        saveCart();
    }

    obj.removeItemFromCart = function (name) {

        for (var item in cart) {
            if (cart[item].sku === name) {
                cart[item].quantity--;
                if (cart[item].quantity === 0) {
                    cart.splice(item, 1);
                }
                break;
            }
        }
        saveCart();
    }

    obj.removeItemFromCartAll = function (name, tipopase) {


        switch (tipopase) {
            case 'acceso':
                for (var item in cart) {
                    if (cart[item].sku === name) {
                        cart.splice(item, 1);
                        break;
                    }
                }
                break;
            case 'competencia':
                for (var item in cart) {
                    if (cart[item].invoiceid === name) {
                        cart.splice(item, 1);
                        break;
                    }
                }
                break;
            case 'promo':
                for (var item in cart) {
                    if (cart[item].sku === name) {
                        cart.splice(item, 1);
                        break;
                    }
                }
                break;
        }

        saveCart();
    }

    obj.clearCart = function () {
        cart = [];
        saveCart();
    }

    obj.totalCart = function () {
        var totalCart = 0;
        for (var item in cart) {
            totalCart += cart[item].precioPase * cart[item].quantity;
        }

        return Number(totalCart.toFixed(2));
    }

    obj.totalCount = function () {
        var totalCount = 0;
        for (var item in cart) {

            totalCount += cart[item].tipoPase == 'competencia' ? 1 : parseInt(cart[item].quantity)

        }
        return totalCount;
    }

    obj.formInputs = async function () {



        var itemForm = "";
        var itemCompetencia = "";
        var itemPromocion = "";
        for (var item in cart) {


            console.log(cart[item]);

            if (cart[item].tipoPase == 'acceso') {

                if (cart[item].quantity > 1) {

                    for (var i = 0; i < cart[item].quantity; i++) {
                        // console.log(cart[item].sku+'_'+i);
                        rand = getRandomIntInclusive(1000, 9000);
                        randalf = generate_string(permitted_chars, 8);
                        sesion = randalf + rand;

                        itemForm += `
                        <div class="row rowPase border-bottom border-dark m-2 p-2">
                            <div class="col-sm-3 form-group mb-1">
                                <label class="form-label" for="ch-fn">Nombre<sup class="text-danger">*</sup></label>
                                <input class="form-control form-control-sm" type="text" name="fname" value="${ 'fname_'+sesion }" required="">
                            </div>
                            <div class="col-sm-3 form-group">
                                <label class="form-label" for="ch-fn">Apellidos<sup class="text-danger">*</sup></label>
                                <input class="form-control form-control-sm" type="text" name="lname" value="${ 'lname_'+sesion }" required="">
                            </div>
                            <div class="col-sm-3 form-group">
                                <label class="form-label" for="ch-fn">Pase<sup class="text-danger">*</sup></label>
                                <input class="form-control form-control-sm" type="text" name="nomPase" value="${ cart[item].nomPase }" required="" readonly>
                            </div>
                            <div class="col-sm-3 form-group">
                                <label class="form-label" for="ch-fn">Código de confirmación<sup class="text-danger">*</sup></label>
                                <input class="form-control form-control-sm" type="text" name="idPase" value="${ sesion }" required="" readonly>
                            </div>
                            <input class="form-control form-control-sm" type="text" name="idform" value="${ cart[item].sku }" required="" hidden>
                        </div>
                        `;




                    }
                }
                if (cart[item].quantity == 1) {
                    // console.log(cart[item].sku+'_'+item)
                    rand = getRandomIntInclusive(1000, 9000);
                    randalf = generate_string(permitted_chars, 8);
                    sesion = randalf + rand;
                    itemForm += `
                        <div class="row rowPase border-bottom border-dark m-2 p-2">
                            <div class="col-sm-4 form-group mb-1">
                                <label class="form-label" for="ch-fn">Nombre<sup class="text-danger ml-1">*</sup></label>
                                <input class="form-control form-control-sm" type="text" name="fname" value="${ 'fname_'+sesion }" required="">
                            </div>
                            <div class="col-sm-4 form-group mb-1">
                                <label class="form-label" for="ch-fn">Apellidos<sup class="text-danger ml-1">*</sup></label>
                                <input class="form-control form-control-sm" type="text" name="lname" value="${ 'lname_'+sesion }" required="">
                            </div>
                            <div class="col-sm-4 form-group mb-1">
                                <label class="form-label" for="ch-fn">Pase<sup class="text-danger ml-1">*</sup></label>
                                <input class="form-control form-control-sm" type="text" name="nomPase" value="${ cart[item].nomPase }" required="" readonly >
                            </div>
                            <div class="col-sm-4 form-group">
                                <label class="form-label" for="ch-fn">Código de confirmación<sup class="text-danger">*</sup></label>
                                <input class="form-control form-control-sm" type="text" name="idPase" value="${ sesion }" required="" readonly>
                            </div>
                            <input class="form-control form-control-sm" type="text" name="idform" value="${ cart[item].sku }" required="" hidden>
                        </div>
                    `;

                }
            } else if (cart[item].tipoPase == 'competencia') {


                for (var i = 0; i < cart[item].quantity; i++) {

                    competidores = cart[item].competidores.infocompetidores
                    categoria = cart[item].competidores.categoria
                    invoiceid = cart[item].invoiceid

                    nomCompetidores = "";

                    for (let index = 0; index < competidores.length; index++) {
                        const element = competidores[index];

                        nomCompetidores += `
                            <h5 class="nav-heading font-size-sm mb-2">Nombre competidor ${index+1}:  ${ element.fname + ' '+ element.lname }</h5>
                            <h5 class="text-muted font-size-sm mr-1 mb-3">ID Competidor: ${ element.idcompetidor }</h5>
                            
                        `;

                    }

                    nombreGrupo = cart[item].sku == 'grupos' ? `<h5 class="font-size-md">Nombre del Grupo: ${cart[item].competidores.nombreGrupo}</h5> ` : '';
                    numeroIntegrantes = cart[item].sku == 'grupos' ? `<h5 class="font-size-sm"># Integrantes: ${ cart[item].competidores.infocompetidores.length }</h5> ` : '';

                }

                itemCompetencia += `
                    <div class="d-sm-flex justify-content-between mb-3 border-bottom border-primary pb-1">
                        <div class="media media-ie-fix d-block d-sm-flex mr-sm-3">
                            <div class="media-body font-size-sm pt-2 pl-sm-3 text-center text-sm-left">
                                ${nombreGrupo}
                                ${numeroIntegrantes}
                                <h5 class="font-size-md">Categoría: ${categoria.categoria_es}</h5>
                                <hr class="mb-2">
                                ${nomCompetidores}
                            </div>
                        </div>
                        
                        <div class="font-size-sm text-center pt-2">
                            <div class="text-muted">ID de registro:</div>
                            <div class="font-weight-medium">${invoiceid}</div>
                        </div>
                    </div>
                `;
            } else if (cart[item].tipoPase == 'promo') {

                rand = getRandomIntInclusive(1000, 9000);
                randalf = generate_string(permitted_chars, 4);
                sesion = randalf + rand;

                for (let index = 0; index < cart[item].quantity; index++) {
                    itemPromocion += `
                            Integrante: ${ index+1 }
                            <div class="row rowPase border-bottom border-dark m-2 p-2">
                                <div class="col-sm-3 form-group mb-1">
                                    <label class="form-label" for="ch-fn">Nombre<sup class="text-danger ml-1">*</sup></label>
                                    <input class="form-control form-control-sm" type="text" name="fname" value="${ 'fname_'+sesion }" required="">
                                </div>
                                <div class="col-sm-3 form-group mb-1">
                                    <label class="form-label" for="ch-fn">Apellidos<sup class="text-danger ml-1">*</sup></label>
                                    <input class="form-control form-control-sm" type="text" name="lname" value="${ 'lname_'+sesion }" required="">
                                </div>
                                <div class="col-sm-3 form-group mb-1">
                                    <label class="form-label" for="ch-fn">Pase<sup class="text-danger ml-1">*</sup></label>
                                    <input class="form-control form-control-sm" type="text" name="nomPase" value="${ cart[item].nomPase }" required="" readonly >
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label class="form-label" for="ch-fn">ID<sup class="text-danger">*</sup></label>
                                    <input class="form-control form-control-sm" type="text" name="idPase" value="${ sesion }" required="" readonly>
                                </div>
                                <input class="form-control form-control-sm" type="text" name="idform" value="${ cart[item].sku }" required="" hidden>
                            </div>
                        `;


                }
            }
        }
        $('.inputsForm').html(itemForm);
        $('.inputsCompetencia').html(itemCompetencia);
        $('.inputsPromocion').html(itemPromocion);

    }

    obj.updateCarrito = function () {

        // console.log(cart)

        // coupon = [{ 'coupon': 'ELWSC' }];
        // cart.push(coupon)
        // saveCart();


        // console.log(cart)

        $.ajax({
            url: 'ajax/activarCupon.php',
            data: {
                cupon: '141991'
            },
            type: 'POST',
            dataType: "json",
        }).done(data => {
            console.log(data)
        })

        // descuento=0.50;
        // for(var item in cart){


        //     console.log(cart[item])

        //     await $.ajax({
        //         url: './ajax/getPrecioPase.php',
        //         type: 'POST',
        //         data: { idform: cart[item].sku }
        //     }).done(data => {

        //         // console.log(data)
        //         precioPase = data.precio;                
        //     })            

        //     if(cart[item].tipoPase=='competencia'){

        //         montoDescuento=precioPase*descuento;
        //         precioPase=precioPase-montoDescuento;

        //         cart[item].precioPase=precioPase.toFixed(2);
        //         cart[item].subTotalCarrito=precioPase.toFixed(2);

        //         if(cart[item].sku=='grupos'){
        //             subTotalCarrito=precioPase*cart[item].quantity
        //             cart[item].subTotalCarrito=subTotalCarrito.toFixed(2);
        //         }



        //     }


        // cart['coupon']='ELWSC';

        // }
    }


    return obj;
})();


$('.btnaddPase').on('click', function (e) {

    var idform = $(this).data('codigopase');
    var nomPase = $(this).data('nompase');
    var precioPase = $(this).data('preciopase');
    var divisaPase = $(this).data('divisapase');
    var tipoPase = $(this).data('tipopase');

    var itemParent = $(this).closest('div.itemCart');
    var prdqty = $(itemParent).find('input.product-qty').val();

    preloaderActive();

    shoppingCart.addItemToCart(idform, nomPase, precioPase, divisaPase, prdqty, tipoPase);


    setTimeout(function () {
        displayCart();
        preloaderRemove();
    }, 500)


})


$('.show-carrito').on("click", ".delete-item", function (event) {

    var name = $(this).data('codpase');
    var tipoPase = $(this).data('tipopase');

    shoppingCart.removeItemFromCartAll(name, tipoPase);
    displayCart();

})

$('.clear-cart').click(function () {
    preloaderActive();

    setTimeout(function () {
        shoppingCart.clearCart();
        displayCart();
        preloaderRemove();
    }, 500)
});






function getRandomIntInclusive(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1) + min);
}

function generate_string(input, strength = 16) {
    input_length = input.length;
    random_string = '';
    for (i = 0; i < strength; i++) {
        random_character = input[getRandomIntInclusive(0, input_length - 1)];
        random_string += random_character;
    }

    return random_string;
}
permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

var rString = randomString(8, '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ');

function randomString(length, chars) {
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;
}


$('.botonDescuento').on('click', function () {
    $('#modal-coupon').modal('show');
});


$('.formOrdenPases').on('click', '.delete-cupon', function (e) {
    e.preventDefault();
    $.ajax({
        url: './ajax/activarCupon.php',
        type: 'POST',
        data: {
            action: 'delete'
        }
    }).done(data => {
        if (data.respuesta === 'success') {
            displayCart();
        }
    })

})

$('#formcupon').submit(function (e) {
    e.preventDefault();

    inputCupon = document.querySelector('.inputCuponAgregar').value

    $.ajax({
        url: './ajax/activarCupon.php',
        type: 'POST',
        data: {
            action: 'activate',
            cupon: inputCupon
        }
    }).done(data => {
        if (data.respuesta == 'success') {


            $('.botonDescuento').fadeOut(500, function () {
                $('.botonDescuento').remove();
            });

            $('#modal-coupon').modal('hide')
            displayCart();

        }
        if (data.respuesta == 'error') {
            var texto = "Cupón no disponible";
            document.querySelector('.alertacupon').textContent = texto
            setTimeout(function () {
                document.querySelector('.alertacupon').textContent = ""
            }, 3000);
        }
    })

})


async function displayCart() {



    const options1 = {
        style: 'currency',
        currency: 'USD'
    };
    const numberFormat1 = new Intl.NumberFormat('en-US', options1);

    var cartArray = shoppingCart.listCart();



    viewPrecioSubTotalCarrito = '';
    viewTotalCarrito = '';
    viewTax = '';

    invoiceID = '';


    var output = "";

    $('.total-count').html(shoppingCart.totalCount());
    const divPaymentMethods = document.getElementById('payment-methods');



    await $.ajax({
        url: 'ajax/getDataEvento',
        type: 'POST'
    }).done(({
        respuesta,
        data
    }) => {

        switch (respuesta) {
            case 'success':
                invoiceID = data['tag'] + rString;
                break;
            default:
                break;
        }

    })

    divCupon = '';


    if (shoppingCart.totalCart() > 0) {

        console.log(cartArray)

        await $.ajax({
            url: 'ajax/getPrecioCarrito.php',
            data: {
                infoPases: cartArray
            },
            type: 'POST',
            dataType: "json",
        }).done(data => {
            comisionUSD = parseFloat(data.tax);
            subtotalUSD = parseFloat(data.subTotalCarrito);
            totalUSD = parseFloat(data.total_amount)
            cuponActivo = data.cupon['cupon']
            descuentoUSD = parseFloat(data.descuento);
        })



        const viewTax = numberFormat1.format(comisionUSD.toFixed(2));
        const viewPrecioSubTotalCarrito = numberFormat1.format(subtotalUSD.toFixed(2));
        const viewTotalCarrito = numberFormat1.format(Number(totalUSD.toFixed(2)));
        const viewDescuentoCarrito = numberFormat1.format(Number(descuentoUSD.toFixed(2)));

        if (cuponActivo) {
            divCupon = `<span class="h6 mb-0">Cupón: </span>
                <span class="h6 mb-0">
                    <span class="h6 mb-0 cupon">${ cuponActivo }</span>
                    <a class="text-danger text-decoration-none font-size-md delete-cupon"
                        href="#" data-toggle="tooltip" title="Eliminar cupón" >
                        <i class="fe-x-circle"></i>
                    </a>
                </span> `
        }

        // console.log(cartArray)

        carritoPrecio = [];
        for (var i in cartArray) {

            await $.ajax({
                url: './ajax/getPrecioPase.php',
                type: 'POST',
                data: {
                    idform: cartArray[i].sku
                }
            }).done(data => {

                precioPase = numberFormat1.format(data.precio, options1)
                subTotalPase = data.precio * cartArray[i].quantity
                carritoPrecio.push(data);
            })

            switch (cartArray[i].tipoPase) {
                case 'competencia':
                    infocompetidores = cartArray[i].competidores.infocompetidores;
                    infocategoria = cartArray[i].competidores.categoria;
                    nomCompetidores = '';
                    for (let index = 0; index < infocompetidores.length; index++) {
                        const element = infocompetidores[index];
                        switch (cartArray[i].sku) {
                            case 'ELWSC2023INSCSOL':
                                nomCompetidores = `${ element.fname + ' ' + element.lname } - ${ element.idcompetidor }`
                                break;
                            case 'ELWSC2023INSCPAR':
                                if (index == 0) {
                                    nomCompetidores += `${ element.fname } ${ element.lname } y `
                                } else {
                                    nomCompetidores += `${ element.fname } ${ element.lname }`
                                }
                                break;
                            case 'ELWSC2023INSCGRU':
                                // nomCompetidores=`<p class="font-size-xs mb-1">${ element.fname + ' ' + element.lname } - ${ element.idcompetidor } </p>`
                                nomCompetidores = '';
                                break;
                        }
                    }

                    numeroIntegrantes = cartArray[i].sku == 'ELWSC2023INSCGRU' ? cartArray[i].competidores.infocompetidores.length : '';
                    nombreGrupo = cartArray[i].sku == 'ELWSC2023INSCGRU' ? cartArray[i].competidores.nombreGrupo + ` - # Integrantes: ${numeroIntegrantes}` : '';


                    output += `<div class="media align-items-center mb-3">
                            <div class="media-body pl-2 ml-1">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="mr-3">
                                        <h4 class="nav-heading font-size-md mb-1">${ cartArray[i].nomPase }</h4>
                                        <p class="font-size-xs mb-1">${nomCompetidores} </p>
                                        <p class="font-size-xs mb-1">${nombreGrupo} </p>
                                        <p class="font-size-xs mb-1">${infocategoria.categoria_es} </p>
                                        <div class="d-flex align-items-center font-size-sm"><span class="mr-2">${ precioPase }</span><span class="mr-2">x</span>
                                            
                                        <span class="px-2" style="max-width: 3.5rem;">${ cartArray[i].quantity }</span>

                                        </div>
                                        <span class="font-size-xs mt-3">Subtotal: ${ numberFormat1.format(subTotalPase, options1) } </span>
                                    </div>
                                    <div class="pl-3 border-left">
                                        
                                        <a class="d-block text-danger text-decoration-none font-size-xl delete-item" href="#" data-toggle="tooltip" title="Remove" data-codpase="${ cartArray[i].invoiceid }" data-tipopase="${ cartArray[i].tipoPase }">
                                            <i class="fe-x-circle"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                    break;
                case 'acceso':
                    output += `
                        <div class="media align-items-center mb-3">
                            <div class="media-body pl-2 ml-1">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="mr-3">
                                    
                                        <h4 class="nav-heading font-size-md mb-1"><a class="font-weight-medium" href="shop-single.html">${ cartArray[i].nomPase }</a></h4>
                                        <div class="d-flex align-items-center font-size-sm"><span class="mr-2">${ precioPase }</span><span class="mr-2">x</span>
                                        
                                        <span class="px-2" style="max-width: 3.5rem;">${ cartArray[i].quantity }</span>
                                        </div>
                                        <span class="font-size-xs mt-3">Subtotal: ${ numberFormat1.format(subTotalPase, options1) } </span>
                                    </div>
                                    <div class="pl-3 border-left">
                                        <a class="d-block text-danger text-decoration-none font-size-xl delete-item" href="#" data-toggle="tooltip" title="Remove" data-codpase="${ cartArray[i].sku }" data-tipopase="${ cartArray[i].tipoPase }">
                                            <i class="fe-x-circle"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    break;
                default:
                    output += `
                        <div class="media align-items-center mb-3">
                            <div class="media-body pl-2 ml-1">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="mr-3">
                                    
                                        <h4 class="nav-heading font-size-md mb-1"><a class="font-weight-medium" href="shop-single.html">${ cartArray[i].nomPase }</a></h4>
                                        <div class="d-flex align-items-center font-size-sm"><span class="mr-2">${ precioPase }</span><span class="mr-2">x</span>
                                        
                                        <span class="px-2" style="max-width: 3.5rem;">${ cartArray[i].quantity }</span>
                                        </div>
                                        <span class="font-size-xs mt-3">Subtotal: ${ numberFormat1.format(subTotalPase, options1) } </span>
                                    </div>
                                    <div class="pl-3 border-left">
                                        <a class="d-block text-danger text-decoration-none font-size-xl delete-item" href="#" data-toggle="tooltip" title="Remove" data-codpase="${ cartArray[i].sku }" data-tipopase="${ cartArray[i].tipoPase }">
                                            <i class="fe-x-circle"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    break;
            }
        }

        const subTotalCarrito = carritoPrecio.map(item => Number(item['precio'])).reduce((prev, curr) => prev + curr, 0);



        $('.invoiceid').html(invoiceID);
        $('.subtotalCarrito').html(viewPrecioSubTotalCarrito)
        $('.descuentoCarrito').html(viewDescuentoCarrito)
        $('.total-cart').html(viewTotalCarrito);
        $('.tax').html(viewTax)
        $('.carritoItems').html(output);
        $('.divCupon').html(divCupon);
        shoppingCart.formInputs();

    } else {

        if (divPaymentMethods) {
            divPaymentMethods.remove();
        }

        carritoVacio = `<div class="container d-flex flex-column justify-content-center pt-5 mt-n6" style="flex: 1 0 auto;">
        <div class="pt-7 pb-5">
            <div class="text-center mb-2 pb-4">
                
                <h2>Tu carrito está vacío.</h2>
                
                <a class="btn btn-translucent-primary mr-3" href="./tickets">Comprar tickets</a>
            </div>
        </div>
        </div>`;
        $('.divTickets').html(carritoVacio)

        $('.tax').html(viewTax)
        $('.invoiceid').html(invoiceID);
        $('.subtotalCarrito').html(viewPrecioSubTotalCarrito)
        $('.total-cart').html(viewTotalCarrito);
        $('.carritoItems').html(output);


    }









}

displayCart();


const select_competidores = document.getElementById('select_competidores');
const select_categorias = document.querySelector('select[name="categoria_p"]');
const formCompetencias = document.getElementById('formCompetencias');

if (formCompetencias) {
    if (select_competidores) {
        select_competidores.addEventListener('change', (event) => {
            idCompetidor = event.target.value

            fetch('./ajax/formularios.php', {
                    method: "post",
                    body: JSON.stringify({
                        idCompetidor
                    })
                })
                .then((response) => response.json())
                .then((data) => {


                    $('#collapseInfoCompetidor').collapse('show');

                    document.querySelector('#nombre_p').textContent = data.fname + ' ' + data.lname
                    document.querySelector('#pais_p').textContent = data.pais
                    document.querySelector('#fecha_nac').textContent = data.fechanac

                })
        });
    }

    var inputs = document.querySelectorAll('.checkboxGrupo');
    $('.checkboxGrupo').on('click', function () {

        checkboxtrue = [];
        for (var i = 0; i < inputs.length; i++) {
            // inputs[i].checked = true;   
            if (inputs[i].checked) {
                checkboxtrue.push(inputs[i])
                console.log(inputs[i].dataset)
            }
        }
        $('.numCompetidoresGrupoSelect').html(checkboxtrue.length)
    })

    formCompetencias.addEventListener('submit', function (e) {
        e.preventDefault();

        var categoriaPase = select_categorias.value
        var tipoPase = $(this).data('tipopase');
        var idform = $(this).data('codigopase');

        // console.log(idform)
        // console.log(tipoPase)
        // console.log(categoriaPase)

        if (idform == 'ELWSC2023INSCSOL' || idform == 'ELWSC2023INSCPAR') {
            inputsCompetidores = document.getElementsByClassName('select_competidores');
            infoRegistro = {
                categoriaPase,
                tipoPase,
                idform
            };
        } else if (idform == 'ELWSC2023INSCGRU') {
            inputsCompetidores = document.querySelectorAll('.checkboxGrupo:checked');
            paisGrupo = document.querySelector('#selectpaisGrupo').value;
            nombreGrupo = document.querySelector('#nombregrupo_p').value;
            infoRegistro = {
                categoriaPase,
                tipoPase,
                idform,
                paisGrupo,
                nombreGrupo
            };
        }

        competidores = [];
        for (let index = 0; index < inputsCompetidores.length; index++) {
            const element = inputsCompetidores[index].value;
            datosCompetidor = {};
            datosCompetidor.idCompetidor = element
            competidores.push(datosCompetidor)
        }




        registroCompetencia = {
            competidores,
            infoRegistro
        };



        // console.log(registroCompetencia)

        preloaderActive();
        shoppingCart.addItemToCartCompetidor(idform, tipoPase, registroCompetencia);


        setTimeout(function () {
            displayCart();
            preloaderRemove();
        }, 500)

    })






}




function saveCarritoCloud(dataCarrito) {



    $.ajax({
        url: 'ajax/saveCarrito.php',
        data: {
            infoPases: dataCarrito
        },
        type: 'POST',
        dataType: "json",
    }).done(data => {
        console.log(data)
        if (data.respuesta == 'no_log') {

            if (localStorage.getItem("carritoelwsc") != null) {
                localStorage.removeItem("carritoelwsc");
            }

            displayCart();

        }

    })

    // return dataCloud;

}

saveCarritoCloud(shoppingCart.listCart())

Fancybox.bind("[data-fancybox]", {
    // Your custom options
});