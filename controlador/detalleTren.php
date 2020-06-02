<?php
	error_reporting(E_ALL ^ E_NOTICE);
 	session_start();
 	require_once('../servicios/configuracion.php');
	require_once '../servicios/dao.php';
	
	require_once '../servicios/usuario.php';
	
	require_once '../mvc/tren.php';
	
    if ($Usuario->getIdMaquinista() == "") die ('{"success":false, "error":"Usuario no registrado"}');
    
    switch ($_POST['accion']) {
		case 'recuperacion':	
			$resultado = true;
			$JSON = "";
			$referencia = "";
			$Tren = new Tren();
			$Tren->setIdTren($_POST['id_tren']);
			$trenes = $Tren->listar();
			foreach ($trenes as $tre) {
				$JSON.= ',{"id_tren":'.$tre->getIdTren().', "id_estacion":'.$tre->getIDEstacion().', "tx_tren":"'.$tre->getTxTren().'", "id_maquinista":"'.$tre->getIdMaquinista().'"}';
			}
			unset($trenes);
			unset($Trem);

            echo '{"success":'.$resultado.', "root":{"dato":['.str_replace(array("\r\n", "\n", "\r"),"<br/>",substr($JSON,1)).']}}';
			
			break;
        default:
            echo '{"success":false, "error":"Acción no reconocida"}';
    } 
?>