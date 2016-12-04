<?php
	class mdlAnden {
		private $id_anden; 		#	int(11)
		private $id_estacion; 	#	int(11)
		private $tx_usuario; 	#	varchar(200)
		private $tx_clave; 		#	varchar(200)
		private $tx_direccion; 	#	varchar(200)
		private $tx_puerto; 	#	int(4)
		private $tx_raiz; 		#	varchar(200)
		private $tp_vagon; 		#	varchar(2)
	
		public function setIdAnden	  ($valor) { $this->id_anden     =    (int)$valor; }
		public function setIdEstacion ($valor) { $this->id_estacion  =    (int)$valor; }
		public function setTxUsuario  ($valor) { $this->tx_usuario   = (string)$valor; }
		public function setTxClave	  ($valor) { $this->tx_clave     = (string)$valor; }
		public function setTxDireccion($valor) { $this->tx_direccion = (string)$valor; }
		public function setTxPuerto	  ($valor) { $this->tx_puerto    =    (int)$valor; }
		public function setTxRaiz	  ($valor) { $this->tx_raiz      = (string)$valor; }
		public function setTpVagon	  ($valor) { $this->tp_vagon     = strtoupper((string)$valor); }
	
		public function getIdAnden	  () { return $this->id_anden;     }
		public function getIdEstacion () { return $this->id_estacion;  }
		public function getTxUsuario  () { return $this->tx_usuario;   }
		public function getTxClave	  () { return $this->tx_clave;     }
		public function getTxDireccion() { return $this->tx_direccion; }
		public function getTxPuerto	  () { return $this->tx_puerto;    }
		public function getTxRaiz	  () { return $this->tx_raiz;      }
		public function getTpVagon	  () { return $this->tp_vagon;     }
		
		public function set($array) {
			if (isset($array['id_anden'])) 	   $this->setIdAnden 	 ($array['id_anden']     );
			if (isset($array['id_estacion']))  $this->setIdEstacion  ($array['id_estacion']  );
			if (isset($array['tx_usuario']))   $this->setTxUsuario 	 ($array['tx_usuario']   );
			if (isset($array['tx_clave'])) 	   $this->setTxClave 	 ($array['tx_clave']     );
			if (isset($array['tx_direccion'])) $this->setTxDireccion ($array['tx_direccion'] );
			if (isset($array['tx_puerto']))    $this->setTxPuerto 	 ($array['tx_puerto']    );
			if (isset($array['tx_raiz'])) 	   $this->setTxRaiz 	 ($array['tx_raiz']      );
			if (isset($array['tp_vagon'])) 	   $this->setTpVagon 	 ($array['tp_vagon']     );
		}
		public function get() {
			return array(
					"id_anden"    => $this->getIdAnden(),
					"id_estacion" => $this->getIdEstacion(),
					"tx_usuario"  => $this->getTxUsuario(),
					"tx_clave"	  => $this->getTxClave(),
					"tx_direccion"=> $this->getTxDireccion(),
					"tx_puerto"	  => $this->getTxPuerto(),
					"tx_raiz"	  => $this->getTxRaiz(),
					"tp_vagon"	  => $this->getTpVagon()
				   );
		}
		
	}
	
	class Anden extends mdlAnden {
		private function consulta() {
			$datos = array (
					0=> array("tipo"=>'i', "dato"=>$this->getIdEstacion()),
					1=> array("tipo"=>'i', "dato"=>$this->getIdAnden()),
					2=> array("tipo"=>'s', "dato"=>$this->getTpVagon())
			);
			$query = "select *
					    from anden
					   where id_estacion = IFNULL(?, id_estacion)
					     and id_anden    = IFNULL(?, id_anden   )
					     and tp_vagon    = IFNULL(?, tp_vagon   )
					   order
					      by id_anden";
			$link = new ConexionSistema();
			$data = $link->consulta($query, $datos);
			$link->close();
			return $data;
		}
		
		public function listar() {
			$result = array();
			$datos = $this->consulta();
			foreach ($datos as $row) {
				$tmp = new mdlAnden();
				$tmp->set($row);
				$result[] = $tmp;
			}
			if (count($result)==0) $result[] = new mdlEstacion();
			return $result;
		}
		
	}

?>