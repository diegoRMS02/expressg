<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: /views/login.php');
    exit();
}

// Conexión a la base de datos
$servername = "localhost"; // Cambia esto si es necesario
$usernameDB = "admin"; // Usuario de la base de datos
$passwordDB = "Hola123"; // Contraseña de la base de datos
$dbname = "sistema"; // Nombre de la base de datos

$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del usuario
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>