<?php
    class mdlVagonFL
    {
        private $id_vagon; 	 //int(11)
        private $tx_fichero; //varchar(200)
        private $tx_ruta; 	 //varchar(500)
        private $id_tren;    //int(11)
        private $ck_carpeta; //char(1)
        private $ck_borrar;  //char(1)

        public function set($array)
        {
            if (isset($array['id_vagon'])) {
                $this->setIdVagon($array['id_vagon']);
            }
            if (isset($array['tx_fichero'])) {
                $this->setTxFichero($array['tx_fichero']);
            }
            if (isset($array['tx_ruta'])) {
                $this->setTxRuta($array['tx_ruta']);
            }
            if (isset($array['id_tren'])) {
                $this->setIdTren($array['id_tren']);
            }
            if (isset($array['ck_carpeta'])) {
                $this->setCkCarpeta($array['ck_carpeta']);
            }
            if (isset($array['ck_borrar'])) {
                $this->setCkBorrar($array['ck_borrar']);
            }
        }

        public function setIdVagon($valor)
        {
            $this->id_vagon = ($valor == null) ? null : (int) $valor;
        }

        public function setTxFichero($valor)
        {
            $this->tx_fichero = ($valor == null) ? null : (string) $valor;
        }

        public function setTxRuta($valor)
        {
            $this->tx_ruta = ($valor == null) ? null : (string) $valor;
        }

        public function setIdTren($valor)
        {
            $this->id_tren = ($valor == null) ? null : (int) $valor;
        }

        public function setCkCarpeta($valor)
        {
            $this->ck_carpeta = ($valor == null) ? null : (string) $valor;
        }

        public function setCkBorrar($valor)
        {
            $this->ck_borrar = ($valor == null) ? null : (string) $valor;
        }

        public function getIdVagon()
        {
            return $this->id_vagon;
        }

        public function getTxFichero()
        {
            return $this->tx_fichero;
        }

        public function getTxRuta()
        {
            return $this->tx_ruta;
        }

        public function getIdTren()
        {
            return $this->id_tren;
        }

        public function getCkCarpeta()
        {
            return $this->ck_carpeta;
        }

        public function getCkBorrar()
        {
            return $this->ck_borrar;
        }
    }

    class VagonFL extends mdlVagonFL
    {
        private function consulta()
        {
            $datos = array(
                        0 => array('tipo' => 'i', 'dato' => $this->getIdTren()),
                        1 => array('tipo' => 'i', 'dato' => $this->getIdVagon()),
                     );
            $query = 'select id_vagon,
					         tx_fichero,
					         tx_ruta,
					         id_tren
					    from vagonfl 
					   where id_tren  = IFNULL(?, id_tren)
					     and id_vagon = IFNULL(?, id_vagon)
					   order
					      by tx_ruta,
					         tx_fichero';
            $link = new ConexionSistema();
            $data = $link->consulta($query, $datos);
            $link->close();

            return $data;
        }

        public function listar()
        {
            $return = array();
            $data = $this->consulta();
            foreach ($data as $row) {
                $tmp = new mdlVagonFL();
                $tmp->set($row);
                $return[] = $tmp;
            }
            if (count($return) == 0) {
                $return[] = new mdlVagonFL();
            }

            return $return;
        }
    }
