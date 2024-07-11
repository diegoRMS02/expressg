document.querySelector(".edit-profile").addEventListener("click", function () {
  // Mostrar el cuadro de diálogo de confirmación
  Swal.fire({
    title: "¿Estás seguro?",
    text: "¡No podrás revertir esto!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      // Mostrar mensaje de éxito
      Swal.fire({
        title: "¡Exitoso!",
        text: "Cerraste sesión",
        icon: "success",
      });
      // Agregar una pequeña pausa antes de redirigir
      setTimeout(function () {
        // Redirigir al usuario a la página de inicio de sesión
        window.location.href = "http://localhost/CLUBGAMERS1/views/login.html";
      }, 1500); // 1500 milisegundos (1.5 segundos) de pausa antes de la redirección
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      // Si el usuario cancela, mostrar mensaje de cancelación
      Swal.fire({
        title: "Cancelado",
        text: "No se cerró sesión :)",
        icon: "error",
      });
    }
  });
});
