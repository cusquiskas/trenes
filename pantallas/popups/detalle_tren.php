<div id="modalGestionTren" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" style="width:600px;">
			<form role="form" method="post" name="frmDetalle">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">
						<span id="spaNomTren" style="display: inline">Información del Tren</span>
					</h4>
				</div>

				<div class="modal-body">
					<span id="inpTxTren" style="display:inline; overflow:auto;">Nombre del tren:</span>
					<input class="form-control" type="text" name="tx_tren" id="inpTxTren" style="font-family:Courier New, monospace;"><br>
                    <span id="inpIdMaqui" style="display:inline; overflow:auto;">Maquinista:
                    <select class="form-control" name="id_maquinista" id="inpIdMaqui">
      				<?php 
      					$maquinista = new Maquinista();
      					$maquinista->setTxActivo('S');
      					$data = $maquinista->listar();
      					foreach ($data as $reg) echo '<option value="'.$reg->getIdMaquinista().'">'.$reg->getPwMaquinista().'</option>'."\n";
      					unset($maquinista);
      				?>
      			    </select><br></span>
                    <span id="inpIdStacion" style="display:none; overflow:auto;">Estación:
                    <select class="form-control" name="id_estacion" id="inpIdStacion">
      				    <option value=""></option>
                    <?php 
      					$estacion = new Estacion();
      					$estacion->setCkInicial(1);
      					$data = $estacion->listar();
      					foreach ($data as $reg) echo '<option value="'.$reg->getIdEstacion().'">'.$reg->getTxEstacion().'</option>'."\n";
      					unset($estacion);
      				?>
      			    </select></span>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id_tren" value="">
                    <input type="hidden" name="accion" value="guardar_tren">
					<button id="btnEditar" style="display:inline" type="button" class="btn btn-success" onClick="guardarTren()">Guardar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</form> 
		</div>
	</div>
</div>

<script>
    function gestionTren(t) {
        $("#modalGestionTren").modal();
        var id_maquinista = '<?php echo $Usuario->getIdMaquinista(); ?>';
        var frm = getForm('frmDetalle');
        if (t == "") {
            muestra(getId('inpIdStacion'));
            frm.reset();
            frm.id_maquinista.value = id_maquinista;

        } else {
            oculta(getId('inpIdStacion'));
            invocaAjax({
                direccion:'/trenes/controlador/detalleTren.php',
                parametros:{
                    xchn:'JSON',id_tren:t, accion:'recuperacion'
                },
                retorno: function (s,d,e) {
                            if (s) {
                                var dat = d.root.dato[0]
                                frm.id_tren.value = dat.id_tren;
                                frm.tx_tren.value = dat.tx_tren;
                                frm.id_maquinista.value = dat.id_maquinista;
                                frm.id_estacion.value = dat.id_estacion;
                            } else {
                                bootbox.alert({title:'Error en la recuperación del tren',message:d.error});
                            } 
                }
            });
        }  
    }
    function guardarTren(){
        getForm('frmDetalle').submit();
    }  
</script>