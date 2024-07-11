document.addEventListener('DOMContentLoaded', () => {
    const searchBar = document.getElementById('search-bar');
    const gameItems = document.querySelectorAll('.game');
    const noResultsMessage = document.getElementById('no-results-message');
    const featuredImg = document.getElementById('featured-img');
    const featuredTitle = document.getElementById('featured-title');
    const featuredButton = document.getElementById('featured-button');
    const logo = document.querySelector("header .header-logo");

    
    noResultsMessage.style.display = 'none';

    // Agregar evento de entrada al campo de búsqueda
    searchBar.addEventListener('input', () => {
        const searchTerm = searchBar.value.trim().toLowerCase();
        let foundResults = false;

        gameItems.forEach(item => {
            const title = item.querySelector('p').textContent.toLowerCase();
            const matches = title.includes(searchTerm);

            // Mostrar u ocultar juegos según la coincidencia con el término de búsqueda
            item.style.display = matches ? 'block' : 'none';

            if (matches) {
                foundResults = true;
            }
        });

        // Mostrar o ocultar el mensaje de no resultados
        noResultsMessage.style.display = foundResults ? 'none' : 'block';
    });

    gameItems.forEach(item => {
        item.addEventListener('click', () => {
            const title = item.querySelector('p').textContent;
            const price = item.querySelector('button').textContent.split(' - ')[1];
            const img = item.querySelector('img').getAttribute('src');

            featuredImg.src = img;
            featuredTitle.textContent = title;
            featuredButton.textContent = `COMPRAR - ${price}`;
        });
    });

    // Definir la velocidad de desplazamiento
    var scrollSpeed = 1000; // Tiempo en milisegundos (1 segundo en este caso)

    // Obtener el carrusel y las imágenes
    var carousel = document.querySelector('.carousel');
    var images = carousel.querySelectorAll('div');
    // Calcular el ancho total del carrusel
    var carouselWidth = carousel.scrollWidth;

    // Definir la animación de desplazamiento automático
    function startAnimation() {
        carousel.style.animationDuration = `${(carouselWidth / scrollSpeed)}ms`;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const hamburgerMenu = document.querySelector('.hamburger-menu');
        const headerNav = document.querySelector('.header-nav');

        // Abrir y cerrar el menú hamburguesa al hacer clic en el icono
        hamburgerMenu.addEventListener('click', () => {
            headerNav.classList.toggle('open');
        });
    });


    
    startAnimation();

    
});


