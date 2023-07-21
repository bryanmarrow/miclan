$('#SignUp').submit(function (e) {
    e.preventDefault();

    // formSignUp = document.getElementById('SignUp')

    let formSignUp = document.getElementById('SignUp');

    formData = new FormData(formSignUp);

    // for (let [name, value] of formData) {
    //     console.log(`${name} = ${value}`);
    // }
    if ($('#SignUpPassword').val() !== $('#SignUpconfirm_password').val()) {
        $('#message').html('Contraseña no coinciden').css('color', 'red');
        e.stopPropagation();
        return false
    }
    if ($('#emailSignUp').val() !== $('#confemailSignUp').val()) {
        $('#messageEmail').html('Emails no coinciden').css('color', 'red');
        e.stopPropagation();
        return false
    }
    if (!formSignUp.checkValidity()) {

        e.stopPropagation();
        return false
    } else {
        preloader.classList.add('active');
        $.ajax({
            url: 'ajax/SignUp.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            // beforeSend: function(){

            // },
            success: function (data) {
                preloader.classList.remove('active');
                console.log(data)

                if (data.respuesta == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Registro exitóso',
                        // showCancelButton: true,
                        confirmButtonText: 'Iniciar sesión',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {

                        if (result.isConfirmed) {
                            window.location.href = "login";
                        }
                    })

                }
                if (data.respuesta == 'errorEmail') {

                    Swal.fire({
                        icon: 'error',
                        title: data.mensaje,
                        // showCancelButton: true,
                        // confirmButtonText: 'Iniciar sesión',
                    })
                }
                // else{
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Favor de intentar más tarde',
                //         // showCancelButton: true,
                //         confirmButtonText: 'Ok',
                //     }).then((result) => {

                //         if (result.isConfirmed) {
                //             location.reload();
                //         } 
                //     })
                // }
            }
        })
        $('.messageForm').html('');
        return true
    }


})


$('#confemailSignUp, #SignUpconfirm_password').change(function (e) {

    if ($('#SignUpPassword').val() !== $('#SignUpconfirm_password').val()) {
        $('#message').html('Contraseña no coinciden').css('color', 'red');
    }
    if ($('#emailSignUp').val() !== $('#confemailSignUp').val()) {
        $('#messageEmail').html('Emails no coinciden').css('color', 'red');
    }
    if ($('#SignUpPassword').val() === $('#SignUpconfirm_password').val()) {
        $('#message').html('');
    }
    if ($('#emailSignUp').val() === $('#confemailSignUp').val()) {
        $('#messageEmail').html('');
    }
})


$('#SignUpPassword').keyup(function (e) {
    passwordUsuario = $(this).val();
    if (passwordUsuario.length < 8) {
        $('#message').html('Contraseña debe contener más de 8 caracteres');
    } else {
        $('#message').empty();
    }
});




$('#SignIn').submit(function (e) {
    e.preventDefault();


    formData = new FormData(this)

    // for (let [name, value] of formData) {
    //     console.log(`${name} = ${value}`);
    // }


    // console.log(formData)
    if ((this).checkValidity() === false) {

        (this).classList.add('was-validated');

    } else {
        preloader.classList.add('active');
        getLogin(formData)

    }

})

function getLogin(formData) {

    $.ajax({
        url: 'ajax/SignIn.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,

    }).done(({
        respuesta,
        mensaje,
        urlback,
        dataCarrito
    }) => {


        preloader.classList.remove('active');

        switch (respuesta) {
            case 'success':
                url = urlback == null ? 'my-account' : urlback
                // console.log(dataCarrito.length)
                if (dataCarrito != null) {
                    localStorage.setItem('carritoelwsc', dataCarrito)
                }
                // console.log(urlback)
                window.location.href = url;
                break;
            case 'error':
                Swal.fire({
                    title: mensaje,
                    icon: 'error'
                })
                break;
            case 'password':
                Swal.fire({
                    title: mensaje,
                    icon: 'error',
                    footer: '<a href="forgot-password">Recuperar contraseña?</a>'
                })
                break;
        }
    })
}

$('.logout').click(function () {


    $.ajax({
        url: 'ajax/logOut.php',
        type: 'POST',
        success: function (data) {
            // console.log(data)
            if (data.respuesta == 'success') {
                window.location.href = "login";
                localStorage.removeItem("carritoelwsc");
            }
        }
    })
})

$('#formForgotPassword').submit(function (e) {
    e.preventDefault();

    formData = new FormData(this);

    // for (let [name, value] of formData) {
    //     console.log(`${name} = ${value}`);
    // }



    if (!this.checkValidity()) {

        e.stopPropagation();
        return false
    } else {
        preloaderActive();

        $.ajax({
            url: 'ajax/recoverypassword.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
        }).done(data => {
            console.log(data)

            if (data.respuesta == 'success') {

                preloaderRemove();

                Swal.fire({
                    icon: 'success',
                    text: 'En breve recibirá un correo electrónico para confirmar su registro.',
                    footer: 'No olvides verificar tu bandeja de correos no deseados, spam u otros(En correos Outlook).',
                    timer: 8000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                    willClose: () => {
                        window.location.href = 'https://localhost/elwsc2021';
                    }
                })

            }
            if (data.respuesta == 'error') {


                preloaderRemove();

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    timer: 2000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                    willClose: () => {
                        window.location.href = 'https://localhost/elwsc2021/';
                    }
                })

            }
        })
    }




})

$('#formNewPassword').submit(function (e) {
    e.preventDefault();

    let url_string = window.location;
    let url = new URL(url_string);
    let email = url.searchParams.get("email");
    let tokenrecovery = url.searchParams.get("tokenrecovery");

    formData = new FormData(this);
    if (email) {
        formData.append('email', email)
    }

    // for (let [name, value] of formData) {
    //     console.log(`${name} = ${value}`);
    // }


    if (!this.checkValidity()) {

        e.stopPropagation();
        return false
    } else {
        preloaderActive();

        $.ajax({
            url: './ajax/recoverypassword.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,

        }).done(data => {

            // console.log(data)
            if (data.respuesta == 'success') {

                preloaderRemove();

                $('#newPassword').modal('hide');

                Swal.fire({
                    icon: 'success',
                    title: 'Contraseña cambiada',
                    timer: 4000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                    willClose: () => {
                        window.location.href = 'https://localhost/elwsc2021/login';
                    }
                })

            }
            if (data.respuesta == 'error') {

                $('.modal').modal('hide');
                preloaderRemove();

                Swal.fire({
                    icon: 'error',
                    title: data.mensaje,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                    willClose: () => {
                        window.location.href = 'https://localhost/elwsc2021/';
                    }
                })

            }
        })
    }



})


$('input[name=confemail]').keyup(function () {

    inputEmail = document.querySelector('input[name=confemail]').value;

    if (inputEmail.length > 5) {
        if ($('input[name=email]').val() == $('input[name=confemail]').val()) {
            $('#messageEmail').html('').css('color', 'green');
        } else if ($('input[name=email]').val() !== $('input[name=confemail]').val()) {
            $('#messageEmail').html('Emails no coinciden').css('color', 'red');
        }
    }

})


$('#newpass1').keyup(function () {

    inputnewPassword = document.querySelector('#newpass1').value;

    if (inputnewPassword.length > 5) {
        if ($('#newpass').val() == $('#newpass1').val()) {
            $('#messagenewPassword').html('').css('color', 'green');
        } else if ($('#newpass').val() !== $('#newpass1').val()) {
            $('#messagenewPassword').html('Contraseña no coincide').css('color', 'red');
        }
    }

})

function ConfirmarRegistro() {
    var url_string = window.location;
    var url = new URL(url_string);
    var token = url.searchParams.get("token");
    var email = url.searchParams.get("email");
    var tokenrecovery = url.searchParams.get("tokenrecovery");

    if (token && email) {
        $.ajax({
            url: 'ajax/confirmarregistro.php',
            type: 'POST',
            data: {
                token: token,
                email: email
            }
        }).done(data => {

            // console.log(data)

            if (data.respuesta == 'success') {

                Swal.fire({
                    icon: 'success',
                    title: data.mensaje,
                    timer: 2000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                    willClose: () => {
                        window.location.href = 'https://localhost/elwsc2021/login';
                    }
                })

            }
            if (data.respuesta == 'error') {

                Swal.fire({
                    icon: 'error',
                    title: data.mensaje,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                    willClose: () => {
                        window.location.href = 'https://localhost/elwsc2021/';
                    }
                })

            }

        })
    }
    if (tokenrecovery && email) {
        $.ajax({
            url: 'ajax/recoverypassword.php',
            type: 'POST',
            data: {
                tokenrecovery: {
                    tokenrecovery,
                    email
                }
            }
        }).done(data => {



            if (data.respuesta == 'success') {

                $('#newPassword').modal('show');

            }
            if (data.respuesta == 'error') {

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.mensaje,
                    timer: 2000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                    willClose: () => {
                        // window.location.href = 'https://localhost/elwsc2021/';
                    }
                })

            }

        })
    }

}

ConfirmarRegistro();