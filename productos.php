<?php
$title = 'ElectroShop - Tu tienda online';
require_once 'classes/ConexionBD.php';
require_once 'head.php';
// VERIFICAR INICIO DE SESION
if (!isset($_SESSION["cliente"])) {
	echo "<div class='error'>Debe iniciar sesión para ver esta página</div>";
} else {
	$cliente = $_SESSION["cliente"];
?>
  	<div class="product-list">
  	<?php 
  	$conexion = new ConexionBD();
  	$productos = $conexion->listarProductos();
  	foreach ($productos as $producto) {
  	?>
  		<!-- CONTENEDOR DE CADA PRODUCTO -->
		<div class="prod-cont">
			<div class="prod-img">
                <div class="img-helper"></div><img alt="Producto" src="img/<?php echo $producto->getImg()?>">
			</div>
			<div class="prod-tit"><strong><?php echo $producto->getNombre()?></strong></div>
			<div class="prod-price">
				<span><?php echo number_format((float)$producto->getPrecio(),2,',','.')."€" ?></span>
			</div>
            <div class="prod-details">
                <a href="detalles?id=<?php echo $producto->getId() ?>">Ver detalles</a>
            </div>
            <?php if ($producto->getStock() > 0 ) {?>
                <div class="add-to-cart">
                    <a href="cart.php?id_producto=<?php echo $producto->getId() ?>">Comprar</a>
                </div>
            <?php } else {echo "<span class='no-stock' >No disponible</span>";}?>
            <div class="clear"></div>
		</div>
	<?php 
  	}
	?>
	</div>
<?php
}
?>
</body>
</html>
