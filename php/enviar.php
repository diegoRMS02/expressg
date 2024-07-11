<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    #PASO #1 Declaramos variables
    $nombre = $_POST['nombre'];
    $email = $_POST['correo'];
    $mensaje = $_POST['mensaje'];

    #PASO #2: INDICAMOS EL DESTINATARIO
    $destinatario = 'ExpressGame-business@gmail.com';
    #PASO #3: INDICAMOS EL ASUNTO
    $asunto = 'MENSAJE DESDE MI WEB';
    #PASO #4: INDICAMOS EL CUERPO DEL MENSAJE
    $cuerpo = "Nombre: $nombre \n Correo:$email  \n Mensaje: $mensaje";

    #PASO #5: ENVIAMOS EL MENSAJE AL SERVIDOR DE CORREO
    if (mail($destinatario, $asunto, $cuerpo)) {
        echo 'Mensaje enviado';
    }else {
        echo 'Error al enviar el mensaje 😥';
    }
    echo '<script>alert("Registro exitoso. ¡Gracias por registrarte!"); window.location.href = "registro.html";</script>';

    header("Location: ../views/registro.html");
    exit;


}
?>