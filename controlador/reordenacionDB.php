<?php
	error_reporting(E_ALL ^ E_NOTICE);
 	session_start();
 	require_once('../servicios/configuracion.php');
	require_once '../servicios/dao.php';
	
	require_once '../servicios/usuario.php';
	
	require_once '../mvc/vagondb.php';
	
	if ($Usuario->getIdMaquinista() == "") die ('{"success":false, "error":"Usuario no registrado"}');
	
	$resultado = true;
	$error = "";
	$Vagon = new VagonDB();
	$Vagon->setIdTren($_POST['id_tren']);
	$vagones = preg_split('/,/',$_POST['cadena']);
	foreach ($vagones as $vag) {
		$orden = preg_split('/:/',$vag);
		$Vagon->setIdVagon($orden[0]);
		$Vagon->setIxOrden($orden[1]);
		if (!$Vagon->guardar()) {
			$resultado = false;
			$error.= "<p>No se pudo asignar la posición $orden[1]</p>";
		}
	}
	
	echo '{"success":'.$resultado.', "error":'.$error.'}';
?>
