<?php

class ConfiguracionSistema {
   private $host = 'localhost';
   private $user = 'maquinista';
   private $pass = 'a todo trapo';
   private $apli = 'trenes';
   
   private $home = '/var/www/html/trenes/';
   
   /*  BASE DE DATOS */
   public function getHost() { return $this->host; }
   public function getUser() { return $this->user; }
   public function getPass() { return $this->pass; }
   public function getApli() { return $this->apli; }
   /*  RUTA FISICA   */
   public function getHome() { return $this->home; }
   
}
?>