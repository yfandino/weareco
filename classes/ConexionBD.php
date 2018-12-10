<?php
use classes\Cliente;
use classes\Producto;
use classes\Direccion;
use classes\CabFactura;
class ConexionBD {
    public $conexion;
    private $host = 'localhost';
    private $user = 'weareco';
    private $pass = 'admin123';
    private $bbdd = 'weareco';
    
    // CONSTRUCTOR
    public function __construct(){
        $this->conexion = $this->connect();
    }
    
    // Funcion para conectar a la base de datos
    private function connect() {
        try {
            $conn = @mysqli_connect($this->host, $this->user, $this->pass, $this->bbdd);
            if (mysqli_connect_errno() != 0) {
                throw new Exception;
            }
            return $conn;
        } catch(Exception $e) {
            echo "<div class='error'>En este momento no podemos procesar su solicitud. Inténtelo más tarde.</div>";
            die();
        }
    }
    
    // Funcion para cerrar la conexion a la base de datos
    public function close_conn() {
    	try {
    		$closeBD = @mysqli_close($this->conexion);
    		
    		if ($closeBD == false) {
    			throw new Exception;
    		}
    	} catch (Exception $e) {
    		echo "<div class='error'>Error al procesar su solicitud. Contacte al Administrador del sitio.</div>";
    	}
    }
    
    // Metodo que hace el registro inicial de un cliente en la base de datos.
    public function registerUser(Cliente $cliente) {
    	$query = "INSERT INTO clientes (username, password)
                  VALUES ('{$cliente->getUsername()}','{$cliente->getPassword()}');";
    	try {
    		$resultado = @mysqli_query($this->conexion, $query);
    		if (!$resultado) {
    			throw new Exception;
    		}
    		return true;
    	} catch (Exception $e) {
    		if (mysqli_errno($this->conexion) == 1062) {
    			echo "<div class='error'>El nombre de usuario ya existe</div>";
    		} else {
    			echo "<div class='error'>En este momento no podemos procesar su solicitud.</div>";
    		}
    		return false;
    	}
    }
    
    // Metodo para obtener la informacion del usuario - Login
    public function loginUser($username, $password) {
    	$query = "SELECT * FROM clientes
                  WHERE username = '$username';";
    	try {
    		$resultado = mysqli_query($this->conexion, $query);
    		$fila = mysqli_fetch_assoc($resultado);
    		if (mysqli_num_rows($resultado)) {
    			if (password_verify($password, $fila["password"])) {
    				$cliente = new Cliente($username);
    				$cliente->setId($fila["id_cliente"]);
    				$_SESSION["cliente"] = $cliente;
    				return true;
    			} else {
    				throw new Exception("Error 1");
    			}
    		} else {
    			throw new Exception("Error 2");
    		}
    	} catch (Exception $e) {
    		echo $e->getMessage();
    		$_SESSION["error_login"] = $e->getMessage();
    		header('Location: index.php');
    		return false;
    	}
    }
    
    // Metodo que lista todos los productos de la base de datos
    public function listarProductos() {
    	$query = "SELECT * FROM productos;";
    	$listaProd = array();
    	try {
    		$resultado = mysqli_query($this->conexion, $query);
     		if (mysqli_num_rows($resultado) == 0) {
     			throw new Exception();
     		}
    		while ($fila = mysqli_fetch_assoc($resultado)) {
    			$producto = new Producto($fila["id_producto"],$fila["nombre"],
    					                 $fila["descripcion"], $fila["stock"], 
    					                 $fila["precio"], $fila["img"]);
    			array_push($listaProd, $producto);
    		}
    		return $listaProd;
    	} catch (Exception $e) {
    		echo "<div class='error'>Ops.. Parece que ha ocurrido un error.</div>";
    	}
    }
    
    // Metodo para obtener producto por ID y agregarlo al carrito
    public function addToCart($id, $carrito) {
    	$query = "SELECT * FROM productos WHERE id_producto = $id;";
    	try {
    		$resultado = mysqli_query($this->conexion, $query);
    		$fila = mysqli_fetch_assoc($resultado);
    		$producto = $producto = new Producto($fila["id_producto"],$fila["nombre"],
    				                             $fila["descripcion"], $fila["stock"],
    				                             $fila["precio"], $fila["img"]);
    		if (isset($carrito[$producto->getId()])) {
    		    $producto = $carrito[$producto->getId()];
    		    $producto->setCantidad($producto->getCantidad()+1);
            }
    		$carrito[$producto->getId()] = $producto;
    		$_SESSION["carrito"] = $carrito;
    	} catch (Exception $e) {
    		echo "<div class='error'>Ops.. Parece que ha ocurrido un error.</div>";
    	}
    }
    
    // Metodo para verificar si el cliente tiene direcciones y listarlas
    public function getDirecciones(Cliente $cliente) {
    	$query = "SELECT * FROM direcciones
                  WHERE direcc2cliente = {$cliente->getId()}";
    	try {
    		$resultado = mysqli_query($this->conexion, $query);
    		if (mysqli_num_rows($resultado) == 0) {
    			return false;
    		} else {
    			$listaDirecciones = array();
    			while($fila = mysqli_fetch_assoc($resultado)) {
    				$direccion = new Direccion($fila["id_direccion"], $fila["direccion"],
    						                   $fila["ciudad"], $fila["cp"] ,$fila["tipo"],
    						                   $fila["direcc2cliente"]);
    				array_push($listaDirecciones, $direccion);
    			}
    			return $listaDirecciones;
    		}
    	} catch (Exception $e) {
    	}
    }
    
    // Metodo que comprueba que el usuario tiene todos los datos rellenados de su perfil
    public function verifyDataUser(Cliente $cliente) {
    	$query = "SELECT * FROM clientes
				  WHERE id_cliente = {$cliente->getId()}
    			  AND nombre IS NOT NULL
				  AND apellidos IS NOT NULL
				  AND email IS NOT NULL
				  AND telefono IS NOT NULL;";
    	try {
    		$resultado = mysqli_query($this->conexion, $query);
    		if (mysqli_num_rows($resultado) == 0) {
    			return false;
    		} else {
    			$fila = mysqli_fetch_assoc($resultado);
    			$cliente->setNombre($fila["nombre"]);
    			$cliente->setApellidos($fila["apellidos"]);
    			$cliente->setEmail($fila["email"]);
    			$cliente->setTelefono($fila["telefono"]);
    			$_SESSION["cliente"] = $cliente;
    			return true;
    		}
    	} catch (Exception $e) {
    	}
    }
    
    // Metodo para modificar los datos del cliente
    public function modificarDatos(Cliente $cliente, $nombre,$apellidos,$email,$tel) {
    	$query = "UPDATE clientes
				  SET nombre = '$nombre',
    	              apellidos = '$apellidos',
    	              email = '$email',
    	              telefono = '$tel'
                  WHERE id_cliente = {$cliente->getId()};";
    	try {
    		$resultado = mysqli_query($this->conexion, $query);
    		if (!$resultado) {
    			throw new Exception();
    		} else {
    			header("Location: seldireccion.php");
    		}
    	} catch (Exception $e) {
    		echo "<div class='error'>Ops.. Parece que ha ocurrido un error.</div>";
    		echo $query;
    	}
    }
    
    // Metodo para insertar una nueva dirección de un cliente
    public function insertarDireccion(Cliente $cliente, $direccion, $ciudad, $cp, $esDeEnvio) {
    	$query = "INSERT INTO direcciones (direccion, ciudad, cp, tipo, direcc2cliente)
				  VALUES ('$direccion','$ciudad','$cp','fac','{$cliente->getId()}');";
    	if ($esDeEnvio == "1") {
    		$query .= "INSERT INTO direcciones (direccion, ciudad, cp, tipo, direcc2cliente)
				  VALUES ('$direccion','$ciudad','$cp','env',{$cliente->getId()});";
    	}
    	try {
    		$resultado = mysqli_multi_query($this->conexion, $query);
    		if (!$resultado) {
    			throw new Exception();
    		} else {
    			header("Location: seldireccion.php");
    		}
    	} catch (Exception $e) {
    		echo "<div class='error'>Ops.. Parece que ha ocurrido un error.</div>";
    	}    	
    }
    
    // Metodo para modificar una direccion
    public function modificarDir($id,$direccion,$ciudad,$cp,$tipo) {
    	$query = "UPDATE direcciones
				  SET direccion = '$direccion',
    	              ciudad = '$ciudad',
    	              cp = '$cp',
    	              tipo = '$tipo'
                  WHERE id_direccion = $id;";
    	try {
    		$resultado = mysqli_query($this->conexion, $query);
    		if (!$resultado) {
    			throw new Exception();
    		} else {
    			header("Location: seldireccion.php");
    		}
    	} catch (Exception $e) {
    		echo "<div class='error'>Ops.. Parece que ha ocurrido un error.</div>";
    	}
    }
    
    // Metodo para verificar que un cliente tiene direccion de facturación y envio.
    public function verificarDir(Cliente $cliente) {
    	$query = "SELECT count(1) AS cuenta FROM direcciones
				  WHERE direcc2cliente = {$cliente->getId()}
    	          AND tipo = 'fac'
				  UNION
				  SELECT count(2) AS cuenta FROM direcciones
				  WHERE direcc2cliente = {$cliente->getId()}
    	          AND tipo = 'env';";
    	try {
    		$resultado = mysqli_query($this->conexion, $query);
    		while ($fila = mysqli_fetch_assoc($resultado)) {
    			if ($fila["cuenta"] < 2) {
	    			return true;
	    		} else {
	    			return false;
	    		}
    		}
    	} catch (Exception $e) {
    	}
    }
    
    // Metodo para generar compra - Insertar registro en cab_factura
    public function generarCompra(Cliente $cliente) {
    	$carrito = $_SESSION["carrito"];
    	$total = 0;
    	
	    foreach ($carrito as $producto) {
	    	// Verificar si la cantidad seleccionada está disponible
	    	if ($producto->getStock() > $producto->getCantidad()) {
		    	$total += ($producto->getPrecio()*$producto->getCantidad());
	    	} else {
	    		return false;
	    	}
	    }
	    	
	    	$idFactura = $this->generarCodigo();
		    $query = "INSERT INTO cab_factura (id_factura, fact2cliente, total)
	                  VALUES ($idFactura,{$cliente->getId()}, $total);";
	    	try {
	    		$resultado = mysqli_query($this->conexion, $query);
	    		if (!$resultado) {
	    			throw new Exception();
	    		} else {
	    			$isOk = $this->tramitarCarro($idFactura);
	    			if ($isOk) {
	    				return $idFactura;
	    			} else {
	    				throw new Exception();
	    			}
	    		}
	    	} catch (Exception $e) {
	    		mysqli_rollback($this->conexion);
	    	}
    }
    
    // Metodo que tramita los productos del carro - Inserta a det_factura
    private function tramitarCarro($idFactura) {
    	$carrito = $_SESSION["carrito"];
    	
    	foreach ($carrito as $producto) {
    		$query = "INSERT INTO det_factura (det2fact, det2prod, cant, precio)
                      VALUES ($idFactura,{$producto->getId()},{$producto->getCantidad()},{$producto->getPrecio()});";
    		try {
    			$resultado = mysqli_query($this->conexion, $query);
    			if (!$resultado) {
    				throw new Exception();
    			}
    		} catch (Exception $e) {
    			mysqli_rollback($this->conexion);
    		}
    	}
    	return true;
    }
    
    // Funcion para generar codigo de factura
    private function generarCodigo() {
    	$chars = "1234567890";
    	$cadena = "";
    	for($i = 0; $i < 5; $i++) {
    		$cadena .= substr($chars,rand(0,strlen($chars)),1);
    	}
    	$codigo = (int)$cadena;
    	$resultado = mysqli_query($this->conexion, "SELECT * FROM cab_factura WHERE id_factura = $codigo");
    	if (mysqli_num_rows($resultado) == 0) {
    		return $codigo;
    	} else {
    		$this->generarCodigo();
    	}
    }
    
    // Metodo para obtener una factura por su id
    public function obtenerFactura($id) {
    	$query = "SELECT * FROM cab_factura WHERE id_factura = $id";
    	try {
    		$resultado = mysqli_query($this->conexion, $query);
    		if (!$resultado) {
    			throw new Exception();
    		} else {
    			$fila = mysqli_fetch_assoc($resultado);
    			$factura = new CabFactura($fila["id_factura"],$fila["fact2cliente"],$fila["total"]);
    			return $factura;
    		}
    	} catch (Exception $e) {
    		    		
    	}    	
    }
    
    // Metodo que busca los productos de una factura
    public function getDetallesFactura($id) {
    	$query = "SELECT p.nombre, df.cant, df.precio, cf.total FROM cab_factura cf, det_factura df, productos p
				  WHERE cf.id_factura = df.det2fact
				  AND p.id_producto = df.det2prod
				  AND cf.id_factura = $id";
    	try {
    		$resultado = mysqli_query($this->conexion, $query);
    		if (!$resultado) {
    			throw new Exception();
    		} else {
    			$lista = array();
    			while ($fila = mysqli_fetch_assoc($resultado)) {
    				array_push($lista, $fila);
    			}
    			return $lista;
    		}
    	} catch (Exception $e) {
    		return false;
    	}
    }
}
?>