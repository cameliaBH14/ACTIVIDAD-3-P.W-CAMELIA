<?
include('conexion.php');
session_start();
$nombreUsuario= $_SESSION['nombre_usuario'];// VARIABLE DE SESIÓN NOMBRE DE USUARIO


//------------------DESCONECTARSE MEDIANTE EL BOTÓN CERRAR SESIÓN---------------///

if (isset($_POST['salir']))
{
	date_default_timezone_set('America/Mexico_City'); //OBTENER FECHA Y HORA ACTUAL
	$ultimaCon=date('Y-M-D G:i:s');

	try
	{
	$Logout=$conexion->prepare("UPDATE usuarios SET estado='desconectado', time_logout=:ultimaCon WHERE nombre=:nombre_usuario");//ACTUALIZAR ESTADO, FECHA Y HORA 
	$Logout->bindParam(':ultimaCon', $ultimaCon, PDO::PARAM_STR);
	$Logout->bindParam(':nombre_usuario', $nombreUsuario, PDO::PARAM_STR);
	$Logout->execute();

	session_unset(); //LIMPIAR VARIABLES DE SESIÓN
	session_destroy();//DESTRUIR LA SESIÓN

	header("Location: index.php");// VOLVER AL CUADRO DE LOGIN/REGISTRO
	}

	catch (PDOException $error) 
	{
     print 'ERROR: '. $error->getMessage();
	}
}




//------------------DESCONECTARSE MEDIANTE TIEMPO INACTIVO---------------///


//Comprobamos si esta definida la sesión 'tiempo'.
if(isset($_SESSION['tiempo']) ) {

    //Variable que define el tiempo de inactividad en segundos
    $inactivo = 20;
    //Calcular el tiempo de inactividad
    $vida_session = time() - $_SESSION['tiempo'];

        //Comprobar si el tiempo de vida de la sesión es mayor a tiempo de inactividad
        if($vida_session > $inactivo)
        {

        	date_default_timezone_set('America/Mexico_City'); //OBTENER FECHA Y HORA ACTUAL
			$ultimaCon=date('Y-M-D G:i:s');
			
        	$Logout=$conexion->prepare("UPDATE usuarios SET estado='desconectado', time_logout=:ultimaCon WHERE nombre=:nombre_usuario");//ACTUALIZAR ESTADO, FECHA Y HORA 
			$Logout->bindParam(':ultimaCon', $ultimaCon, PDO::PARAM_STR);
			$Logout->bindParam(':nombre_usuario', $nombreUsuario, PDO::PARAM_STR);
			$Logout->execute();
            //Removemos sesión.
            session_unset();
            //Destruimos sesión.
            session_destroy();              
            //Redirigimos pagina.
            header("Location: index.php");

            exit();
        }

} else {
    //Activamos sesion tiempo.
    $_SESSION['tiempo'] = time();
}


?>