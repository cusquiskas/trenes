<?php
 class Usuario {
 	private $id_maquinista;
 	private $pw_maquinista;
 	private $tx_correo;
 	private $tx_sesion;
 	
 	public function getIdMaquinista() { return $this->id_maquinista; }
 	public function getPwMaquinista() { return $this->pw_maquinista; }
 	public function getTxCorreo()     { return $this->tx_correo;     }
 	public function getTxSesion()     { return $this->tx_sesion;	 }
 	
 	public function setIdMaquinista ($valor) { $this->id_maquinista = (string)$valor; }
 	public function setPwMaquinista ($valor) { $this->pw_maquinista = (string)$valor; }
 	public function setTxCorreo     ($valor) { $this->tx_correo     = (string)$valor; }
 	public function setTxSesion     ($valor) { $this->tx_sesion     = (string)$valor; }

 	public function setDatos ($array) {
 		$this->setIdMaquinista($array["id_maquinista"]);
 		$this->setPwMaquinista($array["pw_maquinista"]);
 		$this->setTxCorreo    ($array["tx_correo"]);
 		$this->setTxSesion    ($array["tx_sesion"]);
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
 			#más adelante habrá que comprobar la contraseña con el AD
 			$this->setDatos($datos[0]);
 			$_SESSION['data']['user']['id'] = $id_maquinista;
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
