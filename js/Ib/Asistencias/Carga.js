var notyf = new Notyf({
  position: {
    x: 'right',
    y: 'top',
  },
  dismissible: true, // Permite que las notificaciones sean cerrables
  duration: 6000, // Duración predeterminada de las notificaciones en milisegundos (opcional)
});

function updateFileName(input) {
  let fileName = input.files[0].name;
  let fileNameContainer = input.parentElement.querySelector('.custom-file-name');
  fileNameContainer.innerText = fileName;
}

function ocultarModalCarga() {
  $("#modal_carga_masiva_asistencias").modal("hide");
}

function mostrarModalCargaAsistencia() {
  $('.custom-file-name').text('');
  $('#customFile').val(null);
  $("#modal_carga_masiva_asistencias").modal("show");
}

function validarCarga_() {


  let bool = false;
  let maxMB = 5;
  let fileInput = document.getElementById('customFile');
  let file = fileInput.files[0];

  console.log(maxMB);


  if (file) {
    let fileSize = file.size;
    let fileSizeKB = fileSize / 1024;
    let fileMb = fileSizeKB / 1024;
    let fileExtension = file.name.split('.').pop();

    console.log(maxMB);

    if (fileMb >= maxMB) {
      notyf.error('El archivo debe tener un peso máximo de ' + maxMB + ' MB');
      //mensajeError('El archivo debe tener un peso máximo de ' + maxMB + ' MB');
    } else if (fileExtension != 'xls') {
      notyf.error('La extensión del archivo debe terminar .xls');
      //mensajeError('La extensión del archivo debe terminar .xlsx');
    } else {
      processDataAsistencia(file);
    }
  } else {
    notyf.error('Campo seleccione un archivo no puede estar vacio');
  }
  return bool;
}


function fadeIn() {
  $('#overlay').fadeIn();
}

function fadeOut() {
  $('#overlay').fadeOut();
}

function processDataAsistencia(file) {
  ocultarModalCarga();
  fadeIn();
  let data = new FormData();
  data.append('file', file);

  $.ajax({
    url: "../../../../App/Controllers/Central/AsistenciaC/CargaC.php",
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
        getFileAsistencia();
      } else {
        fadeOut();
        notyf.error(message);
      }
    }
  });
}

function getFileAsistencia() {
  $.ajax({
    url: "../../../../App/Controllers/Central/AsistenciaC/DescargaC.php",
    type: 'POST',
    xhrFields: {
      responseType: 'blob' // Configura la respuesta esperada como un blob (archivo binario)
    },
    success: function (data) {
      if (data.size > 0) {
        var blob = new Blob([data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
        var url = window.URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;
        a.download = 'LAYOUT_ASISTENCIAS_RESULTADOS.xlsx'; // Nombre del archivo que se descargará
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
        notyf.success('El proceso se llevó a cabo con éxito');
      } else {
        notyf.error('Error al ejecutar la acción');
      }
      fadeOut();
    },
    error: function (xhr, status, error) {
      notyf.error('Error al ejecutar la acción');
      fadeOut();
    }
  });
}
