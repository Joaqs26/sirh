function ocultarModalFaltas() {
    $("#modal_carga_masiva_faltas").modal("hide");
}

function mostrarModalFaltas() {
    $('.custom-file-name-faltas').text('');
    $('#customFileFaltas').val(null);
    $("#modal_carga_masiva_faltas").modal("show");
}


function updateFileNameFalta(input) {
    let fileName = input.files[0].name;
    let fileNameContainer = input.parentElement.querySelector('.custom-file-name-faltas');
    fileNameContainer.innerText = fileName;
}


function validarCargaFalta() {


    let bool = false;
    let maxMB = 5;
    let fileInput = document.getElementById('customFileFaltas');
    let file = fileInput.files[0];

    if (file) {
        let fileSize = file.size;
        let fileSizeKB = fileSize / 1024;
        let fileMb = fileSizeKB / 1024;
        let fileExtension = file.name.split('.').pop();

        if (fileMb >= maxMB) {
            notyf.error('El archivo debe tener un peso máximo de ' + maxMB + ' MB');
            //mensajeError('El archivo debe tener un peso máximo de ' + maxMB + ' MB');
        } else if (fileExtension != 'xlsx') {
            notyf.error('La extensión del archivo debe terminar .xlsx');
            //mensajeError('La extensión del archivo debe terminar .xlsx');
        } else {
            processDataFaltas(file);
        }
    } else {
        notyf.error('Campo seleccione un archivo no puede estar vacio');
    }
    return bool;
}


function processDataFaltas(file) {
    ocultarModalFaltas();
    fadeIn();
    let data = new FormData();
    data.append('file', file);

    $.ajax({
        url: "../../../../App/Controllers/Central/FaltaC/FaltaJustificarC.php",
        type: 'POST',
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            let jsonData = JSON.parse(data);
            let bool = jsonData.bool;
            let message = jsonData.message;

            if (bool) {
                notyf.success('El proceso se llevó a cabo con éxito');
            } else {
                notyf.error(message);
            }

            fadeOut();
        }
    });
}