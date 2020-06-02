<?php

class mdlVagonDB
{
    private $id_vagon; 	    //int(11)
    private $tx_pasajero;   //varchar(4000)
    private $id_tren; 	    //int(11)
    private $ix_orden; 	    //int(11)
    private $tx_type; 	    //char(50)
    private $tx_referencia; //varchar(200)

    public function set($array)
    {
        if (isset($array['id_vagon'])) {
            $this->setIdVagon($array['id_vagon']);
        }
        if (isset($array['tx_pasajero'])) {
            $this->setTxpasajero($array['tx_pasajero']);
        }
        if (isset($array['id_tren'])) {
            $this->setIdTren($array['id_tren']);
        }
        if (isset($array['ix_orden'])) {
            $this->setIxOrden($array['ix_orden']);
        }
        if (isset($array['tx_type'])) {
            $this->setTxType($array['tx_type']);
        }
        if (isset($array['tx_referencia'])) {
            $this->setTxReferencia($array['tx_referencia']);
        }
    }

    public function setIdVagon($valor)
    {
        $this->id_vagon = ($valor == null) ? null : (int) $valor;
    }

    public function setTxPasajero($valor)
    {
        $this->tx_pasajero = ($valor == null) ? null : (string) $valor;
    }

    public function setIdTren($valor)
    {
        $this->id_tren = ($valor == null) ? null : (int) $valor;
    }

    public function setIxOrden($valor)
    {
        $this->ix_orden = ($valor == null) ? null : (int) $valor;
    }

    public function setTxType($valor)
    {
        $this->tx_type = ($valor == null) ? null : (string) $valor;
    }

    public function setTxReferencia($valor)
    {
        $this->tx_referencia = ($valor == null) ? null : (string) $valor;
    }

    public function getIdVagon()
    {
        return $this->id_vagon;
    }

    public function getTxPasajero()
    {
        return $this->tx_pasajero;
    }

    public function getIdTren()
    {
        return $this->id_tren;
    }

    public function getIxOrden()
    {
        return $this->ix_orden;
    }

    public function getTxType()
    {
        return $this->tx_type;
    }

    public function getTxReferencia()
    {
        return $this->tx_referencia;
    }
}

class VagonDB extends mdlVagonDB
{
    private function consulta()
    {
        $datos = array(
                0 => array('tipo' => 'i', 'dato' => $this->getIdTren()),
                1 => array('tipo' => 'i', 'dato' => $this->getIdVagon()),
        );
        $query = 'select id_vagon,
					     tx_pasajero,
    			         id_tren,
						 ix_orden,
				         tx_type,
						 tx_referencia
					    from vagondb
					   where id_tren  = IFNULL(?, id_tren)
					     and id_vagon = IFNULL(?, id_vagon)
					   order
					      by ix_orden';
        $link = new ConexionSistema();
        $data = $link->consulta($query, $datos);
        $link->close();

        return $data;
    }

    private function insert()
    {
    }

    private function update()
    {
        $datos = array(
                0 => array('tipo' => 's', 'dato' => $this->getTxPasajero()),
                1 => array('tipo' => 'i', 'dato' => $this->getIdTren()),
                2 => array('tipo' => 'i', 'dato' => $this->getIxOrden()),
                3 => array('tipo' => 's', 'dato' => $this->getTxType()),
                4 => array('tipo' => 's', 'dato' => $this->getTxReferencia()),
                5 => array('tipo' => 'i', 'dato' => $this->getIdVagon()),
        );
        $query = 'update vagondb
					 set tx_pasajero = IFNULL(?,tx_pasajero),
					     id_tren = IFNULL(?,id_tren),
					     ix_orden = IFNULL(?,ix_orden),
						 tx_type = IFNULL(?,tx_type),
						 tx_referencia = IFNULL(?,tx_referencia)
				   where id_vagon = ?';
        $link = new ConexionSistema();
        $link->ejecuta($query, $datos);
        $link->close();

        return !$link->hayError();
    }

    public function listar()
    {
        $return = array();
        $data = $this->consulta();
        foreach ($data as $row) {
            $tmp = new mdlVagonDB();
            $tmp->set($row);
            $return[] = $tmp;
        }
        if (count($return) == 0) {
            $return[] = new mdlVagonDB();
        }

        return $return;
    }

    public function guardar()
    {
        if ($this->getIdVagon() == null || $this->getIdVagon() == '') {
            return false;
        } else {
            return $this->update();
        }
    }
}
