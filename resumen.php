<?php
require_once 'classes/CabFactura.php';
require_once 'classes/Direccion/.php';
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
	$factura = $conexion->obtenerFactura($_GET["id"]);
	?>
<body>
	<?php require_once 'header.php' ?>
  	<div class="content">
  	<h2>Resúmen de la compra</h2>
  	<!-- DETALLES DEL CLIENTE -->
	  	<div class="direcc-cont">
	  		<span>Nro. Factura: <?php echo $factura->getId() ?></span><br>
	  		<span>Nombre: <?php echo $cliente->getNombre() ?></span><br>
	  		<span>Apellidos: <?php echo $cliente->getApellidos() ?></span><br>
	  		<span>DNI: <?php echo $cliente->getDni() ?></span><br>
	  	</div>
	  	<?php
	  	$listaDirecciones = $conexion->getDirecciones($cliente);
  		if ($listaDirecciones) {
  			for ($i = 0; $i < count($listaDirecciones); $i++) {
  				$direccion = $listaDirecciones[$i];
  		?>
  			<!-- DIRECCIONES DEL CLIENTE -->
  			<div class="direcc-cont">
  				<span style="font-weight: bold; text-transform: uppercase;">Dirección de 
  					<?php 
  					if ($direccion->getTipo() == "env") {
  					  	echo "envío";
  					} else {
  						echo "facturación";
  					} ?></span><br>
  				<span>Dirección: <?php echo $direccion->getDireccion() ?></span><br>
  				<span>Ciudad: <?php echo $direccion->getCiudad() ?></span><br>
  				<span>Código Postal: <?php echo $direccion->getCp() ?></span><br>
  			</div>
		<?php 
  			}
  		}
		?>
		<h2>Detalles de la compra</h2>
		<?php 
		$listaProductos = $conexion->getDetallesFactura($_GET["id"]);
		if ($listaProductos) {
			foreach ($listaProductos as $detalle) {
		?>
				<!-- Producto -->
				<div class="cart-prod">
					<div class="cart-des">
						<div class="cart-tit"><?php echo $detalle["nombre"]?></div>
						<div><?php //echo ?></div>
					</div>
					<div class="cart-item">
						<div class="cart-tit">Cant.</div>
						<div><?php echo $detalle["cant"] ?></div>
					</div>
					<div class="cart-item">
						<div class="cart-tit">Precio Und.</div>
						<div><?php echo number_format($detalle["precio"],2,',','.')."€"?></div>
					</div>
					<div class="cart-item">
						<div class="cart-tit">Precio</div>
						<div><?php 
							        $precio = $detalle["cant"] * $detalle["precio"];
							        echo number_format($precio,2,',','.')."€"
							 ?>
						</div>
					</div>
				</div>
		<?php
			}
		?>
		<!-- Total -->
		<div class="cart-item" style="position: absolute; right: 30px">
			<div class="cart-tit">Total</div>
			<div><?php echo number_format($detalle["total"],2,',','.')."€";?></div>
		</div>
		<a class="btn" target="_blank" style="position: absolute; right: 30px; top: 30px" href="pdf.php?id=<?php echo $_GET["id"]?>">Imprimir</a>
		<?php 
		} else {
			echo "Ops... Ha ocurrido un problema.";
		}
		?>
  	</div>
</body>
</html>	
<?php 
}
?>