function getReporteAsistencia() {
    Swal.fire({
        title: "Selecciona el rango de fechas",
        html: `
            <div style="text-align:left;">
                <label><b>Fecha inicio:</b></label>
                <input type="date" id="fecha_inicio" class="swal2-input">
                <label><b>Fecha fin:</b></label>
                <input type="date" id="fecha_fin" class="swal2-input">
            </div>
        `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Continuar",
        cancelButtonText: "Cancelar",
        customClass: {
            confirmButton: 'swal2-confirm-color',
            cancelButton: 'swal2-cancel-color'
        },
        preConfirm: () => {
            const fecha_inicio = document.getElementById('fecha_inicio').value;
            const fecha_fin = document.getElementById('fecha_fin').value;

            if (!fecha_inicio || !fecha_fin) {
                Swal.showValidationMessage("Debes ingresar ambas fechas");
                return false;
            }
            return { fecha_inicio, fecha_fin };
        }
    }).then((result) => {
        if (!result.isConfirmed) return;

        const { fecha_inicio, fecha_fin } = result.value;

        Swal.fire({
            title: "¿Qué reporte deseas descargar?",
            icon: "question",
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
                <button id="btnKardex" class="swal2-confirm swal2-styled" 
                    style="background-color: #235B4E; margin-top: 10px;">
                    Reporte Kardex
                </button>
            `
        }).then((res) => {
            if (res.isConfirmed) {
                descargarReporteConFechas("../../../../App/Controllers/Central/AsistenciaC/ReporteC.php", "REPORTE_FALTAS.xlsx", fecha_inicio, fecha_fin);
            } else if (res.isDenied) {
                descargarReporteConFechas("../../../../App/Controllers/Central/AlertaC/ReporteC.php", "REPORTE_ALERTAS.xlsx", fecha_inicio, fecha_fin);
            }
        });

        // Botón para Reporte de Retardos
        Swal.getPopup().querySelector('#btnRetardos').addEventListener('click', function () {
            descargarReporteConFechas("../../../../App/Controllers/Central/RetardoC/ReporteC.php", "REPORTE_RETARDOS.xlsx", fecha_inicio, fecha_fin);
            Swal.close();
        });

        // Botón para Reporte Kardex
        Swal.getPopup().querySelector('#btnKardex').addEventListener('click', function () {
            descargarReporteConFechas("../../../../App/Controllers/Central/RetardoC/Reportekardex.php", "REPORTE_KARDEX.xlsx", fecha_inicio, fecha_fin);
            Swal.close();
        });
    });
}

function descargarReporteConFechas(url, nombreArchivo, fechaInicio, fechaFin) {
    fadeIn();
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            fecha_inicio: fechaInicio,
            fecha_fin: fechaFin
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function (data) {
            if (data.size > 0) {
                const blob = new Blob([data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = nombreArchivo;
                document.body.appendChild(link);
                link.click();
                window.URL.revokeObjectURL(link.href);
                document.body.removeChild(link);
                notyf.success('El reporte se generó exitosamente');
            } else {
                notyf.error('Error: el archivo está vacío');
            }
            fadeOut();
        },
        error: function () {
            notyf.error('Error al generar el reporte');
            fadeOut();
        }
    });
}
