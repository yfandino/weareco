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
        <table class="items">
            <?php
            if (isset($_SESSION["carrito"])) {
            ?>
                <thead>
                <tr>
                    <th></th>
                    <th class="cart-prod">Producto</th>
                    <th class="cart-cant">Cant.</th>
                    <th class="cart-price">Precio</th>
                </tr>
                </thead>
            <?php
            }
            $total = 0;
            // LISTAR PRODUCTOS DEL CARRITO
            foreach ($carrito as $producto) {
            $total += ($producto->getPrecio() * $producto->getCantidad());
            ?>
            <tr class="item">
                <td>
                    <img class="cart-img" width="150px" alt="Producto" src="img/<?php echo $producto->getImg() ?>">
                </td>
                <td class="cart-prod">
                    <div class="cart-tit"><?php echo $producto->getNombre() ?></div>
                </td>
                <td class="cart-cant">
                    <input class="cant" type="number" min="1" id="<?php echo $producto->getId() ?>"
                                max="<?php echo $producto->getStock() // MAXIMO EL STOCK?>"
                                value="<?php echo $producto->getCantidad() ?>">
                </td>
                <td class="cart-price">
                    <div><?php echo number_format((float)$producto->getPrecio(), 2, ',', '.') . "€" ?></div>
                </td>
            </tr>
        <?php
        }
        echo "</table>";
        // SI EXISTEN PRODUCTOS EN EL CARRO MUESTRA PRECIO, SI NO UN MENSAJE
        if (isset($_SESSION["carrito"])) {
            echo "<div class='btn-container' colspan='4'> Total: " . number_format($total, 2, ',', '.') . "€</div>";
            echo "<div colspan='4' class='btn-container'><a href='seldireccion.php' class='btn'>Continuar</a></div>";
        } else {
            echo "<div class='error'>No tiene productos en el carro de compra.</div>";
        }
        ?>
        <div class='btn-container' style="text-align: left">
            <a class="btn btn-negative" href="productos.php">Seguir Comprando</a>
            <a class="btn btn-negative" href="controlador.php?accion=cancel">Cancelar</a>
        </div>
    </div>
    </body>
    <script>
        // AJAX - ACTUALIZAR CANTIDAD DE UN PRODUCTO
        $(".cant").on("change", function () {
            var cant = $(this).val();
            var url = "controlador.php?accion=updateCart&id=" + $(this).attr("id") + "&cant=" + cant;
            $.ajax({
                type: "GET",
                url: url,
            }).done(function (result) {
                location.reload();
            })
        })
    </script>
    </html>
    <?php
}
?>