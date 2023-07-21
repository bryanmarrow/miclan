

// var urlfunctions = getUrl.origin + '/functions/';
// let formframepic = document.querySelector(".validar-formframepic");
// var preloader = document.querySelector('.cs-page-loading');

// // console.log(urlfunctions)
// if(formframepic){
//     formframepic.addEventListener('submit', function(event){
//         event.preventDefault();

//         const formData = new FormData(formframepic);
//         formData.append('image', $('input[type=file]')[0].files[0]); 

//         for(let [name, value] of formData) {
//             console.log(`${name} = ${value}`);

            
//         }

//         if(formframepic.checkValidity()=== false){
//             formframepic.classList.add('was-validated');
            
//             // console.log('Incompleto');
            
//         }else{
            
//             $.ajax({
//                 type: 'POST',
//                 url: urlfunctions + 'addform.php',
//                 data: formData,
//                 dataType: "json",
//                 processData: false,  // tell jQuery not to process the data
//                 contentType: false,   // tell jQuery not to set contentType
//                 beforeSend : function(){
//                     preloader.classList.add('active');
//                     // document.querySelector('#textoload').textContent = 'Enviando registro...';
//                 },
//                 success: function(datos){
//                     preloader.classList.remove('active');
//                     if(datos.respuesta==1){
//                         // console.log(datos)
                        
//                         $('.envioimageexitoso').modal('show')
//                         setTimeout(redirect, 10000)

//                     }else{
//                         $('.codinscnovalido').modal('show')
//                     }
                    
//                     // document.querySelector('.alertaexitoso').textContent = 'Pago exitoso';
//                     // $('.sucessregistro').modal('show')
//                     // $('.sucessregistro').on('show.bs.modal', interval())
//                 }
//             })
//         }

//     });
// }

// $("#imagen_p").change(function () {
//     var file = this.files[0];
//     var imagefile = file.type;
//     var sizefile = file.size;
//     var match = ["image/jpeg", "image/png", "image/jpg"];
//     if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]) || (imagefile == match[3]) )) {
//         alert('Por favor seleccione un formato válido: (JPEG/JPG/PNG).');
//         $("#imagen_p").val('');
//         return false;
//     }
//     if(sizefile > 5242880){
//         alert('Archivo demasiado grande, favor de reducirlo');
//         return false;
//     }
//     $("label[for='file']").text(this.files[0].name);
// });

// function redirect(){
//     window.location.href = getUrl.origin;
// }