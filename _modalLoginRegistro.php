<div class="account-container">
    <div class="modal-container">
        <form action="controlador.php" method="post" class="register-form" name="register" style="display: none;">
            <h2>Crear nueva cuenta</h2>
            <input class="input" type="hidden" name="accion" value="register">
            <input class="input" type="text" name="username" placeholder="Usuario"><br>
            <input class="input" type="text" name="email" placeholder="Correo electrónico"><br>
            <input class="input" type="password" name="password" placeholder="Contraseña"><br>
            <?php
            // Mostrar error en caso de fallar la coincidencia de la contraseña
            if (isset($_SESSION["password_error"]) && $_SESSION["password_error"] == true) {
                echo "<div style='text-align: right'> La contraseña no coincide</div>";
            }
            ?>
            <button class="button" type="submit">Registrar</button>
            <div class="has-account" id="goToLogin">¿Ya tienes una cuenta? Iniciar sesión</div>
        </form>
        <form action="controlador.php" method="post" class="login-form">
            <h2>Iniciar Sesión</h2>
            <input class="input" type="hidden" name="accion" value="login">
            <input class="input" type="text" name="username" placeholder="Usuario"><br>
            <input class="input" type="password" name="password" placeholder="Contraseña"><br>
            <?php
            // Mostrar errores si falla el inicio de sesion
            if (isset($_SESSION["error_login"]) && $_SESSION["error_login"] == 'Error 1') {
                echo "<div>El usuario o contraseña no coincide</div>";
            } elseif (isset($_SESSION["error_login"]) && $_SESSION["error_login"] == 'Error 2') {
                echo "<div>No existe el nombre de usuario</div>";
            }
            $_SESSION["error_login"] = null;
            ?>
            <button class="button">Entrar</button><br>
            <div class="has-account" id="goToRegister">¿No tienes una cuenta? Regístrate</div>
        </form>
        <div class="clear"></div>
        <img src="img/img-form.png" width="50%" height="50%" alt="Sunglasses in sand">
        <i class="fas fa-times exit"></i>
    </div>
</div>
<script>
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
    })
</script>