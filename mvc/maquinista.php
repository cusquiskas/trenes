<?php
class mdlMaquinista {
	private $id_maquinista;
	private $pw_maquinista;
	private $tx_correo;

	public function getIdMaquinista() { return $this->id_maquinista; }
	public function getPwMaquinista() { return $this->pw_maquinista; }
	public function getTxCorreo()     { return $this->tx_correo;     }
	public function getTxActivo()     { return $this->tx_activo;     }

	public function setIdMaquinista ($valor) { $this->id_maquinista = (string)$valor; }
	public function setPwMaquinista ($valor) { $this->pw_maquinista = (string)$valor; }
	public function setTxCorreo     ($valor) { $this->tx_correo     = (string)$valor; }
	public function setTxActivo     ($valor) { 
		if     ($valor === "S" || $valor === "s" || $valor === "1" || $valor === 1) $this->tx_activo = 'S';
		elseif ($valor === "N" || $valor === "n" || $valor === "0" || $valor === 0) $this->tx_activo = 'N';
		else   $this->tx_activo = null;
	}

	public function setDatos ($array) {
		$this->setIdMaquinista($array["id_maquinista"]);
		$this->setPwMaquinista($array["pw_maquinista"]);
		$this->setTxCorreo    ($array["tx_correo"]);
		$this->setTxActivo	  ($array["tx_activo"]);
	}
	public function getDatos() {
		return array(
				'id_maquinista'=>$this->getIdMaquinista(),
				'pw_maquinista'=>$this->getPwMaquinista(),
				'tx_correo'    =>$this->getTxCorreo(),
				'tx_activo'    =>$this->getTxActivo()
		);
	}
	
}

class Maquinista extends mdlMaquinista {
	private function recupera() {
		$array = array(
				0=>array("tipo"=>"s", "dato"=>$this->getIdMaquinista()),
				1=>array("tipo"=>"s", "dato"=>$this->getTxActivo())
		);
		$query = "select *
   		            from maquinista
   		           where id_maquinista = IFNULL(?, id_maquinista)
				     and tx_activo = IFNULL(?, tx_activo)
				   order
				      by pw_maquinista";
		$link = new ConexionSistema();
		$reg = $link->consulta($query,$array);
		$link->close();
		return $reg;
	}
	
	public function listar () {
		$result = array();
		$datos = $this->recupera();
		foreach ($datos as $row) {
			$tmp = new mdlMaquinista();
			$tmp->setDatos($row);
			$result[] = $tmp;
		}
		if (count($result)==0) $result[] = new mdlMaquinista();
		return $result;
	}
	
}

?>

