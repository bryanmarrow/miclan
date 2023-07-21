$('#formAgregarCompetidor').submit(function (e) {
    e.preventDefault();

    formData = new FormData(this);
    formData.append('idform', 'addCompetidor');

    // for (let [name, value] of formData) {
    //     console.log(`${name} = ${value}`);
    // }

    if (!this.checkValidity()) {

        e.stopPropagation();
        return false
    } else {
        preloaderActive();


        $.ajax({
            url: './ajax/addCompetidor.php',
            type: 'POST',
            contentType: false,
            processData: false,
            data: formData
        }).done(data => {

            if (data.respuesta == 'success') {


                $('#nuevoCompetidor').collapse('hide');
                tablaCompetidores.ajax.reload(null, false);
                preloaderRemove();



                this.reset();

                Swal.fire({
                    icon: 'success',
                    title: data.mensaje,
                    timer: 2000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                    willClose: () => {

                    }
                })

            }
            if (data.respuesta == 'error') {

                $('#nuevoCompetidor').collapse('hide')
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

                    }
                })

            }
        })
    }
})


$(document).ready(function () {
    columnsTablaCompetidores = [{
            "title": "Nombre",
            "data": "fname"
        },
        {
            "title": "Apellidos",
            "data": "lname"
        },
        {
            "title": "ID Competidor",
            "data": "idcompetidor"
        },
        {
            "title": "Fecha Registro",
            "data": "fecharegistro"
        },

        // {
        //     "title": "Acciones",
        //     "defaultContent": `
        //     <div class='text-center'>
        //         acciones
        //     </div>`
        // }
    ];

    tablaCompetidores = $('#tablaCompetidores').DataTable({
        dom: 'Bfrtip',
        buttons: [
            // 'copy',
            // 'pdf',
            // 'print',
            // 'excel'
        ],
        "responsive": true,
        "order": [
            [3, "desc"]
        ],
        "columnDefs": [
            // {
            //     "targets": [0, 3, 5],
            //     "visible": false
            // },
        ],
        "ajax": {
            "url": "ajax/tablaCompetidores.php",
            "method": 'POST',
            "dataSrc": ""
        },
        "columns": columnsTablaCompetidores
    });
});