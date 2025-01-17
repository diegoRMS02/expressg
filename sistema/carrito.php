<?php
require_once('fpdf.php');

class PDF_Invoice extends FPDF {
    // Define the header
    function Header() {
        // Logo
        $this->Image('../img/loggin/logo_1.png', 10, 6, 30);
        // Invoice title
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Boleta', 0, 0, 'C');
        // Line break
        $this->Ln(20);
    }

    // Define the footer
    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Footer text
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }

    // Define the invoice body
    function InvoiceBody($data) {
        // Invoice details
        $this->SetFont('Arial', '', 12);
        $this->Cell(50, 10, 'Customer Name:', 0, 0);
        $this->Cell(0, 10, $data['customer_name'], 0, 1);
        $this->Cell(50, 10, 'Invoice Number:', 0, 0);
        $this->Cell(0, 10, $data['invoice_number'], 0, 1);
        // Line break
        $this->Ln(10);
        // Table header
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(80, 10, 'Item', 1, 0);
        $this->Cell(30, 10, 'Quantity', 1, 0);
        $this->Cell(40, 10, 'Price', 1, 0);
        $this->Cell(40, 10, 'Total', 1, 1);
        // Table body
        $this->SetFont('Arial', '', 12);
        foreach ($data['items'] as $item) {
            $this->Cell(80, 10, $item['name'], 1, 0);
            $this->Cell(30, 10, $item['quantity'], 1, 0);
            $this->Cell(40, 10, '$' . number_format($item['price'], 2), 1, 0);
            $this->Cell(40, 10, '$' . number_format($item['price'] * $item['quantity'], 2), 1, 1);
        }
        // Line break
        $this->Ln(10);
        // Subtotal
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(150, 10, 'Subtotal:', 0, 0, 'R');
        $this->Cell(40, 10, 'S/' . number_format($data['subtotal'], 2), 0, 1);
        // Tax
        $this->Cell(150, 10, 'IGV (18%):', 0, 0, 'R');
        $this->Cell(40, 10, 'S/' . number_format($data['tax'], 2), 0, 1);
        // Total
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(150, 10, 'Total:', 0, 0, 'R');
        $this->Cell(40, 10, 'S/' . number_format($data['total'], 2), 0, 1);
    }
}

// Check if a POST request has been made to generate the invoice
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate_invoice'])) {
    // Receive cart data
    $cartData = json_decode($_POST['cart_data'], true);

    // Create PDF
    $pdf = new PDF_Invoice();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    // Prepare invoice data
    $invoiceData = [
        'customer_name' => 'Cliente', // You should get this from user session
        'invoice_number' => 'INV-' . time(),
        'items' => $cartData['items'],
        'subtotal' => $cartData['subtotal'],
        'tax' => $cartData['subtotal'] * 0.18, // 5% tax
        'total' => $cartData['total'],
    ];

    $pdf->InvoiceBody($invoiceData);

    // Generate a unique name for the PDF file
    $pdfName = 'invoice_' . time() . '.pdf';
    $pdfPath = 'invoices/' . $pdfName;

    // Save the PDF
    $pdf->Output('F', $pdfPath);

    // Return response to client
    echo json_encode([
        'success' => true,
        'pdfUrl' => $pdfPath
    ]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExpressGame</title>
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/carrito.css">
    <link rel="stylesheet" href="../css/footer.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container">
        <header>
            <div class="header-logo">
                <img src="../img/loggin/Logo_1.png" alt="">
            </div>
            <div class="hamburger-menu">
                <svg xmlns="http://www.w3.org/2000/svg" height="40" width="40" viewBox="0 0 448 512">
                    <path fill="#ffffff"
                        d="M0 88C0 74.7 10.7 64 24 64H424c13.3 0 24 10.7 24 24s-10.7 24-24 24H24C10.7 112 0 101.3 0 88zm0 168c0-13.3 10.7-24 24-24H424c13.3 0 24 10.7 24 24s-10.7 24-24 24H24c-13.3 0-24-10.7-24-24zm24 120c-13.3 0-24 10.7-24 24s10.7 24 24 24H424c13.3 0 24-10.7 24-24s-10.7-24-24-24H24z" />
                </svg>
            </div>
            <nav class="header-nav">
                <ul class="header-ul">
                    <li class="header-li"><a href="http://localhost/CLUBGAMERS1/index.html">Inicio</a></li>
                    <li class="header-li"><a href="http://localhost/CLUBGAMERS1/views/subpagina.html">Juegos</a></li>
                    <li class="header-li"><a href="http://localhost/CLUBGAMERS1/views/contacto.html">Contacto</a></li>
                    <li class="header-li"><a href="http://localhost/CLUBGAMERS1/views/login.html">Iniciar Sesión</a></li>
                    <li class="header-li"><a href="http://localhost/CLUBGAMERS1/views/perfil.html">
                            <img src="../img/user.png" alt="Perfil" height="40" width="40">
                        </a> </li>
                    <li class="header-li"> <a href="http://localhost/CLUBGAMERS1/sistema/carrito.php">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" height="40" width="40">
                                <path fill="#fffff"
                                    d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                            </svg>
                        </a></li>
                </ul>
            </nav>
        </header>

        <div class="content">
            <div class="games-list">
                <!-- Game items here -->
                <!-- Example: -->
                <div class="game">
                    <img src="../img/my-hero-ones-justice-2018416121630_1.jpg" alt="Boku no Hero">
                    <div>
                        <h2>Boku no Hero</h2>
                        <p>En este juego de lucha que combinan la fuerza y el poder de los dones del popular</p>
                        <p class="price">$60.00</p>
                        <button
                            onclick="addToCart('Boku no Hero', 60, 1,  '/img/my-hero-ones-justice-2018416121630_1.jpg')">Añadir
                            al carrito</button>
                    </div>
                    <div class="item-quantity">
                        <label for="quantity1">Cantidad</label>
                        <select id="quantity1">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                <div class="game">
                    <img src="../img/1632000483-zombie-army-4-dead-war-ps4.jpg" alt="Zombie Army 4">
                    <div>
                        <h2>Zombie Army 4</h2>
                        <p>Dead War es un videojuego de disparos en tercera persona desarrollado</p>
                        <p class="price">$60.00</p>
                        <button
                            onclick="addToCart('Zombie Army 4', 60, 1, '/img/1632000483-zombie-army-4-dead-war-ps4.jpg')">Añadir
                            al carrito</button>
                    </div>
                    <div class="item-quantity">
                        <label for="quantity2">Cantidad</label>
                        <select id="quantity2">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                <div class="game">
                    <img src="../img/red-dead-redemption11-0311e5e382ee030f1b15285015970553-640-0.jpg"
                        alt="Red Dead Redemption">
                    <div>
                        <h2>Red Dead Redemption 2</h2>
                        <p>Es un videojuego de acción-aventura de mundo abierto en el medio desarrollado por Rockstar
                            San Diego</p>
                        <p class="price">$60.00</p>
                        <button
                            onclick="addToCart('Red Dead Redemption 2', 60, 3, '/img/red-dead-redemption11-0311e5e382ee030f1b15285015970553-640-0.jpg')">Añadir
                            al carrito</button>
                    </div>
                    <div class="item-quantity">
                        <label for="quantity3">Cantidad</label>
                        <select id="quantity3">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                <!-- Add more game items as needed -->
            </div>

            <div class="shopping-cart">
                <h2>Carrito de compras</h2>
                <div id="cart-items">
                    <!-- Cart items will be displayed here -->
                </div>

                <div class="subtotal">Subtotal: $<span id="subtotal">0.00</span></div>
                <div class="total-saved">Total Ahorrado: $<span id="total-saved">0.00</span></div>
                <div class="total">Total a Pagar: $<span id="total">0.00</span></div>

                <div class="payment-method">
                    <h3>Selecciona el Método de Pago</h3>
                    <div>
                        <input type="radio" id="visa" name="payment-method" value="visa">
                        <label for="visa"><img src="../img/visa.png" alt="Visa"></label>

                        <input type="radio" id="mastercard" name="payment-method" value="mastercard">
                        <label for="mastercard"><img src="../img/mastercard-4.svg" alt="MasterCard"></label>

                        <input type="radio" id="paypal" name="payment-method" value="paypal">
                        <label for="paypal"><img src="../img/png-transparent-donation-logo-pinballz-paypal-paypal-icon-blue-donation-logo-thumbnail.png" alt="PayPal"></label>
                    </div>
                </div>
                <button id="buy-button" onclick="procesarCompra()">Comprar</button>
                <div id="message"></div>
            </div>
        </div>

        <footer class="footer">
            <!-- Footer content here -->
            <div class="footer-logo">
                <img src="../img/loggin/Logo_1.png" alt="Express Game">
            </div>
            <div class="footer-links">
                <p>
                    <a href="">Terminos y condiciones</a>

                </p>
                <p>
                    <a href="">Politica de privacidad</a>

                </p>
                <p>
                    <a href="">Nosotros</a>
                <p> Somos una web de Gamers para todo tipo de edades para divertirse y escojer el mejor le paresca y
                    subir
                    de niveles mas informacion........</p>
                </p>
                <p>
                    <a href="/views/contacto.html">Contacto</a>
                </p>

            </div>
            <div class="footer-redes">
               <div class="redes">
                <svg xmlns="http://www.w3.org/2000/svg" height="60" width="60" viewBox="0 0 512 512">
                    <path fill="#007cdb"
                        d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z" />
                </svg>
                <p class="redes001"><a href="https://www.facebook.com/profile.php?id=61560255890755">Facebook</a></p>
                <br>

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="60" width="60">
                    <path fill="#ffffff"
                        d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" />
                </svg>
                <p class="redes001"><a href="https://www.instagram.com/expressgameoficial/">Instagram</a></p><br>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="60" width="60">
                    <path fill="#ffffff"
                        d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                </svg>
                <p class="redes002"><a href="https://x.com/ExpressGame2024">Twitter</a></p>
               </div>

            </div>
        </footer>
    </div>
    <script src="/js/carrito.js"></script>
    <script>
        const hamburgerMenu = document.querySelector('.hamburger-menu');
        const headerUl = document.querySelector('.header-ul');

        hamburgerMenu.addEventListener('click', () => {
            headerUl.classList.toggle('active');
        });

        // Cart functionality
        let cart = [];
        let subtotal = 0;
        let total = 0;

        function addToCart(name, price, quantity, image) {
            // Add item to cart
            cart.push({ name, price, quantity, image });
            updateCartView();
        }


        function updateCartView() {
            // Update cart display
            const cartItems = document.getElementById('cart-items');
            cartItems.innerHTML = '';
            subtotal = 0;
            cart.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.innerHTML = `${item.name} - $${item.price} x ${item.quantity}`;
                cartItems.appendChild(itemElement);
                subtotal += item.price * item.quantity;
            });
            total = subtotal * 1.05; // Adding 5% tax
            document.getElementById('subtotal').textContent = subtotal.toFixed(2);
            document.getElementById('total').textContent = total.toFixed(2);
        }

        function procesarCompra() {
            // Validate purchase
            if (cart.length === 0) {
                Swal.fire({
                    title: 'Carrito vacío',
                    text: 'Añade productos al carrito antes de comprar.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const paymentMethod = document.querySelector('input[name="payment-method"]:checked');
            if (!paymentMethod) {
                Swal.fire({
                    title: 'Método de pago no seleccionado',
                    text: 'Por favor, selecciona un método de pago.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Prepare cart data
            const cartData = {
                items: cart,
                subtotal: subtotal,
                total: total
            };

            // Create a form to send data
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'carrito.php';

            const hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = 'generate_invoice';
            hiddenField.value = '1';
            form.appendChild(hiddenField);

            const cartDataField = document.createElement('input');
            cartDataField.type = 'hidden';
            cartDataField.name = 'cart_data';
            cartDataField.value = JSON.stringify(cartData);
            form.appendChild(cartDataField);

            // Send form asynchronously
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Open PDF in a new window
                    window.open(data.pdfUrl, '_blank');
                    
                    // Clear cart and update view
                    cart = [];
                    updateCartView();
                    
                    // Show success message
                    Swal.fire({
                        title: '¡Compra realizada!',
                        text: 'Se ha generado la factura en PDF.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                } else {
                    // Show error message
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un problema al procesar la compra.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al comunicarse con el servidor.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        }
    </script>
</body>

</html>