<?php
require_once 'classes/Direccion.php';
require_once 'classes/ConexionBD.php';
$title = 'ElectroShop - Direcciones';
require_once 'head.php';

$conexion = new ConexionBD();
$login = (isset($_SESSION["cliente"])) ? $_SESSION["cliente"]: false;
$carrito = (isset($_SESSION["carrito"])) ? $_SESSION["carrito"]:array();

// COMPROBAR INICIO DE SESION
if (!$login) {
	echo "<div class='error'>Debe iniciar sesión para ver esta página</div>";
} else {
	$cliente = $_SESSION["cliente"];
?>
<body>
	<?php require_once 'header.php' ?>
  	<div class="content">
  	<!-- DATOS DEL CLIENTE -->
  		<h2>Datos del cliente</h2>
  		<?php 
  		if ($conexion->verifyDataUser($cliente)) {
  		// SI TIENE LOS DATOS COMPLETOS SE MUESTRAN
  		?>
  			<div class="datos-cont">
  				<span>Nombre: <?php echo $cliente->getNombre() ?></span><br>
  				<span>Apellidos: <?php echo $cliente->getApellidos() ?></span><br>
  				<span>Email: <?php echo $cliente->getEmail() ?></span><br>
  				<span>Teléfono: <?php echo $cliente->getTelefono() ?></span><br>
  				<button id="modificar" class="btn">Modificar</button>
  				
  				<!-- FORMULARIO PARA EDITAR DATOS DEL CLIENTE -->
  				<form class="login-form no-display" action="controlador.php">
	  				<input type="hidden" name="accion" value="insertDatos">
	  				<input class="input" type="text" name="nombre" placeholder="Nombre" required><br>
	  				<input class="input" type="text" name="apellidos" placeholder="apellidos" required><br>
	  				<input class="input" type="text" name="email" placeholder="email" required><br>
	  				<input class="input" type="tel" name="tel" placeholder="Teléfono" required><br>
	  				<button class="btn" type="submit">Aceptar</button>
	  				<button class="btn" type="reset">Reestablecer</button>
  				</form>
  			</div>
  		<?php	
  		} else {
  		// SI NO TIENE LOS DATOS COMPLETOS SE MUESTRA EL FORMULARIO
  		?>
  		<div class="datos-cont">
  			<form class="login-form" action="controlador.php">
  				<input type="hidden" name="accion" value="insertDatos">
  				<input class="input" type="text" name="nombre" placeholder="Nombre" required><br>
  				<input class="input" type="text" name="apellidos" placeholder="apellidos" required><br>
  				<input class="input" type="text" name="email" placeholder="email" required><br>
  				<input class="input" type="tel" name="tel" placeholder="Teléfono" required><br>
  				<button class="btn" type="submit">Aceptar</button>
  				<button class="btn" type="reset">Reestablecer</button>
  			</form>
  		</div>
  		<?php
  		}
  		?>
  		<!-- DIRECCIONES DEL CLIENTE -->
  		<h2>Direcciones</h2>
  		<?php
  		//SE OBTIENE LA LISTA DE DIRECCIONES
  		$listaDirecciones = $conexion->getDirecciones($cliente);
  		if ($listaDirecciones) {
  		// SI TIENE DIRECCIONES GUARDADAS SE MUESTRAN LOS DATOS
  			for ($i = 0; $i < count($listaDirecciones); $i++) {
  				$direccion = $listaDirecciones[$i];
  		?>
  			<div class="direcc-cont">
  				<span>Dirección: <?php echo $direccion->getDireccion() ?></span><br>
  				<span>Ciudad: <?php echo $direccion->getCiudad() ?></span><br>
  				<span>Código Postal: <?php echo $direccion->getCp() ?></span><br>
  				<span style="font-weight: bold; text-transform: uppercase;">Dirección de 
  					<?php 
  					if ($direccion->getTipo() == "env") {
  					  	echo "envío";
  					} else {
  						echo "facturación";
  					} ?></span><br>
  				<button id="<?php echo $direccion->getId()?>" class="btn modificar-dir">Modificar</button>
  			</div>
  		<?php
  			}
  		?>
  		<!-- FORMULARIO PARA EDITAR UNA DIRECCION -->
  		<div class="datos-cont">
  			<form class="login-form no-display-dir" action="controlador.php">
	  			<input type="hidden" name="accion" value="updateDir">
	  			<input type="hidden" name="id" id="id_prod">
  				<input class="input" type="text" name="direccion" placeholder="Ej: Calle Alcalá, 5, 1 A" required><br>
  				<input class="input" type="text" name="ciudad" placeholder="Ciudad" required><br>
  				<input class="input" type="text" name="cp" placeholder="Código Postal" required><br>
  				Tipo: <select class="input" name="tipo">
  					<option class="input" value="fac">Facturación</option>
  					<option class="input" value="env">Envío</option>
  				</select>
  				<button class="btn" type="submit">Aceptar</button>
  				<button class="btn" type="reset">Reestablecer</button>
  			</form>
  		</div>
  		<?php
  		} else {
  		?>
  		<div class="datos-cont">
  		<!-- FORMULARIO PARA INSERTAR UNA NUEVA DIRECCION -->
  			<form class="login-form" action="controlador.php">
  				<input type="hidden" name="accion" value="insertDir">
  				<input class="input" type="text" name="direccion" placeholder="Ej: Calle Alcalá, 5, 1 A" required><br>
  				<input class="input" type="text" name="ciudad" placeholder="Ciudad" required><br>
  				<input class="input" type="text" name="cp" placeholder="Código Postal" required><br>
  				<label><input type="checkbox" name="esDeEnvio" value="1"> Tambíen es mi dirección de envío</label><br>
  				<button class="btn" type="submit">Aceptar</button>
  				<button class="btn" type="reset">Reestablecer</button>
  			</form>
  		</div>
  		<?php 
  		}
  		?>
  		<br>
  		<a class="btn" href="controlador.php?accion=tramitarCompra">Finalizar Compra</a>
  	</div>
</body>
<script>
	// HABILITA FORMULARIO PARA MODIFICAR DATOS DE USUARIO
	$("#modificar").on("click", function() {
		$(".no-display").toggle("medium");
	})
	// HABILITA FORMULARIO PARA MODIFICAR LA DIRECCION SELECCIONADA
	$(".modificar-dir").on("click", function() {
		$(".no-display-dir").toggle("medium");
		$("#id_prod").val($(this).attr("id"));
	})
</script>
</html>	
<?php 
}
?>