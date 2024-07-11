<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Aquí podrías agregar la lógica para enviar el correo, por ejemplo usando mail()
    // mail($to, $subject, $message, $headers);

    echo "<p>Gracias, $name. Tu mensaje ha sido enviado.</p>";
}
?>

<form name="formulario" id="formulario" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <label for="name">Nombre del Jugador</label>
    <input type="text" id="name" name="name" required>
    <label for="email">Correo Electrónico del Jugador</label>
    <input type="email" id="email" name="email" required>
    <label for="message">Escríbenos...</label>
    <textarea id="message" name="message" required></textarea>
    <button type="submit">ENTREGA</button>
</form>
