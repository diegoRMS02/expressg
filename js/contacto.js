document.querySelector('.contact-form form').addEventListener('submit', function(event) {
    event.preventDefault(); // Previene el envío del formulario por defecto

    Swal.fire({
        title: "¿Quieres contactarnos?",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Guardar",
        denyButtonText: `No`
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire("¡Enviado!", "", "Enhorabuena");
        } else if (result.isDenied) {
            Swal.fire("Los cambios no se guardáron", "", "info");
        }
    });
});


document.querySelector('.hero-section button').addEventListener('click', function() {
    document.querySelector('.contact-section').scrollIntoView({ behavior: 'smooth' });
});
