// C:\xampp\htdocs\sirh\js\Ib\Asistencias\Falta\Mail.js
(function (window, $) {
  'use strict';

  // ===== Namespace / BASE centralizado (sin colisiones) =====
  window.SIRH = window.SIRH || {};
  window.SIRH.BASE = window.SIRH.BASE || (window.location.origin + '/sirh');
  const BASE = window.SIRH.BASE;

  // ===== ENDPOINTS =====
  const URL_FALTAS_EMAIL = BASE + '/App/Controllers/Central/FaltaC/faltas_email.php';

  // ===== Utils de formato =====
  function fmtDDMMYYYY(isoDate) {
    if (!isoDate) return '';
    const [y, m, d] = isoDate.split('-');
    return `${d}/${m}/${y}`;
  }
  function fmtHHMM(hhmmss) {
    if (!hhmmss) return '';
    return hhmmss.slice(0, 5);
  }

  // ===== Construcción de HTML a copiar =====
  function construirHTMLCorreo() {
    const cont = document.getElementById('correoContenido');
    if (!cont) throw new Error('No se encontró #correoContenido');

    // Clonar el contenido visible
    const clone = cont.cloneNode(true);

    // Reemplazar el selector de fechas por la frase
    const selector = clone.querySelector('#selector-fechas');
    if (selector) selector.outerHTML = construirFraseFechas();

    // Quitar el preview
    const prev = clone.querySelector('#previewFechas');
    if (prev) prev.remove();

    // Documento HTML completo (para pegar con formato)
    return `
<!DOCTYPE html><html><head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;background:#fff;">
  <div style="font-family:Arial,Helvetica,sans-serif;font-size:16px;line-height:1.6;color:#1f2d3d;">
    ${clone.innerHTML}
  </div>
</body></html>`.trim();
  }

  // ===== Copiar HTML robusto (HTTPS AsyncClipboard -> DIV contenteditable -> textarea) =====
  function copyHtmlToClipboard(html) {
  // aseguramos foco en el documento
  if (document.activeElement) document.activeElement.blur();

  const el = document.createElement('div');
  el.contentEditable = 'true';
  el.style.position = 'fixed';
  el.style.left = '-9999px';
  el.style.top = '0';
  // importante: innerHTML para conservar FORMATO
  el.innerHTML = html;
  document.body.appendChild(el);

  const range = document.createRange();
  range.selectNodeContents(el);
  const sel = window.getSelection();
  sel.removeAllRanges();
  sel.addRange(range);

  let ok = false;
  try {
    ok = document.execCommand('copy');
  } catch (e) {
    ok = false;
  }

  sel.removeAllRanges();
  document.body.removeChild(el);
  return ok;
}

// ===== Copiar HTML robusto (compatible con Debian/Windows) =====
function ocultarModalEmail2() {
  const cont = document.getElementById('correoContenido');
  if (!cont) {
    alert('No se encontró #correoContenido');
    return;
  }

  // clonar y sustituir el selector de fechas por la frase
  const clone = cont.cloneNode(true);
  const selector = clone.querySelector('#selector-fechas');
  if (selector) selector.outerHTML = construirFraseFechas();
  const prev = clone.querySelector('#previewFechas');
  if (prev) prev.remove();

  const html = `
<!DOCTYPE html><html><head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;background:#fff;">
  <div style="font-family:Arial,Helvetica,sans-serif;font-size:16px;line-height:1.6;color:#1f2d3d;">
    ${clone.innerHTML}
  </div>
</body></html>`.trim();

  // Texto plano alternativo
  const plainText = html
    .replace(/<style[\s\S]*?<\/style>/gi, '')
    .replace(/<[^>]+>/g, ' ')
    .replace(/\s+/g, ' ')
    .trim();

  // 1) Intento con API moderna async (si está disponible)
  if (navigator.clipboard && window.ClipboardItem) {
    try {
      const htmlBlob = new Blob([html], { type: 'text/html' });
      const textBlob = new Blob([plainText], { type: 'text/plain' });
      
      const data = [
        new ClipboardItem({
          'text/html': htmlBlob,
          'text/plain': textBlob
        })
      ];
      
      navigator.clipboard.write(data).then(() => {
        if (window.notyf) notyf.success('Contenido copiado con formato');
        $('#modal_mail').modal('hide');
      }).catch(async (err) => {
        console.warn('Clipboard API failed, trying fallback:', err);
        // Fallback a método sincrónico
        if (fallbackCopy(html)) {
          if (window.notyf) notyf.success('Contenido copiado');
          $('#modal_mail').modal('hide');
        } else {
          throw new Error('Fallback also failed');
        }
      });
    } catch (err) {
      console.warn('ClipboardItem failed, trying fallback:', err);
      if (fallbackCopy(html)) {
        if (window.notyf) notyf.success('Contenido copiado');
        $('#modal_mail').modal('hide');
      } else {
        if (window.notyf) notyf.error('No se pudo copiar el contenido');
      }
    }
    return;
  }

  // 2) Método fallback para navegadores más antiguos
  if (fallbackCopy(html)) {
    if (window.notyf) notyf.success('Contenido copiado');
    $('#modal_mail').modal('hide');
  } else {
    // 3) Último recurso: copiar como texto plano
    copyPlainText(plainText);
  }
}

// Función auxiliar para copiado fallback
function fallbackCopy(html) {
  try {
    // Crear elemento editable temporal
    const tempElement = document.createElement('div');
    tempElement.contentEditable = 'true';
    tempElement.style.position = 'fixed';
    tempElement.style.left = '-9999px';
    tempElement.style.top = '0';
    tempElement.innerHTML = html;
    document.body.appendChild(tempElement);

    // Seleccionar contenido
    const range = document.createRange();
    range.selectNodeContents(tempElement);
    const selection = window.getSelection();
    selection.removeAllRanges();
    selection.addRange(range);

    // Intentar copiar
    const success = document.execCommand('copy');
    
    // Limpiar
    selection.removeAllRanges();
    document.body.removeChild(tempElement);
    
    return success;
  } catch (err) {
    console.error('Fallback copy failed:', err);
    return false;
  }
}

// Función para copiar texto plano
function copyPlainText(text) {
  try {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-9999px';
    textArea.style.top = '0';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    const success = document.execCommand('copy');
    document.body.removeChild(textArea);
    
    if (success) {
      if (window.notyf) notyf.success('Contenido copiado (solo texto)');
      $('#modal_mail').modal('hide');
    } else {
      if (window.notyf) notyf.error('Error al copiar');
    }
    return success;
  } catch (err) {
    console.error('Plain text copy failed:', err);
    if (window.notyf) notyf.error('Error crítico al copiar');
    return false;
  }
}
  // ===== Render/errores de la tabla =====
  function renderFaltasEmail(resp) {
    const tb = document.getElementById('tbodyFaltasEmail');
    if (!tb) return;

    if (!resp || resp.ok !== true) {
      tb.innerHTML = `<tr><td colspan="5" style="padding:10px;border:1px solid #ddd;text-align:center;color:#c00;">
        ${(resp && resp.msg) || 'Sin registros'}
      </td></tr>`;
      return;
    }
    if (!Array.isArray(resp.faltas) || resp.faltas.length === 0) {
      tb.innerHTML = `<tr><td colspan="5" style="padding:10px;border:1px solid #ddd;text-align:center;">Sin registros</td></tr>`;
      return;
    }

    let html = '';
    resp.faltas.forEach((r) => {
      html += `
        <tr>
          <td style="padding:10px;border:1px solid #ddd;">${r.puesto || ''}</td>
          <td style="padding:10px;border:1px solid #ddd;">${r.nombre || '—'}</td>
          <td style="padding:10px;border:1px solid #ddd;">${fmtDDMMYYYY(r.fecha)}</td>
          <td style="padding:10px;border:1px solid #ddd;">${fmtHHMM(r.hora)}</td>
          <td style="padding:10px;border:1px solid #ddd;">${r.estatus || ''}</td>
        </tr>`;
    });
    tb.innerHTML = html;
  }

  function ajaxErrorFaltasEmail(xhr) {
    console.error('AJAX error', xhr?.status, xhr?.responseText);
    const tb = document.getElementById('tbodyFaltasEmail');
    if (tb)
      tb.innerHTML = `<tr><td colspan="5" style="padding:10px;border:1px solid #ddd;text-align:center;color:#c00;">Error al cargar</td></tr>`;
  }

  // ===== Contexto del modal (para re-filtrar) =====
  let _ctxMail = { idEmpleado: null, idFalta: null };

  // ===== Rango de fechas (filtros superiores) =====
  function getRangoFiltroFechas() {
    const desde = document.getElementById('filtro_desde')?.value || '';
    const hasta = document.getElementById('filtro_hasta')?.value || '';
    return { desde, hasta };
  }

  // ===== Abrir modal por falta =====
  function showMail(idFalta) {
    _ctxMail = { idEmpleado: null, idFalta: Number(idFalta) };

    const tbody = document.getElementById('tbodyFaltasEmail');
    if (tbody)
      tbody.innerHTML = `<tr><td colspan="5" style="padding:10px;border:1px solid #ddd;text-align:center;">Cargando...</td></tr>`;

    $('#modal_mail').modal('show');
    ensureSelectorFechasInit(); // para la frase de fechas del cuerpo

    const { desde, hasta } = getRangoFiltroFechas();

    $.ajax({
      url: URL_FALTAS_EMAIL,
      type: 'POST',
      dataType: 'json',
      data: { id_falta: Number(idFalta), desde, hasta },
      success: renderFaltasEmail,
      error: ajaxErrorFaltasEmail,
    });
  }

  // ===== Abrir modal por empleado =====
  function showMailEmpleado(idEmpleado) {
    _ctxMail = { idEmpleado: Number(idEmpleado), idFalta: null };

    const tbody = document.getElementById('tbodyFaltasEmail');
    if (tbody)
      tbody.innerHTML = `<tr><td colspan="5" style="padding:10px;border:1px solid #ddd;text-align:center;">Cargando...</td></tr>`;

    $('#modal_mail').modal('show');
    ensureSelectorFechasInit();

    const { desde, hasta } = getRangoFiltroFechas();

    $.ajax({
      url: URL_FALTAS_EMAIL,
      type: 'POST',
      dataType: 'json',
      data: { id_empleado: Number(idEmpleado), desde, hasta },
      success: renderFaltasEmail,
      error: ajaxErrorFaltasEmail,
    });
  }

  // ===== Botón "Buscar" (re-filtrar sin cerrar modal) =====
  document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('btnFiltrarFaltas');
    if (!btn) return;

    btn.addEventListener('click', () => {
      const { desde, hasta } = getRangoFiltroFechas();
      const tb = document.getElementById('tbodyFaltasEmail');
      if (tb)
        tb.innerHTML = `<tr><td colspan="5" style="padding:10px;border:1px solid #ddd;text-align:center;">Cargando...</td></tr>`;

      const payload = { desde, hasta };
      if (_ctxMail.idEmpleado) payload.id_empleado = _ctxMail.idEmpleado;
      if (_ctxMail.idFalta) payload.id_falta = _ctxMail.idFalta;

      $.ajax({
        url: URL_FALTAS_EMAIL,
        type: 'POST',
        dataType: 'json',
        data: payload,
        success: renderFaltasEmail,
        error: ajaxErrorFaltasEmail,
      });
    });
  });

  // ===== Selector de fechas (dentro del CUERPO del correo) =====
  const MESES_ES = [
    'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
    'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
  ];

  function _getFecha(id) {
    const v = document.getElementById(id)?.value;
    if (!v) return null;
    const [y, m, d] = v.split('-').map(Number);
    if (!y || !m || !d) return null;
    return new Date(y, m - 1, d);
  }
  function _fmtLargo(d) {
    return `${d.getDate()} de ${MESES_ES[d.getMonth()]} de ${d.getFullYear()}`;
  }
  function construirFraseFechas() {
    let f1 = _getFecha('fecha1');
    let f2 = _getFecha('fecha2');

    if (!f1 && !f2) return 'los días <strong>—</strong>';

    if (f1 && f2 && f2 < f1) {
      const t = f1; f1 = f2; f2 = t;
    }
    if (f1 && (!f2 || f1.getTime() === f2.getTime())) {
      return `el día <strong>${_fmtLargo(f1)}</strong>`;
    }
    if (f1 && f2) {
      const mismoMesYAño =
        f1.getMonth() === f2.getMonth() && f1.getFullYear() === f2.getFullYear();
      if (mismoMesYAño) {
        return `los días <strong>${f1.getDate()} y ${f2.getDate()} de ${MESES_ES[f1.getMonth()]} de ${f1.getFullYear()}</strong>`;
      }
      return `los días <strong>${_fmtLargo(f1)} y ${_fmtLargo(f2)}</strong>`;
    }
    return 'los días <strong>—</strong>';
  }

  function _onFechasChange() {
    const prev = document.getElementById('previewFechas');
    if (prev) prev.innerHTML = construirFraseFechas();

    const c = document.getElementById('conector');
    const v1 = document.getElementById('fecha1')?.value;
    const v2 = document.getElementById('fecha2')?.value;
    const showY = !!(v1 && v2 && v1 !== v2);
    if (c) c.classList.toggle('d-none', !showY);
  }

  let _fechasInit = false;
  function ensureSelectorFechasInit() {
    if (!_fechasInit) {
      ['fecha1', 'fecha2'].forEach((id) => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('change', _onFechasChange);
      });
      _fechasInit = true;
    }
    _onFechasChange();
  }

  // ===== Exponer funciones necesarias al global (las usa el HTML) =====
  window.showMail = showMail;
  window.showMailEmpleado = showMailEmpleado;
  window.ocultarModalEmail2 = ocultarModalEmail2;

})(window, window.jQuery);
