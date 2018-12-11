<?php
$title = 'ElectroShop - Tu tienda online';
require_once 'classes/ConexionBD.php';
require_once 'head.php';
?>
  	<div class="details">
  	<?php
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    if (!$id) die("<div class='error'>No hay nada que mostrar</div>");
  	$conexion = new ConexionBD();
  	$producto = $conexion->getProductById($id);
	?>
        <div class="details-img left">
            <img src="img/<?php echo $producto->getImg() ?>">
        </div>
        <div class="details-info right">
            <h2><?php echo $producto->getNombre() ?></h2>
            <div class="prod-price"><?php echo number_format((float)$producto->getPrecio(), 2, ',', '.') . "€"  ?></div>
            <p><?php echo $producto->getDescripcion() ?></p>
            <input id="qty" class="cant" type="number" min="1"
                   max="<?php echo $producto->getStock()?>"
                   value="1">
            <?php if ($producto->getStock() > 0 ) {?>
                <a class="btn btn-negative" href="#" id="add">Comprar</a>
            <?php } else {echo "<span class='no-stock' >No disponible</span>";}?>
        </div>
        <div class="clear"></div>
	</div>
</body>
<script>
    $('#add').on('click', function() {
        $(this).attr('href', 'cart.php?id_producto=<?php echo $producto->getId() ?>&qty='+$('#qty').val());
    })
</script>
</html>
