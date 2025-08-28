<!-- MODALE_UPLOAD_FALTA -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="modal_mail">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-2">
                            <img src="../../../../assets/sirh/logo_carga_masiva.png" style="max-width: 100%;">
                        </div>
                        <div class="col-10">
                            <h1 style="color:white; font-family: 'Montserrat'; font-size: 40px;">Plantilla para correo
                                electrónico</h1>
                            <p style="color:white;">Copia el contenido de la siguiente plantilla en el correo que deseas
                                enviar. Esta plantilla corresponde a las faltas registradas durante la quincena en la
                                que se generó la incidencia.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="correoContenido">
                <div class="div-spacing"></div>
                <div class="card-body"
                    style="font-family: Arial, sans-serif; font-size: 16px; line-height: 1.6; text-align: justify; padding: 30px;">

                    <p><strong>Referente a la circular <span
                                style="font-weight:bold;">UAF-CRH-6065-2024</span>,</strong>
                        con fecha de 19 de diciembre de 2024, mediante la cual se informa sobre el registro en
                        biométrico al
                        personal IMSS-BIENESTAR adscrito a oficinas centrales; me permito informarle lo siguiente:</p>

                    <p>
 <p>
  Con la finalidad de esclarecer su situación respecto a las incidencias de las que se tienen
  registro en la asistencia de su jornada laboral en la <strong>primera quincena de julio</strong>; para
  cualquier aclaración, deberá presentarse
  <span id="selector-fechas" class="selector-fechas">
    <input type="date" id="fecha1" class="date-input" aria-label="Fecha 1">
    <span id="conector" class="mx-1 d-none">y</span>
    <input type="date" id="fecha2" class="date-input" aria-label="Fecha 2 (opcional)">
    <span id="previewFechas" class="ml-2 text-muted">(elige una o dos fechas)</span>
  </span>;
  en la <strong>Oficina de Control de Asistencia</strong>, ubicada en Gustavo E. Campa No. 54, Colonia
  Guadalupe Inn, piso 3, a un costado de las escaleras de emergencia; en un horario de 9:00 a
  15:00 y de 17:00 a 19:00 horas. Cabe mencionar que <strong>son las únicas fechas para recepción y
  atención de las mismas</strong>.
</p>

                   <p>Es importante que acuda con las incidencias que <strong>se hayan entregado en tiempo y
                            forma</strong>
                        que justifiquen las omisiones que obran en su registro como se detallan a continuación:</p>

                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                            <thead>
                                <tr style="background-color: #28a745;">
                                    <th style="color: white; font-weight: bold; padding: 10px; border: 1px solid #ddd;">
                                        PUESTO</th>
                                    <th style="color: white; font-weight: bold; padding: 10px; border: 1px solid #ddd;">
                                        NOMBRE</th>
                                    <th style="color: white; font-weight: bold; padding: 10px; border: 1px solid #ddd;">
                                        FECHA</th>
                                    <th style="color: white; font-weight: bold; padding: 10px; border: 1px solid #ddd;">
                                        HORA
                                    </th>
                                    <th style="color: white; font-weight: bold; padding: 10px; border: 1px solid #ddd;">
                                        ESTATUS</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyFaltasEmail"></tbody>

                        </table>
                    </div>

                    <div style="text-align: center; margin-top: 40px;">
                        <p style="margin: 0; font-weight: bold;">A T E N T A M E N T E</p>
                        <br>
                        <br>
                        <br>
                        <p style="margin: 0; font-weight: bold;">CONTROL DE ASISTENCIA</p>
                    </div>
                </div>
                <br>

                <div class="div-spacing"></div>
                <div class="modal-footer" style="justify-content: center;">
                    <button onclick="ocultarModalEmail();" type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-check"></i> Copiar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/sirh/js/Ib/Asistencias/Falta/Mail.js"></script>
