<?php
#controlador principal por el que tendrán que pasar todas las peticiones.
	require_once 'servicios/iniciador.php';
	require_once 'servicios/excepcion.php';
	require_once 'servicios/dao.php';
	require_once 'servicios/enlace.php';
	require_once 'servicios/usuario.php';
	
	require_once 'mvc/tren.php';
	require_once 'mvc/estacion.php';
	require_once 'mvc/maquinista.php';
	require_once 'mvc/anden.php';
	
	if (isset($_POST['irA'])) { $enlace->setEnlace($_POST); }
	
	switch ($_POST["accion"]) {
		case "identificacion":
			$Usuario->valida($_POST['maquinista'], $_POST['password']);
			break;
		case "logout":
			unset($_SESSION["data"]);
			unset($Usuario);
			$Usuario = new Usuario();
			break;
	}
	
?>