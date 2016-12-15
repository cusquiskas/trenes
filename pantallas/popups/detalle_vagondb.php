     <div id="modalGestionVagonDB" class="modal fade" role="dialog">
      <div class="modal-dialog">
	<div class="modal-content" style="width:600px;">
	  <form role="form" method="post" name="frmDetalle">
	  <div class="modal-header btn-primary">
	   <h4 class="modal-title">
	   	<span id="spaNomVagonDB" style="display: inline">Detalle Libre/Instrucciones</span>
	   </h4>
	   <input class="form-control" name="inpNomVagonDB" id="inpNomVagonDB" value="" style="display: none; ">
	  </div>
	  
	  <div class="modal-body">
	    <textarea rows="20" cols="68" name="inpInstDB" id="inpInstDB" style="display: none; font-family:Courier New, monospace;"></textarea>
	    <span id="spaInstDB" style="display:inline; overflow:auto;"></span>
	  </div>
	  <div class="modal-footer">
	    <input type="hidden" id="id_vagon" value="">
	    <button id="btnDividir" style="display:none" type="button" class="btn btn-warning" onClick="guardar('secuencia')">Secuencia SQL</button>
	    <button id="btnGuardar" style="display:none" type="button" class="btn btn-warning" onClick="guardar('procedimiento')">Procedimiento</button>
	    <button id="btnEditar" style="display:inline" type="button" class="btn btn-success" onClick="editar()">Editar</button>
	    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	  </div>
	 </form> 
	</div>
      </div>
    </div>

    <script>
		function guardar(accion) {
			invocaAjax({
				direccion:'/trenes/controlador/detalleDB.php',
				parametros:{
					xchn:'JSON',id_vagon:getId('id_vagon').value, accion:accion,
					tx_referencia:getId('inpNomVagonDB').value,
					instrucciones:getId('inpInstDB').value
				},
				retorno: function (s,d,e) {
	 						if (s) {
								getForm('frmDetalle').submit();
	 		 	 	 		} else {
	 	 	 				    bootbox.alert({title:'Error en la recuperación del vagón',message:d.error});
	 	 	 				} 
					     }
			});
		}
    
		function abrir(vDB) {
			getId('spaNomVagonDB').style.display='inline';
			getId('spaInstDB').style.display='inline';
			getId('btnEditar').style.display='inline';
			
			getId('inpNomVagonDB').style.display='none';
			getId('inpInstDB').style.display='none';
			getId('btnDividir').style.display='none';
			getId('btnGuardar').style.display='none';

			getId('spaNomVagonDB').innerHTML = "";
			getId('inpNomVagonDB').value = "";
			getId('spaInstDB').innerHTML = "";
			getId('inpInstDB').value = "";

			getId('id_vagon').value = vDB;

			invocaAjax({
				direccion:'/trenes/controlador/detalleDB.php',
				parametros:{xchn:'JSON',id_vagon:vDB, accion:'recuperacion'},
				retorno: function (s,d,e) {
	 						if (s) {
								var cad="",i;
								for (i=0; i<d.root.dato.length; i++) {
									getId('spaNomVagonDB').innerHTML = d.root.referencia;
									getId('inpNomVagonDB').value = d.root.referencia;
									getId('spaInstDB').innerHTML+= "<pre>"+d.root.dato[i].tx_fila+"</pre>";
	 								getId('inpInstDB').value+= d.root.dato[i].tx_fila.replace(/<br\s*[\/]?>/gi, "\n")+";\n\n";
	 								$("#modalGestionVagonDB").modal();	
								}
	 		 	 	 		} else {
	 	 	 				    bootbox.alert({title:'Error en la recuperación del vagón',message:d.error});
	 	 	 				} 
					     }
			});
		}

		function editar() {
			getId('spaNomVagonDB').style.display='none';
			getId('spaInstDB').style.display='none';
			getId('btnEditar').style.display='none';
			
			getId('inpNomVagonDB').style.display='inline';
			getId('inpInstDB').style.display='inline';
			getId('btnDividir').style.display='inline';
			getId('btnGuardar').style.display='inline';
		}
    </script>