function buscaAnden(v) { var f = getForm("conf_estacion"); f.id_estacion.value = v; f.submit(); }
function buscaLinea(v) { var f = getForm("conf_estacion"); f.id_estacion.value = v; f.id_linea.value = v; f.submit(); }

function confirmaGuardar(form) {
    bootbox.confirm({
        message: "¿Guardar la información del andén?",
        buttons: { confirm: { label: 'Sí', className: 'btn-success' }, cancel: { label: 'No', className: 'btn-danger' } }, callback: function (r) { if (r) { form.accion.value = 'guardarAnden'; form.submit(); } }
    });
}

function confirmaBorrar(form) {
	bootbox.confirm({
        message: "¿Borrar el andén de la estación?",
        buttons: { confirm: { label: 'Sí', className: 'btn-success' }, cancel: { label: 'No', className: 'btn-danger' } }, callback: function (r) { if (r) { form.accion.value = 'borrarAnden'; form.submit(); } }
    });
}
