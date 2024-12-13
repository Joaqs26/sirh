var notyf = new Notyf({
    position: {
        x: 'right',
        y: 'top',
    },
    dismissible: true, // Permite que las notificaciones sean cerrables
    duration: 3000, // Duración predeterminada de las notificaciones en milisegundos (opcional)
});

var mensajeSalida = 'Se produjo un error al ejecutar la acción';

$(document).ready(function () {
    buscarEmpleado();
    $('[data-toggle="tooltip"]').tooltip();
});

function buscarEmpleado(){ //BUSQUEDA
    let buscarNew = clearElement(buscar);
    let buscarlenth = lengthValue(buscarNew);
    
    if (buscarlenth == 0){
        iniciarTablaEmpleados(null, iniciarBusqueda());
    } else {
        iniciarTablaEmpleados(buscarNew, iniciarBusqueda());
    }
}

function iniciarTablaEmpleados(busqueda, paginador) { ///INGRESA LA TABLA
    $.ajax({
        type: 'POST',
        url: '../../../../App/View/Hraes/Empleados/tabla.php',
        data: { 
            busqueda: busqueda,
            paginador:paginador 
        },
        success: function (data) {
            $('#tabla_empleados').html(data);
        }
    });
}

function agregarEditarDetalles(id_object) { //SE OBTIENEN INFO DE ID SELECCIONADO
    var titulo = document.getElementById("titulo");
    titulo.textContent = 'Modificar';
    $("#id_object").val(id_object);
    if (id_object == null){
        $("#agregar_editar_modal").find("input,textarea,select").val("");
        titulo.textContent = 'Agregar';
    }

    $.post("../../../../App/Controllers/Hrae/EmpleadoC/DetallesC.php", {
        id_object: id_object
    },
        function (data) {
            let jsonData = JSON.parse(data);//se obtiene el json
            let entity = jsonData.response; //Se agrega a emtidad 
            //let genero = jsonData.genero;
            let estadoCivil = jsonData.estadoCivil;
            let pais = jsonData.pais;
            let estado = jsonData.estado;
            let nacionalidad = jsonData.nacionalidad;

            //Empleado
            $('#nacionalidad').empty();
            $('#nacionalidad').html(nacionalidad); 

            $('#id_cat_estado_civil').empty();
            $('#id_cat_estado_civil').html(estadoCivil); 

            $('#id_cat_pais_nacimiento').empty();
            $('#id_cat_pais_nacimiento').html(pais); 

            $('#id_cat_estado_nacimiento').empty();
            $('#id_cat_estado_nacimiento').html(estado); 

            $('#nacionalidad').selectpicker('refresh');
            $('#id_cat_estado_civil').selectpicker('refresh');
            $('#id_cat_pais_nacimiento').selectpicker('refresh');
            $('#id_cat_estado_nacimiento').selectpicker('refresh');
            $('.selectpicker').selectpicker();

            if (entity.curp != null){
                $("#genero_x").val(generoCurp(entity.curp));
            }
            
            $("#nombre").val(entity.nombre);
            $("#rfc").val(entity.rfc);
            $("#primer_apellido").val(entity.primer_apellido);
            $("#curp").val(entity.curp);
            $("#segundo_apellido").val(entity.segundo_apellido);
            $("#nss").val(entity.nss);
            $("#num_empleado").val(entity.num_empleado);

        }
    );

    $("#agregar_editar_modal").modal("show");
}


function agregarEditarByDb() {
    let nombre = $("#nombre").val();
    let rfc = $("#rfc").val();
    let primer_apellido = $("#primer_apellido").val();
    let curp = $("#curp").val();
    let segundo_apellido = $("#segundo_apellido").val();
    let nss = $("#nss").val();
    let id_object = $("#id_object").val();

    $.post("../../../../App/Controllers/Hrae/EmpleadoC/AgregarEditarC.php", {
        id_object: id_object,
        nombre: nombre,
        rfc:rfc,
        primer_apellido:primer_apellido,
        curp:curp,
        segundo_apellido:segundo_apellido,
        nss:nss,
        id_cat_estado_civil:$("#id_cat_estado_civil").val(),
        //id_cat_genero:$("#id_cat_genero").val(),
        num_empleado:$("#num_empleado").val(),
        id_cat_pais_nacimiento:$("#id_cat_pais_nacimiento").val(),
        id_cat_estado_nacimiento:$("#id_cat_estado_nacimiento").val(),
        nacionalidad:$("#nacionalidad").val(),
        //pais_nacimiento:$("#pais_nacimiento").val(),
    },
        function (data) {
            if (data == 'edit'){
                notyf.success('Empleado modificado con éxito');
            } else if (data == 'add') {
                notyf.success('Empleado agregado con éxito');  
            } else {
                notyf.error(mensajeSalida);
            }
            $("#agregar_editar_modal").modal("hide");
            buscarEmpleado();
        }
    );
}

function eliminarEntity(id_object) {//ELIMINAR USUARIO
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
        $.post("../../../../App/Controllers/Hrae/EmpleadoC/EliminarC.php", {
                id_object: id_object
            },
            function (data) {
                if (data == 'delete'){
                    notyf.success('Empleado eliminado con éxito')
                } else {
                    notyf.error(mensajeSalida);
                }
                buscarEmpleado();
            }
        );
    }
    });
}


function ocultarModal(){
    $("#agregar_editar_modal").modal("hide");
}

function convertirAMayusculas(event, inputId) {
    let inputElement = document.getElementById(inputId);
    let texto = event.target.value;
    let textoEnMayusculas = texto.toUpperCase();
    inputElement.value = textoEnMayusculas;
  }

  function validarNumero(input) {
    input.value = input.value.replace(/[^\d]/g, '');
  }


  function powerBiRefresh(){
    Swal.fire({
        title: "Power BI Refresh",
        text: "Power BI Refresh se utiliza para actualizar la información en el tablero de Power BI. Este proceso puede tomar unos minutos.",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, continuar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: '#235B4E', 
        cancelButtonColor:'#6c757d',
      }).then((result) => {
        if (result.isConfirmed) {
            fadeIn();
           
        $.post("../../../../App/Controllers/Hrae/EmpleadoC/PowerBiC.php", {
            },
            function (data) {
                fadeOut();
                if (data){
                    notyf.success('Proceso realizado con éxito')
                } else {
                    notyf.error(mensajeSalida);
                }
            }
        );
    }
    });
  }


  function fadeIn(){
    $('#overlay').fadeIn();
  }

  function fadeOut(){
    $('#overlay').fadeOut();
  }