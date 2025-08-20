function ocultarModalFaltas() {
  $("#modal_carga_masiva_faltas").modal("hide");
}

function mostrarModalFaltas() {
  $('.custom-file-name-faltas').text('');
  $('#customFileFaltas').val(null);
  $("#modal_carga_masiva_faltas").modal("show");
}

function updateFileNameFalta(input) {
  if (!input.files || !input.files[0]) return;
  const fileName = input.files[0].name;
  const fileNameContainer = input.parentElement.querySelector('.custom-file-name-faltas');
  if (fileNameContainer) fileNameContainer.innerText = fileName;
}

function validarCargaFalta() {
  const maxMB = 5;
  const fileInput = document.getElementById('customFileFaltas');
  const file = fileInput?.files?.[0];

  if (!file) {
    notyf.error('Campo seleccione un archivo no puede estar vacío');
    return false;
  }

  const fileMb = file.size / 1024 / 1024;
  const nameLower = file.name.toLowerCase();

  if (fileMb >= maxMB) {
    notyf.error('El archivo debe tener un peso máximo de ' + maxMB + ' MB');
    return false;
  }
  if (!nameLower.endsWith('.xlsx')) {
    notyf.error('La extensión del archivo debe terminar en .xlsx');
    return false;
  }

  processDataFaltas(file);
  return true;
}

function processDataFaltas(file) {
  ocultarModalFaltas();
  fadeIn();

  const data = new FormData();
  data.append('file', file); // el backend espera 'file'

  $.ajax({
    url: "../../../../App/Controllers/Central/FaltaC/FaltaJustificarC.php",
    type: 'POST',
    data: data,
    processData: false,
    contentType: false,
    cache: false,
    dataType: 'json', // 👈 importante: ya no haces JSON.parse
    success: function (resp) {
      // resp ya es un objeto
      console.log('DEBUG BACKEND:', resp.debug || null);

      if (resp.bool) {
        // Si tu backend ya devuelve contadores, muéstralos:
        const insTemp = resp.insertados_temp ?? 0;
        const insInc  = resp.incidencias_insertadas ?? 0;
        notyf.success(`Proceso exitoso. Temp: ${insTemp} filas. Incidencias: ${insInc}.`);
      } else {
        notyf.error(resp.message || 'No se pudo completar la acción.');
      }
    },
    error: function (xhr) {
      // Si por alguna razón el backend no devolvió JSON bien formado
      console.error('AJAX error:', xhr.status, xhr.statusText);
      const raw = xhr.responseText || '';
      console.log('Raw response:', raw);
      notyf.error('Error de comunicación. Revisa el log de servidor.');
    },
    complete: function () {
      fadeOut();
    }
  });


}