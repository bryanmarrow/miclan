        var getUrl = window.location;
        var queryString = window.location.search;
        var urlParams = new URLSearchParams(queryString);

        var preloader = document.querySelector('.cs-page-loading');


        var CURRENT_URL = location.href;
        var result = CURRENT_URL.split('/');
        var urlAjax = getUrl.origin + '/' + result[3];
        // const couponcode = document.querySelector(".couponcode").textContent;



        function randomString(length, chars) {
            var result = '';
            for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
            return result;
        }
        var rString = randomString(8, '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        $('#formcupon').submit(function (e) {
            e.preventDefault();

            // const formData = new FormData(this);
            // formData.append('idform', $(this).data('form'))

            const idform = $(this).data('form');
            const codigo_cupon = $('#formcupon .codigo_cupon').val()

            var tipoForm = $('#formTickets').data('tipoform');

            if (this.checkValidity() === false) {
                return this.classList.add('was-validated');
            }
            preloader.classList.add('active');

            validarCupon(codigo_cupon, idform, tipoForm)

        })


        $('.hotel_num').change(function (e) {

            const idform = $('#formcupon').data('form');
            const codigo_cupon = $(this).val();
            const tipoForm = $('#formTickets').data('tipoform');

            if (codigo_cupon.length == 6) {
                validarCupon(codigo_cupon, idform, tipoForm)
            } else {
                const codigo_cupon = 0;
                validarCupon(codigo_cupon, idform, tipoForm)
            }


        })

        function validarCupon(codigo_cupon, idform, tipoForm) {

            $.ajax({
                url: urlAjax + '/functions/validarCupon.php',
                type: 'POST',
                data: {
                    codigo_cupon,
                    idform
                },
                success: function ({
                    respuesta,
                    cupon,
                    mensaje
                }) {

                    switch (idform) {
                        case 'ELWSC2023INSCGRU':
                            numPases = $("#numintegrantes option:selected").val();
                            break;

                        default:
                            numPases = 1;
                            break;
                    }

                    switch (respuesta) {
                        case 1:
                            getPreciosPase(tipoForm, cupon, idform, '', numPases);
                            var texto = "Cupón aplicado";
                            document.querySelector('.alertacupon').textContent = texto
                            setTimeout(function () {
                                $('#modal-coupon').modal('hide');
                                document.querySelector('.alertacupon').textContent = ""
                            }, 1000);
                            $('.hotel_num').val(cupon)
                            break;
                        case 0:
                            getPreciosPase(tipoForm, cupon, idform, '', numPases);
                            preloader.classList.remove('active');
                            $('#formcupon').trigger("reset");
                            var texto = "Cupón no disponible";
                            document.querySelector('.alertacupon').textContent = texto
                            setTimeout(function () {
                                document.querySelector('.alertacupon').textContent = ""
                            }, 3000);
                            document.querySelector(".coupontab").classList.add('d-none')
                            document.querySelector(".coupontab").classList.remove('d-flex')

                            break;
                        case 'error':
                            preloader.classList.remove('active');
                            var texto = "Ocurrió un error, favor de intentarlo más tarde.";
                            console.log(mensaje)
                            document.querySelector('.alertacupon').textContent = texto
                            break;
                    }

                }
            })
        }

        $('#numintegrantes').change(function (e) {
            numIntegrantes = $(this).val();
            columnaIntegrante = ``
            for (i = 0; i < numIntegrantes; i++) {
                columnaIntegrante += `<div class="col-md-3 col-sm-12">
                    <div class="form-group"><label class="form-label">Nombre completo del integrante:</label><input type="text"
                            name="idnumintegrantes${i}" class="form-control" required=""></div>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="form-group"><label class="form-label">Fecha de nacimiento:</label><span
                            class="text-muted">*</span><input type="date" name="date_birthday${i}" class="form-control" required="">
                        <div class="invalid-feedback">Campo requerido</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="form-group">
                        <fieldset class="form-group m-2"><label class="form-label">Género:</label>
                            <div class="form-check">
                                <div class="form-check form-check-inline"><input type="radio" name="generoint${i}" id="masculino${i}"
                                        value="Masculino" class="form-check-input" required=""><label class="form-label"
                                        for="masculino${i}">Masculino</label></div>
                                <div class="form-check form-check-inline"><input type="radio" name="generoint${i}" id="femenino${i}"
                                        value="Femenino" class="form-check-input" required=""><label class="form-label"
                                        for="femenino${i}">Femenino</label></div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="form-group"><label class="form-label">Código de confirmación de Dancer Pass</label><input
                            type="text" name="codfullpass${i}" class="form-control" required=""></div>
                </div>`
            }
            tipoForm = $('#formTickets').data('tipoform');
            skuPase = $('#formTickets').data('form');
            valor_cupon = '';
            getPreciosPase(tipoForm, valor_cupon, skuPase, idApartado, numIntegrantes)

            $('#integrantesgrupo').html(columnaIntegrante);

        })




        $(document).on('click', '#btncodigo', function (e) {

            let codigoConf = document.querySelector(".codigoconf").value;

            if (codigoConf.length > 4) {
                $.ajax({
                    type: 'POST',
                    url: urlAjax + '/functions/validarOrden.php',
                    data: {
                        codigoConf
                    },
                    beforeSend: function () {
                        preloader.classList.add('active');
                    }
                }).done(datos => {

                    preloader.classList.remove('active');

                    if (datos.respuesta > 0) {

                        const dataCompra = datos.dataCompra


                        let nombrecompleto = dataCompra.nombre + ' ' + dataCompra.apellidos;
                        $('#nombreTitular').html(nombrecompleto)
                        $('#email_p').html(dataCompra.email);
                        $('#statusOrdenCompra').html(dataCompra.tagHtml);
                        $('invoiceid').html(dataCompra.invoiceid);

                        var tableIntegrantes = `<table class="table table-striped table-hover table-sm" style="width:100;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Pase</th>
                                </tr>
                            </thead>
                        <tbody>`;
                        datos.integrantes.forEach(element => {
                            tableIntegrantes += `<tr><td>${ element.fname }</td>`
                            tableIntegrantes += `<td>${ element.lname }</td>`
                            tableIntegrantes += `<td>${ element.descripcion_pase }</td></tr>`

                            skuPase = element.codigo_pase;
                        });
                        tableIntegrantes += `</tbody></table>`;

                        if (dataCompra['status'] !== 3) {
                            getPreciosPase('liquidar', '', skuPase, 0)
                            $('.btnLiquidarOrden').attr('disabled', false)
                        }

                        $('#integrantes_apartado').html(tableIntegrantes);
                        $('datePago').html(dataCompra.fechaRegistro);


                        $('#order-1').removeClass('d-none');
                        $('#order-1').collapse('show')
                        $('#modal-coupon').modal('hide')



                    } else {
                        alert(datos.mensaje);
                    }
                })
            } else {
                alert('Ingrese un código de confirmación')
            }
        })

        $('.btnpago').click(async function (evento) {
            event.preventDefault();

            var tagEvento = $(this).data('tagevento'),
                idForm = $(this).data('idpase'),
                nombreTicket = 'Orden de pago ' + $(this).data('nombreticket'),
                sku = $(this).data('sku'),
                divisaPase = $(this).data('divisaPase'),
                status_apartado = $(this).data('status_apartado'),
                tipoForm = $(this).data('tipoform'),
                form = document.querySelector('#formTickets'),
                cupon = document.querySelector('.couponcode');



            integrantes = []
            $('#formTickets').find('div.integrante').each(function (index, element) {

                integrantePase = []
                $(this).find('input:text').each(function (index, element) {
                    integrantePase.push($(element).val())
                })
                $(this).find('input[type="email"]').each(function (index, element) {
                    integrantePase.push($(element).val())
                })
                $(this).find('select option').filter(':selected').each(function (index, element) {
                    integrantePase.push($(element).val())
                    integrantePase.push($(element).text())
                })
                $(this).find('input[type="number"]').each(function (index, element) {
                    integrantePase.push($(element).val())
                })
                $(this).find('input:radio:checked').each(function (index, element) {
                    integrantePase.push($(element).val())
                })
                integrantes.push(integrantePase)
            })

            const datosPase = {
                idform: idForm,
                sku: sku,
                status_apartado: status_apartado,
                integrantes: JSON.stringify(integrantes)
            }


            if (form.checkValidity() === false) {
                form.classList.add('was-validated');
                console.log('Incompleto');

            } else {

                if (tipoForm === 0) {

                    const hotelnum = document.querySelector(".hotel_num").value;
                    // const codFullPass = document.querySelector(".codFullPass").value;

                    let formData = new FormData(form);
                    formData.append('cupon', hotelnum)
                    formData.append('idform', 'cuponcompetidores')
                    formData.append('form', document.querySelector(".tipoform").value)
                    formData.append('datosPase', JSON.stringify(datosPase));
                    formData.append('cupon', cupon)

                    var dataOrden = await crearOrdenInscripcion(formData, datosPase, cupon);


                    // for (let [name, value] of formData) {
                    //     console.log(`${name} = ${value}`);
                    // }

                    switch (dataOrden['respuesta']) {
                        case 'success':

                            document.querySelector('.collapsed').setAttribute("data-toggle", "collapse;");
                            document.querySelector('.collapsed').setAttribute("data-target", "#paypalinfo");
                            document.querySelector('.collapsed').disabled = true;
                            document.getElementById("paypalinfo").classList.add("show");

                            let datosPase = dataOrden['datosPase'],
                                invoiceid = dataOrden['invoiceid'],
                                nombreTicket = datosPase['nombreticket'],
                                tipo_item_amt = datosPase['subtotal'],
                                tipo_tax_amt = datosPase['comisionPase'],
                                tipo_total_amt = datosPase['precioTotal'],
                                sku = datosPase['sku'];

                            let infoPase = {
                                'invoiceid': invoiceid,
                                'nombreTicket': nombreTicket,
                                'tipo_item_amt': tipo_item_amt,
                                'tipo_tax_amt': tipo_tax_amt,
                                'tipo_total_amt': tipo_total_amt,
                                'sku': sku,
                                'divisaPase': datosPase['divisaPase'],
                            };

                            await realizarPagoPaypalInscripcion(infoPase)

                            break;
                        case 'error':
                            alert('No se creo la orden de pago');
                            break;
                    }



                } else if (tipoForm === 1) {




                    const formData = new FormData(form);
                    formData.append('datosPase', JSON.stringify(datosPase));
                    formData.append('cupon', cupon)

                    var dataOrden = await crearOrden(formData, datosPase, cupon);

                    // console.log(dataOrden);

                    switch (dataOrden['respuesta']) {
                        case 'success':

                            // btnpago.disabled = true;
                            // $('.btnpago').prop('disabled', true)
                            document.querySelector('.collapsed').setAttribute("data-toggle", "collapse;");
                            document.querySelector('.collapsed').setAttribute("data-target", "#paypalinfo");
                            document.querySelector('.collapsed').disabled = true;
                            document.getElementById("paypalinfo").classList.add("show");

                            let datosPase = dataOrden['datosPase'],
                                invoiceid = dataOrden['invoiceid'],
                                nombreTicket = datosPase['nombreticket'],
                                tipo_item_amt = datosPase['subtotalOrden'],
                                tipo_tax_amt = datosPase['comisionPase'],
                                tipo_total_amt = datosPase['precioTotal'],
                                sku = datosPase['sku'];

                            let infoPase = {
                                'invoiceid': invoiceid,
                                'nombreTicket': nombreTicket,
                                'tipo_item_amt': tipo_item_amt,
                                'tipo_tax_amt': tipo_tax_amt,
                                'tipo_total_amt': tipo_total_amt,
                                'sku': sku,
                                'divisaPase': datosPase['divisaPase'],
                            };

                            await realizarPagoPaypal(infoPase)





                            break;
                        case 'error':
                            alert('No se creo la orden de pago');
                            break;
                    }
                    var invoiceid = dataOrden.invoiceid;


                }



            }
        })

        $('.btnLiquidarOrden').click(async function (evento) {
            event.preventDefault();

            var tagEvento = $(this).data('tagevento'),
                idForm = $(this).data('idpase'),
                nombreTicket = 'Orden de pago ' + $(this).data('nombreticket'),
                sku = $(this).data('sku'),
                divisaPase = $(this).data('divisaPase'),
                status_apartado = $(this).data('status_apartado'),
                tipoForm = $(this).data('tipoform');



            integrantes = []
            $('#formLiquidarOrden').find('div.integrante').each(function (index, element) {

                integrantePase = []
                $(this).find('input:text').each(function (index, element) {
                    integrantePase.push($(element).val())
                })
                $(this).find('input[type="email"]').each(function (index, element) {
                    integrantePase.push($(element).val())
                })
                $(this).find('select option').filter(':selected').each(function (index, element) {
                    integrantePase.push($(element).val())
                    integrantePase.push($(element).text())
                })
                $(this).find('input[type="number"]').each(function (index, element) {
                    integrantePase.push($(element).val())
                })
                $(this).find('input:radio:checked').each(function (index, element) {
                    integrantePase.push($(element).val())
                })
                integrantes.push(integrantePase)
            })

            const datosPase = {
                idform: idForm,
                sku: sku,
                status_apartado: status_apartado,
                integrantes: JSON.stringify(integrantes)
            }



            const cupon = document.querySelector(".couponcode").textContent;

            formLiquidarOrden = document.getElementById('formLiquidarOrden');
            if (formLiquidarOrden.checkValidity() === false) {
                formLiquidarOrden.classList.add('was-validated');
                // console.log('Incompleto');

            } else {

                $('.btncodigo').attr('disabled', true)

                $('#paypalCheckoutContainer').html('');

                document.querySelector('.collapsed').setAttribute("data-toggle", "collapse;");
                document.querySelector('.collapsed').setAttribute("data-target", "#paypalinfo");
                document.querySelector('.collapsed').disabled = true;
                document.getElementById("paypalinfo").classList.add("show");

                formData = new FormData(formLiquidarOrden)

                var dataOrden = await ordenLiquidacion(formData);

            }
        })



        $(document).ready(function (event) {

            //     if (form) {
            //         $(form).find('div.integrante').each(function (index, element) {
            //             // console.log(index + ': ' + element)
            //             // integrantePase = {}
            //             $(this).find('input').each(function (index, element) {
            //                 // console.log(index + ': ' + $(element).val())
            //                 // console.log($(element).val())
            //                 nameAttr = $(element).attr('name');
            //                 // integrantePase[nameAttr] = $(element).val();
            //                 if (nameAttr == 'email_p') {
            //                     $(element).val('bryanmzrom@gmail.com')
            //                 } else if (nameAttr == 'pnumber_p') {
            //                     $(element).val('2223637840')
            //                 } else if (nameAttr == 'nombre_p' || nameAttr == 'apellidos_p') {
            //                     $(element).val('integrante_' + nameAttr)
            //                 }
            //             })
            //             $(this).find('select option:eq(151)').prop('selected', true)
            //         })

            //         $('#ch-order-notes').val('Notas de orden de pago de los comentarios')

            //         $(form).find('div.row').each(function (index, element) {
            //             // console.log(index + ': ' + element)
            //             // integrantePase = {}
            //             $(this).find('input').each(function (index, element) {
            //                 // console.log(index + ': ' + $(element).val())
            //                 // console.log($(element).val())
            //                 nameAttr = $(element).attr('name');
            //                 // console.log(nameAttr)
            //                 // integrantePase[nameAttr] = $(element).val();
            //                 if (nameAttr == 'email_p') {
            //                     $(element).val('bryanmzrom@gmail.com')
            //                 } else if (nameAttr == 'pnumber_p') {
            //                     $(element).val('2223637840')
            //                 } else if (nameAttr == 'nombre_p' || nameAttr == 'apellidos_p') {
            //                     $(element).val('integrante_' + nameAttr)
            //                 } else if (nameAttr == 'hotel_num') {
            //                     // $(element).val('141991');
            //                 } else if (nameAttr == 'codFullPass') {
            //                     $(element).val('ESAOPDAS3234234');
            //                 }
            //             })
            //             $(this).find('select option:eq(151)').prop('selected', true)
            //         })

            //         $(form).find('div.row').each(function (index, element) {
            //             // console.log(index + ': ' + element)
            //             // integrantePase = {}
            //             $(this).find('input').each(function (index, element) {
            //                 // console.log(index + ': ' + $(element).val())
            //                 // console.log($(element).val())
            //                 nameAttr = $(element).attr('name');
            //                 typeAttr = $(element).attr('type');
            //                 // console.log(nameAttr + ' - ' + typeAttr)

            //                 if (typeAttr == 'text' || typeAttr == 'date' || typeAttr == 'email') {

            //                     if (nameAttr.includes("nombre_p") || nameAttr.includes("apellidos_p")) {
            //                         $(element).val('integrante_' + nameAttr)
            //                     } else if (nameAttr.includes("email_p")) {
            //                         $(element).val('bryanmzrom@gmail.com')
            //                     } else if (nameAttr.includes("pnumber_p")) {
            //                         $(element).val('2223637840')
            //                     } else if (nameAttr.includes("hotel_num")) {
            //                         // $(element).val('141991');
            //                     } else if (nameAttr.includes("codFullPass")) {
            //                         $(element).val('ESAOPDAS3234234');
            //                     } else if (nameAttr.includes("date_birthday")) {
            //                         $(element).val('1992-05-13');
            //                     }
            //                 }


            //             })
            //             // $(this).find('select[name="categoria_p"] option:eq(68)').prop('selected', true)
            //             // $("[name='categoria_p']").find('select option:eq(151)').prop('selected', true)
            //         })

            //         $('#ch-order-notes').val('Notas de orden de pago de los comentarios')
            //     }


            //     const {
            //         host,
            //         hostname,
            //         href,
            //         origin,
            //         pathname,
            //         port,
            //         protocol,
            //         search
            //     } = window.location

            //     console.log(host)
            //     console.log(hostname)
            //     console.log(href)
            //     console.log(origin)
            //     console.log(pathname)
            //     console.log(port)
            //     console.log(protocol)
            //     console.log(search)            



        })

        if (document.querySelector('#formTickets')) {

            preloader.classList.add('active');
            const tipoForm = $('#formTickets').data('tipoform');

            const valor_cupon = $('.cupon').val();
            // const valor_cupon = '156164';

            $(window).on("load", async function () {
                switch (tipoForm) {
                    case 'acceso':
                        skuPase = urlParams.get('sku')
                        idApartado = urlParams.get('apartado');
                        // urlFunctionsPrecios = 'functions/getPrecio.php';
                        break;
                    case 'competition':
                        skuPase = $('.tipoform').val();
                        idApartado = '';
                        // urlFunctionsPrecios = '../functions/getPrecio.php';
                        break;
                }
                const dataPrecioPase = await getPreciosPase(tipoForm, valor_cupon, skuPase, idApartado, 1);
            })

        }

        async function getPreciosPase(tipoForm, valor_cupon, skuPase, idApartado, numIntegrantes) {
            var dataPrecioPase;



            await $.ajax({
                url: urlAjax + '/functions/getPrecio.php',
                type: 'POST',
                data: {
                    skuPase,
                    idApartado,
                    valor_cupon,
                    tipoForm,
                    numIntegrantes
                },
                success: function (data) {
                    dataPrecioPase = data
                }
            })

            let precioPase = dataPrecioPase['precioPase'],
                precioTotalOrden = dataPrecioPase['precioTotal'],
                comisionOrden = dataPrecioPase['comisionPase'],
                subtotalOrden = dataPrecioPase['subtotalOrden'],
                descuentoOrden = dataPrecioPase['descuento']
            nombreCupon = dataPrecioPase['cupon'];

            if ($('#formTickets')) {
                $('.total').html(precioTotalOrden.toFixed(2))
                $('.tax').html(comisionOrden.toFixed(2))
                $('.subtotal').html(precioPase.toFixed(2))
                $('.discount').html(descuentoOrden.toFixed(2))

                if (descuentoOrden > 0) {


                    document.querySelector(".coupontab").classList.remove('d-none')
                    document.querySelector(".coupontab").classList.add('d-flex')

                    $('.couponcode').html(nombreCupon.toUpperCase());
                    $('.couponcode').val(nombreCupon.toUpperCase());
                }
            }

            preloader.classList.remove('active');
            // return dataPreciosPase;
        }

        function enviarregistro(datos) {
            // document.getElementById("paypalinfo").classList.remove("show");


            let form = document.querySelector(".needs-validation");
            let pago = datos.purchase_units[0];


            const formData = new FormData(form);
            formData.append('invoiceid', pago.invoice_id)
            formData.append('reciboid', pago.payments.captures[0].id)
            formData.append('subtotalPago', pago.items[0].unit_amount.value)

            for (let [name, value] of formData) {
                console.log(`${name} = ${value}`);
            }

            $.ajax({
                type: 'POST',
                url: 'functions/addform.php',
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                beforeSend: function () {
                    preloader.classList.add('active');
                }
            }).done(({
                respuesta
            }) => {

                switch (respuesta) {
                    case 'success':
                        preloader.classList.remove('active');
                        document.querySelector('.alertaexitoso').textContent = 'Pago exitoso';
                        $('.sucessregistro').modal('show')
                        // $('.sucessregistro').on('show.bs.modal', interval())
                        break;
                }


            })

        }

        async function crearOrden(datosOrden) {

            await $.ajax({
                url: urlfunctions + 'addOrder.php',
                type: 'POST',
                data: datosOrden,
                processData: false,
                contentType: false,
                success: function (data) {
                    dataOrden = data;
                }
            })

            return dataOrden;
        }

        async function crearOrdenInscripcion(datosOrden) {

            await $.ajax({
                url: '../functions/addInscripcion.php',
                type: 'POST',
                data: datosOrden,
                processData: false,
                contentType: false,
                success: function (data) {
                    // console.log(data)
                    dataOrden = data;
                }
            })

            return dataOrden;
        }

        async function ordenLiquidacion(datosOrden) {

            await $.ajax({
                url: 'functions/getOrdenLiquidacion.php',
                type: 'POST',
                data: datosOrden,
                processData: false,
                contentType: false,
                success: function (data) {
                    // console.log(data)
                    dataOrden = data

                    paypal.Buttons({

                        style: {
                            layout: 'vertical', // horizontal | vertical
                            size: 'large', // medium | large | responsive
                            shape: 'pill', // pill | rect
                            color: 'gold', // gold | blue | silver | black
                            label: 'pay',
                            fundingicons: 'true'
                        },

                        // Execute payment on authorize
                        commit: true,


                        createOrder: function (data, actions) {

                            nombreTicket = 'Liquidación ' + dataOrden.nombreticket;
                            return actions.order.create({
                                purchase_units: [{
                                    reference_id: 'P-1',
                                    description: nombreTicket,
                                    invoice_id: dataOrden.invoiceid,
                                    custom_id: 'CUST_VSDC',
                                    amount: {
                                        currency_code: dataOrden.divisaPase,
                                        value: dataOrden.precioTotal.toFixed(2),
                                        breakdown: {
                                            item_total: {
                                                currency_code: dataOrden.divisaPase,
                                                value: dataOrden.precioPase.toFixed(2)
                                            },
                                            shipping: {
                                                currency_code: dataOrden.divisaPase,
                                                value: '0.00'
                                            },
                                            tax_total: {
                                                currency_code: dataOrden.divisaPase,
                                                value: dataOrden.comisionPase.toFixed(2)
                                            },
                                            handling: {
                                                currency_code: dataOrden.divisaPase,
                                                value: '0.00'
                                            },
                                            shipping_discount: {
                                                currency_code: dataOrden.divisaPase,
                                                value: '0.00'
                                            },
                                            insurance: {
                                                currency_code: dataOrden.divisaPase,
                                                value: '0.00'
                                            }
                                        }
                                    },
                                    items: [{
                                        name: nombreTicket,
                                        sku: dataOrden.sku,
                                        unit_amount: {
                                            currency_code: dataOrden.divisaPase,
                                            value: dataOrden.precioPase.toFixed(2)
                                        },
                                        quantity: '1',
                                        category: 'PHYSICAL_GOODS'
                                    }]

                                }]
                            });



                        },


                        onApprove: function (data, actions) {
                            preloader.classList.add('active');
                            document.querySelector('#textoload').textContent = 'Procesando pago...';
                            return actions.order.capture().then(function (details) {

                                console.log(details)

                                formLiquidarOrden = document.getElementById('formLiquidarOrden');

                                const formData = new FormData(formLiquidarOrden);
                                // formData.append('invoiceid', details.purchase_units[0].invoice_id);
                                formData.append('email', details.payer.email_address)
                                formData.append('fname', details.payer.name.given_name)
                                formData.append('lname', details.payer.name.surname)
                                formData.append('reciboid', details.purchase_units[0].payments.captures[0].id)
                                formData.append('fechapago', details.create_time)
                                formData.append('country', details.payer.address.country_code)
                                formData.append('tipoform', 'liquidar')
                                // formData.append('totalPago', details.purchase_units[0].amount.value)
                                // formData.append('subTotalPago', details.purchase_units[0].amount.breakdown.item_total.value)
                                // formData.append('comisionPago', details.purchase_units[0].amount.breakdown.tax_total.value)

                                for (let [name, value] of formData) {
                                    console.log(`${name} = ${value}`);
                                }

                                $.ajax({
                                    type: 'POST',
                                    url: urlfunctions + 'addPay.php',
                                    data: formData,
                                    processData: false, // tell jQuery not to process the data
                                    contentType: false, // tell jQuery not to set contentType
                                    success: function (response) {

                                        enviarRegistroLiquidacion(details)
                                    }

                                })



                            });
                        }
                    }).render('#paypalCheckoutContainer');
                }
            })

            return dataOrden;
        }

        function enviarregistrov2(datos, datosPase) {

            // console.log(datos)
            // console.log(datosPase)

            let form = document.querySelector("#formTickets");

            let pago = datos.purchase_units[0];

            document.querySelector('#textoload').textContent = 'Enviando orden de pago...';

            const formData = new FormData(form);
            formData.append('invoiceid', pago.invoice_id)
            // formData.append('reciboid', datos.id)
            formData.append('reciboid', pago.payments.captures[0].id)
            formData.append('subtotalPago', pago.items[0].unit_amount.value)
            formData.append('idform', datosPase.idform)
            formData.append('sku', datosPase.sku)
            formData.append('status_apartado', datosPase.status_apartado)
            formData.append('integrantes', datosPase.integrantes)

            for (let [name, value] of formData) {
                console.log(`${name} = ${value}`);
            }

            $.ajax({
                type: 'POST',
                url: urlfunctions + 'addOrden.php',
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                beforeSend: function () {
                    // preloader.classList.add('active');
                }
            }).done(function ({
                respuesta
            }) {
                switch (respuesta) {
                    case 'success':

                        document.querySelector('.alertaexitoso').textContent = 'Pago exitoso';
                        $('.sucessregistro').modal('show')
                        $('.sucessregistro').on('show.bs.modal', interval())
                        preloader.classList.remove('active');
                        break;
                }
            })

        }

        function enviarregistroInscripcion(datos, datosPago) {

            // console.log(datos)
            // console.log(datosPago)

            let form = document.querySelector("#formTickets");

            let pago = datos.purchase_units[0];

            document.querySelector('#textoload').textContent = 'Enviando orden de pago...';

            const formData = new FormData(form);
            formData.append('invoiceid', pago.invoice_id)
            // formData.append('reciboid', datos.id)
            formData.append('reciboid', datos.id)
            formData.append('subtotalPago', pago.items[0].unit_amount.value)
            formData.append('sku', datosPago.sku)

            for (let [name, value] of formData) {
                console.log(`${name} = ${value}`);
            }

            $.ajax({
                type: 'POST',
                url: '../functions/addCompetencia.php',
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                beforeSend: function () {
                    // preloader.classList.add('active');
                }
            }).done(function ({
                respuesta
            }) {
                // console.log(respuesta)
                switch (respuesta) {
                    case 'success':
                        document.querySelector('.alertaexitoso').textContent = 'Pago exitoso';
                        $('.sucessregistro').modal('show')
                        $('.sucessregistro').on('show.bs.modal', interval())
                        preloader.classList.remove('active');
                        break;
                }
            })

        }

        function enviarRegistroLiquidacion(datos) {

            let formLiquidarOrden = document.getElementById('formLiquidarOrden');
            const formData = new FormData(formLiquidarOrden);

            console.log(datos)

            $.ajax({
                type: 'POST',
                url: urlfunctions + 'enviarLiquidacion.php',
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                beforeSend: function () {
                    // preloader.classList.add('active');
                }
            }).done(function ({
                respuesta
            }) {
                switch (respuesta) {
                    case 'success':

                        document.querySelector('.alertaexitoso').textContent = 'Pago exitoso';
                        $('.sucessregistro').modal('show')
                        $('.sucessregistro').on('show.bs.modal', interval())
                        preloader.classList.remove('active');
                        break;
                }
            })

        }

        function realizarPagoPaypal(datosPago) {



            let nombreTicket = 'Orden de pago ' + datosPago.nombreTicket,
                tipo_item_amt = datosPago.tipo_item_amt,
                tipo_tax_amt = datosPago.tipo_tax_amt,
                tipo_total_amt = datosPago.tipo_total_amt,
                sku = datosPago.sku,
                invoiceid = datosPago.invoiceid,
                divisaOrden = datosPago.divisaPase,
                idForm = $('.btnpago').data('idpase'),
                status_apartado = $('.btnpago').data('status_apartado'),
                form = document.querySelector(".needs-validation"),
                inputcoupon = document.querySelector('.couponcode');


            integrantes = []
            $(form).find('div.integrante').each(function (index, element) {
                // console.log(index + ': ' + element)
                integrantePase = []
                $(this).find('input').each(function (index, element) {
                    // console.log(index + ': ' + $(element))
                    // console.log($(element).val())
                    nameAttr = $(element).attr('name');
                    integrantePase[index] = $(element).val();
                    if (index === 0 && nameAttr == 'email_p') {
                        integrantePase[index] = $(element).val();
                    }
                })

                if (index === 0) {
                    integrantePase[3] = $(this).find('select option').filter(':selected').val();
                    integrantePase[4] = $(this).find('select option').filter(':selected').text();
                }
                integrantes.push(integrantePase)
            })

            // console.log(integrantes)


            const datosPase = {
                idform: idForm,
                sku: sku,
                status_apartado: status_apartado,
                integrantes: JSON.stringify(integrantes)
            }


            var options = {

                style: {
                    layout: 'vertical', // horizontal | vertical
                    size: 'large', // medium | large | responsive
                    shape: 'pill', // pill | rect
                    color: 'gold', // gold | blue | silver | black
                    label: 'pay',
                    fundingicons: 'true'
                },

                // Execute payment on authorize
                commit: true,

                // Set up the transaction
                createOrder: function (data, actions) {

                    return actions.order.create({
                        purchase_units: [{
                            reference_id: 'P-1',
                            description: nombreTicket,
                            invoice_id: invoiceid,
                            custom_id: 'CUST_VSDC',
                            amount: {
                                currency_code: divisaOrden,
                                value: tipo_total_amt.toFixed(2),
                                breakdown: {
                                    item_total: {
                                        currency_code: divisaOrden,
                                        value: tipo_item_amt.toFixed(2)
                                    },
                                    shipping: {
                                        currency_code: divisaOrden,
                                        value: '0.00'
                                    },
                                    tax_total: {
                                        currency_code: divisaOrden,
                                        value: tipo_tax_amt.toFixed(2)
                                    },
                                    handling: {
                                        currency_code: divisaOrden,
                                        value: '0.00'
                                    },
                                    shipping_discount: {
                                        currency_code: divisaOrden,
                                        value: '0.00'
                                    },
                                    insurance: {
                                        currency_code: divisaOrden,
                                        value: '0.00'
                                    }
                                }
                            },
                            items: [{
                                name: nombreTicket,
                                sku: sku,
                                unit_amount: {
                                    currency_code: divisaOrden,
                                    value: tipo_item_amt.toFixed(2)
                                },
                                quantity: '1',
                                category: 'PHYSICAL_GOODS'
                            }]

                        }]
                    });

                },

                // Finalize the transaction
                onApprove: function (data, actions) {


                    console.log(data)
                    console.log(actions)

                    preloader.classList.add('active');
                    document.querySelector('#textoload').textContent = 'Procesando pago...';


                    return actions.order.capture().then(function (details) {

                        let status_apartado = $('.btnpago').data('status_apartado')

                        const formData = new FormData(form);
                        formData.append('invoiceid', details.purchase_units[0].invoice_id);
                        formData.append('email', details.payer.email_address)
                        formData.append('fname', details.payer.name.given_name)
                        formData.append('lname', details.payer.name.surname)
                        // formData.append('datebirth', document.querySelector(".fecha_nac").value)
                        formData.append('reciboid', details.id)
                        formData.append('fechapago', details.create_time)
                        formData.append('couponcode', inputcoupon.value)
                        formData.append('country', details.payer.address.country_code)
                        formData.append('status_apartado', status_apartado)

                        for (let [name, value] of formData) {
                            console.log(`${name} = ${value}`);
                        }

                        $.ajax({
                            type: 'POST',
                            url: urlfunctions + 'addpay.php',
                            data: formData,
                            processData: false, // tell jQuery not to process the data
                            contentType: false, // tell jQuery not to set contentType
                        }).done(function ({
                            respuesta
                        }) {

                            switch (respuesta) {
                                case 'success':
                                    enviarregistrov2(details, datosPase);
                                    // console.log(details)
                                    break;

                            }
                        })



                    });
                },


                onCancel: function (data, actions) {

                    console.log(data)
                    console.log(actions)

                },

                onError: function (data, actions) {

                    console.log(data)
                    console.log(actions)

                }
            }


            $('#paypalCheckoutContainer').html('');

            let buttonPaypal = paypal.Buttons(options)

            buttonPaypal.render('#paypalCheckoutContainer');


        }


        function realizarPagoPaypalInscripcion(datosPago) {

            // console.log(datosPago);


            let nombreTicket = 'Orden de pago ' + datosPago.nombreTicket,
                tipo_item_amt = datosPago.tipo_item_amt,
                tipo_tax_amt = datosPago.tipo_tax_amt,
                tipo_total_amt = datosPago.tipo_total_amt,
                sku = datosPago.sku,
                invoiceid = datosPago.invoiceid,
                divisaOrden = datosPago.divisaPase,
                idForm = $('.btnpago').data('idpase'),
                status_apartado = $('.btnpago').data('status_apartado'),
                inputcoupon = document.querySelector('.couponcode'),
                form = document.querySelector(".needs-validation");

            $('#paypalCheckoutContainer').html('');

            paypal.Buttons({

                style: {
                    layout: 'vertical', // horizontal | vertical
                    size: 'large', // medium | large | responsive
                    shape: 'pill', // pill | rect
                    color: 'gold', // gold | blue | silver | black
                    label: 'pay',
                    fundingicons: 'true'
                },

                commit: true,

                // Set up the transaction
                createOrder: function (data, actions) {

                    return actions.order.create({
                        purchase_units: [{
                            reference_id: 'P-1',
                            description: nombreTicket,
                            invoice_id: invoiceid,
                            custom_id: 'CUST_VSDC',
                            amount: {
                                currency_code: divisaOrden,
                                value: tipo_total_amt.toFixed(2),
                                breakdown: {
                                    item_total: {
                                        currency_code: divisaOrden,
                                        value: tipo_item_amt.toFixed(2)
                                    },
                                    shipping: {
                                        currency_code: divisaOrden,
                                        value: '0.00'
                                    },
                                    tax_total: {
                                        currency_code: divisaOrden,
                                        value: tipo_tax_amt.toFixed(2)
                                    },
                                    handling: {
                                        currency_code: divisaOrden,
                                        value: '0.00'
                                    },
                                    shipping_discount: {
                                        currency_code: divisaOrden,
                                        value: '0.00'
                                    },
                                    insurance: {
                                        currency_code: divisaOrden,
                                        value: '0.00'
                                    }
                                }
                            },
                            items: [{
                                name: nombreTicket,
                                sku: sku,
                                unit_amount: {
                                    currency_code: divisaOrden,
                                    value: tipo_item_amt.toFixed(2)
                                },
                                quantity: '1',
                                category: 'PHYSICAL_GOODS'
                            }]

                        }]
                    });

                },


                // onApprove: function (data, actions) {
                //     preloader.classList.add('active');
                //     document.querySelector('#textoload').textContent = 'Procesando pago...';

                //     $.ajax({
                //         url: './functions/dataprocess.php',
                //         data: {
                //             orderID: data.orderID
                //         },
                //         type: 'POST'
                //     }).done((orderData) => {


                //         console.log(orderData)
                //         // Three cases to handle:
                //         //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                //         //   (2) Other non-recoverable errors -> Show a failure message
                //         //   (3) Successful transaction -> Show confirmation or thank you

                //         // This example reads a v2/checkout/orders capture response, propagated from the server
                //         // You could use a different API or structure for your 'orderData'
                //         var errorDetail = Array.isArray(orderData.details) && orderData.details[0];

                //         console.log(errorDetail)

                //         if (errorDetail && errorDetail.issue === 'INSTRUMENT_DECLINED') {
                //             return actions.restart(); // Recoverable state, per:
                //             // https://developer.paypal.com/docs/checkout/integration-features/funding-failure/
                //         }

                //         if (errorDetail) {
                //             var msg = 'Lo sentimos su transacción no pudo ser procesada';
                //             if (errorDetail.description) msg += '\n\n' + errorDetail.description;
                //             if (orderData.debug_id) msg += ' (' + orderData.debug_id + ')';
                //             return alert(msg); // Show a failure message (try to avoid alerts in production environments)
                //         }

                //         // Successful capture! For demo purposes:
                //         // console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));


                //         const formData = new FormData(form);
                //         formData.append('invoiceid', orderData.purchase_units[0].invoice_id);
                //         formData.append('email', orderData.payer.email_address)
                //         formData.append('fname', orderData.payer.name.given_name)
                //         formData.append('lname', orderData.payer.name.surname)
                //         // formData.append('datebirth', document.querySelector(".fecha_nac").value)
                //         formData.append('reciboid', orderData.id)
                //         formData.append('fechapago', details.create_time)
                //         formData.append('couponcode', inputcoupon.value)
                //         formData.append('country', details.payer.address.country_code)

                //         $.ajax({
                //             type: 'POST',
                //             url: '../functions/addpayInscripcion.php',
                //             data: formData,
                //             processData: false, // tell jQuery not to process the data
                //             contentType: false, // tell jQuery not to set contentType
                //         }).done(function ({
                //             respuesta
                //         }) {

                //             console.log(respuesta)

                //             switch (respuesta) {
                //                 case 'success':
                //                     enviarregistroInscripcion(orderData, datosPago);

                //                     break;

                //             }
                //         })



                //     })


                // },
                // // Finalize the transaction
                onApprove: function (data, actions) {
                    preloader.classList.add('active');
                    document.querySelector('#textoload').textContent = 'Procesando pago...';


                    return actions.order.capture().then(function (details) {

                        const formData = new FormData(form);
                        formData.append('invoiceid', details.purchase_units[0].invoice_id);
                        formData.append('email', details.payer.email_address)
                        formData.append('fname', details.payer.name.given_name)
                        formData.append('lname', details.payer.name.surname)
                        // formData.append('datebirth', document.querySelector(".fecha_nac").value)
                        formData.append('reciboid', details.id)
                        formData.append('fechapago', details.create_time)
                        formData.append('couponcode', inputcoupon.value)
                        formData.append('country', details.payer.address.country_code)

                        $.ajax({
                            type: 'POST',
                            url: '../functions/addpayInscripcion.php',
                            data: formData,
                            processData: false, // tell jQuery not to process the data
                            contentType: false, // tell jQuery not to set contentType
                        }).done(function ({
                            respuesta
                        }) {

                            console.log(respuesta)

                            switch (respuesta) {
                                case 'success':
                                    enviarregistroInscripcion(details, datosPago);

                                    break;

                            }
                        })



                    });
                },

                onCancel: function (data, actions) {

                    console.log(data)
                    console.log(actions)

                },

                onError: function (data, actions) {

                    console.log(data)
                    console.log(actions)

                }



            }).render('#paypalCheckoutContainer');
        }

        var inter, t;

        function interval() {
            t = 15;
            inter = setInterval(function () {
                document.getElementById("testdiv").innerHTML = t--;
            }, 1000, "JavaScript");

            setTimeout(redirect, 15000)
        }


        function redirect() {
            window.location.href = getUrl.origin;
            // preloader.classList.remove('active');
        }