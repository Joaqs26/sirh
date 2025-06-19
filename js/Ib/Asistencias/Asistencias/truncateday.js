// Confirmar que el JS está cargado y que se detecta el clic
$(document).ready(function () {
    console.log("✅ truncateday.js cargado correctamente");
    $('#truncatetableday').on('click', function () {
        console.log("🟢 Botón clic detectado");
        truncatetableday();
    });
});
// Función global fuera de ready para que esté disponible siempre
function truncatetableday() {
    Swal.fire({
        title: "Eliminar registros por fecha",
        html: `
            <label for="fecha_eliminar"><b>Selecciona la fecha:</b></label>
            <input type="date" id="fecha_eliminar" class="swal2-input">
        `,
        showCancelButton: true,
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar",
        preConfirm: () => {
            const fecha = document.getElementById('fecha_eliminar').value;
            if (!fecha) {
                Swal.showValidationMessage("⚠️ Debes ingresar una fecha válida.");
            }
            return { fecha };
        }
    }).then((result) => {
        if (!result.isConfirmed) return;
        const { fecha } = result.value;
        Swal.fire({
            title: `¿Eliminar registros del ${fecha}?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#d33"
        }).then((confirmacion) => {
            if (!confirmacion.isConfirmed) return;
            $.ajax({
                url: "../../../../App/Controllers/Central/AsistenciaC/truncateday.php",
                type: "POST",
                data: { fecha: fecha },
                success: function (response) {
                    console.log("✅ Respuesta del servidor:", response);
                    try {
                        let result = JSON.parse(response);
                        Swal.fire("✅ Listo", result.message, "success");
                    } catch (e) {
                        Swal.fire("❌ Error", "Respuesta inválida del servidor", "error");
                    }
                },
                error: function () {
                    Swal.fire("❌ Error", "No se pudo completar la petición", "error");
                }
            });
        });
    });
}