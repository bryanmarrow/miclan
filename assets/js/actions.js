var urlfunctions = 'functions/';
var getUrl = window.location;
let formframepic = document.querySelector(".validar-formframepic");
const formreservacion = document.querySelector('.registro-reservacion');
var preloader = document.querySelector('.cs-page-loading');


preloaderActive = () => {
    return preloader.classList.add('active')
};
preloaderRemove = () => {
    return preloader.classList.remove('active')
};

if (formframepic) {
    formframepic.addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(formframepic);
        formData.append('image', $('input[type=file]')[0].files[0]);

        // for(let [name, value] of formData) {
        //     console.log(`${name} = ${value}`);
        // }

        // const file = $('input[type=file]')[0].files[0];
        // console.log(file);

        if (formframepic.checkValidity() === false) {
            formframepic.classList.add('was-validated');
        } else {

            $.ajax({
                type: 'POST',
                url: urlfunctions + 'addform.php',
                data: formData,
                dataType: "json",
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                beforeSend: function () {
                    preloader.classList.add('active');
                    document.querySelector('#textoload').textContent = 'Enviando registro...';
                },
                success: function (datos) {
                    console.log(datos)
                    preloader.classList.remove('active');
                    if (datos.respuesta == 1) {
                        $('.envioimageexitoso').modal('show')
                        setTimeout(redirect, 10000)

                    } else {
                        $('.codinscnovalido').modal('show')
                    }
                }
            })
        }

    });
}

if (formreservacion) {
    $('.registro-reservacion').submit(function (e) {

        e.preventDefault();

        if (formreservacion.checkValidity() === false) {
            formreservacion.classList.add('was-validated');
        } else {


            preloader.classList.add('active');

            const infoReservacion = new FormData();
            $('.infoPrimariaReservacion').find('input, select.custom-select').each((index, element) => {
                nameAttr = $(element).attr('name');

                if (nameAttr == 'imagen_p') {
                    infoReservacion.append(nameAttr, element.files[0])
                } else {
                    infoReservacion.append(nameAttr, $(element).val())
                }


            });

            $(this).find('div.infoIntegrante').each((index, element) => {
                numIntegrante = index

                $(element).find('input').each((index, element) => {
                    nameAttr = $(element).attr('name');
                    if (nameAttr == 'pasaporteIntegrante') {
                        infoReservacion.append(nameAttr + numIntegrante, element.files[0]);
                    } else {
                        infoReservacion.append(nameAttr + numIntegrante, $(element).val());
                    }
                })
            });

            $.ajax({
                url: urlfunctions + 'addReservacion.php',
                type: 'POST',
                // data: { infoTitular },
                data: infoReservacion,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                dataType: 'json',
            }).done(data => {

                if (data.respuesta === 'success') {
                    preloader.classList.remove('active');
                    document.querySelector('.alertaexitoso').textContent = 'Registro exitoso';
                    $('.sucessregistro').modal('show')
                    $('.sucessregistro').on('show.bs.modal', interval())

                } else {
                    alert('Error, por favor intente más tarde');
                }
            })

        }
    })
}

function huespedeshotel(data) {
    numint = document.querySelector('#huespedes_hotel').value

    var container = document.getElementById("huespedes");

    var o = 0;

    while (container.hasChildNodes()) {
        container.removeChild(container.lastChild);
    }
    for (i = 0; i < numint; i++) {
        // container.appendChild(document.createTextNode(i+1));


        divIntegrante = `
        <div class="row infoIntegrante">
            <div class="col-md-4 col-sm-12 campoIntegrante">
                <div class="form-group">
                    <label>Nombre/ First Name:</label>
                    <input type="text" name="nombreshuespedes" class="form-control" required="">
                </div>
            </div>
            <div class="col-md-4 col-sm-12 campoIntegrante">
                <div class="form-group">
                    <label>Apellido/Last Name:</label>
                    <span class="text-muted">*</span>
                    <input type="text" name="apellidoshuespedes" class="form-control" required="">
                    <div class="invalid-feedback">Campo requerido</div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 campoIntegrante">
                <label for="pasaporteIntegrante${i}">Pasaporte</label>
                <div class="custom-file" lang="es">
                    <input class="custom-file-input pasaporteIntegrante comprobante_pago" id="pasaporteIntegrante${i}" name="pasaporteIntegrante" type="file" accept="application/pdf, image/jpg, image/png" aria-label="Elegir archivo..." required>
                    <label class="custom-file-label text-truncate"  >Elegir archivo...</label>
                </div>
            </div>
        </div>
        `;

        $(container).append(divIntegrante)


            ++o;



    }




}

var inter, t;

function interval() {
    t = 15;
    inter = setInterval(function () {
        document.getElementById("testdiv").innerHTML = t--;
    }, 1000, "JavaScript");

    setTimeout(redirect, 15000)
}

$(document).on('change', ".comprobante_pago", function () {
    var file = this.files[0];
    var imagefile = file.type;
    var sizefile = file.size;
    var match = ["image/jpeg", "image/png", "image/jpg", "application/pdf"];

    var sizemax = 3000000;
    if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]) || (imagefile == match[3]) || (imagefile == match[4]))) {
        alert('Por favor seleccione un formato válido: (JPEG/JPG/PNG,PDF).');
        $(this).val('');
        return false;
    }
    if (sizefile > sizemax) {
        alert('Archivo demasiado grande, favor de reducirlo');
        $(this).val('');
        return false;
    }
    $(this).parent().find('label').text(this.files[0].name)
});

function redirect() {
    window.location.href = getUrl.origin;
}



// $(document).ready(function (e) {
//     $.ajax({
//         url: 'functions/globalStatus.php',
//         type: 'POST',
//         data: {}
//     }).done(({
//         status
//     }) => {
//         if (status == 1) {
//             preloader.classList.add('active');
//         }
//     })
// })


$(document).ready(() => {

    setCountries();

})

setCountries = () => {


    if (document.querySelector('.setCountries')) {
        $('.setCountries').append(`<option readonly>Cargando...</option>`);

        getSelectCountries = $('.setCountries');

        var allCountries;
        $.ajax({
            'url': 'ajax/getData',
            'type': 'POST',
            data: {
                tipo: 'getCountries'
            }
        }).done(({
            data
        }) => {
            allCountries = data;

            for (let index = 0; index < getSelectCountries.length; index++) {
                const selectCountries = getSelectCountries[index];
                let idCountry = null;


                $(selectCountries).empty();

                if ($(selectCountries).data('idcountry')) {
                    idCountry = $(selectCountries).data('idcountry');
                }

                allCountries.forEach(item => {
                    if (idCountry !== null) {
                        if (idCountry == item.id) {
                            $(selectCountries).append(`<option value="${item.id}" selected>${ item.pais}</option>`);
                        } else {
                            $(selectCountries).append(`<option value="${item.id}" >${ item.pais}</option>`);
                        }
                    } else {
                        $(selectCountries).append(`<option value="${item.id}" >${ item.pais}</option>`);
                    }


                })



            }



        })





    }

}


$('#OpenImgUpload').click(function () {
    $('#imgupload').trigger('click');
    return false;
});

$('#imgupload').change(function (e) {
    readfichier(e);
    return false;
})

var img = $('#cambiarAvatarPreview');

function readfichier(e) {
    console.log(e)
    if (window.FileReader) {
        var file = e.target.files[0];
        var reader = new FileReader();
        if (file && file.type.match('image.*')) {
            reader.readAsDataURL(file);
        } else {
            img.css('display', 'none');
            img.attr('src', '');
        }
        reader.onloadend = function (e) {
            img.attr('src', reader.result);
            img.css('display', 'block');
        }
    }
}

$('#formEditAccount').submit(function (e) {
    e.preventDefault();


    const formData = new FormData(this);
    formData.append('action', 'editAccount');

    for (let [name, value] of formData) {
        console.log(`${name} = ${value}`);
    }

    $.ajax({
        type: 'POST',
        url: 'ajax/accountController',
        data: formData,
        dataType: "json",
        processData: false,
        contentType: false,
    }).done(({
        respuesta,
        mensaje
    }) => {

        switch (respuesta) {
            case 'succes':
                Swal.fire({
                    icon: respuesta,
                    title: mensaje,
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    location.reload();
                })
                break;
            case 'error':
                Swal.fire({
                    icon: respuesta,
                    title: mensaje,
                    showConfirmButton: false,
                    timer: 6000
                })
                break;
        }
    })

})