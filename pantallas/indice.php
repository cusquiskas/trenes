<?php
# esta es la pantalla en la que se muestra la lista de trenes
?>
<div class="container-fluid text-center">    
	<div class="row content">
    	<div class="col-sm-2 sidenav">
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
		      	$tren->setVerFinales(0);
		      	$data = $tren->listar();
		      	foreach ($data as $reg) {
		      		$estacion->setIdEstacion($reg->getIDEstacion());
		      		$maquinista->setIdMaquinista($reg->getIdMaquinista());
		      		$rog = $estacion->listar();
		      		$rug = $maquinista->listar();
		      		echo '<tr>
    			           <td><button type="button" class="button button-default"><span class="fa fa-train"></span></button></td>
    			           <td>'.$reg->getFcConstruccion().'</td>
        				   <td>'.$rog[0]->getTxEstacion().'</td>
      					   <td>'.$rug[0]->getPwMaquinista().'</td>
      					   <td>'.$reg->getTxTren().'</td>
		      		      </tr>';
		      	}
		      ?>
    		</tbody>
  		</table>
    	</div>
  	</div>
</div>