$(document).ready(function () {
   
    $("#truncatetablefr").click(function () {
        truncatetablefr();
    });
});

// Función para truncar la tabla
function truncatetablefr() {
    if (confirm("¿Estás seguro de que deseas eliminar los datos de Retardos y Faltas?")) {
        $.ajax({
            url: "../../../../App/Controllers/Central/AsistenciaC/truncatefr.php",
            type: "POST",
            success: function (response) {
                console.log("✅ Respuesta del servidor:", response);
                let result = JSON.parse(response);
                alert(result.message);
            },
            error: function () {
                console.error("❌ Error al ejecutar la acción.");
                alert("Error al ejecutar la acción.");
            }
        });
    }
}
