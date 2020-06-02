<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#"><img src ="img/fijas/imagen.gif" style="height:30px;"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li <?php if ($enlace->getMenu()=='trenes')        echo 'class="active"'; ?>><a onClick="irA('trenes')" href="#">Trenes</a></li>
        <li <?php if ($enlace->getMenu()=='configuracion') echo 'class="active"'; ?>><a href="#" onClick="irA('configuracion')">Configuración</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><form method="post"><button type="submit" name="accion" value="logout"><span class="glyphicon glyphicon-log-in"></span> Salir</button></form></li>
      </ul>
    </div>
  </div>
</nav>