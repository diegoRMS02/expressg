<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Aquí podrías agregar la lógica para verificar las credenciales del usuario, por ejemplo, consultando una base de datos
    // Esta es solo una demostración simple
    if ($username == "usuario" && $password == "contraseña") {
        echo "<p>Inicio de sesión exitoso. Bienvenido, $username!</p>";
    } else {
        echo "<p>Nombre de usuario o contraseña incorrectos. Inténtalo de nuevo.</p>";
    }
}
?>

  <form id="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-group">
                    <label for="username">Usuario</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Iniciar Sesión</button>
            </form>
            <div class="options">
                <a href="#">¿Perdiste tu contraseña?</a>
                <a href="/views/registro.html">¿No tienes una cuenta?</a>
            </div>
        </div>
    </div>
    <script src="/js/login.js"></script>
</body>

</html>