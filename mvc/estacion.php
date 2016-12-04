<?php
	class mdlEstacion {
		private $id_estacion;		#int(11) 	
		private $tx_estacion;		#varchar(200) 	
		private $id_estacion_next;	#int(11) 	
		private $ck_inicial;		#char(1)
	
		public function set($array) {
			if (isset($array['id_estacion'])) 		$this->setIdEstacion	($array['id_estacion']		);
			if (isset($array['tx_estacion'])) 		$this->setTxEstacion	($array['tx_estacion']		);
			if (isset($array['id_estacion_next'])) 	$this->setIdEstacionNext($array['id_estacion_next']	);
			if (isset($array['ck_inicial'])) 		$this->setCkInicial		($array['ck_inicial']		);
		}
		public function setIdEstacion 	  ($valor) { $this->id_estacion = 	   (int)$valor; }
		public function setTxEstacion 	  ($valor) { $this->tx_estacion = 	(string)$valor; }
		public function setIdEstacionNext ($valor) { $this->id_estacion_next = (int)$valor; }
		public function setCkInicial 	  ($valor) { $this->ck_inicial = 	(string)$valor; }
		
		public function getIdEstacion 	  () { return $this->id_estacion; 		}
		public function getTxEstacion 	  () { return $this->tx_estacion; 		}
		public function getIdEstacionNext () { return $this->id_estacion_next; 	}
		public function getCkInicial 	  () { return $this->ck_inicial; 		}
		
	}
	
	class Estacion extends mdlEstacion {
		private function autoIncrement() {
			$datos = array ();
			$query = "select IFNULL(max(id_estacion),0) id_estacion
					    from estacion";
			$link = new ConexionSistema();
			$data = $link->consulta($query, $datos);
			$link->close();
			return ($data[0]['id_estacion'] + 1);
		}
		private function consulta() {
			$datos = array (
					0=> array("tipo"=>'i', "dato"=>$this->getIdEstacion()),
					1=> array("tipo"=>'s', "dato"=>$this->getCkInicial())
			);
			$query = "select *
					    from estacion
					   where id_estacion = IFNULL(?, id_estacion)
					     and ck_inicial  = IFNULL(?, ck_inicial)
					   order
					      by tx_estacion";
			$link = new ConexionSistema();
			$data = $link->consulta($query, $datos);
			$link->close();
			return $data;
		}
		private function insert() {
			$datos = array (
					0=> array("tipo"=>'i', "dato"=>$this->getIdEstacion()),
					1=> array("tipo"=>'s', "dato"=>$this->getTxEstacion()),
					2=> array("tipo"=>'i', "dato"=>$this->getIdEstacionNext()),
					3=> array("tipo"=>'s', "dato"=>$this->getCkInicial())
			);
			$query = "insert
					    into estacion
					         (id_estacion, tx_estacion, id_estacion_next, ck_inicial)
					  values (?,           ?,           ?,                ?			)";
			$link = new ConexionSistema();
			$link->ejecuta($query, $datos);
			$link->close();
			return (!$link->hayError());
		}
		private function update() {
			$datos = array (
					0=> array("tipo"=>'s', "dato"=>$this->getTxEstacion()),
					1=> array("tipo"=>'i', "dato"=>$this->getIdEstacionNext()),
					2=> array("tipo"=>'s', "dato"=>$this->getCkInicial()),
					3=> array("tipo"=>'i', "dato"=>$this->getIdEstacion())
			);
			$query = "update estacion
					     set tx_estacion = ?, 
					         id_estacion_next = ?, 
					         ck_inicial = ?
				       where id_estacion = ?";
			$link = new ConexionSistema();
			$link->ejecuta($query, $datos);
			$link->close();
			return (!$link->hayError());
		}
		private function delete() {
			#Hay que hacer muchas cosas antes de borrar una estación
		}
		
		public function listar() {
			$result = array();
			$datos = $this->consulta();
			foreach ($datos as $row) {
				$tmp = new mdlEstacion();
				$tmp->set($row);
				$result[] = $tmp;
			}
			if (count($result)==0) $result[] = new mdlEstacion();
			return $result;
		}
		public function guardar() {
			if ($this->getIdEstacion() == "") {
				$this->setIdEstacion($this->autoIncrement());
				if ($this->insert()) new MensajeSistema("Se ha creado la estación ".$this->getTxEstacion(), 0);
			} else {
				if ($this->update()) new MensajeSistema("Se ha actualizado la estación ".$this->getTxEstacion(), 0);
			}
		}
	
	}
?>