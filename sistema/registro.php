<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost"; // Cambia esto si es necesario
    $usernameDB = "tu_usuario"; // Usuario de la base de datos
    $passwordDB = "tu_contraseña"; // Contraseña de la base de datos
    $dbname = "nombre_de_tu_base_de_datos"; // Nombre de la base de datos

    $conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash de la contraseña
    $email = htmlspecialchars($_POST['email']);

    $sql = "INSERT INTO usuarios (username, password, email) VALUES ('$username', '$password', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Registro exitoso. ¡Bienvenido, $username!</p>";
    } else {
        echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }

    $conn->close();
}
?>
 <form id="register-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-group">
                    <label for="username">Usuario</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="input-group">
                    <label for="email">Gmail</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <button type="submit">Regístrate</button>
            </form>
            <div class="options">
                <a href="http://localhost/CLUBGAMERS1/views/login.php">¿Tienes una cuenta? Inicia sesión</a>
            </div>
        </div>
    </div>
    <script src="../js/registro.js"></script>
</body>