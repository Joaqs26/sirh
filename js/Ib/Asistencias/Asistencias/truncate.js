$(document).ready(function () {
    
    $("#truncatetable").click(function () {
        truncatetable();
    });
});

// Función para truncar la tabla
function truncatetable() {
    if (confirm("¿Estás seguro de que deseas eliminar los datos de Asistencias, Retardos y Faltas?")) {
        $.ajax({
            url: "../../../../App/Controllers/Central/AsistenciaC/truncate.php",
            type: "POST",
            success: function (response) {
               
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
