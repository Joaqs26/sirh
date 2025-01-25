var notyf = new Notyf({
    position: {
        x: 'right',
        y: 'top',
    },
    dismissible: true, // Permite que las notificaciones sean cerrables
    duration: 3000, // Duración predeterminada de las notificaciones en milisegundos (opcional)
});

var mensajeSalida = 'Se produjo un error al ejecutar la acción';

function buscarInfoEmpleado(id_tbl_empleados_hraes) {
    let nombreResult = document.getElementById("nombreResult");
    let numEmpleadoResult = document.getElementById("numEmpleadoResult");
    let curpResult = document.getElementById("curpResult");
    let rfcResult = document.getElementById("rfcResult");
    let primerA = document.getElementById("primerA");
    let segundoA = document.getElementById("segundoA");
    let codPuesto = document.getElementById("codPuesto");
    let isNivel = document.getElementById("isNivel");
    let nomPuesto = document.getElementById("nomPuesto");

    let numPlaza = document.getElementById("numPlaza");
    let isClue = document.getElementById("isClue");
    let zonaPag = document.getElementById("zonaPag");

    $.post('../../../../App/Controllers/Central/EmpleadoC/InformacionC.php', {
        id_tbl_empleados_hraes: id_tbl_empleados_hraes
    },
        function (data) {
            console.log(data);
            let jsonData = JSON.parse(data);
            let nombre_ = jsonData.nombre;
            let curp_ = jsonData.curp;
            let rfc_ = jsonData.rfc;
            let noEmpleado_ = jsonData.noEmpleado;
            let primerA_ = jsonData.primerA;
            let segundoA_ = jsonData.segundoA;
            let codPuesto_ = jsonData.codPuesto;
            let isNivel_ = jsonData.isNivel;
            let nomPuesto_ = jsonData.nomPuesto;

            let numPlaza_ = jsonData.numPlaza;
            let isClue_ = jsonData.isClue;
            let zonaPag_ = jsonData.zonaPag;

            nombreResult.textContent = nombre_;
            numEmpleadoResult.textContent = noEmpleado_;
            curpResult.textContent = curp_;
            rfcResult.textContent = rfc_;
            primerA.textContent = primerA_;
            segundoA.textContent = segundoA_;
            codPuesto.textContent = codPuesto_;
            isNivel.textContent = isNivel_;
            nomPuesto.textContent = nomPuesto_;

            numPlaza.textContent = numPlaza_;
            isClue.textContent = isClue_;
            zonaPag.textContent = zonaPag_;
        }
    );
}

function iniciarAsistencia() {
    iniciarConfAsistencia();
    buscarAsistencia();
}

function iniciarEscolaridad() {
    buscarEstudio();//ok
    //buscarCedula();//ok
    buscarEspecialidad();//ok
}

function iniciarMediosContacto() {
    //mensajetextLar('El usuario debe verificar que todos los campos estén completos, incluyendo el domiclio (código postal fiscal) y la forma de pago (cuenta clabe).');
    buscarNumTelefonico();//ok
    buscarCorreo(); //ok
    buscarDependiente();//ok
    buscarEmergencia();//ok
}

function iniciarMovimiento() {
    buscarMovimiento();//ok
    // buscarJefe();
    iniciarAdicional();
}

function iniciarPersonalBancario() {
    buscarFormaPago(); // ok
    buscarJefe(); //ok
    iniciarDomicilio(); //ok
    buscarCapacidadesDif();//ok
    buscarLengua();
}

function iniciarProgramas() {
    buscarJuguete(); // pendiente
    //iniciarCampos();
}

function iniciarIncidencias() {
    buscarRetardo();//ok
}

function iniciarPercepciones() {
    buscarPercepcion();//ok
    buscarQuinquenio();
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

function mensajetextLar(text) {
    Swal.fire({
        title: "USUARIO",
        text: text,
        icon: "warning"
    });
}