$(document).ready(function () {
    console.log("Script truncate.js cargado correctamente");

    $("#truncatetable").click(function () {
        truncatetable();
    });
});

// Función para truncar la tabla
function truncatetable() {
    if (confirm("¿Seguro que deseas truncar la tabla?")) {
        $.ajax({
            url: "../../../../App/Controllers/Central/AsistenciaC/truncate.php",
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
