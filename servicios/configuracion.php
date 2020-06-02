<?php

class ConfiguracionSistema
{
    private $host = 'localhost';
    private $user = 'maquinista';
    private $pass = 'maquinaria';
    private $apli = 'trenes';

    private $home = '/opt/lampp/htdocs/trenes/';

    /*  BASE DE DATOS */
    public function getHost()
    {
        return $this->host;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function getApli()
    {
        return $this->apli;
    }

    /*  RUTA FISICA   */
    public function getHome()
    {
        return $this->home;
    }
}
