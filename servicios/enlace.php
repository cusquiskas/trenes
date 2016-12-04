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

?>