document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar el envío del formulario por defecto

    var username = document.getElementById('username').value.trim();
    var password = document.getElementById('password').value.trim();

    // Validar campos
    if (username === '' || password === '') {
        // Mostrar un mensaje de error utilizando SweetAlert2
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Por favor, completa todos los campos.',
        });
        return; // Detener el envío del formulario si algún campo está vacío
    }

    // Simular autenticación
    setTimeout(function() {
        var authenticationSuccessful = (username === 'GAMERS' && password === '123456789');

        if (authenticationSuccessful) {
            window.location.href = '/index.html'; // Redirigir al usuario
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                footer: '<a href="#">Why do I have this issue?</a>'
            });
        }
    }, 1000);
});
