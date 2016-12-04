<div class="container-fluid text-center">    
	<div class="row content">
    	<div class="col-sm-2 sidenav">
      		<p><a href="#" onClick="irA('conf_estaciones')">Estaciones</a></p>
    	</div>
    	<div class="col-sm-10 text-left"> 
			<?php 
				switch ($enlace->getEnlace()) {
					case 'configuracion' :
					case 'conf_estaciones':
						require 'pantallas/conf_estacion.php';
						break;
				}
			?>
    	</div>
  	</div>
</div>