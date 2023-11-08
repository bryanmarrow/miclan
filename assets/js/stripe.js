const formOrdenPases = document.querySelector('.formOrdenPases');
const btnRealizarPago = document.querySelector(".realizarPago");
const cc_number = document.querySelector("#cc-number");
const cc_datexp = document.querySelector("#cc-expiry");
const cc_cvc = document.querySelector("#cc-cvc");
const stripeAccountId = 'acct_1LVia2B4srLF6gvb';

const stripe = Stripe("pk_test_SPzxR9refXm7YQLVIURE8p47", {
  stripeAccount: stripeAccountId
});
const checkoutPago = document.getElementById("paypalinfo");
const checkoutCard = document.getElementById('divCreditCard');

let elements;
var cartArray = shoppingCart.listCart();
var itemsOrden = [];
paymentIntent = '';
carrito = '';

if (formOrdenPases) {
  formOrdenPases.addEventListener("submit", handleSubmit);
  var liveDropzone = new Dropzone(".dropzone", {
    url: "./functions/cargarComprobantesPago.php",
    paramName: "imgvalues",
    maxFilesize: 10,
    maxFiles: 3,
    parallelUploads: 3,
    acceptedFiles: "image/*,application/pdf",
    autoProcessQueue: false,
    uploadMultiple: true,
    // addRemoveLinks: true,
    previewTemplate: document.querySelector('#uploadPreviewTemplate').innerHTML,
    previewsContainer: "#file-previews",
  });

}

cartArray.forEach(elemento => {
  item = {}
  item['product'] = elemento['sku']
  item['quantity'] = parseInt(elemento['quantity'])
  itemsOrden.push(item)
})


async function handleSubmit(e) {
  e.preventDefault();


  var subTotalCarrito = shoppingCart.totalCart();

  tag_evento=urlParams.get('tag_evento');   
  // console.log(tag_evento)

  if (subTotalCarrito == 0) {

    return
  }
  if (formOrdenPases.checkValidity() === false) {
    formOrdenPases.classList.add('was-validated');

    const formData = new FormData(formOrdenPases);

    // for (let [name, value] of formData) {
    //   console.log(`${name} = ${value}`);
    // }
  } else {

    // var checkedValue = document.getElementById('saveCard').checked;

    pases = {}
    $(formOrdenPases).find('div.rowPase').each(function (index, element) {
      pase = {}

      $(this).find('input').each(function () {

        let name = $(this).attr("name");

        pase[name] = $(this).val()
        pase['invoiceid'] = invoiceID
      })
      // console.log(pase)
      pases[index] = pase

    });

    notasOrden = $('.formOrdenPases .notas_orden').val();

    infoOrdenPases = {
      'invoiceid': invoiceID,
      'cc-number': cc_number.value,
      'cc-datexmp': cc_datexp.value,
      'cc-cvc': cc_cvc.value,
      'notasOrden': notasOrden
      // 'saveCard': checkedValue
    };




    paymentMethod = $('input[name="payment_method"]:checked').val();
    queueFiles = liveDropzone.getQueuedFiles();

    console.log(paymentMethod);

    if (paymentMethod === undefined) {
      alert('Seleccione un método de pago');
      return;
    } else if (paymentMethod == 'transfer') {
      if (queueFiles.length == 0) {
        alert('No ha cargado ningún comprobante de pago');
        return;
      }
    }

    // liveDropzone.processQueue();
    preloaderActive();

    // if (!paymentIntent) {
    $.ajax({
      url: './functions/createOrdenPases.php',
      type: "POST",
      data: {
        pases: pases,
        infoOrdenPases: infoOrdenPases,
        itemsOrden: itemsOrden,
        cartArray: cartArray,
        paymentMethod
      }
    }).done(data => {
      // console.log(data)
      // if (data.respuesta == 'success') {
        switch (data.metodoPago) {
          case 'transfer':


            infoComprobantesPago = []


            $(".formOrdenPases #file-previews").find('div.dz-image-preview').each(function (index, element) {
              comprobantePago = {}

              $(this).find('input').each(function () {
                let name = $(this).attr("name");
                comprobantePago[name] = $(this).val()
                comprobantePago['invoiceid'] = invoiceID
              })

              infoComprobantesPago.push(comprobantePago)
            });

            liveDropzone.on("sending", function (file, xhr, formData) {
              formData.append("tokenPago", data.tokenPago)
              formData.append("action", 'insert')
              formData.append("infoComprobantes", JSON.stringify(infoComprobantesPago))
            });

            liveDropzone.processQueue();


            liveDropzone.on("queuecomplete", function (file) {
              $.ajax({
                type: 'POST',
                url: './functions/updateStatustickets.php',
                data: {
                  invoice_id: invoiceID,
                  pases: cartArray,
                  infoOrdenPases,
                  metodopago: data.metodoPago,
                  tag_evento
                }
              }).done(data => {
                switch (data.respuesta) {
                  case 'success':
                    // console.log(data)
                    mostrarOrden(data);
                    shoppingCart.clearCart();
                    displayCart();
                    preloaderRemove();
                    liveDropzone.removeAllFiles(true);
                    break;
                  case 'error':
                    alert(data.texto)
                    console.log(data.mensaje)
                    break;
                }
              })

            })
            break;
          case 'credit-card':
            
          
            metodoPago=data.metodoPago

            carrito = data.carrito;

            stripe.confirmCardPayment(data.clientSecret, {
                payment_method: data.idMetodoPago
              })
              .then(data => {
                if (data.error) {
                  error = data.error
                  paymentIntent = error.payment_intent
                  showMessage(error.message)
                }
                if (data.paymentIntent) {
                  guardarPago(data.paymentIntent, carrito, pases, metodoPago);
                }

              })
            break;
        }
      // } else if (data['respuesta'] == 'error') {

      //   alert('Error al agregar la orden');
      //   console.log(data)

      // }


    });


    //   if (data['respuesta'] == 'error') {

    //     alert('Error al agregar la orden');
    //     console.log(data)

    //   } else {


    //     carrito = data.carrito;

    //     stripe.confirmCardPayment(data.clientSecret, {
    //         payment_method: data.idMetodoPago
    //       })
    //       .then(data => {



    //         if (data.error) {

    //           error = data.error

    //           paymentIntent = error.payment_intent



    //           showMessage(error.message)

    //         }
    //         if (data.paymentIntent) {
    //           guardarPago(data.paymentIntent, carrito, pases);
    //         }

    //       })
    //   }



    //     stripe.confirmOxxoPayment(
    //       data.clientSecret,
    //       {
    //         payment_method: {
    //           billing_details: {
    //             name: 'Bryan Martinez',
    //             email: 'bryan.martinez.romero@gmailc.om',
    //           },
    //         },
    //       }) // Stripe.js will open a modal to display the OXXO voucher to your customer
    //       .then(function(result) {
    //         console.log(result)
    //         This promise resolves when the customer closes the modal
    //         if (result.error) {
    //           Display error to your customer
    //           var errorMsg = document.getElementById('error-message');
    //           errorMsg.innerText = result.error.message;
    //         }
    //   });
    // })
    // }
    // if (paymentIntent) {
    //   clientSecret = paymentIntent.client_secret

    //   $.ajax({
    //     url: './functions/crearMetodoPago.php',
    //     type: "POST",
    //     data: {
    //       paymentIntent: paymentIntent,
    //       infoOrdenPases: infoOrdenPases
    //     }
    //   }).done(data => {



    //     stripe.confirmCardPayment(clientSecret, {
    //         payment_method: data.idMetodoPago
    //       })
    //       .then(data => {


    //         if (data.error) {

    //           error = data.error

    //           paymentIntent = error.payment_intent

    //           showMessage(error.message)

    //         }
    //         if (data.paymentIntent) {
    //           guardarPago(data.paymentIntent, carrito);
    //         }

    //       })
    //   })


    // }






  }




}

function setCollapse(collapsing) {
  if (collapsing) {
    var bsCollapse = new bootstrap.Collapse(checkoutCard, {
      toggle: true
    })
  } else {
    var bsCollapse = new bootstrap.Collapse(checkoutCard, {
      toggle: false
    })
  }
}


function guardarPago(infoPago, carrito, infoOrdenPases, metodoPago) {


  console.log(infoPago)
  console.log(carrito)
  console.log(metodoPago)

  ordenPago = {}
  ordenPago['invoiceid'] = infoPago.description;
  ordenPago['idPagoStripe'] = infoPago.id;
  ordenPago['payment_method_types'] = infoPago.payment_method;
  ordenPago['status'] = infoPago.status;
  ordenPago['monto'] = infoPago.amount;
  ordenPago['currency'] = infoPago.currency
  ordenPago['carrito'] = carrito
  ordenPago['metodopago']=metodoPago
  console.log(ordenPago)


  $.ajax({
    type: 'POST',
    url: './functions/agregarPago.php',
    data: ordenPago,
  }).done(data => {
    if (data.respuesta == 'success') {
      tag_evento=urlParams.get('tag_evento');
      
      $.ajax({
        type: 'POST',
        url: './functions/updateStatustickets.php',
        data: {
          invoice_id: infoPago.description,
          pases: carrito,
          infoOrdenPases,
          metodopago: metodoPago,
          tag_evento: tag_evento
        }
      }).done(data => {
        switch (data.respuesta) {
          case 'success':
            mostrarOrden(data);
            shoppingCart.clearCart();
            displayCart();
            preloaderRemove();
            break;
          case 'error':
            alert(data.texto)
            console.log(data.mensaje)
            break;
        }
      })

      // document.querySelector('.alertaexitoso').textContent = 'Pago exitoso';
      // $('.sucessregistro').modal('show')
      // $('.sucessregistro').on('show.bs.modal', interval())
    }
    if (data.respuesta == 'error') {
      alert(data.texto)
      console.log(data.mensaje)
    }
  })






}

function mostrarOrden(datos) {
  infoOrdenPases = datos.infoOrdenPases;
  ordenPago = datos.ordenPago;
  pases = datos.pases;


  itemsOrdenSuccess = '';
  for (var i in pases) {

    itemsOrdenSuccess += `<div class="media align-items-center mb-4">
        <div class="media-body pl-2 ml-1">
            <div class="d-flex align-items-center justify-content-between">
                <div class="mr-3">
                <h4 class="nav-heading font-size-md mb-1">
                    <a class="font-weight-medium" href="shop-single.html">${ pases[i].descripcion_pase }</a>
                    <span class="mr-2">x${ pases[i].quantity }</span>   
                </h4>
                <div class="d-flex align-items-center font-size-sm">

                </div>
                </div>
                <div class="pl-3 border-left">                    
                    <span class="mr-2">$${ pases[i].subTotalPase.toFixed(2) }</span>
                </div>
            </div>
        </div>
    </div>`
  }

  infoCupon = infoOrdenPases.cupon
  divCupon = infoCupon.length > 0 ? `<div class="d-flex justify-content-between mb-3"><span class="h6 mb-0">Cupón:</span><span class="text-nav">${ infoCupon.cupon }</span></div>` : '';



  divMostrarOrden = `<div class="container pt-4 mb-2 pb-6">
    <h1 class="mb-3 pb-4">Pedido realizado exitosamente!</h1>
    <div class="row">
        <div class="col-sm-6">          
          <div class="row">
              <div class="col-sm-12 mb-2">
                  <div class="bg-secondary p-4 text-center rounded">
                      <span class="font-weight-medium text-heading mr-2">No. de orden: </span> <span class="class='font-weight-normal'">${infoOrdenPases.invoice_id}</span>
                  </div>
              </div>
              <div class="col-sm-12 mb-2">
                  <div class="bg-secondary p-4 text-center rounded">
                      <span class="font-weight-medium text-heading mr-2">Fecha: </span>${infoOrdenPases.fechapago}
                  </div>
              </div>             
          </div>      
          <div class="alert alert-primary text-center" role="alert">
              Status de Orden de Compra: ${datos.statusOrdenCompra}
          </div>
          <div class="alert alert-primary text-center" role="alert">
              Método de pago: ${datos.metodoPago}
          </div>    
        </div>
        <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-12 mt-4">
                ${itemsOrdenSuccess}
                <hr class="mb-4">
                ${divCupon}
                <div class="d-flex justify-content-between mb-3"><span class="h6 mb-0">Subtotal:</span><span
                    class="text-nav">$ ${ infoOrdenPases.subTotalCarrito.toFixed(2) }</span></div>
                <div class="d-flex justify-content-between mb-3"><span class="h6 mb-0">Tax:</span><span
                    class="text-nav">$ ${ infoOrdenPases.tax.toFixed(2) }</span></div>
                <div class="d-flex justify-content-between mb-3"><span class="h6 mb-0">Total:</span><span
                    class="h6 mb-0">$ ${ infoOrdenPases.total_amount.toFixed(2) }</span></div>
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mt-2" href="./orders">Ver detalle de orden</a>
                </div>
            </div>
        </div>
        </div>
    </div>
  </div>`;


  $('.divCarrito').html(divMostrarOrden);



}


function showMessage(messageText) {

  const messageContainer = document.querySelector(".messagecc");

  messageContainer.classList.remove("d-none");
  messageContainer.textContent = messageText;
  preloaderRemove();

  setTimeout(function () {
    messageContainer.classList.add("d-none");
    messageText.textContent = "";
  }, 8000);
}


$(document).on('click', 'input[name="payment_method"]', function (e) {
  paymentMethod = $('input[name="payment_method"]:checked').val();

  switch (paymentMethod) {
    case 'transfer':

      liveDropzone.on("addedfile", file => {
        console.log(file.type)
        queueFiles = liveDropzone.getQueuedFiles();

        if (file.type != 'image/jpeg' && file.type != 'application/pdf' && file.type != 'image/png' && file.type != 'image/jpg') {
          alert('Formato incorrecto');
          liveDropzone.removeFile(file);
        }

        if (queueFiles.length > 2) {
          alert('Solo se pueden cargar 3 archivos');
          liveDropzone.removeFile(file);
          if (file.size > 5000000) {
            liveDropzone.removeFile(file);
            alert('El archivo debe pesar menos de 5MB');
          }
        }


      });
      break;
    case 'credit-card':
      liveDropzone.removeAllFiles(true);
      break;
  }

})