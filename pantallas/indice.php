<?php
# esta es la pantalla en la que se muestra la lista de trenes
?>
<div id="modalGestionTren" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" style="width:600px;">
			<form role="form" method="post" name="frmDetalle">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">
						<span id="spaNomTren" style="display: inline">Detalle Libre/Instrucciones</span>
					</h4>
					<input class="form-control" name="inpNomTren" id="inpNomTren" value="" style="display: none; ">
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

<div class="container-fluid text-center">    
	<div class="row content">
    	<div class="col-sm-2 sidenav">
      		<p>
      			<label for="sel1">Maquinista:</label> 
      			<select class="form-control" onChange="buscaMaq(value)" id="sel1">
      				<option value="">.. Todos ..</option>
      				<?php 
      					$maquinista = new Maquinista();
      					$maquinista->setTxActivo('S');
      					$data = $maquinista->listar();
      					foreach ($data as $reg) echo '<option value="'.$reg->getIdMaquinista().'" '.(($reg->getIdMaquinista()==$buscador->getMaquinista())?'selected':'').'>'.$reg->getPwMaquinista().'</option>'."\n";
      					unset($maquinista);
      				?>
      			</select>
      		</p>
      		<p>
      			<label for="sel2">Estación:</label> 
      			<select class="form-control" onChange="buscaEst(value)" id="sel2">
      				<option value="">.. Todas ..</option>
      				<?php 
      					$estacion = new Estacion();
      					$estacion->setCkInicial(1);
      					$data = $estacion->listar();
      					foreach ($data as $reg) echo '<option value="'.$reg->getIdEstacion().'" '.(($reg->getIdEstacion()==$buscador->getEstacion())?'selected':'').'>'.$reg->getTxEstacion().'</option>'."\n";
      					unset($estacion);
      				?>
      			</select>
      		</p>
      		<p>
      			<label for="txt1">Finalizados:</label><br>
      			<span id="txt1" style="cursor:pointer" onClick="buscaFin(<?php echo (($buscador->getFinalizado()==0)?1:0); ?>)" class="glyphicon glyphicon-<?php echo (($buscador->getFinalizado()==0)?'unchecked':'check'); ?>"></span>
      		</p>
      		<br><br>
      		<p><a href="#">Nuevo Tren</a></p>
    	</div>
    	<div class="col-sm-10 text-left"> 
    	<table class="table table-striped">
    		<thead>
      			<tr>
        			<th width="10%">Acc.</th>
        			<th width="15%">Fecha</th>
        			<th width="15%">Estación</th>
        			<th width="10%">Maquinista</th>
        			<th width="*">Tren</th>
      			</tr>
    		</thead>
    		<tbody>
		      <?php 
		      	$estacion = new Estacion();
		      	$tren = new Tren();
		      	$maquinista = new Maquinista();
		      	$tren->setVerFinales($buscador->getFinalizado());
		      	$tren->setIdMaquinista($buscador->getMaquinista());
		      	$tren->setLnEstacion($buscador->getEstacion());
		      	$data = $tren->listar();
		      	foreach ($data as $reg) {
		      		$estacion->setIdEstacion($reg->getIDEstacion());
		      		$maquinista->setIdMaquinista($reg->getIdMaquinista());
		      		$rog = $estacion->listar();
		      		$rug = $maquinista->listar();
		      		echo '<tr>
						   <td>
						   <button onClick="irA(\'detalle\','.$reg->getIdTren().')" type="button" class="button fa fa-tasks"></button>
						   <button onClick="irA(\'detalle\','.$reg->getIdTren().')" type="button" class="button fa fa-train"></button>
						   </td>
    			           <td>'.$reg->getFcConstruccion().'</td>
        				   <td>'.$rog[0]->getTxEstacion().'</td>
      					   <td>'.$rug[0]->getPwMaquinista().'</td>
      					   <td>'.$reg->getTxTren().'</td>
		      		      </tr>';
		      	}
		     	unset($maquinista);
		     	unset($tren);
		     	unset($estacion);
		     ?>
    		</tbody>
  		</table>
    	</div>
  	</div>
</div>