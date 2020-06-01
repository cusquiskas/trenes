<?php
 class Usuario {
 	private $id_maquinista;
 	private $pw_maquinista;
 	private $tx_correo;
 	private $tx_sesion;
 	private $tx_activo;
 	
 	public function getIdMaquinista() { return $this->id_maquinista; }
 	public function getPwMaquinista() { return $this->pw_maquinista; }
 	public function getTxCorreo()     { return $this->tx_correo;     }
 	public function getTxSesion()     { return $this->tx_sesion;	 }
 	public function getTxActivo()     { return $this->tx_activo;     }
 	
 	public function setIdMaquinista ($valor) { $this->id_maquinista = (string)$valor; }
 	public function setPwMaquinista ($valor) { $this->pw_maquinista = (string)$valor; }
 	public function setTxCorreo     ($valor) { $this->tx_correo     = (string)$valor; }
 	public function setTxSesion     ($valor) { $this->tx_sesion     = (string)$valor; }
 	public function setTxActivo     ($valor) {
 		if     ($valor === "S" || $valor === "s" || $valor === "1" || $valor === 1) $this->tx_activo = 'S';
 		elseif ($valor === "N" || $valor === "n" || $valor === "0" || $valor === 0) $this->tx_activo = 'N';
 		else   $this->tx_activo = null;
 	}

 	public function setDatos ($array) {
 		$this->setIdMaquinista($array["id_maquinista"]);
 		$this->setPwMaquinista($array["pw_maquinista"]);
 		$this->setTxCorreo    ($array["tx_correo"]);
 		$this->setTxSesion    ($array["tx_sesion"]);
 		$this->setTxActivo    ($array["tx_activo"]);
 		
 	}
 	public function getDatos() { 
 		return array(
 				'id_maquinista'=>$this->getIdMaquinista(), 
 				'pw_maquinista'=>$this->getPwMaquinista(),
 				'tx_correo'    =>$this->getTxCorreo(),
 				'tx_sesion'	   =>$this->getTxSesion()
 			   ); 
 	}
 	
 	private function recupera() {
 		$array = array(
 				0=>array("tipo"=>"s", "dato"=>$this->getIdMaquinista())
 		);
 		$query = "select *
   		            from maquinista
   		           where id_maquinista = ?";
 		$link = new ConexionSistema();
 		$reg = $link->consulta($query,$array);
 		$link->close();
 		return $reg;
 	}
 	
 	public function valida($id_maquinista, $contraseña) {
 		$this->setIdMaquinista($id_maquinista);
 		$datos = $this->recupera();
 		if (count($datos)==1) {
 			if ($datos[0]['tx_activo']!='S') {
 				$this->setIdMaquinista("");
 				new MensajeSistema('¡Tu licencia está caducada!', 1);
 			} else {
				$e["message"] = "";
				/*****************/
				$dbc = oci_new_connect(
					'newintra','nintra01', 
					'(DESCRIPTION =(ADDRESS = (PROTOCOL = TCP)(HOST =192.168.156.28)(PORT = 1521) (HASH = '.$rnum.')    )
					(CONNECT_DATA =(SID = PRTLEMP))  )'
				);
				$sql = "begin ACTDIR.PKG_DBMS_USR.LOGIN(:usr,:pas); end;";
				$stid = oci_parse($dbc, $sql);
				oci_bind_by_name($stid,':pas',$contraseña);
				oci_bind_by_name($stid,':usr',$id_maquinista);
				@oci_execute($stid,OCI_DEFAULT);
				$e = oci_error($stid);
				oci_close($dbc);
				/******************/
				if ($e["message"] == '') {
					$this->setDatos($datos[0]);
					$_SESSION['data']['user']['id'] = $id_maquinista;
				} else {
					$this->setIdMaquinista("");
					new MensajeSistema($e["message"], 1);
				}
 			}
 		} else {
 			$this->setIdMaquinista("");
 			new MensajeSistema('¡No se ha encontrado tu licencia!', 1);
 		}
 	}
 	
 	
 	function __construct() {
 		if (isset($_SESSION['data']['user']['id']))
 			$this->setIdMaquinista($_SESSION['data']['user']['id']);
 			$this->setDatos($this->recupera()[0]);
 	}
 
 }
 $Usuario = new Usuario();
 
?>
