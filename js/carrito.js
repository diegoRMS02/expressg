let carrito = [];
let subtotal = 0;

function addToCart(nombre, precio, cantidad, imagen) {
  const cantidadSeleccionada = parseInt(
    document.getElementById("quantity1").value
  );

  if (cantidadSeleccionada > 0) {
    const item = {
      nombre: nombre,
      precio: precio,
      cantidad: cantidadSeleccionada,
      imagen: imagen,
    };
    carrito.push(item);
    actualizarCarrito();
  } else {
    Swal.fire({
      title: "Atención",
      text: "Selecciona una cantidad para añadir al carrito.",
      icon: "warning",
      confirmButtonText: "OK",
    });
  }
}

function removeFromCart(index) {
  carrito.splice(index, 1);
  actualizarCarrito();
}

function actualizarCarrito() {
  let html = "";
  subtotal = 0;

  carrito.forEach((item, index) => {
    subtotal += item.precio * item.cantidad;

    html += `
            <div class="cart-item">
                <img src="${item.imagen}" alt="${item.nombre}">
                <div>
                    <h3>${item.nombre}</h3>
                    <p>Precio unitario: $${item.precio}</p>
                    <p>Cantidad: ${item.cantidad}</p>
                    <button onclick="removeFromCart(${index})">Eliminar</button>
                </div>
            </div>
        `;
  });

  document.getElementById("cart-items").innerHTML = html;
  document.getElementById("subtotal").textContent = subtotal.toFixed(2);
  document.getElementById("total-saved").textContent = (subtotal * 0.1).toFixed(
    2
  );
  document.getElementById("total").textContent = (subtotal * 0.9).toFixed(2);

  if (carrito.length === 0) {
    document.getElementById("buy-button").disabled = true;
  } else {
    document.getElementById("buy-button").disabled = false;
  }
}

// function procesarCompra() {
//   if (carrito.length === 0) {
//     Swal.fire({
//       title: "Carrito vacío",
//       text: "Añade productos al carrito antes de comprar.",
//       icon: "warning",
//       confirmButtonText: "OK",
//     });
//     return;
//   }

//   Swal.fire({
//     title: "Información de Pago",
//     html:
//       '<input id="cardNumber" class="swal2-input" placeholder="Número de tarjeta">' +
//       '<input id="cardHolder" class="swal2-input" placeholder="Titular de la tarjeta">' +
//       '<input id="expiryDate" class="swal2-input" placeholder="Fecha de expiración (MM/AA)">' +
//       '<input id="cvv" class="swal2-input" placeholder="CVV">',
//     focusConfirm: false,
//     preConfirm: () => {
//       return {
//         cardNumber: document.getElementById("cardNumber").value,
//         cardHolder: document.getElementById("cardHolder").value,
//         expiryDate: document.getElementById("expiryDate").value,
//         cvv: document.getElementById("cvv").value,
//       };
//     },
//   }).then((result) => {
//     if (result.isConfirmed) {
//       // Aquí procesaríamos el pago y generaríamos la factura
//       const cartData = {
//         items: carrito,
//         subtotal: subtotal,
//         total: subtotal * 0.9, // Aplicando el 10% de descuento
//       };

//       // Crear un formulario para enviar los datos
//       const form = document.createElement("form");
//       form.method = "POST";
//       form.action = "carrito.php";

//       const hiddenField = document.createElement("input");
//       hiddenField.type = "hidden";
//       hiddenField.name = "generate_invoice";
//       hiddenField.value = "1";
//       form.appendChild(hiddenField);

//       const cartDataField = document.createElement("input");
//       cartDataField.type = "hidden";
//       cartDataField.name = "cart_data";
//       cartDataField.value = JSON.stringify(cartData);
//       form.appendChild(cartDataField);

//       // Enviar formulario de manera asíncrona
//       fetch(form.action, {
//         method: "POST",
//         body: new FormData(form),
//       })
//         .then((response) => response.json())
//         .then((data) => {
//           if (data.success) {
//             // Abrir PDF en una nueva ventana
//             window.open(data.pdfUrl, "_blank");

//             // Limpiar el carrito y actualizar la vista
//             carrito = [];
//             actualizarCarrito();

//             // Mostrar mensaje de éxito
//             Swal.fire({
//               title: "¡Compra realizada!",
//               text: "Se ha generado la factura en PDF.",
//               icon: "success",
//               confirmButtonText: "OK",
//             });
//           } else {
//             // Mostrar mensaje de error
//             Swal.fire({
//               title: "Error",
//               text: "Hubo un problema al procesar la compra.",
//               icon: "error",
//               confirmButtonText: "OK",
//             });
//           }
//         })
//         .catch((error) => {
//           console.error("Error:", error);
//           Swal.fire({
//             title: "Error",
//             text: "Hubo un problema al comunicarse con el servidor.",
//             icon: "error",
//             confirmButtonText: "OK",
//           });
//         });
//     }
//   });
// }
function procesarCompra() {
  // Validate purchase
  if (carrito.length === 0) {
    Swal.fire({
      title: "Carrito vacío",
      text: "Añade productos al carrito antes de comprar.",
      icon: "warning",
      confirmButtonText: "OK",
    });
    return;
  }

  const paymentMethod = document.querySelector(
    'input[name="payment-method"]:checked'
  );
  if (!paymentMethod) {
    Swal.fire({
      title: "Método de pago no seleccionado",
      text: "Por favor, selecciona un método de pago.",
      icon: "warning",
      confirmButtonText: "OK",
    });
    return;
  }

  // Prepare cart data
  const cartData = {
    items: carrito,
    subtotal: subtotal,
    total: total,
  };

  // Create a form to send data
  const form = document.createElement("form");
  form.method = "POST";
  form.action = "carrito.php";

  const hiddenField = document.createElement("input");
  hiddenField.type = "hidden";
  hiddenField.name = "generate_invoice";
  hiddenField.value = "1";
  form.appendChild(hiddenField);

  const cartDataField = document.createElement("input");
  cartDataField.type = "hidden";
  cartDataField.name = "cart_data";
  cartDataField.value = JSON.stringify(cartData);
  form.appendChild(cartDataField);

  // Send form asynchronously
  fetch(form.action, {
    method: "POST",
    body: new FormData(form),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Open PDF in a new window
        window.open(data.pdfUrl, "_blank");

        // Clear cart and update view
        carrito = [];
        updateCartView();

        // Show success message
        Swal.fire({
          title: "¡Compra realizada!",
          text: "Se ha generado la factura en PDF.",
          icon: "success",
          confirmButtonText: "OK",
        });
      } else {
        // Show error message
        Swal.fire({
          title: "Error",
          text: "Hubo un problema al procesar la compra.",
          icon: "error",
          confirmButtonText: "OK",
        });
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      Swal.fire({
        title: "Error",
        text: "Hubo un problema al comunicarse con el servidor.",
        icon: "error",
        confirmButtonText: "OK",
      });
    });
}
// Inicializar el carrito
// actualizarCarrito();
