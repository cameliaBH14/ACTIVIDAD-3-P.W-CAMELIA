<?php
include('conexion.php');
include('login.php');
include('logout.php');


session_start();
$nombreUsuario= $_SESSION['nombre_usuario'];//VARIABLE DE SESIÓN NOMBRE DE USUARIO


$conectados = $conexion->prepare("SELECT * FROM usuarios WHERE estado='conectado'");//LISTA DE USUARIOS CONECTADOS
$conectados->execute();

$detallesU = $conexion->prepare("SELECT * FROM usuarios WHERE nombre=:nombreUsuario");// OBTENER INFORMACIÓN DE USUARIO
$detallesU -> bindParam(':nombreUsuario', $nombreUsuario, PDO::PARAM_STR);
$detallesU->execute();



?>

<html lang="es">
	<head>
		<title>ITIC</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/estilo.css">

  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  		
  		<script>
			$(document).ready(function(){ // OCULTAR LA CAJA DE REGISTRO
				$("#conectadosbox").hide();

			    $("#conectados").click(function(){ // DESAPARECER CAJA DE LOGIN Y APARECER LA DE REGISTRO
			        $("#conectadosbox").slideToggle();
			    });

			});
	    </script>


		<script>setTimeout('document.location.reload()',20000); </script> <!-- TIEMPO EN MILISEGUNDOS PARA QUE LA PÁG SE RECARGUE TRAS INACTIVIDAD-->
	</head>

	<body>
		<header>
			<div class="alert alert-info">
			<h3>Bienvenido: <? echo $nombreUsuario; ?></h3>
			</div>
		</header>

		<div class="col-md-4 col-md-offset-2 ">
		<div class="panel panel-primary">
        <div class="panel-heading text-center" >INFORMACIÓN DE USUARIO</div>
        <div class="panel-body">

			<?
				$mostrarDetalles = $detallesU->fetch(PDO::FETCH_ASSOC);
				
					echo '<strong>ID Usuario: </strong>'.$mostrarDetalles['id'].'<br>';
					echo '<strong>Nombre Usuario: </strong>'.$mostrarDetalles['nombre'].'<br>';
					echo '<strong>Correo Electrónico: </strong>'.$mostrarDetalles['email'].'<br>';
					echo '<strong>último Sing In: </strong>'.$mostrarDetalles['time_login'].'<br>';
					echo '<strong>Último Logout: </strong>'.$mostrarDetalles['time_logout'].'<br>';
				
			?>
		</div>
		</div>
		<form method="post" action="logout.php">
			<input class="btn btn-danger" type="submit" name="salir" value="Cerrar Sesión">
		</form>
		</div>

		<div class="col-md-2">
		<div class="panel panel-primary">
        <div class="panel-heading text-center" ><a href="#" id="conectados">CONECTADOS</a></div>
        <div class="panel-body" id="conectadosbox">

			<?
				while($filaConectados = $conectados->fetch(PDO::FETCH_ASSOC)) 
				{
					echo '<p style="color:gray;">
							<span style="color:#40b22c;">●</span> '.$filaConectados['nombre'].'
						  </p>';
				}

			?>
		</div>
		</div>
		</div>
	</body>
</html>


