function getReporteAsistencia() {
    Swal.fire({
        title: "Generador de reportes",
        text: "Seleccione el reporte que desea descargar",
        icon: "question",
        width: '600px', // Ajusta el ancho del cuadro de diálogo
        showCancelButton: true,
        confirmButtonColor: "#235B4E",
        cancelButtonColor: "#235B4E",
        confirmButtonText: "Reporte de Faltas",
        cancelButtonText: "Cancelar",
        showDenyButton: true,
        denyButtonColor: "#235B4E",
        denyButtonText: "Reporte de Alertas",
        html: `
            <button id="btnRetardos" class="swal2-confirm swal2-styled" 
                style="background-color: #235B4E; margin-top: 10px;">
                Reporte de Retardos
            </button>
        `, // Botón adicional para "Reporte de Retardos"
        customClass: {
            popup: 'popup-reporte-asistencia', // Clase personalizada
        },
    }).then((result) => {
        if (result.isConfirmed) {
            descargarReporte("../../../../App/Controllers/Central/AsistenciaC/ReporteC.php", "REPORTE_FALTAS.xlsx");
        } else if (result.isDenied) {
            descargarReporte("../../../../App/Controllers/Central/AlertaC/ReporteC.php", "REPORTE_ALERTAS.xlsx");
        }
    });

    // Agregar evento click al botón personalizado
    document.getElementById('btnRetardos').addEventListener('click', function () {
        descargarReporte("../../../../App/Controllers/Central/AsistenciaC/OtroReporteC.php", "OTRO_REPORTE.xlsx");
        Swal.close(); // Cierra el cuadro de diálogo después de ejecutar la acción
    });
}

function descargarReporte(url, nombreArchivo) {
    fadeIn();
    $.ajax({
        url: url,
        type: 'POST',
        xhrFields: {
            responseType: 'blob' // Configura la respuesta esperada como un blob (archivo binario)
        },
        success: function (data) {
            console.log(data)
            if (data.size > 0) {
                var blob = new Blob([data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = nombreArchivo;
                document.body.appendChild(link);
                link.click();
                window.URL.revokeObjectURL(link.href);
                document.body.removeChild(link);
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


