<?php
require_once 'classes/CabFactura.php';
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
	$factura = $conexion->obtenerFactura($_GET["id"]);
	?>
<body>
	<?php require_once 'header.php' ?>
  	<div class="content" style="position: relative">
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
  			foreach ($listaDirecciones as $direccion) {
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
        <table class="items">
            <thead>
            <tr>
                <th class="cart-prod">Producto</th>
                <th class="cart-cant">Cant.</th>
                <th class="cart-price">Precio</th>
                <th class="cart-price">Total</th>
            </tr>
            </thead>
		<?php 
		$listaProductos = $conexion->getDetallesFactura($_GET["id"]);
		if ($listaProductos) {
			foreach ($listaProductos as $detalle) {
		?>
				<!-- Producto -->
            <tr class="item">
                <td class="cart-prod">
                    <div class="cart-tit"><?php echo $detalle["nombre"]?></div>
                </td>
                <td class="cart-cant">
                    <?php echo $detalle["cant"] ?>
                </td>
                <td class="cart-price">
                    <div><?php echo number_format($detalle["precio"],2,',','.')."€"?></div>
                </td>
                <td class="cart-price">
                    <div><?php
                        $precio = $detalle["cant"] * $detalle["precio"];
                        echo number_format($precio,2,',','.')."€"
                        ?>
                    </div>
                </td>
            </tr>
		<?php
			}
		?>
		<!-- Total -->
        </table>
        <div class='btn-container'> Total: <?php echo number_format($detalle["total"],2,',','.')."€";?></div>
		<a class="btn btn-print" target="_blank" href="pdf.php?id=<?php echo $_GET["id"]?>">Imprimir</a>
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