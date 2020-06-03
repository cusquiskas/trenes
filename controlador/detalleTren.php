<?php
    error_reporting(E_ALL ^ E_NOTICE);
    session_start();
    require_once '../servicios/excepcion.php';
    require_once '../servicios/configuracion.php';
    require_once '../servicios/dao.php';

    require_once '../servicios/usuario.php';

    require_once '../mvc/tren.php';

    if ($Usuario->getIdMaquinista() == '') {
        die('{"success":false, "error":"Usuario no registrado"}');
    }

    switch ($_POST['accion']) {
        case 'recuperacion':
            $resultado = true;
            $JSON = '';
            $referencia = '';
            $Tren = new Tren();
            $Tren->setIdTren($_POST['id_tren']);
            $trenes = $Tren->listar();
            foreach ($trenes as $tre) {
                $JSON .= ',{"id_tren":'.$tre->getIdTren().', "id_estacion":'.$tre->getIDEstacion().', "tx_tren":"'.$tre->getTxTren().'", "id_maquinista":"'.$tre->getIdMaquinista().'"}';
            }
            unset($trenes);
            unset($Tren);

            echo '{"success":'.$resultado.', "root":{"dato":['.str_replace(array("\r\n", "\n", "\r"), '<br/>', substr($JSON, 1)).']}}';

            break;
        case 'moverTren':
            $resultado = true;
            $JSON = '';
            $referencia = '';
            $Tren = new Tren();
            $Tren->setIdTren($_POST['id_tren']);
            $Tren->setVerFinales(1);
            $temp = $Tren->listar();
            $Tren->setIdMaquinista($temp[0]->getIdMaquinista());
            $Tren->setIDEstacion($_POST['id_estacion']);
            $Tren->setFcConstruccion($temp[0]->getFcConstruccion());
            $Tren->setTxTren($temp[0]->getTxTren());
            $Tren->guardar();
            unset($temp);
            unset($Tren);

            echo '{"success":'.$resultado.', "root":{}}';

            break;
        default:
            echo '{"success":false, "error":"Acción no reconocida"}';
    }
