    <div class="container" style="width:300px">

    <?php if($controlMensaje->hayError() > 0) { 
	   while ($controlMensaje->hayError() > 0){
	    $error = $controlMensaje->getError();
	    echo '<div class="alert alert-'.$error->getTipo().'"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$error->getMessage().'.</div>';
	   }
      echo "<br>";
     }
     
     ?>

      <form method="post" class="form-signin">
        <h2 class="form-signin-heading">Identifícate</h2>
        <label for="inputEmail" class="sr-only">Id Maquinista</label>
        <input type="text" name="maquinista" id="inputEmail" class="form-control" placeholder="Id Maquinista" required autofocus>
        <label for="inputPassword" class="sr-only">Contraseña</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Contraseña" onkeypress="if (event.keyCode==13) this.parentNode.submit();" required>
        <input type="hidden" name="accion" value="identificacion">
        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
      </form>
      

    </div>