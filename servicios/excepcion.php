<?php
interface IExcepcion
{
	/* Protected methods inherited from Exception class */
	public function getMessage();                 // Exception message
	public function getCode();                    // User-defined Exception code
	public function getTrace();                   // An array of the backtrace()

	/* Overrideable methods inherited from Exception class */
	public function __toString();                 // formated string for display
	public function __construct($message = null, $code = 0);
}

class MensajeSistema extends Exception implements IExcepcion {
	private $tipo;
	private function setTipo ($code) {
		switch ($code) {
			case 0:  $this->tipo = 'success'; break;
			case 1:  $this->tipo = 'danger';  break;
			case 2:  $this->tipo = 'warning'; break;
			case 3:  $this->tipo = 'info';    break;
			case 4:  $this->tipo = 'primary'; break;
			default: $this->tipo = 'default'; break;
		}
	}
	public function getTipo() { return $this->tipo; }
	public function __construct($message = null, $code = 0) {
		$this->setTipo($code);
		$GLOBALS['__listaExcepciones'][] = $this;
		parent::__construct($message, $code, $previous);
	}

}

class modeloMensaje {

	public function getError() {
		$temporal = null;
		$error = [];
		$errores = $this->hayError();
		if ($errores > 0) {
			$temporal=$GLOBALS['__listaExcepciones'][$errores-1];
			unset($GLOBALS['__listaExcepciones'][$errores-1]);
			$errores--;
		}
		return $temporal;
	}

	public function hayError() {
		return count($GLOBALS['__listaExcepciones']);
	}

}
$controlMensaje = new modeloMensaje();

?>