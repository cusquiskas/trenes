			<br>
			<form name="conf_estacion" style="display:none" method="post">
				<input name="id_estacion" value="<?php echo $_POST["id_estacion"]?>">
				<input name="id_linea" value="<?php echo $_POST["id_linea"]?>">
			</form>
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
      					<label for="txt1">Línea:</label>
      					<select class="form-control" id="txt1" name="id_estacion" onChange="buscaLinea(value);">
      						<option value="">..Selecciona Estación..</option>
      						<?php 
      							$estacion = new Estacion();
      							$estacion->setCkInicial(1);
      							$datos = $estacion->listar();
      							foreach ($datos as $reg) {
      								echo '<option value="'.$reg->getIdEstacion().'" '.(($_POST["id_linea"]==$reg->getIdEstacion())?'selected':'').' >'.$reg->getTxEstacion().'</option>';
      							}
      						?>
      					</select>
      				</div>
				</div>
			</div>
			<div class="row">
			<div class="col-sm-12">
			<div class="form-group">
      					<label for="btn-estacion">Estación:</label>
			</div>
			</div>
			<?php 
				if (isset($_POST["id_linea"]) && $_POST["id_linea"]!="") {
					$estacion = new Estacion();
					$estacion->setIdEstacion($_POST["id_linea"]);
					$datos = $estacion->listar();
					echo '<div class="col-sm-2"><button type="button" class="btn btn-'.(($_POST["id_estacion"]!=$datos[0]->getIdEstacion())?'default':'warning').'" onClick="buscaAnden('.$_POST["id_linea"].')">'.$datos[0]->getTxEstacion().'</button></div>';
					while ($datos[0]->getIdEstacionNext() > 0) {
						$estacion->setIdEstacion($datos[0]->getIdEstacionNext());
						$datos = $estacion->listar();
						echo '<div class="col-sm-2"><button type="button" class="btn btn-'.(($_POST["id_estacion"]!=$datos[0]->getIdEstacion())?'default':'warning').'" onClick="buscaAnden('.$datos[0]->getIdEstacion().')">'.$datos[0]->getTxEstacion().'</button></div>';
					}
				}
			?>
			
			</div>
			<hr>
			<div class="row">
			<?php 
				if (isset($_POST["id_estacion"]) && $_POST["id_estacion"]!="") {
					$anden = new Anden();
					$anden->setTpVagon('FL');
					$anden->setIdEstacion($_POST["id_estacion"]);
					$datos = $anden->listar();
					foreach ($datos as $datosAndenFL) {
						echo '<div class="col-sm-3" style="margin:5px; padding:5px; border:1px solid gray;">
							  <form method="post">
								<input type="hidden" name="id_anden" value="'.$datosAndenFL->getIdAnden().'">
								<input type="hidden" name="id_estacion" value="'.$datosAndenFL->getIdEstacion().'">
								<input type="hidden" name="tp_vagon" value="'.$datosAndenFL->getTpVagon().'">
							    <input type="hidden" name="id_linea" value="'.$_POST["id_linea"].'">
      							<input type="hidden" name="accion" value="">
      						   <div class="row">
								 <div class="col-sm-4">Usuario:</div><div class="col-sm-8"><input name="tx_usuario" value="'.$datosAndenFL->getTxUsuario().'"></div>
								 <div class="col-sm-4">Clave:</div><div class="col-sm-8"><input name="tx_clave" value="'.$datosAndenFL->getTxClave().'"></div>
								 <div class="col-sm-4">IP:</div><div class="col-sm-8"><input name="tx_direccion" value="'.$datosAndenFL->getTxDireccion().'"></div>
								 <div class="col-sm-4">Puerto:</div><div class="col-sm-8"><input name="tx_puerto" value="'.$datosAndenFL->getTxPuerto().'"></div>
								 <div class="col-sm-4">Raiz:</div><div class="col-sm-8"><input name="tx_raiz" value="'.$datosAndenFL->getTxRaiz().'"></div>
								 <div class="col-sm-6"><button type="button" onClick="confirmaGuardar(form)" class="btn btn-success">Guardar</button></div><div class="col-sm-6"><button type="button" onClick="confirmaBorrar(form)" class="btn btn-danger">Borrar</button></div>
							   </div>
							  </form>
						      </div>';
							
					}
				}
			?>
			</div>
			<hr>
			<div class="row">
			<?php 
				if (isset($_POST["id_estacion"]) && $_POST["id_estacion"]!="") {
					$anden = new Anden();
					$anden->setTpVagon('BD');
					$anden->setIdEstacion($_POST["id_estacion"]);
					$datAndenBD = $anden->listar();
					foreach ($datAndenBD as $datosAndenBD) {
						echo '<div class="col-sm-3" style="margin:5px; padding:5px; border:1px solid gray;">
							  <form method="post">
								<input type="hidden" name="id_anden" value="'.$datosAndenBD->getIdAnden().'">
								<input type="hidden" name="id_estacion" value="'.$datosAndenBD->getIdEstacion().'">
								<input type="hidden" name="tp_vagon" value="'.$datosAndenBD->getTpVagon().'">
							    <input type="hidden" name="id_linea" value="'.$_POST["id_linea"].'">
      						    <input type="hidden" name="accion" value="">
      						   <div class="row">
								 <div class="col-sm-4">Usuario:</div><div class="col-sm-8"><input name="tx_usuario" value="'.$datosAndenBD->getTxUsuario().'"></div>
								 <div class="col-sm-4">Clave:</div><div class="col-sm-8"><input name="tx_clave" value="'.$datosAndenBD->getTxClave().'"></div>
								 <div class="col-sm-4">JDBC:</div><div class="col-sm-8"><input name="tx_direccion" value="'.$datosAndenBD->getTxDireccion().'"></div>
								 <div class="col-sm-4">Puerto:</div><div class="col-sm-8"><input name="tx_puerto" value="'.$datosAndenBD->getTxPuerto().'"></div>
								 <div class="col-sm-4">SSID:</div><div class="col-sm-8"><input name="tx_raiz" value="'.$datosAndenBD->getTxRaiz().'"></div>
							     <div class="col-sm-6"><button type="button" onClick="confirmaGuardar(form)" class="btn btn-success">Guardar</button></div><div class="col-sm-6"><button type="button" onClick="confirmaBorrar(form)" class="btn btn-danger">Borrar</button></div>
							  </div>
							  </form>
						      </div>';
							
					}
				}
			?>
			</div>
			<br>