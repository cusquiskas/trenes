<?php
/* creamos la estructura de datos que están en momória */
if (!isset($_SESSION['data'])) $_SESSION['data'] = array();
if (!isset($_SESSION['data']['user'])) $_SESSION['data']['user'] = array();
if (!isset($_SESSION['data']['enlace'])) $_SESSION['data']['enlace'] = array();
if (!isset($_SESSION['data']['buscar'])) $_SESSION['data']['buscar'] = array("maquinista"=>"", "finalizado"=>0, "estacion"=>"");

/* inicializamos la variable que contendrá los errores */
$GLOBALS['__listaExcepciones'] = array();
?>