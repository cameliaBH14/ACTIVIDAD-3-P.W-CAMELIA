<?
include('conexion.php');

if(isset($_POST['loguearse']))
{
	$usuario_log=$_POST['usuario_log'];// CONTENER EN UNA VARIABLE LO ESCRITO EN EL INPUT USUARIO_LOG
	$contrasena_log=$_POST['contraseña_log'];//CONTENER EN UNA VARIABLE LO ESCRITO EN EL INPUT CONTRASEÑA_LOG

	$loginUsuario=$conexion->prepare("SELECT * FROM usuarios WHERE nombre=:usuario_log AND contrasena=:contrasena_log");// BUSCAR EL USUARIO
	$loginUsuario->bindParam(':usuario_log', $usuario_log, PDO::PARAM_STR);
	$loginUsuario->bindParam(':contrasena_log', $contrasena_log, PDO::PARAM_STR);
	$loginUsuario->execute();

	if($loginUsuario->rowCount()>0)// SI LA QUERY ARROJA UN REGISTRO EXISTENTE...
	{	

		date_default_timezone_set('America/Mexico_City');
		$ultimaCon=date('Y-M-D G:i:s');
		$actualizarUs=$conexion->prepare("UPDATE usuarios SET estado='conectado', time_login=:ultimaCon WHERE nombre=:usuario_log");
		$actualizarUs->bindParam(':ultimaCon', $ultimaCon, PDO::PARAM_STR);
		$actualizarUs->bindParam(':usuario_log', $usuario_log, PDO::PARAM_STR);
		$actualizarUs->execute();

		header("Location: inicio.php");// ACCEDER AL INICIO

		$infoUsuario = $loginUsuario->fetch(PDO::FETCH_ASSOC);//GENERAR LA VARIABLE DE SESIÓN
		session_start();
		$_SESSION['nombre_usuario']=$infoUsuario['nombre']; 

	}

	else
	{
		$mensaje='<div class="alert alert-danger alert-dismissable col-md-offset-4 col-md-3 text-center">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	Datos <strong>incorrectos</strong>, vuelva a intentarlo.</div>';//ALERTA DE QUE EL USUARIO NO ESTA REGISTRADO
	}
}
?>