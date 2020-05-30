<?php
    class mdlTren
    {
        private $id_tren;			//int(11)
        private $id_maquinista;		//varchar(200)
        private $tx_tren;			//varchar(200)
        private $fc_construccion;	//date
        private $id_estacion;		//int(11)

        public function set($array)
        {
            if (isset($array['id_tren'])) {
                $this->setIdTren($array['id_tren']);
            }
            if (isset($array['id_maquinista'])) {
                $this->setIdMaquinista($array['id_maquinista']);
            }
            if (isset($array['fc_construccion'])) {
                $this->setFcConstruccion($array['fc_construccion']);
            }
            if (isset($array['tx_tren'])) {
                $this->setTxTren($array['tx_tren']);
            }
            if (isset($array['id_estacion'])) {
                $this->setIDEstacion($array['id_estacion']);
            }
        }

        public function setIdTren($valor)
        {
            $this->id_tren = (int) $valor;
        }

        public function setIdMaquinista($valor)
        {
            $this->id_maquinista = ((string) $valor != '') ? (string) $valor : null;
        }

        public function setTxTren($valor)
        {
            $this->tx_tren = (string) $valor;
        }

        public function setFcConstruccion($valor)
        {
            $this->fc_construccion = (string) $valor;
        }

        public function setIDEstacion($valor)
        {
            $this->id_estacion = (int) $valor;
        }

        public function getIdTren()
        {
            return $this->id_tren;
        }

        public function getIdMaquinista()
        {
            return $this->id_maquinista;
        }

        public function getTxTren()
        {
            return $this->tx_tren;
        }

        public function getFcConstruccion()
        {
            return $this->fc_construccion;
        }

        public function getIDEstacion()
        {
            return $this->id_estacion;
        }
    }

    class Tren extends mdlTren
    {
        private $ver_finales;		//filtro: ¿incluir estaciones finales? 1 Sí : 0 No
        private $ln_estacion;       //filtro: Array con todas las estaciones de la línea del tren

        public function setVerFinales($valor)
        {
            $this->ver_finales = (int) $valor;
        }

        public function setLnEstacion($valor)
        {
            if ($valor == '') {
                $this->ln_estacion = null;
            } else {
                $estacion = new Estacion();
                $this->ln_estacion = $estacion->lineaIdEstacion($valor);
                unset($estacion);
            }
        }

        public function getVerFinales()
        {
            return $this->ver_finales;
        }

        public function getLnEstacion()
        {
            return $this->ln_estacion;
        }

        private function autoIncrement()
        {
            $datos = array();
            $query = 'select IFNULL(max(id_tren),0) id_tren
					    from tren';
            $link = new ConexionSistema();
            $data = $link->consulta($query, $datos);
            $link->close();

            return $data[0]['id_tren'] + 1;
        }

        private function consulta()
        {
            $datos = array(
                        0 => array('tipo' => 'i', 'dato' => $this->getIdTren()),
                        1 => array('tipo' => 's', 'dato' => $this->getIdMaquinista()),
                        2 => array('tipo' => 'i', 'dato' => $this->getVerFinales()),
                        3 => array('tipo' => 's', 'dato' => $this->getLnEstacion()),
                        4 => array('tipo' => 's', 'dato' => $this->getLnEstacion()),
                     );
            $query = "select id_tren,
					         tx_tren,
					         id_maquinista,
					         DATE_FORMAT(fc_construccion, '%d/%m/%Y') as fc_construccion,
							 id_estacion
					    from tren 
					   where id_tren = IFNULL(?, id_tren)
					     and id_maquinista = IFNULL(?, id_maquinista)
						 and (   ? > 0
					          or id_estacion in (select id_estacion
					                               from estacion
					                              where id_estacion_next > 0)
					         )
					     and (FIND_IN_SET(id_estacion,?) > 0 or ? is null)
					
					   order
					      by id_tren desc";
            $link = new ConexionSistema();
            $data = $link->consulta($query, $datos);
            $link->close();

            return $data;
        }

        private function insert()
        {
            $datos = array(
                        0 => array('tipo' => 'i', 'dato' => $this->getIdTren()),
                        1 => array('tipo' => 's', 'dato' => $this->getIdMaquinista()),
                        2 => array('tipo' => 's', 'dato' => $this->getTxTren()),
                        3 => array('tipo' => 's', 'dato' => $this->getFcConstruccion()),
                        4 => array('tipo' => 'i', 'dato' => $this->getIDEstacion()),
                     );
            $query = "insert
					    into tren
					         (id_tren, id_maquinista, tx_tren, fc_construccion, 		  id_estacion)
					  values (?,       ?,             ?,       STR_TO_DATE(?,'%d/%m/%Y'), ?			 )";
            $link = new ConexionSistema();
            $link->ejecuta($query, $datos);
            $link->close();

            return !$link->hayError();
        }

        private function update()
        {
            $datos = array(
                    0 => array('tipo' => 's', 'dato' => $this->getIdMaquinista()),
                    1 => array('tipo' => 's', 'dato' => $this->getTxTren()),
                    2 => array('tipo' => 's', 'dato' => $this->getFcConstruccion()),
                    3 => array('tipo' => 'i', 'dato' => $this->getIDEstacion()),
                    4 => array('tipo' => 'i', 'dato' => $this->getIdTren()),
            );
            $query = 'update tren
					     set id_maquinista = ?,
							 tx_tren = ?, 
					         fc_construccion = ?,
							 id_estacion = ?
					   where id_tren = ?';
            $link = new ConexionSistema();
            $link->ejecuta($query, $datos);
            $link->close();

            return !$link->hayError();
        }

        private function delete()
        {
            //antes de borrar un tren, hay muchas cosas que borrar.
        }

        public function guardar()
        {
            if ($this->getIdTren() == '') {
                $this->setIdTren($this->autoIncrement());
                if ($this->insert()) {
                    new MensajeSistema('Se ha creado el Tren '.$this->getTxTren(), 0);
                }
            } else {
                if ($this->update()) {
                    new MensajeSistema('Se ha actualizado el Tren '.$this->getTxTren(), 0);
                }
            }
        }

        public function listar()
        {
            $return = array();
            $data = $this->consulta();
            foreach ($data as $row) {
                $tmp = new mdlTren();
                $tmp->set($row);
                $return[] = $tmp;
            }
            if (count($return) == 0) {
                $return[] = new mdlTren();
            }

            return $return;
        }
    }
