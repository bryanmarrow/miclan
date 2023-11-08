chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

function randomString(length, chars) {
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;
}

var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);

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

    function ItemCompetidor(idform, nomPase, precioPase, divisaPase, prdqty, subTotalCarrito, tipoPase, competidores, invoiceid, tipo_competencia) {
        this.sku = idform;
        this.nomPase = nomPase;
        this.precioPase = precioPase;
        this.quantity = prdqty;
        this.subTotalCarrito = subTotalCarrito
        this.divisaPase = divisaPase
        this.tipoPase = tipoPase
        this.competidores = competidores
        this.invoiceid = invoiceid
        this.tipo_competencia = tipo_competencia
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

        // console.log(idform, tipoPase, objcompetidores);

        invoiceid = randomString(12, chars);

        idCompetidores = objcompetidores.competidores;
        infoRegistro = objcompetidores.infoRegistro;

        await $.ajax({
            url: './ajax/infoCompetidor.php',
            type: 'POST',
            data: objcompetidores
        }).done(data => {
            console.log(data)
            competidores = data
        })

        await $.ajax({
            url: './ajax/getPrecioPase.php',
            type: 'POST',
            data: {
                idform: infoRegistro.idform
            }
        }).done(data => {
            console.log(data)

            precioPase = data.precio;
            nomPase = data.descripcion_pase;
            divisaPase = data.divisaPase
            tipo_competencia = data.tipo_competencia
        })


        prdqty = 1;
        subTotalCarrito = prdqty * precioPase;

        // if (tipo_competencia == 'grupos') {
        //     prdqty = idCompetidores.length
        //     subTotalCarrito = precioPase * idCompetidores.length
        //     competidores['nombreGrupo'] = infoRegistro.nombreGrupo
        //     competidores['paisGrupo'] = infoRegistro.paisGrupo
        // }



        var item = new ItemCompetidor(idform, nomPase, precioPase, divisaPase, prdqty, subTotalCarrito.toFixed(2), tipoPase, competidores, invoiceid, tipo_competencia);

        // console.log(item)

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
            } 
            // else if (cart[item].tipoPase == 'promo') {

            //     rand = getRandomIntInclusive(1000, 9000);
            //     randalf = generate_string(permitted_chars, 4);
            //     sesion = randalf + rand;

            //     for (let index = 0; index < cart[item].quantity; index++) {
            //         itemPromocion += `
            //                 Integrante: ${ index+1 }
            //                 <div class="row rowPase border-bottom border-dark m-2 p-2">
            //                     <div class="col-sm-3 form-group mb-1">
            //                         <label class="form-label" for="ch-fn">Nombre<sup class="text-danger ml-1">*</sup></label>
            //                         <input class="form-control form-control-sm" type="text" name="fname" value="${ 'fname_'+sesion }" required="">
            //                     </div>
            //                     <div class="col-sm-3 form-group mb-1">
            //                         <label class="form-label" for="ch-fn">Apellidos<sup class="text-danger ml-1">*</sup></label>
            //                         <input class="form-control form-control-sm" type="text" name="lname" value="${ 'lname_'+sesion }" required="">
            //                     </div>
            //                     <div class="col-sm-3 form-group mb-1">
            //                         <label class="form-label" for="ch-fn">Pase<sup class="text-danger ml-1">*</sup></label>
            //                         <input class="form-control form-control-sm" type="text" name="nomPase" value="${ cart[item].nomPase }" required="" readonly >
            //                     </div>
            //                     <div class="col-sm-2 form-group">
            //                         <label class="form-label" for="ch-fn">ID<sup class="text-danger">*</sup></label>
            //                         <input class="form-control form-control-sm" type="text" name="idPase" value="${ sesion }" required="" readonly>
            //                     </div>
            //                     <input class="form-control form-control-sm" type="text" name="idform" value="${ cart[item].sku }" required="" hidden>
            //                 </div>
            //             `;


            //     }
            // }
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


$(document).on('click', '.btnaddPase', async function (e) {
    // console.log('entro')

    

    var idform = $(this).data('codigopase');
    var nomPase = $(this).data('nompase');
    var precioPase = $(this).data('preciopase');
    var divisaPase = $(this).data('divisapase');
    var tipoPase = $(this).data('tipopase');
    var tipo_competencia = $(this).data('tipopase_competencia');

    var itemParent = $(this).closest('div.itemCart');
    var prdqty = $(itemParent).find('input.product-qty').val();

    var competidores;

    
    $(this).closest('#tickets_view_event').find('.addinfocompetidores').each(function(){
        $(this).collapse('hide')
    })
    // console.log()   
    

    if(tipoPase==='competencia'){
        
        

        tag_evento=urlParams.get('tag_evento'); 
        
        await $.ajax({
            url: 'ajax/tablaCompetidores.php',            
            type: 'POST',
            dataType: "json",
        }).done(data => {
            competidores = data;
        })

        await $.ajax({
            url: 'ajax/getCategorias.php',            
            type: 'POST',
            data: {  
                tokenevento: tag_evento,
                tabla:tipo_competencia
            },
            dataType: "json",
        }).done(data => {
            categorias_competencia=data;
            
        })
        
        

        selectComboCompetidores=`
                <div class="col-lg-12">
                <div class="form-group">
                <label for="select_competidores">Competidor:</label> <span class="text-muted">*</span>
                <select class="custom-select select_competidores" name="select_competidores" id="select_competidores" required>
                    <option value="">Seleccione el competidor</option>`;
        competidores.forEach(element => {
            console.log(element)
            selectComboCompetidores+=`<option value="${element.id}">${element.fname} ${element.lname}</option>`
        })
        selectComboCompetidores+=`</select>                    
        </div>
        </div>
        `;

        selectallCombosCompetidores='';
        for (let index = 0; index < prdqty; index++) {            
            selectallCombosCompetidores+=selectComboCompetidores            
        }
        
        // if(tipo_competencia=='solistas'){
           
            
            

            

            selectComboCategorias=`<div class="col-lg-12">
                <div class="form-group">
                <label for="select_competidores">Categoría:</label> <span class="text-muted">*</span>
                <select class="custom-select select_categorias" name="categoria_p" required>
                    <option value="">Seleccionar categoría</option>`;
            categorias_competencia.forEach(element => {
                selectComboCategorias+=`<option value="${element.idCategoria}">${element.categoria_es}</option>`
            })
            selectComboCategorias+=`</select>                    
                </div>
                </div>
            `;
            
            buttonAgregarCategoria=`<div class="col-lg-12"><button class="btn-primary btn btnAgregarPaseCompetencia" 
                data-codigopase="${ idform }" 
                data-nompase="${ nomPase }"
                data-precioPase="${ precioPase }"
                data-divisapase="${ divisaPase }"
                data-tipopase="${ tipoPase }"
                data-tipopase_competencia="${ tipo_competencia }" 
                type="submit">Agregar al carrito</button></div>`;

            

            divCompetidores=`${selectallCombosCompetidores} ${selectComboCategorias} ${buttonAgregarCategoria}`;
            $(this).closest('.divPase').find('.addinfocompetidores').find('.row').html(divCompetidores);            
            $(this).closest('.divPase').find('.addinfocompetidores').collapse('show');
                        
            

        // }

    }else if(tipoPase==='acceso'){
        preloaderActive();
        shoppingCart.addItemToCart(idform, nomPase, precioPase, divisaPase, prdqty, tipoPase);

        setTimeout(function () {
            displayCart();
            preloaderRemove();
        }, 500)
    }

    


    


})

$(document).on('click', '.btnAgregarPaseCompetencia', function(){

    preloaderActive();

    categoriaPase = $(this).closest('.addinfocompetidores').find('.select_categorias option:selected').val();
    tipoPase = $(this).closest('.divPase').find('.btnaddPase').data('tipopase');
    idform=$(this).closest('.divPase').find('.btnaddPase').data('codigopase');
    tokenevento=tag_evento=urlParams.get('tag_evento'); 
    
    competidores = [];
    $(this).closest('.addinfocompetidores').find('.select_competidores option:selected').each(function(){
        
        
        const element = $(this).val();
        datosCompetidor = {};
        datosCompetidor.idCompetidor = element
        competidores.push(datosCompetidor)
    })

    infoRegistro = {
        categoriaPase,
        tipoPase,
        idform,
        tokenevento
    };


    registroCompetencia = {
        competidores,
        infoRegistro
    };
    console.log(registroCompetencia)


    shoppingCart.addItemToCartCompetidor(idform, tipoPase, registroCompetencia);

    $(this).closest('.addinfocompetidores').collapse('hide');
    
    

    setTimeout(function () {
        displayCart();
        preloaderRemove();
        
    }, 500)


    
    // for (let index = 0; index < inputsCompetidores.length; index++) {
    //     const element = inputsCompetidores[index].value;
    //     datosCompetidor = {};
    //     datosCompetidor.idCompetidor = element
    //     competidores.push(datosCompetidor)
    // }


})


$('.show-carrito').on("click", ".delete-item", function (event) {

    preloaderActive();
    var name = $(this).data('codpase');
    var tipoPase = $(this).data('tipopase');

   
    shoppingCart.removeItemFromCartAll(name, tipoPase);
    setTimeout(function () {
        displayCart();
        preloaderRemove();
    }, 500)
   

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

    tag_evento=urlParams.get('tag_evento');   
    await $.ajax({
        url: 'ajax/getDataEvento',
        type: 'POST',
        data: { tokenevento: tag_evento }
    }).done(({
        respuesta,
        data
    }) => {
        // console.log(data)
        
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

        console.log(cartArray)

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
                        switch (cartArray[i].tipo_competencia) {
                            case 'solistas':
                                nomCompetidores = `${ element.fname + ' ' + element.lname } - ${ element.idcompetidor }`
                                break;
                            case 'parejas':
                                if (index == 0) {
                                    nomCompetidores += `${ element.fname } ${ element.lname } y `
                                } else {
                                    nomCompetidores += `${ element.fname } ${ element.lname }`
                                }
                                break;
                            case 'grupos':
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
            //     default:
            //         output += `
            //             <div class="media align-items-center mb-3">
            //                 <div class="media-body pl-2 ml-1">
            //                     <div class="d-flex align-items-center justify-content-between">
            //                         <div class="mr-3">
                                    
            //                             <h4 class="nav-heading font-size-md mb-1"><a class="font-weight-medium" href="shop-single.html">${ cartArray[i].nomPase }</a></h4>
            //                             <div class="d-flex align-items-center font-size-sm"><span class="mr-2">${ precioPase }</span><span class="mr-2">x</span>
                                        
            //                             <span class="px-2" style="max-width: 3.5rem;">${ cartArray[i].quantity }</span>
            //                             </div>
            //                             <span class="font-size-xs mt-3">Subtotal: ${ numberFormat1.format(subTotalPase, options1) } </span>
            //                         </div>
            //                         <div class="pl-3 border-left">
            //                             <a class="d-block text-danger text-decoration-none font-size-xl delete-item" href="#" data-toggle="tooltip" title="Remove" data-codpase="${ cartArray[i].sku }" data-tipopase="${ cartArray[i].tipoPase }">
            //                                 <i class="fe-x-circle"></i>
            //                             </a>
            //                         </div>
            //                     </div>
            //                 </div>
            //             </div>`;
            //         break;
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



        console.log(registroCompetencia)

        // preloaderActive();
        // shoppingCart.addItemToCartCompetidor(idform, tipoPase, registroCompetencia);


        // setTimeout(function () {
        //     displayCart();
        //     preloaderRemove();
        // }, 500)

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


$('#addtickets_event').click(async function(){
    
    let carritoStorage=JSON.parse(localStorage.getItem("carritoelwsc"));
    // console.log(carritoStorage);

    if(carritoStorage){
        if(carritoStorage.length>0){
            shoppingCart.clearCart();
            displayCart();
        }
    }
    


    tag_evento=urlParams.get('tag_evento');   
    params_controller={
        'action':'get_tickets_evento',
        'variables': {
            'tag_evento':tag_evento
        }
    };

    let {data} = await getDataController('event_controller', 'proc_get_tickets_evento', params_controller);
    console.log(tag_evento)
    
    $('#btnmodal_checkout').attr('href', 'checkout?tag_evento='+tag_evento);

    await $.ajax({
        url: 'ajax/getDataEvento',
        type: 'POST',
        data: { tokenevento: tag_evento }
    }).done(({
        respuesta,
        data
    }) => {
        imagen_evento='data:image/png;base64,'+data.imageMail;
        nombre_evento=data.nombre;
        lugar_evento=data.lugar_evento;
        sede_evento=data.sede;
        fechas_evento=data.fecha_completa;

        $('.img_evento_modal').attr('src',imagen_evento);
        $('.nombre_evento_modal').html(nombre_evento);
        $('.sede_evento_modal').html(sede_evento);
        $('.lugar_evento_modal').html(lugar_evento);
        $('.fechas_evento_modal').html(fechas_evento);

    })



    $('#tickets_view_event').empty();
    data.forEach(element => {
        console.log(element)
        
        texto_addcarrito=element.tipo_pase=='acceso'? 'Agregar al carrito' : 'Seleccionar';
        
        divPase=`<div class="col-lg-12 pb-4">
        <div class="bg-light box-shadow-lg rounded-lg divPase">
            <div class="pt-3 px-3 itemCart">
                <div class="d-md-flex align-items-start border-bottom py-2 py-sm-2">
                <div class="ml-4 ml-sm-0 py-2 w-100" style="max-width: 25rem;">
                    <h5 class="mb-2">${ element.descripcion_pase }</h3>
                    <div class="font-size-xs" style="max-width: 10rem;">${ element.tag }</div>
                </div>
                <div class="d-flex w-100 align-items-end py-3 py-sm-2 px-4" style="max-width: 25rem;">
                    <span class="h5 font-weight-normal text-muted mb-1 mr-2">$</span>
                    <span class="h5 font-weight-normal text-primary mb-1 mr-2" data-current-price="0" data-new-price="0">${ element.precio }</span>
                    <span class="h5 font-weight-normal text-muted mb-1 mr-2">${ element.divisa }</span>
                </div>
                
                <div class="d-flex w-100 align-items-end py-3 py-sm-2 px-4" style="max-width: 15rem;">                              
                    <input class="form-control text-center product-qty mb-2" type="number" value="${ element.minPases }" min="${ element.minPases }" max="${ element.maxPases }" >
                </div>
                <div class="d-flex w-100 align-items-end py-1 py-sm-2 px-3" style="max-width: 13rem;">
                    
                    <button class="btn btn-primary btn-sm btn-block btnaddPase" type="button" 
                        data-codigopase="${ element.codigo_pase }" 
                        data-nompase="${ element.descripcion_pase }"
                        data-precioPase="${ element.precio }"
                        data-divisapase="${ element.divisa }"
                        data-tipopase="${ element.tipo_pase }"
                        data-tipopase_competencia="${ element.tipo_competencia }"                        
                    >
                        ${texto_addcarrito}
                    </button>
                </div>
                
                </div>
            </div>
            <div class="p-3 collapse addinfocompetidores" >
                <div class="row">
                </div>
            </div>
        </div>
       
      </div>`;
      $('#tickets_view_event').append(divPase);
        
    });    
    

    $('#modal_tickets_event').modal('show');
})


async function getDataController(name_controller, name_stored_procedure, params_controller){

    let data_controller;
    await $.ajax({
        url:'controllers/'+name_controller,
        data: { name_stored_procedure, params_controller },
        type: 'POST'
    }).done(datacontroller => {
        data_controller = datacontroller;
    })

    return data_controller;
}

async function getDataFormController(name_controller, name_stored_procedure, params_controller){

    let data_controller;
    await $.ajax({
        url:'controllers/'+name_controller,
        data: params_controller,
        type: 'POST',
        processData: false,
        contentType: false,
    }).done(datacontroller => {
        data_controller = datacontroller;
    })

    return data_controller;
}