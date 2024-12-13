function validarDomicilio(){
    let codigo_postal = document.getElementById('codigo_postal1').value;
    let municipio1 = document.getElementById('municipio1').value;
    let colonia1 = document.getElementById('colonia1').value;
    let calle1 = document.getElementById('calle1').value;
    let codigo_postal2 = document.getElementById('codigo_postal2').value;
    let num_exterior1 = document.getElementById('num_exterior1').value;

    if(validarData(codigo_postal,'Código postal') &&
       validarData(municipio1,'Municipio') &&
       validarData(colonia1,'Colonia') &&
       validarData(calle1,'Calle') &&
       validarData(num_exterior1,'Núm. exterior')){
        if(codigo_postal2.length == 5){
            validaCodigoFiscal();
        } else {
            notyf.error('Código postal fiscal debe tener 5 caracteres');
        }
    } 
}

function buscarInfor(){
    let codigo_postal = document.getElementById('codigo_postal1').value.trim();
    $.post("../../../../App/Controllers/Hrae/DomicilioC/CodigoPostalC.php", {
        codigo_postal: codigo_postal
    },
        function (data) {
            var jsonData = JSON.parse(data);
            var municipio = jsonData.municipio;
            var colonia = jsonData.colonia; 
            var entidad = jsonData.entidad; 
            var pais = jsonData.pais;

            $('#municipio1').empty();
            $('#municipio1').html(municipio);
            $('#colonia1').empty();
            $('#colonia1').html(colonia);  
            $("#entidad1").val(entidad);
            $("#pais_f").val(pais);
            
            $('#colonia1').selectpicker('refresh');
            $('#municipio1').selectpicker('refresh');
            $('.selectpicker').selectpicker();
        }
    );
}

document.getElementById("municipio1").addEventListener("change", function() {
    let municipio1 = this.value;
    $.post("../../../../App/Controllers/Hrae/DomicilioC/ColoniaC.php", {
        municipio1: municipio1,
    },
        function (data) {
            var jsonData = JSON.parse(data);
            var colonia = jsonData.colonia; 

            $('#colonia1').empty();
            $('#colonia1').html(colonia); 
            
            $('#colonia1').selectpicker('refresh');
            $('.selectpicker').selectpicker();
        }
    );
  });



  function validaCodigoFiscal(){
    let codigo_postal = document.getElementById('codigo_postal2').value.trim();
    $.post("../../../../App/Controllers/Hrae/DomicilioC/CodigoPostalC.php", {
        codigo_postal: codigo_postal
    },
        function (data) {
            let jsonData = JSON.parse(data);
            let entidad = jsonData.entidad; 

            if (entidad == 'No encontrado'){
                messageErrorLarge('El código postal fiscal no se encuentra registrado en nuestra base de datos. Para resolver este problema, te recomendamos comunicarte con tu administrador para actualizar la información correcta.')
            } else {
                guardarDomicilio();
            }
        }
    );
}

