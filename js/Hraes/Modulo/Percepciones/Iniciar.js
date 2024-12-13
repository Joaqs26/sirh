var id_tbl_empleados_hraes = document.getElementById('id_tbl_empleados_hraes').value;

function buscarPercepcion(){ //BUSQUEDA
    let buscarNew = clearElement(buscar_pe);
    let buscarlenth = lengthValue(buscarNew);
    
    if (buscarlenth == 0){
        iniciarTabla_pe(null, iniciarBusqueda_pe(),id_tbl_empleados_hraes);
    } else {
        iniciarTabla_pe(buscarNew, iniciarBusqueda_pe(),id_tbl_empleados_hraes);
    }
}

function iniciarTabla_pe(busqueda, paginador, id_tbl_empleados_hraes) { 
    $.post('../../../../App/View/Hraes/Modulo/Percepciones/tabla.php', {
        busqueda: busqueda, 
        paginador: paginador, 
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            $("#tabla_percepciones").html(data); 
        }
    );
}

function agregarEditarPercepcion(id_object){
    $("#id_object").val(id_object);
    let titulo = document.getElementById("titulo_percepcion");
    titulo.textContent = 'Modificar';
    $("#id_object").val(id_object);
    if (id_object == null){
        titulo.textContent = 'Agregar';
        $("#agregar_editar_percepcion").find("input,textarea,select").val("");
    }

    $.post("../../../../App/Controllers/Hrae/PercepcionesC/DetallesC.php", {
        id_object: id_object,
    },
        function (data) {
            let jsonData = JSON.parse(data);
            let entity = jsonData.response; 
            let concepto = jsonData.concepto;
            let valor = jsonData.valor;  

            $('#id_cat_concepto').empty();
            $('#id_cat_concepto').html(concepto); 
            $('#id_cat_valores').empty();
            $('#id_cat_valores').html(valor); 

            $('#id_cat_concepto').selectpicker('refresh');
            $('#id_cat_valores').selectpicker('refresh');
            $('.selectpicker').selectpicker();
        }
    );

    $("#agregar_editar_percepcion").modal("show");
}

function salirAgregarEditarPercepciones(){
    $("#agregar_editar_percepcion").modal("hide");
}


function agregarEditarByDbByPercepcion() {
    let id_cat_valores = $("#id_cat_valores").val();
    let id_object = $("#id_object").val();

    $.post("../../../../App/Controllers/Hrae/PercepcionesC/AgregarEditarC.php", {
        id_object: id_object,
        id_cat_valores: id_cat_valores,
        id_tbl_empleados_hraes:id_tbl_empleados_hraes,
    },
        function (data) {
            if (data == 'edit'){
                notyf.success('Concepto modificado con éxito');
            } else if (data == 'add') {
                notyf.success('Concepto agregado con éxito');  
            } else {
                notyf.error(mensajeSalida);
            }
            $("#agregar_editar_percepcion").modal("hide");
            buscarPercepcion();
        }
    );
}


function eliminarConcepto(id_object) {
    Swal.fire({
        title: "¿Está seguro?",
        text: "¡No podrás revertir esto!",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#235B4E",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
        $.post("../../../../App/Controllers/Hrae/PercepcionesC/EliminarC.php", {
                id_object: id_object
            },
            function (data) {
                if (data == 'delete'){
                    notyf.success('concepto eliminado con éxito')
                } else {
                    notyf.error(mensajeSalida);
                }
                buscarPercepcion();
            }
        );
    }
    });
}
