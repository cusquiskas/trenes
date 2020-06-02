<?php
	error_reporting(E_ALL ^ E_NOTICE);
 	session_start();
 	require_once('controlador/home.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>Trenes</title>
  <link href='img/fijas/Thrawn.ico' rel='shortcut icon' type='image/x-icon'>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/font-awesome-4.6.3/css/font-awesome.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
  <link href="css/datetimepicker.css" rel="stylesheet" type="text/css">
  <script src="js/datetimepicker.js" type="text/javascript"></script>
  <script src="js/funciones.js" type="text/javascript"></script>
  <script src="js/bootbox.min.js" type="text/javascript"></script>
  <script src="js/jquery.sortable.js" type="text/javascript"></script>
  <script src="js/ajax.js" type="text/javascript"></script>
<?php 
if (in_array($enlace->getEnlace(), ['conf_estaciones','configuracion'])) echo '<script src="js/conf_estacion.js" type="text/javascript"></script>';
?>
  
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
  </style>
   <script type="text/javascript">
				function main() {
					<?php if ($controlMensaje->hayError() > 0) echo '$("#modalMuestraErrores").modal();'; ?>
					<?php /*if ($Enlace->getScroll() > 0) { ?> 
						if (typeof (document.body.scrollTop) == 'undefined') 
							document.documentElement.scrollTop = <?php echo $Enlace->getScroll(); ?>; 
						else 
							document.body.scrollTop = <?php echo $Enlace->getScroll(); 
						}*/ ?>;
				}	
  			</script>
</head>
 
<body onLoad="main()">
 			<?php 	if ($Usuario->getIdMaquinista() == "") { 
 						require ('login.php'); 
 					} else { 
 						require ('menu.php');  	
 			 			require ('body.php');
						require ('pie.php');
 					}
 			?>


</body>
</html>
