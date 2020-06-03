<?php
    $tren = new Tren();
    $tren->setIdTren($enlace->getExtra());
    $tren->setVerFinales(1);
    $info = $tren->listar();
    $info = $info[0];
    unset($tren);

    require_once 'pantallas/popups/detalle_vagondb.php';
?>

<div class="container-fluid text-center">    
  <h2><?php echo $info->getTxTren(); ?></h2>
  <ul class="nav nav-pills">
  <?php
    $estacion = new Estacion();
    $estacion->setLnEstacion($estacion->lineaIdEstacion($info->getIDEstacion()));
    $datos = $estacion->listar();
    foreach ($datos as $row) {
        echo '<li class="'.(($info->getIDEstacion() == $row->getIdEstacion()) ? 'active' : '').'"><a href="#" onClick="cambiaTrenEstacion('.$row->getIdEstacion().')">'.$row->getTxEstacion().'</a></li>';
    }
    unset($datos);
    unset($estacion);
  ?>
  </ul>  
  <div class="row content">
    <div class="col-sm-6 text-left">
      <h3>FTP</h3>
      <hr>
		<?php
            $vagonfl = new VagonFL();
            $vagonfl->setIdTren($info->getIdTren());
            $datos = $vagonfl->listar();
            $ruta = '';
            foreach ($datos as $row) {
                if ($ruta != $row->getTxRuta()) {
                    $ruta = $row->getTxRuta();
                    echo '<p style="color:blue"><small><bold>'.$row->getTxRuta().'</bold></small></p>';
                }
                echo '<p><input type="checkbox" name="FL[]" value="'.$row->getIdVagon().'">&nbsp;'.$row->getTxFichero().'</p>';
            }
            unset($datos);
            unset($vagonfl);
        ?>
    </div>
    <div class="col-sm-6 text-left"> 
      <h3>BD</h3>
      <hr>
		<ul style="list-style: none; margin-left:-40px" id="sortable-with-handles" class="sortable list">
		<?php
            $vagondb = new VagonDB();
            $vagondb->setIdTren($info->getIdTren());
            $datos = $vagondb->listar();
            foreach ($datos as $row) {
                echo '<li><span style="cursor:pointer" class="handle glyphicon glyphicon-resize-vertical"></span>&nbsp;<input type="checkbox" name="DB[]" value="'.$row->getIdVagon().'">&nbsp;'.$row->getTxType().'/'.$row->getTxPasajero();
                echo ($row->getTxType() == 'LIBRE') ? " <span style='color:blue'>(".$row->getTxReferencia().")</span> <button onClick='abrir(".$row->getIdVagon().");' type='button' class='glyphicon glyphicon-eye-open'></button>" : '';
                echo '</li>';
            }
            unset($datos);
            unset($vagondb);
        ?>
		</ul>
    </div>
  </div>
</div>

<script>
var eventShooter = false;
$('#sortable-with-handles').sortable({
	handle: '.handle'
});
$('.sortable').sortable().bind('sortupdate', function() {
    //Triggered when the user stopped sorting and the DOM position has changed.
    eventShooter = !eventShooter;
    if (eventShooter) {
    	var cad='',x=1,i,input = document.getElementsByTagName('INPUT');
		for (i=0;i<input.length;i++) {
			if (input[i].name == 'DB[]') {
				cad+=','+input[i].value+':'+(x++);
			}
		} 
		invocaAjax({
			direccion:'/trenes/controlador/reordenacionDB.php',
			parametros:{xchn:'JSON',id_tren:<?php echo $info->getIdTren(); ?>,
 						cadena: cad.substr(1)
					   },
			retorno: function (s,d,e) {
 						if (s) {
							alert('OK');
 	 	 				} else {
 	 	 				    bootbox.alert({title:'Error en la reordenación',message:d.error});
 	 	 				} 
				     }
		});
    }
    
});

function cambiaTrenEstacion(e) {
	bootbox.confirm({
        message: "¿Mover a la estación indicada sin mover pasajeros?",
        buttons: { confirm: { label: 'Sí', className: 'btn-success' }, cancel: { label: 'No', className: 'btn-danger' } }, callback: function (r) { if (r) { confirmaCambioEstacion(e); } }
    });
}
function confirmaCambioEstacion(e) {
  invocaAjax({
    direccion:'/trenes/controlador/detalleTren.php',
    parametros:{xchn:'JSON',id_tren:<?php echo $info->getIdTren(); ?>, id_estacion: e, accion:'moverTren' },
    retorno: function (s,d,e) {
          if (s) {
            irA('detalle', <?php echo $info->getIdTren(); ?>);
          } else {
              bootbox.alert({title:'Error al mover',message:d.error});
          } 
            }
  });
}
</script>