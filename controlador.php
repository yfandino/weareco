<?php
require_once "classes/Cliente.php";
require_once "classes/Producto.php";
require_once "classes/Direccion.php";
require_once "classes/CabFactura.php";
require_once "classes/ConexionBD.php";
use classes\Cliente;
session_start();

    $conexion = new ConexionBD();

    if(isset($_POST["accion"])) {
        $accion = $_POST["accion"];
    } else {
        $accion = $_GET["accion"];
    }

	if ($accion == 'login') {
        $login = $conexion->loginUser($_POST["username"], $_POST["password"]);
        header("Location: index.php");
    }

	if ($accion == 'register') {
        // Procesar datos del formulario
        $conexion = new ConexionBD();
        $cliente = new Cliente(trim($_POST["username"]));
        $cliente->setPassword(password_hash(trim($_POST["password"]), PASSWORD_DEFAULT));
        $registrado = $conexion->registerUser($cliente);
        // Verificar que se ha registrado el usuario correctamente
        if ($registrado) {
            $login = $conexion->loginUser($_POST["username"], $_POST["password"]);
        }
        header('Location: index.php');
        $conexion->close_conn();
    }

	// Borrar el carrito de compra.
	if ($accion == 'cancel') {
		unset($_SESSION["carrito"]);
		header("Location: productos.php");
	}
	
	// Cerrar sesión.
	if ($accion == 'logout') {
		unset($_SESSION["carrito"]);
		unset($_SESSION["cliente"]);
		$conexion->close_conn();
		header("Location: index.php");
	}
	
	// Actualizar cantidad de un producto del carro - Combinación con AJAX. 
	if ($accion == 'updateCart') {
		$id = $_GET["id"];
		$cant = $_GET["cant"];
		$_SESSION["carrito"][$id]->setCantidad($cant);
	}
	
	// Actualizar la información del usuario.
	if ($accion == 'insertDatos') {
		$nombre = $_GET["nombre"];
		$apellidos = $_GET["apellidos"];
		$email = $_GET["email"];
		$tel = $_GET["tel"];
		$conexion->modificarDatos($_SESSION["cliente"], $nombre,
				                  $apellidos, $email, $tel);
	}
	
	// Añadir direcciones si no se tienen.
	if ($accion == "insertDir") {
		$direccion = $_GET["direccion"];
		$ciudad = $_GET["ciudad"];
		$cp = $_GET["cp"];
		$esDeEnvio = $_GET["esDeEnvio"];
		$conexion->insertarDireccion($_SESSION["cliente"], $direccion, $ciudad, $cp, $esDeEnvio);		
	}
	
	// Modificar direcciones.
	if ($accion == "updateDir") {
		$direccion = $_GET["direccion"];
		$ciudad = $_GET["ciudad"];
		$cp = $_GET["cp"];
		$id = $_GET["id"];
		$tipo = $_GET["tipo"];
		$conexion->modificarDir($id, $direccion, $ciudad, $cp, $tipo);
	}
	
	// Al tramitar la compra se vuelcan los productos del carrito al resumen de la compra.
	if ($accion == "tramitarCompra") {
		$datosCompletos = $conexion->verifyDataUser($_SESSION["cliente"]);
		$dirCorrecta = $conexion->verificarDir($_SESSION["cliente"]);
		
		if ($datosCompletos && $dirCorrecta && isset($_SESSION["carrito"])) {
			$idFactura = $conexion->generarCompra($_SESSION["cliente"]);
			if ($idFactura) {
				header("Location: resumen.php?id=$idFactura");
				unset($_SESSION["carrito"]);
			} else {
				echo "El producto seleccionado no está disponible";
			}
		} elseif (!$datosCompletos) {
			echo "Debe rellenar sus datos.";
		} elseif (!$dirCorrecta) {
			echo "Debe tener una dirección de envío y una dirección de facturación.";
		}
	}	
?>