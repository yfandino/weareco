<header>
    <div class="logo"><a href="index.php">weareco</a></div>
    <nav class="menu">
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="">Nosotros</a></li>
            <li><a href="productos.php">Productos</a></li>
            <li><a href="">Ofertas</a></li>
            <li><a href="">Contacto</a></li>
        </ul>
    </nav>
    <div class="cart">
        <a href="cart.php">
            <i class="fas fa-shopping-cart"></i>
            <span>Cesta</span>
        </a>
    </div>
    <div class="user-info">
        <?php
            if (isset($_SESSION['cliente'])) {
                echo "Hola, {$_SESSION['cliente']->getUsername()}";
            } else {
                echo "<a href='#' id='show-modal'>Iniciar Sesión</a>";
            }
        ?>
    </div>
    <?php
        if (isset($_SESSION['cliente'])) {
            echo "<div class=\"logout\">
                      <a href=\"controlador.php?accion=logout\">Salir</a>
                  </div>";
        }
    ?>
<!--    <div class="search">-->
<!--        <input placeholder="Buscar">-->
<!--    </div>-->
</header>