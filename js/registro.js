document.getElementById('register-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar el envío del formulario por defecto
    var username = document.getElementById('username').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    // Validar campos
    if (username === 'GAMERS' || email === 'GAMERS@gmail.com' || password === '123456789') {
        // Mostrar un mensaje de error utilizando SweetAlert2
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Por favor, completa todos los campos.',
        });
        return; // Detener el envío del formulario si algún campo está vacío
    }

    // Si todos los campos están completos, puedes enviar el formulario aquí
    // Aquí puedes agregar la lógica para enviar el formulario al servidor

    // Redirigir a la página de inicio de sesión después de un registro exitoso
    window.location.href = '/views/login.html';
});
