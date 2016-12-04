<?php 
# Este sólo tiene que decidir, que pantalla es la que se tiene que cargar
	switch ($enlace->getEnlace()) {
		case 'trenes':
			require_once 'pantallas/indice.php';
			break;
		case 'conf_estaciones':
		case 'configuracion':
			require_once 'pantallas/configuracion.php';
			break;
	}
?>

