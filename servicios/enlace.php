<?php

	class Enlace {
    	private $anterior;
    	private $enlace;
    	private $menu;
    	private $scroll;
    	private $extra;
    
	    function getEnlace() { return $this->enlace; }
    	function getAnterior() { return $this->anterior; }
    	function getMenu() { return $this->menu; }
  		function getScroll() { return $this->scroll; }
  		function getExtra() { return $this->extra; }
    
	    function setEnlace($datos) {
    		$this->anterior = $this->enlace;
    		$this->enlace = $datos['irA'];
    		$this->scroll = $datos['scroll'];
    		$this->extra = $datos['extra'];
    	
    		switch ($datos['irA']) {
    			case 'verVagonDB':
    			case 'detalle':
    			case 'trenes':
    				$this->menu = 'trenes';
    				break;
    			case 'configuracion':
    			case 'conf_estaciones':
    				$this->menu = 'configuracion';
    				break;
    		}
    	
			$_SESSION['data']['enlace'] = array('anterior'=> $this->anterior,
	    			                            'enlace'  => $this->enlace,
	    			                            'menu'    => $this->menu,
	    			                            'scroll'  => $this->scroll,
	    										'extra'   => $this->extra
    									  );
    }
    
    function __construct() {
    	if ($_SESSION['data']['enlace']['enlace']) {
    		$this->enlace = $_SESSION['data']['enlace']['enlace'];
    		$this->anterior = $_SESSION['data']['enlace']['anterior'];
    		$this->menu = $_SESSION['data']['enlace']['menu'];
    		$this->scroll = $_SESSION['data']['enlace']['scroll'];
    		$this->extra = $_SESSION['data']['enlace']['extra'];
    	} else {
    		$this->setEnlace(array("irA"=>"trenes"));
    	}
    }
  	
  }
  $enlace = new Enlace();
  
  class Buscador {
  	private $maquinista;
  	private $finalizado;
  	private $estacion;
  	
  	function getMaquinista() { return $this->maquinista; }
  	function getFinalizado() { return $this->finalizado; }
  	function getEstacion()   { return $this->estacion;   }
  	
  	function setBusqueda($datos) { 
  		$this->maquinista = $datos['buscaMaq'];
  		$this->estacion   = $datos['buscaEst'];
  		if ($datos['buscaFin'] === "S" || $datos['buscaFin'] === "s" || $datos['buscaFin'] === "1" || $datos['buscaFin'] === 1) $this->finalizado = 1; else $this->finalizado = 0;
  		$_SESSION['data']['buscar']['maquinista'] = $this->maquinista;
  		$_SESSION['data']['buscar']['finalizado'] = $this->finalizado;
  		$_SESSION['data']['buscar']['estacion']   = $this->estacion;
  	}
  	
  	function __construct() {
		$this->maquinista = $_SESSION['data']['buscar']['maquinista'];
  		$this->finalizado = $_SESSION['data']['buscar']['finalizado'];
  		$this->estacion   = $_SESSION['data']['buscar']['estacion'];
  	}
  }
  $buscador = new Buscador();

?>