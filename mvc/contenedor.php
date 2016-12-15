<?php

class mdlContenedor {
	private $id_vagon;	#int(11)
	private $ix_fila;	#int(11)
	private $tx_fila;	#varchar(12000)

	function set($array) {
		if (isset($array['id_vagon'])) $this->setIdVagon ($array['id_vagon']);
		if (isset($array['ix_fila']) ) $this->setIxFila  ($array['ix_fila'] );
		if (isset($array['tx_fila']) ) $this->setTxFila  ($array['tx_fila'] );
	}
	function setIdVagon ($valor) { $this->id_vagon = ($valor==null)?null:   (int)$valor; }
	function setIxFila  ($valor) { $this->ix_fila  = ($valor==null)?null:   (int)$valor; }
	function setTxFila  ($valor) { $this->tx_fila  = ($valor==null)?null:(string)$valor; }

	function getIdVagon () { return $this->id_vagon; }
	function getIxFila  () { return $this->ix_fila;  }
	function getTxFila  () { return $this->tx_fila;  }
		
}

class Contenedor extends mdlContenedor {
	private function consulta() {
		$datos = array (
				0=> array("tipo"=>'i', "dato"=>$this->getIdVagon())
		);
		$query = "select id_vagon,
						 ix_fila,
				         tx_fila
					from contenedor
				   where id_vagon = ?
   			       order
					  by ix_fila";
		$link = new ConexionSistema();
		$data = $link->consulta($query, $datos);
		$link->close();
		return $data;
	}
	
	private function insert() {
		
	}
	
	private function update() {
		
	}

	public function listar(){
		$return = array();
		$data = $this->consulta();
		foreach ($data as $row) {
			$tmp = new mdlContenedor();
			$tmp->set($row);
			$return[] = $tmp;
		}
		if (count($result)==0) $result[] = new mdlContenedor();
		return $return;
	}
	
	public function guardar() {
		
	}

}

?>