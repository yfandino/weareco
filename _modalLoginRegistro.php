<div class="account-container">
    <div class="modal-container">
        <form action="controlador.php" method="post" class="register-form" name="register" style="display: none;">
            <h2>Crear nueva cuenta</h2>
            <input class="input" type="hidden" name="accion" value="register">
            <input class="input" type="text" name="username" placeholder="Usuario" required><br>
            <input class="input" type="text" name="email" placeholder="Correo electrónico" required><br>
            <input class="input" type="password" name="password" placeholder="Contraseña" required><br>
            <?php
            // Mostrar error
            if (isset($_SESSION["error-reg"])) {
                echo "<div style='text-align: right'>{$_SESSION["error-reg"]}</div>";
            }
            ?>
            <button class="btn" type="submit">Registrar</button>
            <div class="has-account" id="goToLogin">¿Ya tienes una cuenta? Iniciar sesión</div>
        </form>
        <form action="controlador.php" method="post" class="login-form">
            <h2>Iniciar Sesión</h2>
            <input class="input" type="hidden" name="accion" value="login">
            <input class="input" type="text" name="username" placeholder="Usuario" required><br>
            <input class="input" type="password" name="password" placeholder="Contraseña" required><br>
            <?php
            // Mostrar errores si falla el inicio de sesion
            if (isset($_SESSION["error-login"])) {
                echo "<div>{$_SESSION["error-login"]}</div>";
            }
            ?>
            <button class="btn">Entrar</button><br>
            <div class="has-account" id="goToRegister">¿No tienes una cuenta? Regístrate</div>
        </form>
        <div class="clear"></div>
        <img src="img/img-form.png" width="50%" height="50%" alt="Sunglasses in sand">
        <i class="fas fa-times exit"></i>
    </div>
</div>
<script>
    var form;
    $("#goToLogin").on("click", function() {
        $(".login-form").show();
        $(".register-form").hide();
    });$("#goToRegister").on("click", function() {
        $(".login-form").hide();
        $(".register-form").show();
    });
    $(".exit").on("click", function() {
        $(".account-container").hide();
    });
    $("#show-modal").on("click", function() {
        $(".account-container").show();
    });
<?php
    if (isset($_SESSION['error-reg'])) {
        echo "form = 'register-form';";
        unset($_SESSION["error-reg"]);
    }
    if (isset($_SESSION['error-login'])) {
        echo "form = 'login-form';";
        unset($_SESSION["error-login"]);
    }
?>
    if (form) {
        $('.account-container').show();
        $('[class$="form"]').hide();
        $('.'+form).show();
    }
</script>