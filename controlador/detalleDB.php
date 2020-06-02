<?php
	error_reporting(E_ALL ^ E_NOTICE);
 	session_start();
 	require_once('../servicios/configuracion.php');
	require_once '../servicios/dao.php';
	
	require_once '../servicios/usuario.php';
	
	require_once '../mvc/contenedor.php';
	require_once '../mvc/vagondb.php';
	
	if ($Usuario->getIdMaquinista() == "") die ('{"success":false, "error":"Usuario no registrado"}');
	
	switch ($_POST['accion']) {
		case 'recuperacion':	
			$resultado = true;
			$JSON = "";
			$referencia = "";
			$Vagon = new Contenedor();
			$Vagon->setIdVagon($_POST['id_vagon']);
			$vagones = $Vagon->listar();
			foreach ($vagones as $vag) {
				$JSON.= ',{"id_vagon":'.$vag->getIdVagon().', "ix_fila":'.$vag->getIxFila().', "tx_fila":"'.$vag->getTxFila().'"}';
			}
			unset($vagones);
			unset($Vagon);
			$Vagon = new VagonDB();
			$Vagon->setIdVagon($_POST['id_vagon']);
			$vagones = $Vagon->listar();
			$referencia = $vagones[0]->getTxReferencia();
			unset($vagones);
			unset($Vagon);
			
			echo '{"success":'.$resultado.', "root":{"referencia":"'.$referencia.'", "dato":['.str_replace(array("\r\n", "\n", "\r"),"<br/>",substr($JSON,1)).']}}';
			
			break;
		case 'secuencia':
			$Vagon = new VagonDB();
			$Vagon->setIdVagon($_POST['id_vagon']);
			$vagones = $Vagon->listar();
			$vagones = array(
					'tx_pasajero'=>$vagones[0]->getTxPasajero(),
					'id_tren'=>$vagones[0]->getIdTren(),
					'ix_orden'=>$vagones[0]->getIxOrden(),
					'tx_type'=>$vagones[0]->getTxType()
			);
			$Vagon->set($vagones);
			$Vagon->setTxReferencia($_POST['tx_referencia']);
			$resultado = $Vagon->guardar();
				
			echo '{"success":'.$resultado.', "error":"No se ha podido guardar la referencia"}';
			break;
		case 'procedimiento':
			$Vagon = new VagonDB();
			$Vagon->setIdVagon($_POST['id_vagon']);
			$vagones = $Vagon->listar();
			$vagones = array(
					'tx_pasajero'=>$vagones[0]->getTxPasajero(),
					'id_tren'=>$vagones[0]->getIdTren(),
					'ix_orden'=>$vagones[0]->getIxOrden(),
					'tx_type'=>$vagones[0]->getTxType()
			);
			$Vagon->set($vagones);
			$Vagon->setTxReferencia($_POST['tx_referencia']);
			$resultado = $Vagon->guardar();
				
			echo '{"success":'.$resultado.', "error":"No se ha podido guardar la referencia"}';
			break;
		default:
			echo '{"success":false, "error":"Acción no reconocida"}';
	}
	
?>