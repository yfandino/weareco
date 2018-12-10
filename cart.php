<?php
require_once 'classes\ConexionBD.php';
$title = 'ElectroShop - Carrito de compra';
require_once 'head.php';

$conexion = new ConexionBD();
$login = (isset($_SESSION["cliente"])) ? $_SESSION["cliente"]: false;
$carrito = (isset($_SESSION["carrito"])) ? $_SESSION["carrito"]:array();

// VERIFICAR INICIO DE SESION
if (!$login) {
	echo "<div class='error'>Debe iniciar sesión para ver esta página</div>";
} else {
	$cliente = $_SESSION["cliente"];
	// SI SE ESTA AÑADIENDO UN PRODUCTO SE LLAMA A LA FUNCION Y SE RECARGA EL CARRO
	if (isset($_GET["id_producto"]) && $_GET["id_producto"] != NULL) {
		$conexion->addToCart($_GET["id_producto"], $carrito);
		unset($_GET["id_producto"]);
		header("Location: cart.php");
	}
?>

<body>
	<?php require_once 'header.php' ?>
  	<div class="content">
  		<h2>Productos en el carrito</h2>
  		<?php 
  		$total = 0;
  		
  		// LISTAR PRODUCTOS DEL CARRITO
  		for ($i = 0; $i < count($carrito); $i++) {
  			$producto = $carrito[$i];
  			$total += ($producto->getPrecio() * $producto->getCantidad());
  		?>
		<form class="cart-prod" action="seldireccion.php">
			<img class="cart-img" alt="Producto" src="img/<?php echo $producto->getImg()?>">
			<div class="cart-des">
				<div class="cart-tit"><?php echo $producto->getNombre()?></div>
				<div><?php echo $producto->getDescripcion()?></div>
			</div>
			<div class="cart-item">
				<div class="cart-tit">Precio</div>
				<div><?php echo number_format((float)$producto->getPrecio(),2,',','.')."€"?></div>
			</div>
			<div class="cart-item">
				<div class="cart-tit">Cant.</div>
				<div><input class="cant" type="number" min="1" id="<?php echo $i?>"
				            max="<?php echo $producto->getStock() // MAXIMO EL STOCK?>" 
				            value="<?php echo $producto->getCantidad() ?>"></div>
			</div>
  		<?php
  		}
  		// SI EXISTEN PRODUCTOS EN EL CARRO MUESTRA PRECIO, SI NO UN MENSAJE
  		if (isset($_SESSION["carrito"])) {
  			echo "<div> Total: " . number_format($total,2,',','.')."€</div>";
  		} else {
  			echo "<div>No tiene productos en el carro de compra.</div>";
  		}
  		?>
  		<button class="button">Continuar</button>
  		<a class="button" href="productos.php">Seguir Comprando</a>
  		<a class="button" href="controlador.php?accion=cancel">Cancelar</a>
  		</form>
	</div>
</body>
<script>
	// AJAX - ACTUALIZAR CANTIDAD DE UN PRODUCTO
	$(".cant").on("change", function() {
		var cant = $(this).val();
		var url = "controlador.php?accion=updateCart&id="+ $(this).attr("id")+"&cant="+cant;
		$.ajax({
			type: "GET",
			url: url,
		}).done(function(result) {
			location.reload();
		})
	})
</script>
</html>
<?php
}
?>